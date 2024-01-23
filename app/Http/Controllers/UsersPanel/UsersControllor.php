<?php

namespace App\Http\Controllers\UsersPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsersControllor extends Controller
{
    public function index()
    {
        return view('users.home');
    }
}
