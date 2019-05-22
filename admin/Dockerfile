FROM php:7.2-fpm-alpine

WORKDIR /var/www/admin

RUN apk add --update --no-cache --virtual .build_deps autoconf g++ make \
    libxml2-dev icu-dev \
    && docker-php-source extract \
    && pecl channel-update pecl.php.net \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && docker-php-source delete \
    && docker-php-ext-install pdo_mysql soap intl zip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && apk del .build_deps \
    && apk add icu-libs

COPY . .
RUN composer install

EXPOSE 9000
CMD ["php-fpm", "-F"]
