<?php

namespace App\Http\Controllers\ManagerPanel;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;
use App\Models\Terms_sub;

class DocumentSummaryController extends Controller
{
    public function index()
    {
        return view('manager.doc_report.index');
    }

    public function get_subject($id, $t_id)
    {
        $count_success = 0;
        $count_wait = 0;
        $count_doc = 0;
        $count_sub = 0;
        $count_redoc = 0;
        $subjects = Terms_sub::with(['subjects.courses.program'])
            ->whereHas('subjects.courses.program', function ($query) use ($id) {
                $query->where('p_id', $id);
            })->with('docfile.docfile_status')->where('t_id', $t_id)->paginate(10);
        foreach ($subjects as $item) {
            foreach ($item->docfile as $docfile) {
                $lastStatus = $docfile->docfile_status->last();

                // Assuming 'status' is a column in 'docfile_status' table
                if ($lastStatus && $lastStatus->dfs_status == 1) {
                    $count_success += 1;
                } elseif ($lastStatus && $lastStatus->dfs_status == 0) {
                    $count_wait += 1;
                } elseif ($lastStatus && $lastStatus->dfs_status == 2) {
                    $count_redoc += 1;
                }
            }
            if ($item->docfile->count() == 0) {
                $count_doc += 1;
            }
            $count_sub += 1;
        }


        return response()->json([
            'subjects' => $subjects,
            'count_success' => $count_success,
            'count_wait' => $count_wait,
            'count_doc' => $count_doc,
            'count_sub' => $count_sub,
            'count_redoc' => $count_redoc
        ], 200);
    }
    public function get_program($id)
    {
        $program = Program::find($id);

        return response()->json([
            'program' => $program
        ]);
    }
}
