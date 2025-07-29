<?php

use App\Http\Controllers\Admin\CloseDayController;
use App\Http\Controllers\Admin\CoursesController;
use App\Http\Controllers\Admin\MembersController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProfessorsController;
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


Route::middleware(['auth', 'role:coordinator'])->group(function () {
    Route::get('groups-coordinator', [GroupsController::class,'indexForCoordinator'])->name('groups-coordinator.index');
    Route::get('groups-coordinator/{group}', [GroupsController::class,'showForCoordinator'])->name('groups-coordinator.show');
});
Route::group(['middleware' => 'role:admin|coordinator|professor|secretary'], function () {
    Route::resource('groups', GroupsController::class, ['only' => ['index','show']]);
    Route::resource('professors', ProfessorsController::class, ['only' => ['show']]);
});

Route::group(['middleware' => 'role:coordinator|professor'], function () {
    Route::get('my-courses',[CoursesController::class, 'getCourseByProf'])->name('prof.courses');
    Route::get('my-courses/today',[CoursesController::class, 'getTodayCourses'])->name('prof.courses_today');
});


require __DIR__ . '/auth.php';
