# Тестирование API с curl.exe
# Использование: .\test-api.ps1

Write-Host "=== Тестирование API с API-ключом ===" -ForegroundColor Green
Write-Host ""

# Цвета для вывода
$colors = @{
    Success = "Green"
    Error = "Red"
    Info = "Yellow"
    Data = "Cyan"
}

# Функция для выполнения curl запроса
function Test-ApiRequest {
    param(
        [string]$Description,
        [string]$Url,
        [string]$ApiKey = $null
    )
    
    Write-Host "🔍 $Description" -ForegroundColor $colors.Info
    
    if ($ApiKey) {
        $result = curl.exe -H "X-API-KEY: $ApiKey" $Url 2>$null
    } else {
        $result = curl.exe $Url 2>$null
    }
    
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✅ Успешно" -ForegroundColor $colors.Success
        Write-Host "📄 Ответ: $result" -ForegroundColor $colors.Data
    } else {
        Write-Host "❌ Ошибка (код: $LASTEXITCODE)" -ForegroundColor $colors.Error
        Write-Host "📄 Ответ: $result" -ForegroundColor $colors.Data
    }
    
    Write-Host ""
}

# Тестируем различные сценарии
$baseUrl = "http://localhost:8000/api/organizations/1"

Write-Host "🚀 Начинаем тестирование..." -ForegroundColor Green
Write-Host ""

# Тест 1: С правильным API-ключом
Test-ApiRequest -Description "Тест с правильным API-ключом" -Url $baseUrl -ApiKey "test-api-key-123"

# Тест 2: Без API-ключа
Test-ApiRequest -Description "Тест без API-ключа" -Url $baseUrl

# Тест 3: С неправильным API-ключом
Test-ApiRequest -Description "Тест с неправильным API-ключом" -Url $baseUrl -ApiKey "invalid-key"

# Тест 4: С другим валидным ключом
Test-ApiRequest -Description "Тест с другим валидным ключом" -Url $baseUrl -ApiKey "demo-api-key-456"

Write-Host "=== Тестирование завершено ===" -ForegroundColor Green
Write-Host ""
Write-Host "💡 Ожидаемые результаты:" -ForegroundColor Cyan
Write-Host "   ✅ С правильным ключом: 200 OK" -ForegroundColor Green
Write-Host "   ❌ Без ключа: 401 Unauthorized" -ForegroundColor Red
Write-Host "   ❌ С неправильным ключом: 401 Unauthorized" -ForegroundColor Red 