# PHP
FROM php:7.4-apache

# Modules apache
RUN a2enmod headers deflate expires rewrite
EXPOSE 80

# Composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# git, unzip & zip are for composer
RUN apt-get update -qq && \
    apt-get install -qy \
    git \
    gnupg \
    unzip \
    zip && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# PHP Extensions
RUN docker-php-ext-install -j$(nproc) opcache pdo_mysql

#Install NodeJS
RUN curl -sL https://deb.nodesource.com/setup_lts.x | bash -
RUN apt-get update \
 && apt-get install -y \
 nodejs

# Virtualhost
# COPY conf/vhost.conf /etc/apache2/sites-enabled/docker-vhost.conf

# Redémarrage de Apache pour tenir compte des modifications + modules installés
# RUN service apache2 restart

# COPY . /var/www/html/

# Dossier de travail
WORKDIR /var/www/html

RUN git clone https://github.com/arthurquoise/vide-grenier .

RUN git chekout release

RUN composer install

RUN npm install

