@extends('layouts.base')
@section('additional_style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/extra-libs/multicheck/multicheck.css') }}">
    <link  rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}">
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-end">

                        <a href="{{ route('students.create') }}" class="btn btn-success mb-3 text-white">
                        <i class="mdi mdi-plus"></i> Ajouter un étudiant
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table id="liste_student" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="" scope="col">#</th>
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
                                @forelse ($students as $index => $student)
                                    <tr>
                                        <td>{{ $student->id }}</td>
                                        <td>
                                            @if ($student->user->photo)
                                                <img src="{{ asset('storage/'.$student->user->photo) }}"
                                                    alt="{{ $student->user->lastname }}"
                                                    width="60"
                                                    height="60"
                                                    class="rounded-circle border  shadow"
                                                    style="object-fit: cover;">
                                            @else
                                                <div class="rounded-circle bg-secondary d-flex justify-content-center align-items-center text-white"
                                                    style="width: 60px; height: 60px; font-size: 14px;">
                                                    N/A
                                                </div>
                                            @endif
                                        </td>
                                        <td class=" text-center">{{ $student->user->gender }}</td>
                                        <td class=" text-center">{{ $student->user->lastname }}</td>
                                        <td class=" text-center">{{ $student->user->firstname }}</td>
                                        <td class=" text-center"><a href="mailto:{{ $student->user->email }}">{{ $student->user->email }}</a></td>
                                        <td class=" text-center"><a href="tel:{{ $student->user->phone }}">{{ $student->user->phone }}</a></td>
                                        <td >
                                            <div class="d-flex justify-content-center gap-3">
                                                <a href="{{ route('students.show', $student->id) }}" class="btn btn-sm btn-info"><i class="mdi mdi-eye"></i></a>

                                                <a href="{{ route('students.edit', $student->id) }}" class="btn btn-sm btn-primary"><i class="mdi mdi-pencil"></i></a>

                                                <form action="{{ route('students.destroy', $student->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger text-white" onclick="return confirm('Confirmer la suppression ?')"><i class="mdi mdi-delete"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-muted">Aucun étudiant trouvé</td>
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
    @if(Session::has('success'))
        <script>
            toastr.success("{{ Session::get('success') }}", "Succès!");
        </script>
    @endif
    <!-- jQuery et DataTables -->
    <script src="{{asset('assets/extra-libs/DataTables/datatables.min.js')}}"></script>
    <!-- Initialisation -->
    <script>
        $(document).ready(function () {
        const ulr_json = "{{asset('dist/fr-FR.json')}}";
            $('#liste_student').DataTable({
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