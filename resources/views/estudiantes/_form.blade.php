@php $e = $estudiante ?? null; @endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="md:col-span-2 border-b pb-2 mb-2">
        <h3 class="font-semibold text-gray-700">Datos Personales</h3>
    </div>

    <div>
        <x-input-label for="nombres" value="Nombres *" />
        <x-text-input id="nombres" name="nombres" type="text" class="mt-1 block w-full" :value="old('nombres', $e?->nombres)" required />
        <x-input-error :messages="$errors->get('nombres')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="apellidos" value="Apellidos *" />
        <x-text-input id="apellidos" name="apellidos" type="text" class="mt-1 block w-full" :value="old('apellidos', $e?->apellidos)" required />
        <x-input-error :messages="$errors->get('apellidos')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="tipo_documento" value="Tipo Documento" />
        <select id="tipo_documento" name="tipo_documento" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="RC" {{ old('tipo_documento', $e?->tipo_documento) == 'RC' ? 'selected' : '' }}>Registro Civil</option>
            <option value="TI" {{ old('tipo_documento', $e?->tipo_documento) == 'TI' ? 'selected' : '' }}>Tarjeta de Identidad</option>
            <option value="NUIP" {{ old('tipo_documento', $e?->tipo_documento) == 'NUIP' ? 'selected' : '' }}>NUIP</option>
        </select>
    </div>

    <div>
        <x-input-label for="documento" value="Número Documento" />
        <x-text-input id="documento" name="documento" type="text" class="mt-1 block w-full" :value="old('documento', $e?->documento)" />
    </div>

    <div>
        <x-input-label for="fecha_nacimiento" value="Fecha de Nacimiento *" />
        <x-text-input id="fecha_nacimiento" name="fecha_nacimiento" type="date" class="mt-1 block w-full" :value="old('fecha_nacimiento', $e?->fecha_nacimiento?->format('Y-m-d'))" required />
        <x-input-error :messages="$errors->get('fecha_nacimiento')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="lugar_nacimiento" value="Lugar de Nacimiento" />
        <x-text-input id="lugar_nacimiento" name="lugar_nacimiento" type="text" class="mt-1 block w-full" :value="old('lugar_nacimiento', $e?->lugar_nacimiento)" />
    </div>

    <div>
        <x-input-label for="genero" value="Género" />
        <select id="genero" name="genero" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="masculino" {{ old('genero', $e?->genero) == 'masculino' ? 'selected' : '' }}>Masculino</option>
            <option value="femenino" {{ old('genero', $e?->genero) == 'femenino' ? 'selected' : '' }}>Femenino</option>
        </select>
    </div>

    <div>
        <x-input-label for="rh" value="RH" />
        <select id="rh" name="rh" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">Seleccionar</option>
            @foreach(['O+','O-','A+','A-','B+','B-','AB+','AB-'] as $tipo)
                <option value="{{ $tipo }}" {{ old('rh', $e?->rh) == $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <x-input-label for="eps" value="EPS" />
        <x-text-input id="eps" name="eps" type="text" class="mt-1 block w-full" :value="old('eps', $e?->eps)" />
    </div>

    <div>
        <x-input-label for="foto" value="Foto" />
        <input id="foto" name="foto" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
        @if($e?->foto)
            <img src="{{ asset('storage/' . $e->foto) }}" alt="Foto" class="mt-2 h-20 w-20 object-cover rounded-full">
        @endif
    </div>

    <div class="md:col-span-2 border-b pb-2 mb-2 mt-4">
        <h3 class="font-semibold text-gray-700">Información Médica</h3>
    </div>

    <div>
        <x-input-label for="alergias" value="Alergias" />
        <textarea id="alergias" name="alergias" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('alergias', $e?->alergias) }}</textarea>
    </div>

    <div>
        <x-input-label for="condiciones_medicas" value="Condiciones Médicas" />
        <textarea id="condiciones_medicas" name="condiciones_medicas" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('condiciones_medicas', $e?->condiciones_medicas) }}</textarea>
    </div>

    <div>
        <x-input-label for="medicamentos" value="Medicamentos" />
        <textarea id="medicamentos" name="medicamentos" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('medicamentos', $e?->medicamentos) }}</textarea>
    </div>

    <div>
        <x-input-label for="contacto_emergencia" value="Contacto de Emergencia" />
        <x-text-input id="contacto_emergencia" name="contacto_emergencia" type="text" class="mt-1 block w-full" :value="old('contacto_emergencia', $e?->contacto_emergencia)" />
    </div>

    <div>
        <x-input-label for="telefono_emergencia" value="Teléfono Emergencia" />
        <x-text-input id="telefono_emergencia" name="telefono_emergencia" type="text" class="mt-1 block w-full" :value="old('telefono_emergencia', $e?->telefono_emergencia)" />
    </div>

    <div class="md:col-span-2 border-b pb-2 mb-2 mt-4">
        <h3 class="font-semibold text-gray-700">Asignación</h3>
    </div>

    <div>
        <x-input-label for="acudiente_id" value="Acudiente Principal *" />
        <select id="acudiente_id" name="acudiente_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            <option value="">Seleccionar acudiente</option>
            @foreach($acudientes as $acu)
                <option value="{{ $acu->id }}" {{ old('acudiente_id', $e?->acudiente_id) == $acu->id ? 'selected' : '' }}>
                    {{ $acu->nombre_completo }} - {{ $acu->documento }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('acudiente_id')" class="mt-2" />
        <a href="{{ route('acudientes.create') }}" class="text-xs text-indigo-600 hover:underline mt-1 inline-block">+ Crear nuevo acudiente</a>
    </div>

    <div>
        <x-input-label for="acudiente_secundario_id" value="Acudiente Secundario" />
        <select id="acudiente_secundario_id" name="acudiente_secundario_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">Ninguno</option>
            @foreach($acudientes as $acu)
                <option value="{{ $acu->id }}" {{ old('acudiente_secundario_id', $e?->acudiente_secundario_id) == $acu->id ? 'selected' : '' }}>
                    {{ $acu->nombre_completo }} - {{ $acu->documento }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <x-input-label for="grupo_id" value="Grupo" />
        <select id="grupo_id" name="grupo_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">Sin asignar</option>
            @foreach($grupos as $est)
                <option value="{{ $est->id }}" {{ old('grupo_id', $e?->grupo_id) == $est->id ? 'selected' : '' }}>{{ $est->nombre }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <x-input-label for="estado" value="Estado" />
        <select id="estado" name="estado" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="activo" {{ old('estado', $e?->estado ?? 'activo') == 'activo' ? 'selected' : '' }}>Activo</option>
            <option value="retirado" {{ old('estado', $e?->estado) == 'retirado' ? 'selected' : '' }}>Retirado</option>
            <option value="graduado" {{ old('estado', $e?->estado) == 'graduado' ? 'selected' : '' }}>Graduado</option>
            <option value="suspendido" {{ old('estado', $e?->estado) == 'suspendido' ? 'selected' : '' }}>Suspendido</option>
        </select>
    </div>

    <div>
        <x-input-label for="fecha_ingreso" value="Fecha de Ingreso" />
        <x-text-input id="fecha_ingreso" name="fecha_ingreso" type="date" class="mt-1 block w-full" :value="old('fecha_ingreso', $e?->fecha_ingreso?->format('Y-m-d') ?? now()->format('Y-m-d'))" />
    </div>

    <div class="md:col-span-2">
        <x-input-label for="observaciones" value="Observaciones" />
        <textarea id="observaciones" name="observaciones" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('observaciones', $e?->observaciones) }}</textarea>
    </div>
</div>
