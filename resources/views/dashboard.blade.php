@extends('layouts.base')
@section('aditionnal_css')
    <link href="{{ asset('assets/libs/fullcalendar/dist/fullcalendar.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/extra-libs/calendar/calendar.css') }}" rel="stylesheet" />
    <style>
        .fc-row{
            height: 80px!important;
        }
    </style>
@show
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="col-lg-12 p-2">
                    <div class="row">
                        <div class="col-2">
                            <a href="{{route('students.index')}}">
                            <div class="bg-dark p-10 text-white text-center">
                                <i class="mdi mdi-school mb-1 font-16"></i>
                                <h5 class="mb-0 mt-1">{{$students}}</h5>
                                <small class="font-light">Nombre d'étudiants</small>
                            </div>
                            </a>
                        </div>
                        <div class="col-2">
                            <a href="{{route('professors.index')}}">
                            <div class="bg-dark p-10 text-white text-center">
                                <i class="mdi mdi-account-multiple mb-1 font-16"></i>
                                <h5 class="mb-0 mt-1">{{$professors}}</h5>
                                <small class="font-light">Nombre de professeurs</small>
                            </div>
                            </a>
                        </div>
                        <div class="col-2">
                            <a href="{{route('groups.index')}}">
                            <div class="bg-dark p-10 text-white text-center">
                                <i class="mdi mdi-briefcase-check mb-1 font-16"></i>
                                <h5 class="mb-0 mt-1">{{$groups}}</h5>
                                <small class="font-light">Nombre de groupes</small>
                            </div>
                            </a>
                        </div>
                        <div class="col-2">
                            <a href="{{route('subjects.index')}}">
                            <div class="bg-dark p-10 text-white text-center">
                                <i class="mdi mdi-book mb-1 font-16"></i>
                                <h5 class="mb-0 mt-1">{{$subjects}}</h5>
                                <small class="font-light">Nombre de matières</small>
                            </div>
                            </a>
                        </div>
                        <div class="col-2">
                            <a href="{{route('rooms.index')}}">
                            <div class="bg-dark p-10 text-white text-center">
                                <i class="mdi mdi-home-modern mb-1 font-16"></i>
                                <h5 class="mb-0 mt-1">{{$rooms}}</h5>
                                <small class="font-light">Nombre de salles</small>
                            </div>
                            </a>
                        </div>
                        <div class="col-2">
                            <a href="{{route('courses.index')}}">
                            <div class="bg-dark p-10 text-white text-center">
                                <i class="mdi mdi-book-multiple mb-1 font-16"></i>
                                <h5 class="mb-0 mt-1">{{count($courses)}}</h5>
                                <small class="font-light">Nombre de cours</small>
                            </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card-body b-l calender-sidebar">
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- BEGIN MODAL -->
    <div class="modal fade" id="eventModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fw-bold text-white text-center" id="eventHeader"></h4>
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal"></button> --}}
            </div>
            <div class="modal-body">
                <div class=" mb-3 d-flex" style="border-radius: 5px;background-color: blue; ">
                    <div class="text-end fw-bold text-white px-3" style="font-size: 25px"><i class="mdi mdi-book-open-page-variant "></i></div>
                    <div class="text-white mt-2" id="eventCourse" style="font-size: 15px"></div>
                </div>
                <div class=" mb-3 d-flex " style="border-radius: 5px;background-color: blue; ">
                    <div class="text-end fw-bold text-white px-3" style="font-size: 25px"><i class="mdi mdi-clipboard-account"></i></div>
                    <div class="col-10 text-white mt-2" id="eventTeacher" style="font-size: 15px"></div>
                </div>
                <div class=" mb-3 d-flex" style="border-radius: 5px;background-color: blue; ">
                    <div class="text-end fw-bold text-white px-3" style="font-size: 25px"><i class="mdi mdi-calendar"></i></div>
                    <div class="col-10 text-white mt-2" id="eventDate" style="font-size: 15px"></div>
                </div>
                <div class=" mb-3 d-flex" style="border-radius: 5px;background-color: blue; ">
                    <div class="text-end fw-bold text-white px-3" style="font-size: 25px"><i class="mdi mdi-timer"></i></div>
                    <div class="col-10 text-white mt-2" id="eventTime" style="font-size: 15px"></div>
                </div>
                <div class=" mb-3 d-flex" style="border-radius: 5px;background-color: blue; ">
                    <div class="text-end fw-bold text-white px-3" style="font-size: 25px"><i class="mdi mdi-account-switch"></i></div>
                    <div class="col-10 text-white mt-2" id="eventClass" style="font-size: 15px"></div>
                </div>
                <div class=" mb-3 d-flex" style="border-radius: 5px;background-color: blue; ">
                    <div class="text-end fw-bold text-white px-3" style="font-size: 25px"><i class="mdi mdi-home-modern"></i></div>
                    <div class="col-10 text-white mt-2" id="eventLocation" style="font-size: 15px"></div>
                </div>
                <div class=" mb-3 d-flex" style="border-radius: 5px;background-color: rgb(19, 150, 41); ">
                    <div class="text-end fw-bold text-white px-3" style="font-size: 25px"><i class="mdi mdi-bookmark"></i></div>
                    <div class="col-10 text-white mt-2" id="eventLocation" style="font-size: 15px">Appel</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
            </div>
        </div>
    </div>
    <!-- END MODAL -->
