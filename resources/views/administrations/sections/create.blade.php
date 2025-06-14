@extends('layouts.base')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form method="POST" action="{{ route('sections.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Nom de la section (Attitude)</label>
                            <select name="name" class="form-select" required>
                                <option value="">Sélectionnez une option</option>
                                @foreach($attitudes as $attitude)
                                    <option value="{{ $attitude }}" {{ old('name') == $attitude ? 'selected' : '' }}>{{ $attitude }}</option>
                                @endforeach
                            </select>
                        </div>
                            <div class="mb-3">
                                <label class="form-label">Abréviation</label>
                                <input type="text" name="abbreviation" class="form-control" value="{{ old('abbreviation') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Promotion</label>
                                <select name="promotion" class="form-select" required>
                                    <option value="">-- Choisir une option --</option>
                                    <option value="AEII" {{ old('promotion') == 'AEII' ? 'selected' : '' }}>AEII</option>
                                    <option value="GL" {{ old('promotion') == 'GL' ? 'selected' : '' }}>GL</option>
                                    <!-- Ajoute d'autres options si besoin -->
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Niveau : </label>
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
                                <input type="text" name="year" class="form-control" placeholder="ex: 2024-2025" value="{{ old('year') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Prix (€)</label>
                                <input type="number" step="0.01" name="pricing" class="form-control" placeholder="ex: 200 000" value="{{ old('pricing') }}" required>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="mt-6 d-flex justify-content-between">
                                <a href="{{ route('sections.index') }}" class="btn btn-secondary btn-rounded">Annuler</a>
                                <button type="submit" class="btn btn-success btn-rounded">Ajouter</button>
                            </div>
                        </div>
                    </div>
                </form>
            @if($errors->any())
                <div class="alert alert-danger mt-3">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
