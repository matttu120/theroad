#!/bin/bash
#clear
rm ../._*
rm ._*
rm */._*
rm */*/._*
rm */*/*/._*

echo AddType application/x-httpd-php-cgi .php > .htaccess
echo Action application/x-httpd-php-cgi /~AddYourNameHere/cgi-bin/php-cgi.cgi >> .htaccess

echo "Changing Permissions..."
chmod -R 755 ./*
chmod 755 ./
chmod 644 ./.htaccess
chmod 700 ./config
chmod 700 ./upload


echo "Process Completed"
