<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminDocumentReportController extends Controller
{
    public function index()
    {
        return view('admin.doc_report_view');
    }
}
