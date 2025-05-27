@extends('layouts.base')

@section('aditionnal_css')
<!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/jquery-minicolors/jquery.minicolors.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/quill/dist/quill.snow.css') }}">
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-0">Ajouter un cours</h5>
                    <div class="form-group mt-3">
                        <label>Matière</label>
                        <select class="select2 form-select shadow-none" style="width: 100%; height:36px;" name="subject">
                            <option value="">Select</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <label>Professeur</label>
                        <select class="select2 form-select shadow-none" style="width: 100%; height:36px;" name="subject">
                            <option value="">Select</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <label>Salle</label>
                        <select class="select2 form-select shadow-none" style="width: 100%; height:36px;" name="subject">
                            <option value="">Select</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}">{{ $room->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <label>Classe</label>
                        <select class="select2 form-select shadow-none" style="width: 100%; height:36px;" name="subject">
                            <option value="">GL</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}">{{ $room->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <label>Période</label>
                        <div class="d-flex">
                            <div class="col-md-2">
                                <select class="select2 form-select shadow-none col-md-2" style="width: 100%; height:36px;" name="subject">
                                    <option value="">Select</option>
                                    @foreach($rooms as $room)
                                        <option value="{{ $room->id }}">{{ $room->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/libs/inputmask/dist/min/jquery.inputmask.bundle.min.js')}}"></script>
    <script src="{{ asset('dist/js/pages/mask/mask.init.js')}}"></script>
    <script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js')}}"></script>
    <script src="{{ asset('assets/libs/select2/dist/js/select2.min.js')}}"></script>
    <script src="{{ asset('assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
    <script>
        //***********************************//
        // For select 2
        //***********************************//
        $(".select2").select2();

        /*colorpicker*/
        $('.demo').each(function () {
            //
            // Dear reader, it's actually very easy to initialize MiniColors. For example:
            //
            //  $(selector).minicolors();
            //
            // The way I've done it below is just for the demo, so don't get confused
            // by it. Also, data- attributes aren't supported at this time...they're
            // only used for this demo.
            //
            $(this).minicolors({
                control: $(this).attr('data-control') || 'hue',
                position: $(this).attr('data-position') || 'bottom left',

                change: function (value, opacity) {
                    if (!value) return;
                    if (opacity) value += ', ' + opacity;
                    if (typeof console === 'object') {
                        console.log(value);
                    }
                },
                theme: 'bootstrap'
            });

        });
        /*datwpicker*/
        jQuery('.mydatepicker').datepicker();
        jQuery('#datepicker-autoclose').datepicker({
            autoclose: true,
            todayHighlight: true
        });

    </script>
@endsection
