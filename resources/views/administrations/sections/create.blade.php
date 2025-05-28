@extends('layouts.base')

@section('aditionnal_css')
<!-- Custom CSS -->
@endsection

@section('content')
    <?php
        function yearth(int $number): string {
            return match($number) {
                1 => '1ère année',
                2 => '2ème année',
                3 => '3ème année',
                4 => '4ème année',
                5 => '5ème année',
                default => $number . 'ème'
            };
        }
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route('sections.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <h5 class="card-title mb-0">Ajouter une sections</h5>
                        <div class="form-group mt-3">
                            <label>Intitulé</label>
                            <input class="form-control" type="text" name="name" placeholder="ex: Genie logiciel" required>
                        </div>
                        <div class="form-group mt-3">
                            <label>Abréviation</label>
                            <input class="form-control" type="text" name="abbreviation" placeholder="ex: GL" required>
                        </div>
                        <div class="form-group mt-3">
                            <label>Année de la section</label>
                            <select name="promotion" class="form-control selectpicker" title="Sélectionner l'année">
                                @for($i=1; $i<=5; $i++)
                                    <option class="form-control" data-tokens="{{ yearth($i) }}"
                                            @if(old('promotion') == $i) @php($selected = TRUE) selected @endif
                                            value="{{ $i }}">{{ yearth($i) }}
                                    </option>
                                    @php($selected = FALSE)
                                @endfor
                            </select>
                        </div>
                        <div class="form-group mt-3">
                            <label>Prix année scolaire</label>
                            <input class="form-control" type="text" name="praicing" placeholder="ex: 200 000" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success btn-rounded">Ajouter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/libs/inputmask/dist/min/jquery.inputmask.bundle.min.js')}}"></script>
    <script>
    </script>
@endsection
