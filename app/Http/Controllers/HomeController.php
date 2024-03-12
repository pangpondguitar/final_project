<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::id()) {
            $user_type = Auth()->user()->user_type;

            if ($user_type == '1') {
                return view('admin.home');
            } else if ($user_type == '2') {
                return view('users.home');
            } else if ($user_type == '3') {
                return view('president.home');
            } else if ($user_type == '4') {
                return view('manager.home');
            } else {
                return redirect()->back();
            }
        }
    }
    public function post()
    {
        return view('admin.home');
    }
}
