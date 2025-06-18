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
          <div class="d-flex justify-content-between align-items-center">
            <h7></h7>
            <a href="{{ route('members.export.pdf') }}" class="btn btn-danger mb-3">
                <i class="fas fa-file-pdf"></i> Exporter en PDF
            </a>

            <a href="{{ route('members.create') }}" class="btn btn-success mb-3">
              <i class="fas fa-plus-circle"></i> Ajouter un membre
            </a>
          </div>
          <div class="table-responsive">
            <table id="liste_member" class="table table-striped table-bordered">
              <thead>
                <tr>
                  {{-- <th scope="col">#</th> --}}
                  <th class="sorting_disabled" scope="col">PHOTO</th>
                  <th class="sorting_disabled" scope="col">GENRE</th>
                  <th scope="col">NOM</th>
                  <th scope="col">PRÉNOM</th>
                  <th scope="col">EMAIL</th>
                  <th scope="col">TELEPHONE</th>
                  <th class="sorting_disabled" scope="col">ACTIONS</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($members as $index => $member)
                  <tr>
                    {{-- <td>{{ $member->id }}</td> --}}
                    <td>
                        @if ($member->photo && file_exists(public_path('storage/' . $member->photo)))
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
@endsection
@section('scripts')
<!-- jQuery et DataTables -->
<script src="{{asset('assets/extra-libs/DataTables/datatables.min.js')}}"></script>

<!-- Initialisation -->
<script>
    $(document).ready(function () {
      const ulr_json = "{{asset('dist/fr-FR.json')}}";
        $('#liste_member').DataTable({
          responsive: true,
          language: {
              url: ulr_json
          },
          columnDefs: [
            {
              // Colonne photo (première colonne) non triable et non filtrable
              targets: [0, 1, 6],
              orderable: false,
              searchable: false
            }
          ],
        });
    });
</script>
@endsection

