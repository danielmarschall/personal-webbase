@echo off

echo Order Deny,Allow > .htaccess
echo Deny from all >> .htaccess

ren index.htm_ index.html
