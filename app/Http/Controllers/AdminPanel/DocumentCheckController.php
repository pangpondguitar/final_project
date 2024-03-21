<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\Docfile_status;
use Illuminate\Http\Request;
use App\Models\Terms;
use App\Models\Program;
use App\Models\Subject;
use App\Models\Terms_courses;
use App\Models\User;
use App\Models\Users_detail;
use App\Models\Terms_sub_teach;
use App\Models\Terms_sub;
use App\Models\Docfile;

class DocumentCheckController extends Controller
{
    public function index()
    {
        return view('admin.document_check');
    }
    public function get_subject($id, $t_id)
    {
        $subjects = Terms_sub::with(['subjects.courses.program'])
            ->whereHas('subjects.courses.program', function ($query) use ($id) {
                $query->where('p_id', $id);
            })->with('docfile.docfile_status')->where('t_id', $t_id)->get();

        return response()->json([
            'subjects' => $subjects
        ], 200);
    }
    public function get_docfile_status($id)
    {
        $doc_status = Docfile_status::where('df_id', $id)->get();
        return response()->json([
            'doc_status' => $doc_status
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

    public function get_doc_file($id)
    {
        $docfile = Docfile::where('ts_id', $id)->get();
        return response()->json([
            'docfile' => $docfile
        ], 200);
    }
    public function confirm_docfile_status($id, $status_con)
    {
        $status = new Docfile_status();
        $status->df_id = $id;
        $status->dfs_status = $status_con;
        $status->save();
    }
}
