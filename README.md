<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# Laravel Swagger API Demo

Тестовое задание: Laravel REST API с аутентификацией по API ключам и документацией Swagger/OpenAPI. Демонстрирует работу с организациями, зданиями и деятельностью.

## 🚀 Возможности

- **REST API** для организаций, зданий и деятельности
- **API Key аутентификация** для безопасности
- **Swagger/OpenAPI документация** с интерактивным тестированием
- **Docker контейнеризация** для простого развертывания
- **Полная валидация** запросов
- **MySQL база данных** с готовыми данными

## 📋 API Endpoints

### Organizations
- `GET /api/organizations/{id}` - Получить организацию по ID
- `GET /api/organizations/building/{buildingId}` - Организации в здании
- `GET /api/organizations/activity/{activityId}` - Организации по деятельности
- `GET /api/organizations/search?name={name}` - Поиск организаций
- `GET /api/organizations/radius?lat={lat}&lng={lng}&radius={radius}` - Организации в радиусе

### Buildings
- `GET /api/buildings` - Список всех зданий

## 🔑 API Keys

По умолчанию доступны следующие API ключи:
- `test-api-key-123`
- `demo-api-key-456`
- `production-api-key-789`

**Как настроить свои ключи:** См. [docs/api-keys-configuration.md](docs/api-keys-configuration.md)

## 🛠 Установка и запуск

> ⚠️ **Если после клонирования или composer install возникают ошибки, связанные с отсутствием папок или правами на запись (например, /var/www/bootstrap/cache directory must be present and writable), выполните:**
> 
> ```sh
> mkdir -p bootstrap/cache storage/framework/{cache,sessions,views}
> chmod -R 777 bootstrap/cache storage
> ```

### Требования
- Docker
- Docker Compose

### Быстрый старт

1. **Клонируйте репозиторий**
```bash
git clone <repository-url>
cd laravel-test
```

2. **Запустите Docker контейнеры**
```bash
docker-compose up -d
```

3. **Установите зависимости**
```bash
docker exec laravel_app composer install
```

4. **Настройте базу данных**
```bash
docker exec laravel_app php artisan migrate
docker exec laravel_app php artisan db:seed
```

5. **Сгенерируйте ключ приложения**
```bash
docker exec laravel_app php artisan key:generate
```

6. **Откройте в браузере**
- **API**: http://localhost:8000/api/organizations/1
- **Swagger UI**: http://localhost:8000/api/documentation

## 📖 Документация

- [API Key Middleware](docs/api-key-middleware.md) - Документация по API ключам
- [Swagger Configuration](docs/swagger-config.md) - Настройка Swagger
- [API Keys Configuration](docs/api-keys-configuration.md) - Настройка API ключей
- [Quick API Keys Setup](docs/quick-api-keys-setup.md) - Быстрая настройка ключей
- [API Testing Results](docs/api-testing-results.md) - Результаты тестирования

## 🧪 Тестирование API

### cURL примеры

```bash
# Получить организацию
curl -H "X-API-KEY: test-api-key-123" \
     http://localhost:8000/api/organizations/1

# Поиск организаций
curl -H "X-API-KEY: test-api-key-123" \
     "http://localhost:8000/api/organizations/search?name=мясной"

# Организации в здании
curl -H "X-API-KEY: test-api-key-123" \
     http://localhost:8000/api/organizations/building/1
```

### Swagger UI
1. Откройте http://localhost:8000/api/documentation
2. Нажмите "Authorize" и введите API ключ
3. Тестируйте любой эндпоинт

## 🔧 Настройка

### Изменение API ключей

1. Откройте `config/app.php`
2. Найдите секцию `api_keys`
3. Замените на свои ключи:
```php
'api_keys' => [
    'your-secure-api-key-2024',
    'client-abc-key-xyz789',
],
```
4. Перезапустите: `docker-compose restart`

### Переменные окружения

Скопируйте `.env.example` в `.env` и настройте:

```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=admin
DB_PASSWORD=admin_password
```

## 🏗 Структура проекта

```
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── OrganizationController.php
│   │   ├── Middleware/
│   │   │   └── ApiKeyMiddleware.php
│   │   └── Requests/
│   ├── Services/
│   │   └── OrganizationService.php
│   └── Models/
├── config/
│   └── app.php (API keys configuration)
├── routes/
│   └── api.php
├── docs/ (Documentation)
└── docker-compose.yml
```

## 🔒 Безопасность

- API защищен API ключами
- Валидация всех входных данных
- CORS настройки
- Rate limiting (можно добавить)
- Логирование запросов
