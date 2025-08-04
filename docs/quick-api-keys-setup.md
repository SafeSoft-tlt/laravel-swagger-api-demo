# Быстрая настройка API ключей

## ⚡ Быстрый способ (5 минут)

### 1. Откройте файл конфигурации
```bash
# Откройте config/app.php в редакторе
code config/app.php
```

### 2. Найдите секцию API ключей
Найдите строки примерно 120-125:
```php
'api_keys' => [
    'test-api-key-123',
    'demo-api-key-456', 
    'production-api-key-789',
],
```

### 3. Замените на свои ключи
```php
'api_keys' => [
    'your-secure-api-key-2024',
    'client-abc-key-xyz789',
    'production-key-abc123def456',
],
```

### 4. Перезапустите приложение
```bash
docker-compose restart
```

### 5. Протестируйте новые ключи
```bash
# Тест с новым ключом
curl.exe -H "X-API-KEY: your-secure-api-key-2024" http://localhost:8000/api/organizations/1

# Тест со старым ключом (должен вернуть ошибку)
curl.exe -H "X-API-KEY: test-api-key-123" http://localhost:8000/api/organizations/1
```

## 🔐 Генерация безопасных ключей

### Онлайн генератор:
```bash
# Откройте в браузере
https://www.random.org/strings/
```

### Или используйте команду:
```bash
# Генерирует случайный ключ
openssl rand -base64 32
```

## 📋 Примеры хороших ключей

```php
'api_keys' => [
    'sk_live_51H8J9K2L3M4N5O6P7Q8R9S0T1U2V3W4X5Y6Z',
    'pk_test_A1B2C3D4E5F6G7H8I9J0K1L2M3N4O5P6Q7R8S9T',
    'api_key_2024_secure_client_abc123def456ghi789',
],
```

## ⚠️ Важно!

1. **Не используйте простые ключи** типа `123`, `test`, `key`
2. **Минимум 32 символа** для безопасности
3. **Включайте буквы, цифры, символы**
4. **Разные ключи для разных клиентов**
5. **Не коммитьте ключи в Git**

## 🚀 Готово!

Теперь ваш API защищен новыми ключами. Не забудьте сообщить клиентам о новых ключах!

---

**📖 Подробная документация:** [docs/api-keys-configuration.md](docs/api-keys-configuration.md) 