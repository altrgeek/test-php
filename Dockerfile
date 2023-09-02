FROM composer:latest as build
WORKDIR /app
COPY composer.json composer.lock helpers ./
RUN composer install --no-progress --optimize-autoloader --quiet \
    --no-interaction --no-scripts
COPY . .
RUN php artisan package:discover --ansi \
    && php artisan view:cache \
    && php artisan event:cache

# Install node dependencies and build for production
FROM node:lts-alpine as assets
WORKDIR /app
COPY --from=build /app/package.json /app/yarn.lock ./
RUN yarn install --non-interactive --emoji true
COPY --from=build /app .
RUN yarn run build

FROM ubuntu:20.04

ENV DEBIAN_FRONTEND noninteractive
ENV COMPOSER_ALLOW_SUPERUSER=1

# Install required packages
RUN apt-get update && apt-get upgrade -y && apt-get install -y curl cron \
    ca-certificates software-properties-common supervisor libcap2-bin \
    libpng-dev libonig-dev libxml2-dev openssl libbz2-dev zlib1g-dev \
    libzip-dev libcurl4-openssl-dev libssl-dev zip unzip

# Add PPA respository for installing PHP 8.1
RUN add-apt-repository ppa:ondrej/php -y && apt-get update

# Install required PHP 8.1 packages and Apache compaitble modules
RUN apt-get --fix-missing install -y php8.1 php8.1-common php8.1-cli \
    php-phpseclib php8.1-bcmath php8.1-bz2 php8.1-curl php8.1-decimal \
    php8.1-gd php8.1-gmp php8.1-igbinary php8.1-imap php8.1-intl php8.1-ldap \
    php8.1-mbstring php8.1-mcrypt php8.1-msgpack php8.1-mysql php8.1-opcache \
    php8.1-pcov php8.1-redis php8.1-soap php8.1-ssh2 php8.1-vips php8.1-xml \
    php8.1-xmlrpc php8.1-xsl php8.1-zip

# Copy necessary scripts and configurations in appropriate locations
COPY docker/scheduler /etc/cron.d/scheduler
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/start-container.sh /usr/local/bin/start-container

# Set appropriate permissions for copied scripts and configuration files
RUN chmod 0644 /etc/cron.d/scheduler \
    && crontab /etc/cron.d/scheduler \
    && chmod +x /etc/supervisor/conf.d/supervisord.conf \
    && chmod +x /usr/local/bin/start-container

# Copy our built application files
COPY --from=assets /app /var/www

RUN cp /var/www/.env.example /var/www.env \
    && /usr/bin/php /var/www/artisan storage:link --force

# Remove unnecessary packages to reduce image size
RUN apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

WORKDIR /var/www

EXPOSE 80

CMD [ "start-container" ]
