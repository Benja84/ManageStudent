@extends('layouts.base')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form method="POST" action="{{ route('sections.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Nom de la section</label>
                            <input list="sections" type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                            {{-- <select name="name" class="form-select" required>
                                <option value="">Sélectionnez une option</option>
                                @foreach($attitudes as $attitude)
                                    <option value="{{ $attitude }}" {{ old('name') == $attitude ? 'selected' : '' }}>{{ $attitude }}</option>
                                @endforeach
                            </select> --}}
                            <datalist id="sections">
                                @foreach($sectionsList as $item)
                                    <option value="{{ $item->name }}"></option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Abréviation</label>
                            <input type="text" class="form-control" name="abbreviation" placeholder="Ex: GL">
                        </div>
                        <div class="form-group mt-3">
                            <label>Année de la section</label>
                            <select name="promotion" class="form-control selectpicker" title="Sélectionner l'année">
                                @for($i=1; $i<=5; $i++)
                                    <option class="form-control" data-tokens="{{ yearth($i) }}"
                                            @if(old('promotion') == $i) @php($selected = TRUE) selected @endif
                                            value="{{ $i }}">{{ yearth($i) }}
                                    </option>
                                    @php($selected = FALSE)
                                @endfor
                            </select>
                        </div>
                        
                        <div class="form-group mt-3">
                            <label>Matières</label>
                            <div class="col-md-12">
                                <select name="subject_id[]" class="select2 form-select" multiple
                                title="Sélectionner les matières">
                                @foreach($subjects as $subject)
                                    <option data-tokens="{{ $subject->name }}"
                                    @if(old('subject_id') && in_array($subject->id, old('subject_id'))) selected @php($selected = TRUE) @endif
                                    value="{{$subject->id}}">{{ $subject->name }} ( {{ $subject->abbreviation }} )
                                    </option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label>Prix année scolaire</label>
                            <input class="form-control" type="text" name="pricing" placeholder="ex: 200 000" required>
                        </div>

                        <div class="card-footer">
                            <div class="mt-6 d-flex justify-content-between">
                                <a href="{{ route('sections.index') }}" class="btn btn-secondary ">Annuler</a>
                                <button type="submit" class="btn btn-primary ">Ajouter</button>
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
