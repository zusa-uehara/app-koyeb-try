FROM php:8.2-apache

# PostgreSQLクライアントライブラリをインストール
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && rm -rf /var/lib/apt/lists/*

COPY . /var/www/html

# PostgreSQLに接続するためのpdo_pgsql拡張機能をインストール
RUN docker-php-ext-install pdo pdo_pgsql
