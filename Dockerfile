FROM php:7.1-fpm

RUN  pecl install xdebug && \
     docker-php-ext-enable xdebug


WORKDIR /var/www/app

ENTRYPOINT ["./bin/generator.php"]