<?php
// Простой тестовый API-эндпоинт для проверки API-ключа
// Запуск: php -S localhost:8080 test-api-endpoint.php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: X-API-KEY, Content-Type');

// Обработка preflight запросов
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Валидные API-ключи
$validApiKeys = [
    'test-api-key-123',
    'demo-api-key-456',
    'production-api-key-789'
];

// Получаем API-ключ из заголовка
$apiKey = $_SERVER['HTTP_X_API_KEY'] ?? null;

// Проверяем наличие API-ключа
if (!$apiKey) {
    http_response_code(401);
    echo json_encode([
        'error' => 'API key is required',
        'message' => 'X-API-KEY header is missing'
    ]);
    exit();
}

// Проверяем валидность API-ключа
if (!in_array($apiKey, $validApiKeys)) {
    http_response_code(401);
    echo json_encode([
        'error' => 'Invalid API key',
        'message' => 'The provided API key is not valid'
    ]);
    exit();
}

// Успешный ответ
http_response_code(200);
echo json_encode([
    'success' => true,
    'message' => 'API key is valid',
    'data' => [
        'id' => 1,
        'name' => 'ООО Рога и Копыта',
        'address' => 'ул. Пушкина, д. 10',
        'phone' => '+7 (495) 123-45-67',
        'email' => 'info@example.com',
        'website' => 'https://example.com',
        'api_key_used' => $apiKey,
        'timestamp' => date('Y-m-d H:i:s')
    ]
]);
?> 