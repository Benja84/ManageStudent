@extends('layouts.base')

@section('aditionnal_css')
  <link href="{{ asset('assets/libs/fullcalendar/dist/fullcalendar.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/extra-libs/calendar/calendar.css') }}" rel="stylesheet" />
@endsection
@section('content')

<div class="container-fluid py-3">
  <div class="card shadow-sm">
    <div class="card-header">
      {{-- <p>Groupe {{ $group->abreviation }} ({{ count($group->students)}} étudiants)</p> --}}
      <!-- Nav tabs -->
      <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item"> 
          <a class="nav-link active" data-bs-toggle="tab" href="#student" role="tab">
            <span class="hidden-sm-up"></span> 
            <span class="hidden-xs-down">Etudiants du groupe</span>
          </a> 
        </li>
        <li class="nav-item"> 
          <a class="nav-link" data-bs-toggle="tab" href="#prof" role="tab">
            <span class="hidden-sm-up"></span> 
            <span class="hidden-xs-down">Professeur du groupe</span>
          </a> 
        </li>
        <li class="nav-item"> 
          <a class="nav-link" data-bs-toggle="tab" href="#coordinator" role="tab">
            <span class="hidden-sm-up"></span> 
            <span class="hidden-xs-down">Coordinateurs du groupe</span>
          </a> 
        </li>
        <li class="nav-item"> 
          <a class="nav-link" data-bs-toggle="tab" href="#course" role="tab">
            <span class="hidden-sm-up"></span> 
            <span class="hidden-xs-down">Cours du groupe</span>
          </a> 
        </li>
        <li class="nav-item"> 
          <a class="nav-link" data-bs-toggle="tab" href="#course_calendar" role="tab">
            <span class="hidden-sm-up"></span> 
            <span class="hidden-xs-down">Calendrier des cours</span>
          </a> 
        </li>
      </ul>
    </div>
    <div class="card-body">
      <!-- Tab panes -->
      <div class="tab-content tabcontent-border">
        <div class="tab-pane active" id="student" role="tabpanel">
          <div class="p-20">
            <div class="table-responsive">
              <table id="liste_student" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th class="sorting_disabled text-center" scope="col">PHOTO</th>
                    <th class="sorting_disabled text-center" scope="col">GENRE</th>
                    <th class=" text-center" scope="col">NOM</th>
                    <th class=" text-center" scope="col">PRÉNOM</th>
                    <th class=" text-center" scope="col">EMAIL</th>
                    <th class=" text-center" scope="col">TELEPHONE</th>
                    <th class="sorting_disabled text-center" scope="col">ACTIONS</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($group->students as $index => $student)
                    <tr>
                      <td>
                        @if ($student->user->photo)
                          <img src="{{ asset('storage/' . $student->user->photo) }}"
                              alt="Photo de {{ $student->lastname }}"
                              width="60"
                              height="60"
                              class="rounded-circle border  shadow"
                              style="object-fit: cover;">
                        @else
                          <div class="rounded-circle bg-secondary d-flex justify-content-center align-items-center text-white"
                              style="width: 60px; height: 60px; font-size: 14px;">
                              N/A
                          </div>
                        @endif
                      </td>
                      <td>{{ $student->user->gender }}</td>
                      <td>{{ $student->user->lastname }}</td>
                      <td>{{ $student->user->firstname }}</td>
                      <td><a href="mailto:{{ $student->user->email }}">{{ $student->user->email }}</a></td>
                      <td><a href="tel:{{ $student->user->phone }}">{{ $student->user->phone }}</a></td>
                      <td >
                        <div class="d-flex justify-content-center gap-3">
                          <a href="{{ route('students.show', $student->id) }}" class="btn btn-sm btn-info"><i class="mdi mdi-eye"></i></a>

                          <a href="{{ route('students.edit', $student->id) }}" class="btn btn-sm btn-primary"><i class="mdi mdi-pencil"></i></a>
                        </div>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="8" class="text-muted">Aucun étudiant trouvé</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="tab-pane" id="prof" role="tabpanel">
          <div class="p-20">
            <div class="table-responsive">
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th class="sorting_disabled text-center" scope="col">PHOTO</th>
                    <th class="sorting_disabled text-center" scope="col">GENRE</th>
                    <th class=" text-center" scope="col">NOM</th>
                    <th class=" text-center" scope="col">PRÉNOM</th>
                    <th class=" text-center" scope="col">EMAIL</th>
                    <th class=" text-center" scope="col">TELEPHONE</th>
                    <th class="sorting_disabled text-center" scope="col">ACTIONS</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($group->professors as $index => $prof)
                    <tr>
                      <td>
                          @if ($prof->user->photo && file_exists(public_path('storage/' . $prof->user->photo)))
                            <img src="{{ asset('storage/' . $prof->user->photo) }}" alt="Photo de {{ $prof->user->lastname }}" width="50" height="50" class="rounded-circle shadow" style="object-fit: cover;margin-top:-1em">
                          @else
                            <div class="rounded-circle bg-secondary d-flex justify-content-center align-items-center text-white" style="width: 50px; height: 50px; font-size: 14px; margin-top:-0.5rem">N/A</div>
                          @endif
                        </td>

                      <td class="text-center">{{$prof->user->gender}}</td>
                      <td class="text-center">{{ $prof->user->lastname }}</td>
                      <td class="text-center">{{ $prof->user->firstname }}</td>
                      <td class="text-center">{{ $prof->user->email }}</td>
                      <td class="text-center"><a href="tel:{{ $prof->phone }}">{{ $prof->user->phone }}</a></td>
                      <td >
                        <div class="d-flex justify-content-around">
                          <a href="{{ route('professors.show', $prof->id) }}" class="btn btn-sm btn-info">
                            <i class="mdi mdi-eye"></i>
                          </a>
                          <a href="{{ route('professors.edit', $prof->id) }}" class="btn btn-sm btn-primary">
                            <i class="mdi mdi-pencil"></i>
                          </a>
                        </div>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="8" class="text-muted">Aucun professeur trouvé</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="tab-pane" id="coordinator" role="tabpanel">
          <div class="p-20">
            <div class="table-responsive">
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th class="sorting_disabled text-center" scope="col">PHOTO</th>
                    <th class="sorting_disabled text-center" scope="col">GENRE</th>
                    <th class=" text-center" scope="col">NOM</th>
                    <th class=" text-center" scope="col">PRÉNOM</th>
                    <th class=" text-center" scope="col">EMAIL</th>
                    <th class=" text-center" scope="col">TELEPHONE</th>
                    <th class="sorting_disabled text-center" scope="col">ACTIONS</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($group->coordinators as $index => $prof)
                    <tr>
                      <td>
                          @if ($prof->user->photo && file_exists(public_path('storage/' . $prof->user->photo)))
                            <img src="{{ asset('storage/' . $prof->user->photo) }}" alt="Photo de {{ $prof->user->lastname }}" width="50" height="50" class="rounded-circle shadow" style="object-fit: cover;margin-top:-1em">
                          @else
                            <div class="rounded-circle bg-secondary d-flex justify-content-center align-items-center text-white" style="width: 50px; height: 50px; font-size: 14px; margin-top:-0.5rem">N/A</div>
                          @endif
                        </td>

                      <td class="text-center">{{ $prof->user->gender }}</td>
                      <td class="text-center">{{ $prof->user->lastname }}</td>
                      <td class="text-center">{{ $prof->user->firstname }}</td>
                      <td class="text-center">{{ $prof->user->email }}</td>
                      <td class="text-center"><a href="tel:{{ $prof->phone }}">{{ $prof->user->phone }}</a></td>
                      <td >
                        <div class="d-flex justify-content-around">
                          <a href="{{ route('professors.show', $prof->id) }}" class="btn btn-sm btn-info">
                            <i class="mdi mdi-eye"></i>
                          </a>
                          <a href="{{ route('professors.edit', $prof->id) }}" class="btn btn-sm btn-primary">
                            <i class="mdi mdi-pencil"></i>
                          </a>
                        </div>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="8" class="text-muted">Aucun coordinateur-trice trouvé</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="tab-pane" id="course" role="tabpanel">
          <div class="p-20">
            <div class="table-responsive">
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th class="sorting_disabled text-center" scope="col">DATE</th>
                    <th class="sorting_disabled text-center" scope="col">HORAIRE</th>
                    <th class=" text-center" scope="col">COURS</th>
                    <th class=" text-center" scope="col">PROFESSEUR</th>
                    <th class=" text-center" scope="col">SALLE</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($group->courses as $course)
                    <tr>
                      <td class="text-center">{{ weekdays()[$course->weekday] }} {{ DateTime::createFromFormat('Y-m-d', $course->date)->format('d/m/Y') }}</td>
                      <td class="text-center">{{ DateTime::createFromFormat('H:i:s', $course->start_time)->format('H\hi') }} à {{ DateTime::createFromFormat('H:i:s', $course->end_time)->format('H\hi') }}</td>
                      <td class="text-center">{{ $course->subject->name }}</td>
                      <td class="text-center">{{ $course->professor->user->firstname }} {{ $course->professor->user->lastname }}</td>
                      <td class="text-center">{{ $course->room->name }} ({{ $course->room->department }}), n° {{ $course->room->number }}, étage {{ $course->room->floor ?? '' }} </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="8" class="text-muted">Aucun coordinateur-trice trouvé</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="tab-pane" id="course_calendar" role="tabpanel">
          <div id="calendar"></div>
        </div>
      </div>

      <div class="mt-4">
          <a href="{{ route('groups.index') }}" class="btn btn-secondary"> Retour</a>
          <a href="{{ route('groups.edit', $group->id) }}" class="btn btn-primary">Modifier</a>
      </div>
    </div>
  </div>
