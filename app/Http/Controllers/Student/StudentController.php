<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Advisor;
use App\Models\Group;
use App\Models\Professor;
use App\Models\Student;
use App\Models\StudentGroupHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Liste des étudiants";
        $page = "Etudiants";
        $students = Student::all();

        return view('students.index', compact('title','page','students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Création d'étudiant";
        $page = "Etudiants";
        $groups = Group::all();
        $professors = Professor::all();
        $advisors = Advisor::all();
        return view('students.create',compact('title','page','groups','professors','advisors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $data = $request->validate([
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
            'nationality' => 'required',
        ]);
        $pass = strtolower(normaliserChaine($request->firstname).'school');
        $data['password'] = Hash::make($pass);
        $data['country'] = $request->country;
        // Upload de la photo
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $request->validate([
                'photo' => 'image|mimes:jpeg,png|max:20480',
            ]);
            $photoPath = $request->file('photo')->store('students/photos', 'public');
            $data['photo'] = $photoPath;
        }

        // création compte utilisateur pour l'étudiant
        $user = User::create($data);
        // Donner un rôle 'student' pour l'utilisateur créé
        $user->assignRole('student');
        
        // Création de l'étudiant
        $student = Student::create([
            'user_id' => $user->id,
            'advisor_id' => $request->advisor_id,
            'parent1_firstname' => $request->father_firstname,
            'parent1_lastname' => $request->father_lastname,
            'parent1_phone' => $request->father_phone,
            'parent1_relation' => $request->father_relation,
            'parent1_profession' => $request->father_profession,
            
            'parent2_firstname' => $request->mother_firstname,
            'parent2_lastname' => $request->mother_lastname,
            'parent2_phone' => $request->mother_phone,
            'parent2_relation' => $request->mother_relation,
            'parent2_profession' => $request->mother_profession,

        ]);

        if($request->group_id){
            $student->groups()->attach($request->group_id);
        }

        StudentGroupHistory::create([
            'student_id' => $student->id,
            'group_id' => $request->group_id,
        ]);

        // Redirection avec message de succès
        return redirect()->route('students.create')->with('success', 'Étudiant enregistré avec succès.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = "Détail de l'étudiant(e)";
        $page = "Etudiants";
        $student = Student::findOrFail($id);
        return view('students.show', compact('title','page','student'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = "Modification d'un(e) étudiant(e)";
        $page = "Etudiants";
        $groups = Group::all();
        $professors = Professor::all();
        $advisors = Advisor::all();
        $student = Student::findOrFail($id);
        return view('students.edit', compact('title','page','groups','advisors','student'));
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
        $student = Student::findOrFail($id);

        // Validation des champs de l'étudiant
        $validated = $request->validate([
            'gender' => 'required|in:M,F',
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'email' => ['required','email',Rule::unique('users')->ignore($student->user_id)],
            'phone' => ['required','max:10',Rule::unique('users')->ignore($student->user_id)] ,
            'birthdate' => 'required|date',
            'birthplace_city' => 'required|string|max:255',
            'address_street' => 'required|string|max:255',
            'address_city' => 'required|string|max:255',
            'nationality' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'address_postcode' => 'required|string|max:20',
        ]);
        // Gestion de la photo
        if ($request->hasFile('photo')) {
            // Supprimer l’ancienne photo si elle existe
            if ($student->user->photo && Storage::disk('public')->exists($student->user->photo)) {
                Storage::disk('public')->delete($student->user->photo);
            }

            // Stocker la nouvelle photo
            $validated['photo'] = $request->file('photo')->store('students/photos', 'public');
        }
        
        $validated['password'] = Hash::make(strtolower(normaliserChaine($request->firstname)) . 'school');

        $user = User::find($student->user_id);
        $user->update($validated);
        

        if($request->group_id){
            $student->groups()->sync($request->group_id);
        }

        if ($student->groups->isnotEmpty()) {
            foreach ($student->groups as $groupAttached) {
                $student->studentGroupHistories()->updateOrCreate([
                    'group_id' => $groupAttached->id,
                    'status'   => 'Student',
                ]);
            }
        }

        // Mise à jour des informations de l’étudiant
        $data = [
            'advisor_id' => $request->advisor_id,
            'parent1_firstname' => $request->father_firstname,
            'parent1_lastname' => $request->father_lastname,
            'parent1_phone' => $request->father_phone,
            'parent1_relation' => $request->father_relation,
            'parent1_profession' => $request->father_profession,
            
            'parent2_firstname' => $request->mother_firstname,
            'parent2_lastname' => $request->mother_lastname,
            'parent2_phone' => $request->mother_phone,
            'parent2_relation' => $request->mother_relation,
            'parent2_profession' => $request->mother_profession,

        ];
        $student->update($data);
        return redirect()->route('students.index')->with('success', 'Étudiant mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $student = Student::findOrFail($id);


        // Supprimer la photo associée
        if ($student->photo && Storage::disk('public')->exists($student->photo)) {
            Storage::disk('public')->delete($student->photo);
        }

        $student->delete();

        return redirect()->route('students.index')->with('success', 'Étudiant supprimé avec succès.');
    }
}
