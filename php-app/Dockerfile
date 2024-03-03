FROM php:8.0-apache
RUN apt-get update

WORKDIR /var/www/html
COPY src/. .

RUN apt-get update && \
    apt-get install -y libxml2-dev
RUN docker-php-ext-install soap

# Source: https://gist.github.com/jdecode/77b554ba217c5dfcf5f78f89260c8561
#Install pgsql dev support
RUN apt-get install libpq-dev -y
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && docker-php-ext-install pdo_pgsql pgsql
RUN a2enmod rewrite

EXPOSE 80