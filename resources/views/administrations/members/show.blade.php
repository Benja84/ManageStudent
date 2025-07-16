@extends('layouts.base')

@section('aditionnal_css')
@endsection
@section('content')

<div class="container-fluid py-3">
  <div class="card shadow-sm">
    <div class="card-header">
      {{-- <p>Groupe {{ $group->abreviation }} ({{ count($group->students)}} étudiants)</p> --}}
      <!-- Nav tabs -->
      <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item"> 
          <a class="nav-link active" data-bs-toggle="tab" href="#info" role="tab">
            <span class="hidden-sm-up"></span> 
            <span class="hidden-xs-down">Information</span>
          </a> 
        </li>
        @if($member->user->hasRole('advisor'))
        <li class="nav-item"> 
          <a class="nav-link" data-bs-toggle="tab" href="#student" role="tab">
            <span class="hidden-sm-up"></span> 
            <span class="hidden-xs-down">Etudiants</span>
          </a> 
        </li>
        @endif
      </ul>
    </div>
    <div class="card-body">
      <!-- Tab panes -->
      <div class="tab-content tabcontent-border">
        
        <div class="tab-pane active" id="info" role="tabpanel">
          <div class="p-20">
            <div class="card shadow-sm">
              <div class="card-body">
                  <div class="row mb-4">
                      <div class="col-md-3 text-center">
                          @if ($member->user->photo)
                              <img src="{{ asset('storage/' . $member->user->photo) }}"
                                  alt="Photo de {{ $member->user->firstname }}"
                                  class="rounded-circle shadow"
                                  width="150" height="150" style="object-fit: cover;">
                          @else
                              <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width:150px; height:150px;">
                                  N/A
                              </div>
                          @endif
                      </div>

                      <div class="col-md-9">
                          <h3>{{ $member->user->firstname }} {{ $member->user->lastname }} ({{$member->user->role()}})</h3>
                          <p><strong>Genre :</strong> {{ $member->user->gender }}</p>
                          <p><strong>Email :</strong> <a href="mailto:{{ $member->user->email }}">{{ $member->user->email }}</a></p>
                          <p><strong>Téléphone :</strong> <a href="tel:{{ $member->user->phone }}">{{ $member->user->phone }}</a></p>
                          <p><strong>Date de naissance :</strong> {{ \Carbon\Carbon::parse($member->user->birthdate)->format('d/m/Y') }}</p>
                          <p><strong>Lieu de naissance :</strong>  {{ $member->user->birthplace_city }}</p>
                          <p><strong>Nationalité :</strong> {{ $member->user->nationality ?? 'Non renseignée' }}</p>
                          <p><strong>Adresse :</strong>
                              {{ $member->user->address_street }}, {{ $member->user->address_postcode }} {{ $member->user->address_city }}
                          </p>
                      </div>
                  </div>

                  {{-- <hr> --}}

                  {{-- <div class="row">
                      <h3 class="mt-5">Parents</h3>
                          <div class="row">
                              <!-- Père -->
                              <div class="col-md-6">
                                  <div class="card mb-3">
                                      <div class="card-header">Père</div>
                                      <div class="card-body">
                                          <p><strong>Prénom :</strong> {{ $student->parent1_firstname ?? 'Non renseigné' }}</p>
                                          <p><strong>Nom :</strong> {{ $student->parent1_lastname ?? 'Non renseigné' }}</p>
                                          <p><strong>Profession :</strong> {{ $student->parent1_profession ?? 'Non renseignée' }}</p>
                                          <p><strong>Téléphone :</strong> {{ $student->parent1_phone ?? 'Non renseigné' }}</p>
                                          <p><strong>Situation :</strong> {{ $student->parent1_relation ?? 'Non renseigné' }}</p>
                                      </div>
                                  </div>
                              </div>

                              <!-- Mère -->
                              <div class="col-md-6">
                                  <div class="card mb-3">
                                      <div class="card-header">Mère</div>
                                      <div class="card-body">
                                          <p><strong>Prénom :</strong> {{ $student->parent2_firstname ?? 'Non renseigné' }}</p>
                                          <p><strong>Nom :</strong> {{ $student->parent2_lastname ?? 'Non renseigné' }}</p>
                                          <p><strong>Profession :</strong> {{ $student->parent2_profession ?? 'Non renseignée' }}</p>
                                          <p><strong>Téléphone :</strong> {{ $student->parent2_phone ?? 'Non renseigné' }}</p>
                                          <p><strong>Situation :</strong> {{ $student->parent2_relation ?? 'Non renseigné' }}</p>
                                      </div>
                                  </div>
                              </div>
                          </div>
                  </div> --}}

                  
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane" id="student" role="tabpanel">
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
                  @forelse ($member->students as $index => $student)
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
      </div>

      <div class="mt-4">
          <a href="{{ route('members.index') }}" class="btn btn-secondary"> Retour</a>
          <a href="{{ route('members.edit', $member->id) }}" class="btn btn-primary">Modifier</a>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
  <script>
  </script>
@endsection
