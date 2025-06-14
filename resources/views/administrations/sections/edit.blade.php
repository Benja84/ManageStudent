@extends('layouts.base')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('sections.update', $section->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom de la section</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $section->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="abbreviation" class="form-label">Abréviation</label>
                            <input type="text" name="abbreviation" class="form-control" value="{{ old('abbreviation', $section->abbreviation) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="promotion" class="form-label">Promotion</label>
                            {{-- <input type="text" name="promotion" class="form-control" value="{{ old('promotion', $section->promotion) }}" required> --}}
                            <select name="promotion" class="form-select" required>
                                <option value="">-- Choisir une option --</option>
                                <option value="AEII" {{ old('promotion', $section->promotion) == 'AEII' ? 'selected' : '' }}>AEII</option>
                                <option value="GL" {{ old('promotion', $section->promotion) == 'GL' ? 'selected' : '' }}>GL</option>
                                </select>
                        </div>
                        <div class="md-3">
                            <label for="niveau" class="form-label">Niveau : </label>
                            <select name="niveau" class="form-select" required>
                                {{-- <input type="text" name="year" class="form-control" placeholder="ex: 2024-2025" value="{{ old('year') }}" required> --}}
                                <option value="1ère année" {{ old('niveau') == '1ère année' ? 'selected' : '' }}>1ère année</option>
                                <option value="2ème année" {{ old('niveau') == '2ème année' ? 'selected' : '' }}>2ème année</option>
                                <option value="2ème année" {{ old('niveau') == '2ème année' ? 'selected' : '' }}>3ème année</option>
                                <option value="2ème année" {{ old('niveau') == '2ème année' ? 'selected' : '' }}>4ème année</option>
                                <option value="2ème année" {{ old('niveau') == '2ème année' ? 'selected' : '' }}>5ème année</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="year" class="form-label">Année</label>
                            <input type="text" name="year" class="form-control" placeholder="ex: 2024-2025" value="{{ old('year', $section->year) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="pricing" class="form-label">Prix</label>
                            <input type="number" name="pricing" step="0.01" class="form-control" value="{{ old('pricing', $section->pricing) }}" required>
                        </div>

                        <div class="card-footer">
                            <div class="mt-6 d-flex justify-content-between">
                                <button type="submit" class="btn btn-success btn-rounded">Annuler</button>
                                <a href="{{ route('sections.index') }}" class="btn btn-secondary btn-rounded">Mettre à jours</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
