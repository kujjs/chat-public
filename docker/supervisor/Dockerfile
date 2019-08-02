FROM php:7-alpine

ENV SUPERVISOR_CONF_DIR=/etc/supervisor.d
ENV SUPERVISOR_CONF_FILE=/etc/supervisord.conf

RUN apk add --update --no-cache supervisor

RUN mkdir -p $SUPERVISOR_CONF_DIR
RUN mkdir -p /var/log/supervisor


VOLUME $SUPERVISOR_CONF_DIR

#EXPOSE 6001

ENTRYPOINT supervisord -n -c $SUPERVISOR_CONF_FILE

