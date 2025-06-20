<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\GroupSubject;
use App\Models\Professor;
use App\Models\Section;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
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
        $title = "Liste groupe";
        $page = "Liste des groupes";
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
        $title = "Ajouter une groupe";
        $page = "Groupe";
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
            return redirect()->back()->with('error', 'Ce groupe existe déjà pour cette année scolaire');
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
        
        return redirect()->route('groups.index')->with('success','Le groupe <a href="' . route('groups.show', $group->id) . '">' . $group->abbreviation . '</a> a bien été ajouté');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = "Editer un groupe";
        $page = "Editer un groupe";
        $sections = Section::all();
        $group = Group::find($id);
        return view('groups.edit',compact('title','page','sections','group'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = "Editer un groupe";
        $page = "Editer un groupe";
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

        $coordinators = $group->coordinators();
        if ($coordinators->count() > 0) {
            foreach ($coordinators as $coordinator) {
                User::getById($coordinator->user_id)->revokeGroup('coordinators');
            }
        }
        $group->coordinators()->detach();

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
        //
    }

    // Récuperer les abréviations d'une année scolaire
    public function getYearAbreviation($school_year){
        // dd($school_year);
        return Group::where('school_year',$school_year)->get()->pluck('abbreviation');
    }
}
