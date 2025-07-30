@extends('layouts.base')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route('rooms.update', $room->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label>Nom :</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $room->name) }}" required>
                        </div>

                        <div class="form-group">
                            <label>Numéro :</label>
                            <input type="text" name="number" class="form-control" value="{{ old('number', $room->number) }}">
                        </div>

                        <div class="form-group">
                            <label>Bâtiment :</label>
                            <input type="text" name="department" class="form-control" value="{{ old('department', $room->department) }}">
                        </div>

                        <div class="form-group">
                            <label>Étage :</label>
                            <input type="number" name="floor" class="form-control" value="{{ old('floor', $room->floor) }}">
                        </div>

                        <div class="form-group">
                            <label>Capacité en personnes :</label>
                            <input type="number" name="seating_capacity" class="form-control" value="{{ old('seating_capacity', $room->seating_capacity) }}">
                        </div>

                        <div class="form-group">
                            <label>Capacité en matériel :</label>
                            <input type="number" name="material_capacity" placeholder="ex:20" class="form-control" value="{{ old('material_capacity', $room->material_capacity) }}">
                        </div>

                        <div class="form-group">
                            <label>Type d'ordinateur :</label>
                            <select name="computer_type" class="form-control">
                                <option value="">Sélectionner un type</option>
                                <option value="Fixe" {{ $room->computer_type == 'Fixe' ? 'selected' : '' }}>Fixe</option>
                                <option value="Portable" {{ $room->computer_type == 'Portable' ? 'selected' : '' }}>Portable</option>
                                <option value="Hybride" {{ $room->computer_type == 'Hybride' ? 'selected' : '' }}>Hybride</option>
                            </select>
                        </div>
                        <div class="form-group d-flex justify-content-between">
                            <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Annuler</a>
                            <button type="submit" class="btn btn-primary">Modifier</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
