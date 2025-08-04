# Используем официальный образ PHP 8.4-FPM
FROM php:8.4-fpm

# Обновление пакетов и установка зависимостей
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libgd-dev \
    default-mysql-client \ 
    && rm -rf /var/lib/apt/lists/*

# Настройка GD с поддержкой JPEG и FreeType
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# Установка расширений PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Установка рабочей директории
WORKDIR /var/www

# Копирование файлов проекта
COPY . /var/www

# Изменение прав владельца на www-data
RUN chown -R www-data:www-data /var/www

# Переключение на пользователя www-data
USER www-data

# Экспонирование порта 9000 для php-fpm
EXPOSE 9000

# Запуск php-fpm
CMD ["php-fpm"]