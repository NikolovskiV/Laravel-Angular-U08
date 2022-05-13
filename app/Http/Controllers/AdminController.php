<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function login(Request $request){
        return view('login');
    }
    public function dashboard(Request $request){
        return view('dashboard');
    }
}