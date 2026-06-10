FROM php:8.3-cli

WORKDIR /app

# Curl va json extensionlarini o'rnatish
RUN docker-php-ext-install curl json

# Bot fayllarini ko'chirish
COPY bot.php .
COPY railway.json .

# Papka yaratish
RUN mkdir -p users_config && chmod 777 users_config

# Botni ishga tushirish
CMD ["php", "bot.php"]
