@extends('layouts.base')

@section('aditionnal_css')
<!-- Custom CSS -->
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route('rooms.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <h5 class="card-title mb-0">Ajouter une salle</h5>
                        <div class="form-group mt-3">
                            <label>Nom</label>
                            <input class="form-control" type="text" name="name" placeholder="ex: Théâtre" required>
                        </div>
                        <div class="form-group mt-3">
                            <label>Numero</label>
                            <input class="form-control" type="text" name="number" placeholder="ex: 4" required>
                        </div>
                        <div class="form-group mt-3">
                            <label>Batiment</label>
                            <input class="form-control" type="text" name="department" placeholder="ex: info" required>
                        </div>
                        <div class="form-group mt-3">
                            <label>Etage</label>
                            <input class="form-control" type="text" name="floor" placeholder="ex: 2" required>
                        </div>
                        <div class="form-group mt-3">
                            <label>Capacité en personnes</label>
                            <input class="form-control" type="text" name="seating_capacity" placeholder="ex: 20" required>
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
