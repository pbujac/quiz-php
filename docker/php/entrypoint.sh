#!/bin/sh
set -e

if [ -z "$DISABLE_PING" -o "$DISABLE_PING" = "false" ]; then
  until nc -z -v -w90 $SYMFONY__DATABASE__HOST $SYMFONY__DATABASE__PORT
  do
    echo "Waiting for database connection..."
    sleep 5
  done
fi

composer install

bin/console doctrine:database:create --if-not-exists
bin/console doctrine:migration:migrate --no-interaction
bin/console doctrine:fixtures:load --no-interaction
bin/console assetic:dump

bower install --allow-root

chown -R www-data:www-data var/cache var/logs var/sessions

exec "$@"
