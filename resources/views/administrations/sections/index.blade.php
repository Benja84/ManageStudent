@extends('layouts.base')

@section('content')
<div class="row">
    <div class="col-12 d-flex justify-content-between mb-3">
        <h7></h7>
        <a href="{{ route('sections.create') }}" class="btn btn-success btn-sm">
            <i class="bi bi-plus"></i> Nouvelle section
        </a>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Intitulé</th>
                            <th>Abréviation</th>
                            <th>Année de la section</th>
                            <th>Prix</th>
                            <th>Date création</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sections as $key => $section)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $section->name }}</td>
                                <td>{{ $section->abbreviation }}</td>
                                <td>{{ $section->promotion_text }}</td>
                                <td>{{ number_format($section->pricing, 0, '', ' ') }} Ar</td>
                                <td>{{ \Carbon\Carbon::parse($section->created_at)->format('d/m/Y') }}</td>
                                <td>
                                    {{-- <a href="{{ route('sections.show', $section->id) }}" class="btn btn-info btn-sm">Voir</a> --}}
                                    <a href="{{ route('sections.edit', $section->id) }}" class="btn btn-sm btn-primary">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    <form action="{{ route('sections.destroy', $section->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Voulez-vous vraiment supprimer cette section ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">Aucune section enregistrée pour le moment.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
