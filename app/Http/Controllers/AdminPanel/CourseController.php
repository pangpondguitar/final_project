<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Course;
use App\Models\Program;
use App\Models\Subject;
use App\Models\Course_committee;
use App\Models\Doc_course;
use App\Models\Topic_learn_results;
use App\Models\User;
use Illuminate\Support\Str;
use PHPUnit\Framework\Constraint\Count;

class CourseController extends Controller
{

    public function index()
    {
        return view('admin.course');
    }




    public function course_Addfile(Request $request, $id)
    {

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $uploadedFile) {
                $randomFileName = uniqid() . '_' . Str::random(10) . '.pdf';
                $filePath = 'uploads/course_doc' . '/' . $randomFileName;

                if (move_uploaded_file($uploadedFile, $filePath)) {
                    $filePaths[] = $filePath;
                    $course = new Doc_course;
                    $course->c_id = $id;
                    $course->dcf_name = $uploadedFile->getClientOriginalName();
                    $course->dcf_file = $randomFileName;
                    $course->save();
                } else {
                    return response()->json(['message' => 'Failed to upload files'], 500);
                }
            }
            return response()->json(['message' => 'Upload successful', 'file_paths' => $filePaths], 200);
        } else {
            return response()->json(['message' => 'No files uploaded'], 400);
        }
    }
    public function get_course_doc($id)
    {
        $course = Doc_course::where('c_id', $id)->get();
        return response()->json([
            'course' => $course
        ], 200);
    }

    public function delete_course_doc($id)
    {
        $course = Doc_course::find($id);
        $filePath = public_path('uploads/course_doc/' . $course->dcf_file);
        unlink($filePath);

        $course->delete();
    }
    public function open_course_doc_file($id)
    {
        $performanceFile = Doc_course::find($id);
        if (!$performanceFile) {
            return response()->json(['error' => 'ไฟล์เอกสารไม่พบ'], 404);
        }

        $filePath = public_path('uploads/course_doc/' . $performanceFile->dcf_file);
        if (!file_exists($filePath)) {
            return response()->json(['error' => 'ไฟล์เอกสารไม่พบ'], 404);
        }
        return response()->stream(
            function () use ($filePath) {
                readfile($filePath);
            },
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $performanceFile->dcf_file . '"',
            ]
        );
    }

    public function get_all_programs()
    {
        $programs = Program::all();
        return response()->json([
            'programs' => $programs
        ], 200);
    }

    public function get_program($id)
    {
        $program = Program::find($id);
        return response()->json([
            'program' => $program
        ], 200);
    }

    public function get_courses($id)
    {
        $program = Program::find($id);
        $courses = $program->courses;

        return response()->json([
            'courses' => $courses
        ], 200);
    }

    public function get_subjects($id)
    {
        $subjects = Subject::where('c_id', $id)->paginate(10);

        return response()->json([
            'subjects' => $subjects
        ], 200);
    }

    public function get_single_course($id)
    {
        $course = Course::find($id);

        return response()->json([
            'course' => $course
        ], 200);
    }
    public function update_course(Request $request, $id)
    {
        $course = Course::find($id);
        $course->c_name = $request->c_name;
        $course->c_name2 = $request->c_name2;
        $course->save();
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
    public function add_course(Request $request)
    {

        $course = new Course();
        $course->c_name = $request->c_name;
        $course->c_name2 = $request->c_name2;
        $course->p_id = $request->id;
        $course->c_file = 'none';

        $course->save();
    }
    public function delete_course($id)
    {
        $course = Course::find($id);
        $course->delete();
    }

    public function detail($id, $menu_type)
    {
        // $data = DB::table('programs')
        //     ->select('programs.id', 'programs.p_name', 'courses.c_name')
        //     ->join('courses', 'courses.p_id', '=', 'programs.id')
        //     ->where(['p_id' => $id])
        //     ->get();

        $subject = Subject::where('c_id', $id)->paginate(10);
        $course = Course::find($id);
        $course_com = Course_committee::where('c_id', $id)->get();



        // $data = $program->courses;
        // $p_name = $program->p_name;
        return view('admin.course_detail', compact('id', 'subject', 'course', 'course_com', 'menu_type'));
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
    public function add_subject(Request $request, $id)
    {
        $subject = new Subject();
        $subject->s_num = $request->s_num;
        $subject->s_name = $request->s_name;
        $subject->s_name2 = $request->s_name2;
        $subject->s_credit = $request->s_credit;
        $subject->doc_type = $request->doc_type;
        $subject->c_id = $id;
        $subject->save();
    }

    public function update_subject(Request $request)
    {
        $subject =  Subject::find($request->s_id);
        $subject->s_num = $request->s_num;
        $subject->s_name = $request->s_name;
        $subject->s_name2 = $request->s_name2;
        $subject->s_credit = $request->s_credit;
        $subject->doc_type = $request->doc_type;
        $subject->save();
    }

    public function edit_doctype(Request $request, $id)
    {
        $subject =  Subject::find($id);

        $subject->doc_type = $request->doc_type;
        $subject->save();
    }
    public function add_topic_result(Request $request, $id)
    {
        $topic = new Topic_learn_results();
        $topic->tlr_title = $request->title;
        $topic->doc_type = $request->doc_type;
        $topic->c_id = $id;
        $topic->save();
    }

    public function topic_result($id, $doc)
    {
        $topic = Topic_learn_results::where('c_id', $id)->where('doc_type', $doc)->get();

        return response()->json([
            'topic' => $topic
        ], 200);
    }
    public function update_topic_result(Request $request, $id)
    {
        $topic = Topic_learn_results::find($id);
        $topic->tlr_title = $request->title;
    }

    public function delete_topic_result($id)
    {
        $topic = Topic_learn_results::find($id);
        $topic->delete();
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


    public function delete_subject($id)
    {

        $subject = Subject::find($id);
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
    public function get_teacher($id)
    {
        $course = Course::find($id);
        $committee = Course_committee::where('c_id', $id)->get();
        $teachers = User::with('user_detail')->whereHas('user_detail', function ($query) use ($course) {
            $query->where('p_id', $course->p_id);
        })->get();

        $teachersWithoutCommittee = User::with('user_detail')
            ->whereHas('user_detail', function ($query) use ($course) {
                $query->where('p_id', $course->p_id);
            })
            ->whereDoesntHave('committee', function ($query) use ($id) {
                $query->where('c_id', $id);
            })
            ->get();



        return response()->json([
            'teachers' => $teachersWithoutCommittee,
            '$committee' => $committee

        ], 200);
    }
    public function add_committee($id, $user_id)
    {
        $committee = new Course_committee();
        $committee->c_id = $id;
        $committee->id = $user_id;
        $committee->save();
    }
    public function get_committee($id)
    {
        $committee = Course_committee::with('user.user_detail')->where('c_id', $id)->get();
        // $committeeData = $committee->map(function ($item) {
        //     return $item->user->user_detail;
        // });
        return response()->json([
            'committee' => $committee
        ], 200);
    }
    public function delete_committee($id)
    {
        $committee = Course_committee::find($id);
        $committee->delete();
    }
}
