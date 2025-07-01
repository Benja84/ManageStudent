@extends('layouts.base')

@section('content')

<div class="container-fluid py-3">
  <div class="card shadow-sm">
    <div class="card-header">
      <p>Groupe {{ $group->abreviation }} ({{ count($group->students)}} étudiants)</p>
    </div>
    <div class="card-body">
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
          <a class="nav-link" data-bs-toggle="tab" href="#coorinator" role="tab">
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
      </ul>
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
                        @if ($student->photo)
                          <img src="{{ asset('storage/' . $student->photo) }}"
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
        <div class="tab-pane  p-20" id="prof" role="tabpanel">
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
                          @if ($prof->photo && file_exists(public_path('storage/' . $prof->photo)))
                            <img src="{{ asset('storage/' . $prof->photo) }}" alt="Photo de {{ $prof->user->lastname }}" width="50" height="50" class="rounded-circle shadow" style="object-fit: cover;margin-top:-1em">
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
        <div class="tab-pane p-20" id="coordinator" role="tabpanel">
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
                          @if ($prof->photo && file_exists(public_path('storage/' . $prof->photo)))
                            <img src="{{ asset('storage/' . $prof->photo) }}" alt="Photo de {{ $prof->user->lastname }}" width="50" height="50" class="rounded-circle shadow" style="object-fit: cover;margin-top:-1em">
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
        <div class="tab-pane p-20" id="course" role="tabpanel">
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
      </div>

      <div class="mt-4">
          <a href="{{ route('groups.index') }}" class="btn btn-secondary"> Retour</a>
          <a href="{{ route('groups.edit', $group->id) }}" class="btn btn-primary">Modifier</a>
      </div>
    </div>
  </div>
</div>
@endsection
