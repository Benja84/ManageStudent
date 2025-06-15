<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\SectionSubject;
use App\Models\Subject;
use Illuminate\Http\Request;

class SectionsController extends Controller
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
        $title = "Ajouter une section";
        $page = "Sections";
        $subjects = Subject::all();

        return view('administrations.sections.create',compact('title','page','subjects'));
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
            'name' => 'required',
            'abbreviation' => 'required',
            'promotion' => 'required',
            'subject_id' => 'required'
        ]);

        $section = Section::create($request->all());
        foreach ($request->subject_id as $key => $subject) {
            SectionSubject::create([
                'section_id' => $section->id,
                'subject_id' => $subject,
            ]);
        }

        return redirect()->route('sections.create')->with('success','Section créé avec succés');
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

    public function getSubject($id){
        $subjects = SectionSubject::with('subject')->where('section_id',$id)->get();
        return $subjects;
    }
}
