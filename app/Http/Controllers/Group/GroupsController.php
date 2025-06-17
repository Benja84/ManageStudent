<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\GroupSubject;
use App\Models\Professor;
use App\Models\Section;
use App\Models\Subject;
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
        //
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
            'abbreviation' => 'required',
            'section_id' => 'required',
            'school_year' => 'required',
            'period_type' => 'required',
        ]);

        $yearAbbreviations = $this->getYearAbreviation($request->school_year);
        if(in_array($request->abbreviation,$yearAbbreviations->toArray())){
            return redirect()->back()->with('error', 'Ce groupe existe déjà pour cette année scolaire');
        }
        
        $group = Group::create($data);
        foreach ($request->subject_id as $key => $subject) {
            $groupsubject = new GroupSubject();
            $groupsubject->group_id = $group->id;
            $groupsubject->subject_id = $subject;
            $groupsubject->save();
        }
        if($request->coordinator_id){
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

    // Récuperer les abréviations d'une année scolaire
    public function getYearAbreviation($school_year){
        // dd($school_year);
        return Group::where('school_year',$school_year)->get()->pluck('abbreviation');
    }
}
