FROM fabioassuncao/php:8.1-nginx

LABEL maintainer="Fábio Assunção fabio@codions.com"

ENV APP_ENV=production \
    APP_PATH=/var/www/html \
    APP_STORAGE=/var/www/html/storage \
    APP_SCRIPTS=/usr/deploy/scripts \
    ENABLE_SCHEDULE=false \
    ENABLE_WORKER=false \
    ENABLE_HORIZON=false \
    ENABLE_WEBSOCKETS=false \
    SCHEDULE_CONF=/etc/supervisor.d/schedule.conf \
    WORKER_CONF=/etc/supervisor.d/worker.conf \
    HORIZON_CONF=/etc/supervisor.d/horizon.conf \
    WEBSOCKETS_CONF=/etc/supervisor.d/websockets.conf

WORKDIR $APP_PATH

# Supervisor config
COPY docker/supervisor.d/* /etc/supervisor.d/

# Override nginx's default config
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# Copy existing application directory
COPY docker/php /usr/deploy/php
COPY docker/scripts $APP_SCRIPTS

COPY . /var/www/html/
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf

RUN chmod +x $APP_SCRIPTS/entrypoint && \
    chmod +x $APP_SCRIPTS/start && \
    chmod +x $APP_SCRIPTS/schedule

RUN composer install --ignore-platform-reqs --no-scripts --working-dir=$APP_PATH

VOLUME ["$APP_STORAGE"]

# Expose webserver port
EXPOSE 80 6001 9001

# Set a custom entrypoint to allow for privilege dropping and one-off commands
ENTRYPOINT ["/usr/deploy/scripts/entrypoint"]

# Set default command to launch the all-in-one configuration supervised by supervisord
CMD ["/usr/deploy/scripts/start"]
