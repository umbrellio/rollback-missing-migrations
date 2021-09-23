#!/usr/bin/env bash

psql postgres -U user -tc "SELECT 1 FROM pg_database WHERE datname = 'testing'" | grep -q 1 || psql postgres -U user -c "CREATE DATABASE testing"
cd app
rm -f .env
rm -f composer.json
sed -e "s/\${USERNAME}/postgres/" \
    -e "s/\${PASSWORD}//" \
    -e "s/\${DATABASE}/testing/" \
    -e "s/\${HOST}/127.0.0.1/" \
    .env.sample > .env
sed -e "s/\${LARAVEL_VERSION}/^8.0/" \
    -e "s/\${PHP_VERSION}/7.4.16/" \
    composer.json.sample > composer.json
rm -rf release
composer create-project laravel/laravel release
rm -rf release/database/migrations
rm release/composer.json
rm release/.env
rm -rf release/tests
cp composer.json release/composer.json
cp -rf database/new_migrations release/database/migrations
cp .env release/.env
cd release && COMPOSER_MEMORY_LIMIT=-1 composer update
cd ../../ && COMPOSER_MEMORY_LIMIT=-1 composer update
composer lint-fix
sed -e "s/\${USERNAME}/postgres/" \
    -e "s/\${PASSWORD}//" \
    -e "s/\${DATABASE}/testing/" \
    -e "s/\${HOST}/127.0.0.1/" \
    phpunit.xml.dist > phpunit.xml
php -d pcov.directory='.' vendor/bin/phpunit --coverage-html build --coverage-text
