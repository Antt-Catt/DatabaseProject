FROM php:apache
RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql
COPY *.php /var/www/html/
COPY *.css /var/www/html/