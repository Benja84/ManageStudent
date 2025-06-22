@extends('layouts.base')

@section('additional_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/extra-libs/multicheck/multicheck.css') }}">
    <link  rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}">
@endsection

@section('content')
<<<<<<< HEAD
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
=======
{{-- <div class="container mt-4">
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('sections.create') }}" class="btn btn-primary"><i class="mdi mdi-plus"></i> Ajouter une section</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="table-responsive">
        <table id="liste_groupe" class="table table-striped table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Nom</th>
                    <th>Abréviation</th>
                    <th>Promotion</th>
                    <th>Niveau</th>
                    <th>Année</th>
                    <th>Prix de l'année scolaire</th>
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
                        <td>{{ number_format($section->pricing, 2, ',', ' ') }} </td>
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
</div> --}}
    <div class="row">
        <div class="col-12">
        <div class="card">
            <div class="card-body">
            <div class="d-flex justify-content-end">

                <a href="{{ route('sections.create') }}" class="btn btn-success mb-3">
                <i class="mdi mdi-plus"></i> Ajouter une séction
                </a>
            </div>
            <div class="table-responsive">
                <table id="liste_section" class="table table-striped table-bordered">
                <thead>
                    <tr>
                    <th class="d-none" scope="col">#</th>
                    <th class="text-center" scope="col">Nom</th>
                    <th class="text-center" scope="col">Abréviation</th>
                    <th class="text-center" scope="col">Promotion</th>
                    <th class="text-center" scope="col">Prix de l'année scolaire</th>
                    <th class="sorting_disabled text-center" scope="col">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sections as $section)
                    <tr>
                        <td class="d-none">{{ $section->id }}</td>
                        <td class="text-center">{{$section->name}}</td>
                        <td class="text-center">{{ $section->abbreviation }}</td>
                        <td class="text-center">{{yearth($section->promotion)}}</td>
                        <td class="text-center">{{number_format($section->pricing, 0, ',', ' ')  }} Ar</td>
                        <td >
                        <div class="d-flex justify-content-around">
                            <a href="{{ route('sections.show', $section->id) }}" class="btn btn-sm btn-info">
                            <i class="mdi mdi-eye"></i>
                            </a>
                            <a href="{{ route('sections.edit', $section->id) }}" class="btn btn-sm btn-primary">
                            <i class="mdi mdi-pencil"></i>
                            </a>
                            <form action="{{ route('sections.destroy', $section->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer ?')">
                                <i class="mdi mdi-delete"></i>
                            </button>
                            </form>
                        </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-muted">Aucun séction trouvé</td>
                    </tr>
                    @endforelse
                </tbody>
                </table>
            </div>
            </div>
        </div>
        </div>
    </div>
>>>>>>> dev_bis
@endsection
@section('scripts')
<!-- jQuery et DataTables -->
<script src="{{asset('assets/extra-libs/DataTables/datatables.min.js')}}"></script>

<!-- Initialisation -->
<script>
    $(document).ready(function () {
      const ulr_json = "{{asset('dist/fr-FR.json')}}";
        $('#liste_section').DataTable({
          responsive: true,
          language: {
              url: ulr_json
          },
          columnDefs: [
            {
              targets: 5,
              orderable: false,
              searchable: false
            }
          ],
        });
    });
</script>
@endsection