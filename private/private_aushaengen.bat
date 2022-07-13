@echo off

cd /d %~dp0
cd ..

echo WARNUNG!
echo.
echo Dieses Script h„ngt die Drittanbietersysteme sowie die Konfiguration
echo von IronBASE aus bzw. wieder ein. Durch das Aushaengen k”nnen Sie
echo Ihr IronBASE System schneller aktualisieren (dabei werden die Dritt-
echo anbietermodule wie z.B. phpMyAdmin nicht aktualisiert).
echo.
echo Sie sollten nur fortfahren, wenn Sie wissen, was Sie tun.
echo Schlieáen Sie ansonsten das Fenster wieder.
echo.
pause

IF EXIST ausgehaengt GOTO ein
GOTO aus

:ein

rmdir /S /Q modules\user_phpmyadmin\system\
mkdir modules\user_phpmyadmin\system\
xcopy ausgehaengt\pma modules\user_phpmyadmin\system\ /E /V /C /I /H
rmdir /S /Q ausgehaengt\pma

rmdir /S /Q modules\user_popper\system\
mkdir modules\user_popper\system\
xcopy ausgehaengt\popper modules\user_popper\system\ /E /V /C /I /H
rmdir /S /Q ausgehaengt\popper

rmdir /S /Q modules\user_net2ftp\system\
mkdir modules\user_net2ftp\system\
xcopy ausgehaengt\net2ftp modules\user_net2ftp\system\ /E /V /C /I /H
rmdir /S /Q ausgehaengt\net2ftp

move ausgehaengt\config.inc.php includes\

rmdir /S /Q ausgehaengt\

GOTO end

:aus

mkdir ausgehaengt\

rmdir /S /Q ausgehaengt\pma\
mkdir ausgehaengt\pma\
xcopy modules\user_phpmyadmin\system ausgehaengt\pma\ /E /V /C /I /H
rmdir /S /Q modules\user_phpmyadmin\system

rmdir /S /Q ausgehaengt\popper\
mkdir ausgehaengt\popper\
xcopy modules\user_popper\system ausgehaengt\popper\ /E /V /C /I /H
rmdir /S /Q modules\user_popper\system

rmdir /S /Q ausgehaengt\net2ftp\
mkdir ausgehaengt\net2ftp\
xcopy modules\user_net2ftp\system ausgehaengt\net2ftp\ /E /V /C /I /H
rmdir /S /Q modules\user_net2ftp\system

move includes\config.inc.php ausgehaengt\

:end

cls
