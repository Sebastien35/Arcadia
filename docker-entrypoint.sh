#!/bin/sh

# Wait for MySQL to be ready
while ! mysqladmin ping -hmysql --silent; do
    echo "Waiting for MySQL..."
    sleep 1
done

# Wait for MongoDB to be ready
until mongo --host mongo --eval "print(\"waited for connection\")"; do
    >&2 echo "MongoDB is unavailable - sleeping"
    sleep 1
done



# Start PHP-FPM
exec php-fpm
