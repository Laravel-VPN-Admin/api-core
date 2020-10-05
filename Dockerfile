FROM php:7.4-apache

ENV DB_CONNECTION=mysql
ENV DB_HOST=mariadb
ENV DB_PORT=3306
ENV DB_DATABASE=vpnadmin
ENV DB_USERNAME=vpnadmin_user
ENV DB_PASSWORD=vpnadmin_pass

# Install tools required for build stage
RUN apt-get update \
 && apt-get install -fyqq \
    bash curl wget rsync ca-certificates openssl openssh-client git tzdata \
    libxrender1 fontconfig libc6 \
    gnupg binutils-gold autoconf nodejs npm \
    g++ gcc gnupg libgcc1 linux-headers-amd64 make python

# Install additional PHP libraries
RUN docker-php-ext-install \
    pcntl \
    bcmath \
    sockets

# Install mbstring plugin
RUN apt-get update \
 && apt-get install -fyqq libonig5 libonig-dev \
 && docker-php-ext-install mbstring \
 && apt-get remove -fyqq libonig-dev

# Install mysql plugin
RUN apt-get update \
 && apt-get install -fyqq mariadb-client libmariadbclient-dev \
 && docker-php-ext-install pdo_mysql mysqli \
 && apt-get remove -fyqq libmariadbclient-dev

# Install pgsql plugin
RUN apt-get update \
 && apt-get install -fyqq postgresql-client libpq-dev \
 && docker-php-ext-install pdo_pgsql pgsql \
 && apt-get remove -fyqq libpq-dev

# Install internalization plugin
RUN apt-get update \
 && apt-get install -fyqq libicu63 libicu-dev \
 && docker-php-ext-install intl \
 && apt-get remove -fyqq libicu-dev

# Install libraries for compiling GD, then build it
RUN apt-get update \
 && apt-get install -fyqq libfreetype6 libfreetype6-dev libpng16-16 libpng-dev libjpeg62-turbo libjpeg62-turbo-dev \
 && docker-php-ext-install gd \
 && apt-get remove -fyqq libfreetype6-dev libpng-dev libjpeg62-turbo-dev

# Add ZIP archives support (not needed here)
RUN apt-get update \
 && apt-get install -fyqq zip libzip-dev \
 && docker-php-ext-install zip \
 && apt-get remove -fyqq libzip-dev

# Install memcache
RUN apt-get update \
 && apt-get install -fyqq libmemcached11 libmemcached-dev \
 && pecl install memcached \
 && docker-php-ext-enable memcached \
 && apt-get remove -fyqq libmemcached-dev

# Install redis ext
RUN pecl install redis \
 && docker-php-ext-enable redis

# Install xdebug
RUN pecl install xdebug

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer \
 && chmod 755 /usr/bin/composer

# Add apache to run and configure
RUN a2enmod rewrite && a2enmod session && a2enmod session_cookie && a2enmod session_crypto && a2enmod deflate
ADD apache.conf /etc/apache2/sites-available/000-default.conf

RUN mkdir -pv /app \
 && chown -R www-data:www-data /app \
 && chmod -R 755 /app

WORKDIR /app

ENV LARAVEL_TAG="7.28.0"
ENV LARAVEL_TARGZ="https://api.github.com/repos/laravel/laravel/tarball"

ADD . /app

RUN set -xe \
 && npm install \
 && npm run production

RUN set -xe \
 && cp .env.example .env \
 && chown www-data:www-data -R bootstrap \
 && chown www-data:www-data -R storage \
 && composer -V \
 && composer install --no-dev \
 && php artisan optimize:clear \
 && php artisan lang:js \
 && php artisan key:generate --force

EXPOSE 80
EXPOSE 443

ENTRYPOINT ["/app/entrypoint.sh"]
