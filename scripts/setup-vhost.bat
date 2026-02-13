@echo off
chcp 65001 >nul
title CDI Matriculas - Configuracion de Host Virtual
color 0A

echo ============================================================
echo   CDI Matriculas - Configurador de Host Virtual (XAMPP)
echo   LC Design - Luis Carlos Correa Arrieta
echo ============================================================
echo.

:: ─── Variables configurables ───
set DOMAIN=cdimatriculas.local
set "PROJECT_PATH=C:\xampp\htdocs\laravel\cdi_matriculas\public"
set "APACHE_CONF=C:\xampp\apache\conf\extra\httpd-vhosts.conf"
set "HOSTS_FILE=C:\Windows\System32\drivers\etc\hosts"

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
echo [PASO 1/3] Archivo hosts...
findstr /C:"%DOMAIN%" "%HOSTS_FILE%" >nul 2>&1
if %errorlevel% equ 0 goto hosts_ok

echo.
echo          Agrega esta linea al final del archivo hosts:
echo.
echo          127.0.0.1       %DOMAIN%
echo.
echo          Se abrira el Bloc de notas con el archivo hosts.
echo          Agrega la linea al final, guarda con Ctrl+S y cierra.
echo.
echo          Presiona una tecla para abrir el archivo...
pause >nul
notepad.exe "%HOSTS_FILE%"
echo.
echo          Verificando...
findstr /C:"%DOMAIN%" "%HOSTS_FILE%" >nul 2>&1
if %errorlevel% equ 0 (
    echo          Entrada para %DOMAIN% detectada. OK!
) else (
    echo          [AVISO] No se detecto la entrada. Verifica que guardaste.
)
goto hosts_done

:hosts_ok
echo          Ya existe la entrada para %DOMAIN% en hosts. OK!

:hosts_done
echo.

:: ─── 2. Configurar Virtual Host en Apache ───
echo [PASO 2/3] Configurando Virtual Host en Apache...
findstr /C:"%DOMAIN%" "%APACHE_CONF%" >nul 2>&1
if %errorlevel% equ 0 goto vhost_ok

echo.>>"%APACHE_CONF%"
echo ## CDI Matriculas - Host Virtual>>"%APACHE_CONF%"
echo ^<VirtualHost *:80^>>>"%APACHE_CONF%"
echo     ServerName %DOMAIN%>>"%APACHE_CONF%"
echo     DocumentRoot "%PROJECT_PATH%">>"%APACHE_CONF%"
echo     ^<Directory "%PROJECT_PATH%"^>>>"%APACHE_CONF%"
echo         Options Indexes FollowSymLinks MultiViews>>"%APACHE_CONF%"
echo         AllowOverride All>>"%APACHE_CONF%"
echo         Require all granted>>"%APACHE_CONF%"
echo     ^</Directory^>>>"%APACHE_CONF%"
echo     ErrorLog "logs/cdimatriculas-error.log">>"%APACHE_CONF%"
echo     CustomLog "logs/cdimatriculas-access.log" common>>"%APACHE_CONF%"
echo ^</VirtualHost^>>>"%APACHE_CONF%"
echo          VirtualHost creado para %DOMAIN%. OK!
goto vhost_done

:vhost_ok
echo          Ya existe el VirtualHost para %DOMAIN%. OK!

:vhost_done
echo.

:: ─── 3. Reiniciar Apache ───
echo [PASO 3/3] Reiniciando Apache...
cd /d C:\xampp
apache_stop.bat >nul 2>&1
timeout /t 2 /nobreak >nul
apache_start.bat >nul 2>&1
echo          Apache reiniciado. Si no funciona, reinicia desde el panel XAMPP.
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
echo ============================================================
pause
