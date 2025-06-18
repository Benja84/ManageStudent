<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Professor;
use App\Models\ProfessorSubject;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ProfessorsController extends Controller
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
        $title = "Ajouter un prof";
        $page = "Prof";
        $subjects = Subject::all();
        $groups = Group::with('section')->where('school_year', 'LIKE', '%' . date('Y') . '%')->get();
        return view('administrations.professors.create',compact('title','page','subjects','groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // Valide les données du formulaire
            $validated = $request->validate([
                'gender' => 'required|in:M,F',
                'last_name' => 'required|string|max:255',
                'first_name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'email' => 'required|email|unique:users,email',
                'birth_date' => 'required|date',
                'birth_place' => 'required|string|max:255',
                'nationality' => 'required|string|max:100',
                'address' => 'required|string|max:255',
                'city' => 'required|string|max:100',
                'zip_code' => 'required|string|max:20',
                // 'country' => 'required|string|max:100',
            ]);
            // dd($request);

            // Prépare les données validées
            $user = new User();
            $user->gender = $validated['gender'];
            $user->firstname = $validated['first_name'];
            $user->lastname = $validated['last_name'];
            $user->birthdate = $validated['birth_date'];
            $user->birthplace_city = $validated['birth_place'];
            // $user->nationality = $validated['nationality'];
            $user->address_street = $validated['address'];
            $user->address_city = $validated['city'];
            $user->address_postcode = $validated['zip_code'];
            // $user->country = $validated['country'];
            $user->phone = $validated['phone'] ?? null;
            $user->email = $validated['email'];
            $user->password = Hash::make('school123');

            // $password = Hash::make('school123');
            // $user->password = $password;

            $user->save();
            $user->assignRole('professor');
            // Associe l'ID de l'utilisateur authentifié
            $data = [
                'user_id' => $user->id,
                'comments' => $validated['comments'] ?? null,

            ];

            // if ($request->hasFile('photo')) {
            //     $data['photo'] = $request->file('photo')->store('professors', 'public');
            // }

            // Crée un nouveau professeur avec les données
            $prof = Professor::create($data);
            if($request->group_id){
                $prof->groups()->attach($request->group_id);
            }
            if($request->subject_id){
                $prof->subjects()->syncWithoutDetaching($request->subject_id);
            }
            // Redirige vers la liste des professeurs avec un message de succès
            // return redirect()->route('professors.index')->with('success', 'Professeur ajouté avec succès');
            return $prof;
        } catch (\Exception $e) {
            // Enregistre l'erreur dans les logs
            Log::error('Error in store: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            // Retourne à la page précédente avec un message d'erreur
            return back()->withErrors(['error' => 'Une erreur est survenue lors de l\'enregistrement.'])->withInput();
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

    public function getProfSubject($id){
        $subjects = ProfessorSubject::with('professor','subject.groups.section')->where('subject_id',$id)->get();
        return $subjects;
    }
}
