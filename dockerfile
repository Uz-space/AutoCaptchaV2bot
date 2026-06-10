FROM php:8.2-cli-bullseye

WORKDIR /app

# Kerakli paketlarni o'rnatish
RUN apt-get update && apt-get install -y \
    libcurl4-openssl-dev \
    && docker-php-ext-install curl json \
    && apt-get clean

# Bot faylini ko'chirish
COPY bot.php /app/bot.php

# Papka yaratish va ruxsatlar
RUN mkdir -p /app/users_config && chmod 777 /app/users_config

# Botni ishga tushirish
CMD ["php", "/app/bot.php"]
