# Swagger/OpenAPI конфигурация с API-ключом

## Базовая конфигурация

### 1. Установка пакета

```bash
composer require darkaonline/l5-swagger
```

### 2. Публикация конфигурации

```bash
php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
```

### 3. Конфигурация в config/l5-swagger.php

```php
<?php

return [
    'default' => 'default',
    'documentations' => [
        'default' => [
            'api' => [
                'title' => 'Laravel Organizations API Documentation',
            ],
            'routes' => [
                'api' => 'api/documentation',
            ],
            'paths' => [
                'use_absolute_path' => env('L5_SWAGGER_USE_ABSOLUTE_PATH', true),
                'docs_json' => 'api-docs.json',
                'docs_yaml' => 'api-docs.yaml',
                'format_to_use_for_docs' => env('L5_FORMAT_TO_USE_FOR_DOCS', 'json'),
                'annotations' => [
                    base_path('app'),
                ],
            ],
        ],
    ],
    'defaults' => [
        'routes' => [
            'docs' => 'docs',
            'oauth2_callback' => 'api/oauth2-callback',
            'middleware' => [
                'api' => [],
                'asset' => [],
                'docs' => [],
                'oauth2_callback' => [],
            ],
        ],
        'paths' => [
            'docs' => storage_path('api-docs'),
            'views' => base_path('resources/views/vendor/l5-swagger'),
            'base' => env('L5_SWAGGER_BASE_PATH', null),
            'swagger_ui_assets_path' => env('L5_SWAGGER_UI_ASSETS_PATH', 'vendor/swagger-api/swagger-ui/dist/'),
            'excludes' => [],
        ],
        'scanOptions' => [
            'analyser' => null,
            'analysis' => null,
            'processors' => [],
            'pattern' => null,
            'exclude' => [],
            'exclude_glob' => [],
            'open_api_spec_version' => env('L5_SWAGGER_OPEN_API_SPEC_VERSION', \L5Swagger\Generator::OPEN_API_DEFAULT_SPEC_VERSION),
        ],
        'securityDefinitions' => [
            'securitySchemes' => [
                'ApiKeyAuth' => [
                    'type' => 'apiKey',
                    'in' => 'header',
                    'name' => 'X-API-KEY',
                    'description' => 'API key for authentication'
                ],
            ],
            'security' => [
                [
                    'ApiKeyAuth' => []
                ],
            ],
        ],
        'generate_always' => env('L5_SWAGGER_GENERATE_ALWAYS', false),
        'generate_yaml_copy' => env('L5_SWAGGER_GENERATE_YAML_COPY', false),
        'proxy' => false,
        'additional_config_url' => null,
        'operations_sort' => env('L5_SWAGGER_OPERATIONS_SORT', null),
        'validator_url' => null,
        'ui' => [
            'display' => [
                'doc_expansion' => env('L5_SWAGGER_UI_DOC_EXPANSION', 'none'),
                'filter' => true,
            ],
            'authorization' => [
                'persist_authorization' => env('L5_SWAGGER_UI_PERSIST_AUTHORIZATION', false),
            ],
        ],
        'constants' => [
            'L5_SWAGGER_CONST_HOST' => env('L5_SWAGGER_CONST_HOST', 'http://localhost:8000'),
        ],
    ],
];
```

## Аннотации для контроллеров

### 1. Основная информация API

```php
/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Laravel Organizations API",
 *     description="REST API для справочника организаций с аутентификацией по API-ключу",
 *     @OA\Contact(
 *         email="admin@example.com"
 *     )
 * )
 */
```

### 2. Пример контроллера с полными аннотациями

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Organizations",
 *     description="API Endpoints для работы с организациями"
 * )
 */
