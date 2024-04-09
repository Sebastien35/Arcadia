FROM php:8.2.12
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions intl && \
    install-php-extensions mongodb && \
    curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
    mv composer.phar /usr/local/bin/composer && \
    apt update && apt install -yqq zip git

COPY . /var/www
COPY ./docker/apache.conf /etc/apache2/sites-available/000-default.conf
ENV APP_ENV=prod
RUN rm -rf /var/www/vendor && \
    rm -rf /var/www/.git && \
    rm -rf /var/www/.env.local && \
    cd /var/www && \
    composer install && \
    php bin/console cache:clear && \
    php bin/console cache:warmup && \
    chown -R www-data:www-data /var/www

WORKDIR /var/www
ENTRYPOINT ["bash", "./docker/docker.sh"]
EXPOSE 80