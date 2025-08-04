# Быстрое тестирование API
# Использование: .\quick-test.ps1

param(
    [string]$ApiKey = "test-api-key-123",
    [string]$Url = "http://localhost:8000/api/organizations/1"
)

Write-Host "🚀 Быстрое тестирование API" -ForegroundColor Green
Write-Host "URL: $Url" -ForegroundColor Cyan
Write-Host "API Key: $ApiKey" -ForegroundColor Cyan
Write-Host ""

# Выполняем запрос
Write-Host "📡 Отправляем запрос..." -ForegroundColor Yellow
$result = curl.exe -H "X-API-KEY: $ApiKey" $Url

Write-Host ""
Write-Host "📄 Результат:" -ForegroundColor Green
Write-Host $result -ForegroundColor White

Write-Host ""
Write-Host "✅ Тест завершен!" -ForegroundColor Green 