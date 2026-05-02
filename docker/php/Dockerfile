FROM php:8.3-fpm-alpine

# Dependências básicas
RUN apk add --no-cache \
    bash curl git unzip icu-dev oniguruma-dev libzip-dev \
    && docker-php-ext-install \
        pdo pdo_mysql mbstring intl zip opcache

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Usuário não-root (evita dor de cabeça com permissões)
ARG UID=1000
ARG GID=1000
RUN addgroup -g ${GID} appgroup \
 && adduser -D -G appgroup -u ${UID} appuser

USER appuser
