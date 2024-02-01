<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminPanel\TeachingControllor;
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
Route::post('add_sub', [teachingControllor::class, 'add_sub']);
Route::get('delete_sub/{id}', [TeachingControllor::class, 'delete_sub']);
Route::get('get_term_sub/{id}', [TeachingControllor::class, 'get_term_sub']);
Route::post('add_teacher', [teachingControllor::class, 'add_teacher']);
