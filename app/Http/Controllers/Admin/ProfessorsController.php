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
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfessorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Liste des professeurs";
        $page = "Professeurs";
        $profs = Professor::all();
        return view('administrations.professors.index',compact('title','page','profs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Ajouter un professeur";
        $page = "Professeur";
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
                'lastname' => 'required|string|max:255',
                'firstname' => 'required|string|max:255',
                'phone' => 'required|string|max:20|unique:users,phone',
                'email' => 'required|email|unique:users,email',
                'birthdate' => 'required|date',
                'birthplace_city' => 'required|string|max:255',
                'address_street' => 'required|string|max:255',
                'address_city' => 'required|string|max:255',
                'address_postcode' => 'required|string|max:20',
            ]);

            // Prépare les données validées
            $validated['password'] = Hash::make(strtolower($request->firstname).'school123');
            if ($request->hasFile('photo')) {
                $request->validate([
                    'photo' => 'image|mimes:jpeg,png|max:20480',
                ]);
                $photoPath = $request->file('photo')->store('professors/photos', 'public');
                $validated['photo'] = $photoPath;
            }
            $user = User::create($validated);
            $user->assignRole('professor');
            // Associe l'ID de l'utilisateur créé
            $data = [
                'user_id' => $user->id,
                'comments' => $validated['comments'] ?? null,
            ];

            // Crée un nouveau professeur avec les données
            $prof = Professor::create($data);
            if($request->group_id){
                $prof->groups()->attach($request->group_id);
            }
            if($request->subject_id){
                $prof->subjects()->syncWithoutDetaching($request->subject_id);
            }
            // Redirige vers la liste des professeurs avec un message de succès
            return redirect()->route('professors.create')->with('success', 'Professeur ajouté avec succès');
            // return $prof;
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
        $prof = Professor::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = "Modification professeur";
        $page = "Professeur";
        $prof = Professor::find($id);
        $subjects = Subject::all();
        $groups = Group::with('section')->where('school_year', 'LIKE', '%' . date('Y') . '%')->get();

        return view('administrations.professors.edit',compact('title','page','prof','subjects','groups'));
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
        $prof = Professor::find($id);
        $validated = $request->validate([
            'gender' => 'required|in:M,F',
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'phone' => ['required','string','max:20',Rule::unique('users')->ignore($prof->user_id)],
            'email' => ['required','email',Rule::unique('users')->ignore($prof->user_id)],
            'birthdate' => 'required|date',
            'birthplace_city' => 'required|string|max:255',
            'address_street' => 'required|string|max:255',
            'address_city' => 'required|string|max:255',
            'address_postcode' => 'required|string|max:20',
            'nationality' => 'required|string',
            'country' => 'string',
        ]);
        if($prof->groups){
            $prof->groups()->detach();
        }
        if($request->group_id){
            $prof->groups()->attach($request->group_id);
        }
        ProfessorSubject::where('professor_id',$id)->delete();
        if($request->subject_id){
            $prof->subjects()->syncWithoutDetaching($request->subject_id);
        }

        if ($request->hasFile('photo')) {
            $request->validate([
                'photo' => 'image|mimes:jpeg,png|max:20480',
            ]);
            // Supprimer l’ancienne photo si elle existe
            if ($prof->user->photo && Storage::disk('public')->exists($prof->user->photo)) {
                Storage::disk('public')->delete($prof->user->photo);
            }
            $photoPath = $request->file('photo')->store('members/photos', 'public');
            $validated['photo'] = $photoPath;
        }
        $user = User::find($prof->user_id);
        $user->update($validated);

        return redirect()->route('professors.index')->with('success','Mise à jour du professeur avec succès!');
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
