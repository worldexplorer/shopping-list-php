#!/bin/sh

apt install php-pgsql
apt install php-xdebug


apt install libapache2-mod-php
a2enmod php8.0
apache2ctl restart

cp sites-available/8000-shli.conf /etc/apache2/sites-available/
a2ensite 8000-shli
apache2ctl restart

chmod o+x ~user

tail -n 0 -f /var/log/apache2/8000-shli-error.log &
tail -n 0 -f /var/log/apache2/8000-shli-access.log &

su user firefox http://localhost:8000/_lib/_info.php &
su user firefox http://localhost:8000/backoffice/ &
