FROM php:8.0-fpm

ARG user=www-data

RUN apt-get update && apt-get install -y git \
    zip unzip zlib1g-dev libpng-dev libzip-dev lsof \
    supervisor \
    && docker-php-ext-install pdo_mysql pcntl zip \
    && pecl install redis \
    && docker-php-ext-enable redis

ENV PATH="$PATH:/var/www/vendor/bin"
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
RUN chown $user ./

RUN usermod -u 1000 $user
RUN groupmod -g 1000 $user

USER $user

COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-interaction
COPY --chown=$user:www-data . ./
RUN composer dump-autoload

RUN chmod -R 775 /var/www/bootstrap
RUN chmod -R 775 /var/www/storage
