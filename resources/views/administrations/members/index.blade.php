@extends('layouts.base')
@section('additional_css')
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/extra-libs/multicheck/multicheck.css') }}">
  <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet') }}">
  <style>
    .dataTables_filter {
        float: right !important;
        text-align: right;
    }

    .dataTables_length {
        float: left;
    }

    .dataTables_paginate {
        float: right !important;
    }
    </style>
@endsection
@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Liste des membres du personnel</h4>
            <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Accueil</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Membres</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <h3 ></h3>
              <a href="{{ route('members.create') }}" class="btn btn-success mb-3">
                <i class="fas fa-plus-circle"></i> Ajouter un membre
              </a>
            </div>
            <div class="table-responsive">
              <table id="liste_member" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">PHOTO</th>
                    <th scope="col">GENRE</th>
                    <th scope="col">NOM</th>
                    <th scope="col">PRÉNOM</th>
                    <th scope="col">EMAIL</th>
                    <th scope="col">TELEPHONE</th>
                    <th scope="col">ACTIONS</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($members as $index => $member)
                    <tr>
                      <td>{{ $member->id }}</td>
                      <td>
                        @if ($member->photo)
                          <img src="{{ asset('storage/' . $member->photo) }}" alt="Photo de {{ $member->user->lastname }}" width="50" height="50" class="rounded-circle shadow" style="object-fit: cover;margin-top:-1em">
                        @else
                          <div class="rounded-circle bg-secondary d-flex justify-content-center align-items-center text-white" style="width: 50px; height: 50px; font-size: 14px; margin-top:-0.5rem">N/A</div>
                        @endif
                      </td>
                      <td>
                        <div class="item-center" style="margin-top:-1.3rem">
                          <i style="font-size: 3em" class="mdi {{ $member->user->gender === 'F' ? 'mdi-gender-female' : 'mdi-gender-male'}}"></i>
                        </div>
                      </td>
                      <td class="text-center">{{ $member->user->lastname }}</td>
                      <td class="text-center">{{ $member->user->firstname }}</td>
                      <td class="text-center"><a href="mailto:{{ $member->email }}">{{ $member->user->email }}</a></td>
                      <td class="text-center"><a href="tel:{{ $member->phone }}">{{ $member->user->phone }}</a></td>
                      <td >
                        <div class="d-flex justify-content-around">
                          <a href="{{ route('members.show', $member->id) }}" class="btn btn-sm btn-info">
                            <i class="mdi mdi-eye"></i>
                          </a>
                          <a href="{{ route('members.edit', $member->id) }}" class="btn btn-sm btn-primary">
                            <i class="mdi mdi-pencil"></i>
                          </a>
                          <form action="{{ route('members.destroy', $member->id) }}" method="POST">
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
                      <td colspan="8" class="text-muted">Aucun membre trouvé</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
  <script src="{{ asset('assets/extra-libs/multicheck/datatable-checkbox-init.js') }}"></script>
  <script src="{{ asset('assets/extra-libs/multicheck/jquery.multicheck.js') }}"></script>
  <script src="{{ asset('assets/extra-libs/DataTables/datatables.min.js') }}"></script>
  <script>
    $('#liste_member').DataTable({
        "language": {
            "decimal":        "",
            "emptyTable":     "Aucune donnée disponible dans le tableau",
            "info":           "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
            "infoEmpty":      "Affichage de 0 à 0 sur 0 entrées",
            "infoFiltered":   "(filtrées depuis _MAX_ entrées totales)",
            "infoPostFix":    "",
            "thousands":      ",",
            "lengthMenu":    "Afficher _MENU_ entrées",
            "loadingRecords": "Chargement...",
            "processing":    "Traitement...",
            "search":         "Recherche:",
            "zeroRecords":    "Aucun résultat trouvé",
            "paginate": {
                "first":      "Premier",
                "last":       "Dernier",
                "next":       "Suivant",
                "previous":   "Précédent"
            }
        },
        "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
               "<'row'<'col-sm-12'tr>>" +
               "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        "columnDefs": [
            {
                "targets": 5,
                "render": function(data) {
                    return data.replace(/(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/, "$1 $2 $3 $4 $5");
                }
            }
        ]
    });
  </script>
@endsection
