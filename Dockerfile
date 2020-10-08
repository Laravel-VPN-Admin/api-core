FROM php:7.4-apache

# Install tools required for build stage
RUN set -xe \
 && apt-get update \
 && apt-get install -fyqq \
    bash curl wget rsync ca-certificates openssl openssh-client git tzdata \
    libxrender1 fontconfig libc6 \
    gnupg binutils-gold autoconf nodejs npm \
    g++ gcc gnupg libgcc1 linux-headers-amd64 make python \
    # Install additional PHP libraries
 && docker-php-ext-install pcntl bcmath sockets \
    # Install plugins
 && apt-get install -fyqq \
    libonig5 libonig-dev \
    mariadb-client libmariadbclient-dev \
    postgresql-client libpq-dev \
    libicu63 libicu-dev \
    libfreetype6 libfreetype6-dev libpng16-16 libpng-dev libjpeg62-turbo libjpeg62-turbo-dev \
    zip libzip-dev \
    libmemcached11 libmemcached-dev \
 && docker-php-ext-install \
    mbstring \
    pdo_mysql mysqli \
    pdo_pgsql pgsql \
    intl \
    gd \
    zip \
 && pecl install \
    memcached \
    redis \
    xdebug \
 && docker-php-ext-enable \
    memcached \
    redis \
 && apt-get remove -fyqq \
    libonig-dev \
    libmariadbclient-dev \
    libpq-dev \
    libicu-dev \
    libfreetype6-dev libpng-dev libjpeg62-turbo-dev \
    libzip-dev \
    libmemcached-dev \
    # Install composer
 && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer \
 && chmod 755 /usr/bin/composer \
    # Enable some apache modules
 && a2enmod rewrite \
 && a2enmod session \
 && a2enmod session_cookie \
 && a2enmod session_crypto \
 && a2enmod deflate

# Add apache config
ADD apache.conf /etc/apache2/sites-available/000-default.conf

# Prepare direcotory and fix permitions
RUN mkdir -pv /app \
 && chmod -R 755 /app

# Install nodejs and latest npm
RUN set -xe \
 && echo 'deb https://deb.nodesource.com/node_14.x focal main' > '/etc/apt/sources.list.d/nodesource.list' \
 && apt-key adv --keyserver keyserver.ubuntu.com --recv 1655A0AB68576280 \
 && apt-get update \
 && apt-get install nodejs -fuqq \
 && npm install -g npm@latest

ENV DB_CONNECTION=mysql
ENV DB_HOST=mariadb
ENV DB_PORT=3306
ENV DB_DATABASE=vpnadmin
ENV DB_USERNAME=vpnadmin_user
ENV DB_PASSWORD=vpnadmin_pass

WORKDIR /app
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
 && php artisan key:generate --force \
 && chown -R www-data:www-data /app

EXPOSE 80
EXPOSE 443

ENTRYPOINT ["/app/entrypoint.sh"]
