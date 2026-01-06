@extends('layouts.admin')

@section('title', 'Modifier un Étudiant')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-gray-800 rounded-lg shadow-lg p-6">
        <div class="flex items-center mb-6">
            <a href="{{ route('admin.students.index') }}" class="mr-4 text-gray-400 hover:text-white">
                ← Retour
            </a>
            <h2 class="text-2xl font-bold text-white">Modifier l'Étudiant</h2>
        </div>

        <form method="POST" action="{{ route('admin.students.update', $student) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="apogee" class="block text-sm font-medium text-gray-300">Code Apogée *</label>
                    <input type="text" name="apogee" id="apogee" value="{{ old('apogee', $student->apogee) }}" required
                        class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white @error('apogee') border-red-500 @enderror">
                    @error('apogee')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="cin" class="block text-sm font-medium text-gray-300">CIN *</label>
                    <input type="text" name="cin" id="cin" value="{{ old('cin', $student->cin) }}" required
                        class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white @error('cin') border-red-500 @enderror">
                    @error('cin')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="nom" class="block text-sm font-medium text-gray-300">Nom *</label>
                    <input type="text" name="nom" id="nom" value="{{ old('nom', $student->nom) }}" required
                        class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white @error('nom') border-red-500 @enderror">
                    @error('nom')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="prenom" class="block text-sm font-medium text-gray-300">Prénom *</label>
                    <input type="text" name="prenom" id="prenom" value="{{ old('prenom', $student->prenom) }}" required
                        class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white @error('prenom') border-red-500 @enderror">
                    @error('prenom')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-300">Email *</label>
                <input type="email" name="email" id="email" value="{{ old('email', $student->email) }}" required
                    class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white @error('email') border-red-500 @enderror">
                @error('email')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="filiere" class="block text-sm font-medium text-gray-300">Filière</label>
                    <input type="text" name="filiere" id="filiere" value="{{ old('filiere', $student->filiere) }}"
                        class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white">
                </div>

                <div>
                    <label for="niveau" class="block text-sm font-medium text-gray-300">Niveau</label>
                    <input type="text" name="niveau" id="niveau" value="{{ old('niveau', $student->niveau) }}"
                        class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white">
                </div>

                <div>
                    <label for="date_naissance" class="block text-sm font-medium text-gray-300">Date de Naissance</label>
                    <input type="date" name="date_naissance" id="date_naissance" value="{{ old('date_naissance', $student->date_naissance?->format('Y-m-d')) }}"
                        class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white">
                </div>

                <div>
                    <label for="telephone" class="block text-sm font-medium text-gray-300">Téléphone</label>
                    <input type="text" name="telephone" id="telephone" value="{{ old('telephone', $student->telephone) }}"
                        class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white">
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.students.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition">Annuler</a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">Mettre à Jour</button>
            </div>
        </form>
    </div>
</div>
@endsection
