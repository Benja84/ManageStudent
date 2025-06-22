@extends('layouts.base')

@section('content')
    <?php
    function yearth(int $number): string {
        return match($number) {
            1 => '1ère année',
            2 => '2ème année',
            3 => '3ème année',
            4 => '4ème année',
            5 => '5ème année',
            default => $number . 'ème'
        };
    }
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route('sections.update', $section->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <h5 class="card-title mb-0">Modifier une section</h5>
                        <div class="form-group mt-3">
                            <label>Intitulé</label>
                            <input class="form-control" type="text" name="name" value="{{ old('name', $section->name) }}" required>
                        </div>
                        <div class="form-group mt-3">
                            <label>Abréviation</label>
                            <input class="form-control" type="text" name="abbreviation" value="{{ old('abbreviation', $section->abbreviation) }}" required>
                        </div>
                        <div class="form-group mt-3">
                            <label>Année de la section</label>
                            <select name="promotion" class="form-control selectpicker" title="Sélectionner l'année" required>
                                @for($i=1; $i<=5; $i++)
                                    <option value="{{ $i }}" {{ old('promotion', $section->promotion) == $i ? 'selected' : '' }}>
                                        {{ yearth($i) }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group mt-3">
                            <label>Prix année scolaire</label>
                            <input class="form-control" type="text" name="pricing" value="{{ old('pricing', $section->pricing) }}" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-warning btn-rounded">Modifier</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
