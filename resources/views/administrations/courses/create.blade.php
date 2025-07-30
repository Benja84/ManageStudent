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
    @error('start_date')
    <div class="alert alert-danger col-md-12 alert-block" role="alert">
        <h4><i class="icon fa fa-warning"></i> Erreur!</h4>
        {!! $message !!}
    </div>
    @enderror
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{route('courses.store')}}" method="POST">
                @csrf
                    <div class="card-body">
                        <h5 class="card-title mb-0">Ajouter un cours</h5>
                        <div class="form-group mt-3">
                            <label>Matière</label>
                            <select class="select2 form-select shadow-none" name="subject_id" id="subject">
                                <option value="" selected disabled>Séléctionner une matière</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}"  @if(old('subject_id') == $subject->id) selected @endif>{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-3">
                            <label>Professeur</label>
                            <select class="select2 form-select shadow-none" name="professor_id" id="professor">
                                <option value="" selected disabled>Séléctionner un prof</option>
                                @foreach($professors as $prof)
                                    <option value="{{ $prof->id }}" @if(old('professor_id') == $prof->id) selected @endif>{{ $prof->user->firstname }} {{ $prof->user->lastname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-3">
                            <label>Salle</label>
                            <select class="select2 form-select shadow-none" name="room_id">
                                <option value="" selected disabled hidden>Séléctionner une salle</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}"  @if(old('room_id') == $room->id) selected @endif>{{ $room->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-3">
                            <label>Group</label>
                            <select class="select2 form-select shadow-none" name="group_id" id="group">
                                <option value="" selected disabled>Séléctionner un parcours</option>
                                @foreach($groups as $group)
                                    <option value="{{ $group->id }}"  @if(old('group_id') == $group->id) selected @endif>{{ $group->abbreviation }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-3">
                            <label>Période</label>
                            <div class="d-flex justify-content-between">
                                <div class="col-md-2">
                                    <select class="select2 form-select shadow-none col-md-2"  name="weekday">
                                        <option value="" disabled selected hidden>Selectionner un jour de la semaine</option>
                                        @foreach (weekdays() as $weekday => $localeWeekday)
                                            <option class="form-control" data-tokens="{{ $localeWeekday }}"
                                                @if(old('weekday') == $weekday) selected @endif
                                                value="{{ $weekday }}">{{ $localeWeekday }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control col-md-2 js-masked-time start_time" value="@if(old('start_time')) {{old('start_time')}} @endif" type="text" name="start_time" placeholder="Heure de debut du cours (HH:MM)">
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
                                    <input class="form-control col-md-2 start_date datepicker" value="{{old('start_date')}}" type="text" name="start_date" placeholder="Date début de la période (dd/mm/yyyy)">
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control col-md-2 end_date  datepicker" value="{{old('end_date')}}" type="text" name="end_date" placeholder="Date fin de la période (dd/mm/yyyy)">
                                </div>
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
    @if(Session::has('success'))
        <script>
            toastr.success("{{ Session::get('success') }}", "Succès!");
        </script>
    @endif
    <script>

        $(document).ready(function (){
            let errors = @json($errors->all());
            errors.forEach(error => {
                toastr.error(error +'.', 'Erreur!');
            });
            $('#subject').on('change',function(){
                const subject = $(this).val();
                const url = "{{ route('professorSubject', ':value') }}".replace(':value', subject);
                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(response){
                        console.log('response',response)
                        if(response){
                            if(response.professors.length){
                                $('#professor').html('<option value="" selected disabled>Séléctionner le prof</option>');
                                response.professors.forEach(prof => {
                                    $('#professor').append('<option value="'+prof.id+'" data-tokens="'+prof.user.firstname+' '+prof.user.lastname+'">'+prof.user.firstname+' '+prof.user.lastname+'</option>');
                                });
                            }
                            if(response.groups.length){
                                $('#group').html('<option value="" selected disabled>Séléctionner un parcours</option>')
                                response.groups.forEach(group => {
                                    $('#group').append('<option value="'+group.id+'" data-tokens="'+group.abbreviation+' '+group.school_year+' ( Mention '+group.section.name+')">'+group.abbreviation+' '+group.school_year+' ( Mention '+group.section.name+')</option>')
                                })
                            }
                        }else{
                            $('#professor').html('<option value="" disabled>Aucun professeurs trouvés</option>');
                            $('#group').html('<option value="" disabled>Aucun parcours trouvés</option>');
                        }
                    }
                })
            })
            $('.start_time').on('change',function (){
                if(isValidTime($(this).val())){
                    const valide = checkTimeWithDetails($(this).val());
                    switch (valide) {
                        case 'hours':
                            $(this).addClass('is-invalid');
                            toastr.error('Heures doivent être entre 00 et 23', 'Heure non valide!');
                            break;
                        case 'minutes':
                            $(this).addClass('is-invalid');
                            toastr.error('Minutes doivent être entre 00 et 59', 'Heure non valide!');
                            break;
                        case 'tot':
                            $(this).addClass('is-invalid');
                            toastr.error('Trop tôt (min 06:00)', 'Heure non valide!');
                            break;
                        case 'tard':
                            $(this).addClass('is-invalid');
                            toastr.error('Trop tard (max 19:00)', 'Heure non valide!');
                            break;
                        default:
                            $(this).removeClass('is-invalid');
                            break;
                    }
                }else{
                    $(this).addClass('is-invalid');
                    toastr.error('Veuillez vérifier l\'heure que vous avez saisis.', 'Heure non valide!');
                }
            })

            function isValidTime(timeString) {
                // Vérifie le format XX:XX avec des chiffres
                const regex = /^([0-1][0-9]|2[0-3]):([0-5][0-9])$/;
                return regex.test(timeString);
            }
            function checkTimeWithDetails(timeString) {

                const [hours, minutes] = timeString.split(':').map(Number);

                // Vérification plages standards
                if (hours < 0 || hours > 23) return "hours";
                if (minutes < 0 || minutes > 59) return "minutes";

                // Vérification plage 06:00-19:00
                const totalMinutes = hours * 60 + minutes;
                if (totalMinutes < 360) return "tot";
                if (totalMinutes > 1140) return "tard";

                return 'valide';
            }

            $('.end_date').on('change',function(){
                const startVal = $('.start_date').val();
                const endVal = $(this).val();
                const startParts = startVal.split('/');
                const endParts = endVal.split('/');

                // Créer des dates correctes (new Date(année, mois-1, jour))
                const start = new Date(
                    parseInt(startParts[2]),
                    parseInt(startParts[1]) - 1,
                    parseInt(startParts[0])
                );

                const end = new Date(
                    parseInt(endParts[2]),
                    parseInt(endParts[1]) - 1,
                    parseInt(endParts[0])
                );
                if(start != ""){
                    if( start > end){
                        toastr.error('La date début doit inférieur ou égal à la date fin','Erreur date!')
                    }
                }
            })
        })

    </script>
@endsection
