FROM php:7.4-apache

WORKDIR /var/www/html

COPY ./backend/ .

# Install Apache module: URL rewrite
RUN a2enmod rewrite && \
    a2enmod expires && \
    a2enmod deflate && \
    a2enmod negotiation

# Install extension
RUN apt-get update && apt-get install -y mariadb-client libzip-dev zip

# Install PHP extensions (former PECL)
RUN docker-php-ext-install pdo pdo_mysql zip

# Allow PHP process to read and write files in /var/www/html
RUN usermod -u 1000 www-data
RUN chown -R www-data:www-data /var/www/html

EXPOSE 8080
