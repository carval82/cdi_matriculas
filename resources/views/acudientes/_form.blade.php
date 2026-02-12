@php $a = $acudiente ?? null; @endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <x-input-label for="tipo_documento" value="Tipo Documento" />
        <select id="tipo_documento" name="tipo_documento" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="CC" {{ old('tipo_documento', $a?->tipo_documento) == 'CC' ? 'selected' : '' }}>Cédula de Ciudadanía</option>
            <option value="CE" {{ old('tipo_documento', $a?->tipo_documento) == 'CE' ? 'selected' : '' }}>Cédula de Extranjería</option>
            <option value="TI" {{ old('tipo_documento', $a?->tipo_documento) == 'TI' ? 'selected' : '' }}>Tarjeta de Identidad</option>
            <option value="PP" {{ old('tipo_documento', $a?->tipo_documento) == 'PP' ? 'selected' : '' }}>Pasaporte</option>
        </select>
    </div>

    <div>
        <x-input-label for="documento" value="Número Documento *" />
        <x-text-input id="documento" name="documento" type="text" class="mt-1 block w-full" :value="old('documento', $a?->documento)" required />
        <x-input-error :messages="$errors->get('documento')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="nombres" value="Nombres *" />
        <x-text-input id="nombres" name="nombres" type="text" class="mt-1 block w-full" :value="old('nombres', $a?->nombres)" required />
        <x-input-error :messages="$errors->get('nombres')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="apellidos" value="Apellidos *" />
        <x-text-input id="apellidos" name="apellidos" type="text" class="mt-1 block w-full" :value="old('apellidos', $a?->apellidos)" required />
        <x-input-error :messages="$errors->get('apellidos')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="parentesco" value="Parentesco" />
        <select id="parentesco" name="parentesco" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">Seleccionar</option>
            @foreach(['Madre','Padre','Abuela','Abuelo','Tía','Tío','Hermana','Hermano','Otro'] as $p)
                <option value="{{ $p }}" {{ old('parentesco', $a?->parentesco) == $p ? 'selected' : '' }}>{{ $p }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <x-input-label for="celular" value="Celular" />
        <x-text-input id="celular" name="celular" type="text" class="mt-1 block w-full" :value="old('celular', $a?->celular)" />
    </div>

    <div>
        <x-input-label for="telefono" value="Teléfono Fijo" />
        <x-text-input id="telefono" name="telefono" type="text" class="mt-1 block w-full" :value="old('telefono', $a?->telefono)" />
    </div>

    <div>
        <x-input-label for="email" value="Email" />
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $a?->email)" />
    </div>

    <div>
        <x-input-label for="direccion" value="Dirección" />
        <x-text-input id="direccion" name="direccion" type="text" class="mt-1 block w-full" :value="old('direccion', $a?->direccion)" />
    </div>

    <div>
        <x-input-label for="barrio" value="Barrio" />
        <x-text-input id="barrio" name="barrio" type="text" class="mt-1 block w-full" :value="old('barrio', $a?->barrio)" />
    </div>

    <div>
        <x-input-label for="ocupacion" value="Ocupación" />
        <x-text-input id="ocupacion" name="ocupacion" type="text" class="mt-1 block w-full" :value="old('ocupacion', $a?->ocupacion)" />
    </div>

    <div>
        <x-input-label for="empresa_trabajo" value="Empresa de Trabajo" />
        <x-text-input id="empresa_trabajo" name="empresa_trabajo" type="text" class="mt-1 block w-full" :value="old('empresa_trabajo', $a?->empresa_trabajo)" />
    </div>

    <div>
        <x-input-label for="telefono_trabajo" value="Teléfono Trabajo" />
        <x-text-input id="telefono_trabajo" name="telefono_trabajo" type="text" class="mt-1 block w-full" :value="old('telefono_trabajo', $a?->telefono_trabajo)" />
    </div>

    <div>
        <x-input-label for="eps" value="EPS" />
        <x-text-input id="eps" name="eps" type="text" class="mt-1 block w-full" :value="old('eps', $a?->eps)" />
    </div>

    <div class="md:col-span-2">
        <x-input-label for="observaciones" value="Observaciones" />
        <textarea id="observaciones" name="observaciones" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('observaciones', $a?->observaciones) }}</textarea>
    </div>
</div>
