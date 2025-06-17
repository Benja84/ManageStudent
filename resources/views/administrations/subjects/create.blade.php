@extends('layouts.base')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route('subjects.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Intitulé :</label>
                            <input type="text" name="name" class="form-control" placeholder="ex: Histoire de l’art" required>
                        </div>

                        <div class="form-group">
                            <label>Abréviation :</label>
                            <input type="text" name="abbreviation" class="form-control" placeholder="ex: HDLA" required>
                        </div>
                    </div>
                    <div class="card-footer mt-2">
                        <div class="mt-6 d-flex justify-content-between">
                            <a href="{{ route('subjects.index') }}" class="btn btn-secondary">Annuler</a>
                            <button type="submit" class="btn btn-primary">Ajouter</button>
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
