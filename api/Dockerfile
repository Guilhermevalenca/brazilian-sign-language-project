FROM php:8.4

RUN apt-get update -y && apt-get install -y openssl zip unzip git

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# RUN docker-php-ext-install pdo mbstring

WORKDIR /app
COPY . /app

RUN composer install

RUN chmod -R 777 /app

RUN php artisan key:generate

RUN php artisan migrate --seed

RUN php artisan optimize:clear

RUN php artisan optimize

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
EXPOSE 8000