<?php

namespace App\Http\Controllers\UsersPanel;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Terms;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Users_detail;
use App\Models\Terms_sub;
use App\Models\Terms_sub_teach;
use App\Models\Topic_learn_results;
use App\Models\Learn_results_list;
use App\Models\Learn_results_detail;
use App\Models\Planning_topic;
use App\Models\Planning_week_hour;
use App\Models\Planning_week_list;

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
    public function  get_subject($id)
    {
        $subject = Terms_sub::with(['subjects'])
            ->where('ts_id', $id)->first();
        $subject = $subject->subjects;
        return response()->json([
            'subject' => $subject
        ], 200);
    }
    public function  get_course($id)
    {
        $course = Terms_sub::with(['subjects.courses'])
            ->where('ts_id', $id)->first();
        $course = $course->subjects->courses;
        return response()->json([
            'course' => $course
        ], 200);
    }

    public function get_top_result($id)
    {

        $subject = Terms_sub::with('subjects')->where('ts_id', $id)->first();
        $doc_type = $subject->subjects->first()->doc_type;
        $topic = Terms_sub::where('ts_id', $id)->with([
            'subjects' => function ($query) use ($doc_type) {
                $query->with(['courses' => function ($query) use ($doc_type) {
                    $query->with(['topic_learn_results' => function ($query) use ($doc_type) {
                        $query->where('doc_type', $doc_type);
                    }]);
                }]);
            }
        ])->first();

        $topic = $topic->subjects->first()->courses->topic_learn_results
            ->where('doc_type', $doc_type)
            ->values();

        return response()->json([
            'topic' => $topic
        ], 200);
    }
    public function get_result_list($id)
    {
        $result_list = Learn_results_list::where('ts_id', $id)->get();
        return response()->json([
            'result_list' => $result_list
        ], 200);
    }
    public function add_result_list(Request $request, $id)
    {
        $result_list = new Learn_results_list();
        $result_list->lrl_title = $request->lrl_title;
        $result_list->ts_id = $id;
        $result_list->save();
    }
    public function update_result_list(Request $request)
    {
        $result_list = Learn_results_list::find($request->lrl_id);
        $result_list->lrl_title = $request->lrl_title;
        $result_list->save();
    }
    public function delete_result_list($id)
    {
        $result_list = Learn_results_list::find($id);
        $result_list->delete();
    }


    public function get_result_detail($id, $tlr_id)
    {
        $result_detail = Learn_results_detail::where('ts_id', $id)->where('tlr_id', $tlr_id)->get();
        return response()->json([
            'result_detail' => $result_detail
        ], 200);
    }
    public function add_result_detail(Request $request, $id)
    {
        $result_detail = new Learn_results_detail();
        $result_detail->lrd_title = $request->lrd_title;
        $result_detail->tlr_id = $request->tlr_id;
        $result_detail->lrd_remark = $id;
        $result_detail->ts_id = $id;
        $result_detail->save();
    }
    public function update_result_detail(Request $request)
    {
        $result_detail = Learn_results_detail::find($request->lrd_id);
        $result_detail->lrd_title = $request->lrd_title;
        $result_detail->save();
    }
    public function delete_result_detail($id)
    {
        $result_detail = Learn_results_detail::find($id);
        $result_detail->delete();
    }



    public function get_planweek_hour($id)
    {
        $week = Planning_week_hour::where('ts_id', $id)->paginate(5);
        return response()->json([
            'week' => $week
        ], 200);
    }
    public function add_planweek_hour(Request $request, $id)
    {
        $week = new Planning_week_hour();
        $week->pw_week = $request->pw_week;
        $week->pw_hour = $request->pw_hour;
        $week->ts_id = $id;
        $week->save();
    }
    public function update_planweek_hour(Request $request)
    {
        $week = Planning_week_hour::find($request->pw_id);
        $week->pw_week = $request->pw_week;
        $week->pw_hour = $request->pw_hour;
        $week->save();
    }
    public function delete_planweek_hour($id)
    {
        $week = Planning_week_hour::find($id);
        $week->delete();
    }

    public function get_planning_top($id)
    {
        $topic = Planning_topic::where('doc_type', $id)->get();
        return response()->json([
            'topic' => $topic
        ], 200);
    }
    public function get_single_week($id)
    {
        $single_week = Planning_week_hour::where('pw_id', $id)->first();
        return response()->json([
            'single_week' => $single_week
        ], 200);
    }
}
