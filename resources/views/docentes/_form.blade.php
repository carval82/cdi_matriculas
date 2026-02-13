@php $e = $docente ?? null; @endphp

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
            <option value="CC" {{ old('tipo_documento', $e?->tipo_documento) == 'CC' ? 'selected' : '' }}>Cédula de Ciudadanía</option>
            <option value="CE" {{ old('tipo_documento', $e?->tipo_documento) == 'CE' ? 'selected' : '' }}>Cédula de Extranjería</option>
            <option value="PA" {{ old('tipo_documento', $e?->tipo_documento) == 'PA' ? 'selected' : '' }}>Pasaporte</option>
            <option value="PEP" {{ old('tipo_documento', $e?->tipo_documento) == 'PEP' ? 'selected' : '' }}>PEP</option>
            <option value="PPT" {{ old('tipo_documento', $e?->tipo_documento) == 'PPT' ? 'selected' : '' }}>PPT</option>
        </select>
    </div>

    <div>
        <x-input-label for="documento" value="Número Documento *" />
        <x-text-input id="documento" name="documento" type="text" class="mt-1 block w-full" :value="old('documento', $e?->documento)" required />
        <x-input-error :messages="$errors->get('documento')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="celular" value="Celular" />
        <x-text-input id="celular" name="celular" type="text" class="mt-1 block w-full" :value="old('celular', $e?->celular)" />
    </div>

    <div>
        <x-input-label for="telefono" value="Teléfono" />
        <x-text-input id="telefono" name="telefono" type="text" class="mt-1 block w-full" :value="old('telefono', $e?->telefono)" />
    </div>

    <div>
        <x-input-label for="email" value="Email" />
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $e?->email)" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="direccion" value="Dirección" />
        <x-text-input id="direccion" name="direccion" type="text" class="mt-1 block w-full" :value="old('direccion', $e?->direccion)" />
    </div>

    <div class="md:col-span-2 border-b pb-2 mb-2 mt-4">
        <h3 class="font-semibold text-gray-700">Información Profesional</h3>
    </div>

    <div>
        <x-input-label for="especialidad" value="Especialidad / Área" />
        <x-text-input id="especialidad" name="especialidad" type="text" class="mt-1 block w-full" :value="old('especialidad', $e?->especialidad)" placeholder="Ej: Primera Infancia, Pedagogía..." />
    </div>

    <div>
        <x-input-label for="titulo" value="Título Profesional" />
        <x-text-input id="titulo" name="titulo" type="text" class="mt-1 block w-full" :value="old('titulo', $e?->titulo)" placeholder="Ej: Lic. en Pedagogía Infantil" />
    </div>

    <div>
        <x-input-label for="fecha_ingreso" value="Fecha de Ingreso" />
        <x-text-input id="fecha_ingreso" name="fecha_ingreso" type="date" class="mt-1 block w-full" :value="old('fecha_ingreso', $e?->fecha_ingreso?->format('Y-m-d') ?? now()->format('Y-m-d'))" />
    </div>

    <div>
        <x-input-label for="foto" value="Foto" />
        <input id="foto" name="foto" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
        @if($e?->foto)
            <img src="{{ asset('storage/' . $e->foto) }}" alt="Foto" class="mt-2 h-20 w-20 object-cover rounded-full">
        @endif
    </div>

    <div class="md:col-span-2 border-b pb-2 mb-2 mt-4">
        <h3 class="font-semibold text-gray-700">Asignación de Grupos ({{ date('Y') }})</h3>
    </div>

    <div class="md:col-span-2">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            @foreach($grupos as $g)
                <label class="flex items-center gap-2 p-3 border rounded-lg cursor-pointer hover:bg-indigo-50 transition {{ in_array($g->id, old('grupos', $gruposAsignados ?? [])) ? 'bg-indigo-50 border-indigo-300' : '' }}">
                    <input type="checkbox" name="grupos[]" value="{{ $g->id }}" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                        {{ in_array($g->id, old('grupos', $gruposAsignados ?? [])) ? 'checked' : '' }}>
                    <span class="text-sm font-medium">{{ $g->nombre }}</span>
                </label>
            @endforeach
        </div>
    </div>

    <div class="md:col-span-2 border-b pb-2 mb-2 mt-4">
        <h3 class="font-semibold text-gray-700">Acceso al Sistema</h3>
    </div>

    @if(!$e?->user_id)
    <div class="md:col-span-2">
        <label class="flex items-center gap-2">
            <input type="checkbox" name="crear_usuario" value="1" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                {{ old('crear_usuario') ? 'checked' : '' }}
                onchange="document.getElementById('div_password').style.display = this.checked ? 'block' : 'none'">
            <span class="text-sm font-medium text-gray-700">Crear usuario de acceso al sistema (requiere email)</span>
        </label>
    </div>
    <div id="div_password" class="md:col-span-2" style="{{ old('crear_usuario') ? '' : 'display:none' }}">
        <x-input-label for="password" value="Contraseña (dejar vacío para usar el documento)" />
        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" placeholder="Opcional - por defecto usa el documento" />
    </div>
    @else
    <div class="md:col-span-2">
        <div class="flex items-center gap-2 p-3 bg-green-50 border border-green-200 rounded-lg">
            <i class="fas fa-check-circle text-green-600"></i>
            <span class="text-sm text-green-800">Este docente ya tiene acceso al sistema ({{ $e->user?->email }})</span>
        </div>
    </div>
    @endif

    <div>
        <x-input-label for="activo" value="Estado" />
        <select id="activo" name="activo" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="1" {{ old('activo', $e?->activo ?? true) ? 'selected' : '' }}>Activo</option>
            <option value="0" {{ !old('activo', $e?->activo ?? true) ? 'selected' : '' }}>Inactivo</option>
        </select>
    </div>

    <div class="md:col-span-2">
        <x-input-label for="observaciones" value="Observaciones" />
        <textarea id="observaciones" name="observaciones" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('observaciones', $e?->observaciones) }}</textarea>
    </div>
</div>
