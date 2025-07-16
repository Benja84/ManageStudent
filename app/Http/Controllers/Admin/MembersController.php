<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advisor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Illuminate\Validation\Rule;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class MembersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Liste des membres du personnel";
        $page = "Membres";
        $members = Advisor::all();
        return view('administrations.members.index', compact('members', 'title', 'page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Ajouter un membre du personnel";
        $page = 'Membres';
        $roles = [User::ADMIN => 'administrateur-trice', User::ADVISOR => 'conseiller-ère', User::SECRETARY => 'secrétaire'];
        return view('administrations.members.create', compact('roles', 'title', 'page'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'gender' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|max:10|unique:users,phone',
            'role' => 'required',
            'birthdate' => 'required',
            'birthplace_city' => 'required',
            'address_city' => 'required',
            'address_street' => 'required',
        ]);
        $fields['address_postcode'] = $request->address_postcode;
        $fields['nationality'] = $request->nationality;
        $fields['password'] = Hash::make(strtolower($request->firstname) . 'school');
        if ($request->hasFile('photo')) {
            $request->validate([
                'photo' => 'image|mimes:jpeg,png|max:20480',
            ]);
            $photoPath = $request->file('photo')->store('members/photos', 'public');
            $fields['photo'] = $photoPath;
        }
        $user = User::create($fields);

        $attributes['user_id'] = $user->id;
        $user->assignRole($request->role);
        $advisor = Advisor::create($attributes);

        return redirect()->route('members.create')->with('success','Membre enregistré avec succé !');
        // return $advisor;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $member = Advisor::find($id);
        $title = "Fiche du membre";
        $page = "Détail du membre";
        return view('administrations.members.show',compact('title','page','member'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = "Editer un membre du personnel";
        $page = "Membres";
        $member = Advisor::find($id);
        $roles = [User::ADMIN => 'Administrateur-trice', User::ADVISOR => 'Conseiller-ère', User::SECRETARY => 'Secrétaire'];
        return view('administrations.members.edit', compact('member', 'roles', 'title', 'page'));
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
        $advisor = Advisor::find($id);
        $fields = $request->validate([
            'firstname' => 'required',
            'gender' => 'required',
            'lastname' => 'required',
            'email' => ['required','email',Rule::unique('users')->ignore($advisor->user_id)],
            'phone' => ['required','max:10',Rule::unique('users')->ignore($advisor->user_id)] ,
            'birthdate' => 'required',
            'birthplace_city' => 'required',
            'address_street' => 'required',
            'address_city' => 'required',
        ]);

        $fields['address_postcode'] = $request->address_postcode;
        $fields['nationality'] = $request->nationality;

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $request->validate([
                'photo' => 'image|mimes:jpeg,png|max:20480',
            ]);
            // Supprimer l’ancienne photo si elle existe
            if ($advisor->user->photo && Storage::disk('public')->exists($advisor->user->photo)) {
                Storage::disk('public')->delete($advisor->user->photo);
            }
            $photoPath = $request->file('photo')->store('members/photos', 'public');
        }
        
        $user = User::find($advisor->user_id);
        $user->gender = $request->gender;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->phone = $request->phone;
        $user->birthdate = $request->birthdate;
        $user->birthplace_city = $request->birthplace_city;
        $user->address_city = $request->address_city;
        $user->address_postcode = $request->address_postcode;
        $user->address_street = $request->address_street;
        $user->photo = $photoPath;

        $user->save();

        return redirect()->route('members.index')->with('success','Membre modifié avec succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $advisor = Advisor::find($id);
        $user = User::find($advisor->user_id);
        $user->delete();
        return redirect()->route('members.index')->with('success', 'Conseiller supprimé avec succès.');
    }

    public function exportPDF()
    {
        $members = Advisor::with('user')->get();

        $pdf = PDF::loadView('administrations.members.pdf', compact('members'));
        return $pdf->download('liste_membres.pdf');
    }
}
