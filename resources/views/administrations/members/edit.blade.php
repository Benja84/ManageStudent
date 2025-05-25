@extends('layouts.base')

@section('aditionnal_css')
<!-- Custom CSS -->
<link href="{{ asset('assets/libs/jquery-steps/jquery.steps.css') }}" rel="stylesheet">
<link href="{{ asset('assets/libs/jquery-steps/steps.css') }}" rel="stylesheet">
@endsection

@section('content')

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

            <form id="example-form" action="{{ route('members.update',$member->id) }}" method="POST" enctype="multipart/form-data" class="mt-2">
                @csrf
                @method('PUT')
                <input type="hidden" value="{{ $member->user->id }}" name="id">
                <div>
                    <h3>Identité</h3>
                    <section>
                        <label for="photo">Photo </label>
                        <div class="col-md-6">
                          <input type="file" class="col-md-6 form-control mb-2" name="photo"  >
                        </div>

                        <label for="gender">Genre *</label>
                        <div class="form-group d-flex row  mb-3" style="margin-left: 1px">
                            <div class="form-check col-md-2">
                                <input type="radio" class="form-check-input" id="genderHomme" name="gender" value="M" required @if($member->user->gender == "M")checked @endif>
                                <label class="form-check-label mb-0" for="genderHomme">Homme</label>
                            </div>
                            <div class="form-check col-md-2">
                                <input type="radio" class="form-check-input" id="genderFemme" name="gender" value="F" required @if($member->user->gender == "F")checked @endif>
                                <label class="form-check-label mb-0" for="genderFemme">Femme</label>
                            </div>
                        </div>

                        <label for="firstname">Prénom *</label>
                        <input id="firstname" name="firstname" type="text" class="form-control mb-2" value="{{ $member->user->firstname }}" required>

                        <label for="lastname">Nom *</label>
                        <input id="lastname" name="lastname" type="text" class="form-control mb-2" value="{{ $member->user->lastname }}" required>

                        <label for="email">Email *</label>
                        <input id="email" name="email" type="email" class="form-control mb-2" value="{{ $member->user->email }}" required>

                        <label for="phone">Téléphone *</label>
                        <input id="phone" name="phone" type="text" class="form-control mb-2" value="{{ $member->user->phone }}" required>
                        
                        {{-- <div class="form-group row">
                          <label for="role" class="mt-3">Rôles *</label>
                          <div class="col-md-6">
                            <select class="select2 form-select shadow-none" name="role" id="role" style="width: 100%; height:36px;">
                              <option value="">Select</option>
                              @foreach($roles as $key => $role)
                                <option value="{{ $key }}" @if(old('phone') == $key) selected @endif>{{ $role }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div> --}}
                        <p class="text-warning">(*) Champ obligatoire</p>
                    </section>

                    <h3>Information</h3>
                    <section>
                        <label for="birth">Date de naissance *</label>
                        <input id="birth" name="birthdate" type="date" class="form-control" value="{{ $member->user->birthdate }}" required>

                        <label for="lieu">Lieu de naissance : *</label>
                        <input id="lieu" name="birthplace_city" type="txt" class="form-control" value="{{ $member->user->birthplace_city }}" required>

                        <label for="nationality">Nationalité </label>
                        <input id="nationality" name="nationality" type="text" class="form-control" value="{{ $member->user->nationality }}" >

                        <label for="address">Adresse</label>
                        <input id="address" name="address_city" type="text" class="form-control" value="{{ $member->user->address_city }}">

                        <p class="text-warning">(*) Champ obligatoire</p>
                    </section>
                </div>
            </form>
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
