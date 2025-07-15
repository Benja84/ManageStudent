<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = Room::all();
        $title = "Listes des salles";
        $page = "Membre";
        return view('administrations.rooms.index', compact('rooms', 'title', 'page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Ajouter une salle";
        $page = "Salle";
        return view('administrations.rooms.create', compact('title', 'page'));
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
            'name' => 'required',
            'number' => 'required|numeric',
            'department' => 'required',
            'floor' => 'required|numeric',
            'seating_capacity' => 'required|numeric',
        ]);

        Room::create($request->all());
        return redirect()->route('rooms.index')->with('success', 'Salle ajoutée avec succès.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        $title = "Voire salles";
        $page = "Membre";
        return view('administrations.rooms.show', compact('room', 'title', 'page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        $title = "Modifier la matiere";
        $page = "Membre";
        return view('administrations.rooms.edit', compact('room', 'title', 'page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        $request->validate([
            'name' => 'required|unique:rooms,name,' . $room->id,
            'number' => 'nullable|string',
            'department' => 'nullable|string',
            'floor' => 'nullable|integer',
            'seating_capacity' => 'nullable|integer',
            'material_capacity' => 'nullable|integer',
            'computer_type' => 'nullable|string',
        ]);
        $room->update($request->all());
        return redirect()->route('rooms.index')->with('success', 'Salle modifiée avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'Salle supprimée.');
    }
}
