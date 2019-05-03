#!/bin/bash
set -e
service apache2 start
service mysql start

if [ "$1" = 'init' ]; then
  echo "Starting oasis controller"
  if [ ! "$(mysql -e 'use controller')" ]; then
    echo "DB doesn't exist. Creating database..."
    mysql -e 'create database controller'
    mysql -e "GRANT ALL PRIVILEGES ON *.* TO 'oasis'@'localhost' IDENTIFIED BY 'raspberry';"
    echo "Running schema.sql..."
    mysql controller < /var/www/html/db/schema.sql
    echo "Running seed.sql..."
    mysql controller < /var/www/html/db/seed.sql
  else
    echo "WARNING: DB controller already exists. Drop it before running init."
  fi
  echo "Init complete. Restart the container with the start command."
elif [ "$1" = 'start' ]; then
  echo "Starting oasis controller"
  echo "Started"
  trap : TERM INT; sleep infinity & wait
else
  exec "$@"
fi
