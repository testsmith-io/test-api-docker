FROM php:7.2-fpm

#RUN apt-get update && apt-get install -y zip unzip git libmcrypt-dev mysql-client\
#    && docker-php-ext-install mysqli\
#    && docker-php-ext-enable mysqli

RUN apt-get update
RUN apt-get upgrade -y
RUN docker-php-ext-install pdo pdo_mysql mysqli

RUN curl https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# RUN chown -R www-data:www-data /var/www
# RUN chmod 777 -R /var/www/html/storage

WORKDIR /var/www