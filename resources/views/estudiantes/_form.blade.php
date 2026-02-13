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
            <option value="PEP" {{ old('tipo_documento', $e?->tipo_documento) == 'PEP' ? 'selected' : '' }}>PEP (Permiso Especial de Permanencia)</option>
            <option value="PPT" {{ old('tipo_documento', $e?->tipo_documento) == 'PPT' ? 'selected' : '' }}>PPT (Permiso por Protección Temporal)</option>
            <option value="CE" {{ old('tipo_documento', $e?->tipo_documento) == 'CE' ? 'selected' : '' }}>Cédula de Extranjería</option>
            <option value="PA" {{ old('tipo_documento', $e?->tipo_documento) == 'PA' ? 'selected' : '' }}>Pasaporte</option>
            <option value="SD" {{ old('tipo_documento', $e?->tipo_documento) == 'SD' ? 'selected' : '' }}>Sin Documento</option>
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
        <x-input-label for="tipo_eps" value="Tipo de Afiliación EPS" />
        <select id="tipo_eps" name="tipo_eps" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">Seleccionar</option>
            <option value="contributivo" {{ old('tipo_eps', $e?->tipo_eps) == 'contributivo' ? 'selected' : '' }}>Contributivo</option>
            <option value="subsidiado" {{ old('tipo_eps', $e?->tipo_eps) == 'subsidiado' ? 'selected' : '' }}>Subsidiado</option>
            <option value="beneficiario" {{ old('tipo_eps', $e?->tipo_eps) == 'beneficiario' ? 'selected' : '' }}>Beneficiario</option>
            <option value="regimen_especial" {{ old('tipo_eps', $e?->tipo_eps) == 'regimen_especial' ? 'selected' : '' }}>Régimen Especial</option>
            <option value="no_afiliado" {{ old('tipo_eps', $e?->tipo_eps) == 'no_afiliado' ? 'selected' : '' }}>No Afiliado</option>
        </select>
    </div>

    <div>
        <x-input-label for="nacionalidad" value="Nacionalidad" />
        <select id="nacionalidad" name="nacionalidad" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="Colombiana" {{ old('nacionalidad', $e?->nacionalidad ?? 'Colombiana') == 'Colombiana' ? 'selected' : '' }}>Colombiana</option>
            <option value="Venezolana" {{ old('nacionalidad', $e?->nacionalidad) == 'Venezolana' ? 'selected' : '' }}>Venezolana</option>
            <option value="Ecuatoriana" {{ old('nacionalidad', $e?->nacionalidad) == 'Ecuatoriana' ? 'selected' : '' }}>Ecuatoriana</option>
            <option value="Peruana" {{ old('nacionalidad', $e?->nacionalidad) == 'Peruana' ? 'selected' : '' }}>Peruana</option>
            <option value="Brasileña" {{ old('nacionalidad', $e?->nacionalidad) == 'Brasileña' ? 'selected' : '' }}>Brasileña</option>
            <option value="Haitiana" {{ old('nacionalidad', $e?->nacionalidad) == 'Haitiana' ? 'selected' : '' }}>Haitiana</option>
            <option value="Chilena" {{ old('nacionalidad', $e?->nacionalidad) == 'Chilena' ? 'selected' : '' }}>Chilena</option>
            <option value="Argentina" {{ old('nacionalidad', $e?->nacionalidad) == 'Argentina' ? 'selected' : '' }}>Argentina</option>
            <option value="Panameña" {{ old('nacionalidad', $e?->nacionalidad) == 'Panameña' ? 'selected' : '' }}>Panameña</option>
            <option value="Otra" {{ old('nacionalidad', $e?->nacionalidad) == 'Otra' ? 'selected' : '' }}>Otra</option>
        </select>
    </div>

    <div>
        <x-input-label for="pais_origen" value="País de Origen (si es extranjero)" />
        <x-text-input id="pais_origen" name="pais_origen" type="text" class="mt-1 block w-full" :value="old('pais_origen', $e?->pais_origen)" placeholder="Ej: Venezuela, Ecuador..." />
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
        <x-input-label for="diagnostico_medico" value="Diagnóstico Médico" />
        <textarea id="diagnostico_medico" name="diagnostico_medico" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Diagnóstico médico específico si aplica">{{ old('diagnostico_medico', $e?->diagnostico_medico) }}</textarea>
    </div>

    <div>
        <x-input-label for="condicion_especial_salud" value="Condición Especial de Salud" />
        <textarea id="condicion_especial_salud" name="condicion_especial_salud" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Ej: Asma, epilepsia, diabetes, etc.">{{ old('condicion_especial_salud', $e?->condicion_especial_salud) }}</textarea>
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
        <h3 class="font-semibold text-gray-700">Información Socioeconómica</h3>
    </div>

    <div>
        <x-input-label for="tiene_sisben" value="¿Tiene SISBEN?" />
        <select id="tiene_sisben" name="tiene_sisben" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" onchange="document.getElementById('div_grupo_sisben').style.display = this.value == '1' ? 'block' : 'none'">
            <option value="0" {{ old('tiene_sisben', $e?->tiene_sisben) == 0 ? 'selected' : '' }}>No</option>
            <option value="1" {{ old('tiene_sisben', $e?->tiene_sisben) == 1 ? 'selected' : '' }}>Sí</option>
        </select>
    </div>

    <div id="div_grupo_sisben" style="{{ old('tiene_sisben', $e?->tiene_sisben) == 1 ? '' : 'display:none' }}">
        <x-input-label for="grupo_sisben" value="Grupo SISBEN" />
        <select id="grupo_sisben" name="grupo_sisben" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">Seleccionar</option>
            @foreach(['A1','A2','A3','A4','A5','B1','B2','B3','B4','B5','B6','B7','C1','C2','C3','C4','C5','C6','C7','C8','C9','C10','C11','C12','C13','C14','C15','C16','C17','C18','D1','D2','D3','D4','D5','D6','D7','D8','D9','D10','D11','D12','D13','D14','D15','D16','D17','D18','D19','D20','D21'] as $gs)
                <option value="{{ $gs }}" {{ old('grupo_sisben', $e?->grupo_sisben) == $gs ? 'selected' : '' }}>{{ $gs }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <x-input-label for="estrato" value="Estrato Socioeconómico" />
        <select id="estrato" name="estrato" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">Seleccionar</option>
            @for($i = 1; $i <= 6; $i++)
                <option value="{{ $i }}" {{ old('estrato', $e?->estrato) == $i ? 'selected' : '' }}>Estrato {{ $i }}</option>
            @endfor
        </select>
    </div>

    <div>
        <x-input-label for="tiene_discapacidad" value="¿Tiene Discapacidad?" />
        <select id="tiene_discapacidad" name="tiene_discapacidad" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" onchange="document.getElementById('div_tipo_discapacidad').style.display = this.value == '1' ? 'block' : 'none'">
            <option value="0" {{ old('tiene_discapacidad', $e?->tiene_discapacidad) == 0 ? 'selected' : '' }}>No</option>
            <option value="1" {{ old('tiene_discapacidad', $e?->tiene_discapacidad) == 1 ? 'selected' : '' }}>Sí</option>
        </select>
    </div>

    <div id="div_tipo_discapacidad" style="{{ old('tiene_discapacidad', $e?->tiene_discapacidad) == 1 ? '' : 'display:none' }}">
        <x-input-label for="tipo_discapacidad" value="Tipo de Discapacidad" />
        <select id="tipo_discapacidad" name="tipo_discapacidad" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">Seleccionar</option>
            <option value="fisica" {{ old('tipo_discapacidad', $e?->tipo_discapacidad) == 'fisica' ? 'selected' : '' }}>Física</option>
            <option value="cognitiva" {{ old('tipo_discapacidad', $e?->tipo_discapacidad) == 'cognitiva' ? 'selected' : '' }}>Cognitiva / Intelectual</option>
            <option value="sensorial_visual" {{ old('tipo_discapacidad', $e?->tipo_discapacidad) == 'sensorial_visual' ? 'selected' : '' }}>Sensorial Visual</option>
            <option value="sensorial_auditiva" {{ old('tipo_discapacidad', $e?->tipo_discapacidad) == 'sensorial_auditiva' ? 'selected' : '' }}>Sensorial Auditiva</option>
            <option value="psicosocial" {{ old('tipo_discapacidad', $e?->tipo_discapacidad) == 'psicosocial' ? 'selected' : '' }}>Psicosocial</option>
            <option value="multiple" {{ old('tipo_discapacidad', $e?->tipo_discapacidad) == 'multiple' ? 'selected' : '' }}>Múltiple</option>
            <option value="trastorno_espectro_autista" {{ old('tipo_discapacidad', $e?->tipo_discapacidad) == 'trastorno_espectro_autista' ? 'selected' : '' }}>Trastorno del Espectro Autista</option>
            <option value="sindrome_down" {{ old('tipo_discapacidad', $e?->tipo_discapacidad) == 'sindrome_down' ? 'selected' : '' }}>Síndrome de Down</option>
        </select>
    </div>

    <div>
        <x-input-label for="tipo_poblacion" value="Tipo de Población" />
        <select id="tipo_poblacion" name="tipo_poblacion" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">Ninguna / No aplica</option>
            <option value="victima_conflicto" {{ old('tipo_poblacion', $e?->tipo_poblacion) == 'victima_conflicto' ? 'selected' : '' }}>Víctima del Conflicto Armado</option>
            <option value="desplazado" {{ old('tipo_poblacion', $e?->tipo_poblacion) == 'desplazado' ? 'selected' : '' }}>Desplazado</option>
            <option value="indigena" {{ old('tipo_poblacion', $e?->tipo_poblacion) == 'indigena' ? 'selected' : '' }}>Indígena</option>
            <option value="afrocolombiano" {{ old('tipo_poblacion', $e?->tipo_poblacion) == 'afrocolombiano' ? 'selected' : '' }}>Afrocolombiano</option>
            <option value="raizal" {{ old('tipo_poblacion', $e?->tipo_poblacion) == 'raizal' ? 'selected' : '' }}>Raizal</option>
            <option value="palenquero" {{ old('tipo_poblacion', $e?->tipo_poblacion) == 'palenquero' ? 'selected' : '' }}>Palenquero</option>
            <option value="rom_gitano" {{ old('tipo_poblacion', $e?->tipo_poblacion) == 'rom_gitano' ? 'selected' : '' }}>Rom / Gitano</option>
            <option value="migrante" {{ old('tipo_poblacion', $e?->tipo_poblacion) == 'migrante' ? 'selected' : '' }}>Migrante</option>
            <option value="reincorporado" {{ old('tipo_poblacion', $e?->tipo_poblacion) == 'reincorporado' ? 'selected' : '' }}>Reincorporado</option>
            <option value="cabeza_de_hogar" {{ old('tipo_poblacion', $e?->tipo_poblacion) == 'cabeza_de_hogar' ? 'selected' : '' }}>Hijo de Madre/Padre Cabeza de Hogar</option>
        </select>
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
