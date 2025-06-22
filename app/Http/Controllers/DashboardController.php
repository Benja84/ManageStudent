<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $courses = Course::with(['group.section','professor','subject','room'])->get();
        $title = "Emploie du temps";
        $page = "Tableau de bord";
        return view('dashboard', compact('courses','title','page'));
        
    }
}
