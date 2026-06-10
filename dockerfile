
FROM php:8.2-cli

WORKDIR /app

# Curl extensionini o'rnatish
RUN docker-php-ext-install curl json

# Bot faylini ko'chirish
COPY bot.php /app/bot.php

# Papka yaratish
RUN mkdir -p /app/users_config && chmod 777 /app/users_config

# Botni ishga tushirish
CMD ["php", "/app/bot.php"]
