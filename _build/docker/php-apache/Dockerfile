FROM php:8.1.2-apache

LABEL traefik.enable="true"
LABEL traefik.port=80
LABEL traefik.http.routers.yukinator.rule="Host(`yukinator.localhost`)"
LABEL traefik.http.routers.yukinator.entrypoints="websecure"
LABEL traefik.http.routers.yukinator.tls.certresolver="myresolver"

COPY _build/docker/php-apache/php.ini /usr/local/etc/php/conf.d/app_php.ini
COPY _build/docker/php-apache/apache.conf /etc/apache2/sites-available/docker.conf
COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN apt-get update && apt-get install -y git wget
RUN docker-php-ext-install pdo_mysql
RUN apt-get install -y \
        libzip-dev \
        zip npm \
  && docker-php-ext-install zip

# Symfony CLI
RUN wget https://get.symfony.com/cli/installer -O - | bash

RUN export PATH="$HOME/.symfony5/bin:$PATH"
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

RUN a2enmod rewrite &&\
    a2dissite 000-default &&\
    a2ensite docker &&\
    service apache2 restart \

COPY . /var/www/html
RUN rm -rf _build
WORKDIR /var/www/html

EXPOSE 80
