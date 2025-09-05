FROM php:8.2-apache

# PostgreSQLクライアントライブラリをインストール
RUN apt-get update && apt-get install -y libpq-dev libzip-dev unzip libonig-dev

# PHPのPostgreSQL拡張機能をインストール
RUN docker-php-ext-install mbstring pdo pdo_pgsql zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY ./src /var/www/html
