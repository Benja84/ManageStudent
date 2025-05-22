<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Affiche la liste des étudiants.
     */
    public function index()
    {
        $students = Student::select('id', 'photo', 'gender', 'lastname', 'firstname', 'email', 'phone')
            ->latest()
            ->paginate(10);

        return view('students.index', compact('students'));
    }

    /**
     * Affiche le formulaire de création.
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Enregistre un nouvel étudiant dans la base de données.
     */
    public function store(Request $request)
    {
        // Vérifie que l'utilisateur est bien connecté
        if (!Auth::check()) {
            abort(403, 'Utilisateur non authentifié');
        }


        $validated = $request->validate([
            // Étudiant
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gender' => 'required|in:Homme,Femme',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'phone' => 'required|string|max:20',
            'birth' => 'required|date',
            'lieu' => 'required|string|max:255',
            'nationality' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',

            // Père (optionnel)
            'father_firstname' => 'nullable|string|max:255',
            'father_lastname' => 'nullable|string|max:255',
            'father_company' => 'nullable|string|max:255',
            'father_phone' => 'nullable|string|max:20',
            'father_message' => 'nullable|string',

            // Mère (optionnel)
            'mother_firstname' => 'nullable|string|max:255',
            'mother_lastname' => 'nullable|string|max:255',
            'mother_company' => 'nullable|string|max:255',
            'mother_phone' => 'nullable|string|max:20',
            'mother_message' => 'nullable|string',
        ]);

        // Upload de la photo
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('students/photos', 'public');
        }

        // Création de l'étudiant avec association à l'utilisateur connecté
        $student = Student::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'birth' => $request->birth,
            'lieu' => $request->lieu,
            'nationality' => $request->nationality,
            'address' => $request->address,
            'photo' => $photoPath,
            'user_id' => Auth::id(),

        ]);

        // Ajout des parents si les champs sont remplis
        $student->parents()->createMany([
            [
                'type' => 'father',
                'firstname' => $validated['father_firstname'],
                'lastname' => $validated['father_lastname'],
                'company' => $validated['father_company'],
                'phone' => $validated['father_phone'],
                'message' => $validated['father_message'],
            ],
            [

                'type' => 'mother',
                'firstname' => $validated['mother_firstname'],
                'lastname' => $validated['mother_lastname'],
                'company' => $validated['mother_company'],
                'phone' => $validated['mother_phone'],
                'message' => $validated['mother_message'],
            ]
        ]);

        // Redirection avec message de succès
        return redirect()->route('students.index')->with('success', 'Étudiant enregistré avec succès.');
    }

    /**
     * Affiche les détails d’un étudiant.
     */
    public function show($id)
    {
        $student = Student::with('father', 'mother')->findOrFail($id);
        return view('students.show', compact('student'));
    }

    /**
     * Affiche le formulaire d’édition.
     */
    public function edit($id)
    {
        $student = Student::with('father', 'mother')->findOrFail($id);
        return view('students.edit', compact('student'));
    }

    /**
     * Met à jour les informations d’un étudiant.
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
     * Supprime un étudiant.
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
