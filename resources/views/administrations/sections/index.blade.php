@extends('layouts.base')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Liste des sections ({{ $sections->count() }})</h2>
        <a href="{{ route('sections.create') }}" class="btn btn-primary">➕ Ajouter une section</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover shadow-sm">
        <thead class="table-light">
            <tr>
                <th>Nom</th>
                <th>Abréviation</th>
                <th>Promotion</th>
                <th>Niveau</th>
                <th>Année</th>
                <th>Prix (€)</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sections as $section)
                <tr>
                    <td>{{ $section->name }}</td>
                    <td>{{ $section->abbreviation }}</td>
                    <td>{{ $section->promotion }}</td>
                    <td>{{ $section->niveau }}</td>
                    <td>{{ $section->year }}</td>
                    <td>{{ number_format($section->pricing, 2, ',', ' ') }} €</td>
                    <td class="text-center">
                        <a href="{{ route('sections.edit', $section) }}" class="btn btn-sm btn-warning">✏️</a>
                        <form action="{{ route('sections.destroy', $section) }}" method="POST" class="d-inline" onsubmit="return confirm('Voulez-vous vraiment supprimer ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">🗑</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Aucune section enregistrée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
