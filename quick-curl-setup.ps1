# Быстрая настройка curl для использования curl.exe

Write-Host "Быстрая настройка curl..." -ForegroundColor Green

# Удаляем существующий алиас curl (если есть)
if (Get-Alias -Name curl -ErrorAction SilentlyContinue) {
    Write-Host "Удаляем существующий алиас curl..." -ForegroundColor Yellow
    Remove-Item Alias:curl -Force
}

# Создаем новый алиас
Set-Alias -Name curl -Value curl.exe

Write-Host "Готово! Теперь curl использует curl.exe" -ForegroundColor Green
Write-Host "Пример: curl -H 'X-API-KEY: test-api-key-123' http://localhost:8000/api/organizations/1" -ForegroundColor Cyan 