@extends('layouts.base')

@section('aditionnal_css')
    <!-- Custom CSS -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> --}}
    <link href="{{asset('css/tailwind.min.css')}}" rel="stylesheet">
    <style>
        .progress-container {
            display: flex;
            width: 100%;
        }
        #progress-bar {
            height: 8px;
            background-color: #3b82f6;
            transition: width 0.3s ease-in-out;
        }
        .profile-pic-container {
            position: relative;
            width: 100px;
            height: 100px;
        }
        .profile-pic {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }
        .upload-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 1;
            transition: opacity 0.3s ease;
            border-radius: 50%;
        }
        .profile-pic-container:hover .upload-overlay {
            opacity: 1;
        }
        .upload-input {
            display: none;
        }
    </style>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">                    
                    <div class="flex  mb-4">
                        <h2 class="text-gray w-1/3">1. Identité</h2>
                        <h2 class="text-gray w-1/3">2. Informations</h2>
                        <h2 class="text-gray">3. Parents</h2>
                    </div>
                    <!-- Progress Bar -->
                    <div class="progress-container mb-6">
                        <div id="progress-bar" class="w-1/3" style="height: 8px; background-color: #3b82f6; transition: width 0.3s ease-in-out;"></div>
                        <div class="flex-1 bg-gray-200 w-1/3" style="height: 8px;"></div>
                        <div class="flex-1 bg-gray-200" style="height: 8px;"></div>
                    </div>
                    <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data" id="form_data">
                        @csrf
                        <!-- Step 1: Identity -->
                        <div id="step1" class="bg-white p-6 rounded shadow" >
                            <div class="form-group mb-4">
                                <div class="w-1/4 flex mb-3">
                                    <div class="profile-pic-container mr-4">
                                        <img id="profile-pic" src="https://via.placeholder.com/100?text=Profile" alt="" class="profile-pic">
                                        <label for="photo-upload" class="upload-overlay cursor-pointer">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h4l2-2h2l2 2h4a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </label>
                                        <input id="photo-upload" type="file" name="photo" accept="image/*" class="upload-input">
                                    </div>
                                    
                                    <div class="flex space-x-4">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="gender" value="M" class="form-radio" checked>
                                            <span class="ml-2 text-gray-700">Masculin</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="gender" value="F" class="form-radio">
                                            <span class="ml-2 text-gray-700">Féminin</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="w-4/4">
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-gray-700">Nom</label>
                                            <input type="text" name="lastname" class="w-full p-2 border rounded form-control">
                                        </div>
                                        <div>
                                            <label class="block text-gray-700">Prénom</label>
                                            <input type="text" name="firstname" class="w-full p-2 border rounded form-control">
                                        </div>
                                        <div>
                                            <label class="block text-gray-700">Email</label>
                                            <input type="email" name="email" class="w-full p-2 border rounded form-control">
                                        </div>
                                        <div>
                                            <label class="block text-gray-700">Portable</label>
                                            <input type="tel" name="phone" class="w-full p-2 border rounded form-control">
                                        </div>
                                        <div>
                                            <label class="block text-gray-700">Conseiller-ère</label>
                                            <select name="advisor_id" class="select2 form-select" placeholder="Selectionner les matières">
                                                <option value=""  disabled>Selectionner un(e) conseiller-ère</option>
                                                @foreach ($advisors as $key => $advisor)
                                                    @if($advisor->user->hasRole('advisor'))
                                                    <option class="form-control-alt" data-tokens="{{ $advisor->user->firstname }} {{ $advisor->user->lastname }}"
                                                        @if (old('advisor_id') == $key) @php($advisored = TRUE) selected  @endif
                                                        value="{{ $advisor->id }}">{{ $advisor->user->firstname }} {{ $advisor->user->lastname }}</option>
                                                    @php($advisored = false)
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-gray-700">Affectation aux groupes</label>
                                            <select name="group_id" class="select2 form-select"  placeholder="Selectionner les groupes" title="Sélectionner les groupes">
                                                <option value=""  disabled>Selectionner un groupe</option>
                                                @foreach($groups as $group)
                                                    <option data-tokens="{{ $group->fullname }}"
                                                        @if(old('group_id')) selected @php($selected = TRUE) @endif
                                                        value="{{$group->id}}">{{ $group->fullname }}
                                                    </option>
                                                    @php($selected = FALSE)
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-end mt-6">
                                {{-- <button type="button" class="btn btn-secondary text-white px-4 py-2 rounded">Précédent</button> --}}
                                <button type="button" id="nextBtn" class="btn btn-primary text-white px-4 py-2 rounded">Suivant</button>
                            </div>
                        </div>

                        <!-- Step 2: Information -->
                        <div id="step2" class="bg-white p-6 rounded shadow mt-6 hidden">
                            <div class="space-y-4">
                                <div class="flex space-x-4">
                                    <div class="w-1/3">
                                        <label class="block text-gray-700">Naissance</label>
                                        <input type="date" name="birthdate" class="w-full p-2 border rounded form-control">
                                    </div>
                                    <div class="w-1/3">
                                        <label class="block text-gray-700">Lieu de naissance</label>
                                        <input type="text" name="birthplace_city" class="w-full p-2 border rounded form-control">
                                    </div>
                                    <div class="w-1/3">
                                        <label class="block text-gray-700">Nationalité</label>
                                        <select name="nationality" class="w-full p-2 border rounded form-select">
                                            <option value="France">Francaise</option>
                                            <option value="Malagasy">Malagasy</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="flex space-x-4">
                                    <div class="w-1/3">
                                        <label class="block text-gray-700">Adresse</label>
                                        <input type="text" name="address_street" class="w-full p-2 border rounded form-control">
                                    </div>
                                    <div class="w-1/3">
                                        <label class="block text-gray-700">Ville</label>
                                        <input type="text" name="address_city" class="w-full p-2 border rounded form-control">
                                    </div>
                                    <div class="w-1/3">
                                        <label class="block text-gray-700">Code postal</label>
                                        <input type="text" name="address_postcode" class="w-full p-2 border rounded form-control">
                                    </div>
                                    <div class="w-1/3">
                                        <label class="block text-gray-700">Pays</label>
                                        <select name="country" class="w-full p-2 border rounded form-select">
                                            <option value="France">France</option>
                                            <option value="Madagascar">Madagascar</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-between mt-6">
                                <button type="button" id="prevBtn" class="btn btn-secondary text-white px-4 py-2 ">Précédent</button>
                                <button type="submit" id="nexttwo" class="btn btn-primary text-white px-4 py-2 ">Suivant</button>
                            </div>
                        </div>
                        <div id="step3" class="bg-white p-6 rounded shadow mt-6 hidden">
                            <div class="d-flex">
                                <!-- Père -->
                                <div class="card col-md-6">
                                    <div class="card-body">
                                        <h3 class="card-title">Père :</h3>
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
                                                <input type="text" name="father_profession" class="form-control" value="{{ old('father_profession') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 text-end col-form-label">Téléphone</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="father_phone" class="form-control" value="{{ old('father_phone') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 text-end col-form-label">Situation</label>
                                            <div class="col-sm-9">
                                                <select name="father_relation" class="w-full p-2 border rounded form-select">
                                                    <option value="celibat">Célibataire</option>
                                                    <option value="marie">Marié</option>
                                                    <option value="veuf">Veuf</option>
                                                    <option value="separe">Séparé</option>
                                                    <option value="divorce">Divorcé</option>
                                                    <option value="union">Union libre</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Mère -->
                                <div class="card col-md-6">
                                    <div class="card-body">
                                        <h3 class="card-title">Mère :</h3>
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
                                                <input type="text" name="mother_profession" class="form-control" value="{{ old('mother_profession') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 text-end col-form-label">Téléphone</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="mother_phone" class="form-control" value="{{ old('mother_phone') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 text-end col-form-label">Situation</label>
                                            <div class="col-sm-9">
                                                <select name="mother_relation" class="w-full p-2 border rounded form-select">
                                                    <option value="celibat">Célibataire</option>
                                                    <option value="marie">Mariée</option>
                                                    <option value="veuf">Veuve</option>
                                                    <option value="separe">Séparée</option>
                                                    <option value="divorce">Divorcée</option>
                                                    <option value="union">Union libre</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-between mt-6">
                                <button type="button" id="prevtwo" class="btn btn-secondary text-white px-4 py-2 ">Précédent</button>
                                <button type="submit" id="submitBtn" class="btn btn-primary text-white px-4 py-2 ">Enregistrer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @if(Session::has('success'))
        <script>
            toastr.success("{{ Session::get('success') }}", "Succès!");
        </script>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const step1 = document.getElementById('step1');
            const step2 = document.getElementById('step2');
            const step3 = document.getElementById('step3');
            const nextBtn = document.getElementById('nextBtn');
            const nexttwo = document.getElementById('nexttwo');
            const prevBtn = document.getElementById('prevBtn');
            const prevtwo = document.getElementById('prevtwo');
            const submitBtn = document.getElementById('submitBtn');
            const progressBar = document.getElementById('progress-bar');
            const photoUpload = document.getElementById('photo-upload');
            const profilePic = document.getElementById('profile-pic');

            // Handle image preview with error handling
            photoUpload.addEventListener('change', function (e) {
                try {
                    const file = e.target.files[0];
                    if (!file) {
                        alert('Aucun fichier sélectionné.');
                        return;
                    }

                    // Validate file type
                    if (!file.type.startsWith('image/')) {
                        alert('Veuillez sélectionner une image valide (jpg, png, etc.).');
                        return;
                    }

                    // Validate file size (e.g., max 5MB)
                    const maxSize = 5 * 1024 * 1024; // 5MB in bytes
                    if (file.size > maxSize) {
                        alert('L\'image est trop volumineuse. La taille maximale est de 5 Mo.');
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function (e) {
                        try {
                            profilePic.src = e.target.result;
                        } catch (error) {
                            console.error('Erreur lors de l\'affichage de l\'image:', error);
                            alert('Impossible d\'afficher l\'image. Vérifiez la console pour plus de détails.');
                        }
                    };
                    reader.onerror = function (error) {
                        console.error('Erreur lors de la lecture du fichier:', error);
                        alert('Erreur lors de la lecture du fichier image. Vérifiez la console pour plus de détails.');
                    };
                    reader.readAsDataURL(file);
                } catch (error) {
                    console.error('Erreur dans le gestionnaire de changement d\'image:', error);
                    alert('Une erreur est survenue lors du chargement de l\'image. Vérifiez la console.');
                }
            });

            // Validation for Step 1
            function validateStep1() {
                try {
                    const lastName = step1.querySelector('input[name="lastname"]').value.trim();
                    const firstName = step1.querySelector('input[name="firstname"]').value.trim();
                    const phone = step1.querySelector('input[name="phone"]').value.trim();
                    const email = step1.querySelector('input[name="email"]').value.trim();
                    const gender = step1.querySelector('input[name="gender"]:checked');
                    if(photoUpload.files[0]){
                        const photo = photoUpload.files[0];
                    }
                    

                    // Check for missing fields
                    if (!lastName) {
                        step1.querySelector('input[name="lastname"]').focus();
                        $('input[name="lastname"]').addClass('is-invalid');
                        return false;
                    }else{
                        $('input[name="lastname"]').removeClass('is-invalid');
                    }
                    if (!firstName) {
                        step1.querySelector('input[name="firstname"]').focus();
                        $('input[name="firstname"]').addClass('is-invalid');
                        return false;
                    }else{
                        $('input[name="firstname"]').removeClass('is-invalid');
                    }
                    if (!email) {
                        step1.querySelector('input[name="email"]').focus();
                        $('input[name="email"]').addClass('is-invalid');
                        return false;
                    }else{
                        $('input[name="email"]').removeClass('is-invalid');
                    }
                    if (!phone) {
                        step1.querySelector('input[name="phone"]').focus();
                        $('input[name="phone"]').addClass('is-invalid');
                        return false;
                    }else{
                        $('input[name="phone"]').removeClass('is-invalid');
                    }
                    
                    // if (!photo) {
                    //     alert("Une image de profil est requise. Veuillez sélectionner une image.");
                    //     return false;
                    // }

                    // Email validation
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(email)) {
                        step1.querySelector('input[name="email"]').focus();
                        $('input[name="email"]').addClass('is-invalid');
                        toastr.error('Adresse mail non valide','Erreur!')
                        return false;
                    }else{
                        $('input[name="email"]').removeClass('is-invalid');
                    }

                    // Phone validation
                    const phoneRegex = /^\+?[0-9]{10,15}$/;
                    if (!phoneRegex.test(phone)) {
                        step1.querySelector('input[name="phone"]').focus();
                        $('input[name="phone"]').addClass('is-invalid');
                        toastr.error('Numéro téléphone non valide','Erreur!')
                        return false;
                    }else{
                        $('input[name="phone"]').removeClass('is-invalid');
                    }

                    return true;
                } catch (error) {
                    toastr.error('Veuillez completer les champs requis','Erreur!')
                    return false;
                }
            }

            // Validation for Step 2
            function validateStep2() {
                try {
                    const birthDate = step2.querySelector('input[name="birthdate"]').value;
                    const birthPlace = step2.querySelector('input[name="birthplace_city"]').value.trim();
                    const nationality = step2.querySelector('select[name="nationality"]').value;
                    const address = step2.querySelector('input[name="address_street"]').value.trim();
                    const city = step2.querySelector('input[name="address_city"]').value.trim();
                    const zipCode = step2.querySelector('input[name="address_postcode"]').value.trim();
                    const country = step2.querySelector('select[name="country"]').value;
                    // Check for missing fields
                    if (!birthDate) {
                        $('input[name="birthdate"]').addClass('is-invalid');
                        step2.querySelector('input[name="birthdate"]').focus();
                        return false;
                    }else{
                        $('input[name="birthdate"]').removeClass('is-invalid');
                    }
                    if (!birthPlace) {
                        $('input[name="birthplace_city"]').addClass('is-invalid');
                        step2.querySelector('input[name="birthplace_city"]').focus();
                        return false;
                    }else{
                        $('input[name="birthplace_city"]').removeClass('is-invalid');
                    }
                    if (!nationality) {
                        $('input[name="nationality"]').addClass('is-invalid');
                        step2.querySelector('input[name="nationality"]').focus();
                        return false;
                    }else{
                        $('input[name="nationality"]').removeClass('is-invalid');
                    }
                    if (!address) {
                        $('input[name="address_street"]').addClass('is-invalid');
                        step2.querySelector('input[name="address_street"]').focus();
                        return false;
                    }else{
                        $('input[name="address_street"]').removeClass('is-invalid');
                    }
                    if (!city) {
                        $('input[name="address_city"]').addClass('is-invalid');
                        step2.querySelector('input[name="address_city"]').focus();
                        return false;
                    }else{
                        $('input[name="address_city"]').removeClass('is-invalid');
                    }
                    if (!zipCode) {
                        $('input[name="address_postcode"]').addClass('is-invalid');
                        step2.querySelector('input[name="address_postcode"]').focus();
                        return false;
                    }else{
                        $('input[name="address_postcode"]').removeClass('is-invalid');
                    }
                    if (!country) {
                        $('input[name="country"]').addClass('is-invalid');
                        step2.querySelector('input[name="country"]').focus();
                        return false;
                    }else{
                        $('input[name="country"]').removeClass('is-invalid');
                    }

                    return true;
                } catch (error) {
                    toastr.error('Veuillez completer les champs requis','Erreur!')
                    return false;
                }
            }

            // Navigation to Step 2
            nextBtn.addEventListener('click', function (e) {
                e.preventDefault();
                if (validateStep1()) {
                    step1.classList.add('hidden');
                    step2.classList.remove('hidden');
                    progressBar.style.width = 200/3 +'%';
                }
            });

            // Navigation to step 3
            nexttwo.addEventListener('click', function (e) {
                e.preventDefault();
                if (validateStep2()) {
                    step2.classList.add('hidden');
                    step3.classList.remove('hidden');
                    progressBar.style.width = '100%';
                }
            });

            // Navigation back to Step 1
            prevBtn.addEventListener('click', function (e) {
                e.preventDefault();
                step2.classList.add('hidden');
                step1.classList.remove('hidden');
                progressBar.style.width = 100/3 +'%';
            });

            // Navigationback to step 2
            prevtwo.addEventListener('click', function (e) {
                e.preventDefault();
                step3.classList.add('hidden');
                step2.classList.remove('hidden');
                progressBar.style.width = 200/3 +'%';
            });

            // Form submission
            submitBtn.addEventListener('click', function (e) {
                e.preventDefault();
                if (validateStep2()) {
                    $("#form_data").submit();
                }
            });
        });
    </script>
@endsection
