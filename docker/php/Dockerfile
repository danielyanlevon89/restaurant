FROM php:8.1.0-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    nano \
    telnet \
    unzip \
    sudo \
    nodejs \
    npm \
    vite

RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd
#RUN apt-get update && apt-get install -y \
#        libfreetype6-dev \
#        libjpeg62-turbo-dev \
#        libmcrypt-dev \
#        libpng-dev \
#        libicu-dev \
#        libpq-dev \
#        libxpm-dev \
#        libvpx-dev \
#        pgsql \
#        pdo_pgsql \
#    && pecl install xdebug \
#    && docker-php-ext-enable xdebug \
#    && docker-php-ext-install -j$(nproc) mcrypt \
#    && docker-php-ext-install -j$(nproc) gd \
#    && docker-php-ext-install -j$(nproc) intl \
#    && docker-php-ext-install -j$(nproc) zip \
#    && docker-php-ext-install -j$(nproc) pgsql \
#    && docker-php-ext-install -j$(nproc) pdo_pgsql \
#    && docker-php-ext-install -j$(nproc) exif \
#    && docker-php-ext-configure gd \
#        --with-freetype-dir=/usr/include/ \
#        --with-jpeg-dir=/usr/include/ \
#        --with-xpm-dir=/usr/lib/x86_64-linux-gnu/ \
#        --with-vpx-dir=/usr/lib/x86_64-linux-gnu/ \


# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions

RUN docker-php-ext-install mbstring exif pcntl bcmath gd


#RUN docker-php-source extract \
#    && docker-php-ext-install bcmath mbstring pdo_pgsql soap sockets zip exif pcntl bcmath gd \
#    && pecl install xdebug \
#    && docker-php-ext-enable xdebug \
#    && docker-php-source delete

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer




# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

RUN composer self-update

# Set working directory
WORKDIR /var/www

COPY . .
# INSTALL YOUR DEPENDENCIES
RUN composer install  --ignore-platform-req=ext-zip

USER $user
