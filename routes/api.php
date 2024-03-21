<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminPanel\TeachingControllor;
use App\Http\Controllers\AdminPanel\CourseController;


use App\Http\Controllers\UsersPanel\ProfileControllor;
use App\Http\Controllers\UsersPanel\CourseSpecControllor;
use App\Http\Controllers\UsersPanel\PerformanceController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\PerformanceReportController;
use App\Http\Controllers\AdminPanel\DocumentCheckController;
use App\Http\Controllers\PresidentPanel\DocumentReportController;
use App\Http\Controllers\PresidentPanel\CourseProgramController;
use App\Models\Course_committee;
use App\Http\Controllers\ManagerPanel\DocumentSummaryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::prefix('admin/teaching')->group(function () {
//     Route::controller(TeachingControllor::class)->group(function () {
//         Route::get('/', 'index')->name('admin.teaching');
//     });
// });

Route::get('get_all_programs', [TeachingControllor::class, 'get_all_programs']);
Route::get('get_all_terms', [TeachingControllor::class, 'get_all_terms']);
Route::get('get_program/{id}', [TeachingControllor::class, 'get_program']);
Route::get('get_subject/{id}/{t_id}', [TeachingControllor::class, 'get_subject']);
Route::get('get_all_teachers/{id}', [TeachingControllor::class, 'get_all_teachers']);
Route::get('get_all_teaching/{id}', [TeachingControllor::class, 'get_all_teaching']);
Route::post('add_sub', [teachingControllor::class, 'add_sub']);
Route::get('delete_sub/{id}', [TeachingControllor::class, 'delete_sub']);
Route::get('delete_Teacher/{id}', [TeachingControllor::class, 'delete_Teacher']);
Route::get('get_term_sub/{id}/{p_id}', [TeachingControllor::class, 'get_term_sub']);
Route::post('add_teacher', [teachingControllor::class, 'add_teacher']);



//admin_course
Route::get('admin_get_all_programs', [CourseController::class, 'get_all_programs']);
Route::get('admin_get_courses/{id}', [CourseController::class, 'get_courses']);
Route::post('admin_update_course/{id}', [CourseController::class, 'update_course']);
Route::get('admin_delete_course/{id}', [CourseController::class, 'delete_course']);
Route::get('admin_get_courses_program/{id}', [CourseController::class, 'get_program']);
Route::get('admin_get_courses_subjects/{id}', [CourseController::class, 'get_subjects']);
Route::get('admin_get_single_course/{id}', [CourseController::class, 'get_single_course']);
Route::post('admin_add_course', [CourseController::class, 'add_course']);
Route::get('admin_get_teacher/{id}', [CourseController::class, 'get_teacher']);



Route::post('admin_add_subject/{id}', [CourseController::class, 'add_subject']);
Route::post('admin_update_subject', [CourseController::class, 'update_subject']);
Route::get('admin_delete_subject/{id}', [CourseController::class, 'delete_subject']);
Route::post('admin_edit_subject_doc/{id}', [CourseController::class, 'edit_doctype']);


Route::get('admin_get_topic_result/{id}/{doc}', [CourseController::class, 'topic_result']);
Route::post('admin_add_topic_result/{id}', [CourseController::class, 'add_topic_result']);
Route::get('admin_update_topic_result/{id}', [CourseController::class, 'update_topic_result']);
Route::get('admin_delete_topic_result/{id}', [CourseController::class, 'delete_topic_result']);

Route::get('admin_get_committee/{id}', [CourseController::class, 'get_committee']);
Route::post('admin_add_committee/{id}/{user_id}', [CourseController::class, 'add_committee']);
Route::get('admin_delete_committee/{id}', [CourseController::class, 'delete_committee']);

Route::get('get_subjectAll_term/{id}/{t_id}', [DocumentCheckController::class, 'get_subject']);
Route::get('admin_get_docfile_status/{id}', [DocumentCheckController::class, 'get_docfile_status']);
Route::get('admin_get_teachers/{id}', [DocumentCheckController::class, 'get_teachers']);
Route::get('admin_get_docfile/{id}', [DocumentCheckController::class, 'get_doc_file']);
Route::get('admin_confirm_docfile_status/{id}/{status_con}', [DocumentCheckController::class, 'confirm_docfile_status']);


Route::post('admin_add_course_doc/{id}', [CourseController::class, 'course_Addfile']);
Route::get('admin_get_course_doc/{id}', [CourseController::class, 'get_course_doc']);
Route::get('admin_delete_course_doc/{id}', [CourseController::class, 'delete_course_doc']);

Route::get('user_open_course_doc_file/{id}', [CourseController::class, 'open_course_doc_file']);

//users
Route::get('get_profile/{id}', [ProfileControllor::class, 'get_profile']);
Route::get('get_all_subject/{id}/{t_id}', [CourseSpecControllor::class, 'get_all_subject']);
Route::get('get_subject_teach/{id}', [CourseSpecControllor::class, 'get_subject_teach']);
Route::get('get_teachers/{id}', [CourseSpecControllor::class, 'get_teachers']);
Route::get('user_get_top_result/{id}', [CourseSpecControllor::class, 'get_top_result']);
Route::get('user_get_subject/{id}', [CourseSpecControllor::class, 'get_subject']);
Route::get('user_get_course/{id}', [CourseSpecControllor::class, 'get_course']);

Route::get('user_get_Lresult_list/{id}', [CourseSpecControllor::class, 'get_result_list']);
Route::post('user_add_Lresult_list/{id}', [CourseSpecControllor::class, 'add_result_list']);
Route::post('user_update_Lresult_list', [CourseSpecControllor::class, 'update_result_list']);
Route::get('user_delete_Lresult_list/{id}', [CourseSpecControllor::class, 'delete_result_list']);

Route::get('user_get_Lresult_detail/{id}/{tlr_id}', [CourseSpecControllor::class, 'get_result_detail']);
Route::post('user_add_Lresult_detail/{id}', [CourseSpecControllor::class, 'add_result_detail']);
Route::post('user_update_Lresult_detail', [CourseSpecControllor::class, 'update_result_detail']);
Route::get('user_delete_Lresult_detail/{id}', [CourseSpecControllor::class, 'delete_result_detail']);

Route::get('user_get_planWeek_hour/{id}', [CourseSpecControllor::class, 'get_planweek_hour']);
Route::post('user_add_planWeek_hour/{id}', [CourseSpecControllor::class, 'add_planweek_hour']);
Route::post('user_update_planWeek_hour', [CourseSpecControllor::class, 'update_planweek_hour']);
Route::get('user_delete_planWeek_hour/{id}', [CourseSpecControllor::class, 'delete_planweek_hour']);

Route::get('user_get_planning_top/{id}', [CourseSpecControllor::class, 'get_planning_top']);
Route::get('user_get_singleWeek/{id}', [CourseSpecControllor::class, 'get_single_week']);

Route::get('user_get_planning_list/{pt_id}/{pw_id}', [CourseSpecControllor::class, 'get_planning_list']);
Route::post('user_add_planning_list/{pt_id}/{pw_id}', [CourseSpecControllor::class, 'add_planning_list']);
Route::post('user_update_planning_list', [CourseSpecControllor::class, 'update_planning_list']);
Route::get('user_delete_planning_list/{id}', [CourseSpecControllor::class, 'delete_planning_list']);

Route::get('user_get_planning_sum/{id}', [CourseSpecControllor::class, 'get_planning_sum']);
Route::post('user_update_planning_sum', [CourseSpecControllor::class, 'update_planning_sum']);
Route::post('user_add_planning_sum/{id}', [CourseSpecControllor::class, 'add_planning_sum']);

Route::get('user_get_measure/{id}', [CourseSpecControllor::class, 'get_measure']);
Route::post('user_add_measure/{id}', [CourseSpecControllor::class, 'add_measure']);


Route::post('user_update_measure', [CourseSpecControllor::class, 'update_measure']);
Route::get('user_delete_measure/{id}', [CourseSpecControllor::class, 'delete_measure']);

Route::get('user_get_resource/{id}', [CourseSpecControllor::class, 'get_resource']);
Route::post('user_add_resource/{id}', [CourseSpecControllor::class, 'add_resource']);
Route::post('user_update_resource', [CourseSpecControllor::class, 'update_resource']);

Route::get('user_get_prepplan_top', [CourseSpecControllor::class, 'get_prepplan_top']);

Route::get('user_get_prepplan/{id}/{ppt_id}', [CourseSpecControllor::class, 'get_prepplan']);
Route::post('user_add_prepplan/{id}', [CourseSpecControllor::class, 'add_prepplan']);
Route::post('user_update_prepplan', [CourseSpecControllor::class, 'update_prepplan']);
Route::get('user_delete_prepplan/{id}', [CourseSpecControllor::class, 'delete_prepplan']);

Route::get('user_get_measure_prac_top', [CourseSpecControllor::class, 'get_measure_prac_top']);

Route::get('user_get_measure_prac/{id}/{mpt_id}', [CourseSpecControllor::class, 'get_measure_prac']);
Route::post('user_add_measure_prac/{id}', [CourseSpecControllor::class, 'add_measure_prac']);
Route::post('user_update_measure_prac', [CourseSpecControllor::class, 'update_measure_prac']);
Route::get('user_delete_measure_prac/{id}', [CourseSpecControllor::class, 'delete_measure_prac']);


Route::get('user_get_adjust_people_top', [CourseSpecControllor::class, 'get_adjust_people_top']);
Route::get('user_get_adjust_people/{id}/{apt_id}', [CourseSpecControllor::class, 'get_adjust_people']);
Route::post('user_add_adjust_people/{id}', [CourseSpecControllor::class, 'add_adjust_people']);
Route::post('user_update_adjust_people', [CourseSpecControllor::class, 'update_adjust_people']);
Route::get('user_delete_adjust_people/{id}', [CourseSpecControllor::class, 'delete_adjust_people']);


Route::get('user_get_adjust_repeat/{id}', [CourseSpecControllor::class, 'get_adjust_repeat']);
Route::post('user_add_adjust_repeat/{id}', [CourseSpecControllor::class, 'add_adjust_repeat']);
Route::post('user_update_adjust_repeat', [CourseSpecControllor::class, 'update_adjust_repeat']);
Route::get('user_delete_adjust_repeat/{id}', [CourseSpecControllor::class, 'delete_adjust_repeat']);

Route::get('user_get_objective/{id}', [CourseSpecControllor::class, 'get_objective']);
Route::post('user_add_objective/{id}', [CourseSpecControllor::class, 'add_objective']);
Route::post('user_update_objective', [CourseSpecControllor::class, 'update_objective']);
Route::get('user_delete_objective/{id}', [CourseSpecControllor::class, 'delete_objective']);

Route::get('user_get_subdes/{id}', [CourseSpecControllor::class, 'get_subdes']);
Route::post('user_add_subdes/{id}', [CourseSpecControllor::class, 'add_subdes']);
Route::post('user_update_subdes', [CourseSpecControllor::class, 'update_subdes']);


Route::get('user_get_committee/{id}', [CourseSpecControllor::class, 'get_committee']);
Route::post('user_add_committee/{id}', [CourseSpecControllor::class, 'add_committee']);
Route::get('user_delete_committee/{id}/{user_id}', [CourseSpecControllor::class, 'delete_committee']);


Route::get('user_get_doc_show/{id}', [PDFController::class, 'get_doc_show']);
Route::get('user_get_docfile/{id}', [CourseSpecControllor::class, 'get_doc_file']);
Route::get('user_get_docfile_finish/{id}', [CourseSpecControllor::class, 'get_docfile_finish']);
Route::get('user_delete_docfile/{id}', [CourseSpecControllor::class, 'delete_docfile']);

Route::get('user_get_performance_file/{id}', [PerformanceController::class, 'get_performance_file']);
Route::get('user_get_performance_file_byid/{id}', [PerformanceController::class, 'get_performance_file_byid']);
Route::get('user_open_performance_file/{id}', [PerformanceController::class, 'open_performance_file']);
Route::post('user_performance_Addfile/{id}', [PerformanceController::class, 'performance_Addfile']);
Route::get('user_get_performance_file_edit_byid/{id}', [PerformanceController::class, 'get_performance_file_edit_byid']);
Route::post('user_performance_Edit/{id}', [PerformanceController::class, 'performance_Edit']);
Route::post('user_performance_add_file_edit/{id}', [PerformanceController::class, 'performance_add_file_edit']);
Route::get('user_delete_performance_file/{id}', [PerformanceController::class, 'performance_file_delete']);
Route::get('user_delete_performance/{id}', [PerformanceController::class, 'performance_delete']);
Route::get('user_get_teacher/{id}', [PerformanceController::class, 'get_teacher']);

Route::get('user_get_result_detail_All/{id}', [CourseSpecControllor::class, 'get_result_detail_All']);
Route::get('user_get_result_remark/{id}', [CourseSpecControllor::class, 'get_result_remark']);
Route::post('user_update_result_remark', [CourseSpecControllor::class, 'update_result_remark']);
Route::get('user_getObjective_Remark/{id}', [CourseSpecControllor::class, 'get_objective_remark']);
Route::post('user_update_objective_remark', [CourseSpecControllor::class, 'update_objective_remark']);

//president
Route::get('president_get_user_data/{id}', [DocumentReportController::class, 'get_user_data']);
Route::get('president_get_subjectAll_term/{id}/{t_id}', [DocumentReportController::class, 'get_subject']);
Route::get('president_get_teacher/{id}/{t_id}', [DocumentReportController::class, 'get_teacher']);
Route::get('president_get_teacher_detail/{id}/{t_id}', [DocumentReportController::class, 'get_teacher_detail']);
Route::get('president_get_single_term/{id}', [DocumentReportController::class, 'get_single_term']);


Route::get('president_get_program/{id}', [CourseProgramController::class, 'get_program']);
Route::get('president_get_single_course/{id}', [CourseProgramController::class, 'get_single_course']);
Route::get('manager_get_subjectAll_term/{id}/{t_id}', [DocumentSummaryController::class, 'get_subject']);
Route::get('manager_get_program/{id}', [DocumentSummaryController::class, 'get_program']);

Route::get('manager_get_doc_status_count/{t_id}', [DocumentSummaryController::class, 'get_doc_status_count']);


//reportPerformance
Route::get('performance_count_check/{id}', [PerformanceReportController::class, 'performance_count_check']);
Route::get('performance_teacher/{id}', [PerformanceReportController::class, 'performance_teacher']);
