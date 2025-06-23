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
                            <label for="name" class="form-label">Intitulé</label>
                            <input list="sections" type="text" name="name" class="form-control" value="{{ old('name', $section->name) }}" required>
                            <datalist id="sections">
                                @foreach($sectionsList as $item)
                                    <option value="{{ $item->name }}"></option>
                                @endforeach
                            </datalist>
                        </div>

                        <div class="mb-3">
                            <label for="abbreviation" class="form-label">Abréviation</label>
                            <input type="text" name="abbreviation" class="form-control" value="{{ old('abbreviation', $section->abbreviation) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="year" class="form-label">Niveau</label>
                            <select name="promotion" class="form-control selectpicker" title="Sélectionner l'année">
                                @for($i=1; $i<=5; $i++)
                                    <option class="form-control" data-tokens="{{ yearth($i) }}" @if(old('promotion', $section->promotion) == $i) @php($selected = TRUE) selected @endif
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
                                    @if((old('subject_id') && in_array($subject->id, old('subject_id')) ) || ( $section->subjects && $section->subjects->contains($subject->id))) selected @php($selected = TRUE) @endif
                                    value="{{$subject->id}}">{{ $subject->name }} ( {{ $subject->abbreviation }} )
                                    </option>
                                @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="pricing" class="form-label">Prix</label>
                            <input type="number" name="pricing" step="0.01" class="form-control" value="{{ old('pricing', $section->pricing) }}" required>
                        </div>

                        <div class="card-footer">
                            <div class="mt-6 d-flex justify-content-between">
                                <button  class="btn btn-danger">Annuler</button>
                                <button type="submit" class="btn btn-primary">Valider</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
