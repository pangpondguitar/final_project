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
