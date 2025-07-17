<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Group;
use App\Models\Professor;
use App\Models\Room;
use App\Models\Subject;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;
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
        $courses = Course::with(['group.section', 'professor', 'subject', 'room'])->get();
        $groups = Group::all();
        $professors = Professor::all();
        $subjects = Subject::all();
        $rooms = Room::all();
        $title = "Liste des cours";
        $page = "Calendrier des cours";
        return view('administrations.courses.index', compact('courses', 'title', 'page', 'professors', 'groups', 'rooms', 'subjects'));
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

        return view('administrations.courses.create', compact('title', 'page', 'subjects', 'rooms', 'professors', 'groups'));
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
        $messagesErrors = ['start_date' => ''];
        try {
            $inputDates = $this->checkDatesProfessor($request);
        } catch (ValidationException $e) {
            $messagesErrors['start_date'] .= 'Le professeur donne déjà des cours dans cette période <br>';
        }

        try {
            $inputDates = $this->checkDatesRoom($request);
        } catch (ValidationException $e) {
            $messagesErrors['start_date'] .= 'La salle est occupée dans cette période <br>';
        }

        try {
            $inputDates = $this->checkDatesGroup($request);
        } catch (ValidationException $e) {
            $messagesErrors['start_date'] .= 'Le groupe est déjà en cours dans cette période <br>';
        }


        $inputDates = $this->avoidClosedDays($request);

        if (!empty($messagesErrors['start_date'])) {
            throw ValidationException::withMessages($messagesErrors);
        }

        // Modifier la durée choisi en minutes
        $duration = floatval($request->duration) * 60 . "minutes";
        // Calculer l'heure fin à partir de l'heure du début choisi et la durée en minutes
        $heureFin = date('H:i', strtotime("$request->start_time + $duration"));
        $createdCourses  = [];

        if (count($inputDates)) {
            foreach ($inputDates as $date) {
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
                $createdCourses[] = $course;
            }
        }
        // else{
        //     return redirect()->back()->withErrors('Vérifier le jour ou les dates début et fin!');
        // }

        if (empty($createdCourses)) {
            throw ValidationException::withMessages(['start_date' => 'Aucun cours n\'a été créé car les dates sont hors du jour indiqué ou sur des jours fermés']);
        }

        return redirect()->route('courses.create')->with('success', 'Le cours a bien été ajouté');
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
        $page = 'Modifier cours';
        $title = 'Editer un cours';
        $course = Course::with('subject.professors', 'subject.groups')->find($id);
        $subjects = Subject::all();
        $rooms = Room::all();
        // $professors = Professor::all();
        // $groups = Group::all();

        return view('administrations.courses.edit', compact('title', 'page', 'course', 'subjects', 'rooms'));
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
        $course = Course::find($id);
        $data = $request->all();
        $messagesErrors = ['start_date' => ''];
        $attributes   = collect($data);
        $duration = floatval($attributes->get('duration')) * 60;
        $attributes['end_time'] = Carbon::parse($attributes->get('start_time'))->addRealMinutes($duration)->format('H:i');

        $toUpdate = [];
        $toUpdate[] = $course;

        $tempIdArr = [];
        $idtoverify = [];

        array_push($tempIdArr, $course->id);

        $fromDate = Carbon::createFromFormat('d/m/Y', $attributes->get('start_date'))->format('Y-m-d');
        $toDate = Carbon::createFromFormat('d/m/Y', $attributes->get('end_date'))->format('Y-m-d');
        $dayWeek = $attributes->get('weekday');
        $group = $attributes->get('group_id');
        $startTime = Carbon::createFromFormat('H:i', $attributes->get('start_time'));
        // $endTime = Carbon::createFromFormat('H:i', $attributes->get('end_time'));
        $prof = $attributes->get('professor_id');
        $room = $attributes->get('room_id');

        // Récuperer les cours qui ont les mêmes infos
        $toverify = $this->searchCoursesVerify($fromDate, $toDate, $dayWeek, $group, $startTime, $prof, $room);

        if (count($toverify) > 0) // s'il y en a
        {
            $verif = collect($toverify[0]);

            array_push($idtoverify, $verif['id']);
            // comparer les cours trouvé avec le cours actuel
            $hascommon = array_intersect($idtoverify, $tempIdArr);
            if (count($hascommon) <= 0) //
            {
                $idtoverif = [];
                $toverif = $this->searchCoursesVerify($fromDate, $toDate, $dayWeek, null, $startTime, null, $room);

                if (count($toverif) > 0) {
                    $ver = collect($toverif[0]);
                    array_push($idtoverif, $ver['id']);

                    $hascom = array_diff($idtoverif, $tempIdArr);
                    if (count($hascom) > 0) {
                        try {
                            $inputDates = $this->checkDatesRoom($request);
                        } catch (ValidationException $e) {
                            return redirect()->back()->with('error', 'La salle est occupée dans cette période');
                        }
                    }
                }

                $toverify2 = $this->searchCoursesVerify($fromDate, $toDate, $dayWeek, null, $startTime, $prof, null);
                $idtoverify2 = [];

                if (count($toverify2) > 0) {
                    $verif2 = collect($toverify[0]);
                    array_push($idtoverify2, $verif2['id']);

                    $hascommon2 = array_diff($idtoverify2, $tempIdArr);
                    if (count($hascommon2) > 0) {
                        try {
                            $inputDates = $this->checkDatesProfessor($request);
                        } catch (ValidationException $e) {
                            return redirect()->back()->with('error', 'Le professeur donne déjà des cours dans cette période');
                        }
                    }
                }

                $toverify3 = $this->searchCoursesVerify($fromDate, $toDate, $dayWeek, $group, $startTime, null, null);
                $idtoverify3 = [];

                if (count($toverify3) > 0) {
                    $verif3 = collect($toverify[0]);
                    array_push($idtoverify3, $verif3['id']);

                    $hascommon3 = array_diff($idtoverify3, $tempIdArr);
                    if (count($hascommon3) > 0) {
                        try {
                            $inputDates = $this->checkDatesGroup($request);
                        } catch (ValidationException $e) {
                            return redirect()->back()->with('error', 'Le groupe est déjà en cours dans cette période');
                        }
                    }
                }
            }
        }

        $fromDate = $toUpdate[0]['date'];
        $toDate = $toUpdate[count($toUpdate)  - 1]['date'];
        $dayWeek = $toUpdate[0]['weekday'];
        $group = $toUpdate[0]['group_id'];
        $startTime = $toUpdate[0]['start_time'];
        $endTime = $toUpdate[0]['end_time'];
        $prof = $toUpdate[0]['professor_id'];
        $room = $toUpdate[0]['room_id'];
        $subject = $toUpdate[0]['subject_id'];

        $inputDates = $this->avoidClosedDays($request);
        // dd($inputDates);
        $allcourse = $this->searchGroupedCoursesLimited($fromDate, $toDate, $dayWeek, $group, $startTime, $subject, $prof, $room);
        if (count($allcourse) > 0) {
            $coursessources = collect($allcourse[0]);

            if (count($inputDates) == 1) {
                $attributes['date'] = $inputDates[0];
                $course = Course::find($coursessources['id']);
                if ($attributes['group_id'] != $course->group_id) {
                    $attributes['absences_checked'] = false;
                }
                $course->update($attributes->toArray());
                return redirect()->route('courses.index')->with('success', 'Le cours a bien été modifié.');
            } else {
                return redirect()->back()->with('error', 'Aucun cours n\'a été créé car les dates sont hors du jour indiqué ou sur des jours fermés');
            }
        }

        return redirect()->route('courses.index')->with('success', 'Le cours a bien été modifié');
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
    private function getDatesForDay($request)
    {
        $attributes = collect($request->all());
        $started_on = Carbon::createFromFormat('d/m/Y', $attributes->pull('start_date'));
        if (mb_strtolower($started_on->format('l')) != mb_strtolower($attributes->get('weekday'))) {
            $started_on = date('Y-m-d', strtotime("next " . mb_strtolower($attributes->get('weekday')), strtotime($started_on->format('Y-m-d'))));
        } else {
            $started_on = $started_on->format('Y-m-d');
        }

        $ended_on = Carbon::createFromFormat('d/m/Y', $attributes->pull('end_date'))->format('Y-m-d');

        $period   = CarbonPeriod::create($started_on, CarbonInterval::week(), $ended_on);
        $dates    = $period->toArray();
        foreach ($dates as $key => $date) {
            $dates[$key] = $date->format('Y-m-d');
        }

        return $dates;
    }

    // Vérifier si le prof a des cours
    public function checkDatesProfessor($request, $throw = TRUE)
    {
        $inputDates       = $this->getDatesForDay($request);
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
        return Course::where('professor_id', $professor_id)->get();
    }
    // Vérifier l'heure
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
                            throw ValidationException::withMessages(['start_date' => $message]);
                        }

                        return $message;
                    }
                }
            }
        }

        return TRUE;
    }
    // Vérifier si la salle est dispo
    public function checkDatesRoom($request, $throw = TRUE)
    {
        $inputDates  = $this->getDatesForDay($request);
        $roomCourses = Course::where('room_id', $request->get('room_id'))->get();
        $roomDates   = [];
        foreach ($roomCourses as $value) {
            $roomDates[] = $value->date;
        }

        $commonDates = array_intersect($inputDates, $roomDates);
        if (!empty($commonDates)) {
            $this->checkHours($request, $roomCourses, $commonDates, 'La salle est occupée dans cette période', $throw);
        }

        return $inputDates;
    }
    // Vérifier si le groupe à déjà un cours
    public function checkDatesGroup($request, $throw = TRUE)
    {
        $inputDates   = $this->getDatesForDay($request);
        $groupCourses = Course::where('group_id', $request->get('group_id'))->get();
        $groupDates   = [];
        foreach ($groupCourses as $value) {
            $groupDates[] = $value->date;
        }

        $commonDates = array_intersect($inputDates, $groupDates);
        if (!empty($commonDates)) {
            $this->checkHours($request, $groupCourses, $commonDates, 'Le groupe a déjà des cours dans cette période', $throw);
        }

        return $inputDates;
    }

    public function avoidClosedDays($request, $dayType = NULL)
    {
        $inputDates         = $this->getDatesForDay($request);
        $switchedInputdates = array_flip($inputDates);

        if ((is_array($dayType) && in_array('generalHoliday', $dayType)) || $dayType == 'generalHoliday' || is_null($dayType)) {
            $generalHolidays = Carbon::getGeneralHolidays();
            $commonDates    = array_intersect($inputDates, $generalHolidays);
            if (!empty($commonDates)) {
                foreach ($commonDates as $commonDate) {
                    unset($switchedInputdates[$commonDate]);
                }
            }
        }
        if ((is_array($dayType) && in_array('schoolHoliday', $dayType)) || $dayType == 'schoolHoliday' || is_null($dayType)) {
            $schoolHolidays = Carbon::getSchoolHolidays();
            $commonDates    = array_intersect($inputDates, $schoolHolidays);
            if (!empty($commonDates)) {
                foreach ($commonDates as $commonDate) {
                    unset($switchedInputdates[$commonDate]);
                }
            }
        }
        if ((is_array($dayType) && in_array('specialDay', $dayType)) || $dayType == 'specialDay' || is_null($dayType)) {
            $specialDays = Carbon::getSpecialDays();
            $commonDates = array_intersect($inputDates, $specialDays);
            if (!empty($commonDates)) {
                foreach ($commonDates as $commonDate) {
                    unset($switchedInputdates[$commonDate]);
                }
            }
        }

        $inputDates = array_flip($switchedInputdates);
        return $inputDates;
    }

    // Recherche cours ajax
    public function chercheCourse(Request $request)
    {
        $query = Course::query();
        $hasFilters = false;
        if ($request->filled('date_debut') && $request->filled('date_fin')) {
            $hasFilters = true;
            $dateDebut = Carbon::createFromFormat('d/m/Y', $request->date_debut)->startOfDay()->format('Y-m-d');
            $dateFin = Carbon::createFromFormat('d/m/Y', $request->date_fin)->startOfDay()->format('Y-m-d');
            $query->whereBetween('date', [
                $dateDebut,
                $dateFin
            ]);
        } elseif ($request->filled('date_debut')) {
            $hasFilters = true;
            $dateDebut = Carbon::createFromFormat('d/m/Y', $request->date_debut)->startOfDay()->format('Y-m-d');
            $query->where('date', '>=', $dateDebut);
        } elseif ($request->filled('date_fin')) {
            $hasFilters = true;
            $dateFin = Carbon::createFromFormat('d/m/Y', $request->date_fin)->startOfDay()->format('Y-m-d');
            $query->where('date', '<=', $dateFin);
        }

        // Autres filtres
        $filters = [
            'start_time' => '=',
            'weekday' => '=',
            'professor_id' => '=',
            'group_id' => '=',
            'room_id' => '=',
            'subject_id' => '='
        ];

        foreach ($filters as $key => $operator) {
            if ($request->filled($key)) {
                $hasFilters = true;
                $query->where($key, $operator, $request->$key);
            }
        }
        if (!$hasFilters) {
            return [];
        }
        $query->with(['room', 'subject', 'group', 'professor']);
        $results = $query->get();
        return $results;
    }

    // Vérifier le cours à modifier
    public function searchCoursesVerify($fromDate, $toDate, $dayWeek, $group, $startTime, $prof, $room)
    {
        $searchQuery = Course::selectRaw('MIN(courses.id) AS id, MIN(courses.date) AS date, group_id, subject_id, room_id, professor_id, weekday, start_time, end_time, duration')
            ->when(!is_null($fromDate), function ($query) use ($fromDate) {
                return $query->whereDate('date', '>=', $fromDate);
            })->when(!is_null($group), function ($query) use ($group) {
                return $query->where('group_id', intval($group));
            })->when(!is_null($toDate), function ($query) use ($toDate) {
                return $query->whereDate('date', '<=', $toDate);
            })->when(!is_null($dayWeek), function ($query) use ($dayWeek) {
                return $query->where('weekday', strtolower($dayWeek));
            })->when(!is_null($startTime), function ($query) use ($startTime) {
                return $query->whereTime('start_time', '<=', $startTime)->whereTime('end_time', '>=', $startTime);
            })->when(!is_null($prof), function ($query) use ($prof) {
                return $query->where('professor_id', intval($prof));
            })->when(!is_null($room), function ($query) use ($room) {
                return $query->where('room_id', intval($room));
            });

        return $searchQuery->orderBy('date', 'desc')->groupBy('group_id', 'subject_id', 'room_id', 'professor_id', 'weekday', 'start_time', 'end_time', 'duration')->get();
    }

    public function searchGroupedCoursesLimited($fromDate, $toDate, $dayWeek, $group, $startTime, $subject, $prof, $room)
    {
        $searchQuery = Course::selectRaw('MIN(courses.id) AS id, MIN(courses.date) AS date, group_id, subject_id, room_id, professor_id, weekday, start_time, end_time, duration')
            ->when(!is_null($fromDate), function ($query) use ($fromDate) {
                return $query->whereDate('date', '>=', $fromDate);
            })->when(!is_null($group), function ($query) use ($group) {
                return $query->where('group_id', intval($group));
            })->when(!is_null($toDate), function ($query) use ($toDate) {
                return $query->whereDate('date', '<=', $toDate);
            })->when(!is_null($dayWeek), function ($query) use ($dayWeek) {
                return $query->where('weekday', strtolower($dayWeek));
            })->when(!is_null($startTime), function ($query) use ($startTime) {
                return $query->whereTime('start_time', '<=', $startTime)->whereTime('end_time', '>=', $startTime);
            })->when(!is_null($prof), function ($query) use ($prof) {
                return $query->where('professor_id', intval($prof));
            })->when(!is_null($room), function ($query) use ($room) {
                return $query->where('room_id', intval($room));
            });

        return $searchQuery->orderBy('date', 'desc')->groupBy('group_id', 'subject_id', 'room_id', 'professor_id', 'weekday', 'start_time', 'end_time', 'duration')->get();
    }
}
