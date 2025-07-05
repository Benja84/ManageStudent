@extends('layouts.base')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route('subjects.update', $subject) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label>Intitulé :</label>
                            <input type="text" name="name" class="form-control" value="{{ $subject->name }}" required>
                        </div>

                        <div class="form-group">
                            <label>Abréviation :</label>
                            <input type="text" name="abbreviation" class="form-control" value="{{ $subject->abbreviation }}" required>
                        </div>

                        <div class="card-footer">
                            <div class="mt-6 d-flex justify-content-between">
                                <a href="{{ route('sections.index') }}" class="btn btn-secondary">Annuler</a>
                                <button type="submit" class="btn btn-primary">Valider</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
