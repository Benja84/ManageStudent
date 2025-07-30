<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\GroupSubject;
use App\Models\Professor;
use App\Models\Section;
use App\Models\StudentGroupHistory;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class GroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Liste des parcours";
        $page = "Liste des parcours";
        $groups = Group::with('section')->get();
        return view('groups.index',compact('title','page','groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Ajouter un parcours";
        $page = "Parcours";
        $sections = Section::all();
        $professors = Professor::all();
        $subjects = Subject::all();
        return view('groups.create',compact('title','page','sections','subjects','professors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $data = $request->validate([
            'abbreviation' => 'min:1|max:50|string|unique:groups,abbreviation',
            'section_id'   => 'required|integer',
            'school_year'  => 'required|min:9|max:9',
            'period_type'  => 'required|in:trimestre,semestre',
        ]);

        $yearAbbreviations = $this->getYearAbreviation($request->school_year);
        if(in_array($request->abbreviation,$yearAbbreviations->toArray())){
            return redirect()->back()->with('error', 'Ce parcours existe déjà pour cette année scolaire');
        }
        
        $group = Group::create($data);
        if($request->subject_id ){
            $group->subjects()->syncWithoutDetaching($request->subject_id);
                
        }
        if($request->coordinator_id){
            $group->coordinators()->attach($request->coordinator_id, ['status' => 'Coordinateur']);
            foreach ($request->coordinator_id as $prof_id){
                $prof = Professor::find($prof_id);
                $prof->user->assignRole('coordinator');
            }
        }
        
        return redirect()->route('groups.index')->with('success','Le parcours <a href="' . route('groups.show', $group->id) . '">' . $group->abbreviation . '</a> a bien été ajouté');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $group = Group::with('courses.group.section','courses.professor','courses.subject','courses.room')->find($id);
        $title = "Parcours ".$group->abbreviation;
        $page = "Editer un parcours";
        $sections = Section::all();
        return view('groups.show',compact('title','page','sections','group'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = "Editer un parcours";
        $page = "Editer un parcours";
        $sections = Section::with('subjects')->get();
        $professors = Professor::all();
        $group = Group::with('coordinators','subjects')->find($id);
    
        return view('groups.edit',compact('title','page','sections','professors','group'));
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
        $data = $request->validate([
            'abbreviation' => ['min:1','max:50','string',Rule::unique('groups')->ignore($id)],
            'section_id'   => 'required|integer',
            'school_year'  => 'required|min:9|max:9',
            'period_type'  => 'required|in:trimestre,semestre',
        ]);

        $group = Group::find($id);
        $group->update($data);
        GroupSubject::where('group_id',$id)->delete();
        if ($request->subject_id && is_array($request->subject_id)) {
            $group->subjects()->syncWithoutDetaching($request->subject_id);
        }

        $oldUserIds = $group->coordinators->pluck('user_id')->filter()->toArray();
        $group->coordinators()->detach();
        // Révoque les rôles des anciens coordinateurs

        if (!empty($oldUserIds)) {
            // 1. Trouver les users qui sont encore coordinateurs dans d'autres parcours
            $usersStillCoordinators = DB::table('groupables')
                ->join('professors', 'professors.id', '=', 'groupables.groupable_id')
                ->where('groupables.groupable_type', Professor::class)
                ->where('groupables.status', 'Coordinateur')
                ->where('groupables.group_id', '<>', $group->id)
                ->whereIn('professors.user_id', $oldUserIds)
                ->pluck('professors.user_id')
                ->unique()
                ->toArray();

            // 2. Calculer les users à qui retirer le rôle
            $usersToRevoke = array_diff($oldUserIds, $usersStillCoordinators);

            // 3. Retirer le rôle uniquement à ceux qui ne sont plus coordinateurs ailleurs
            User::whereIn('id', $usersToRevoke)
                ->each(function ($user) {
                    $user->removeRole('coordinator');
                });
        }

        if($request->coordinator_id){
            $group->coordinators()->attach($request->coordinator_id, ['status' => 'Coordinateur']);
            foreach ($request->coordinator_id as $prof_id){
                $prof = Professor::find($prof_id);
                $prof->user->assignRole('coordinator');
            }
        }

        return redirect()->route('groups.index')->with('success','Goupe modifié avec succés!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = Group::find($id);
        GroupSubject::where('group_id',$group->id)->delete();
        if($group->delete()){
            return redirect()->route('groups.index')->with('success', 'Le parcours  a bien été supprimé');
        }
        return redirect()->route('groups.index')->with('error', 'Problème. Le parcours n\'a pas été supprimé');
    }

    // Récuperer les abréviations d'une année scolaire
    public function getYearAbreviation($school_year){
        return Group::where('school_year',$school_year)->get()->pluck('abbreviation');
    }

    public function indexForCoordinator()
    {
        $coordinator = TRUE;
        $title = "Liste des parcours";
        $page = "Liste des parcours";
        // $groupsRoute = explode('.', Route::current()->getName())[0];

        $groups = auth()->user()->professor->groupsCoordinator()->orderBy('groups.school_year', 'desc')->get();
        

        return view('groups.index', compact('title','page','groups', 'coordinator'));
    }

    public function showForCoordinator(Group $group)
    {
        if (auth()->user()->professor->groupsCoordinator->contains($group)) {
            $historyGroupStudent = StudentGroupHistory::where('group_id',$group->id)->get();
            // dd($history[0]->group->school_year);
            foreach($group->students as $student){
                foreach ($historyGroupStudent as $key => $value) {
                    if($student->id == $value->student->id){
                        unset($historyGroupStudent[$key]);
                    }
                }
            }
            return $this->view('show', compact('group','historyGroupTrainee'));
        }

        return abort(401, 'Accès non authorisé');
    }
}
