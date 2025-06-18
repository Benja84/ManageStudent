<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // Affiche la liste des matières
    public function index()
    {
        $subjects = Subject::all(); // Récupère toutes les matières
        $title = "Liste des matières";
        $page = "Membre";
        return view('administrations.subjects.index', compact('subjects', 'title', 'page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // Affiche le formulaire de création
    public function create()
    {
        $title = "Ajouter un matiere";
        $page = "Membre";
        return view('administrations.subjects.create', compact('title', 'page'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    // Enregistre une nouvelle matière
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'abbreviation' => 'required|string|max:255',
        ]);

        // Enregistrement
        Subject::create($request->all());

        return redirect()->route('subjects.index')->with('success', 'Matière ajoutée avec succès.');
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

    // Affiche le formulaire d'édition
    public function edit(Subject $subject)
    {
        $title = "Modifier la matiere";
        $page = "Membre";
        return view('administrations.subjects.edit', compact('subject', 'title', 'page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // Met à jour une matière
    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'abbreviation' => 'required|string|max:255',
        ]);


        $subject->update($request->all());

        return redirect()->route('subjects.index')->with('success', 'Matière mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // Supprime une matière
    public function destroy(Subject $subject)
    {
        $subject->delete();

        return redirect()->route('subjects.index')->with('success', 'Matière supprimée avec succès.');
    }

    public function getProf($id){
        return Subject::with('professors','groups.section')->find($id);
    }
}
