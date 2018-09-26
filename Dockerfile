FROM php:7
MAINTAINER Sam Li
RUN apt-get update -y && apt-get install -y openssl zip unzip git
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo mbstring pdo_mysql
ENV DB_HOST=192.168.1.1
ENV DB_USERNAME=root
ENV DB_PASSWORD=default
ENV DB_DATABASE=CodiBook
WORKDIR /app
COPY . /app
RUN composer install
RUN chmod +x docker-point.sh
RUN cp .env.example .env
CMD ["/app/docker-point.sh"]
EXPOSE 8181