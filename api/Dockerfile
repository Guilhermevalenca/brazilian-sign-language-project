FROM php:8.4-apache

RUN apt-get update -y && apt-get install -y openssl zip unzip git

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

COPY . /var/www/html/

COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

RUN composer install

RUN php artisan key:generate
RUN php artisan optimize

RUN a2enmod rewrite

EXPOSE 80

CMD ["apache2-foreground"]
