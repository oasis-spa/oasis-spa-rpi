FROM aaronbronow/oasis-base:latest

ENV DEBIAN_FRONTEND "noninteractive"
ENV APP_PASS "raspberry"
ENV ROOT_PASS "oasis"
ENV APP_DB_PASS "raspberry"

RUN apt-get -yq --no-install-recommends install wiringpi
RUN apt-get -yq --no-install-recommends install syslog-ng


VOLUME /var/lib/mysql
COPY docker/entrypoint.sh /
ENTRYPOINT ["/entrypoint.sh"]
# EXPOSE 80 8000
# EXPOSE 3306 33060

COPY . .
RUN chown -R www-data: /var/www
RUN chmod -R 755 /var/www

RUN config/setup-syslog.sh

RUN /bin/bash -c "chsh -s /bin/bash www-data"
RUN /bin/su -c "curl -s http://getcomposer.org/installer | php; \
  php composer.phar require vlucas/phpdotenv" www-data

