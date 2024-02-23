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

class PDFController extends Controller
{
    public function index($id)
    {
        $subject = Terms_sub::with(['subjects'])->where('ts_id', $id)->get();
        $m = new Merger();


        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pdf_doc.doctitle', compact('subject'))->setPaper('a4', 'portrait');
        $m->addRaw($pdf->output());


        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pdf_doc.docresult')->setPaper('a4', 'landscape');
        $m->addRaw($pdf->output());

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pdf_doc.docresult_detail')->setPaper('a4', 'portrait');
        $m->addRaw($pdf->output());

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pdf_doc.docplan')->setPaper('a4', 'landscape');
        $m->addRaw($pdf->output());

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pdf_doc.doclast')->setPaper('a4', 'landscape');
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

    public function pdf_result()
    {
        return view('pdf_doc.docresult_detail');
    }
}
