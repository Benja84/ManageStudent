@extends('layouts.base')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route('rooms.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group mt-3">
                            <label>Lieu</label>
                            <input class="form-control" type="text" name="name" placeholder="ex: Arcade" required>
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
                                <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Annuler</a>
                                <button type="submit" class="btn btn-primary">Ajouter</button>
                            </div>
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
    @if(Session::has('success'))
        <script>
            toastr.success("{{ Session::get('success') }}", "Succès!");
        </script>
    @endif
@endsection
