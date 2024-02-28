<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
use App\Models\Planning_week_list;
use App\Models\Planning_sum_hour;
use App\Models\Doc_committee;
use App\Models\Measure_list;
use App\Models\Resource;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class PDFController extends Controller
{
    public function index($id)
    {
        $subject = Terms_sub::with(['subjects.courses.topic_learn_results'])->with(['terms'])->where('ts_id', $id)->first();
        $top_result = Topic_learn_results::where('c_id', $subject->subjects->c_id)->where('doc_type', $subject->subjects->doc_type)->get();
        $result_list_detail = Learn_results_detail::where('ts_id', $id)->get();


        $count_list_detail = Topic_learn_results::select('topic_learn_results.tlr_id', 'tlr_title', DB::raw('count(learn_results_details.tlr_id) as count'))
            ->leftJoin('learn_results_details', 'topic_learn_results.tlr_id', '=', 'learn_results_details.tlr_id')->where('learn_results_details.ts_id', $id)
            ->groupBy('topic_learn_results.tlr_id', 'tlr_title')
            ->get();
        $count_all_details = Learn_results_detail::where('ts_id', $id)->count();

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
            $result_data[]  = $num . '.' . ' ' . $item['lrl_title'];
            $num  += 1;
        }



        $result_data_detail =   $this->learn_result_detail($subject, $id);
        $plan_week_top =   $this->get_planning_top($subject);
        $plan_week =   $this->planing_week($id, $subject);
        $sum_plan_week =   $this->get_planning_sum_hours($id);
        $measure_list =   $this->get_measure_list($id);
        $sum_measure_list =   $this->get_sum_measure_list($id);
        $resource =   $this->get_resource($id);

        // return response()->json([
        //     'term_sub' => $resource
        // ], 200);

        $m = new Merger();
        $imagePath = public_path('/assets/img/logo-sru.jpg');
        $imageData = File::get($imagePath);
        $base64Image = base64_encode($imageData);



        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pdf_doc.doctitle', compact('subject', 'base64Image'))->setPaper('a4', 'portrait');
        $m->addRaw($pdf->output());


        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pdf_doc.docresult', compact('count_list_detail', 'count_all_details', 'list_result_detail', 'result_data'))->setPaper('a4', 'landscape');
        $m->addRaw($pdf->output());

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pdf_doc.docresult_detail', compact('result_data_detail'))->setPaper('a4', 'portrait');
        $m->addRaw($pdf->output());

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pdf_doc.docplan', compact('plan_week', 'plan_week_top', 'sum_plan_week'))->setPaper('a4', 'landscape');
        $m->addRaw($pdf->output());

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pdf_doc.doclast', compact('measure_list', 'sum_measure_list', 'resource'))->setPaper('a4', 'portrait');
        $m->addRaw($pdf->output());

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
    public function pdf_result()
    {
        return view('pdf_doc.docresult_detail');
    }
}
