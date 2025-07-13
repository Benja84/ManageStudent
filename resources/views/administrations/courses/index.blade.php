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
        <div class="card-header">
          <div class="d-flex justify-content-end">
            <a class="btn btn-success text-white" href="{{route('courses.create')}}"><i class="mdi mdi-plus"></i> Ajouter un cours</a>
          </div>
          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item"> 
              <a class="nav-link active" data-bs-toggle="tab" href="#courses_calendar" role="tab">
                <span class="hidden-sm-up"></span> 
                <span class="hidden-xs-down">Calendrier des cours</span>
              </a> 
            </li>
            <li class="nav-item"> 
              <a class="nav-link" data-bs-toggle="tab" href="#course" role="tab">
                <span class="hidden-sm-up"></span> 
                <span class="hidden-xs-down">Recherche des cours</span>
              </a> 
            </li>
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content tabcontent-border">
            <div class="tab-pane active" id="courses_calendar" role="tabpanel">
              <div class="p-20">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="b-l calender-sidebar">
                      <div id="calendar"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="tab-pane" id="course" role="tabpanel">
              <div class="p-20">
                <form action="{{route('search_courses')}}" method="post" style="padding-top:0.5rem;padding-left:0.5rem;padding-right:0.5rem;background-color: #eee; border: 1px solid rgba(241, 240, 240, 0.756)">
                  @csrf
                  <div class="form-group">
                    <div class="d-flex justify-content-between">
                      <div class="col-md-3">
                        <label>Date début :</label>
                        <input class="form-control col-md-2 start_date datepicker" type="text" name="start_date" placeholder="Date début de la période (dd/mm/yyyy)">
                      </div>
                      <div class="col-md-3">
                        <label>Date fin :</label>
                        <input class="form-control col-md-2 end_date  datepicker" type="text" name="end_date" placeholder="Date fin de la période (dd/mm/yyyy)">
                      </div>
                      <div class="col-md-3">
                        <label>Jour :</label>
                        <div class="form-group ">
                          <select class="select2 form-select shadow-none" style="width: 100%"  name="weekday">
                            <option value="" disabled selected hidden>Selectionner un jour de la semaine</option>
                            @foreach (weekdays() as $weekday => $localeWeekday)
                              <option class="form-control" data-tokens="{{ $localeWeekday }}" value="{{ $weekday }}">
                                {{ $localeWeekday }}
                              </option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <label>Heure :</label>
                        <input class="form-control col-md-2 js-masked-time start_time" type="time" name="start_time" placeholder="Heure de début du cours (HH:MM)">
                      </div>
                      
                    </div>
                    <div class="d-flex justify-content-between">
                      <div class="col-md-3">
                        <label for="">Groupe :</label>
                        <div>
                        <select class="select2 form-select shadow-none" style="width: 100%"   name="group_id">
                          <option value="" disabled selected hidden>Selectionner un groupe</option>
                          @foreach ($groups as $group)
                            <option class="form-control" data-tokens="{{ $group->fullname }}" value="{{ $group->id }}">
                              {{ $group->fullname }}
                            </option>
                          @endforeach
                        </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <label for="">Salle :</label>
                        <div>
                        <select class="select2 shadow-none" style="width: 100%"   name="room_id">
                          <option value="" disabled selected hidden>Selectionner une salle</option>
                          @foreach ($rooms as $room)
                            <option class="form-control" data-tokens="{{ $room->name }}" value="{{ $room->id }}">
                              {{ $room->name }}
                            </option>
                          @endforeach
                        </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <label for="">Matière :</label>
                        <div>
                        <select class="select2 form-select shadow-none" style="width: 100%"  name="subject_id">
                          <option value="" disabled selected >Selectionner la matière</option>
                          @foreach ($subjects as $subject)
                            <option class="form-control" data-tokens="{{ $subject->name }}" value="{{ $subject->id }}">
                              {{ $subject->name }}
                            </option>
                            @php($selected = FALSE)
                          @endforeach
                        </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <label for="">Professeur :</label>
                        <div>
                        <select class="select2 form-select shadow-none" style="width: 100%" name="prof_id">
                          <option value="" disabled selected hidden>Selectionner un professeur</option>
                          @foreach ($professors as $prof)
                            <option class="form-control" data-tokens="{{ $prof->user->firstname }} {{ $prof->user->lastname }}" value="{{ $prof->id }}">
                              {{ $prof->user->firstname }} {{ $prof->user->lastname }}
                            </option>
                          @endforeach
                        </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group mt-3">
                      <button class="btn btn-primary" type="button" id="recherche">Rechercher</button>
                      <button class="btn btn-danger text-white" type="button" id="reinitialiser">Réinitialiser</button>
                    </div>
                  </div>
                </form>
                <div class="table-responsive">
                  <h3>Résultats de recherche</h3>
                  <table class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th class="sorting_disabled text-center" scope="col">DATE</th>
                        <th class="sorting_disabled text-center" scope="col">HORAIRE</th>
                        <th class=" text-center" scope="col">COURS</th>
                        <th class=" text-center" scope="col">PROFESSEUR</th>
                        <th class=" text-center" scope="col">SALLE</th>
                        <th class=" text-center" scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody id="data_tr">
                        <tr>
                          <td colspan="8" class="text-muted">Aucun cours trouvé</td>
                        </tr>
                    </tbody>
                  </table>
                </div>
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
        } )
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

      // Recherche cours
      $('#recherche').on('click',function(event){
        event.preventDefault();
        $('#data_tr').html('');
        // Récuperer l'url d'action form (POST)
        let url = $(this).closest('form').attr('action');
        // Récuperer les valeurs du formulaire
        let date_start = $('input[name="start_date"]').val();
        let date_end = $('input[name="end_date"]').val();
        let token = $('input[name="_token"]').val();
        let weekday = $('select[name="weekday"]').val();
        let prof = $('select[name="prof_id"]').val();
        let group = $('select[name="group_id"]').val();
        let subject = $('select[name="subject_id"]').val();
        let room = $('select[name="room_id"]').val();
        let start_time = $('input[name="start_time"]').val() ;
        // Déclaration url delete et edit cours
        let url_delete = "{{ route('courses.destroy',':id_cours') }}";
        let url_edit = "{{ route('courses.edit',':id') }}";

        // Ajax methode
        $.ajax({
          url:url,
          method: 'POST',
          data: {date_debut:date_start,date_fin:date_end,weekday:weekday,start_time:start_time,professor_id:prof,group_id:group,subject_id:subject,room_id:room,'_token':token},
          success: function (response){
            if(response.length){
              // S'il y a des valeurs dans response
              response.forEach(element => {
                // Remplacer :id et :id_cours par id cours trouvé 
                const edit_route = url_edit.replace(':id',element.id);
                const delete_route = url_delete.replace(':id_cours',element.id);

                moment.locale('en');
                // Récuperer l'index du tableau weekdays
                const dayIndex = moment.weekdays().indexOf(element.weekday.charAt(0).toUpperCase() + element.weekday.slice(1));
                
                const date = new Date(element.date);
                const jour = date.getDate().toString().padStart(2, '0');
                const mois = (date.getMonth() + 1).toString().padStart(2, '0');
                const annee = date.getFullYear();

                // Formatter heure ex: 08:30 => 08h30
                const heure_debut = element.start_time.substring(0, 5).replace(':', 'h');
                const heure_fin = element.end_time.substring(0, 5).replace(':', 'h');

                moment.locale('fr');
                // Prepare la ligne et colonne du tableau (<tr> <td></td> </tr>)
                let result = '<tr>';
                result +='<td class="text-center">'+moment.weekdays()[dayIndex].charAt(0).toUpperCase() + moment.weekdays()[dayIndex].slice(1)+' '+`${jour}/${mois}/${annee} </td>`;
                result +=`<td class="text-center">${heure_debut} à ${heure_fin} </td>`;
                result += `<td class="text-center">${element.subject.name} </td>`;
                result += `<td class="text-center">${element.professor.user.firstname} ${element.professor.user.lastname}</td>`;
                result += `<td class="text-center">${element.room.name} (${element.room.department}), n° ${element.room.number}, étage ${element.room.floor}</td>`;
                result += `<td class="text-center">
                  <div class="d-flex justify-content-between">
                    <div>
                    <a class="btn btn-primary text-white" href="${edit_route}"><i class="mdi mdi-pencil"></i></a>
                    </div>
                    <form action="${delete_route}" mthod="POST">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-danger text-white"><i class="mdi mdi-delete"></i></button>
                    </form>
                  </div>
                  </td>`;
                result +='</tr>';
                // Afficher dans la table les rérultats
                $('#data_tr').append(result);
              });
            }else{
              $('#data_tr').append('<tr><td colspan="8" class="text-muted">Aucun cours trouvé</td></tr>')
            }
          },
          error: function (error){
            toastr.error(error.message);
          }
        })
      });
      $('#reinitialiser').on('click',function(event){
        event.preventDefault();
        $('input[name="start_date"]').val('');
        $('input[name="end_date"]').val('');
        $('input[name="start_time"]').val('') ;
        $('select[name="weekday"] option').each(element =>{
          console.log(element)
          // if($(option).hasAttribute('selected')){
          //   $(option).removeAttr('selected');
          // }
        });
        $('select[name="prof_id"]').val('');
        $('select[name="group_id"]').val('');
        $('select[name="subject_id"]').val('');
        $('select[name="room_id"]').val(''); 
      });
    })
  </script>
    
@endsection
            