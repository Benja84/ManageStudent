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
                    {{-- <h4 class="mb-4">listes des matieres({{ $subjects->count() }})</h4> --}}
                    <a href="{{ route('subjects.create') }}" class="btn btn-success mb-3 text-white"><i class="mdi mdi-plus"></i>Ajouter une matière</a>
                </div>
                {{-- @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif --}}
                <div class="table-responsive">
                    <table id="matieresTable" class="table table-striped table-bordered">
                        <thead >
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
                                    <a href="{{ route('subjects.edit', $subject->id) }}" class="btn btn-sm btn-primary"><i class="mdi mdi-pencil"></i></a>
                                    <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger text-white" onclick="return confirm('Supprimer cette matière ?')"><i class="mdi mdi-delete"></i></button>
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
@endsection
@section('scripts')
    @if(Session::has('success'))
        <script>
            toastr.success("{{ Session::get('success') }}", "Succès!");
        </script>
    @endif
  <!-- DataTables -->
  <script src="{{asset('assets/extra-libs/DataTables/datatables.min.js')}}"></script>


  <script>
    $(document).ready(function () {
      const ulr_json = "{{asset('dist/fr-FR.json')}}";
        $('#matieresTable').DataTable({
          responsive: true,
          language: {
              url: ulr_json
          },
          columnDefs: [
            {
              // Colonne photo (première colonne) non triable et non filtrable
              targets: [3],
              orderable: false,
              searchable: false
            }
          ],
        });
    });
  </script>
@endsection

