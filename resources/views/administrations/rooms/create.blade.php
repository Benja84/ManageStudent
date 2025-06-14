@extends('layouts.base')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <form action="{{ route('rooms.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label>Lieu :</label>
                        <input type="text" name="name" class="form-control" placeholder="ex: Tsaratanana" required>
                    </div>

                    <div class="form-group">
                        <label>Numéro :</label>
                        <input type="text" name="number" class="form-control" placeholder="ex: O7">
                    </div>

                    <div class="form-group">
                        <label>Bâtiment :</label>
                        <input type="text" name="department" class="form-control" placeholder="ex: 1">
                    </div>

                    <div class="form-group">
                        <label>Étage :</label>
                        <input type="number" name="floor" class="form-control" placeholder="ex: 02">
                    </div>

                    <div class="form-group">
                        <label>Capacité en personnes :</label>
                        <input type="number" name="seating_capacity" class="form-control" placeholder="ex: 20">
                    </div>

                    <div class="form-group">
                        <label>Capacité en matériel :</label>
                        <input type="number" name="material_capacity" class="form-control" placeholder="ex: 20">
                    </div>

                    <div class="form-group">
                        <label>Type d'ordinateur :</label>
                        <select name="computer_type" class="form-control">
                            <option value="">Sélectionner un type d'ordinateur</option>
                            <option value="Fixe">Fixe</option>
                            <option value="Portable">Portable</option>
                            <option value="Hybride">Hybride</option>
                        </select>
                    </div>
                    {{-- class="btn btn-success mb-3 --}}
                    <div class="card-footer">
                        <div class="mt-6 d-flex justify-content-between">
                            <a href="{{ route('rooms.index') }}" class="btn btn-secondary btn-rounded">Annuler</a>
                            <button type="submit" class="btn btn-success btn-rounded">Ajouter</button>
                        </div>
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
