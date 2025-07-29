<?php

use App\Http\Controllers\Admin\CloseDayController;
use App\Http\Controllers\Admin\CoursesController;
use App\Http\Controllers\Admin\MembersController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\SectionsController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Course\StudentCoursesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Group\GroupsController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\ProfileController;
use App\Models\Course;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Auth;



Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/my_courses', [StudentCoursesController::class, 'index'])->name('student.courses');
    Route::get('/my_courses/aujourdhui', [StudentCoursesController::class, 'index'])->name('student.course_today');
});
Route::group(['middleware' => 'role:admin|coordinator|student|secretary'], function () {
    Route::resource('students', StudentController::class, ['only' => ['show']]);
});


require __DIR__ . '/auth.php';
