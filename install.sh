#!/bin/bash

clear

echo "Start install project"

sudo composer update

php app/console doctrine:database:create
php app/console doctrine:schema:update --force
php app/console hautelook_alice:fixtures:load

cd web-src

npm install
bower install
gulp