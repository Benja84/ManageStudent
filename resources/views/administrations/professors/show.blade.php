@extends('layouts.base')

@section('aditionnal_css')
  <link href="{{ asset('assets/libs/fullcalendar/dist/fullcalendar.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/extra-libs/calendar/calendar.css') }}" rel="stylesheet" />
@endsection
@section('content')

<div class="container-fluid py-3">
  <div class="card shadow-sm">
    <div class="card-header text-center">
      <h3>{{$prof->user->gender == 'F' ? 'Mme' : 'Mr'}} {{ $prof->user->firstname }} {{ $prof->user->lastname }}</h3>
    </div>
    <div class="card-body d-flex">
      <div class="col-md-3 text-center">
        @if ($prof->user->photo)
          <img src="{{ asset('storage/' . $prof->user->photo) }}" alt="Photo de {{ $prof->user->firstname }}" class="rounded-circle shadow"
            width="300" height="300" style="object-fit: cover;">
        @else
          <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width:150px; height:150px;">
            N/A
          </div>
        @endif
        
        <div class="mt-4">
          <div class="text-align">
            <h4>Matières enseignés</h4>
            <ul>
              @foreach ($prof->subjects as $subject)
                <li>{{$subject->name}}</li>
              @endforeach
            </ul>
          </div>
          <div>
            <h4>Groupes gérés</h4>
            <ul>
              @foreach ($prof->groupsCoordinator as $group)
                <li>{{$group->abbreviation}} ({{$group->school_year}}), Section: {{$group->section->name}}</li>
              @endforeach
            </ul>
          </div>
        </div>
        <div class="mt-4 d-flex justify-content-between">
            <a href="{{ route('professors.index') }}" class="btn btn-secondary"> Retour</a>
            <a href="{{ route('professors.edit', $prof->id) }}" class="btn btn-primary">Modifier</a>
        </div>
      </div>
      <div class="col-md-9">
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item"> 
            <a class="nav-link active" data-bs-toggle="tab" href="#information" role="tab">
              <span class="hidden-sm-up"></span> 
              <span class="hidden-xs-down">Information</span>
            </a> 
          </li>
          <li class="nav-item"> 
            <a class="nav-link" data-bs-toggle="tab" href="#course" role="tab">
              <span class="hidden-sm-up"></span> 
              <span class="hidden-xs-down">Cours</span>
            </a> 
          </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content tabcontent-border">
          <div class="tab-pane active" id="information" role="tabpanel">
            <div class="p-20">
              <div class="card shadow-sm">
                  <div class="card-body">
                      <div class="row mb-4">
                        <div class="col-md-12">
                          <p><strong>Genre :</strong> {{ $prof->user->gender }}</p>
                          <p><strong>Email :</strong> <a href="mailto:{{ $prof->user->email }}">{{ $prof->user->email }}</a></p>
                          <p><strong>Téléphone :</strong> <a href="tel:{{ $prof->user->phone }}">{{ $prof->user->phone }}</a></p>
                          <p><strong>Date de naissance :</strong> {{ \Carbon\Carbon::parse($prof->user->birthdate)->format('d/m/Y') }}</p>
                          <p><strong>Lieu de naissance :</strong>  {{ $prof->user->birthplace_city }}</p>
                          <p><strong>Nationalité :</strong> {{ $prof->user->nationality ?? 'Non renseignée' }}</p>
                          <p><strong>Adresse :</strong>
                              {{ $prof->user->address_street }}, {{ $prof->user->address_postcode }} {{ $prof->user->address_city }}
                          </p>
                        </div>
                      </div>
                  </div>
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
                    @forelse ($prof->courses as $course)
                      @if($course->subject)
                      <tr>
                        <td class="text-center">{{ weekdays()[$course->weekday] }} {{ DateTime::createFromFormat('Y-m-d', $course->date)->format('d/m/Y') }}</td>
                        <td class="text-center">{{ DateTime::createFromFormat('H:i:s', $course->start_time)->format('H\hi') }} à {{ DateTime::createFromFormat('H:i:s', $course->end_time)->format('H\hi') }}</td>
                        <td class="text-center">{{ $course->subject->name }}</td>
                        <td class="text-center">{{ $course->professor->user->firstname }} {{ $course->professor->user->lastname }}</td>
                        <td class="text-center">{{ $course->room->name }} ({{ $course->room->department }}), n° {{ $course->room->number }}, étage {{ $course->room->floor ?? '' }} </td>
                      </tr>
                      @endif
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
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
  <script>
  </script>
@endsection
