<?php

use App\Http\Controllers\Admin\CoursesController;
use App\Http\Controllers\Admin\MembersController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProfessorsController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RoomsController;
use App\Http\Controllers\Admin\SectionsController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Group\GroupsController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\ProfileController;
use App\Models\Course;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Auth;

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
    if (Auth::check()) {
        return redirect()->route('dashboard'); // redirect raha authentifié
    }
    return redirect()->route('login'); // redirect raha tsy authentifié
    //return view('welcome');
});

// voire profile
// Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show');


Route::get('/dashboard', function () {
    $courses = Course::all();
    $title = "Emploie du temps";
    $page = "Tableau de bord";
    return view('dashboard', compact('courses', 'title', 'page'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:admin'])->group(function () {
    // Route::resource('/roles',RoleController::class);
    // Route::resource('/permissions',PermissionController::class);
    Route::resource('/students', StudentController::class);
    Route::resource('/members', MembersController::class);
    Route::resource('/professors', ProfessorsController::class);
    Route::resource('/courses', CoursesController::class);
    Route::resource('/subjects', SubjectController::class);
    Route::resource('/sections', SectionsController::class);
    Route::resource('/rooms', RoomsController::class);
    Route::get('/members/export/pdf', [MembersController::class, 'exportPDF'])->name('members.export.pdf');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('/groups', GroupsController::class);
});
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');



require __DIR__ . '/auth.php';
