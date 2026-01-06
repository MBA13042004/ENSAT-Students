@extends('layouts.admin')

@section('title', 'Détails de l\'Étudiant')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-gray-800 rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center">
                <a href="{{ route('admin.students.index') }}" class="mr-4 text-gray-400 hover:text-white">
                    ← Retour
                </a>
                <h2 class="text-2xl font-bold text-white">Détails de l'Étudiant</h2>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.students.edit', $student) }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                    Modifier
                </a>
                <form method="POST" action="{{ route('admin.students.destroy', $student) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                        Supprimer
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-sm font-medium text-gray-400 mb-1">Code Apogée</h3>
                <p class="text-lg text-white">{{ $student->apogee }}</p>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-400 mb-1">CIN</h3>
                <p class="text-lg text-white">{{ $student->cin }}</p>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-400 mb-1">Nom</h3>
                <p class="text-lg text-white">{{ $student->nom }}</p>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-400 mb-1">Prénom</h3>
                <p class="text-lg text-white">{{ $student->prenom }}</p>
            </div>

            <div class="md:col-span-2">
                <h3 class="text-sm font-medium text-gray-400 mb-1">Email</h3>
                <p class="text-lg text-white">{{ $student->email }}</p>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-400 mb-1">Filière</h3>
                <p class="text-lg text-white">{{ $student->filiere ?? 'Non spécifié' }}</p>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-400 mb-1">Niveau</h3>
                <p class="text-lg text-white">{{ $student->niveau ?? 'Non spécifié' }}</p>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-400 mb-1">Date de Naissance</h3>
                <p class="text-lg text-white">{{ $student->date_naissance?->format('d/m/Y') ?? 'Non spécifié' }}</p>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-400 mb-1">Téléphone</h3>
                <p class="text-lg text-white">{{ $student->telephone ?? 'Non spécifié' }}</p>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-400 mb-1">Date de Création</h3>
                <p class="text-lg text-white">{{ $student->created_at->format('d/m/Y H:i') }}</p>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-400 mb-1">Dernière Modification</h3>
                <p class="text-lg text-white">{{ $student->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
