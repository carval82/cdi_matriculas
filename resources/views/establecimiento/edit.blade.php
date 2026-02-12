<x-app-layout>
    <x-slot name="header">Datos del Establecimiento</x-slot>

    <div class="max-w-3xl mx-auto">
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <form action="{{ route('establecimiento.update') }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')

                @if($establecimiento->logo)
                    <div class="flex justify-center mb-6">
                        <img src="{{ $establecimiento->logoUrl() }}" alt="Logo" class="h-24 object-contain rounded-lg shadow">
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <x-input-label for="nombre" value="Nombre del Establecimiento *" />
                        <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" :value="old('nombre', $establecimiento->nombre)" required />
                        <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                    </div>

                    <div class="md:col-span-2">
                        <x-input-label for="lema" value="Lema / Slogan" />
                        <x-text-input id="lema" name="lema" type="text" class="mt-1 block w-full" :value="old('lema', $establecimiento->lema)" placeholder="Ej: Formando el futuro con amor" />
                    </div>

                    <div>
                        <x-input-label for="nit" value="NIT" />
                        <x-text-input id="nit" name="nit" type="text" class="mt-1 block w-full" :value="old('nit', $establecimiento->nit)" />
                    </div>

                    <div>
                        <x-input-label for="resolucion" value="Resolución" />
                        <x-text-input id="resolucion" name="resolucion" type="text" class="mt-1 block w-full" :value="old('resolucion', $establecimiento->resolucion)" placeholder="Ej: Res. 1234 de 2020" />
                    </div>

                    <div>
                        <x-input-label for="representante_legal" value="Representante Legal / Director(a)" />
                        <x-text-input id="representante_legal" name="representante_legal" type="text" class="mt-1 block w-full" :value="old('representante_legal', $establecimiento->representante_legal)" />
                    </div>

                    <div>
                        <x-input-label for="direccion" value="Dirección" />
                        <x-text-input id="direccion" name="direccion" type="text" class="mt-1 block w-full" :value="old('direccion', $establecimiento->direccion)" />
                    </div>

                    <div>
                        <x-input-label for="ciudad" value="Ciudad" />
                        <x-text-input id="ciudad" name="ciudad" type="text" class="mt-1 block w-full" :value="old('ciudad', $establecimiento->ciudad)" />
                    </div>

                    <div>
                        <x-input-label for="departamento" value="Departamento" />
                        <x-text-input id="departamento" name="departamento" type="text" class="mt-1 block w-full" :value="old('departamento', $establecimiento->departamento)" />
                    </div>

                    <div>
                        <x-input-label for="telefono" value="Teléfono" />
                        <x-text-input id="telefono" name="telefono" type="text" class="mt-1 block w-full" :value="old('telefono', $establecimiento->telefono)" />
                    </div>

                    <div>
                        <x-input-label for="celular" value="Celular" />
                        <x-text-input id="celular" name="celular" type="text" class="mt-1 block w-full" :value="old('celular', $establecimiento->celular)" />
                    </div>

                    <div>
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $establecimiento->email)" />
                    </div>

                    <div>
                        <x-input-label for="logo" value="Logo (JPG, PNG, WebP - máx 2MB)" />
                        <input id="logo" name="logo" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                        <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                    </div>

                    <div class="md:col-span-2">
                        <x-input-label for="descripcion" value="Descripción" />
                        <textarea id="descripcion" name="descripcion" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('descripcion', $establecimiento->descripcion) }}</textarea>
                    </div>
                </div>

                <div class="flex items-center gap-4 mt-6">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                        <i class="fas fa-save mr-2"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
