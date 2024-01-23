<?php

namespace App\Http\Controllers\AdminPanel;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Contracts\Service\Attribute\Required;

use App\Models\Course;
use App\Models\Program;

class AdminControllor extends Controller
{
    public function index()
    {
        return view('admin.home');
    }
    public function programs()
    {
        $programs = Program::all();
        return view('admin.program', compact('programs'));
    }

    public function program_insert(Request $request)
    {
        $request->validate(
            [
                'p_name' => 'required|max:50',
            ],
            [
                'p_name.required' => 'กรุณาป้อนข้อมูล',

            ]
        );
        // $data = [
        //     'p_name' => $request->p_name,
        //     'p_detail' => $request->p_detail,
        // ];

        $program = new Program();

        $program->p_name = $request->p_name;
        $program->p_detail = $request->p_detail;

        $program->save();
        // DB::table('programs')->insert($data);
        return redirect('admin/programs');
    }
    public function program_edit($id)
    {
        $program = Program::find($id);
        $courses = $program->courses;

        $c_course = Course::find($program->c_id);
        // $program =  DB::table('programs')->where('id', $id)->get();

        return view('admin.program_edit', compact('program', 'courses', 'c_course'));
    }
    public function program_update(Request $request, $id)
    {
        $request->validate([
            'p_name' => 'required|max:50',
        ], [
            'p_name.required' => 'กรุณาป้อนข้อมูล',
        ]);

        // $data = [
        //     'p_name' => $request->p_name,
        //     'p_detail' => $request->p_detail,
        // ];
        // DB::table('programs')->where('id', $id)->update($data);
        $program = Program::find($id);

        $program->p_name = $request->p_name;
        $program->p_detail = $request->p_detail;

        $program->save();
        return redirect('admin/programs/edit/' . $id)->with('status', 'บันทึกข้อมูลสำเร็จ!');;
    }
    public function program_delete($id)
    {
        // DB::table('programs')->where('id', $id)->delete();
        $program = Program::find($id);

        $program->delete();
        return redirect('admin/programs');
    }

    public function program_update_course(Request $request, $id)
    {
        $program = Program::find($id);

        $program->c_id = $request->course;
        $program->save();
        return back()->with('status', 'success');
    }
}
