@extends('layouts.admin')

@section('title', 'Gestion des Étudiants')

@section('content')
<div class="bg-gray-800 rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-white">Liste des Étudiants</h2>
        <a href="{{ route('admin.students.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
            + Ajouter un étudiant
        </a>
    </div>

    <!-- Search Form -->
    <form method="GET" action="{{ route('admin.students.index') }}" class="mb-6">
        <div class="flex gap-4">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Rechercher par nom, prénom, email, CIN ou code Apogée..."
                class="flex-1 px-4 py-2 bg-gray-700 border border-gray-600 rounded text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                Rechercher
            </button>
            @if(request('search'))
                <a href="{{ route('admin.students.index') }}" class="px-6 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition">
                    Réinitialiser
                </a>
            @endif
        </div>
    </form>

    <!-- Students Table -->
    @if($students->isEmpty())
        <div class="text-center py-12 text-gray-400">
            <p class="text-lg">Aucun étudiant trouvé</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Code Apogée</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">CIN</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Nom Complet</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Filière</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-800 divide-y divide-gray-700">
                    @foreach($students as $student)
                        <tr class="hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-white">{{ $student->apogee }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-white">{{ $student->cin }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-white">{{ $student->prenom }} {{ $student->nom }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $student->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $student->filiere ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.students.show', $student) }}" class="text-indigo-400 hover:text-indigo-300">Voir</a>
                                    <a href="{{ route('admin.students.edit', $student) }}" class="text-green-400 hover:text-green-300">Modifier</a>
                                    <form method="POST" action="{{ route('admin.students.destroy', $student) }}" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $students->links() }}
        </div>
    @endif
</div>
@endsection
