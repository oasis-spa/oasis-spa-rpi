#!/bin/bash
set -e
service syslog-ng start
service apache2 start

if [[ "$1" = 'init' ]]; then
  echo "Setting up oasis controller"
  if [[ ! "$(mysql -h $DB_HOST -u $MYSQL_USER -p $MYSQL_PASSWORD -e 'use $MYSQL_DATABASE')" ]]; then
    echo "DB doesn't exist. Creating database..."
    mysql -e "create database $MYSQL_DATABASE"
    mysql -e "GRANT ALL PRIVILEGES ON *.* TO '$MYSQL_USER'@'%' IDENTIFIED BY '$MYSQL_PASSWORD';"
    echo "Running schema.sql..."
    mysql -h $DB_HOST -u $MYSQL_USER -p $MYSQL_PASSWORD $MYSQL_DATABASE < /var/www/html/db/schema.sql
    echo "Running seed.sql..."
    mysql -h $DB_HOST -u $MYSQL_USER -p $MYSQL_PASSWORD $MYSQL_DATABASE < /var/www/html/db/seed.sql
  else
    echo "WARNING: DB $MYSQL_DATABASE already exists. Drop it before running init."
  fi
  echo "Init complete. Restart the container with the start command."
elif [[ "$1" = 'start' ]]; then
  echo "Starting oasis controller"
  syslog-ng-ctl reload
  echo "Started"
  tail -f /var/log/syslog
  # trap : TERM INT; sleep infinity & wait
else
  exec "$@"
fi
