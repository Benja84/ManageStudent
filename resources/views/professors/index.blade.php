

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des professeurs</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }
        .modal-content {
            background-color: white;
            margin: 5% auto;
            padding: 20px;
            width: 80%;
            max-width: 800px;
            border-radius: 8px;
            position: relative;
        }
        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            cursor: pointer;
        }
    </style>
</head>
<body class="bg-purple-100 p-6">
    @extends('layouts.base')

    @section('content')
    <div class="container mx-auto">
        <div class="flex justify-between mb-4">
            <h2 class="text-xl font-bold">Les professeurs</h2>
            <div>
                <a href="#" class="text-blue-500 mr-4">Accueil</a>
                <a href="#" class="text-blue-500">Professeurs</a>
            </div>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <div class="flex justify-between mb-4">
                <h3>LISTE DES PROFESSEURS ({{ count($professors) }})</h3>
                <div class="flex items-center space-x-2">
                    <button disabled title="Télécharger le profil" class="bg-green-500 text-white p-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                    </button>

                    <button class="bg-green-500 text-white px-4 py-2 rounded">Exporter professeurs</button>

                    <a href="{{ route('professors.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Ajouter un professeur</a>
                </div>
            </div>
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-purple-200">
                        <th class="p-2">PHOTO</th>
                        <th class="p-2">GENRE</th>
                        <th class="p-2">NOM</th>
                        <th class="p-2">PRÉNOM</th>
                        <th class="p-2">EMAIL</th>
                        <th class="p-2">PORTABLE</th>
                        <th class="p-2">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($professors as $professor)
                        <tr class="border-b" data-id="{{ $professor->id }}">
                            <td class="p-2"><img src="{{ $professor->photo ? asset('storage/' . $professor->photo) : 'https://via.placeholder.com/50' }}" alt="Photo" class="rounded-full"></td>
                            <td class="p-2">{{ $professor->gender }}</td>
                            <td class="p-2">{{ $professor->last_name }}</td>
                            <td class="p-2">{{ $professor->first_name }}</td>
                            <td class="p-2">{{ $professor->email }}</td>
                            <td class="p-2">{{ $professor->phone }}</td>
                            <td class="p-2">
                                <a href="#" class="text-blue-500 mr-2">ℹ️</a>
                                <button class="edit-btn text-blue-500 mr-2" data-professor='{{ json_encode($professor) }}'>✏️</button>
                                <button class="delete-btn text-red-500" data-id="{{ $professor->id }}">🗑️</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2 class="text-xl font-bold mb-4">Modifier un professeur</h2>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="edit-id">
                <!-- Step 1: Identity -->
                <div id="edit-step1">
                    <div class="flex mb-4">
                        <div class="w-1/4">
                            <div class="profile-pic-container">
                                <img id="edit-profile-pic" src="https://via.placeholder.com/100?text=Profile" alt="Profile" class="profile-pic">
                                <label for="edit-photo-upload" class="upload-overlay cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h4l2-2h2l2 2h4a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </label>
                                <input id="edit-photo-upload" type="file" name="photo" accept="image/*" class="upload-input">
                            </div>
                        </div>
                        <div class="w-3/4">
                            <div class="flex space-x-4 mb-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="gender" value="F" class="form-radio">
                                    <span class="ml-2 text-gray-700">Féminin</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="gender" value="M" class="form-radio">
                                    <span class="ml-2 text-gray-700">Masculin</span>
                                </label>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-gray-700">Nom</label>
                                    <input type="text" name="last_name" id="edit-last_name" class="w-full p-2 border rounded">
                                </div>
                                <div>
                                    <label class="block text-gray-700">Prénom</label>
                                    <input type="text" name="first_name" id="edit-first_name" class="w-full p-2 border rounded">
                                </div>
                                <div>
                                    <label class="block text-gray-700">Portable</label>
                                    <input type="tel" name="phone" id="edit-phone" class="w-full p-2 border rounded">
                                    <select name="phone_country" id="edit-phone_country" class="w-24 p-2 border rounded mt-1">
                                        <option value="+33">+33 (France)</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-gray-700">Email</label>
                                    <input type="email" name="email" id="edit-email" class="w-full p-2 border rounded">
                                    <select name="email_type" id="edit-email_type" class="w-48 p-2 border rounded mt-1">
                                        <option value="I">I - Futilisateur</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end mt-6">
                        <button type="button" id="edit-nextBtn" class="bg-blue-500 text-white px-4 py-2 rounded">Suivant</button>
                    </div>
                </div>

                <!-- Step 2: Information -->
                <div id="edit-step2" class="hidden">
                    <div class="space-y-4">
                        <div class="flex space-x-4">
                            <div class="w-1/3">
                                <label class="block text-gray-700">Naissance</label>
                                <input type="date" name="birth_date" id="edit-birth_date" class="w-full p-2 border rounded">
                            </div>
                            <div class="w-1/3">
                                <label class="block text-gray-700">Lieu de naissance</label>
                                <input type="text" name="birth_place" id="edit-birth_place" class="w-full p-2 border rounded">
                            </div>
                            <div class="w-1/3">
                                <label class="block text-gray-700">Nationalité</label>
                                <select name="nationality" id="edit-nationality" class="w-full p-2 border rounded">
                                    <option value="France">France</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex space-x-4">
                            <div class="w-1/3">
                                <label class="block text-gray-700">Adresse</label>
                                <input type="text" name="address" id="edit-address" class="w-full p-2 border rounded">
                            </div>
                            <div class="w-1/3">
                                <label class="block text-gray-700">Ville</label>
                                <input type="text" name="city" id="edit-city" class="w-full p-2 border rounded">
                            </div>
                            <div class="w-1/3">
                                <label class="block text-gray-700">Code postal</label>
                                <input type="text" name="zip_code" id="edit-zip_code" class="w-full p-2 border rounded">
                            </div>
                            <div class="w-1/3">
                                <label class="block text-gray-700">Pays</label>
                                <select name="country" id="edit-country" class="w-full p-2 border rounded">
                                    <option value="France">France</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between mt-6">
                        <button type="button" id="edit-prevBtn" class="bg-gray-500 text-white px-4 py-2 rounded">Précédent</button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Mettre à jour</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

</body>
</html>
