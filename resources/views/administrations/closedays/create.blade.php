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
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <h4><i class="icon fa fa-check"></i> Succès!</h4>
            {!! $message !!}
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{route('closedays.store')}}" method="POST">
                @csrf
                    <div class="card-body">
                        <h5 class="card-title mb-0">Ajouter des jours fermés</h5>
                        <div class="form-group mt-3">
                            <label>Période</label>
                            <div class="d-flex justify-content-between">
                                <div class="col-md-3">
                                    <select class="select2 form-select shadow-none col-md-2" name="type" required>
                                        <option value="" disabled selected >Selectionner le type de jour fermé</option>
                                        @foreach (closed_day_types() as $closeddaytype => $localeWeekday)
                                            <option class="form-control" data-tokens="{{ $localeWeekday }}"
                                                @if(old('type') == $closeddaytype) @php($selected = TRUE) selected
                                                @elseif(empty($selected) && !empty($closed_day->closeddaytype) && $closed_day->closeddaytype == $localeWeekday) @php($selected = TRUE) selected
                                                @endif
                                                value="{{ $closeddaytype }}">{{ $localeWeekday }}</option>
                                            @php($selected = FALSE)
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control col-md-2 start_date datepicker" type="text" name="start_date" placeholder="Date début (dd/mm/yyyy)" required> 
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control col-md-2 end_date  datepicker" type="text" name="end_date" placeholder="Date fin (dd/mm/yyyy)" required> 
                                </div>
                                <div class="col-md-5">
                                    <input class="form-control col-md-2 " type="text" name="description" placeholder="Déscription"> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-default ">Ajouter</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover table-vcenter">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($closed_days as $closed_day)
                            <tr
                                @if($closed_day->type == 'general_holiday') class="bg-gray-light"
                                @elseif($closed_day->type == 'school_holiday') class="bg-flat-lighter"
                                @elseif($closed_day->type == 'special_day') class="bg-smooth-lighter" @endif>
                                <td>{{ $closed_day->getDateFrenchFormatAttribute() }}</td>
                                <td>{{ closed_day_types()[$closed_day->type] }}</td>
                                <td>{{ $closed_day->description ?? '--' }}</td>
                                <td>
                                   <div class="d-flex">
                                        {{-- <button class="btn btn-edit"><i class="fa fa-edit"></i></button> --}}
                                        <form action="{{ route('closedays.destroy', $closed_day->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer ?')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                   </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" align="center">Aucun jour fermé</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function (){
            let errors = @json($errors->all());
            errors.forEach(error => {
                toastr.error('I do not think that word means what you think it means.', 'Inconceivable!');
            });

            
            $('.end_date').on('change',function(){
                const start = new Date($('.start_date').val());
                const end = new Date($(this).val());
                if(start != ""){
                    if( start > end){
                        $('.end_date').addClass('is-invalid');
                        toastr.error('La date début doit inférieur ou égal à la date fin','Erreur date!');
                    }else{
                        $('.end_date').removeClass('is-invalid');
                    }
                }
            })
        });

    </script>
@endsection
