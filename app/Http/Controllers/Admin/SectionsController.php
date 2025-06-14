<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
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
        $sections = Section::all();
        $title = "Ajouter du sections";
        $page = "Membre";
        return view('administrations.sections.index', compact('sections', 'title', 'page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $attitudes = [
            'Montage Video',
            'SCIENCES ',
            ' LETTRES ',
            ' TECHNIQUE ',
            ' GESTION ',
            ' DROIT',
        ];
        $title = "Crée une section";
        $page = "Membre";

        return view('administrations.sections.create', compact('attitudes', 'title', 'page'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'abbreviation' => 'required|string|max:50',
            'promotion' => 'required|string|max:255',
            'niveau' => 'required|string|max:255',
            'year' => 'required|string|max:50',
            'pricing' => 'required|numeric|min:0',
        ]);

        Section::create($validated);

        return redirect()->route('sections.index')->with('success', 'Section créée avec succès');
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
    public function edit(Section $section)
    {
        $attitudes = [
            'Montage Video',
            'SCIENCES ',
            ' LETTRES ',
            ' TECHNIQUE ',
            ' GESTION ',
            ' DROIT',
        ];
        $title = "Editer setion";
        $page = "Membre";

        return view('administrations.sections.edit', compact('section', 'attitudes', 'title', 'page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Section $section)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'abbreviation' => 'required|string|max:50',
            'promotion' => 'required|string|max:255',
            'year' => 'required|string|max:50',
            'niveau' => 'required|string|max:255',
            'pricing' => 'required|numeric|min:0',
        ]);

        $section->update($validated);

        return redirect()->route('sections.index')->with('success', 'Section mise à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
        $section->delete();
        return redirect()->route('sections.index')->with('success', 'Section supprimée avec succès');
    }
}
