<?php

namespace App\Http\Controllers\UsersPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseSpecControllor extends Controller
{
    public function index2()
    {
        return view('users.course_spec.index');
    }
}
