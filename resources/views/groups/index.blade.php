@extends('layouts.base')
@section('additional_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/extra-libs/multicheck/multicheck.css') }}">
<link  rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}">
@endsection
@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-end">

            <a href="{{ route('groups.create') }}" class="btn btn-success mb-3 text-white">
              <i class="mdi mdi-plus"></i> Ajouter un groupe
            </a>
          </div>
          <div class="table-responsive">
            <table id="liste_groupe" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th class="d-none" scope="col">#</th>
                  <th class="text-center" scope="col">Abréviation</th>
                  <th class="text-center" scope="col">Section</th>
                  <th class="text-center" scope="col">Année scolaire</th>
                  <th class="text-center" scope="col">Périodicité</th>
                  <th class="sorting_disabled text-center" scope="col">ACTIONS</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($groups as $index => $group)
                  <tr>
                    <td class="d-none">{{ $group->id }}</td>
                    <td class="text-center">{{$group->abbreviation}}</td>
                    <td class="text-center">{{ $group->section->name }}</td>
                    <td class="text-center">{{$group->school_year}}</td>
                    <td class="text-center">{{ $group->period_type }}</td>
                    <td >
                      <div class="d-flex justify-content-around">
                        <a href="{{ route('groups.show', $group->id) }}" class="btn btn-sm btn-info">
                          <i class="mdi mdi-eye"></i>
                        </a>
                        <a href="{{ route('groups.edit', $group->id) }}" class="btn btn-sm btn-primary">
                          <i class="mdi mdi-pencil"></i>
                        </a>
                        @if(count($group->students) == 0 && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('secretary')) ) 
                        <form action="{{ route('groups.destroy', $group->id) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-danger text-white" onclick="return confirm('Voulez-vous vraiment supprimer ?')">
                            <i class="mdi mdi-delete"></i>
                          </button>
                        </form>
                        @else 
                          <button class="btn btn-sm btn-secondary text-white" title="Ce groupe a des étudiant donc on ne peut pas le supprimer">
                            <i class="mdi mdi-delete"></i>
                          </button>
                        @endif
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="8" class="text-muted">Aucun groupe trouvé</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
<!-- jQuery et DataTables -->
<script src="{{asset('assets/extra-libs/DataTables/datatables.min.js')}}"></script>

<!-- Initialisation -->
<script>
    $(document).ready(function () {
      const ulr_json = "{{asset('dist/fr-FR.json')}}";
        $('#liste_groupe').DataTable({
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

