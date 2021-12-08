FROM php:fpm

RUN apt update && apt install -y nano cron && service cron start && php-fpm
