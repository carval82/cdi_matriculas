@echo off
chcp 65001 >nul
title CDI Matriculas - Instalación Completa
color 0B

echo ============================================================
echo   CDI Matriculas - Script de Instalación
echo   LC Design - Luis Carlos Correa Arrieta
echo ============================================================
echo.

:: ─── Variables ───
set PROJECT_DIR=%~dp0..
set DB_NAME=cdi_matriculas

echo [INFO] Directorio del proyecto: %PROJECT_DIR%
echo.

:: ─── 1. Instalar dependencias de Composer ───
echo [PASO 1/7] Instalando dependencias de Composer...
cd /d "%PROJECT_DIR%"
call composer install --no-dev --optimize-autoloader
if %errorlevel% neq 0 (
    echo [ERROR] Fallo al instalar dependencias de Composer.
    echo         Verifica que Composer este instalado: https://getcomposer.org
    pause
    exit /b 1
)
echo          Dependencias de Composer instaladas.
echo.

:: ─── 2. Configurar archivo .env ───
echo [PASO 2/7] Configurando archivo de entorno...
if not exist "%PROJECT_DIR%\.env" (
    copy "%PROJECT_DIR%\.env.example" "%PROJECT_DIR%\.env" >nul
    echo          Archivo .env creado desde .env.example
    echo.
    echo ============================================================
    echo   IMPORTANTE: Edita el archivo .env con los datos correctos
    echo   de tu base de datos antes de continuar.
    echo.
    echo   Archivo: %PROJECT_DIR%\.env
    echo.
    echo   Configurar:
    echo     DB_DATABASE=%DB_NAME%
    echo     DB_USERNAME=root
    echo     DB_PASSWORD=tu_password
    echo ============================================================
    echo.
    pause
) else (
    echo          Archivo .env ya existe. Omitiendo...
)
echo.

:: ─── 3. Generar clave de aplicación ───
echo [PASO 3/7] Generando clave de aplicacion...
cd /d "%PROJECT_DIR%"
call php artisan key:generate --force
echo          Clave generada.
echo.

:: ─── 4. Crear base de datos (MySQL) ───
echo [PASO 4/7] Creando base de datos %DB_NAME%...
mysql -u root -e "CREATE DATABASE IF NOT EXISTS %DB_NAME% CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" 2>nul
if %errorlevel% equ 0 (
    echo          Base de datos creada o ya existente.
) else (
    echo          [AVISO] No se pudo crear la BD automaticamente.
    echo          Creala manualmente: CREATE DATABASE %DB_NAME%;
)
echo.

:: ─── 5. Ejecutar migraciones y seeder ───
echo [PASO 5/7] Ejecutando migraciones...
cd /d "%PROJECT_DIR%"
call php artisan migrate --force
echo.
echo          Ejecutando seeder (usuario admin)...
call php artisan db:seed --force
echo          Migraciones y seeder completados.
echo.

:: ─── 6. Storage link ───
echo [PASO 6/7] Creando enlace de storage...
cd /d "%PROJECT_DIR%"
call php artisan storage:link 2>nul
echo          Storage link creado.
echo.

:: ─── 7. Instalar y compilar assets (NPM) ───
echo [PASO 7/7] Instalando y compilando assets...
cd /d "%PROJECT_DIR%"
call npm install
call npm run build
if %errorlevel% equ 0 (
    echo          Assets compilados correctamente.
) else (
    echo          [AVISO] Error al compilar assets.
    echo          Verifica que Node.js este instalado: https://nodejs.org
)
echo.

:: ─── Limpiar cache ───
echo [EXTRA] Limpiando cache...
cd /d "%PROJECT_DIR%"
call php artisan config:clear
call php artisan route:clear
call php artisan view:clear
call php artisan cache:clear
echo          Cache limpiada.
echo.

echo ============================================================
echo   INSTALACION COMPLETADA EXITOSAMENTE
echo ============================================================
echo.
echo   Credenciales de acceso:
echo     Email:      pcapacho24@gmail.com
echo     Password:   anaval33
echo     Rol:        Administrador
echo.
echo   Para configurar el host virtual ejecuta:
echo     scripts\setup-vhost.bat (como Administrador)
echo.
echo   O accede directamente en:
echo     http://localhost/laravel/cdi_matriculas/public
echo.
echo ============================================================
pause
