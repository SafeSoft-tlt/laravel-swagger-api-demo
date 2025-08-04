# Тестовое задание: REST API для справочника организаций

## Описание
Необходимо разработать REST API для справочника организаций с использованием Laravel и MySQL. API должно поддерживать получение данных об организациях по различным критериям.

## Требования
- PHP 8.4, Laravel (последняя версия), MySQL 8.0.
- Использовать Eloquent ORM для работы с базой данных.
- Тонкий контроллер, вся логика в сервисе.
- Валидация входящих параметров через Request-классы.
- Middleware для проверки API-ключа (заголовок `X-API-KEY`).
- Swagger-документация для всех эндпоинтов.
- Тестовые данные через Seeder.
- Поддержка Docker для запуска проекта.

## Структура базы данных
```sql
CREATE TABLE buildings (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    address VARCHAR(255) NOT NULL,
    latitude DECIMAL(9,6) NOT NULL,
    longitude DECIMAL(9,6) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

CREATE TABLE activities (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    parent_id BIGINT UNSIGNED NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (parent_id) REFERENCES activities(id)
);

CREATE TABLE organizations (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    building_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (building_id) REFERENCES buildings(id)
);

CREATE TABLE organization_phone_numbers (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    organization_id BIGINT UNSIGNED NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (organization_id) REFERENCES organizations(id)
);

CREATE TABLE activity_organization (
    organization_id BIGINT UNSIGNED NOT NULL,
    activity_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    PRIMARY KEY (organization_id, activity_id),
    FOREIGN KEY (organization_id) REFERENCES organizations(id),
    FOREIGN KEY (activity_id) REFERENCES activities(id)
);


# API Documentation

## Endpoints

### Organizations

- `GET /api/organizations/building/{buildingId}`  
  Список организаций в здании.

- `GET /api/organizations/activity/{activityId}`  
  Список организаций по деятельности (включая дочерние).

- `GET /api/organizations/radius?latitude=X&longitude=Y&radius=Z`  
  Список организаций в радиусе.

- `GET /api/organizations/{id}`  
  Получить организацию по ID.

- `GET /api/organizations/search?name=X`  
  Поиск организаций по имени.

### Buildings

- `GET /api/buildings`  
  Список всех зданий.

## Validation

| Parameter    | Validation Rules                          |
|--------------|-------------------------------------------|
| `buildingId` | Целое число, существует в таблице buildings |
| `activityId` | Целое число, существует в таблице activities |
| `latitude`   | Число от -90 до 90                        |
| `longitude`  | Число от -180 до 180                      |
| `radius`     | Число от 0 до 100000                      |
| `id`         | Целое число, существует в таблице organizations |
| `name`       | Строка, минимум 1 символ                  |

## Additional Requirements

- Использовать стандарт PSR-12 и `declare(strict_types=1)`
- Не использовать property hooks (достаточно Eloquent ORM)

## Test Data

- 2 здания
- 3 деятельности (с вложенностью, например: "Еда" → "Мясная продукция", "Молочная продукция")
- 2 организации
- 3 номера телефона
- Связи в таблице `activity_organization`

## Documentation & Deployment

- Документация: Swagger UI
- Развертывание: Docker с PHP 8.4 и MySQL 8.0
- Переменные окружения в `.env` без хардкода секретов
