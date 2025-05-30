@extends('layouts.base')

@section('aditionnal_css')
<!-- Custom CSS -->
<link href="{{ asset('assets/libs/jquery-steps/jquery.steps.css') }}" rel="stylesheet">
<link href="{{ asset('assets/libs/jquery-steps/steps.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Création étudiant</h4>
            <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Étudiant</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="card">
        <div class="card-body wizard-content">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="example-form" action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data" class="mt-5">
                @csrf
                <div>
                    <h3>Identité</h3>
                    <section>
                        <label for="photo">Photo *</label>
                        <input type="file" class="form-control" name="photo" accept="image/*" required>

                        <label for="gender">Genre *</label>
                        <div class="form-group d-flex row" style="margin-left: 1px">
                            <div class="form-check col-md-2">
                                <input type="radio" class="form-check-input" id="genderHomme" name="gender" value="M" required checked>
                                <label class="form-check-label mb-0" for="genderHomme">Homme</label>
                            </div>
                            <div class="form-check col-md-2">
                                <input type="radio" class="form-check-input" id="genderFemme" name="gender" value="F" required>
                                <label class="form-check-label mb-0" for="genderFemme">Femme</label>
                            </div>
                        </div>

                        <label for="firstname">Prénom *</label>
                        <input id="firstname" name="firstname" type="text" class="form-control" value="{{ old('firstname') }}" required>

                        <label for="lastname">Nom *</label>
                        <input id="lastname" name="lastname" type="text" class="form-control" value="{{ old('lastname') }}" required>

                        <label for="email">Email *</label>
                        <input id="email" name="email" type="email" class="form-control" value="{{ old('email') }}" required>

                        <label for="phone">Téléphone *</label>
                        <input id="phone" name="phone" type="text" class="form-control" value="{{ old('phone') }}" required>

                        <div class="form-group">
                            <label for="advisor">Conseiller-ère</label>
                            <select name="advisor_id" data-live-search="true"
                                class="form-control form-control-alt selectpicker"
                                title="Sélectionner le/la conseiller/ère">
                                @foreach ($advisors as $key => $advisor)
                                    <option class="form-control-alt" data-tokens="{{ $advisor->user->firstname }} {{ $advisor->user->lastname }}"
                                        @if (old('advisor_id') == $key) @php($advisored = TRUE) selected  @endif
                                        value="{{ $advisor->id }}">{{ $advisor->user->firstname }} {{ $advisor->user->lastname }}</option>
                                    @php($advisored = false)
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-3">
                          <label>Groupe</label>
                          <select name="group_id" class="select2 form-select shadow-none mt-3"
                          title="Sélectionner le groupe">
                            @foreach($groups as $group)
                              <option data-tokens="{{ $group->abbreviation }}"
                                @if(old('group_id')) selected @php($selected = TRUE) @endif
                                value="{{$group->id}}">{{ $group->abbreviation }}
                              </option>
                              @php($selected = FALSE)
                            @endforeach
                          </select>
                        </div>

                        <p class="text-warning">(*) Champ obligatoire</p>
                    </section>

                    <h3>Information</h3>
                    <section>
                        <label for="birth">Date de naissance *</label>
                        <input id="birth" name="birthdate" type="date" class="form-control" value="{{ old('birthdate') }}" required>

                        <label for="lieu">Lieu de naissance : *</label>
                        <input id="lieu" name="birthplace_city" type="txt" class="form-control" value="{{ old('birthplace_city') }}" required>

                        <label for="nationality">Nationalité *</label>
                        <input id="nationality" name="nationality" type="text" class="form-control" value="{{ old('nationality') }}" required>

                        <label for="address">Adresse</label>
                        <input id="address" name="address_city" type="text" class="form-control" value="{{ old('address_city') }}">

                        <p class="text-warning">(*) Champ obligatoire</p>
                    </section>

                    <h3>Parents</h3>
                    <section>
                        <div class="d-flex col-md-12">
                            <!-- Père -->
                            <div class="card col-md-6">
                                <div class="card-body">
                                    <h4 class="card-title">Père</h4>
                                    <div class="form-group row">
                                        <label class="col-sm-3 text-end col-form-label">Prénom</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="father_firstname" class="form-control" value="{{ old('father_firstname') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 text-end col-form-label">Nom</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="father_lastname" class="form-control" value="{{ old('father_lastname') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 text-end col-form-label">Profession</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="father_company" class="form-control" value="{{ old('father_company') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 text-end col-form-label">Téléphone</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="father_phone" class="form-control" value="{{ old('father_phone') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 text-end col-form-label">Message</label>
                                        <div class="col-sm-9">
                                            <textarea name="father_message" class="form-control">{{ old('father_message') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Mère -->
                            <div class="card col-md-6">
                                <div class="card-body">
                                    <h4 class="card-title">Mère</h4>
                                    <div class="form-group row">
                                        <label class="col-sm-3 text-end col-form-label">Prénom</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="mother_firstname" class="form-control" value="{{ old('mother_firstname') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 text-end col-form-label">Nom</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="mother_lastname" class="form-control" value="{{ old('mother_lastname') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 text-end col-form-label">Profession</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="mother_company" class="form-control" value="{{ old('mother_company') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 text-end col-form-label">Téléphone</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="mother_phone" class="form-control" value="{{ old('mother_phone') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 text-end col-form-label">Message</label>
                                        <div class="col-sm-9">
                                            <textarea name="mother_message" class="form-control">{{ old('mother_message') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/libs/jquery-steps/build/jquery.steps.min.js') }}"></script>
<script src="{{ asset('assets/libs/jquery-validation/dist/jquery.validate.min.js') }}"></script>
<script>
    var form = $("#example-form");
    form.validate({
        errorPlacement: function errorPlacement(error, element) {
            element.before(error);
        }
    });

    form.children("div").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        onStepChanging: function (event, currentIndex, newIndex) {
            form.validate().settings.ignore = ":disabled,:hidden";
            return form.valid();
        },
        onFinishing: function (event, currentIndex) {
            form.validate().settings.ignore = ":disabled";
            return form.valid();
        },
        onFinished: function (event, currentIndex) {
            form.submit(); // Important : submit le formulaire
        }
    });
</script>
@endsection
