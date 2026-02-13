<x-app-layout>
    <x-slot name="header">Editar Docente</x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <form action="{{ route('docentes.update', $docente) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                @include('docentes._form')
                <div class="flex items-center gap-4 mt-6">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                        <i class="fas fa-save mr-2"></i> Actualizar
                    </button>
                    <a href="{{ route('docentes.show', $docente) }}" class="text-sm text-gray-600 hover:underline">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
