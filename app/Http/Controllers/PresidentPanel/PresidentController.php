<?php

namespace App\Http\Controllers\PresidentPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PresidentController extends Controller
{
    public function index()
    {
        return view('president.home');
    }
}
