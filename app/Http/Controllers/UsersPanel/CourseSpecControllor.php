<?php

namespace App\Http\Controllers\UsersPanel;

use App\Http\Controllers\Controller;
use App\Models\Terms;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Users_detail;
use App\Models\Terms_sub;
use App\Models\Terms_sub_teach;

class CourseSpecControllor extends Controller
{
    public function index()
    {
        return view('users.course_spec.index');
    }
    public function get_all_subject($id, $t_id)
    {
        // $subjects = Terms_sub::with(['terms_sub_teach.users'])
        //     ->where('t_id', $t_id)
        //     ->whereHas('terms_sub_teach.users', function ($query) use ($id) {
        //         $query->where('id', $id);
        //     })
        //     ->get();
        $subjects = Terms_sub::with(['subjects'])
            ->with(['terms_sub_teach'])
            ->with(['terms_sub_teach.users'])
            ->where('t_id', $t_id)
            ->whereHas('terms_sub_teach.users', function ($query) use ($id) {
                $query->where('id', $id);
            })->get();
        return response()->json([
            'subjects' => $subjects
        ], 200);
    }

    public function get_subject_teach($id)
    {
        $subject = Terms_sub::with(['subjects'])->where('ts_id', $id)->get();
        return response()->json([
            'subject' => $subject
        ], 200);
    }

    public function get_teachers($id)
    {
        $teachers = Terms_sub::with(['subjects'])
            ->with(['terms_sub_teach'])
            ->with(['terms_sub_teach.users.user_detail'])
            ->where('ts_id', $id)->get();
        return response()->json([
            'teachers' => $teachers
        ], 200);
    }
}
