<?php

namespace App\Http\Controllers\PresidentPanel;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Program;
use App\Models\Subject;
use App\Models\User;
use App\Models\Course_committee;
use Illuminate\Http\Request;

class CourseProgramController extends Controller
{
    public function index()
    {
        return view('president.course.index');
    }
    public function get_program($id)
    {
        $program = Program::find($id);
        $teacher_count = User::with('user_detail')->whereHas('user_detail', function ($query) use ($id) {
            $query->where('p_id', $id);
        })->where('user_type', '2')->count();
        $course = Course::where('p_id', $id)->get();

        return response()->json([
            'program' => $program,
            'course' =>  $course,
            'teacher_count' =>  $teacher_count
        ], 200);
    }
    public function get_single_course($id)
    {

        $course = Course::find($id);
        $subject = Subject::where('c_id', $id)->get();
        $course_committee = Course_committee::with('user.user_detail')->where('c_id', $id)->get();
        return response()->json([
            'course' =>  $course,
            'subject' =>  $subject,
            'course_committee' =>  $course_committee
        ], 200);
    }
}
