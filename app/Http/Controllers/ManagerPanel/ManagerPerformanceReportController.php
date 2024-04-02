<?php

namespace App\Http\Controllers\ManagerPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Program;
use App\Models\Subject;
use App\Models\Course_committee;
use App\Models\Doc_course;
use App\Models\Topic_learn_results;
use App\Models\Performance;
use App\Models\User;
use App\Models\user_detail;
use App\Models\Terms;
use App\Models\Users_detail;
use App\Models\Terms_sub;

class ManagerPerformanceReportController extends Controller
{
    public function index()
    {
        return view('manager.performance_report.index');
    }
    public function get_doc_performance($year)
    {
        $program = Program::get();
        $pf_year = $year;
        $data = [];

        foreach ($program as $item) {
            $p_id = $item->p_id;
            $p_name = $item->p_name;
            $users = $this->get_userByProgram($p_id);
            $count = 0;

            foreach ($users as $item) {
                $user_id = $item->id;
                $performance = Performance::where('id', $user_id)->where('pf_year', $pf_year)->count();

                $count += $performance;
            }
            $data[$p_id] = [
                'name' => $p_name,
                'count' => $count
            ];

        }

        $year = date('Y') + 543;
        $year_arr = [];
        for ($i = 1; $i <= 5; $i++) {
            $year_arr[] = $year;
            $year -= 1;
        }

        return response()->json([
            'count_per' => $data,
            'year' => $year_arr
        ], 200);
    }
    public function get_userByProgram($id)
    {
        $users = User::where('user_type', 2)->where('user_status', '1')->with('user_detail')->whereHas('user_detail', function ($query) use ($id) {
            $query->where('p_id', $id);
        })->get();
        return $users;
    }


}
