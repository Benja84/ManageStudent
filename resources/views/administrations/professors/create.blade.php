
    @extends('layouts.base')
    @section('aditionnal_css')
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
                <div class="card-body">
                    {{-- <div class="flex justify-between mb-4">
                        <h2 class="text-xl font-bold">Ajouter un membre du personnel</h2>
                        <div>
                            <a href="#" class="text-blue-500 mr-2">Accueil</a> >
                            <a href="#" class="text-blue-500 mr-2">Membres du personnel</a> >
                            <a href="#" class="text-blue-500">Ajouter un membre du personnel</a>
                        </div>
                    </div> --}}

                    
                    <div class="flex  mb-4">
                        <h2 class="text-gray w-1/2">1 Identité</h2>
                        <h2 class="text-gray">2 Informations</h2>
                    </div>
                    <!-- Progress Bar -->
                    <div class="progress-container mb-6">
                        <div id="progress-bar" class="w-1/2" style="height: 8px; background-color: #3b82f6; transition: width 0.3s ease-in-out;"></div>
                        <div class="flex-1 bg-gray-200" style="height: 8px;"></div>
                    </div>

                    <!-- Step 1: Identity -->
                    <form id="step1" class="bg-white p-6 rounded shadow" enctype="multipart/form-data">
                        @csrf
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
                                        <input type="text" name="last_name" class="w-full p-2 border rounded">
                                    </div>
                                    <div>
                                        <label class="block text-gray-700">Prénom</label>
                                        <input type="text" name="first_name" class="w-full p-2 border rounded">
                                    </div>
                                    <div>
                                        <label class="block text-gray-700">Portable</label>
                                        <input type="tel" name="phone" class="w-full p-2 border rounded">
                                    </div>
                                    <div>
                                        <label class="block text-gray-700">Email</label>
                                        <input type="email" name="email" class="w-full p-2 border rounded">
                                    </div>
                                    <div>
                                        <label class="block text-gray-700">Matières pouvant être enseignées</label>
                                        <select name="subjec_id[]" class="select2 form-select" multiple placeholder="Selectionner les matières">
                                            <option value=""  disabled>Selectionner les matières</option>
                                            @foreach($subjects as $subject)
                                            <option value="{{$subject->id}}" data-token="{{$subject->name}} ({{$subject->abbreviation}})">{{$subject->name}} ({{$subject->abbreviation}})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-gray-700">Affectation aux groupes</label>
                                        <select name="group_id[]" class="select2 form-select selectpicker" multiple placeholder="Selectionner les groupes" title="Sélectionner les groupes">
                                            <option value=""  disabled>Selectionner les groupes</option>
                                            @foreach($groups as $group)
                                            <option value="{{$group->id}}" data-token="{{$group->abbreviation}} ({{$group->school_year}})">{{$group->abbreviation}} ({{$group->school_year}})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-between mt-6">
                            <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded">Précédent</button>
                            <button type="button" id="nextBtn" class="bg-blue-500 text-white px-4 py-2 rounded">Suivant</button>
                        </div>
                    </form>

                    <!-- Step 2: Information -->
                    <form id="step2" action="{{ route('professors.store') }}" method="POST" class="bg-white p-6 rounded shadow mt-6 hidden" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-4">
                            <div class="flex space-x-4">
                                <div class="w-1/3">
                                    <label class="block text-gray-700">Naissance</label>
                                    <input type="date" name="birth_date" class="w-full p-2 border rounded">
                                </div>
                                <div class="w-1/3">
                                    <label class="block text-gray-700">Lieu de naissance</label>
                                    <input type="text" name="birth_place" class="w-full p-2 border rounded">
                                </div>
                                <div class="w-1/3">
                                    <label class="block text-gray-700">Nationalité</label>
                                    <select name="nationality" class="w-full p-2 border rounded">
                                        <option value="France">Francaise</option>
                                        <option value="Malagasy">Malagasy</option>
                                    </select>
                                </div>
                            </div>
                            <div class="flex space-x-4">
                                <div class="w-1/3">
                                    <label class="block text-gray-700">Adresse</label>
                                    <input type="text" name="address" class="w-full p-2 border rounded">
                                </div>
                                <div class="w-1/3">
                                    <label class="block text-gray-700">Ville</label>
                                    <input type="text" name="city" class="w-full p-2 border rounded">
                                </div>
                                <div class="w-1/3">
                                    <label class="block text-gray-700">Code postal</label>
                                    <input type="text" name="zip_code" class="w-full p-2 border rounded">
                                </div>
                                <div class="w-1/3">
                                    <label class="block text-gray-700">Pays</label>
                                    <select name="country" class="w-full p-2 border rounded">
                                        <option value="France">France</option>
                                        <option value="Madagascar">Madagascar</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-between mt-6">
                            <button type="button" id="prevBtn" class="bg-gray-500 text-white px-4 py-2 rounded">Précédent</button>
                            <button type="submit" id="submitBtn" class="bg-blue-500 text-white px-4 py-2 rounded">Enregistrer</button>
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
                    const lastName = step1.querySelector('input[name="last_name"]').value.trim();
                    const firstName = step1.querySelector('input[name="first_name"]').value.trim();
                    const phone = step1.querySelector('input[name="phone"]').value.trim();
                    const email = step1.querySelector('input[name="email"]').value.trim();
                    const gender = step1.querySelector('input[name="gender"]:checked');
                    const phoneCountry = step1.querySelector('select[name="phone_country"]').value;
                    const role = step1.querySelector('select[name="role"]').value;
                    const photo = photoUpload.files[0];

                    // Check for missing fields
                    if (!lastName) {
                        alert("Le champ 'Nom' est requis.");
                        return false;
                    }
                    if (!firstName) {
                        alert("Le champ 'Prénom' est requis.");
                        return false;
                    }
                    if (!phone) {
                        alert("Le champ 'Portable' est requis.");
                        return false;
                    }
                    if (!email) {
                        alert("Le champ 'Email' est requis.");
                        return false;
                    }
                    if (!gender) {
                        alert("Le champ 'Genre' est requis.");
                        return false;
                    }
                    if (!phoneCountry) {
                        alert("Le champ 'Code pays pour le téléphone' est requis.");
                        return false;
                    }
                    if (!role) {
                        alert("Le champ 'Rôle' est requis.");
                        return false;
                    }
                    if (!photo) {
                        alert("Une image de profil est requise. Veuillez sélectionner une image.");
                        return false;
                    }

                    // Email validation
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(email)) {
                        alert("L'email est incorrect. Veuillez entrer un email valide.");
                        return false;
                    }

                    // Phone validation
                    const phoneRegex = /^\+?[0-9]{10,15}$/;
                    if (!phoneRegex.test(phone)) {
                        alert("Le numéro de téléphone est incorrect. Veuillez entrer un numéro valide (10-15 chiffres, avec ou sans code pays).");
                        return false;
                    }

                    return true;
                } catch (error) {
                    console.error('Erreur dans validateStep1:', error);
                    alert('Une erreur est survenue lors de la validation de l\'étape 1. Vérifiez la console pour plus de détails.');
                    return false;
                }
            }

            // Validation for Step 2
            function validateStep2() {
                try {
                    const birthDate = step2.querySelector('input[name="birth_date"]').value;
                    const birthPlace = step2.querySelector('input[name="birth_place"]').value.trim();
                    const nationality = step2.querySelector('select[name="nationality"]').value;
                    const address = step2.querySelector('input[name="address"]').value.trim();
                    const city = step2.querySelector('input[name="city"]').value.trim();
                    const zipCode = step2.querySelector('input[name="zip_code"]').value.trim();
                    const country = step2.querySelector('select[name="country"]').value;

                    // Check for missing fields
                    if (!birthDate) {
                        alert("Le champ 'Naissance' est requis.");
                        return false;
                    }
                    if (!birthPlace) {
                        alert("Le champ 'Lieu de naissance' est requis.");
                        return false;
                    }
                    if (!nationality) {
                        alert("Le champ 'Nationalité' est requis.");
                        return false;
                    }
                    if (!address) {
                        alert("Le champ 'Adresse' est requis.");
                        return false;
                    }
                    if (!city) {
                        alert("Le champ 'Ville' est requis.");
                        return false;
                    }
                    if (!zipCode) {
                        alert("Le champ 'Code postal' est requis.");
                        return false;
                    }
                    if (!country) {
                        alert("Le champ 'Pays' est requis.");
                        return false;
                    }

                    return true;
                } catch (error) {
                    console.error('Erreur dans validateStep2:', error);
                    alert('Une erreur est survenue lors de la validation de l\'étape 2. Vérifiez la console pour plus de détails.');
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
                if (validateStep2()) {
                    const formData = new FormData(step2);

                    // Add Step 1 data to FormData
                    const lastName = step1.querySelector('input[name="last_name"]').value;
                    const firstName = step1.querySelector('input[name="first_name"]').value;
                    const phone = step1.querySelector('input[name="phone"]').value;
                    const email = step1.querySelector('input[name="email"]').value;
                    const gender = step1.querySelector('input[name="gender"]:checked')?.value;
                    const phoneCountry = step1.querySelector('select[name="phone_country"]').value;
                    const role = step1.querySelector('select[name="role"]').value;

                    // Step2
                    const birthDate = step2.querySelector('input[name="birth_date"]').value;
                    const birthPlace = step2.querySelector('input[name="birth_place"]').value.trim();
                    const nationality = step2.querySelector('select[name="nationality"]').value;
                    const address = step2.querySelector('input[name="address"]').value.trim();
                    const city = step2.querySelector('input[name="city"]').value.trim();
                    const zipCode = step2.querySelector('input[name="zip_code"]').value.trim();
                    const country = step2.querySelector('select[name="country"]').value;

                    formData.append('last_name', lastName);
                    formData.append('first_name', firstName);
                    formData.append('phone', phone);
                    formData.append('email', email);
                    formData.append('gender', gender);
                    formData.append('phone_country', phoneCountry);
                    formData.append('role', role);

                    // Add photo (already validated as required in Step 1)
                    formData.append('photo', photoUpload.files[0]);

                    fetch('{{ route('professors.store') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response)
                    .then(data => {
                        if (data.success) {
                            window.location.href = data.redirect || '{{ route('professors.index') }}';
                        } else {
                            alert(data.message || 'Erreur lors de l\'enregistrement.');
                        }
                    })
                    .catch(error => {
                        console.error('Erreur lors de la soumission:', error);
                        alert('Une erreur est survenue lors de l\'enregistrement. Vérifiez la console.');
                    });
                }
            });
        });
    </script>
    @endsection
