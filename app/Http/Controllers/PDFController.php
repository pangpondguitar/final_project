<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function index()
    {
        $pdf = Pdf::loadView('users.course_spec.pdf');
        return $pdf->download('users.pdf');
    }
}
