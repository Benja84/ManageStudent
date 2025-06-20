@extends('layouts.base')

@section('aditionnal_css')
<!-- Custom CSS -->
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
          @if(session('error'))
            <div class="alert alert-danger" role="alert">{{session('error')}}</div>
          @endif
            <div class="card">
                <form action="{{ route('groups.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group mt-3">
                            <label>Abréviation</label>
                            <input class="form-control" type="text" value="{{ old('abbreviation') ?? '' }}" name="abbreviation" placeholder="ex: GL" required>
                        </div>
                        <div class="form-group mt-3">
                            <label>Section</label>
                            <select class="select2 form-select shadow-none" id="section" name="section_id" id="role" style="width: 100%; height:36px;">
                              <option value="" selected hidden disabled>Séléctionner la section</option>
                              @foreach($sections as $key => $section)
                                <option value="{{ $section->id }}" @if(old('section_id') == $section->id) selected @endif>{{ $section->name }}</option>
                              @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-3">
                          <label>Année scolaire</label>
                          @php($schoolYears = school_years())
                          <select class="form-control" name="school_year" title="Sélectionner l'année scolaire">
                            <option value="" selected hidden disabled>Séléctionner l'année scolaire</option>
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
                            <option value="" selected hidden disabled>Séléctionner la périodicité</option>
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
                            <option value="" hidden disabled>Séléctionner les professeurs coordinateurs</option>
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
                            <select id="subject" name="subject_id[]" class="select2 form-select shadow-none" multiple="multiple"
                            title="Sélectionner les matières">
                              {{-- <option value=""  hidden disabled>Séléctionner les matières</option>
                              @foreach($subjects as $subject)
                                <option data-tokens="{{ $subject->name }}"
                                  @if(old('subject_id') && in_array($subject->id, old('subject_id'))) selected @php($selected = TRUE) @endif
                                  value="{{$subject->id}}">{{ $subject->name }} ( {{ $subject->abbreviation }} )
                                </option>
                                @php($selected = FALSE)
                              @endforeach --}}
                            </select>
                          </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Ajouter</button>
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
      $("#section").on('change',function(){
        const value = $(this).val();
        const url = "{{ route('subject', ':value') }}".replace(':value', value);
        
        console.log('url',url)
        $.ajax({
          url: url,
          method: 'GET',
          success: function(response){
            if(response.length){
              $('#subject').html('<option value="" disabled>Séléctionner les matières</option>');
              response.forEach(element => {
                $('#subject').append('<option data-tokens="'+element.subject.name+'" value="'+element.subject_id+'">'+element.subject.name+' ( '+element.subject.abbreviation+' )</option>');
              });
            }else{
              $('#subject').html('<option value="" disabled>Aucun matières trouvés</option>');
            }
          }
        })
      });
    </script>
@endsection
