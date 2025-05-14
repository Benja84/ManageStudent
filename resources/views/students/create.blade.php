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
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Library</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="card">
        <div class="card-body wizard-content">
            <form id="example-form" action="#" class="mt-5">
                <div>
                    <h3>Identité</h3>
                    <section>
                        <label for="genre">Genre *</label>
                        <div class="form-group d-flex row" style="margin-left: 1px">
                            <div class="form-check col-md-2">
                                <input type="radio" class="form-check-input" id="customControlValidation1" name="gender" required checked>
                                <label class="form-check-label mb-0" for="customControlValidation1">Homme</label>
                            </div>
                            <div class="form-check col-md-2">
                                <input type="radio" class="form-check-input"
                                    id="customControlValidation2" name="gender" required>
                                <label class="form-check-label mb-0" for="customControlValidation2">Femme</label>
                            </div>
                        </div>
                        <label for="firstname">Prenom *</label>
                        <input id="firstname" name="firstname" type="text" class="required form-control">
                        <label for="lastname">Nom *</label>
                        <input id="lastname" name="lastname" type="text" class="required form-control">
                        <label for="email">Email *</label>
                        <input id="email" name="email" type="email" class="required email form-control">
                        <label for="phone">Téléphone *</label>
                        <input id="phone" name="phone" type="text" class="required phone form-control">
                        
                        <p class="text-warning">(*) Champ obligatoire</p>
                    </section>
                    <h3>Information</h3>
                    <section>
                        <label for="birth">Naissance *</label>
                        <input id="birth" name="birth" type="date" class="required form-control">
                        <label for="nationality">Nationalité *</label>
                        <input id="nationality" name="nationality" type="text" class="required form-control">
                        
                        <label for="address">Address</label>
                        <input id="address" name="address" type="text" class=" form-control">
                        <p>(*) Mandatory</p>
                    </section>
                    <h3>Parents</h3>
                    <section>
                        <div class="d-flex col-md-12">
                            <div class="card col-md-6">
                                <div class="card-body">
                                    <h4 class="card-title">Père</h4>
                                    <div class="form-group row">
                                        <label for="fname"
                                            class="col-sm-3 text-end control-label col-form-label">First Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="fname"
                                                placeholder="First Name Here">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="lname" class="col-sm-3 text-end control-label col-form-label">Last
                                            Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="lname"
                                                placeholder="Last Name Here">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="lname"
                                            class="col-sm-3 text-end control-label col-form-label">Password</label>
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control" id="lname"
                                                placeholder="Password Here">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="email1"
                                            class="col-sm-3 text-end control-label col-form-label">Company</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="email1"
                                                placeholder="Company Name Here">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="cono1"
                                            class="col-sm-3 text-end control-label col-form-label">Contact No</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="cono1"
                                                placeholder="Contact No Here">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="cono1"
                                            class="col-sm-3 text-end control-label col-form-label">Message</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- parent 2 --}}
                            <div class="card col-md-6">
                                <div class="card-body">
                                    <h4 class="card-title">Mère</h4>
                                    <div class="form-group row">
                                        <label for="fname"
                                            class="col-sm-3 text-end control-label col-form-label">First Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="fname"
                                                placeholder="First Name Here">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="lname" class="col-sm-3 text-end control-label col-form-label">Last
                                            Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="lname"
                                                placeholder="Last Name Here">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="lname"
                                            class="col-sm-3 text-end control-label col-form-label">Password</label>
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control" id="lname"
                                                placeholder="Password Here">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="email1"
                                            class="col-sm-3 text-end control-label col-form-label">Company</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="email1"
                                                placeholder="Company Name Here">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="cono1"
                                            class="col-sm-3 text-end control-label col-form-label">Contact No</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="cono1"
                                                placeholder="Contact No Here">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="cono1"
                                            class="col-sm-3 text-end control-label col-form-label">Message</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control"></textarea>
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
        // Basic Example with form
        var form = $("#example-form");
        form.validate({
            errorPlacement: function errorPlacement(error, element) { element.before(error); },
            rules: {
                confirm: {
                    equalTo: "#password"
                }
            }
        });
        form.children("div").steps({
            headerTag: "h3",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            onStepChanging: function (event, currentIndex, newIndex) {
                form.validate().settings.ignore = ":disabled,:hidden";
                console.log('event',event)
                return form.valid();
            },
            onFinishing: function (event, currentIndex) {
                form.validate().settings.ignore = ":disabled";
                return form.valid();
            },
            onFinished: function (event, currentIndex) {
                console.log('event',currentIndex)
            }
        });


    </script>
@endsection