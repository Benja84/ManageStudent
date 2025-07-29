<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Professor;
use App\Models\Room;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StudentCoursesController extends Controller
{
    public function index(){
        $today = Str::endsWith(request()->path(), 'aujourdhui');
        $groups = request()->user()->student->groups;
        $courses = $this->getCoursesOfGroups(
            request('groupBy', $groups->sortBy('school_year')->pluck('id')->last()),
            $today
        );
        $professors = $groups ? $groups[0]->professors : [];
        $subjects = $groups ? $groups[0]->subjects : [];
        $rooms = Room::all();

        return view('administrations.courses.index', [
            'title' => $today ? 'Cours d\'aujourd\'hui' : 'Tous mes cours',
            'page' => 'Mes cours',
            'courses' => $courses,
            'groups' => $groups,
            'rooms' => $rooms,
            'subjects' => $subjects,
            'professors' => $professors,
        ]);
    }

    public function getCoursesOfGroups($group_ids,$today = false){
        $query =  Course::query();
        $query->with(['group.section','professor','subject','room']);
        $query->where('group_id',$group_ids);
        if($today){
            $query->where('date', now()->format('Y-m-d'));
        }

        return $query->get();
    }
}
