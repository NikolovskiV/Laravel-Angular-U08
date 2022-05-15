<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\SSP;

class AdminController extends Controller
{
    public function login(Request $request){
        return view('login');
    }
    public function dashboard(Request $request){
        return view('dashboard');
    }
    public function logout(Request $request){
        $request->session()->flush();
        return redirect('admin/login');
    }
    public function addUser(Request $request){
        return view('add_user');
    }
    public function saveUser(Request $request, $id = ""){
        if($id == ""){
            $user = new User();
            $duplicate = User::where('email',$request->email)->first();
        }
        else{
            $user = User::find($id);
            $duplicate = User::where('id', '!=', $id)->where('email',$request->email)->first();
        }

        if(!is_null($duplicate)){
            return redirect()->back()->with('error', "Email already exists")->withInput();
        }

        $user->name = $request->name;
        $user->email = $request->email;
        if($id == ""){
            $user->password =  \Hash::make($request->password);
        }
        $user->role = $request->role;
        $success = $user->save();

        if($success){
            return redirect('admin/user-list')->with('success', "Successfully Saved");
        }
        else{
            return redirect()->back()->with('error', "Couldn't save!")->withInput();
        }
    }

    public function editUser(Request $request, $id){
        $user = User::where('id', $id)->first();
        return view('edit_user')->with('user', $user);
    }

    public function userList(Request $request){
        return view('user_list');
    }


    public function getAllUsers(Request $request){
        $table = 
            "users";

        

        $primaryKey = 'id';
        $columns = array(

            array( 'db' => 'id', 'dt' => 'id' ),

            array( 'db' => 'name', 'dt' => 'name' ),

            array( 'db' => 'email', 'dt' => 'email' ),

            array( 'db' => 'role', 'dt' => 'role' )
        );

        $database = config('database.connections.mysql');

        $sql_details = array(
            'user' => $database['username'],
            'pass' => $database['password'],
            'db'   => $database['database'],
            'host' => $database['host']
        );

        $result =  SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns);

        $start=$_REQUEST['start']+1;

        $idx=0;

        foreach($result['data'] as &$res){

            $res[0]=(string)$start;

            $start++;

            $idx++;

        }
        echo json_encode($result);

    }

    public function deleteUser(Request $request, $id){
        $user = User::where('id',$id)->delete();
        return $user;
    }
}