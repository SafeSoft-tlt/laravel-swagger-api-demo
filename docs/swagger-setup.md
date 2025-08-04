# Настройка Swagger для работы с API ключом

## Обзор

Swagger UI теперь настроен для работы с API ключом `X-API-KEY`. Все эндпоинты защищены и требуют авторизации.

## Как использовать

### 1. Откройте Swagger UI
Перейдите по адресу: **http://localhost:8000/api/documentation**

### 2. Авторизация
1. Нажмите кнопку **"Authorize"** в правом верхнем углу
2. В поле `X-API-KEY` введите один из валидных ключей:
   - `test-api-key-123`
   - `demo-api-key-456`
   - `production-api-key-789`
3. Нажмите **"Authorize"**

### 3. Тестирование API
После авторизации вы можете:
- Тестировать любой эндпоинт через Swagger UI
- API ключ будет автоматически добавляться к каждому запросу
- Видеть примеры запросов и ответов

## Доступные эндпоинты

### Organizations
- `GET /api/organizations/{id}` - Получить организацию по ID
- `GET /api/organizations/building/{buildingId}` - Получить организации по зданию
- `GET /api/organizations/activity/{activityId}` - Получить организации по деятельности
- `GET /api/organizations/radius` - Получить организации в радиусе
- `GET /api/organizations/search` - Поиск организаций по названию

### Buildings
- `GET /api/buildings` - Получить все здания

## Примеры ответов

### Успешный ответ
```json
{
  "id": 1,
  "name": "Организация",
  "address": "Адрес",
  "phone": "+7 123 456 78 90"
}
```

### Ошибка авторизации
```json
{
  "error": "API key is required",
  "message": "X-API-KEY header is missing"
}
```

### Ошибка валидации
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "id": ["The selected id is invalid."]
  }
}
```

## Конфигурация

### Файл конфигурации
Настройки находятся в `config/l5-swagger.php`:

```php
'securityDefinitions' => [
    'securitySchemes' => [
        'api_key' => [
            'type' => 'apiKey',
            'name' => 'X-API-KEY',
            'in' => 'header',
        ],
    ],
    'security' => [
        [
            'api_key' => [],
        ],
    ],
],
```

### Аннотации в контроллерах
Каждый метод помечен аннотацией `@OA\Security`:

```php
/**
 * @OA\Get(
 *     path="/api/organizations/{id}",
 *     security={{"api_key":{}}},
 *     // ... остальные аннотации
 * )
 */
```

## Перегенерация документации

После изменения аннотаций перегенерируйте документацию:

```bash
docker exec laravel_app php artisan l5-swagger:generate
```

## Устранение неполадок

### Swagger не обновляется
1. Проверьте, что аннотации корректны
2. Перегенерируйте документацию
3. Очистите кэш браузера

### API ключ не работает
1. Убедитесь, что ключ введен правильно
2. Проверьте, что ключ есть в `config/app.php`
3. Проверьте, что middleware зарегистрирован

### 404 ошибки
1. Проверьте, что роуты загружены в `bootstrap/app.php`
2. Убедитесь, что контроллеры существуют
3. Проверьте логи Laravel 