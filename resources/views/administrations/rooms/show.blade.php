@extends('layouts.base')

@section('content')
<div class="container">
    <h3>Détails de la salle : {{ $room->name }}</h3>

    <div class="card mt-3">
        <div class="card-body">
            <p><strong>Nom :</strong> {{ $room->name }}</p>
            <p><strong>Numéro :</strong> {{ $room->number ?? 'N/A' }}</p>
            <p><strong>Bâtiment :</strong> {{ $room->department ?? 'N/A' }}</p>
            <p><strong>Étage :</strong> {{ $room->floor ?? 'N/A' }}</p>
            <p><strong>Capacité (personnes) :</strong> {{ $room->seating_capacity ?? 'N/A' }}</p>
            <p><strong>Capacité (matériel) :</strong> {{ $room->material_capacity ?? 'N/A' }}</p>
            <p><strong>Type d’ordinateur :</strong> {{ $room->computer_type ?? 'N/A' }}</p>
        </div>
    </div>

    <a href="{{ route('rooms.index') }}" class="btn btn-secondary mt-3">Retour à la liste</a>
</div>
@endsection