class OrganizationController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/organizations/{id}",
     *     operationId="getOrganizationById",
     *     tags={"Organizations"},
     *     summary="Получить организацию по ID",
     *     description="Возвращает информацию об организации по её уникальному идентификатору",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID организации",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="ООО Рога и Копыта"),
     *             @OA\Property(property="address", type="string", example="ул. Пушкина, д. 10"),
     *             @OA\Property(property="phone", type="string", example="+7 (495) 123-45-67"),
     *             @OA\Property(property="email", type="string", example="info@example.com"),
     *             @OA\Property(property="website", type="string", example="https://example.com"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Неавторизованный доступ",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="API key is required"),
     *             @OA\Property(property="message", type="string", example="X-API-KEY header is missing")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Организация не найдена",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Organization not found"),
     *             @OA\Property(property="message", type="string", example="The requested organization does not exist")
     *         )
     *     )
     * )
     */
    public function getById(int $id): JsonResponse
    {
        // Логика контроллера
        return response()->json([
            'id' => $id,
            'name' => 'ООО Рога и Копыта',
            'address' => 'ул. Пушкина, д. 10',
            'phone' => '+7 (495) 123-45-67',
            'email' => 'info@example.com',
            'website' => 'https://example.com',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/organizations/search",
     *     operationId="searchOrganizations",
     *     tags={"Organizations"},
     *     summary="Поиск организаций по названию",
     *     description="Поиск организаций по частичному совпадению названия",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Название организации для поиска",
     *         required=true,
     *         @OA\Schema(type="string", example="Рога")
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Количество результатов",
     *         required=false,
     *         @OA\Schema(type="integer", default=10, minimum=1, maximum=100)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="ООО Рога и Копыта"),
     *                 @OA\Property(property="address", type="string", example="ул. Пушкина, д. 10")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Неавторизованный доступ"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Некорректный запрос",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Name parameter is required"),
     *             @OA\Property(property="message", type="string", example="The name parameter must be provided")
     *         )
     *     )
     * )
     */
    public function searchByName(Request $request): JsonResponse
    {
        $name = $request->query('name');
        $limit = $request->query('limit', 10);

        if (!$name) {
            return response()->json([
                'error' => 'Name parameter is required',
                'message' => 'The name parameter must be provided'
            ], 400);
        }

        // Логика поиска
        return response()->json([
            [
                'id' => 1,
                'name' => 'ООО Рога и Копыта',
                'address' => 'ул. Пушкина, д. 10'
            ],
            [
                'id' => 2,
                'name' => 'ИП Рогачев',
                'address' => 'ул. Ленина, д. 5'
            ]
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/organizations/radius",
     *     operationId="getOrganizationsByRadius",
     *     tags={"Organizations"},
     *     summary="Поиск организаций по радиусу",
     *     description="Поиск организаций в заданном радиусе от указанных координат",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\Parameter(
     *         name="latitude",
     *         in="query",
     *         description="Широта",
     *         required=true,
     *         @OA\Schema(type="number", format="float", example=55.7558)
     *     ),
     *     @OA\Parameter(
     *         name="longitude",
     *         in="query",
     *         description="Долгота",
     *         required=true,
     *         @OA\Schema(type="number", format="float", example=37.6176)
     *     ),
     *     @OA\Parameter(
     *         name="radius",
     *         in="query",
     *         description="Радиус поиска в метрах",
     *         required=true,
     *         @OA\Schema(type="integer", example=1000)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="ООО Рога и Копыта"),
     *                 @OA\Property(property="address", type="string", example="ул. Пушкина, д. 10"),
     *                 @OA\Property(property="distance", type="number", format="float", example=250.5)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Неавторизованный доступ"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Некорректные параметры",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Invalid coordinates"),
     *             @OA\Property(property="message", type="string", example="Latitude and longitude must be valid numbers")
     *         )
     *     )
     * )
     */
    public function getByRadius(Request $request): JsonResponse
    {
        $latitude = $request->query('latitude');
        $longitude = $request->query('longitude');
        $radius = $request->query('radius');

        if (!$latitude || !$longitude || !$radius) {
            return response()->json([
                'error' => 'Missing required parameters',
                'message' => 'Latitude, longitude and radius are required'
            ], 400);
        }

        // Логика поиска по радиусу
        return response()->json([
            [
                'id' => 1,
                'name' => 'ООО Рога и Копыта',
                'address' => 'ул. Пушкина, д. 10',
                'distance' => 250.5
            ],
            [
                'id' => 3,
                'name' => 'ООО Торговый Дом',
                'address' => 'ул. Гагарина, д. 15',
                'distance' => 750.2
            ]
        ]);
    }
}
```

## Генерация документации

### 1. Генерация документации

```bash
php artisan l5-swagger:generate
```

### 2. Просмотр документации

После генерации документация будет доступна по адресу:
`http://localhost:8000/api/documentation`

### 3. Автоматическая генерация при изменениях

Добавьте в `config/l5-swagger.php`:

```php
'generate_always' => env('L5_SWAGGER_GENERATE_ALWAYS', true),
```

## Использование в Swagger UI

### 1. Авторизация

1. Откройте Swagger UI
2. Нажмите кнопку "Authorize"
3. Введите один из валидных API-ключей:
   - `test-api-key-123`
   - `demo-api-key-456`
   - `production-api-key-789`
4. Нажмите "Authorize"

### 2. Тестирование API

После авторизации вы сможете:
- Тестировать все эндпоинты прямо из браузера
- Видеть автоматически добавляемый заголовок `X-API-KEY`
- Получать реальные ответы от API

## Примеры ответов для тестирования

### Успешный запрос
```json
{
    "id": 1,
    "name": "ООО Рога и Копыта",
    "address": "ул. Пушкина, д. 10",
    "phone": "+7 (495) 123-45-67",
    "email": "info@example.com",
    "website": "https://example.com",
    "created_at": "2024-01-15T10:30:00.000000Z",
    "updated_at": "2024-01-15T10:30:00.000000Z"
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
    "error": "Invalid coordinates",
    "message": "Latitude and longitude must be valid numbers"
}
``` 