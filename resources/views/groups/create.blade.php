@extends('layouts.base')

@section('aditionnal_css')
<!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}">
    <link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet">
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route('groups.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group mt-3">
                            <label>Abréviation</label>
                            <input class="form-control" type="text" name="abbreviation" placeholder="ex: GL" required>
                        </div>
                        <div class="form-group mt-3">
                            <label>Section</label>
                            <select class="select2 form-select shadow-none" name="section_id" id="role" style="width: 100%; height:36px;">
                              <option value="">Select</option>
                              @foreach($sections as $key => $section)
                                <option value="{{ $section->id }}" @if(old('section_id') == $key) selected @endif>{{ $section->name }}</option>
                              @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-3">
                          <label>Année scolaire</label>
                          @php($schoolYears = school_years())
                          <select class="form-control" name="school_year" title="Sélectionner l'année scolaire">
                            @foreach ($schoolYears as $year)
                              <option class="form-control" data-tokens="{{ $year }}"
                                @if(old('school_year') == $year) @php($selected = TRUE) selected @endif
                                value="{{ $year }}">{{ $year }}</option>
                              @php($selected = FALSE)
                            @endforeach
                          </select>
                        </div>
                        <div class="form-group mt-3">
                          <label>Périodicité : </label>
                          @php($periodTypes = ['trimestre', 'semestre'])
                          <select class="form-control selectpicker" name="period_type" title="Sélectionner la périodicité">
                            @foreach ($periodTypes as $periodType)
                              <option class="form-control" data-tokens="{{ $periodType }}"
                                @if(old('period_types') == $periodType) @php($selected = TRUE) selected
                                @elseif(empty($selected) && !empty($group->period_type) && $group->period_type == $periodType) @php($selected = TRUE) selected
                                @endif
                                value="{{ $periodType }}">Périodicité en {{ $periodType }}s
                              </option>
                              @php($selected = FALSE)
                            @endforeach
                          </select>
                        </div>
                        <div class="form-group mt-3">
                          <label>Professeurs coordinateurs</label>
                          <select name="coordinator_id[]" class="select2 form-select shadow-none mt-3" multiple="multiple"
                          title="Sélectionner les professeurs coordinateurs">
                            @foreach($professors as $coordinator)
                              <option data-tokens="{{ $coordinator->user->firstname }} {{ $coordinator->user->lastname }}"
                                @if(old('coordinator_id') && in_array($coordinator->id, old('coordinator_id'))) selected @php($selected = TRUE) @endif
                                value="{{$coordinator->id}}">{{ $coordinator->user->firstname }} {{ $coordinator->user->lastname }}
                              </option>
                              @php($selected = FALSE)
                            @endforeach
                          </select>
                        </div>
                        <div class="form-group mt-3">
                          <label>Matières</label>
                          <div class="col-md-12">
                            <select name="subject_id[]" class="select2 form-select shadow-none" multiple="multiple"
                            title="Sélectionner les matières">
                              @foreach($subjects as $subject)
                                <option data-tokens="{{ $subject->name }}"
                                  @if(old('subject_id') && in_array($subject->id, old('subject_id'))) selected @php($selected = TRUE) @endif
                                  value="{{$subject->id}}">{{ $subject->name }} ( {{ $subject->abbreviation }} )
                                </option>
                                @php($selected = FALSE)
                              @endforeach
                            </select>
                          </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success btn-rounded">Ajouter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/libs/inputmask/dist/min/jquery.inputmask.bundle.min.js')}}"></script>
    <script src="{{ asset('dist/js/pages/mask/mask.init.js')}}"></script>
    <script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js')}}"></script>
    <script src="{{ asset('assets/libs/select2/dist/js/select2.min.js')}}"></script>
    <script>
      $(".select2").select2();
    </script>
@endsection
