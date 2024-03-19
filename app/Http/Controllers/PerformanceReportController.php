<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PerformanceFile;
use App\Models\Performance;
use App\Models\Teaching;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PerformanceReportController extends Controller
{
    public function index_president()
    {
        return view('president.performance_report.index');
    }
    public function index_admin()
    {
        return view('admin.performance_report');
    }
    public function performance_count_check($id)
    {
        $performanceCounts = Performance::select('pf_year', DB::raw('COUNT(*) as count'))
            ->with('user.user_detail')
            ->whereHas('user.user_detail', function ($query) use ($id) {
                $query->where('p_id', $id);
            })
            ->whereHas('user', function ($query) use ($id) {
                $query->where('user_status', 1);
            })
            ->whereHas('user', function ($query) use ($id) {
                $query->where('user_type', 2);
            })
            ->groupBy('pf_year')
            ->orderByDesc('pf_year')
            ->get();
        $year_past = (now()->year + 543) - 4;
        $year_now = (now()->year + 543);

        $data = [];

        while ($year_now >= $year_past) {
            $found = false;

            foreach ($performanceCounts as $item) {
                if ($item['pf_year'] == $year_now) {
                    $data[] = [
                        'year' => $item['pf_year'],
                        'count' => $item['count'],
                    ];
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $data[] = [
                    'year' => $year_now,
                    'count' => 0,
                ];
            }

            $year_now--;
        }

        return response()->json([
            'performance_counts' => $performanceCounts,
            'date' =>  $data
        ], 200);
    }
    public function performance_teacher($id)
    {
        $teachers = User::with('user_detail', 'performance')->whereHas('user_detail', function ($query) use ($id) {
            $query->where('p_id', $id);
        })->where('user_type', 2)->where('user_status', 1)->get();

        return response()->json([
            'teacher' => $teachers
        ], 200);
    }
}
