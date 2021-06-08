<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
       return view('user.index');
    }

    public function edit()
    {
       return view('user.edit');
    }

    public function create()
    {
        return view('user.create');
    }
}
