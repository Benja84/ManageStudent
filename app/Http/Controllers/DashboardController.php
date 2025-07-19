<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Group;
use App\Models\Professor;
use App\Models\Room;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $courses = Course::with(['group.section','professor','subject','room'])->get();
        $title = "Emploie du temps";
        $page = "Tableau de bord";
        $students = count(Student::all());
        $professors = count(Professor::all());
        $groups = count(Group::all());
        $subjects = count(Subject::all());
        $sections = count(Section::all());
        $rooms = count(Room::all());
        return view('dashboard', compact('courses','title','page','students','professors','groups','subjects','sections','rooms'));
        
    }
}