@endsection
@section('scripts')
    <script src="{{ asset('assets/libs/fullcalendar/dist/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/fullcalendar/dist/locale/fr.js') }}"></script>
    <script>
        $(document).ready(function (){
            function hslToHex(h, s, l) {
                l /= 100;
                const a = s * Math.min(l, 1 - l) / 100;
                const f = n => {
                    const k = (n + h / 30) % 12;
                    const color = l - a * Math.max(Math.min(k - 3, 9 - k, 1), -1);
                    return Math.round(255 * color).toString(16).padStart(2, '0');
                };
                return `#${f(0)}${f(8)}${f(4)}`.toUpperCase();
            }

            function generateColorPalette(count) {
                const colors = [];
                const goldenRatio = 137.508; // Angle d'or pour répartition optimale
                
                for (let i = 0; i < count; i++) {
                    const hue = (i * goldenRatio) % 360;
                    const saturation = 65 + Math.sin(i) * 15; // Variation entre 50-80%
                    const lightness = 45 + Math.cos(i * 0.8) * 10; // Variation entre 35-55%
                    
                    colors.push(hslToHex(hue, saturation, lightness));
                }
                return colors;
            }
            let datas = @json($courses);
            
            let courses = [];
            let colors = generateColorPalette(100);
            datas.forEach(element => {
                if(element.subject){
                    courses.push({
                        '_id':element.id,
                        'title':element.subject.abbreviation+' - '+element.professor.user.firstname+' '+element.professor.user.lastname+ ' - '+element.group.abbreviation,
                        'start':element.date+' '+element.start_time,
                        'end':element.date+' '+element.end_time,
                        'color':colors[element.id],
                        extendedProps: {
                            course: element.subject.abbreviation,
                            startHour: element.start_time,
                            endHour: element.end_time,
                            teacher: element.professor.user.firstname+' '+element.professor.user.lastname,
                            class: element.group.abbreviation+' '+element.group.school_year+' ( Section '+element.group.section.abbreviation+' )',
                            location: element.room.name+'('+element.room.department+') ('+element.room.seating_capacity+' places)'+' n° '+element.room.number
                        }
                    });
                }
            });
            
            $('#calendar').fullCalendar({
                locale: 'fr',
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                height: 'auto',     // Hauteur automatique
                aspectRatio: 1.5,
                // defaultView: 'agendaWeek', 
                views: {
                agendaWeek: {
                    minTime: moment.duration('08:00:00'),
                    maxTime: moment.duration('20:00:00'),
                    // slotDuration: moment.duration('00:30:00'),
                    // slotLabelInterval: moment.duration('00:30:00'),
                    scrollTime: moment.duration('08:00:00'),
                    slotLabelFormat: 'H[h]mm'
                },
                agendaDay: {
                    minTime: moment.duration('08:00:00'),
                    maxTime: moment.duration('20:00:00'),
                    // slotDuration: moment.duration('00:30:00'),
                    // slotLabelInterval: moment.duration('00:30:00'),
                    scrollTime: moment.duration('08:00:00'),
                    slotLabelFormat: 'H[h]mm'
                }
                },
                allDaySlot: false,
                hiddenDays: [0, 6],
                events: courses,
                selectable: true,
                selectHelper: true,
                eventClick: function(info){
                    const event = info;
                    const start = new Date(event.start);
                    const end = new Date(event.end);
                    
                    // Formater la date en français
                    const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
                    const dateString = start.toLocaleDateString('fr-FR', options);
                    const dateendString = end.toLocaleDateString('fr-FR', options);
                    
                    // Remplir le modal
                    // $('#eventModal').find('.modal-header').style.backgroundColor =event.color;
                    $('#eventModal').find('.modal-header').css('background-color', event.color+'!important');;
                    $('#eventHeader').text(event.title);
                    $('#eventCourse').text(event.extendedProps.course);
                    $('#eventTeacher').text(event.extendedProps.teacher);
                    $('#eventDate').text(dateString);
                    $('#eventTime').text(`De ${event.extendedProps.startHour.split(':').slice(0, 2).join(':')} à ${event.extendedProps.endHour.split(':').slice(0, 2).join(':')}`);
                    $('#eventClass').text(event.extendedProps.class);
                    $('#eventLocation').text(event.extendedProps.location);
                    
                    // Afficher le modal
                    $('#eventModal').modal('toggle');
                },
            });
        })
    </script>
    
@endsection
            