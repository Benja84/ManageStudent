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
            'phone' => 'required|max:10',
            'role' => 'required',
            'birthdate' => 'required',
            'birthplace_city' => 'required',
        ]);
        // $fields['gender'] = $request->gender;
        $fields['password'] = Hash::make($request->firstname . 'school');
        if ($request->hasFile('photo')) {
            $request->validate([
                'photo' => 'required|image|mimes:jpeg,png|max:2048',
            ]);
            $file = $request->file('photo');
            $filename = str_replace(' ', '', $request->firstname . $request->lasname);
            $filename = iconv('UTF-8', 'ASCII//TRANSLIT', $filename);
            $filename = preg_replace('/[^a-zA-Z0-9]/', '', strtolower($filename));
            // $plus = Str::random(10);
            $name = $file->storeAs('public/images', $filename . '.' . $file->extension());
            $fields['photo'] = $name;
        }
        $user = User::create($fields);

        $attributes['user_id'] = $user->id;
        $user->assignRole($request->role);
        $advisor = Advisor::create($attributes);

        return redirect()->route('members.index');
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
        return $member;
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
        $roles = [User::ADMIN => 'administrateur-trice', User::ADVISOR => 'conseiller-ère', User::SECRETARY => 'secrétaire'];
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
        dd($request);
        $fields = $request->validate([
            'firstname' => 'required',
            'gender' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'phone' => 'required|max:10',
            'birthdate' => 'required',
            'birthplace_city' => 'required',
        ]);

        if ($request->hasFile('photo')) {
            $request->validate([
                'photo' => 'required|image|mimes:jpeg,png|max:2048',
            ]);
            $file = $request->file('photo');
            $filename = str_replace(' ', '', $request->firstname . $request->lasname);
            $filename = iconv('UTF-8', 'ASCII//TRANSLIT', $filename);
            $filename = preg_replace('/[^a-zA-Z0-9]/', '', strtolower($filename));
            // $plus = Str::random(10);
            $name = $file->storeAs('public/images', $filename . '.' . $file->extension());
            $fields['photo'] = $name;
        }

        $user = User::find($request->id);
        $user->gender = $request->gender;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->phone = $request->phone;
        $user->birthdate = $request->birthdate;
        $user->birthplace_city = $request->birthplace_city;
        $user->address_city = $request->address_city;

        $user->save();

        return redirect()->route('members.index');
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
