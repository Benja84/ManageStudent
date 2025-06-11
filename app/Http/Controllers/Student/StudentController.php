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
        $data = $request->validate([
            'gender' => 'required',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'birthdate' => 'required|date',
            'birthplace_city' => 'required|string|max:255',
            'nationality' => 'required|string|max:255',
            'address_city' => 'nullable|string|max:255',
        ]);
        // dd($request);
        $pass = str_replace('-','',$request->birthdate);
        $data['password'] = Hash::make($pass);
        // création compte utilisateur pour l'étudiant
        $user = User::create($data);
        // Donner un rôle 'student' pour l'utilisateur créé
        $user->assignRole('student');
        // Upload de la photo
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $request->validate([
                'photo' => 'image|mimes:jpeg,png|max:2048',
            ]);
            $photoPath = $request->file('photo')->store('students/photos', 'public');
        }

        // Création de l'étudiant
        $student = Student::create([
            'user_id' => $user->id,
            'advisor_id' => $request->advisor_id,
            'parent1_firstname' => $request->father_firstname,
            'parent1_lastname' => $request->father_lastname,
            'parent1_phone' => $request->father_phone,
            'parent1_relation' => $request->father_company,
            
            'parent2_firstname' => $request->mother_firstname,
            'parent2_lastname' => $request->mother_lastname,
            'parent2_phone' => $request->mother_phone,
            'parent2_relation' => $request->mother_company,

        ]);

        StudentGroupHistory::create([
            'student_id' => $student->id,
            'group_id' => $request->group_id,
        ]);

        // Redirection avec message de succès
        return redirect()->route('students.index')->with('success', 'Étudiant enregistré avec succès.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = Student::with('father', 'mother')->findOrFail($id);
        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $student = Student::with('father', 'mother')->findOrFail($id);
        return view('students.edit', compact('student'));
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
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gender' => 'required|in:Homme,Femme',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'phone' => 'required|string|max:20',
            'birth' => 'required|date',
            'nationality' => 'required|string|max:255',
            'address' => 'nullable|string',

            'father_firstname' => 'nullable|string|max:255',
            'father_lastname' => 'nullable|string|max:255',
            'father_company' => 'nullable|string|max:255',
            'father_phone' => 'nullable|string|max:20',
            'father_message' => 'nullable|string',

            'mother_firstname' => 'nullable|string|max:255',
            'mother_lastname' => 'nullable|string|max:255',
            'mother_company' => 'nullable|string|max:255',
            'mother_phone' => 'nullable|string|max:20',
            'mother_message' => 'nullable|string',
        ]);

        // Gestion de la photo
        if ($request->hasFile('photo')) {
            // Supprimer l’ancienne photo si elle existe
            if ($student->photo && Storage::disk('public')->exists($student->photo)) {
                Storage::disk('public')->delete($student->photo);
            }

            // Stocker la nouvelle photo
            $validated['photo'] = $request->file('photo')->store('students/photos', 'public');
        }

        // Mise à jour des informations de l’étudiant
        $student->update($validated);

        // Met à jour les informations des parents

        // Supprimer les parents existants
        $student->parents()->delete();

        // Créer un tableau pour les nouveaux parents à insérer
        $parents = [];

        // Si les champs du père sont remplis
        if ($request->filled('father_firstname') && $request->filled('father_lastname')) {
            $parents[] = [
                'type' => 'father',
                'firstname' => $request->input('father_firstname'),
                'lastname' => $request->input('father_lastname'),
                'company' => $request->input('father_company'),
                'phone' => $request->input('father_phone'),
                'message' => $request->input('father_message'),
            ];
        }

        // Si les champs de la mère sont remplis
        if ($request->filled('mother_firstname') && $request->filled('mother_lastname')) {
            $parents[] = [
                'type' => 'mother',
                'firstname' => $request->input('mother_firstname'),
                'lastname' => $request->input('mother_lastname'),
                'company' => $request->input('mother_company'),
                'phone' => $request->input('mother_phone'),
                'message' => $request->input('mother_message'),
            ];
        }

        // Insérer les parents s’ils existent
        if (!empty($parents)) {
            $student->parents()->createMany($parents);
        }

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
