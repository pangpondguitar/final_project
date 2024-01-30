<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Terms;
use App\Models\Program;
use App\Models\Subject;
use App\Models\Terms_courses;
use App\Models\User;
use App\Models\Users_detail;
use App\Models\Terms_sub_teach;
use App\Models\Terms_sub;

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

    public function get_all_terms()
    {
        $terms = Terms::all();
        return response()->json([
            'terms' => $terms
        ], 200);
    }
    public function get_program($id)
    {
        $program = Program::find($id);
        return response()->json([
            'program' => $program
        ], 200);
    }
    public function get_subject($id, $t_id)
    {

        $terms_course = Terms_courses::where('p_id', $id)->where('t_id', $t_id)->first();
        $get_course = $terms_course->c_id;

        $program = Program::find($id);

        $subject = Subject::where('c_id', $get_course)->get();
        return response()->json([
            'subject' => $subject
        ], 200);
    }

    public function get_all_teachers()
    {
        $users = User::where('user_type', '2')->where('user_status', '1')->with('user_detail')->get();
        return response()->json([
            'teachers' => $users
        ], 200);
    }

    public function add_sub(Request $request)
    {
        // $users = User::where('user_type', '2')->where('user_status', '1')->with('user_detail')->get();
        // return response()->json([
        //     'teachers' => $users
        // ], 200);

        $terms_sub = new Terms_sub();
        $terms_sub->t_id = $request->t_id;
        $terms_sub->s_id = $request->s_id;

        $terms_sub->save();
    }
    public function get_term_sub()
    {
        $term_sub = Terms_sub::all();
        $term_sub = Terms_sub::with('subjects', 's_id')->get();
        $term_sub = Terms_sub::with('subjects')->get();


        return response()->json([
            'term_sub' => $term_sub
        ], 200);
    }
}
