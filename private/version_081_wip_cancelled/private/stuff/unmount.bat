@echo off

echo WARNUNG!
echo.
echo Dieses Script h„ngt die Drittanbietersysteme sowie die Konfiguration
echo von Personal WebBase aus bzw. wieder ein. Durch das Aushaengen k”nnen Sie
echo Ihr Personal WebBase System schneller aktualisieren (dabei werden die Dritt-
echo anbietermodule wie z.B. phpMyAdmin nicht aktualisiert).
echo.
echo Sie sollten nur fortfahren, wenn Sie wissen, was Sie tun.
echo Schlieáen Sie ansonsten das Fenster wieder.
echo.
pause

IF EXIST unmounted GOTO ein
GOTO aus

:ein

rmdir /S /Q ..\modules\user_phpmyadmin\system\
mkdir ..\modules\user_phpmyadmin\system\
xcopy unmounted\pma modules\user_phpmyadmin\system\ /E /V /C /I /H
rmdir /S /Q unmounted\pma

rmdir /S /Q ..\modules\user_popper\system\
mkdir ..\modules\user_popper\system\
xcopy unmounted\popper modules\user_popper\system\ /E /V /C /I /H
rmdir /S /Q unmounted\popper

rmdir /S /Q ..\modules\user_net2ftp\system\
mkdir ..\modules\user_net2ftp\system\
xcopy unmounted\net2ftp modules\user_net2ftp\system\ /E /V /C /I /H
rmdir /S /Q unmounted\net2ftp

del ..\includes\config.inc.php
move unmounted\config.inc.php ..\includes\

rmdir /S /Q unmounted\

GOTO end

:aus

mkdir unmounted\

rmdir /S /Q unmounted\pma\
mkdir unmounted\pma\
xcopy ..\modules\user_phpmyadmin\system unmounted\pma\ /E /V /C /I /H
rmdir /S /Q ..\modules\user_phpmyadmin\system

rmdir /S /Q unmounted\popper\
mkdir unmounted\popper\
xcopy ..\modules\user_popper\system unmounted\popper\ /E /V /C /I /H
rmdir /S /Q ..\modules\user_popper\system

rmdir /S /Q unmounted\net2ftp\
mkdir unmounted\net2ftp\
xcopy ..\modules\user_net2ftp\system unmounted\net2ftp\ /E /V /C /I /H
rmdir /S /Q ..\modules\user_net2ftp\system

move ..\includes\config.inc.php unmounted\

:end

cls
