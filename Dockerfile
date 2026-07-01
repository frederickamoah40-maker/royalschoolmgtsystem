FROM php:8.2-cli

RUN apt-get update && apt-get install -y --no-install-recommends \
    libsqlite3-dev sqlite3 \
    && docker-php-ext-install pdo_sqlite \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html
COPY . /var/www/html

EXPOSE 10000

CMD ["sh", "-c", "php -S 0.0.0.0:${PORT:-10000} -t /var/www/html"]
