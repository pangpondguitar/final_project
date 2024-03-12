<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\AdminPanel\AdminControllor;
use App\Http\Controllers\AdminPanel\CourseController;
use App\Http\Controllers\UsersPanel\UsersControllor;
use App\Http\Controllers\AdminPanel\AdminuserController;
use App\Http\Controllers\AdminPanel\TermsControllor;
use App\Http\Controllers\AdminPanel\TeachingControllor;
use App\Http\Controllers\AdminPanel\DocumentCheckController;
use App\Http\Controllers\UsersPanel\ProfileControllor;
use App\Http\Controllers\UsersPanel\CourseSpecControllor;
use App\Http\Controllers\PresidentPanel\PresidentController;
use App\Http\Controllers\PresidentPanel\DocumentReportController;
use App\Http\Controllers\PresidentPanel\CourseProgramController;
use App\Http\Controllers\ManagerPanel\ManagerController;
use App\Http\Controllers\ManagerPanel\DocumentSummaryController;
use App\Http\Controllers\PDFController;
use App\Models\Terms;

use Barryvdh\DomPDF\Facade\Pdf;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('admin', function () {
//     return view('admin.home');
// });
Route::get('/logout', function () {
    return view('auth.vertify-email');
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Route::get('admin', function () {
    //     return view('admin.home');
    // });
    // Route::get('/program', [ProgramController::class, 'index'])->name('program');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:1'])->group(function () {
    Route::get('admin/home', [AdminControllor::class, 'index'])->name('admin.home');
    Route::get('admin/programs', [AdminControllor::class, 'programs'])->name('admin.program');
    // Route::post('admin/programs/insert', [AdminControllor::class, 'program_insert'])->name('admin.insert');
    Route::prefix('admin/programs')->group(function () {
        Route::post('/insert', [AdminControllor::class, 'program_insert'])->name('admin.insert');
        Route::get('/edit/{id}', [AdminControllor::class, 'program_edit'])->name('program.edit');
        Route::post('/update/{id}', [AdminControllor::class, 'program_update'])->name('program.update');
        Route::post('/update_course/{id}', [AdminControllor::class, 'program_update_course'])->name('program.update.course');
        Route::get('/delete/{id}', [AdminControllor::class, 'program_delete'])->name('program.delete');
    });

    Route::prefix('admin/courses')->group(function () {
        Route::controller(CourseController::class)->group(function () {
            Route::get('/', 'index')->name('admin.course');
            Route::get('/{pathMatch}', 'index')->where('pathMatch', ".*");
            Route::get('/all/{id}', 'all')->name('admin.course_all');
            Route::post('/insert/{id}', 'course_insert')->name('admin.course_insert');
            Route::get('/detail/{id}/{menu}', 'detail')->name('admin.course_detail');
            Route::get('/course/delete/{id}', 'course_delete')->name('admin.course_detail.course_delete');
            Route::post('/subject/insert/{id}', 'subject_insert')->name('admin.course_detail.subject_insert');
            Route::post('/subject/edite/{id}', 'subject_edit')->name('admin.course_detail.subject_edit');
            Route::get('/subject/delete/{id}', 'subject_delete')->name('admin.course_detail.subject_delete');
            Route::get('/subject/search/{id}', 'subject_search')->name('admin.course_detail.subject_search');
        });
    });
    Route::prefix('admin/users')->group(function () {
        Route::controller(AdminuserController::class)->group(function () {
            Route::get('/', 'index')->name('admin.users');
            Route::get('/detail/{id}', 'user_detail')->name('admin.user_detail');
            Route::get('/insert', 'user_insert')->name('admin.user_insert');
            Route::get('/delete/{id}', 'delete')->name('admin.user_delete');
            Route::post('/insert_check', 'user_insert_check')->name('admin.user_insert_check');
            Route::post('/edit_check/{id}', 'user_edit_check')->name('admin.user_edit_check');
            Route::post('/edit_password/{id}', 'user_edit_password')->name('admin.user_edit_password');
        });
    });
    Route::prefix('admin/terms')->group(function () {
        Route::controller(TermsControllor::class)->group(function () {
            Route::get('/', 'index')->name('admin.terms');
            Route::post('/insert', 'term_insert')->name('admin.term_insert');
            Route::get('/delete/{id}', 'term_delete')->name('admin.term_delete');
            Route::post('/edit/{id}', 'term_edit')->name('admin.term_edit');
            Route::get('/term_program/{id}', 'program')->name('admin.term_program');
        });
    });
    Route::prefix('admin/teaching')->group(function () {
        Route::controller(TeachingControllor::class)->group(function () {
            Route::get('/', 'index')->name('admin.teaching');
            Route::get('/{pathMatch}', 'index')->where('pathMatch', ".*");
        });
    });

    Route::prefix('admin/document_check')->group(function () {
        Route::controller(DocumentCheckController::class)->group(function () {
            Route::get('/', 'index')->name('admin.document_check');
            Route::get('/document_check_sub/{id}', 'index')->name('admin.document_check_sub');
            Route::get('/{pathMatch}', 'index')->where('pathMatch', ".*");
        });
    });
    // Route::name('admin/programs.')->group(function () {
    //     Route::post('/insert', [AdminControllor::class, 'program_insert'])->name('admin.insert');
    // });
});
Route::middleware(['auth', 'role:2'])->group(function () {
    Route::get('users/home', [UsersControllor::class, 'index'])->name('users.home');

    Route::prefix('users/profile')->group(function () {
        Route::controller(ProfileControllor::class)->group(function () {
            Route::get('/', 'index')->name('users.profile');
            Route::get('/{pathMatch}', 'index')->where('pathMatch', ".*");
        });
    });

    Route::prefix('users/course_spec')->group(function () {
        Route::controller(CourseSpecControllor::class)->group(function () {
            Route::get('/', 'index')->name('users.course_spec');
            Route::get('/subject_detail/{id}', 'index')->name('users.subject_detail');
            Route::get('/{pathMatch}', 'index')->where('pathMatch', ".*");
        });
    });
    Route::prefix('users/pdf')->group(function () {
        Route::controller(PDFController::class)->group(function () {
            Route::get('/{id}', 'index')->name('users.pdf');
            Route::get('export/{id}/{user_id}', 'export')->name('export.pdf');
            Route::get('/result', 'pdf_result')->name('users2.pdf');
            Route::get('/{pathMatch}', 'index')->where('pathMatch', ".*");
        });
    });
});
Route::middleware(['auth', 'role:3'])->group(function () {
    Route::get('president/home', [PresidentController::class, 'index'])->name('president.home');
    Route::prefix('president/profile')->group(function () {
        Route::controller(ProfileControllor::class)->group(function () {
            Route::get('/', 'index')->name('president.profile');
            Route::get('/{pathMatch}', 'index')->where('pathMatch', ".*");
        });
    });
    Route::prefix('president/course')->group(function () {
        Route::controller(CourseProgramController::class)->group(function () {
            Route::get('/', 'index')->name('president.course');
            Route::get('/course_detail/{id}', 'index')->name('president.course_detail');
            Route::get('/{pathMatch}', 'index')->where('pathMatch', ".*");
        });
    });
    Route::prefix('president/doc_report')->group(function () {
        Route::controller(DocumentReportController::class)->group(function () {
            Route::get('/', 'index')->name('president.document_report');
            Route::get('/doc_report_detail/{id}', 'doc_report_detail')->name('president.report_detail');
            Route::get('/{pathMatch}', 'index')->where('pathMatch', ".*");
        });
    });
    Route::prefix('president/teaching')->group(function () {
        Route::controller(DocumentReportController::class)->group(function () {
            Route::get('/', 'index')->name('president.teaching');
            Route::get('/teaching_detail/{id}', 'teaching_detail')->name('president.teaching_detail');
            Route::get('/{pathMatch}', 'index')->where('pathMatch', ".*");
        });
    });
});
Route::middleware(['auth', 'role:4'])->group(function () {
    Route::get('manager/home', [ManagerController::class, 'index'])->name('manager.home');

    Route::prefix('manager/doc_report')->group(function () {
        Route::controller(DocumentSummaryController::class)->group(function () {
            Route::get('/', 'index')->name('manager.document_report');
            Route::get('/doc_report_detail/{id}', 'index')->name('manager.report_detail');
            Route::get('/{pathMatch}', 'index')->where('pathMatch', ".*");
        });
    });
});
// Route::get('/admin', [HomeController::class, 'post'])->middleware(['auth', 'admin']);

require __DIR__ . '/auth.php';
