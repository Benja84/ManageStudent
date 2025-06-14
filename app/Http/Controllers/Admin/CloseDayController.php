<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CloseDay;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CloseDayController extends Controller
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
        $title = "Jours fermés";
        $page = "Jours fermés";
        $closed_days = CloseDay::orderBy('date','desc')->get();

        return view('administrations.closedays.create', compact('title','page','closed_days'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $attributes = collect($request->all());
         $period = CarbonPeriod::create(Carbon::createFromFormat('d/m/Y',$attributes['start_date']),Carbon::createFromFormat('d/m/Y',$attributes['end_date']));
         $dates = $period->toArray();
         foreach ($dates as $date) {
            $closeday = CloseDay::where('date',$date->format('Y-m-d'))->first();
            if($closeday){
                $closeday->type = $attributes['type'];
                $closeday->description = $attributes['description'];
                $closeday->save();
            }else{
                CloseDay::create([
                    'date' => $date->format('Y-m-d'),
                    'type' => $attributes['type'],
                    'description' => $attributes['description']
                ]);
            }
        }

        return redirect()->route('closedays.create')->with('success', 'Les dates ont bien été ajoutées');
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
        $closed_day = CloseDay::find($id);
        $closed_day->delete();
        return redirect()->route('closedays.create')->with('success', 'Element supprimé avec succès.');
    }
}
