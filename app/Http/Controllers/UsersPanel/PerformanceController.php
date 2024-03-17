<?php

namespace App\Http\Controllers\UsersPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PerformanceFile;
use App\Models\Performance;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PerformanceController extends Controller
{
    public function index()
    {
        return view('users.performance.index');
    }

    public function performance_Addfile(Request $request, $id)
    {
        $performance = new Performance;
        $performance->pf_name = $request->title;
        $performance->pf_date = $request->date;
        $performance->pf_year = $request->year;
        $performance->pf_detail = $request->detail;
        $performance->id = $id;
        $performance->save();

        $latestId = $performance->pf_id;

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $uploadedFile) {
                $randomFileName = uniqid() . '_' . Str::random(10) . '.pdf';
                $filePath = 'uploads/performance_doc' . '/' . $randomFileName;

                // บันทึกไฟล์โดยใช้ move_uploaded_file()
                if (move_uploaded_file($uploadedFile, $filePath)) {
                    $filePaths[] = $filePath;

                    $file = new PerformanceFile;
                    $file->pff_name = $randomFileName;
                    $file->pf_id = $latestId;
                    $file->save();
                } else {
                    // หากเกิดข้อผิดพลาดในการบันทึกไฟล์
                    return response()->json(['message' => 'Failed to upload files'], 500);
                }
            }

            // Return JSON response with file paths
            return response()->json(['message' => 'Upload successful', 'file_paths' => $filePaths], 200);
        } else {
            return response()->json(['message' => 'No files uploaded'], 400);
        }
    }

    public function performance_add_file_edit(Request $request, $id)
    {

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $uploadedFile) {
                $randomFileName = uniqid() . '_' . Str::random(10) . '.pdf';
                $filePath = 'uploads/performance_doc' . '/' . $randomFileName;

                // บันทึกไฟล์โดยใช้ move_uploaded_file()
                if (move_uploaded_file($uploadedFile, $filePath)) {
                    $filePaths[] = $filePath;

                    $file = new PerformanceFile;
                    $file->pff_name = $randomFileName;
                    $file->pf_id = $id;
                    $file->save();
                } else {
                    // หากเกิดข้อผิดพลาดในการบันทึกไฟล์
                    return response()->json(['message' => 'Failed to upload files'], 500);
                }
            }

            // Return JSON response with file paths
            return response()->json(['message' => 'Upload successful', 'file_paths' => $filePaths], 200);
        } else {
            return response()->json(['message' => 'No files uploaded'], 400);
        }
    }
    public function performance_Edit(Request $request, $id)
    {
        $performance = Performance::find($id);
        $performance->pf_name = $request->title;
        $performance->pf_date = $request->date;
        $performance->pf_year = $request->year;
        $performance->pf_detail = $request->detail;
        $performance->save();
    }
    public function performance_file_delete($id)
    {
        $performance = PerformanceFile::find($id);
        $filePath = public_path('uploads/performance_doc/' . $performance->pff_name);
        unlink($filePath);

        $performance->delete();
    }
    public function performance_delete($id)
    {
        $performance = Performance::find($id);
        $performance->delete();
    }
    public function get_performance_file($id)
    {
        $performance = Performance::where('id', $id)->with('performance_file')->get();
        return response()->json([
            'performance' => $performance
        ], 200);
    }
    public function get_teacher($id)
    {
        $teacher = User::with('user_detail')->where('id', $id)->get();
        return response()->json([
            'teacher' => $teacher
        ], 200);
    }

    public function get_performance_file_byid($id)
    {
        $performance = Performance::where('pf_id', $id)->with('performance_file')->get();
        return response()->json([
            'performance' => $performance
        ], 200);
    }
    public function get_performance_file_edit_byid($id)
    {
        $performance = Performance::where('pf_id', $id)->with('performance_file')->first();
        return response()->json([
            'performance' => $performance
        ], 200);
    }
    public function open_performance_file($id)
    {
        $performanceFile = PerformanceFile::find($id);
        if (!$performanceFile) {
            return response()->json(['error' => 'ไฟล์เอกสารไม่พบ'], 404);
        }

        $filePath = public_path('uploads/performance_doc/' . $performanceFile->pff_name);
        if (!file_exists($filePath)) {
            return response()->json(['error' => 'ไฟล์เอกสารไม่พบ'], 404);
        }
        return response()->stream(
            function () use ($filePath) {
                readfile($filePath);
            },
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $performanceFile->pff_name . '"',
            ]
        );
    }
}
