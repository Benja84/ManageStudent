@extends('layouts.base')

@section('content')
@section('additional_css')
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/extra-libs/multicheck/multicheck.css') }}">
  <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet') }}">
@endsection
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-4">listes des matieres({{ $subjects->count() }})</h4>
                    <a href="{{ route('subjects.create') }}" class="btn btn-success mb-3"><i class="fas fa-plus-circle"></i>Ajouter une matière</a>
                </div>
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <div class="table-responsive">
                <table id="matieresTable" class="table table-striped table align-middle text-center table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Intitulé</th>
                            <th scope="col">Abréviation</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subjects as $subject)
                        <tr>
                            <td>{{ $subject->id }}</td>
                            <td>{{ $subject->name }}</td>
                            <td>{{ $subject->abbreviation }}</td>
                            <td class="d-flex justify-content-center gap-3">
                                <a href="{{ route('subjects.edit', $subject->id) }}" class="btn btn-sm btn-primary">✏️</a>
                                <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette matière ?')">🗑️</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- <div class="d-flex justify-content-center mt-4">
                    {{ $matieres->links() }}
                </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
  <!-- jQuery requis -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- DataTables -->
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

  <!-- CSS DataTables (tu peux aussi l’ajouter dans additional_css) -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

  <script>
    $(document).ready(function () {
        $('#matieresTable').DataTable({
            responsive: true,
            language: {
                "decimal": "",
                "emptyTable": "Aucune donnée disponible dans le tableau",
                "info": "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
                "infoEmpty": "Affichage de 0 à 0 sur 0 entrées",
                "infoFiltered": "(filtrées depuis _MAX_ entrées totales)",
                "lengthMenu": "Afficher _MENU_ entrées",
                "loadingRecords": "Chargement...",
                "processing": "Traitement...",
                "search": "Recherche:",
                "zeroRecords": "Aucun résultat trouvé",
                "paginate": {
                    "first": "Premier",
                    "last": "Dernier",
                    "next": "Suivant",
                    "previous": "Précédent"
                },
                "aria": {
                    "sortAscending": ": activer pour trier la colonne par ordre croissant",
                    "sortDescending": ": activer pour trier la colonne par ordre décroissant"
                }
            }
        });
    });
  </script>
@endsection

