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

            <a href="{{ route('professors.create') }}" class="btn btn-success mb-3 text-white">
              <i class="mdi mdi-plus"></i> Ajouter un professeur
            </a>
          </div>
          <div class="table-responsive">
            <table id="liste_prof" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th class="d-none" scope="col">#</th>
                  <th class="sorting_disabled text-center" scope="col">PHOTO</th>
                  <th class="sorting_disabled text-center" scope="col">GENRE</th>
                  <th class=" text-center" scope="col">NOM</th>
                  <th class=" text-center" scope="col">PRÉNOM</th>
                  <th class=" text-center" scope="col">EMAIL</th>
                  <th class=" text-center" scope="col">TELEPHONE</th>
                  <th class="sorting_disabled text-center" scope="col">ACTIONS</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($profs as $index => $prof)
                  <tr>
                    <td class="d-none">{{ $prof->id }}</td>
                    <td>
                        @if ($prof->photo && file_exists(public_path('storage/' . $prof->photo)))
                          <img src="{{ asset('storage/' . $prof->photo) }}" alt="Photo de {{ $prof->user->lastname }}" width="50" height="50" class="rounded-circle shadow" style="object-fit: cover;margin-top:-1em">
                        @else
                          <div class="rounded-circle bg-secondary d-flex justify-content-center align-items-center text-white" style="width: 50px; height: 50px; font-size: 14px; margin-top:-0.5rem">N/A</div>
                        @endif
                      </td>

                    <td class=" text-center">{{$prof->user->gender}}</td>
                    <td class="text-center">{{ $prof->user->lastname }}</td>
                    <td class="text-center">{{ $prof->user->firstname }}</td>
                    <td class="text-center">{{ $prof->user->email }}</td>
                    <td class="text-center"><a href="tel:{{ $prof->phone }}">{{ $prof->user->phone }}</a></td>
                    <td >
                      <div class="d-flex justify-content-around">
                        <a href="{{ route('professors.show', $prof->id) }}" class="btn btn-sm btn-info">
                          <i class="mdi mdi-eye"></i>
                        </a>
                        <a href="{{ route('professors.edit', $prof->id) }}" class="btn btn-sm btn-primary">
                          <i class="mdi mdi-pencil"></i>
                        </a>
                        <form action="{{ route('professors.destroy', $prof->id) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-danger text-white" onclick="return confirm('Voulez-vous vraiment supprimer ?')">
                            <i class="mdi mdi-delete"></i>
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="8" class="text-muted">Aucun professeur trouvé</td>
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
  @if(Session::has('success'))
    <script>
      toastr.success("{{ Session::get('success') }}", "Succès!");
    </script>
  @endif
  <!-- Initialisation -->
  <script>
    $(document).ready(function () {
      const ulr_json = "{{asset('dist/fr-FR.json')}}";
        $('#liste_prof').DataTable({
          responsive: true,
          language: {
              url: ulr_json
          },
          columnDefs: [
            {
              // Colonne photo (première colonne) non triable et non filtrable
              targets: [1, 2, 7],
              orderable: false,
              searchable: false
            }
          ],
        });
    });
  </script>
@endsection

