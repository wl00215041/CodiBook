FROM cloudeasy/laravel-swoole-docker
MAINTAINER Sam Li
ENV DB_CONNECTION=mysql
ENV APP_NAME=CodiBook
ENV DB_HOST=192.168.1.1
ENV DB_PORT=3306
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
