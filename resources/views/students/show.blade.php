@extends('layouts.base')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Détails de l'étudiant</h4>
            <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Étudiants</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Profil</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid py-3">
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-3 text-center">
                    @if ($student->photo)
                        <img src="{{ asset('storage/' . $student->photo) }}"
                            alt="Photo de {{ $student->firstname }}"
                            class="rounded-circle shadow"
                            width="150" height="150" style="object-fit: cover;">
                    @else
                        <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width:150px; height:150px;">
                            N/A
                        </div>
                    @endif
                </div>

                <div class="col-md-9">
                    <h3>{{ $student->firstname }} {{ $student->lastname }}</h3>
                    <p><strong>Genre :</strong> {{ $student->gender }}</p>
                    <p><strong>Email :</strong> <a href="mailto:{{ $student->email }}">{{ $student->email }}</a></p>
                    <p><strong>Téléphone :</strong> <a href="tel:{{ $student->phone }}">{{ $student->phone }}</a></p>
                    <p><strong>Date de naissance :</strong> {{ \Carbon\Carbon::parse($student->dateofbirth)->format('d/m/Y') }}</p>
                    <p><strong>Lieu de naissance :</strong> {{ $student->birthplace_postcode }} {{ $student->birthplace_city }}</p>
                    <p><strong>Nationalité :</strong> {{ $student->nationality ?? 'Non renseignée' }}</p>
                    <p><strong>Adresse :</strong>
                        {{ $student->address_street }}, {{ $student->address_postcode }} {{ $student->address_city }}
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
                                    <p><strong>Prénom :</strong> {{ $student->father_firstname ?? 'Non renseigné' }}</p>
                                    <p><strong>Nom :</strong> {{ $student->father_lastname ?? 'Non renseigné' }}</p>
                                    <p><strong>Profession :</strong> {{ $student->father_company ?? 'Non renseignée' }}</p>
                                    <p><strong>Téléphone :</strong> {{ $student->father_phone ?? 'Non renseigné' }}</p>
                                    <p><strong>Message :</strong> {{ $student->father_message ?? 'Non renseigné' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Mère -->
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header">Mère</div>
                                <div class="card-body">
                                    <p><strong>Prénom :</strong> {{ $student->mother_firstname ?? 'Non renseigné' }}</p>
                                    <p><strong>Nom :</strong> {{ $student->mother_lastname ?? 'Non renseigné' }}</p>
                                    <p><strong>Profession :</strong> {{ $student->mother_company ?? 'Non renseignée' }}</p>
                                    <p><strong>Téléphone :</strong> {{ $student->mother_phone ?? 'Non renseigné' }}</p>
                                    <p><strong>Message :</strong> {{ $student->mother_message ?? 'Non renseigné' }}</p>
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
