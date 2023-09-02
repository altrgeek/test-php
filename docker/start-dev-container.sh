#!/usr/bin/env bash

if [ ! -d /.composer ]; then
    mkdir /.composer
fi

chmod -R ugo+rw /.composer

# Install yarn dependencies
yarn install --pure-lockfile

# Install composer dependencies
composer install

# Link storage
php artisan storage:link

# Start the supervisor
/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
