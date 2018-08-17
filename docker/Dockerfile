FROM phpearth/php:7.2-nginx

RUN apk update && apk add libmcrypt-dev php7.2-pdo php7.2-pdo_mysql php7.2-gd bash git
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer
