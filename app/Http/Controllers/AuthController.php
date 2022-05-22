<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Lists;
use App\Models\Listname;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {   
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            if($request->path()=='admin/login'){
                return redirect('admin/login')->with('error', "Email and Password do not match");
            }
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        if(Auth::user()->role ==1 && $request->path()=='admin/login'){
            $request->session()->put('user', Auth::user());
            return redirect('admin/dashboard');
        }
        else if(Auth::user()->role !=1 && $request->path()=='admin/login'){
            return redirect('admin/login');
        }
        else{
            return $this->respondWithToken($token);        
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'role' => Auth::user()->role,
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }


    public function register(Request $request, $id = ""){
        $data['success'] = 0;
        if($id == ""){
            $user = new User();
            $duplicate = User::where('email',$request->email)->first();
        }
        else{
            $user = User::find($id);
            $duplicate = User::where('id', '!=', $id)->where('email',$request->email)->first();
        }

        if(!is_null($duplicate)){
            $data['message'] = "Email already exists";
            return response()->json($data);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        if($id == ""){
            $user->password = \Hash::make($request->password);
        }
        $user->role = 2;
        $success = $user->save();

        if($success){
            $data['success'] = 1;
            $data['message'] = "Successfully registered";
        }
        else{
            $data['success'] = 0;
            $data['message'] = "Something went wrong";
        }
        return response()->json($data);
    }

    public function savelist(Request $request){
        $input = $request->all();
        $recipes = array_unique(array_column($input, 'idMeal'));
        Lists::where('user_id', Auth::user()->id)->delete();
        $list = [];
        $i = 0;
        foreach($recipes as $rec){
            $list[$i]['user_id'] = Auth::user()->id;
            $list[$i]['recipe_id'] = $rec;
            $list[$i]['recipe'] = json_encode($input[$i]);
            $i++;
        }
        // return $list;
        $success = Lists::insert($list);

        // $list = new Lists();
        // $list->user_id = Auth::user()->id;
        // $list->recipe_id = 1;
        // $list->recipe = json_encode($input);
        // return json_encode($input);;
        // $success = $list->save();
        
        if($success){
            $data['success'] = 1;
            $data['message'] = "Successfully saved";
        }
        else{
            $data['success'] = 0;
            $data['message'] = "Something went wrong";
        }
        return $data;
    }

    public function getItemByUser(Request $request){
        $data = Lists::select('recipe')->where('user_id', Auth::user()->id)->get();
        return response()->json($data);
    }

    public function createList(Request $request){
        $check = Listname::where('name', $request->name)->where('user_id', Auth::user()->id)->first();
        if(!is_null($check)){
            $data['success'] = 0;
            $data['message'] = "Already Exists";
        }
        else{
            $listname = new Listname();
            $listname->name = $request->name;
            $listname->user_id = Auth::user()->id;

            $success = $listname->save();

            if($success){
                $data['success'] = 1;
                $data['message'] = "Successfully saved";
            }
            else{
                $data['success'] = 0;
                $data['message'] = "Something went wrong";
            }
        }
        
        return $data;
    }

    public function getListNames(Request $request){
        $listnames = Listname::where('user_id', Auth::user()->id)->get();
        return $listnames;
    }

    public function saveItem(Request $request){
        $listnames = $request->checkedlist;
        $recipe = $request->recipe;
        foreach ($listnames as $listname) {
            $check = Lists::where('user_id', Auth::user()->id)->where('list_name', $listname)->where('recipe_id', $recipe['idMeal'])->first();
            if(is_null($check)){
                $list = new Lists();
                $list->list_id = Listname::select('id')->where('name', $listname)->where('user_id', Auth::user()->id)->first()['id'];
                $list->user_id = Auth::user()->id;
                $list->list_name = $listname;
                $list->recipe_id = $recipe['idMeal'];
                $list->recipe = json_encode($request->recipe);
                $list->save();
            }
        }
        $data['success'] = 1;
        $data['message'] = "Successfully saved";
        return $data;
    }

    public function getitembylistbyid(Request $request){
        $data = Lists::where('user_id', Auth::user()->id)->where('list_id', $request->all()[0])->get();
        return $data;
    }

    public function itemDelete(Request $request){
        $success = Lists::where('user_id', Auth::user()->id)->where('id', $request->all()[0])->delete();
        if($success){
            $data['success'] = 1;
            $data['message'] = "Successfully deleted";
        }
        else{
            $data['success'] = 0;
            $data['message'] = "Something went wrong";
        }
        return $data;
    }
}