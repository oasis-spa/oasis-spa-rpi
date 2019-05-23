#!/bin/bash
set -e
service syslog-ng start
service apache2 start

init () {
  echo "Setting up oasis controller"
  chown -R :www-data /var/www/html
  chmod -R g+wx /var/www/html
  /bin/su -c "cd /var/www/html && php composer.phar --no-dev install" www-data
  waitfordb
  if [[ -n $(mysql -h $DB_HOST -u root --password=$MYSQL_ROOT_PASSWORD -e "use ${MYSQL_DATABASE}") ]]; then
    echo "DB $MYSQL_DATABASE doesn't exist. Creating database..."
    mysql -h $DB_HOST -u root --password=$MYSQL_ROOT_PASSWORD -e "create database $MYSQL_DATABASE"
  else
    echo "DB $MYSQL_DATABASE exists"
  fi

  COUNT=$(mysql -h $DB_HOST -u root --password=$MYSQL_ROOT_PASSWORD $MYSQL_DATABASE -sse \
    "select count(*) from information_schema.tables where table_schema='${MYSQL_DATABASE}' and table_name='users';")
  
  if [[ ! $COUNT -eq 1 ]]; then
    echo "Schema not loaded. Loading..."
    mysql -h $DB_HOST -u root --password=$MYSQL_ROOT_PASSWORD -e "GRANT ALL PRIVILEGES ON *.* TO '$MYSQL_USER'@'%' IDENTIFIED BY '$MYSQL_PASSWORD';"
    echo "Running schema.sql..."
    mysql -h $DB_HOST -u $MYSQL_USER --password=$MYSQL_PASSWORD $MYSQL_DATABASE < /var/www/html/db/schema.sql
    echo "Running seed.sql..."
    mysql -h $DB_HOST -u $MYSQL_USER --password=$MYSQL_PASSWORD $MYSQL_DATABASE < /var/www/html/db/seed.sql
  else
    echo "DB $MYSQL_DATABASE schema present"
  fi
}

start () {
  echo "Starting oasis controller"
  syslog-ng-ctl reload
  waitfordb
  echo "Started"
  tail -f /var/log/syslog
}

waitfordb () {
  until mysql -h $DB_HOST -u $MYSQL_USER --password=$MYSQL_PASSWORD -e "show databases;"; do
    echo "MySQL is unavailable - sleeping..."
    sleep 1
  done
}

case "$1" in
init)
  init
  ;;
start)
  start
  ;;
initstart)
  init
  start
  ;;
*)
  exec "$@"
esac
