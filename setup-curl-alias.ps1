# Настройка алиаса curl для использования curl.exe

Write-Host "Настройка алиаса curl..." -ForegroundColor Green

# Способ 1: Удалить существующий алиас curl (если есть)
if (Get-Alias -Name curl -ErrorAction SilentlyContinue) {
    Write-Host "Удаляем существующий алиас curl..." -ForegroundColor Yellow
    Remove-Item Alias:curl -Force
}

# Способ 2: Создать новый алиас для curl.exe
Write-Host "Создаем алиас curl -> curl.exe..." -ForegroundColor Yellow
Set-Alias -Name curl -Value curl.exe

# Проверим результат
Write-Host "`nПроверяем алиас:" -ForegroundColor Green
Get-Alias curl

Write-Host "`nТеперь можно использовать:" -ForegroundColor Green
Write-Host "curl -H 'X-API-KEY: test-api-key-123' http://localhost:8000/api/organizations/1" -ForegroundColor Cyan

# Тестируем новый алиас
Write-Host "`nТестируем новый алиас..." -ForegroundColor Yellow
try {
    $result = curl -H "X-API-KEY: test-api-key-123" http://localhost:8000/api/organizations/1
    Write-Host "Результат: $result" -ForegroundColor Green
} catch {
    Write-Host "Ошибка: $($_.Exception.Message)" -ForegroundColor Red
}

Write-Host "`nАлиас настроен! Теперь curl будет использовать curl.exe" -ForegroundColor Green 