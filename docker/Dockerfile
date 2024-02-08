FROM php:8.3-fpm-alpine

# Arguments defined in docker-compose.yml
ENV USER=docker
ENV UID=1000

RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Install Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Install unzip utility and libs needed by zip PHP extension
RUN apk --update add wget \
      grep \
      build-base \
      libmemcached-dev \
      libmcrypt-dev \
      libxml2-dev \
      pcre-dev \
      libtool \
      autoconf \
      libzip-dev \
      unzip \
      supervisor

RUN apk --update add wget \
      libpng-dev

RUN docker-php-ext-install zip

RUN docker-php-ext-configure pcntl --enable-pcntl \
  && docker-php-ext-install  \
    pcntl

# Instsll nodejs && npm
RUN apk add --update nodejs npm

# Install redis
RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

RUN rm /var/cache/apk/* && \
    mkdir -p /var/www

# Create system user to run Composer and Artisan Commands
RUN addgroup -g $UID -S $USER \
    && adduser -u $UID -S $USER -G $USER

USER $USER