</div>
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
      let datas = @json($group->courses);
      
      let courses = [];
      let colors = generateColorPalette(100);
      datas.forEach(element => {
        courses.push({
          '_id':element.id,
          'title':element.subject.abbreviation+' - '+element.professor.user.firstname+' '+element.professor.user.lastname+ ' - '+element.group.abbreviation,
          'start':element.date+'T'+element.start_time,
          'end':element.date+'T'+element.end_time,
          'color':colors[element.id],
          extendedProps: {
            course: element.subject.abbreviation,
            startHour: element.start_time,
            endHour: element.end_time,
            teacher: element.professor.user.firstname+' '+element.professor.user.lastname,
            class: element.group.abbreviation+' '+element.group.school_year+' ( Section '+element.group.section.abbreviation+' )',
            location: element.room.name+'('+element.room.department+') ('+element.room.seating_capacity+' places)'+' n° '+element.room.number
          }
        } )
      });
      $('#calendar').fullCalendar('destroy');
      $('#calendar').fullCalendar({
        locale: 'fr',
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
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
        height: 'auto',     // Hauteur automatique
        aspectRatio: 1.5,
        allDaySlot: false,
        hiddenDays: [0, 6],
        events: courses,
        selectable: true,
        selectHelper: false,
        eventClick: function(info){
          // const event = info;
          const start = new Date(info.start);
          const end = new Date(info.end);
          
          // Formater la date en français
          const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
          const dateString = start.toLocaleDateString('fr-FR', options);
          const dateendString = end.toLocaleDateString('fr-FR', options);
          
          // Remplir le modal
          // $('#eventModal').find('.modal-header').style.backgroundColor =event.color;
          $('#eventModal').find('.modal-header').css('background-color', info.color+'!important');;
          $('#eventHeader').text(info.title);
          $('#eventCourse').text(info.extendedProps.course);
          $('#eventTeacher').text(info.extendedProps.teacher);
          $('#eventDate').text(dateString);
          $('#eventTime').text(`De ${info.extendedProps.startHour.split(':').slice(0, 2).join(':')} à ${info.extendedProps.endHour.split(':').slice(0, 2).join(':')}`);
          $('#eventClass').text(info.extendedProps.class);
          $('#eventLocation').text(info.extendedProps.location);
          
          // Afficher le modal
          $('#eventModal').modal('toggle');
        },
      });
    })
  </script>
@endsection
