<x-app-layout>
    <x-slot name="header">Nuevo Acudiente</x-slot>

    <div class="max-w-3xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('acudientes.store') }}" method="POST">
                    @csrf
                    @include('acudientes._form')
                    <div class="flex items-center gap-4 mt-6">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">Guardar</button>
                        <a href="{{ route('acudientes.index') }}" class="text-sm text-gray-600 hover:underline">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
