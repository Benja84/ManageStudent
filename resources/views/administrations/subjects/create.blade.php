@extends('layouts.base')

@section('aditionnal_css')
<!-- Custom CSS -->
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route('subjects.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <h5 class="card-title mb-0">Ajouter une matière</h5>
                        <div class="form-group mt-3">
                            <label>Intitulé</label>
                            <input class="form-control" type="text" name="name" placeholder="ex: Mathématique" required>
                        </div>
                        <div class="form-group mt-3">
                            <label>Abréviation</label>
                            <input class="form-control" type="text" name="abbreviation" placeholder="ex: MATH" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success btn-rounded">Ajouter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/libs/inputmask/dist/min/jquery.inputmask.bundle.min.js')}}"></script>
    <script>
    </script>
@endsection
