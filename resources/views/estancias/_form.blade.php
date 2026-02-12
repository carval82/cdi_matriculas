@php $e = $estancia ?? null; @endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <x-input-label for="nombre" value="Nombre *" />
        <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" :value="old('nombre', $e?->nombre)" required />
        <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="codigo" value="Código" />
        <x-text-input id="codigo" name="codigo" type="text" class="mt-1 block w-full" :value="old('codigo', $e?->codigo)" placeholder="PAR, JAR, PRE..." />
        <x-input-error :messages="$errors->get('codigo')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="edad_minima" value="Edad Mínima (meses)" />
        <x-text-input id="edad_minima" name="edad_minima" type="number" class="mt-1 block w-full" :value="old('edad_minima', $e?->edad_minima)" />
    </div>

    <div>
        <x-input-label for="edad_maxima" value="Edad Máxima (meses)" />
        <x-text-input id="edad_maxima" name="edad_maxima" type="number" class="mt-1 block w-full" :value="old('edad_maxima', $e?->edad_maxima)" />
    </div>

    <div>
        <x-input-label for="capacidad" value="Capacidad (cupos) *" />
        <x-text-input id="capacidad" name="capacidad" type="number" class="mt-1 block w-full" :value="old('capacidad', $e?->capacidad ?? 25)" required min="1" />
        <x-input-error :messages="$errors->get('capacidad')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="jornada" value="Jornada" />
        <select id="jornada" name="jornada" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="completa" {{ old('jornada', $e?->jornada) == 'completa' ? 'selected' : '' }}>Completa</option>
            <option value="mañana" {{ old('jornada', $e?->jornada) == 'mañana' ? 'selected' : '' }}>Mañana</option>
            <option value="tarde" {{ old('jornada', $e?->jornada) == 'tarde' ? 'selected' : '' }}>Tarde</option>
        </select>
    </div>

    <div>
        <x-input-label for="valor_matricula" value="Valor Matrícula *" />
        <x-text-input id="valor_matricula" name="valor_matricula" type="number" step="0.01" class="mt-1 block w-full" :value="old('valor_matricula', $e?->valor_matricula ?? 0)" required />
        <x-input-error :messages="$errors->get('valor_matricula')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="valor_pension" value="Valor Pensión Mensual *" />
        <x-text-input id="valor_pension" name="valor_pension" type="number" step="0.01" class="mt-1 block w-full" :value="old('valor_pension', $e?->valor_pension ?? 0)" required />
        <x-input-error :messages="$errors->get('valor_pension')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="orden" value="Orden" />
        <x-text-input id="orden" name="orden" type="number" class="mt-1 block w-full" :value="old('orden', $e?->orden ?? 0)" />
    </div>

    <div>
        <x-input-label for="activa" value="Estado" />
        <select id="activa" name="activa" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="1" {{ old('activa', $e?->activa ?? true) ? 'selected' : '' }}>Activa</option>
            <option value="0" {{ !old('activa', $e?->activa ?? true) ? 'selected' : '' }}>Inactiva</option>
        </select>
    </div>

    <div class="md:col-span-2">
        <x-input-label for="descripcion" value="Descripción" />
        <textarea id="descripcion" name="descripcion" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('descripcion', $e?->descripcion) }}</textarea>
    </div>
</div>
