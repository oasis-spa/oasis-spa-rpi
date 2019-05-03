FROM aaronbronow/oasis-base:latest

ENV DEBIAN_FRONTEND "noninteractive"
ENV APP_PASS "raspberry"
ENV ROOT_PASS "oasis"
ENV APP_DB_PASS "raspberry"

RUN apt-get -yq --no-install-recommends install wiringpi

VOLUME /var/lib/mysql
COPY docker/entrypoint.sh /
ENTRYPOINT ["/entrypoint.sh"]
# EXPOSE 80 8000
# EXPOSE 3306 33060

COPY . .
RUN chown -R :www-data .
RUN chmod -R 755 .

