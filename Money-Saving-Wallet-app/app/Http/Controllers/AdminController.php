<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AdminController extends Controller
{
    //
    public function index()
    {
        # code...
        return view('backend.home');
    }
    public function users()
    {
        # code...
        $users = User::paginate(15);
        
        return view('backend.users')->with('users',$users);
    }
}
