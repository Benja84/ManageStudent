@extends('layouts.base')

@section('aditionnal_css')
<!-- Custom CSS -->
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route('sections.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Nom de la section</label>
                            <select name="name" class="form-select" required>
                                <option value="">Sélectionnez une option</option>
                                @foreach($attitudes as $attitude)
                                    <option value="{{ $attitude }}" {{ old('name') == $attitude ? 'selected' : '' }}>{{ $attitude }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Abréviation</label>
                            <input type="text" class="form-control" name="abbreviation" placeholder="Ex: GL">
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
                            <label>Prix année scolaire</label>
                            <input class="form-control" type="text" name="pricing" placeholder="ex: 200 000" required>
                        </div>

                        <div class="card-footer">
                            <div class="mt-6 d-flex justify-content-between">
                                <a href="{{ route('sections.index') }}" class="btn btn-danger ">Annuler</a>
                                <button type="submit" class="btn btn-primary ">Ajouter</button>
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
        document.querySelector('form').addEventListener('submit', function (e) {
            const pricing = document.querySelector('input[name="pricing"]');
            pricing.value = pricing.value.replace(/\s/g, '');
        });
    </script>
@endsection
