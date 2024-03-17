<?php

namespace App\Http\Controllers\PresidentPanel;

use App\Http\Controllers\Controller;
use App\Models\Terms;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Users_detail;
use App\Models\Terms_sub;

class DocumentReportController extends Controller
{
    public function index()
    {
        return view('president.doc_report.index');
    }
    public function get_user_data($id)
    {
        $user = User::find($id);
        $user =  $user->user_detail;
        return response()->json([
            'user' => $user
        ], 200);
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
    public function get_teacher($id, $t_id)
    {
        $teachers = User::with([
            'user_detail' => function ($query) use ($id) {
                $query->where('p_id', $id);
            },
            'terms_sub_teaches' => function ($query) use ($t_id) {
                $query->whereHas('terms_sub', function ($subQuery) use ($t_id) {
                    $subQuery->where('t_id', $t_id);
                });
            },
            'terms_sub_teaches.terms_sub' => function ($query) use ($t_id) {
                $query->where('t_id', $t_id);
            },
        ])
            ->where('user_status', '1')
            ->where('user_type', '2')
            ->whereHas('user_detail', function ($query) use ($id) {
                $query->where('p_id', $id);
            })
            ->get();

        return response()->json([
            'teachers' => $teachers
        ], 200);
    }


    public function get_teacher_detail($id, $t_id)
    {
        // $teachers = User::with('user_detail')
        //     ->with(['terms_sub_teaches.terms_sub.subjects', 'terms_sub_teaches.terms_sub.docfile.docfile_status'])
        //     ->whereHas('terms_sub_teaches.terms_sub', function ($query) use ($t_id) {
        //         $query->where('t_id', $t_id);
        //     })
        //     ->where('id', $id)
        //     ->get();

        $teachers = User::with('user_detail')
            ->with([
                'terms_sub_teaches' => function ($query) use ($t_id) {
                    $query->whereHas('terms_sub', function ($subQuery) use ($t_id) {
                        $subQuery->where('t_id', $t_id);
                    });
                },
                'terms_sub_teaches.terms_sub' => function ($query) use ($t_id) {
                    $query->where('t_id', $t_id);
                },
                'terms_sub_teaches.terms_sub.subjects',
                'terms_sub_teaches.terms_sub.docfile.docfile_status'
            ],)
            ->where('id', $id)->get();
        // $subjects = $user
        $count_success = 0;
        $count_wait = 0;
        $count_doc = 0;
        $count_sub = 0;

        foreach ($teachers as $item) {
            foreach ($item->terms_sub_teaches as $docfile) {
                $lastStatus = $docfile->terms_sub->docfile;
                foreach ($lastStatus as $docfile) {
                    // $lastStatus2[] = $docfile;
                    $lastStatus3 = $docfile->docfile_status->last();

                    if ($lastStatus3->dfs_status == 1) {
                        $count_success += 1;
                    } elseif ($lastStatus3->dfs_status == 0) {
                        $count_wait += 1;
                    }
                }
                if ($lastStatus->count() == 0) {
                    $count_doc += 1;
                }
            }
        }

        return response()->json([
            'teachers' => $teachers,
            'count_success' => $count_success,
            'count_wait' => $count_wait,
            'count_doc' => $count_doc
        ], 200);
    }

    public function get_single_term($id)
    {
        $term = Terms::find($id);
        return response()->json([
            'term' => $term
        ], 200);
    }
}
