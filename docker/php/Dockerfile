FROM php:8.1-fpm
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN apt-get update && apt-get install -y git
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions @composer-2 xdebug zip pdo_mysql intl

WORKDIR /app
