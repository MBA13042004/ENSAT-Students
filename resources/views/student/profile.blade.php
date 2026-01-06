<!DOCTYPE html>
<html lang="fr" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mon Profil - ENSAT Students</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-900">
    <!-- Navigation Bar -->
    <nav class="bg-gray-800 border-b border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-xl font-bold text-white">ENSAT Students</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-300">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gray-800 rounded-lg shadow-lg p-8">
                <h2 class="text-3xl font-bold text-white mb-6">Mon Profil Étudiant</h2>

                @if($student)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-700 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-gray-400 mb-2">Code Apogée</h3>
                            <p class="text-xl text-white font-semibold">{{ $student->apogee }}</p>
                        </div>

                        <div class="bg-gray-700 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-gray-400 mb-2">CIN</h3>
                            <p class="text-xl text-white font-semibold">{{ $student->cin }}</p>
                        </div>

                        <div class="bg-gray-700 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-gray-400 mb-2">Nom</h3>
                            <p class="text-xl text-white">{{ $student->nom }}</p>
                        </div>

                        <div class="bg-gray-700 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-gray-400 mb-2">Prénom</h3>
                            <p class="text-xl text-white">{{ $student->prenom }}</p>
                        </div>

                        <div class="md:col-span-2 bg-gray-700 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-gray-400 mb-2">Email</h3>
                            <p class="text-xl text-white">{{ $student->email }}</p>
                        </div>

                        <div class="bg-gray-700 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-gray-400 mb-2">Filière</h3>
                            <p class="text-xl text-white">{{ $student->filiere ?? 'Non spécifié' }}</p>
                        </div>

                        <div class="bg-gray-700 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-gray-400 mb-2">Niveau</h3>
                            <p class="text-xl text-white">{{ $student->niveau ?? 'Non spécifié' }}</p>
                        </div>

                        <div class="bg-gray-700 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-gray-400 mb-2">Date de Naissance</h3>
                            <p class="text-xl text-white">{{ $student->date_naissance?->format('d/m/Y') ?? 'Non spécifié' }}</p>
                        </div>

                        <div class="bg-gray-700 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-gray-400 mb-2">Téléphone</h3>
                            <p class="text-xl text-white">{{ $student->telephone ?? 'Non spécifié' }}</p>
                        </div>
                    </div>
                @else
                    <div class="bg-yellow-500/20 border border-yellow-500 rounded-lg p-6 text-center">
                        <svg class="mx-auto h-12 w-12 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <h3 class="mt-4 text-xl font-semibold text-yellow-500">Profil étudiant non trouvé</h3>
                        <p class="mt-2 text-gray-300">
                            Votre profil étudiant n'est pas encore créé dans le système.<br>
                            Veuillez contacter l'administration pour plus d'informations.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </main>
</body>
</html>
