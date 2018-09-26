FROM php:7
MAINTAINER Sam Li
RUN apt-get update -y && apt-get install -y openssl zip unzip git
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo mbstring
WORKDIR /app
COPY . /app
RUN composer install
ENV MYSQL_HOST=192.168.1.1
ENV MYSQL_AC=root
ENV MYSQL_PW=default
CMD chmod +x docker-point.sh && ./docker-point.sh
EXPOSE 8181