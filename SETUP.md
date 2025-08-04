# Инструкции по настройке Laravel Organizations API

## Быстрый старт

### 1. Подготовка окружения

```bash
# Клонирование проекта (если нужно)
git clone <repository-url>
cd laravel-test

# Копирование файла окружения
cp env.example .env
```

### 2. Запуск с Docker

```bash
# Сборка и запуск контейнеров
docker-compose up -d --build

# Ожидание запуска контейнеров (30-60 секунд)
sleep 60

# Установка зависимостей
docker-compose exec app composer install

# Генерация ключа приложения
docker-compose exec app php artisan key:generate

# Выполнение миграций
docker-compose exec app php artisan migrate

# Заполнение базы тестовыми данными
docker-compose exec app php artisan db:seed

# Генерация Swagger документации
docker-compose exec app php artisan l5-swagger:generate
```

### 3. Проверка работоспособности

- **Главная страница**: http://localhost:8000
- **Swagger документация**: http://localhost:8000/api/documentation
- **API endpoints**: http://localhost:8000/api/organizations/building/1

### 4. Тестирование API

#### Примеры запросов с curl:

```bash
# Получить организации в здании
curl -H "X-API-KEY: test-key" http://localhost:8000/api/organizations/building/1

# Получить организации по деятельности
curl -H "X-API-KEY: test-key" http://localhost:8000/api/organizations/activity/1

# Поиск организаций по радиусу
curl -H "X-API-KEY: test-key" "http://localhost:8000/api/organizations/radius?latitude=55.7558&longitude=37.6176&radius=1000"

# Получить организацию по ID
curl -H "X-API-KEY: test-key" http://localhost:8000/api/organizations/1

# Поиск организаций по имени
curl -H "X-API-KEY: test-key" "http://localhost:8000/api/organizations/search?name=мясной"

# Получить все здания
curl -H "X-API-KEY: test-key" http://localhost:8000/api/buildings
```

## Структура базы данных

### Таблицы:
- `buildings` - здания с координатами
- `activities` - деятельности с иерархией
- `organizations` - организации
- `organization_phone_numbers` - номера телефонов организаций
- `activity_organization` - связи организаций с деятельностью

### Тестовые данные:
- 2 здания в Москве
- 3 деятельности: "Еда" → "Мясная продукция", "Молочная продукция"
- 2 организации: мясной и молочный магазины
- 3 номера телефона
- Связи между организациями и деятельностью

## Устранение неполадок

### Проблемы с Docker:
```bash
# Перезапуск контейнеров
docker-compose down
docker-compose up -d --build

# Просмотр логов
docker-compose logs -f app
docker-compose logs -f db
```

### Проблемы с базой данных:
```bash
# Проверка подключения к БД
docker-compose exec app php artisan tinker
# В tinker: DB::connection()->getPdo();

# Пересоздание базы
docker-compose exec app php artisan migrate:fresh --seed
```

### Проблемы с Swagger:
```bash
# Перегенерация документации
docker-compose exec app php artisan l5-swagger:generate

# Очистка кэша
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
```

## Полезные команды

```bash
# Остановка контейнеров
docker-compose down

# Просмотр статуса контейнеров
docker-compose ps

# Вход в контейнер приложения
docker-compose exec app bash

# Выполнение команд Laravel
docker-compose exec app php artisan list

# Просмотр логов
docker-compose logs -f
``` 