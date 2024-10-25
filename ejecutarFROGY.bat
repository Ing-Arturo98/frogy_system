@echo off
setlocal

rem Cambia la URL a la dirección que deseas abrir
set "url=http://localhost/frogy_system/index.php"

rem Detectar el navegador predeterminado en Windows
set "browser="
for /f "tokens=2 delims= " %%I in ('reg query "HKEY_CLASSES_ROOT\http\shell\open\command" ^| find /i "chrome.exe"') do set "browser=chrome"
for /f "tokens=2 delims= " %%I in ('reg query "HKEY_CLASSES_ROOT\http\shell\open\command" ^| find /i "firefox.exe"') do set "browser=firefox"
for /f "tokens=2 delims= " %%I in ('reg query "HKEY_CLASSES_ROOT\http\shell\open\command" ^| find /i "iexplore.exe"') do set "browser=iexplore"
if not defined browser (
    echo No se pudo detectar un navegador predeterminado.
    pause
    exit /b
)

rem Abrir la URL en el navegador predeterminado
start "" %browser% %url%

endlocal