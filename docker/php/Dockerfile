FROM php:7.1.1-fpm

RUN apt-get update \
    && apt-get -y install \
    curl \
    git \
    nano \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libpng12-dev \
    netcat \
    unzip \
    zlib1g-dev \
    supervisor \
    nodejs-legacy \
    npm \
    && pecl install apcu \
    && pecl install apcu_bc-1.0.3 \
    && apt-get clean

RUN docker-php-ext-install -j$(nproc) \
    zip \
    pdo \
    pdo_mysql \
    iconv mcrypt \
    bcmath \
    gd \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/

RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

RUN mkdir -p \
    var/cache \
    var/logs

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN mkdir -p /usr/local/bin
RUN curl -LsS https://symfony.com/installer -o /usr/local/bin/symfony
RUN chmod a+x /usr/local/bin/symfony

RUN npm install --global bower

COPY docker/php/php.ini /usr/local/etc/php/

COPY docker/php/entrypoint.sh /entrypoint.sh
ENTRYPOINT ["/bin/bash", "/entrypoint.sh"]

WORKDIR /var/www
VOLUME /var/www
EXPOSE 9000

CMD ["php-fpm"]
