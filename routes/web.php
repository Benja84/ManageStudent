<?php

use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\ProfileController;
use App\Models\Course;
use Illuminate\Support\Facades\Route;

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
// voire profile
Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show');


Route::get('/dashboard', function () {
    $courses = Course::all();
    return view('dashboard',compact('courses'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    // Route::resource('/roles',RoleController::class);
    // Route::resource('/permissions',PermissionController::class);
    Route::resource('/students', StudentController::class);
    Route::resource('professors', ProfessorController::class);
});

// Route::middleware(['auth'])->group(function () {
//     // Affiche la liste des professeurs
//     Route::get('/professors', [ProfessorController::class, 'index'])->name('professors.index');
//     // Affiche le formulaire de création d'un professeur
//     Route::get('/professors/create', [ProfessorController::class, 'create'])->name('professors.create');
//     // Enregistre un nouveau professeur
//     Route::post('/professors', [ProfessorController::class, 'store'])->name('professors.store');
//     // Met à jour un professeur existant
//     Route::put('/professors/{id}', [ProfessorController::class, 'update'])->name('professors.update');
//     // Supprime un professeur
//     Route::delete('/professors/{id}', [ProfessorController::class, 'destroy'])->name('professors.destroy');
// });

Route::get('/professeurs', [ProfessorController::class, 'index'])->name('professors.index');
Route::get('/professeurs/ajouter', [ProfessorController::class, 'create'])->name('professors.create');
Route::post('/professeurs', [ProfessorController::class, 'store'])->name('professors.store');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
