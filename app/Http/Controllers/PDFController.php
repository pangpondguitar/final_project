<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Adjust_people_topic;
use App\Models\Adjust_repeat;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use iio\libmergepdf\Merger;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

use App\Models\Subject;
use App\Models\Terms;
use App\Models\User;
use App\Models\Users_detail;
use App\Models\Terms_sub;
use App\Models\Terms_sub_teach;
use App\Models\Topic_learn_results;
use App\Models\Learn_results_list;
use App\Models\Learn_results_detail;
use App\Models\Planning_topic;
use App\Models\Planning_week_hour;
use App\Models\Objective_remark;
use App\Models\Planning_week_list;
use App\Models\Planning_sum_hour;
use App\Models\Doc_committee;
use App\Models\Measure_list;
use App\Models\Measure_prac_topic;
use App\Models\Resource;
use App\Models\Objective;
use App\Models\Prep_plan_topic;
use App\Models\Subject_description;
use App\Models\Learn_results_remark;
use App\Models\Docfile;
use App\Models\Docfile_status;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class PDFController extends Controller
{
    public function get_doc_show($id)
    {
        $subject = Terms_sub::with(['subjects.courses.topic_learn_results'])->with(['terms'])->where('ts_id', $id)->first();
        $top_result = Topic_learn_results::where('c_id', $subject->subjects->c_id)->where('doc_type', $subject->subjects->doc_type)->get();
        $result_list_detail = Learn_results_detail::where('ts_id', $id)->get();


        $count_list_detail = Topic_learn_results::select('topic_learn_results.tlr_id', 'tlr_title', DB::raw('count(learn_results_details.tlr_id) as count'))
            ->leftJoin('learn_results_details', 'topic_learn_results.tlr_id', '=', 'learn_results_details.tlr_id')->where('learn_results_details.ts_id', $id)
            ->groupBy('topic_learn_results.tlr_id', 'tlr_title')
            ->get();
        $count_all_details = Learn_results_detail::where('ts_id', $id)->count();
        $count_all_objective = Objective::where('ts_id', $id)->count();
        $count_all_details = mb_convert_encoding($count_all_details, 'HTML-ENTITIES', 'UTF-8');
        $list_result_detail = [];
        $j = 1;

        foreach ($count_list_detail as $item) {
            for ($i = 1; $i <= $item['count']; $i++) {
                $list_result_detail[] = [
                    'num' => $j . '.' . $i,
                    'data' => $item['tlr_title'],
                ];
            }
            $j += 1;
        }

        $num = 1;
        $result_data = [];
        $list_result = Learn_results_list::where('ts_id', $id)->get();

        foreach ($list_result as $item) {
            $result_data[] = [
                'lrl_id' =>  $item['lrl_id'],
                'num' => $num,
                'title' => $item['lrl_title']
            ];
            $num  += 1;
        }



        $result_data_detail =   $this->learn_result_detail($subject, $id);
        $plan_week_top =   $this->get_planning_top($subject);
        $plan_week =   $this->planing_week($id, $subject);
        $sum_plan_week =   $this->get_planning_sum_hours($id);
        $measure_list =   $this->get_measure_list($id);
        $sum_measure_list =   $this->get_sum_measure_list($id);
        $resource =   $this->get_resource($id);
        $subdes =   $this->get_sub_description($id);
        $objective =   $this->get_objective($id);
        $prep_plan =   $this->get_prep_plan($id);
        $measure_prac =   $this->get_measure_prac($id);
        $adjust_people =   $this->get_adjust_people($id);
        $adjust_repeat =   $this->get_adjust_repeat($id);
        $result_remark = $this->get_result_remark($id);
        $objective_num = $this->get_objective_num($objective);
        $learn_result_detail_data = $this->get_learn_result_detail_data($id);
        $objective_remark = $this->objective_remark_check($id);
        $committees = $this->get_committee($id);

        $teachers = $this->get_teachers($id);
        $mark_result = [];

        foreach ($result_data as $result_list) {
            foreach ($learn_result_detail_data as $list_result_details) {
                $remark_check = $this->get_remark_check($result_list['lrl_id'], $list_result_details['lrd_id']);
                if ($remark_check) {
                    $mark_result[] = [
                        'lrl_id' => $result_list['lrl_id'],
                        'lrd_id' => $list_result_details['lrd_id'],
                        'status' => '1'
                    ];
                } else {
                    $mark_result[] = [
                        'lrl_id' => $result_list['lrl_id'],
                        'lrd_id' => $list_result_details['lrd_id'],
                        'status' => '0'
                    ];
                }
            }
        }


        // return response()->json([
        //     'get_teachers' => $committees
        // ], 200);

        $m = new Merger();
        $imagePath = public_path('/assets/img/logo-sru.jpg');
        $imageData = File::get($imagePath);
        $base64Image = base64_encode($imageData);



        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pdf_doc.doctitle', compact('subject', 'base64Image', 'subdes'))->setPaper('a4', 'portrait');
        $m->addRaw($pdf->output());


        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pdf_doc.docresult', compact('count_list_detail', 'count_all_details', 'list_result_detail', 'result_data', 'result_remark', 'learn_result_detail_data', 'mark_result', 'objective_num', 'objective_remark', 'count_all_objective'))->setPaper('a4', 'landscape');
        $m->addRaw($pdf->output());

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pdf_doc.docresult_detail', compact('result_data_detail', 'objective'))->setPaper('a4', 'portrait');
        $m->addRaw($pdf->output());

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pdf_doc.docplan', compact('plan_week', 'plan_week_top', 'sum_plan_week', 'subject'))->setPaper('a4', 'landscape');
        $m->addRaw($pdf->output());
        if ($subject->subjects->doc_type == 2) {
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('pdf_doc.docprep_plan', compact('prep_plan', 'measure_list', 'sum_measure_list', 'measure_prac', 'adjust_people', 'adjust_repeat', 'teachers', 'committees'))->setPaper('a4', 'portrait');
            $m->addRaw($pdf->output());
        }
        if ($subject->subjects->doc_type != 2) {
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('pdf_doc.doclast', compact('measure_list', 'sum_measure_list', 'resource', 'teachers', 'committees'))->setPaper('a4', 'portrait');
            $m->addRaw($pdf->output());
        }

        // file_put_contents('pdf_doc' . '.pdf', $m->merge());


        $mergedPdfContent = $m->merge();
        // $filePath = 'pdf_doc.pdf';

        // $randomFileName = uniqid() . '_' . Str::random(10) . '.pdf';
        // $filePath = 'uploads/file_doc' . '/' . $randomFileName;

        // บันทึกไฟล์ PDF ที่ได้จากการรวม
        // file_put_contents($filePath, $mergedPdfContent);

        // สร้าง Response และให้บริการการดาวน์โหลด
        return Response::stream(
            function () use ($mergedPdfContent) {
                echo $mergedPdfContent;
            },
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="pdf_doc.pdf"',
            ]
        );
    }
    public function export($id, $userId)
    {
        $subject = Terms_sub::with(['subjects.courses.topic_learn_results'])->with(['terms'])->where('ts_id', $id)->first();
        $top_result = Topic_learn_results::where('c_id', $subject->subjects->c_id)->where('doc_type', $subject->subjects->doc_type)->get();
        $result_list_detail = Learn_results_detail::where('ts_id', $id)->get();


        $count_list_detail = Topic_learn_results::select('topic_learn_results.tlr_id', 'tlr_title', DB::raw('count(learn_results_details.tlr_id) as count'))
            ->leftJoin('learn_results_details', 'topic_learn_results.tlr_id', '=', 'learn_results_details.tlr_id')->where('learn_results_details.ts_id', $id)
            ->groupBy('topic_learn_results.tlr_id', 'tlr_title')
            ->get();
        $count_all_details = Learn_results_detail::where('ts_id', $id)->count();
        $count_all_objective = Objective::where('ts_id', $id)->count();
        $count_all_details = mb_convert_encoding($count_all_details, 'HTML-ENTITIES', 'UTF-8');
        $list_result_detail = [];
        $j = 1;

        foreach ($count_list_detail as $item) {
            for ($i = 1; $i <= $item['count']; $i++) {
                $list_result_detail[] = [
                    'num' => $j . '.' . $i,
                    'data' => $item['tlr_title'],
                ];
            }
            $j += 1;
        }

        $num = 1;
        $result_data = [];
        $list_result = Learn_results_list::where('ts_id', $id)->get();

        foreach ($list_result as $item) {
            $result_data[] = [
                'lrl_id' =>  $item['lrl_id'],
                'num' => $num,
                'title' => $item['lrl_title']
            ];
            $num  += 1;
        }



        $result_data_detail =   $this->learn_result_detail($subject, $id);
        $plan_week_top =   $this->get_planning_top($subject);
        $plan_week =   $this->planing_week($id, $subject);
        $sum_plan_week =   $this->get_planning_sum_hours($id);
        $measure_list =   $this->get_measure_list($id);
        $sum_measure_list =   $this->get_sum_measure_list($id);
        $resource =   $this->get_resource($id);
        $subdes =   $this->get_sub_description($id);
        $objective =   $this->get_objective($id);
        $prep_plan =   $this->get_prep_plan($id);
        $measure_prac =   $this->get_measure_prac($id);
        $adjust_people =   $this->get_adjust_people($id);
        $adjust_repeat =   $this->get_adjust_repeat($id);
        $result_remark = $this->get_result_remark($id);
        $objective_num = $this->get_objective_num($objective);
        $learn_result_detail_data = $this->get_learn_result_detail_data($id);
        $objective_remark = $this->objective_remark_check($id);
        $committees = $this->get_committee($id);

        $teachers = $this->get_teachers($id);
        $mark_result = [];

        foreach ($result_data as $result_list) {
            foreach ($learn_result_detail_data as $list_result_details) {
                $remark_check = $this->get_remark_check($result_list['lrl_id'], $list_result_details['lrd_id']);
                if ($remark_check) {
                    $mark_result[] = [
                        'lrl_id' => $result_list['lrl_id'],
                        'lrd_id' => $list_result_details['lrd_id'],
                        'status' => '1'
                    ];
                } else {
                    $mark_result[] = [
                        'lrl_id' => $result_list['lrl_id'],
                        'lrd_id' => $list_result_details['lrd_id'],
                        'status' => '0'
                    ];
                }
            }
        }


        // return response()->json([
        //     'get_teachers' => $committees
        // ], 200);

        $m = new Merger();
        $imagePath = public_path('/assets/img/logo-sru.jpg');
        $imageData = File::get($imagePath);
        $base64Image = base64_encode($imageData);



        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pdf_doc.doctitle', compact('subject', 'base64Image', 'subdes'))->setPaper('a4', 'portrait');
        $m->addRaw($pdf->output());


        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pdf_doc.docresult', compact('count_list_detail', 'count_all_details', 'list_result_detail', 'result_data', 'result_remark', 'learn_result_detail_data', 'mark_result', 'objective_num', 'objective_remark', 'count_all_objective'))->setPaper('a4', 'landscape');
        $m->addRaw($pdf->output());

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pdf_doc.docresult_detail', compact('result_data_detail', 'objective'))->setPaper('a4', 'portrait');
        $m->addRaw($pdf->output());

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pdf_doc.docplan', compact('plan_week', 'plan_week_top', 'sum_plan_week', 'subject'))->setPaper('a4', 'landscape');
        $m->addRaw($pdf->output());
        if ($subject->subjects->doc_type == 2) {
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('pdf_doc.docprep_plan', compact('prep_plan', 'measure_list', 'sum_measure_list', 'measure_prac', 'adjust_people', 'adjust_repeat', 'teachers', 'committees'))->setPaper('a4', 'portrait');
            $m->addRaw($pdf->output());
        }
        if ($subject->subjects->doc_type != 2) {
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('pdf_doc.doclast', compact('measure_list', 'sum_measure_list', 'resource', 'teachers', 'committees'))->setPaper('a4', 'portrait');
            $m->addRaw($pdf->output());
        }

        file_put_contents('pdf_doc' . '.pdf', $m->merge());


        $mergedPdfContent = $m->merge();
        $filePath = 'pdf_doc.pdf';

        $randomFileName = $id . '_' . uniqid() . '_' . Str::random(10) . '.pdf';
        $filePath = 'uploads/file_doc' . '/' . $randomFileName;


        $doc_file = new Docfile();
        $doc_file->df_name = $randomFileName;
        $doc_file->ts_id = $id;
        $doc_file->id = $userId;
        $doc_file->save();

        $lastInsertedId = $doc_file->df_id;

        $doc_st = new Docfile_status();
        $doc_st->df_id = $lastInsertedId;
        $doc_st->dfs_status = 0;
        $doc_st->save();

        file_put_contents($filePath, $mergedPdfContent);

        return redirect()->route('users.subject_detail', $id);
    }
    public  function learn_result_detail($subject, $id)
    {
        $learn_result_detail = Topic_learn_results::where('c_id', $subject->subjects->c_id)
            ->where('doc_type', $subject->subjects->doc_type)
            ->with(['learn_results_detail' => function ($query) use ($id) {
                $query->where('ts_id', $id);
            }])->get();

        $j = 1;
        $result_data_detail = [];

        foreach ($learn_result_detail as $topic) {
            $i = 1;

            $topicData = [
                'topic_num' =>  $j . '.',
                'topic' => $topic['tlr_title'],
                'details' => [],  // Create an array to hold details within the topic
            ];

            foreach ($topic->learn_results_detail as $detail) {
                $topicData['details'][] = [
                    'num' => $j . '.' . $i,
                    'data' => $detail['lrd_title'],
                ];
                $i += 1;
            }

            $result_data_detail[] = $topicData;
            $j += 1;
        }
        return $result_data_detail;
    }
    public  function get_prep_plan($id)
    {
        $prep_plan = Prep_plan_topic::with(['prep_plan_list' => function ($query) use ($id) {
            $query->where('ts_id', $id);
        }])->get();

        $j = 1;
        $result_data_prep = [];

        foreach ($prep_plan as $topic) {
            $i = 1;
            $topicData = [
                'topic_num' =>  $j . '.',
                'topic' => $topic['ppt_title'],
                'title' => [],
            ];

            foreach ($topic->prep_plan_list as $item) {
                $topicData['title'][] = [
                    'num' => $j . '.' . $i,
                    'data' => $item['ppl_title'],
                ];
                $i += 1;
            }

            $result_data_prep[] = $topicData;
            $j += 1;
        }
        return $result_data_prep;
    }
    public  function get_measure_prac($id)
    {
        $measure_prac = Measure_prac_topic::with(['measure_prac_list' => function ($query) use ($id) {
            $query->where('ts_id', $id);
        }])->get();

        $j = 1;
        $result_data_measure_prac = [];

        foreach ($measure_prac as $topic) {
            $i = 2;
            $topicData = [
                'topic_num' =>  $j . '.',
                'topic' => $topic['mpt_title'],
                'title' => [],
            ];

            foreach ($topic->measure_prac_list as $item) {
                $topicData['title'][] = [
                    'num' => $j . '.' . $i,
                    'data' => $item['mpl_title'],
                ];
                $i += 1;
            }

            $result_data_measure_prac[] = $topicData;
            $j += 1;
        }
        return $result_data_measure_prac;
    }
    public  function get_adjust_people($id)
    {
        $adjust_people = Adjust_people_topic::with(['adjust_people_list' => function ($query) use ($id) {
            $query->where('ts_id', $id);
        }])->get();

        $j = 1;
        $i = 1;
        $result_data_adjust_people = [];

        foreach ($adjust_people as $topic) {

            $topicData = [
                'topic_num' =>  $j . '.' . $i,
                'topic' => $topic['apt_title'],
                'title' => [],
            ];

            foreach ($topic->adjust_people_list as $item) {
                $topicData['title'][] = [
                    'num' => $j . '.' . $i,
                    'data' => $item['apl_title'],
                ];
            }
            $i += 1;

            $result_data_adjust_people[] = $topicData;
        }
        return $result_data_adjust_people;
    }
    public  function planing_week($id, $subject)
    {


        $week_hour = Planning_week_hour::where('ts_id', $id)->with('planing_week_list')->get();

        $result_plan_week = [];
        $groupedData = [];

        foreach ($week_hour as $planningWeekHour) {
            $pwId = $planningWeekHour->pw_id;

            // ตรวจสอบว่ามี key ที่ตรงกับ pw_id ใน $groupedData หรือยัง
            if (!array_key_exists($pwId, $groupedData)) {
                $groupedData[$pwId] = [
                    'week' => $planningWeekHour->pw_week,
                    'hour' => $planningWeekHour->pw_hour,
                ];
            }

            // เพิ่มข้อมูลลงใน array ที่มี key เป็น pw_id
            foreach ($planningWeekHour->planing_week_list as $weekList) {
                $ptId = $weekList->pt_id;
                if (!array_key_exists($ptId, $groupedData[$pwId])) {
                    $groupedData[$pwId][$ptId] = [];
                }

                // เพิ่มข้อมูลลงใน array ที่มี key เป็น pw_id และ pt_id
                $groupedData[$pwId][$ptId][] = [
                    'order' => count($groupedData[$pwId][$ptId]) + 1 . '.',
                    'data' => $weekList,
                ];
            }
        }

        return $groupedData;
    }
    public function get_learn_result_detail_data($id)
    {
        $learn_result_detail = Terms_sub::where('ts_id', $id)->with('learn_result_detail')->first();
        return $learn_result_detail->learn_result_detail;
    }

    public function get_result_remark($id)
    {
        $remark = Learn_results_list::where('ts_id', $id)->with('learn_result_remark')->get();
        return $remark;
    }
    public function get_objective_num($objective)
    {
        $num = 1;
        $result = [];
        foreach ($objective as $item) {
            $result[] = [
                'num' => $num . '.',
                'obj_id' => $item['obj_id'],
                'obj_title' => $item['obj_title']
            ];

            $num += 1;
        }
        return $result;
    }
    public function get_remark_check($lrl_id, $lrd_id)
    {
        return Learn_results_remark::where('lrl_id', $lrl_id)
            ->where('lrd_id', $lrd_id)
            ->exists();
    }
    public function objective_remark_check($id)
    {

        $list_result = Learn_results_list::where('ts_id', $id)->get();
        $objective = Objective::where('ts_id', $id)->get();
        $result_data = [];

        foreach ($list_result as $list) {
            $lrl_id  = $list['lrl_id'];
            foreach ($objective as $objec) {
                $obj_id  = $objec['obj_id'];
                $remark =   Objective_remark::where('obj_id', $obj_id)->where('lrl_id', $lrl_id)->exists();

                if ($remark) {
                    $result_data[] = [
                        'lrl_id' => $lrl_id,
                        'obj_id' =>   $obj_id,
                        'status' => '1'
                    ];
                } else {
                    $result_data[] = [
                        'lrl_id' => $lrl_id,
                        'obj_id' =>   $obj_id,
                        'status' => '0'
                    ];
                }
            }
        }
        return $result_data;
    }
    public function get_teachers($id)
    {
        $teachers = Terms_sub_teach::where('ts_id', $id)->with('users.user_detail')->get();

        $result = [];
        $num = 1;
        foreach ($teachers as $item) {
            $result[] = [

                'num' => $num,
                'teacher' => $item->users->user_detail->user_d_name
            ];
            $num += 1;
        }
        return $result;
    }
    public function get_committee($id)
    {
        $teachers = Doc_committee::where('ts_id', $id)->with('users.user_detail')->get();

        $result = [];
        $num = 1;
        foreach ($teachers as $item) {
            $result[] = [

                'num' => $num,
                'teacher' => $item->users->user_detail->user_d_name
            ];
            $num += 1;
        }
        return $result;
    }


    public function get_planning_top($subject)
    {
        $plan_week = Planning_topic::where('doc_type', $subject->subjects->doc_type)->with('planing_week_list')->get();
        return $plan_week;
    }

    public function get_planning_week_hours($id)
    {
        $plan_week = Planning_week_hour::where('ts_id',)->get();
        return $plan_week;
    }
    public function get_planning_sum_hours($id)
    {
        $sum_plan_week = Planning_sum_hour::where('ts_id', $id)->get();
        return $sum_plan_week;
    }
    public function get_measure_list($id)
    {
        $measure_list = Measure_list::where('ts_id', $id)->get();
        return $measure_list;
    }
    public function get_sum_measure_list($id)
    {
        $measure_list = Measure_list::where('ts_id', $id)->get();
        $sum = 0;
        foreach ($measure_list as $item) {
            $sum += $item->ml_value;
        }
        return $sum;
    }
    public function get_resource($id)
    {
        $resource = Resource::where('ts_id', $id)->get();
        return $resource;
    }
    public function get_sub_description($id)
    {
        $subdes = Subject_description::where('ts_id', $id)->get();
        return $subdes;
    }
    public function get_objective($id)
    {
        $objective = Objective::where('ts_id', $id)->get();
        return $objective;
    }
    public function get_adjust_repeat($id)
    {
        $adjust_repeat = Adjust_repeat::where('ts_id', $id)->get();
        return $adjust_repeat;
    }
    public function pdf_result()
    {
        return view('pdf_doc.docresult_detail');
    }
}
