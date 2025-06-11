@extends('layouts.base')

@section('aditionnal_css')
<!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/jquery-minicolors/jquery.minicolors.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/quill/dist/quill.snow.css') }}">
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{route('courses.store')}}" method="POST">
                @csrf
                    <div class="card-body">
                        <h5 class="card-title mb-0">Ajouter un cours</h5>
                        <div class="form-group mt-3">
                            <label>Matière</label>
                            <select class="select2 form-select shadow-none" name="subject_id">
                                <option value="" selected disabled>Séléctionner une matière</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-3">
                            <label>Professeur</label>
                            <select class="select2 form-select shadow-none" name="professor_id">
                                <option value="" selected disabled>Séléctionner un prof</option>
                                @foreach($professors as $prof)
                                    <option value="{{ $prof->id }}">{{ $prof->user->firstname }} {{ $prof->user->lastname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-3">
                            <label>Salle</label>
                            <select class="select2 form-select shadow-none" name="room_id">
                                <option value="" selected disabled hidden>Séléctionner une salle</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}">{{ $room->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-3">
                            <label>Group</label>
                            <select class="select2 form-select shadow-none" name="group_id">
                                <option value="" selected hidden disabled>Séléctionner un groupe</option>
                                @foreach($groups as $group)
                                    <option value="{{ $group->id }}">{{ $group->abbreviation }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-3">
                            <label>Période</label>
                            <div class="d-flex justify-content-between">
                                <div class="col-md-2">
                                    <select class="select2 form-select shadow-none col-md-2"  name="weekday">
                                        <option value="" disabled selected hidden>Selectionner un jour de la semaine</option>
                                        @foreach ($weekdays as $weekday => $localeWeekday)
                                            <option class="form-control" data-tokens="{{ $localeWeekday }}"
                                                @if(old('weekday') == $weekday) selected @endif
                                                value="{{ $weekday+1 }}">{{ $localeWeekday }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control col-md-2 js-masked-time" type="text" name="start_time" placeholder="Heure de debut du cours (HH:MM)"> 
                                </div>
                                <div class="col-md-2">
                                    <select class="select2 form-select shadow-none col-md-2" name="duration">
                                        <option value="" disabled selected >Selectionner la durée du cours</option>
                                        @for ($duration = 0.5; $duration < 10; $duration+=0.5)
                                            <option class="form-control" data-tokens="{{ $duration }} heure(s)"
                                                @if(old('duration') == $duration) @php($selected = TRUE) selected @endif
                                                value="{{ $duration }}">{{ $duration }} heure{{ $duration > 1 ? 's' : '' }}
                                            </option>
                                            @php($selected = FALSE)
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control col-md-2" type="date" name="start_date" placeholder="Date début de la période"> 
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control col-md-2" type="date" name="end_date" placeholder="Date fin de la période"> 
                                </div>
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
    <script src="{{ asset('assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
    <script>
        //***********************************//
        // For select 2
        //***********************************//
        $(".select2").select2();

        /*colorpicker*/
        $('.demo').each(function () {
            //
            // Dear reader, it's actually very easy to initialize MiniColors. For example:
            //
            //  $(selector).minicolors();
            //
            // The way I've done it below is just for the demo, so don't get confused
            // by it. Also, data- attributes aren't supported at this time...they're
            // only used for this demo.
            //
            $(this).minicolors({
                control: $(this).attr('data-control') || 'hue',
                position: $(this).attr('data-position') || 'bottom left',

                change: function (value, opacity) {
                    if (!value) return;
                    if (opacity) value += ', ' + opacity;
                    if (typeof console === 'object') {
                        console.log(value);
                    }
                },
                theme: 'bootstrap'
            });

        });
        /*datwpicker*/
        jQuery('.mydatepicker').datepicker();
        jQuery('#datepicker-autoclose').datepicker({
            autoclose: true,
            todayHighlight: true
        });

        // $(document).ready(function (){
            let errors = @json($errors->all());
            errors.forEach(error => {
                toastr.error('I do not think that word means what you think it means.', 'Inconceivable!');
            });
        // })

    </script>
@endsection
