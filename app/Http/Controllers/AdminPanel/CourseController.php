<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Course;
use App\Models\Program;
use App\Models\Subject;

class CourseController extends Controller
{
    public function index()
    {
        // $course = Course::find(1);
        // $program = $course->program;

        // $program = Program::find(2);
        // $course = $program->courses;


        $data = Program::all();
        // $programs = DB::table('programs')->get();
        // dd($data[0]->courses);
        return view('admin.course', compact('data'));
    }
    public function all($id)
    {
        // $data = DB::table('programs')
        //     ->select('programs.id', 'programs.p_name', 'courses.c_name')
        //     ->join('courses', 'courses.p_id', '=', 'programs.id')
        //     ->where(['p_id' => $id])
        //     ->get();
        $program = Program::find($id);
        $data = $program->courses;
        $p_name = $program->p_name;
        return view('admin.courseall', compact('data', 'p_name', 'id'));
    }
    public function course_insert(Request $request, $id)
    {

        $user = Course::create([
            'c_name' => $request->name,
            'c_name2' => $request->name2,
            'c_file' => $request->email,
            'p_id' => $id,
        ]);

        return redirect()->back();
    }
    public function detail($id)
    {
        // $data = DB::table('programs')
        //     ->select('programs.id', 'programs.p_name', 'courses.c_name')
        //     ->join('courses', 'courses.p_id', '=', 'programs.id')
        //     ->where(['p_id' => $id])
        //     ->get();

        $subject = Subject::where('c_id', $id)->paginate(10);
        // $data = $program->courses;
        // $p_name = $program->p_name;

        return view('admin.course_detail', compact('id', 'subject'));
    }

    public function subject_insert(Request $request, $id)
    {
        $request->validate(
            [
                's_name' => 'required|max:50',
                's_num' => 'required|max:50',
            ],
            [
                's_num.required' => 'กรุณาป้อนข้อมูล',
                's_name.required' => 'กรุณาป้อนข้อมูล',

            ]
        );
        $subject = new Subject();

        $subject->s_num = $request->s_num;
        $subject->s_name = $request->s_name;
        $subject->s_name2 = $request->s_name;
        $subject->c_id = $id;
        $subject->p_id = 2;
        $subject->save();
        return redirect('admin/course/detail/' . $id)->with('status', 'บันทึกข้อมูลสำเร็จ!');;
        //  return view('admin.course_detail', compact('id'));
    }
    public function subject_edit(Request $request, $id)
    {
        $request->validate([
            's_name' => 'required|max:50',
            's_num' => 'required|max:50',
        ], [
            's_num.required' => 'กรุณาป้อนข้อมูล',
            's_name.required' => 'กรุณาป้อนข้อมูล',
        ]);

        // Use first() instead of get() to get a single model instance
        $subject = Subject::where('s_id', $id)->first();

        if (!$subject) {
            // Handle case where subject is not found
            return redirect()->back()->with('error', 'ไม่พบวิชาที่ต้องการแก้ไข');
        }

        $subject->s_num = $request->s_num;
        $subject->s_name = $request->s_name;
        $subject->save();


        return redirect()->back();
    }
    public function subject_delete($id)
    {

        // Use first() instead of get() to get a single model instance
        $subject = Subject::where('s_id', $id)->first();


        $subject->delete();

        return back()->with('status', 'Some message here');
    }
    public function subject_search(Request $request, $id)
    {
        $keyword = $request->keyword;

        $subject = Subject::where('s_num', 'like', '%' . $keyword . '%')
            ->orWhere('s_name', 'like', '%' . $keyword . '%')
            ->paginate(10);



        return view('admin.course_detail', compact('id', 'subject'));
    }
}
