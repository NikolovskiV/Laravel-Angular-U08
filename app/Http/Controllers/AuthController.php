<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Lists;

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
            $i++;
        }
        $success = Lists::insert($list);
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
        $data = Lists::where('user_id', Auth::user()->id)->get();
        return $data;
    }
}