<x-app-layout>
    <x-slot name="header">Editar Grupo: {{ $grupo->nombre }}</x-slot>

    <div class="max-w-2xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('grupos.update', $grupo) }}" method="POST">
                    @csrf @method('PUT')
                    @include('grupos._form', ['grupo' => $grupo])
                    <div class="flex items-center gap-4 mt-6">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">Actualizar</button>
                        <a href="{{ route('grupos.index') }}" class="text-sm text-gray-600 hover:underline">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
