<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Group;
use App\Models\Professor;
use App\Models\Room;
use App\Models\Subject;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use IntlDateFormatter;

class CoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Création cours";
        $page = "Cours";
        $subjects = Subject::all();
        $rooms = Room::all();
        $professors = Professor::all();
        $groups = Group::all();
        $weekdays = [];
        $formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::NONE);
        $formatter->setPattern('EEEE');

        // Créer un tableau des jours (du lundi au dimanche)
        $date = new DateTime('next Monday'); // Commence par lundi
        for ($i = 0; $i < 5; $i++) {
            $weekdays[] = $formatter->format($date);
            $date->modify('+1 day');
        }

        return view('administrations.courses.create',compact('title','page','subjects','rooms','professors','groups','weekdays'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "subject_id" => "required",
            "professor_id" => "required",
            "room_id" => "required",
            "group_id" => "required",
            "weekday" => "required",
            "start_time" => "required",
            "duration" => "required",
            "start_date" => "required",
            "end_date" => "required"
        ]);
        // Modifier la durée choisi en minutes
        $duration = floatval($request->duration)*60 ."minutes";
        // Calculer l'heure fin à partir de l'heure du début choisi et la durée en minutes
        $heureFin = date('H:i', strtotime("$request->start_time + $duration"));
        // Récupérer les dates à partir du jour , date début et date fin séléctionnés
        $dates = $this->getDatesForDay($request->weekday,$request->start_date,$request->end_date);
        
        if(count($dates)){
            foreach($dates as $date){
                $course = new Course();
                $course->subject_id = $request->subject_id;
                $course->professor_id = $request->professor_id;
                $course->room_id = $request->room_id;
                $course->group_id = $request->group_id;
                $course->weekday = $request->weekday;
                $course->start_time = $request->start_time;
                $course->end_time = $heureFin;
                $course->date = $date;
                $course->duration = $request->duration;
                $course->save();
            }
        }else{
            return redirect()->back()->withErrors('Vérifier le jour ou les dates début et fin!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // Récuperer le jour choisi entre deux dates
    private function getDatesForDay($day, $startDate, $endDate) {        
        $targetDay = $day;
        $start = new DateTime($startDate);
        $end = new DateTime($endDate);
        
        // Trouver le premier jour cible après la date de début
        $current = clone $start;
        $currentDay = (int)$current->format('N');
        
        // Calculer le décalage nécessaire
        $offset = ($targetDay - $currentDay + 7) % 7;
        $current->modify("+$offset days");
        
        // Générer la liste des dates
        $dates = [];
        while ($current <= $end) {
            $dates[] = $current->format('Y-m-d');
            $current->modify('+7 days');
        }
        
        return $dates;
    }

    // Vérifier si le prof a des cours
    public function checkDatesProfessor($request, $throw = TRUE)
    {
        $inputDates       = $this->getDatesForDay($request->weekday,$request->start_date,$request->end_date);
        $professorCourses = $this->getCoursesOfProfessor($request->professor_id);
        $professorDates   = [];
        foreach ($professorCourses as $value) {
            $professorDates[] = $value->date;
        }

        $commonDates = array_intersect($inputDates, $professorDates);

        if (!empty($commonDates)) {
            $this->checkHours($request, $professorCourses, $commonDates, 'Le professeur donne déjà des cours dans cette période', $throw);
        }

        return $inputDates;
    }

    public function getCoursesOfProfessor($professor_id)
    {
        return Course::where('professor_id',$professor_id)->get();
    }

    public function checkHours($request, $entityCourses, $commonDates, $message, $throw = TRUE)
    {
        $inputStartTime = Carbon::createFromFormat('H:i', $request->start_time);
        $inputEndTime   = Carbon::createFromFormat('H:i', $request->start_time)->addHours($request->duration);
        if ($entityCourses->isNotEmpty()) {
            foreach ($entityCourses as $entityCourse) {
                $entiDateStartTime = Carbon::createFromFormat('H:i:s', $entityCourse->start_time);
                $entiDateEndTime   = Carbon::createFromFormat('H:i:s', $entityCourse->end_time);
                if (in_array($entityCourse->date, $commonDates)) {
                    if (!(($inputStartTime < $entiDateStartTime && $inputEndTime <= $entiDateStartTime) || $inputStartTime >= $entiDateEndTime)) {
                        if ($throw) {
                            throw ValidationException::withMessages(['started_on' => $message]);
                        }

                        return $message;
                    }
                }
            }
        }

        return TRUE;
    }
}
