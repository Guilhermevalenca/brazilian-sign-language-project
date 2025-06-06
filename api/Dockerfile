# Estágio de construção (build)
FROM composer:2.6 AS builder

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist \
    --no-dev

COPY . .

RUN composer dump-autoload --optimize

FROM php:8.2-fpm-alpine

WORKDIR /var/www/html

RUN apk add --no-cache \
    nginx \
    supervisor \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    oniguruma-dev \
    postgresql-dev \
    && docker-php-ext-install \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    bcmath \
    mbstring \
    zip \
    gd

RUN mkdir -p /etc/supervisor/conf.d
COPY docker/supervisor.conf /etc/supervisor/conf.d/supervisor.conf

COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/laravel.conf /etc/nginx/conf.d/default.conf

COPY --from=builder /app .

COPY docker/start.sh /usr/local/bin/start
RUN chmod +x /usr/local/bin/start
RUN chmod 777 -R storage/app/public

RUN echo "upload_max_filesize = 1000M" >> /usr/local/etc/php/conf.d/uploads.ini && \
    echo "post_max_size = 10000M" >> /usr/local/etc/php/conf.d/uploads.ini

VOLUME [ "/var/www/html/storage" ]

EXPOSE 80/tcp
EXPOSE 80/udp

CMD ["/usr/local/bin/start"]
