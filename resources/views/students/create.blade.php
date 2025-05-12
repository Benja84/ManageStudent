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
                    <h3>Account</h3>
                    <section>
                        <label for="userName">User name *</label>
                        <input id="userName" name="userName" type="text" class="required form-control">
                        <label for="password">Password *</label>
                        <input id="password" name="password" type="text" class="required form-control">
                        <label for="confirm">Confirm Password *</label>
                        <input id="confirm" name="confirm" type="text" class="required form-control">
                        <p>(*) Mandatory</p>
                    </section>
                    <h3>Profile</h3>
                    <section>
                        <label for="name">First name *</label>
                        <input id="name" name="name" type="text" class="required form-control">
                        <label for="surname">Last name *</label>
                        <input id="surname" name="surname" type="text" class="required form-control">
                        <label for="email">Email *</label>
                        <input id="email" name="email" type="text" class="required email form-control">
                        <label for="address">Address</label>
                        <input id="address" name="address" type="text" class=" form-control">
                        <p>(*) Mandatory</p>
                    </section>
                    <h3>Hints</h3>
                    <section>
                        <ul>
                            <li>Foo</li>
                            <li>Bar</li>
                            <li>Foobar</li>
                        </ul>
                    </section>
                    <h3>Finish</h3>
                    <section>
                        <input id="acceptTerms" name="acceptTerms" type="checkbox" class="required">
                        <label for="acceptTerms">I agree with the Terms and Conditions.</label>
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
                return form.valid();
            },
            onFinishing: function (event, currentIndex) {
                form.validate().settings.ignore = ":disabled";
                return form.valid();
            },
            onFinished: function (event, currentIndex) {
                alert("Submitted!");
            }
        });


    </script>
@endsection