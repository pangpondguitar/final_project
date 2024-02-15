<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminPanel\TeachingControllor;
use App\Http\Controllers\AdminPanel\CourseController;


use App\Http\Controllers\UsersPanel\ProfileControllor;
use App\Http\Controllers\UsersPanel\CourseSpecControllor;

use App\Models\Course_committee;

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


Route::post('admin_add_subject/{id}', [CourseController::class, 'add_subject']);
Route::post('admin_update_subject', [CourseController::class, 'update_subject']);
Route::get('admin_delete_subject/{id}', [CourseController::class, 'delete_subject']);
Route::post('admin_edit_subject_doc/{id}', [CourseController::class, 'edit_doctype']);


Route::get('admin_get_topic_result/{id}', [CourseController::class, 'topic_result']);
Route::post('admin_add_topic_result/{id}', [CourseController::class, 'add_topic_result']);
Route::get('admin_update_topic_result/{id}', [CourseController::class, 'update_topic_result']);
Route::get('admin_delete_topic_result/{id}', [CourseController::class, 'delete_topic_result']);

//users
Route::get('get_profile/{id}', [ProfileControllor::class, 'get_profile']);
Route::get('get_all_subject/{id}/{t_id}', [CourseSpecControllor::class, 'get_all_subject']);
Route::get('get_subject_teach/{id}', [CourseSpecControllor::class, 'get_subject_teach']);
Route::get('get_teachers/{id}', [CourseSpecControllor::class, 'get_teachers']);
