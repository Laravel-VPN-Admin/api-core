#!/usr/bin/env bash

set -e

role=${CONTAINER_ROLE:-app}
env=${APP_ENV:-production}

cd /app

if [ "$role" = "app" ]; then

    echo "Caching configuration..."
    composer dump-autoload
    php artisan optimize:clear

    echo "Migrate and generate API doc..."
    php artisan migrate --force
    docker-php-entrypoint -D FOREGROUND

elif [ "$role" = "queue" ]; then

    echo "Queue role"
    php artisan queue:work --sleep=10 --tries=3 --timeout=10000

elif [ "$role" = "scheduler" ]; then

    while [ true ]
    do
      php artisan schedule:run --verbose --no-interaction &
      sleep 60
    done

else
    echo "Could not match the container role \"$role\""
    exit 1
fi
