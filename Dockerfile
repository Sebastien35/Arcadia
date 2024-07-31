FROM php:8.2-fpm

RUN apt update && apt install -y \
    nano \
    libpng-dev \
    libjpeg-dev \
    libzip-dev \
    libfreetype6-dev \
    libonig-dev \
    libxslt1-dev \
    unzip \
    build-essential \
    git \
    nginx \
    libssl-dev \
    default-mysql-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    # && docker-php-ext-install pdo_mysql \
    # && docker-php-ext-enable pdo_mysql \
    && docker-php-ext-enable opcache \
    && docker-php-ext-install xsl \
    && docker-php-ext-install zip \
    && docker-php-ext-install intl \
    && docker-php-ext-install soap \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb

RUN docker-php-ext-install  pdo_mysql \
    && docker-php-ext-enable pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY docker/php/conf.d/* /usr/local/etc/php/conf.d/


COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# Set working directory
WORKDIR /var/www

# Copy application files
COPY . .

# Install Symfony and other PHP dependencies
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN composer install

# Debug information
RUN php -m
RUN php -r "print_r(get_loaded_extensions());"
RUN ls -la /usr/local/etc/php/conf.d/
RUN php -i | grep pdo_mysql
RUN php -r "echo ini_get('extension_dir');"

# Expose port 9000 and start PHP-FPM server
EXPOSE 9000
CMD ["php-fpm"]
