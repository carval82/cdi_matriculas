@echo off
chcp 65001 >nul
title CDI Matriculas - Configuración de Host Virtual
color 0A

echo ============================================================
echo   CDI Matriculas - Configurador de Host Virtual (XAMPP)
echo   LC Design - Luis Carlos Correa Arrieta
echo ============================================================
echo.

:: ─── Variables configurables ───
set DOMAIN=cdimatriculas.local
set PROJECT_PATH=C:\xampp\htdocs\laravel\cdi_matriculas\public
set APACHE_CONF=C:\xampp\apache\conf\extra\httpd-vhosts.conf
set HOSTS_FILE=C:\Windows\System32\drivers\etc\hosts

:: ─── Verificar permisos de administrador ───
net session >nul 2>&1
if %errorlevel% neq 0 (
    echo [ERROR] Este script requiere permisos de ADMINISTRADOR.
    echo         Haz clic derecho y selecciona "Ejecutar como administrador".
    echo.
    pause
    exit /b 1
)

echo [INFO] Dominio:       %DOMAIN%
echo [INFO] Ruta proyecto:  %PROJECT_PATH%
echo [INFO] Apache config:  %APACHE_CONF%
echo [INFO] Archivo hosts:  %HOSTS_FILE%
echo.

:: ─── 1. Configurar archivo hosts ───
echo [PASO 1/3] Configurando archivo hosts...
findstr /C:"%DOMAIN%" "%HOSTS_FILE%" >nul 2>&1
if %errorlevel% equ 0 (
    echo          Ya existe la entrada para %DOMAIN% en hosts. Omitiendo...
) else (
    echo.>> "%HOSTS_FILE%"
    echo 127.0.0.1       %DOMAIN%>> "%HOSTS_FILE%"
    echo          Entrada agregada: 127.0.0.1  %DOMAIN%
)
echo.

:: ─── 2. Configurar Virtual Host en Apache ───
echo [PASO 2/3] Configurando Virtual Host en Apache...
findstr /C:"%DOMAIN%" "%APACHE_CONF%" >nul 2>&1
if %errorlevel% equ 0 (
    echo          Ya existe el VirtualHost para %DOMAIN%. Omitiendo...
) else (
    echo.>> "%APACHE_CONF%"
    echo ## CDI Matriculas - Host Virtual>> "%APACHE_CONF%"
    echo ^<VirtualHost *:80^>>> "%APACHE_CONF%"
    echo     ServerName %DOMAIN%>> "%APACHE_CONF%"
    echo     DocumentRoot "%PROJECT_PATH%">> "%APACHE_CONF%"
    echo     ^<Directory "%PROJECT_PATH%"^>>> "%APACHE_CONF%"
    echo         Options Indexes FollowSymLinks MultiViews>> "%APACHE_CONF%"
    echo         AllowOverride All>> "%APACHE_CONF%"
    echo         Require all granted>> "%APACHE_CONF%"
    echo     ^</Directory^>>> "%APACHE_CONF%"
    echo     ErrorLog "logs/cdimatriculas-error.log">> "%APACHE_CONF%"
    echo     CustomLog "logs/cdimatriculas-access.log" common>> "%APACHE_CONF%"
    echo ^</VirtualHost^>>> "%APACHE_CONF%"
    echo          VirtualHost creado para %DOMAIN%
)
echo.

:: ─── 3. Reiniciar Apache ───
echo [PASO 3/3] Reiniciando Apache...
cd /d C:\xampp
apache\bin\httpd.exe -k restart >nul 2>&1
if %errorlevel% equ 0 (
    echo          Apache reiniciado correctamente.
) else (
    echo          [AVISO] No se pudo reiniciar Apache automaticamente.
    echo          Reinicia Apache manualmente desde el panel de XAMPP.
)
echo.

echo ============================================================
echo   CONFIGURACION COMPLETADA
echo ============================================================
echo.
echo   Accede al sistema en:  http://%DOMAIN%
echo.
echo   Credenciales de acceso:
echo     Email:      pcapacho24@gmail.com
echo     Password:   anaval33
echo.
echo   Si no funciona, verifica que:
echo     1. Apache este corriendo en XAMPP
echo     2. El modulo mod_rewrite este habilitado
echo     3. La base de datos este creada y migrada
echo.
echo   Comandos de instalacion:
echo     composer install
echo     cp .env.example .env
echo     php artisan key:generate
echo     php artisan migrate
echo     php artisan db:seed
echo     php artisan storage:link
echo     npm install ^&^& npm run build
echo.
echo ============================================================
pause
