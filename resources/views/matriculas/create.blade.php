<x-app-layout>
    <x-slot name="header">Nueva Matrícula</x-slot>

    <style>
        .section-card { background: white; border-radius: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); padding: 24px; margin-bottom: 20px; }
        .section-title { font-size: 1rem; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 8px; margin-bottom: 16px; }
        .section-title i { font-size: 0.9rem; }
        .tab-group { display: flex; gap: 8px; margin-bottom: 16px; }
        .tab-btn { padding: 8px 16px; border-radius: 8px; font-size: 0.85rem; font-weight: 600; cursor: pointer; border: 2px solid #e2e8f0; background: white; color: #64748b; transition: all 0.15s; }
        .tab-btn.active { border-color: #6366f1; background: #eef2ff; color: #4f46e5; }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        .form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 14px; }
        @media (max-width: 640px) { .form-grid { grid-template-columns: 1fr; } }
        .form-grid .full { grid-column: 1 / -1; }
        .inp { margin-top: 4px; display: block; width: 100%; border: 1px solid #d1d5db; border-radius: 8px; padding: 8px 12px; font-size: 0.875rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
        .inp:focus { outline: none; border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,0.1); }
        .lbl { font-size: 0.8rem; font-weight: 600; color: #374151; }
        .btn-submit { display: inline-flex; align-items: center; gap: 8px; padding: 10px 24px; background: linear-gradient(135deg, #6366f1, #4f46e5); color: white; font-weight: 700; font-size: 0.9rem; border: none; border-radius: 10px; cursor: pointer; transition: all 0.2s; box-shadow: 0 2px 8px rgba(99,102,241,0.3); }
        .btn-submit:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(99,102,241,0.4); }
    </style>

    <div style="max-width:800px;margin:0 auto;">
        @if(session('error'))
            <div style="margin-bottom:16px;padding:12px 16px;background:#fef2f2;border:1px solid #fca5a5;color:#dc2626;border-radius:10px;font-size:0.85rem;">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div style="margin-bottom:16px;padding:12px 16px;background:#fef2f2;border:1px solid #fca5a5;color:#dc2626;border-radius:10px;font-size:0.85rem;">
                <i class="fas fa-exclamation-triangle"></i> Por favor corrige los errores marcados.
            </div>
        @endif

        <form action="{{ route('matriculas.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- ═══════════ SECCIÓN 1: ACUDIENTE ═══════════ --}}
            <div class="section-card">
                <div class="section-title"><i class="fas fa-users" style="color:#8b5cf6;"></i> 1. Acudiente</div>
                <input type="hidden" name="modo_acudiente" id="modo_acudiente" value="{{ old('modo_acudiente', 'existente') }}">
                <div class="tab-group">
                    <button type="button" class="tab-btn {{ old('modo_acudiente', 'existente') == 'existente' ? 'active' : '' }}" onclick="switchTab('acudiente', 'existente')">
                        <i class="fas fa-search"></i> Existente
                    </button>
                    <button type="button" class="tab-btn {{ old('modo_acudiente') == 'nuevo' ? 'active' : '' }}" onclick="switchTab('acudiente', 'nuevo')">
                        <i class="fas fa-plus"></i> Crear Nuevo
                    </button>
                </div>

                <div id="acudiente_existente" class="tab-content {{ old('modo_acudiente', 'existente') == 'existente' ? 'active' : '' }}">
                    <label class="lbl">Seleccionar Acudiente *</label>
                    <select name="acudiente_id" id="acudiente_id" class="inp">
                        <option value="">-- Seleccionar --</option>
                        @foreach($acudientes as $acu)
                            <option value="{{ $acu->id }}" {{ old('acudiente_id', $estudiantePreseleccionado?->acudiente_id) == $acu->id ? 'selected' : '' }}>
                                {{ $acu->nombre_completo }} - {{ $acu->tipo_documento }} {{ $acu->documento }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('acudiente_id')" class="mt-1" />
                </div>

                <div id="acudiente_nuevo" class="tab-content {{ old('modo_acudiente') == 'nuevo' ? 'active' : '' }}">
                    <div class="form-grid">
                        <div>
                            <label class="lbl">Nombres *</label>
                            <input type="text" name="acu_nombres" class="inp" value="{{ old('acu_nombres') }}">
                            <x-input-error :messages="$errors->get('acu_nombres')" class="mt-1" />
                        </div>
                        <div>
                            <label class="lbl">Apellidos *</label>
                            <input type="text" name="acu_apellidos" class="inp" value="{{ old('acu_apellidos') }}">
                            <x-input-error :messages="$errors->get('acu_apellidos')" class="mt-1" />
                        </div>
                        <div>
                            <label class="lbl">Tipo Doc.</label>
                            <select name="acu_tipo_documento" class="inp">
                                <option value="CC" {{ old('acu_tipo_documento') == 'CC' ? 'selected' : '' }}>CC</option>
                                <option value="CE" {{ old('acu_tipo_documento') == 'CE' ? 'selected' : '' }}>CE</option>
                                <option value="PA" {{ old('acu_tipo_documento') == 'PA' ? 'selected' : '' }}>Pasaporte</option>
                            </select>
                        </div>
                        <div>
                            <label class="lbl">Documento *</label>
                            <input type="text" name="acu_documento" class="inp" value="{{ old('acu_documento') }}">
                            <x-input-error :messages="$errors->get('acu_documento')" class="mt-1" />
                        </div>
                        <div>
                            <label class="lbl">Celular *</label>
                            <input type="text" name="acu_celular" class="inp" value="{{ old('acu_celular') }}">
                            <x-input-error :messages="$errors->get('acu_celular')" class="mt-1" />
                        </div>
                        <div>
                            <label class="lbl">Teléfono</label>
                            <input type="text" name="acu_telefono" class="inp" value="{{ old('acu_telefono') }}">
                        </div>
                        <div>
                            <label class="lbl">Email</label>
                            <input type="email" name="acu_email" class="inp" value="{{ old('acu_email') }}">
                        </div>
                        <div>
                            <label class="lbl">Parentesco</label>
                            <select name="acu_parentesco" class="inp">
                                <option value="Madre" {{ old('acu_parentesco') == 'Madre' ? 'selected' : '' }}>Madre</option>
                                <option value="Padre" {{ old('acu_parentesco') == 'Padre' ? 'selected' : '' }}>Padre</option>
                                <option value="Abuelo(a)" {{ old('acu_parentesco') == 'Abuelo(a)' ? 'selected' : '' }}>Abuelo(a)</option>
                                <option value="Tío(a)" {{ old('acu_parentesco') == 'Tío(a)' ? 'selected' : '' }}>Tío(a)</option>
                                <option value="Otro" {{ old('acu_parentesco') == 'Otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                        </div>
                        <div>
                            <label class="lbl">Dirección</label>
                            <input type="text" name="acu_direccion" class="inp" value="{{ old('acu_direccion') }}">
                        </div>
                        <div>
                            <label class="lbl">Barrio</label>
                            <input type="text" name="acu_barrio" class="inp" value="{{ old('acu_barrio') }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- ═══════════ SECCIÓN 2: ESTUDIANTE ═══════════ --}}
            <div class="section-card">
                <div class="section-title"><i class="fas fa-user-graduate" style="color:#3b82f6;"></i> 2. Estudiante</div>
                <input type="hidden" name="modo_estudiante" id="modo_estudiante" value="{{ old('modo_estudiante', 'existente') }}">
                <div class="tab-group">
                    <button type="button" class="tab-btn {{ old('modo_estudiante', 'existente') == 'existente' ? 'active' : '' }}" onclick="switchTab('estudiante', 'existente')">
                        <i class="fas fa-search"></i> Existente
                    </button>
                    <button type="button" class="tab-btn {{ old('modo_estudiante') == 'nuevo' ? 'active' : '' }}" onclick="switchTab('estudiante', 'nuevo')">
                        <i class="fas fa-plus"></i> Crear Nuevo
                    </button>
                </div>

                <div id="estudiante_existente" class="tab-content {{ old('modo_estudiante', 'existente') == 'existente' ? 'active' : '' }}">
                    <label class="lbl">Seleccionar Estudiante *</label>
                    <select name="estudiante_id" id="estudiante_id" class="inp">
                        <option value="">-- Seleccionar --</option>
                        @foreach($estudiantes as $est)
                            <option value="{{ $est->id }}" {{ old('estudiante_id', $estudiantePreseleccionado?->id) == $est->id ? 'selected' : '' }}>
                                {{ $est->nombre_completo }} - {{ $est->documento ?? $est->codigo }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('estudiante_id')" class="mt-1" />
                </div>

                <div id="estudiante_nuevo" class="tab-content {{ old('modo_estudiante') == 'nuevo' ? 'active' : '' }}">
                    <div class="form-grid">
                        <div>
                            <label class="lbl">Nombres *</label>
                            <input type="text" name="est_nombres" class="inp" value="{{ old('est_nombres') }}">
                            <x-input-error :messages="$errors->get('est_nombres')" class="mt-1" />
                        </div>
                        <div>
                            <label class="lbl">Apellidos *</label>
                            <input type="text" name="est_apellidos" class="inp" value="{{ old('est_apellidos') }}">
                            <x-input-error :messages="$errors->get('est_apellidos')" class="mt-1" />
                        </div>
                        <div>
                            <label class="lbl">Fecha Nacimiento *</label>
                            <input type="date" name="est_fecha_nacimiento" class="inp" value="{{ old('est_fecha_nacimiento') }}">
                            <x-input-error :messages="$errors->get('est_fecha_nacimiento')" class="mt-1" />
                        </div>
                        <div>
                            <label class="lbl">Género *</label>
                            <select name="est_genero" class="inp">
                                <option value="masculino" {{ old('est_genero') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="femenino" {{ old('est_genero') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                            </select>
                            <x-input-error :messages="$errors->get('est_genero')" class="mt-1" />
                        </div>
                        <div>
                            <label class="lbl">Tipo Doc.</label>
                            <select name="est_tipo_documento" class="inp">
                                <option value="RC" {{ old('est_tipo_documento', 'RC') == 'RC' ? 'selected' : '' }}>Registro Civil</option>
                                <option value="TI" {{ old('est_tipo_documento') == 'TI' ? 'selected' : '' }}>Tarjeta de Identidad</option>
                                <option value="NUIP" {{ old('est_tipo_documento') == 'NUIP' ? 'selected' : '' }}>NUIP</option>
                                <option value="PEP" {{ old('est_tipo_documento') == 'PEP' ? 'selected' : '' }}>PEP</option>
                                <option value="PPT" {{ old('est_tipo_documento') == 'PPT' ? 'selected' : '' }}>PPT</option>
                                <option value="CE" {{ old('est_tipo_documento') == 'CE' ? 'selected' : '' }}>Cédula Extranjería</option>
                                <option value="PA" {{ old('est_tipo_documento') == 'PA' ? 'selected' : '' }}>Pasaporte</option>
                                <option value="SD" {{ old('est_tipo_documento') == 'SD' ? 'selected' : '' }}>Sin Documento</option>
                            </select>
                        </div>
                        <div>
                            <label class="lbl">Documento</label>
                            <input type="text" name="est_documento" class="inp" value="{{ old('est_documento') }}">
                        </div>
                        <div>
                            <label class="lbl">RH</label>
                            <select name="est_rh" class="inp">
                                <option value="">--</option>
                                @foreach(['O+','O-','A+','A-','B+','B-','AB+','AB-'] as $rh)
                                    <option value="{{ $rh }}" {{ old('est_rh') == $rh ? 'selected' : '' }}>{{ $rh }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="lbl">EPS</label>
                            <input type="text" name="est_eps" class="inp" value="{{ old('est_eps') }}">
                        </div>
                        <div>
                            <label class="lbl">Tipo Afiliación EPS</label>
                            <select name="est_tipo_eps" class="inp">
                                <option value="">Seleccionar</option>
                                <option value="contributivo" {{ old('est_tipo_eps') == 'contributivo' ? 'selected' : '' }}>Contributivo</option>
                                <option value="subsidiado" {{ old('est_tipo_eps') == 'subsidiado' ? 'selected' : '' }}>Subsidiado</option>
                                <option value="beneficiario" {{ old('est_tipo_eps') == 'beneficiario' ? 'selected' : '' }}>Beneficiario</option>
                                <option value="regimen_especial" {{ old('est_tipo_eps') == 'regimen_especial' ? 'selected' : '' }}>Régimen Especial</option>
                                <option value="no_afiliado" {{ old('est_tipo_eps') == 'no_afiliado' ? 'selected' : '' }}>No Afiliado</option>
                            </select>
                        </div>
                        <div>
                            <label class="lbl">Nacionalidad</label>
                            <select name="est_nacionalidad" class="inp">
                                <option value="Colombiana" {{ old('est_nacionalidad', 'Colombiana') == 'Colombiana' ? 'selected' : '' }}>Colombiana</option>
                                <option value="Venezolana" {{ old('est_nacionalidad') == 'Venezolana' ? 'selected' : '' }}>Venezolana</option>
                                <option value="Ecuatoriana" {{ old('est_nacionalidad') == 'Ecuatoriana' ? 'selected' : '' }}>Ecuatoriana</option>
                                <option value="Peruana" {{ old('est_nacionalidad') == 'Peruana' ? 'selected' : '' }}>Peruana</option>
                                <option value="Haitiana" {{ old('est_nacionalidad') == 'Haitiana' ? 'selected' : '' }}>Haitiana</option>
                                <option value="Otra" {{ old('est_nacionalidad') == 'Otra' ? 'selected' : '' }}>Otra</option>
                            </select>
                        </div>
                        <div>
                            <label class="lbl">País de Origen (si extranjero)</label>
                            <input type="text" name="est_pais_origen" class="inp" value="{{ old('est_pais_origen') }}" placeholder="Ej: Venezuela">
                        </div>

                        <div class="full" style="border-top:1px solid #e2e8f0;padding-top:12px;margin-top:4px;">
                            <label class="lbl" style="color:#6366f1;"><i class="fas fa-hand-holding-heart"></i> Información Socioeconómica</label>
                        </div>
                        <div>
                            <label class="lbl">¿Tiene SISBEN?</label>
                            <select name="est_tiene_sisben" class="inp" onchange="document.getElementById('div_est_grupo_sisben').style.display = this.value == '1' ? 'block' : 'none'">
                                <option value="0" {{ old('est_tiene_sisben') == '0' ? 'selected' : '' }}>No</option>
                                <option value="1" {{ old('est_tiene_sisben') == '1' ? 'selected' : '' }}>Sí</option>
                            </select>
                        </div>
                        <div id="div_est_grupo_sisben" style="{{ old('est_tiene_sisben') == '1' ? '' : 'display:none' }}">
                            <label class="lbl">Grupo SISBEN</label>
                            <select name="est_grupo_sisben" class="inp">
                                <option value="">Seleccionar</option>
                                @foreach(['A1','A2','A3','A4','A5','B1','B2','B3','B4','B5','B6','B7','C1','C2','C3','C4','C5','C6','C7','C8','C9','C10','C11','C12','C13','C14','C15','C16','C17','C18','D1','D2','D3','D4','D5','D6','D7','D8','D9','D10','D11','D12','D13','D14','D15','D16','D17','D18','D19','D20','D21'] as $gs)
                                    <option value="{{ $gs }}" {{ old('est_grupo_sisben') == $gs ? 'selected' : '' }}>{{ $gs }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="lbl">Estrato</label>
                            <select name="est_estrato" class="inp">
                                <option value="">Seleccionar</option>
                                @for($i = 1; $i <= 6; $i++)
                                    <option value="{{ $i }}" {{ old('est_estrato') == $i ? 'selected' : '' }}>Estrato {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="lbl">¿Tiene Discapacidad?</label>
                            <select name="est_tiene_discapacidad" class="inp" onchange="document.getElementById('div_est_tipo_disc').style.display = this.value == '1' ? 'block' : 'none'">
                                <option value="0" {{ old('est_tiene_discapacidad') == '0' ? 'selected' : '' }}>No</option>
                                <option value="1" {{ old('est_tiene_discapacidad') == '1' ? 'selected' : '' }}>Sí</option>
                            </select>
                        </div>
                        <div id="div_est_tipo_disc" style="{{ old('est_tiene_discapacidad') == '1' ? '' : 'display:none' }}">
                            <label class="lbl">Tipo de Discapacidad</label>
                            <select name="est_tipo_discapacidad" class="inp">
                                <option value="">Seleccionar</option>
                                <option value="fisica" {{ old('est_tipo_discapacidad') == 'fisica' ? 'selected' : '' }}>Física</option>
                                <option value="cognitiva" {{ old('est_tipo_discapacidad') == 'cognitiva' ? 'selected' : '' }}>Cognitiva / Intelectual</option>
                                <option value="sensorial_visual" {{ old('est_tipo_discapacidad') == 'sensorial_visual' ? 'selected' : '' }}>Sensorial Visual</option>
                                <option value="sensorial_auditiva" {{ old('est_tipo_discapacidad') == 'sensorial_auditiva' ? 'selected' : '' }}>Sensorial Auditiva</option>
                                <option value="psicosocial" {{ old('est_tipo_discapacidad') == 'psicosocial' ? 'selected' : '' }}>Psicosocial</option>
                                <option value="multiple" {{ old('est_tipo_discapacidad') == 'multiple' ? 'selected' : '' }}>Múltiple</option>
                                <option value="trastorno_espectro_autista" {{ old('est_tipo_discapacidad') == 'trastorno_espectro_autista' ? 'selected' : '' }}>Trastorno del Espectro Autista</option>
                                <option value="sindrome_down" {{ old('est_tipo_discapacidad') == 'sindrome_down' ? 'selected' : '' }}>Síndrome de Down</option>
                            </select>
                        </div>
                        <div>
                            <label class="lbl">Tipo de Población</label>
                            <select name="est_tipo_poblacion" class="inp">
                                <option value="">Ninguna / No aplica</option>
                                <option value="victima_conflicto" {{ old('est_tipo_poblacion') == 'victima_conflicto' ? 'selected' : '' }}>Víctima del Conflicto</option>
                                <option value="desplazado" {{ old('est_tipo_poblacion') == 'desplazado' ? 'selected' : '' }}>Desplazado</option>
                                <option value="indigena" {{ old('est_tipo_poblacion') == 'indigena' ? 'selected' : '' }}>Indígena</option>
                                <option value="afrocolombiano" {{ old('est_tipo_poblacion') == 'afrocolombiano' ? 'selected' : '' }}>Afrocolombiano</option>
                                <option value="raizal" {{ old('est_tipo_poblacion') == 'raizal' ? 'selected' : '' }}>Raizal</option>
                                <option value="palenquero" {{ old('est_tipo_poblacion') == 'palenquero' ? 'selected' : '' }}>Palenquero</option>
                                <option value="rom_gitano" {{ old('est_tipo_poblacion') == 'rom_gitano' ? 'selected' : '' }}>Rom / Gitano</option>
                                <option value="migrante" {{ old('est_tipo_poblacion') == 'migrante' ? 'selected' : '' }}>Migrante</option>
                                <option value="reincorporado" {{ old('est_tipo_poblacion') == 'reincorporado' ? 'selected' : '' }}>Reincorporado</option>
                                <option value="cabeza_de_hogar" {{ old('est_tipo_poblacion') == 'cabeza_de_hogar' ? 'selected' : '' }}>Hijo Cabeza de Hogar</option>
                            </select>
                        </div>
                        <div>
                            <label class="lbl">Diagnóstico Médico</label>
                            <input type="text" name="est_diagnostico_medico" class="inp" value="{{ old('est_diagnostico_medico') }}" placeholder="Si aplica">
                        </div>
                        <div>
                            <label class="lbl">Condición Especial de Salud</label>
                            <input type="text" name="est_condicion_especial_salud" class="inp" value="{{ old('est_condicion_especial_salud') }}" placeholder="Ej: Asma, epilepsia...">
                        </div>
                    </div>
                </div>
            </div>

            {{-- ═══════════ SECCIÓN 3: DATOS DE MATRÍCULA ═══════════ --}}
            <div class="section-card">
                <div class="section-title"><i class="fas fa-file-signature" style="color:#22c55e;"></i> 3. Datos de Matrícula</div>
                <div class="form-grid">
                    <div>
                        <label class="lbl">Grupo *</label>
                        <select name="grupo_id" id="grupo_id" class="inp" required onchange="actualizarValores()">
                            <option value="">-- Seleccionar --</option>
                            @foreach($grupos as $g)
                                <option value="{{ $g->id }}" data-matricula="{{ $g->valor_matricula }}" data-pension="{{ $g->valor_pension }}"
                                    {{ old('grupo_id', $estudiantePreseleccionado?->grupo_id) == $g->id ? 'selected' : '' }}>
                                    {{ $g->nombre }} ({{ $g->cuposDisponibles() }} cupos)
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('grupo_id')" class="mt-1" />
                    </div>
                    <div>
                        <label class="lbl">Año *</label>
                        <input type="number" name="anio" class="inp" value="{{ old('anio', now()->year) }}" required min="2020">
                        <x-input-error :messages="$errors->get('anio')" class="mt-1" />
                    </div>
                    <div>
                        <label class="lbl">Fecha Matrícula *</label>
                        <input type="date" name="fecha_matricula" class="inp" value="{{ old('fecha_matricula', now()->format('Y-m-d')) }}" required>
                        <x-input-error :messages="$errors->get('fecha_matricula')" class="mt-1" />
                    </div>
                    <div>
                        <label class="lbl">Periodo</label>
                        <select name="periodo" class="inp">
                            <option value="anual" {{ old('periodo') == 'anual' ? 'selected' : '' }}>Anual</option>
                            <option value="semestre1" {{ old('periodo') == 'semestre1' ? 'selected' : '' }}>Semestre 1</option>
                            <option value="semestre2" {{ old('periodo') == 'semestre2' ? 'selected' : '' }}>Semestre 2</option>
                        </select>
                    </div>
                    <div>
                        <label class="lbl">Jornada</label>
                        <select name="jornada" class="inp">
                            <option value="completa" {{ old('jornada') == 'completa' ? 'selected' : '' }}>Completa</option>
                            <option value="mañana" {{ old('jornada') == 'mañana' ? 'selected' : '' }}>Mañana</option>
                            <option value="tarde" {{ old('jornada') == 'tarde' ? 'selected' : '' }}>Tarde</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- ═══════════ SECCIÓN 4: VALORES ═══════════ --}}
            <div class="section-card">
                <div class="section-title"><i class="fas fa-dollar-sign" style="color:#10b981;"></i> 4. Valores</div>
                <div class="form-grid">
                    <div>
                        <label class="lbl">Valor Matrícula *</label>
                        <input type="number" name="valor_matricula" id="valor_matricula" step="0.01" class="inp" value="{{ old('valor_matricula', 0) }}" required>
                        <x-input-error :messages="$errors->get('valor_matricula')" class="mt-1" />
                    </div>
                    <div>
                        <label class="lbl">Valor Pensión Mensual *</label>
                        <input type="number" name="valor_pension" id="valor_pension" step="0.01" class="inp" value="{{ old('valor_pension', 0) }}" required>
                        <x-input-error :messages="$errors->get('valor_pension')" class="mt-1" />
                    </div>
                    <div>
                        <label class="lbl">Descuento</label>
                        <input type="number" name="descuento" step="0.01" class="inp" value="{{ old('descuento', 0) }}">
                    </div>
                    <div>
                        <label class="lbl">Tipo Descuento</label>
                        <select name="tipo_descuento" class="inp">
                            <option value="">Ninguno</option>
                            <option value="hermano" {{ old('tipo_descuento') == 'hermano' ? 'selected' : '' }}>Hermano</option>
                            <option value="becado" {{ old('tipo_descuento') == 'becado' ? 'selected' : '' }}>Becado</option>
                            <option value="empleado" {{ old('tipo_descuento') == 'empleado' ? 'selected' : '' }}>Empleado</option>
                            <option value="otro" {{ old('tipo_descuento') == 'otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>
                    <div class="full">
                        <label class="lbl">Observaciones</label>
                        <textarea name="observaciones" rows="2" class="inp">{{ old('observaciones') }}</textarea>
                    </div>
                </div>
            </div>

            <div style="display:flex;align-items:center;gap:16px;margin-top:8px;">
                <button type="submit" class="btn-submit">
                    <i class="fas fa-check"></i> Registrar Matrícula
                </button>
                <a href="{{ route('matriculas.index') }}" style="font-size:0.85rem;color:#64748b;text-decoration:none;">Cancelar</a>
            </div>
        </form>
    </div>

    <script>
        function switchTab(section, mode) {
            document.getElementById('modo_' + section).value = mode;
            document.querySelectorAll('#' + section + '_existente, #' + section + '_nuevo').forEach(el => el.classList.remove('active'));
            document.getElementById(section + '_' + mode).classList.add('active');
            // Update tab buttons
            const parent = document.getElementById(section + '_' + mode).closest('.section-card');
            parent.querySelectorAll('.tab-btn').forEach((btn, i) => {
                btn.classList.toggle('active', (mode === 'existente' && i === 0) || (mode === 'nuevo' && i === 1));
            });
        }

        function actualizarValores() {
            const select = document.getElementById('grupo_id');
            const option = select.options[select.selectedIndex];
            if (option.value) {
                document.getElementById('valor_matricula').value = option.dataset.matricula || 0;
                document.getElementById('valor_pension').value = option.dataset.pension || 0;
            }
        }

        document.addEventListener('DOMContentLoaded', actualizarValores);
    </script>
</x-app-layout>
