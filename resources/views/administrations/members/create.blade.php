@extends('layouts.base')

@section('aditionnal_css')
<!-- Custom CSS -->
<link href="{{ asset('assets/libs/jquery-steps/jquery.steps.css') }}" rel="stylesheet">
<link href="{{ asset('assets/libs/jquery-steps/steps.css') }}" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card-body">
                
                <div class="flex  mb-4">
                    <h2 class="text-gray w-1/2">1 Identité</h2>
                    <h2 class="text-gray">2 Informations</h2>
                </div>
                <!-- Progress Bar -->
                <div class="progress-container mb-6">
                    <div id="progress-bar" class="w-1/2" style="height: 8px; background-color: #3b82f6; transition: width 0.3s ease-in-out;"></div>
                    <div class="flex-1 bg-gray-200" style="height: 8px;"></div>
                </div>
                <div id="step1" class="bg-white p-6 rounded shadow" enctype="multipart/form-data">
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
                                <label for="lastname">Nom <span class="text-warning">*</span></label>
                                <input id="lastname" name="lastname" type="text" class="w-full p-2 border rounded form-control" value="{{ old('lastname') }}" required>

                                <label for="firstname">Prénom <span class="text-warning">*</span></label>
                                <input id="firstname" name="firstname" type="text" class="w-full p-2 border rounded form-control " value="{{ old('firstname') }}" required>

                                <label for="email">Email <span class="text-warning">*</span></label>
                                <input id="email" name="email" type="email" class="w-full p-2 border rounded form-control" value="{{ old('email') }}" required>

                                <label for="phone">Téléphone <span class="text-warning">*</span></label>
                                <input id="phone" name="phone" type="text" class="w-full p-2 border rounded form-control" value="{{ old('phone') }}" required>
                                
                                <div>
                                    <label class="block text-gray-700">Rôle <span class="text-warning">*</span></label>
                                    <select name="role" class="form-select selectpicker" placeholder="Selectionner les groupes" title="Sélectionner les groupes">
                                        <option value="" selected disabled>Choisissez le rôle</option>
                                        @foreach($roles as $key => $role)
                                            <option value="{{ $key }}" @if(old('role') == $key) selected @endif>{{ $role }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <p class="text-warning mt-3">(*) Champ obligatoire</p>
                    </div>
                    <div class="flex justify-between mt-6">
                        <button type="button" class="btn btn-danger text-white px-4 py-2">Précédent</button>
                        <button type="button" id="nextBtn" class="btn btn-primary px-4 py-2">Suivant</button>
                    </div>
                </div>
                <form id="step2" action="{{ route('members.store') }}" method="POST" class="bg-white p-6 rounded shadow mt-6 hidden" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-4">
                        <div class="flex space-x-4">
                            <div class="w-1/3">
                                <label class="block text-gray-700">Naissance <span class="text-warning">*</span> </label>
                                <input type="date" name="birthdate" class="w-full p-2 border rounded form-control">
                            </div>
                            <div class="w-1/3">
                                <label class="block text-gray-700">Lieu de naissance <span class="text-warning">*</span></label>
                                <input type="text" name="birthplace" class="w-full p-2 border rounded form-control">
                            </div>
                            <div class="w-1/3">
                                <label class="block text-gray-700">Nationalité <span class="text-warning">*</span></label>
                                <select name="nationality" class="w-full p-2 border rounded form-select">
                                    <option value="France">Francaise</option>
                                    <option value="Malagasy">Malagasy</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex space-x-4">
                            <div class="w-1/3">
                                <label class="block text-gray-700">Adresse <span class="text-warning">*</span></label>
                                <input type="text" name="address_street" class="w-full p-2 border rounded form-control">
                            </div>
                            <div class="w-1/3">
                                <label class="block text-gray-700">Ville <span class="text-warning">*</span></label>
                                <input type="text" name="birthplace_city" class="w-full p-2 border rounded form-control">
                            </div>
                            <div class="w-1/3">
                                <label class="block text-gray-700">Code postal <span class="text-warning">*</span></label>
                                <input type="text" name="address_postcode" class="w-full p-2 border rounded form-control">
                            </div>
                            <div class="w-1/3">
                                <label class="block text-gray-700">Pays <span class="text-warning">*</span></label>
                                <select name="country" class="w-full p-2 border rounded form-select">
                                    <option value="France">France</option>
                                    <option value="Madagascar">Madagascar</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <p class="text-warning mt-3">(*) Champ obligatoire</p>
                    <div class="flex justify-between mt-6">
                        <button type="button" id="prevBtn" class="btn btn-danger text-white px-4 py-2 ">Précédent</button>
                        <button type="submit" id="submitBtn" class="btn btn-primary text-white px-4 py-2 ">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const step1 = document.getElementById('step1');
        const step2 = document.getElementById('step2');
        const nextBtn = document.getElementById('nextBtn');
        const prevBtn = document.getElementById('prevBtn');
        const submitBtn = document.getElementById('submitBtn');
        const progressBar = document.getElementById('progress-bar');
        const photoUpload = document.getElementById('photo-upload');
        const profilePic = document.getElementById('profile-pic');

        // Handle image preview with error handling
        photoUpload.addEventListener('change', function (e) {
            try {
                const file = e.target.files[0];
                if (!file) {
                    toastr.error('Aucun fichier sélectionné.','Erreur !');
                    return;
                }

                // Validate file type
                if (!file.type.startsWith('image/')) {
                    toastr.error('Veuillez sélectionner une image valide (jpg, png, etc.).','Erreur !');
                    return;
                }

                // Validate file size (e.g., max 5MB)
                const maxSize = 5 * 1024 * 1024; // 5MB in bytes
                if (file.size > maxSize) {
                    toastr.error('L\'image est trop volumineuse. La taille maximale est de 5 Mo.','Erreur !');
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (e) {
                    try {
                        profilePic.src = e.target.result;
                    } catch (error) {
                        console.error('Erreur lors de l\'affichage de l\'image:', error);
                        toastr.error('Impossible d\'afficher l\'image. Vérifiez la console pour plus de détails.','Erreur !');
                    }
                };
                reader.onerror = function (error) {
                    console.error('Erreur lors de la lecture du fichier:', error);
                    toastr.error('Erreur lors de la lecture du fichier image. Vérifiez la console pour plus de détails.','Erreur !');
                };
                reader.readAsDataURL(file);
            } catch (error) {
                console.error('Erreur dans le gestionnaire de changement d\'image:', error);
                toastr.error('Une erreur est survenue lors du chargement de l\'image. Vérifiez la console.','Erreur !');
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
                const role = step1.querySelector('select[name="role"]').value;
                const photo = photoUpload.files[0];
                

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
                if (!role) {
                    step1.querySelector('select[name="role"]').focus();
                    $('select[name="role"]').addClass('is-invalid');
                    return false;
                }else{
                    $('select[name="role"]').removeClass('is-invalid');
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
                const birthPlace = step2.querySelector('input[name="birthplace"]').value.trim();
                const nationality = step2.querySelector('select[name="nationality"]').value;
                const address = step2.querySelector('input[name="address_street"]').value.trim();
                const city = step2.querySelector('input[name="birthplace_city"]').value.trim();
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
                    $('input[name="birthplace"]').addClass('is-invalid');
                    step2.querySelector('input[name="birthplace"]').focus();
                    return false;
                }else{
                    $('input[name="birthplace"]').removeClass('is-invalid');
                }
                if (!nationality) {
                    $('select[name="nationality"]').addClass('is-invalid');
                    step2.querySelector('select[name="nationality"]').focus();
                    return false;
                }else{
                    $('select[name="nationality"]').removeClass('is-invalid');
                }
                if (!address) {
                    $('input[name="address_street"]').addClass('is-invalid');
                    step2.querySelector('input[name="address_street"]').focus();
                    return false;
                }else{
                    $('input[name="address_street"]').removeClass('is-invalid');
                }
                if (!city) {
                    $('input[name="birthplace_city"]').addClass('is-invalid');
                    step2.querySelector('input[name="birthplace_city"]').focus();
                    return false;
                }else{
                    $('input[name="birthplace_city"]').removeClass('is-invalid');
                }
                if (!zipCode) {
                    $('input[name="address_postcode"]').addClass('is-invalid');
                    step2.querySelector('input[name="address_postcode"]').focus();
                    return false;
                }else{
                    $('input[name="address_postcode"]').removeClass('is-invalid');
                }
                if (!country) {
                    $('select[name="country"]').addClass('is-invalid');
                    step2.querySelector('select[name="country"]').focus();
                    return false;
                }else{
                    $('select[name="country"]').removeClass('is-invalid');
                }

                return true;
            } catch (error) {
                console.log('error',error.message)
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
                progressBar.style.width = '100%';
            }
        });

        // Navigation back to Step 1
        prevBtn.addEventListener('click', function (e) {
            e.preventDefault();
            step2.classList.add('hidden');
            step1.classList.remove('hidden');
            progressBar.style.width = '50%';
        });

        // Form submission
        submitBtn.addEventListener('click', function (e) {
            e.preventDefault();
            if (validateStep2()){
                const formData = new FormData(step2);

                // Add Step 1 data to FormData
                const lastName = step1.querySelector('input[name="lastname"]').value;
                const firstName = step1.querySelector('input[name="firstname"]').value;
                const phone = step1.querySelector('input[name="phone"]').value;
                const email = step1.querySelector('input[name="email"]').value;
                const gender = step1.querySelector('input[name="gender"]:checked')?.value;
                const role = step1.querySelector('select[name="role"]').value;

                // Step2
                const birthDate = step2.querySelector('input[name="birthdate"]').value;
                const birthPlace = step2.querySelector('input[name="birthplace"]').value.trim();
                const nationality = step2.querySelector('select[name="nationality"]').value;
                const address = step2.querySelector('input[name="address_street"]').value.trim();
                const city = step2.querySelector('input[name="birthplace_city"]').value.trim();
                const zipCode = step2.querySelector('input[name="address_postcode"]').value.trim();
                const country = step2.querySelector('select[name="country"]').value;

                formData.append('lastname', lastName);
                formData.append('firstname', firstName);
                formData.append('phone', phone);
                formData.append('email', email);
                formData.append('gender', gender);
                formData.append('role', role);

                // Add photo (already validated as required in Step 1)
                if(photoUpload.files[0]){
                    formData.append('photo', photoUpload.files[0]);
                }

                fetch('{{ route('members.store') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                })
                .then(response => response)
                .then(data => {
                    if (data.status === 201) {
                        console.log('data',data)
                        toastr.success('Membre enregistré avec succés','Success!');
                        window.location.href = data.url || '{{ route('members.index') }}';
                    } else {
                        toastr.error('Erreur lors de l\'enregistrement','Erreur !');
                    }
                })
                .catch(error => {
                    console.log('Erreur lors de la soumission:', error);
                    toastr.error('Une erreur est survenue lors de l\'enregistrement. Vérifiez la console.','Erreur!');
                });
            }
        });
    });
</script>
@endsection
