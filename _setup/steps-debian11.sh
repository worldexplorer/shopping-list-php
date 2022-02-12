#!/bin/sh

apt install php-pgsql
apt install php-xdebug
cp sites-available/8000-shli.conf /etc/apache2/sites-available/
cp sites-enabled/8000-shli.conf /etc/apache2/sites-enabled/
apache2ctl restart