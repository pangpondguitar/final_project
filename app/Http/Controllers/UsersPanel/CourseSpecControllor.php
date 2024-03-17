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
use App\Models\Planning_sum_hour;
use App\Models\Doc_committee;
use App\Models\Measure_list;
use App\Models\Resource;
use App\Models\Prep_plan_topic;
use App\Models\Prep_plan_list;
use App\Models\Measure_prac_topic;
use App\Models\Measure_prac_list;
use App\Models\Adjust_people_topic;
use App\Models\Adjust_people_list;
use App\Models\Adjust_repeat;
use App\Models\Objective;
use App\Models\Subject_description;
use App\Models\Course_committee;
use App\Models\Docfile;
use App\Models\Docfile_status;
use Illuminate\Support\Str;

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
            })->with('docfile.docfile_status')->get();
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
        $doc_type = $subject->subjects->doc_type;
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

    public function get_planning_list($pt_id, $pw_id)
    {
        $plan_list = Planning_week_list::where('pw_id', $pw_id)->where('pt_id', $pt_id)->get();
        return response()->json([
            'plan_list' => $plan_list
        ], 200);
    }
    public function add_planning_list(Request $request, $pt_id, $pw_id)
    {
        $week = new Planning_week_list();
        $week->pwl_title = $request->pwl_title;
        $week->pw_id = $pw_id;
        $week->pt_id = $pt_id;
        $week->save();
    }
    public function update_planning_list(Request $request)
    {
        $week = Planning_week_list::find($request->pwl_id);
        $week->pwl_title = $request->pwl_title;
        $week->save();
    }
    public function delete_planning_list($id)
    {
        $week = Planning_week_list::find($id);
        $week->delete();
    }

    public function get_planning_sum($id)
    {
        $sumhour = Planning_sum_hour::where('ts_id', $id)->first();
        return response()->json([
            'sumhour' => $sumhour
        ], 200);
    }
    public function update_planning_sum(Request $request)
    {

        $sumhour = Planning_sum_hour::find($request->psh_id);
        $sumhour->psh_describe = $request->describe;
        $sumhour->psh_practice = $request->practice;
        $sumhour->psh_self = $request->self;
        $sumhour->save();
    }

    public function add_planning_sum(Request $request, $id)
    {
        $sumhour = new Planning_sum_hour;
        $sumhour->psh_describe = $request->describe;
        $sumhour->psh_practice = $request->practice;
        $sumhour->psh_self = $request->self;
        $sumhour->ts_id = $id;
        $sumhour->save();
    }

    public function get_measure($id)
    {
        $measure = Measure_list::where('ts_id', $id)->get();
        return response()->json([
            'measure' => $measure
        ], 200);
    }
    public function add_measure(Request $request, $id)
    {
        $measure = new Measure_list();
        $measure->ml_title = $request->title;
        $measure->ml_value = $request->value;
        $measure->ts_id = $id;
        $measure->save();
    }
    public function update_measure(Request $request)
    {
        $measure = Measure_list::find($request->id);
        $measure->ml_title = $request->title;
        $measure->ml_value = $request->value;
        $measure->save();
    }
    public function delete_measure($id)
    {
        $measure = Measure_list::find($id);
        $measure->delete();
    }
    public function get_resource($id)
    {
        $resource = Resource::where('ts_id', $id)->first();
        return response()->json([
            'resource' => $resource
        ], 200);
    }
    public function add_resource(Request $request, $id)
    {
        $resource = new Resource();
        $resource->rs_title = $request->editor;
        $resource->ts_id = $id;
        $resource->save();
    }
    public function update_resource(Request $request)
    {
        $resource = Resource::find($request->id);
        $resource->rs_title = $request->editor;
        $resource->save();
    }

    public function get_prepplan_top()
    {
        $topic = Prep_plan_topic::get();
        return response()->json([
            'topic' => $topic
        ], 200);
    }
    public function get_prepplan($id, $ppt_id)
    {
        $prep = Prep_plan_list::where('ts_id', $id)->where('ppt_id', $ppt_id)->get();
        return response()->json([
            'prep' => $prep
        ], 200);
    }
    public function add_prepplan(Request $request, $id)
    {
        $prep = new Prep_plan_list();
        $prep->ppl_title = $request->title;
        $prep->ppt_id = $request->ppt_id;
        $prep->ts_id = $id;
        $prep->save();
    }
    public function update_prepplan(Request $request)
    {
        $prep = Prep_plan_list::find($request->id);
        $prep->ppl_title = $request->title;
        $prep->save();
    }
    public function delete_prepplan($id)
    {
        $prep = Prep_plan_list::find($id);
        $prep->delete();
    }

    public function get_measure_prac_top()
    {
        $topic = Measure_prac_topic::get();
        return response()->json([
            'topic' => $topic
        ], 200);
    }
    public function get_measure_prac($id, $mpt_id)
    {
        $prac = Measure_prac_list::where('ts_id', $id)->where('mpt_id', $mpt_id)->get();
        return response()->json([
            'prac' => $prac
        ], 200);
    }
    public function add_measure_prac(Request $request, $id)
    {
        $prac = new Measure_prac_list();
        $prac->mpl_title = $request->title;
        $prac->mpt_id = $request->mpt_id;
        $prac->ts_id = $id;
        $prac->save();
    }
    public function update_measure_prac(Request $request)
    {
        $prac = Measure_prac_list::find($request->id);
        $prac->mpl_title = $request->title;
        $prac->save();
    }
    public function delete_measure_prac($id)
    {
        $prac = Measure_prac_list::find($id);
        $prac->delete();
    }

    public function get_adjust_people_top()
    {
        $topic = Adjust_people_topic::get();
        return response()->json([
            'topic' => $topic
        ], 200);
    }
    public function get_adjust_people($id, $apt_id)
    {
        $adjust = Adjust_people_list::where('ts_id', $id)->where('apt_id', $apt_id)->get();
        return response()->json([
            'adjust' => $adjust
        ], 200);
    }
    public function add_adjust_people(Request $request, $id)
    {
        $adjust = new Adjust_people_list();
        $adjust->apl_title = $request->title;
        $adjust->apt_id = $request->apt_id;
        $adjust->ts_id = $id;
        $adjust->save();
    }
    public function update_adjust_people(Request $request)
    {
        $adjust = Adjust_people_list::find($request->id);
        $adjust->apl_title = $request->title;
        $adjust->save();
    }
    public function delete_adjust_people($id)
    {
        $adjust = Adjust_people_list::find($id);
        $adjust->delete();
    }

    public function get_adjust_repeat($id)
    {
        $adjust_r = Adjust_repeat::where('ts_id', $id)->get();
        return response()->json([
            'adjust_r' => $adjust_r
        ], 200);
    }
    public function add_adjust_repeat(Request $request, $id)
    {
        $adjust_r = new Adjust_repeat();
        $adjust_r->adr_title = $request->title;
        $adjust_r->ts_id = $id;
        $adjust_r->save();
    }
    public function update_adjust_repeat(Request $request)
    {
        $adjust_r = Adjust_repeat::find($request->id);
        $adjust_r->adr_title = $request->title;
        $adjust_r->save();
    }
    public function delete_adjust_repeat($id)
    {
        $adjust_r = Adjust_repeat::find($id);
        $adjust_r->delete();
    }

    public function get_objective($id)
    {
        $objective = Objective::where('ts_id', $id)->get();
        return response()->json([
            'objective' => $objective
        ], 200);
    }
    public function add_objective(Request $request, $id)
    {
        $objective = new Objective();
        $objective->obj_title = $request->title;
        $objective->ts_id = $id;
        $objective->save();
    }
    public function update_objective(Request $request)
    {
        $objective = Objective::find($request->id);
        $objective->obj_title = $request->title;
        $objective->save();
    }

    public function delete_objective($id)
    {
        $objective = Objective::find($id);
        $objective->delete();
    }

    public function get_subdes($id)
    {
        $subdes = Subject_description::where('ts_id', $id)->first();
        return response()->json([
            'subdes' => $subdes
        ], 200);
    }
    public function add_subdes(Request $request, $id)
    {
        $subdes = new Subject_description();
        $subdes->sd_title = $request->title;
        $subdes->sd_title_eng = $request->title_eng;
        $subdes->ts_id = $id;
        $subdes->save();
    }
    public function update_subdes(Request $request)
    {
        $subdes = Subject_description::find($request->id);
        $subdes->sd_title = $request->title;
        $subdes->sd_title_eng = $request->title_eng;
        $subdes->save();
    }
    public function get_committee($id)
    {

        $term_sub = Terms_sub::with('subjects.courses')->find($id);

        $course = $term_sub->subjects->courses->c_id;
        $doc_committee = Doc_committee::where('ts_id', $id)->get();
        $committee = Course_committee::with('user.user_detail')->where('c_id', $course)->get();
        return response()->json([
            'committee' => $committee,
            'doc_committee' => $doc_committee
        ], 200);
    }
    public function add_committee($id, $user_id)
    {
        $committee = new Doc_committee();
        $committee->id = $user_id;
        $committee->ts_id = $id;
        $committee->save();
    }
    public function delete_committee($id, $user_id)
    {
        $committee = Doc_committee::where('ts_id', $id)->where('id', $user_id)->firstOrFail();
        $committee->delete();
    }

    public function get_doc_file($id)
    {
        $docfile = Docfile::where('ts_id', $id)->get();
        return response()->json([
            'docfile' => $docfile
        ], 200);
    }
    public function get_docfile_finish($id)
    {
        $docfile = Docfile::find($id);

        $filePath = public_path('uploads/file_doc/' . $docfile->df_name);

        return response()->stream(
            function () use ($filePath) {
                readfile($filePath);
            },
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $docfile->df_name . '"',
            ]
        );
    }
    public function delete_docfile($id)
    {
        $docfile = Docfile::find($id);

        if (!$docfile) {
            return response()->json(['message' => 'ไม่พบข้อมูลที่ต้องการลบ'], 404);
        }

        $df_id = $docfile->df_id;

        // ลบข้อมูลใน Docfile_status ที่มี df_id เป็น FK
        Docfile_status::where('df_id', $df_id)->delete();

        // ลบข้อมูลใน Docfile
        $docfile->delete();

        $filePath = public_path('uploads/file_doc/' . $docfile->df_name);
        unlink($filePath);

        return response()->json(['message' => 'ลบข้อมูลเรียบร้อยแล้ว'], 200);
    }
}
