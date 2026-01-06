@extends('layouts.admin')

@section('title', 'Ajouter un Étudiant')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-gray-800 rounded-lg shadow-lg p-6">
        <div class="flex items-center mb-6">
            <a href="{{ route('admin.students.index') }}" class="mr-4 text-gray-400 hover:text-white">
                ← Retour
            </a>
            <h2 class="text-2xl font-bold text-white">Ajouter un Étudiant</h2>
        </div>

        <form method="POST" action="{{ route('admin.students.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Code Apogée -->
                <div>
                    <label for="apogee" class="block text-sm font-medium text-gray-300">Code Apogée *</label>
                    <input type="text" name="apogee" id="apogee" value="{{ old('apogee') }}" required
                        class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('apogee') border-red-500 @enderror">
                    @error('apogee')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- CIN -->
                <div>
                    <label for="cin" class="block text-sm font-medium text-gray-300">CIN *</label>
                    <input type="text" name="cin" id="cin" value="{{ old('cin') }}" required
                        class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('cin') border-red-500 @enderror">
                    @error('cin')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nom -->
                <div>
                    <label for="nom" class="block text-sm font-medium text-gray-300">Nom *</label>
                    <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required
                        class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('nom') border-red-500 @enderror">
                    @error('nom')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Prénom -->
                <div>
                    <label for="prenom" class="block text-sm font-medium text-gray-300">Prénom *</label>
                    <input type="text" name="prenom" id="prenom" value="{{ old('prenom') }}" required
                        class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('prenom') border-red-500 @enderror">
                    @error('prenom')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-300">Email *</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                    class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Filière -->
                <div>
                    <label for="filiere" class="block text-sm font-medium text-gray-300">Filière</label>
                    <input type="text" name="filiere" id="filiere" value="{{ old('filiere') }}"
                        class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <!-- Niveau -->
                <div>
                    <label for="niveau" class="block text-sm font-medium text-gray-300">Niveau</label>
                    <input type="text" name="niveau" id="niveau" value="{{ old('niveau') }}"
                        class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <!-- Date de naissance -->
                <div>
                    <label for="date_naissance" class="block text-sm font-medium text-gray-300">Date de Naissance</label>
                    <input type="date" name="date_naissance" id="date_naissance" value="{{ old('date_naissance') }}"
                        class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <!-- Téléphone -->
                <div>
                    <label for="telephone" class="block text-sm font-medium text-gray-300">Téléphone</label>
                    <input type="text" name="telephone" id="telephone" value="{{ old('telephone') }}"
                        class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.students.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition">
                    Annuler
                </a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                    Créer l'Étudiant
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
