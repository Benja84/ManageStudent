@extends('layouts.base')

@section('content')

<div class="container-fluid py-3">
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-3 text-center">
                    @if ($student->user->photo)
                        <img src="{{ asset('storage/' . $student->user->photo) }}"
                            alt="Photo de {{ $student->user->firstname }}"
                            class="rounded-circle shadow"
                            width="150" height="150" style="object-fit: cover;">
                    @else
                        <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width:150px; height:150px;">
                            N/A
                        </div>
                    @endif
                </div>

                <div class="col-md-9">
                    <h3>{{ $student->user->firstname }} {{ $student->user->lastname }}</h3>
                    <p><strong>Genre :</strong> {{ $student->user->gender }}</p>
                    <p><strong>Email :</strong> <a href="mailto:{{ $student->user->email }}">{{ $student->user->email }}</a></p>
                    <p><strong>Téléphone :</strong> <a href="tel:{{ $student->user->phone }}">{{ $student->user->phone }}</a></p>
                    <p><strong>Date de naissance :</strong> {{ \Carbon\Carbon::parse($student->user->birthdate)->format('d/m/Y') }}</p>
                    <p><strong>Lieu de naissance :</strong>  {{ $student->user->birthplace_city }}</p>
                    <p><strong>Nationalité :</strong> {{ $student->user->nationality ?? 'Non renseignée' }}</p>
                    <p><strong>Adresse :</strong>
                        {{ $student->user->address_street }}, {{ $student->user->address_postcode }} {{ $student->user->address_city }}
                    </p>
                </div>
            </div>

            <hr>

            <div class="row">
                <h3 class="mt-5">Parents</h3>
                    <div class="row">
                        <!-- Père -->
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header">Père</div>
                                <div class="card-body">
                                    <p><strong>Prénom :</strong> {{ $student->parent1_firstname ?? 'Non renseigné' }}</p>
                                    <p><strong>Nom :</strong> {{ $student->parent1_lastname ?? 'Non renseigné' }}</p>
                                    <p><strong>Profession :</strong> {{ $student->parent1_profession ?? 'Non renseignée' }}</p>
                                    <p><strong>Téléphone :</strong> {{ $student->parent1_phone ?? 'Non renseigné' }}</p>
                                    <p><strong>Situation :</strong> {{ $student->parent1_relation ?? 'Non renseigné' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Mère -->
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header">Mère</div>
                                <div class="card-body">
                                    <p><strong>Prénom :</strong> {{ $student->parent2_firstname ?? 'Non renseigné' }}</p>
                                    <p><strong>Nom :</strong> {{ $student->parent2_lastname ?? 'Non renseigné' }}</p>
                                    <p><strong>Profession :</strong> {{ $student->parent2_profession ?? 'Non renseignée' }}</p>
                                    <p><strong>Téléphone :</strong> {{ $student->parent2_phone ?? 'Non renseigné' }}</p>
                                    <p><strong>Situation :</strong> {{ $student->parent2_relation ?? 'Non renseigné' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('students.index') }}" class="btn btn-secondary">← Retour</a>
                <a href="{{ route('students.edit', $student->id) }}" class="btn btn-primary">Modifier</a>
            </div>
        </div>
    </div>
</div>
@endsection
