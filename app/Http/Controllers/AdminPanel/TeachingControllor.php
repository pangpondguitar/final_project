<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Terms;
use App\Models\Program;

class TeachingControllor extends Controller
{
    public function index()
    {
        return view('admin.teaching');
    }
    public function get_all_programs()
    {
        $programs = Program::all();
        return response()->json([
            'programs' => $programs
        ], 200);
    }
}
