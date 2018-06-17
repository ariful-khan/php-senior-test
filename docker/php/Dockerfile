FROM php:7.1-fpm

USER root

# Allow Composer to be run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libmcrypt-dev \
    libjpeg-dev \
    libpng-dev \
    libgmp-dev \
    libpq-dev && \
docker-php-ext-install  gd \
    mbstring \
    mcrypt \
    zip \
    gmp && \
pecl install xdebug-2.6.0 \
	&& docker-php-ext-enable xdebug && \
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www
