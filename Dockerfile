FROM raspbian/stretch

RUN echo "debconf debconf/frontend select noninteractive" | debconf-set-selections;

RUN apt-get -yq update
RUN apt-get -yq --no-install-recommends install \
  curl vim git-core build-essential npm apache2 \
  php php-mysql mysql-client wiringpi syslog-ng unzip

RUN /bin/bash -c "chsh -s /bin/bash www-data"
#RUN mkdir -p /var/www/html
WORKDIR /var/www/html
COPY . .
RUN chown -R www-data: /var/www
RUN chmod -R 755 /var/www

RUN config/setup-syslog.sh

RUN /bin/su -c "cd /var/www/html && curl -s http://getcomposer.org/installer | php" www-data
#RUN /bin/su -c "cd /var/www/html && php composer.phar --no-dev install" www-data
  
COPY docker/entrypoint.sh /
ENTRYPOINT ["/entrypoint.sh"]
