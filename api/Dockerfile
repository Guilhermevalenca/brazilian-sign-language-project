# Estágio de construção (build)
FROM composer:2.6 AS builder

WORKDIR /app

# Copiar os arquivos do composer para instalar as dependências
COPY composer.json composer.lock ./

# Instalar dependências (sem as dependências de desenvolvimento)
RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist \
    --no-dev

# Copiar todo o código fonte
COPY . .

# Gerar o autoloader e otimizar
RUN composer dump-autoload --optimize

# Estágio de produção
FROM php:8.2-fpm-alpine

WORKDIR /var/www/html

# Instalar dependências do sistema
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

# Configurar o supervisor
RUN mkdir -p /etc/supervisor/conf.d
COPY docker/supervisor.conf /etc/supervisor/conf.d/supervisor.conf

# Configurar o Nginx
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/laravel.conf /etc/nginx/conf.d/default.conf

# Copiar os arquivos do estágio de construção
COPY --from=builder /app .

# Configurar permissões
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Copiar scripts de inicialização
COPY docker/start.sh /usr/local/bin/start
RUN chmod +x /usr/local/bin/start

# Expor as portas necessárias
EXPOSE 80 443

# Comando de inicialização
CMD ["/usr/local/bin/start"]