FROM php:apache
RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql
COPY test.php /var/www/html/