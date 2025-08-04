# Быстрый старт с API-ключом

## Что уже настроено

✅ **ApiKeyMiddleware** - проверяет заголовок `X-API-KEY`  
✅ **Регистрация** - middleware зарегистрирован в `bootstrap/app.php`  
✅ **Маршруты** - все API маршруты защищены middleware  
✅ **Конфигурация** - API-ключи настроены в `config/app.php`  
✅ **Postman** - коллекция обновлена с правильным API-ключом  

## Валидные API-ключи

Для тестирования используйте один из этих ключей:

- `test-api-key-123`
- `demo-api-key-456` 
- `production-api-key-789`

## Быстрое тестирование

### 1. cURL

```bash
# Успешный запрос
curl -H "X-API-KEY: test-api-key-123" \
     http://localhost:8000/api/organizations/1

# Запрос без ключа (ошибка 401)
curl http://localhost:8000/api/organizations/1
```

### 2. Postman

1. Импортируйте `postman_collection.json`
2. API-ключ уже настроен в коллекции
3. Все запросы автоматически включают заголовок `X-API-KEY`

### 3. Swagger (если установлен)

1. Установите пакет: `composer require darkaonline/l5-swagger`
2. Следуйте инструкциям в `docs/swagger-config.md`
3. Откройте `http://localhost:8000/api/documentation`
4. Нажмите "Authorize" и введите API-ключ

## Структура ответов

### Успешный запрос (200 OK)
```json
{
    "id": 1,
    "name": "ООО Рога и Копыта",
    "address": "ул. Пушкина, д. 10"
}
```

### Ошибка авторизации (401 Unauthorized)
```json
{
    "error": "API key is required",
    "message": "X-API-KEY header is missing"
}
```

## Доступные эндпоинты

Все эндпоинты требуют API-ключ:

- `GET /api/organizations/{id}` - получить организацию по ID
- `GET /api/organizations/search?name={name}` - поиск по названию
- `GET /api/organizations/radius?lat={lat}&lng={lng}&radius={radius}` - поиск по радиусу
- `GET /api/organizations/building/{buildingId}` - организации в здании
- `GET /api/organizations/activity/{activityId}` - организации по деятельности
- `GET /api/buildings` - список зданий

## Настройка для продакшена

### 1. Добавьте ключи в .env

```env
API_KEYS=your-production-key-1,your-production-key-2
```

### 2. Обновите config/app.php

```php
'api_keys' => explode(',', env('API_KEYS', 'test-api-key-123,demo-api-key-456')),
```

### 3. Используйте HTTPS

В продакшене обязательно используйте HTTPS для защиты API-ключей.

## Дополнительная документация

- 📖 [Полная документация API-ключа](api-key-middleware.md)
- 📖 [Настройка Swagger](swagger-config.md)
- 📖 [Postman коллекция](postman_collection.json) 