#!/bin/bash

fixuid
echo "php-fpm container has been started."

php ./artisan migrate

php-fpm