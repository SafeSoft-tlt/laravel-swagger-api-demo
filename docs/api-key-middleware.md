# API Key Middleware - Документация

## Что такое ApiKeyMiddleware?

`ApiKeyMiddleware` - это middleware Laravel, который проверяет наличие и валидность API-ключа в заголовке `X-API-KEY` для всех запросов к защищенным API-эндпоинтам.

## Как это работает?

1. **Проверка заголовка**: Middleware проверяет наличие заголовка `X-API-KEY` в запросе
2. **Валидация ключа**: Сравнивает предоставленный ключ со списком разрешенных ключей из конфигурации
3. **Ответ**: Возвращает ошибку 401 (Unauthorized) если ключ отсутствует или недействителен

## Конфигурация

### Регистрация в bootstrap/app.php

```php
->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
        'api.key' => \App\Http\Middleware\ApiKeyMiddleware::class,
    ]);
})
```

### Настройка API-ключей в config/app.php

```php
'api_keys' => [
    'test-api-key-123',
    'demo-api-key-456',
    'production-api-key-789',
],
```

## Использование в маршрутах

```php
Route::middleware('api.key')->group(function () {
    Route::get('/organizations/{id}', [OrganizationController::class, 'getById']);
    Route::get('/buildings', [OrganizationController::class, 'getBuildings']);
});
```

## Использование в Swagger/OpenAPI

### 1. Добавление в Swagger конфигурацию

```yaml
components:
  securitySchemes:
    ApiKeyAuth:
      type: apiKey
      in: header
      name: X-API-KEY
      description: API key for authentication

security:
  - ApiKeyAuth: []
```

### 2. Пример Swagger аннотации для контроллера

```php
/**
 * @OA\Get(
 *     path="/api/organizations/{id}",
 *     summary="Get organization by ID",
 *     security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized - Invalid or missing API key"
 *     )
 * )
 */
public function getById($id)
{
    // Your controller logic
}
```

### 3. Настройка в Swagger UI

В Swagger UI вы сможете:
- Ввести API-ключ в поле "Authorize"
- Все запросы будут автоматически включать заголовок `X-API-KEY`
- Тестировать API прямо из браузера

## Использование в Postman

### 1. Настройка переменной окружения

1. Создайте новое окружение в Postman
2. Добавьте переменную `api_key` со значением одного из валидных ключей
3. Например: `test-api-key-123`

### 2. Настройка заголовка в коллекции

1. Откройте вашу коллекцию
2. Перейдите на вкладку "Headers"
3. Добавьте заголовок:
   - **Key**: `X-API-KEY`
   - **Value**: `{{api_key}}`

### 3. Настройка на уровне запроса

Для отдельных запросов:
1. Откройте запрос
2. Перейдите на вкладку "Headers"
3. Добавьте:
   - **Key**: `X-API-KEY`
   - **Value**: `{{api_key}}` или конкретный ключ

### 4. Автоматическая настройка через Pre-request Script

Добавьте в Pre-request Script:

```javascript
pm.request.headers.add({
    key: 'X-API-KEY',
    value: pm.environment.get('api_key')
});
```

## Примеры ответов

### Успешный запрос (200 OK)
```json
{
    "id": 1,
    "name": "Example Organization",
    "address": "123 Main St"
}
```

### Ошибка - отсутствует API-ключ (401 Unauthorized)
```json
{
    "error": "API key is required",
    "message": "X-API-KEY header is missing"
}
```

### Ошибка - недействительный API-ключ (401 Unauthorized)
```json
{
    "error": "Invalid API key",
    "message": "The provided API key is not valid"
}
```

## Тестирование

### cURL примеры

```bash
# Успешный запрос
curl -H "X-API-KEY: test-api-key-123" \
     http://localhost:8000/api/organizations/1

# Запрос без API-ключа
curl http://localhost:8000/api/organizations/1

# Запрос с недействительным ключом
curl -H "X-API-KEY: invalid-key" \
     http://localhost:8000/api/organizations/1
```

### PHP примеры

```php
// Успешный запрос
$response = Http::withHeaders([
    'X-API-KEY' => 'test-api-key-123'
])->get('http://localhost:8000/api/organizations/1');

// Запрос без API-ключа
$response = Http::get('http://localhost:8000/api/organizations/1');
```

## Безопасность

### Рекомендации по безопасности:

1. **Используйте HTTPS** в продакшене
2. **Регулярно ротируйте ключи** - меняйте их периодически
3. **Ограничивайте доступ** - выдавайте разные ключи разным клиентам
4. **Мониторинг** - отслеживайте использование ключей
5. **Храните ключи безопасно** - используйте переменные окружения

### Добавление в .env файл

```env
API_KEYS=test-api-key-123,demo-api-key-456,production-api-key-789
```

И обновите config/app.php:

```php
'api_keys' => explode(',', env('API_KEYS', 'test-api-key-123,demo-api-key-456')),
```

> **💡 Подробная инструкция по настройке API ключей:** См. [docs/api-keys-configuration.md](docs/api-keys-configuration.md)

## Расширение функциональности

### Добавление логирования

```php
public function handle(Request $request, Closure $next): SymfonyResponse
{
    $apiKey = $request->header('X-API-KEY');
    
    if (!$apiKey) {
        Log::warning('API request without key', [
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'url' => $request->url()
        ]);
        
        return response()->json([
            'error' => 'API key is required',
            'message' => 'X-API-KEY header is missing'
        ], Response::HTTP_UNAUTHORIZED);
    }
    
    // ... остальная логика
}
```

### Добавление rate limiting

```php
Route::middleware(['api.key', 'throttle:60,1'])->group(function () {
    // Ваши маршруты
});
``` 