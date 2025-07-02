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
                <div class="d-flex justify-content-end align-items-center">
                    {{-- <h3>Liste des salles({{ $rooms->count() }})</h3> --}}
                    <a href="{{ route('rooms.create') }}" class="btn btn-success mb-3 text-white"><i class="mdi mdi-plus"></i> Ajouter une salle</a>
                </div>
                    {{-- @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif --}}
                    <div class="table-responsive">
                    <table id="roomsTable" class="table table-striped align-middle text-center table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Lieu</th>
                            <th scope="col">Numéro</th>
                            <th scope="col">Bâtiment</th>
                            <th scope="col">Étage</th>
                            <th scope="col">Capacité</th>
                            <th scope="col">Matériel</th>
                            <th scope="col">Type Ordinateur</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($rooms as $room)
                        <tr>
                            <td>{{ $room->id }}</td>
                            <td>{{ $room->name }}</td>
                            <td>{{ $room->number }}</td>
                            <td>{{ $room->department }}</td>
                            <td>{{ $room->floor }}</td>
                            <td>{{ $room->seating_capacity }}</td>
                            <td>{{ $room->material_capacity }}</td>
                            <td>{{ $room->computer_type }}</td>
                            <td >
                                <div class="d-flex justify-content-around">
                                <a href="{{ route('rooms.show', $room->id) }}" class="btn btn-sm btn-info">
                                    <i class="mdi mdi-eye"></i>
                                </a>
                                <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-sm btn-primary">
                                    <i class="mdi mdi-pencil"></i>
                                </a>
                                <form action="{{ route('rooms.destroy', $room->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger text-white" onclick="return confirm('Voulez-vous vraiment supprimer ?')">
                                    <i class="mdi mdi-delete"></i>
                                    </button>
                                </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    @if(Session::has('success'))
        <script>
            toastr.success("{{ Session::get('success') }}", "Succès!");
        </script>
    @endif

  <!-- DataTables JS -->
  <script src="{{asset('assets/extra-libs/DataTables/datatables.min.js')}}"></script>

  <script>
    $(document).ready(function () {
      const ulr_json = "{{asset('dist/fr-FR.json')}}";
        $('#roomsTable').DataTable({
          responsive: true,
          language: {
              url: ulr_json
          },
          columnDefs: [
            {
              // Colonne photo (première colonne) non triable et non filtrable
              targets: [8],
              orderable: false,
              searchable: false
            }
          ],
        });
    });
  </script>
@endsection

