<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ProfessorController extends Controller
{
    /**
     * Affiche la liste de tous les professeurs.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Récupère tous les professeurs depuis la base de données
        $professors = Professor::all();
        // Retourne la vue 'professors.index' avec les données des professeurs
        return view('professors.index', compact('professors'));
    }

    /**
     * Affiche le formulaire pour créer un nouveau professeur.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Retourne la vue 'professors.create' pour le formulaire de création
        return view('professors.create');
    }

    /**
     * Enregistre un nouveau professeur dans la base de données.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // DD($request);
        try {
            // Valide les données du formulaire
            $validated = $request->validate([
                'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'gender' => 'required|in:M,F',
                'last_name' => 'required|string|max:255',
                'first_name' => 'required|string|max:255',
                'phone_country' => 'required|string',
                'phone' => 'required|string|max:20',
                'email' => 'required|email|unique:professors,email',
                'role' => 'required|string|max:255',
                'birth_date' => 'required|date',
                'birth_place' => 'required|string|max:255',
                'nationality' => 'required|string|max:100',
                'address' => 'required|string|max:255',
                'city' => 'required|string|max:100',
                'zip_code' => 'required|string|max:20',
                'country' => 'required|string|max:100',
            ]);

            // Prépare les données validées
            // $data = $validated;
            $user = new User();
            $user->gender = $validated['gender'];
            $user->firstname = $validated['first_name'];
            $user->lastname = $validated['last_name'];
            $user->dateofbirth = $validated['birth_date'];
            $user->birthplace_city = $validated['birth_place'];
            $user->nationality = $validated['nationality'];
            $user->address = $validated['address'];
            $user->city = $validated['city'];
            $user->zip_code = $validated['zip_code'];
            $user->country = $validated['country'];
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

            if ($request->hasFile('photo')) {
                $data['photo'] = $request->file('photo')->store('professors', 'public');
            }

            // Crée un nouveau professeur avec les données
            Professor::create($data);

            // Redirige vers la liste des professeurs avec un message de succès
            return redirect()->route('professors.index')->with('success', 'Professeur ajouté avec succès');
        } catch (\Exception $e) {
            // Enregistre l'erreur dans les logs
            Log::error('Error in store: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            // Retourne à la page précédente avec un message d'erreur
            return back()->withErrors(['error' => 'Une erreur est survenue lors de l\'enregistrement.'])->withInput();
        }
    }

    /**
     * Met à jour les informations d'un professeur spécifique.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        // Valide les données du formulaire
        $validated = $request->validate([
            'photo' => 'nullable|image|max:2048',
            'gender' => 'required|in:M,F',
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'email' => 'required|email|unique:professors,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'required|date',
            'birth_place' => 'required|string|max:255',
            'nationality' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'country' => 'required|string|max:255',
            'comments' => 'nullable|string',
            'phone_country' => 'nullable|string',
            'email_type' => 'nullable|string',
        ]);

        // Récupère le professeur ou lance une exception si non trouvé
        $data = $validated;
        $data['user_id'] = Auth::id() ?? 1; // Utilise 1 si non authentifié pour tester

        // Gère le téléchargement de la photo si elle existe
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('professors', 'public');
        }

        // Met à jour les données du professeur
        Professor::create($data);

        // Retourne une réponse JSON indiquant le succès
        return response()->json(['success' => true, 'message' => 'Professeur mis à jour avec succès']);
    }


    /**
     * Supprime un professeur spécifique de la base de données.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        // Récupère le professeur ou lance une exception si non trouvé
        $professor = Professor::findOrFail($id);
        // Supprime le professeur
        $professor->delete();

        // Retourne une réponse JSON indiquant le succès
        return response()->json(['success' => true, 'message' => 'Professeur supprimé avec succès']);
    }
}
