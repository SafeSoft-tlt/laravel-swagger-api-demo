# Простое тестирование API с curl.exe

Write-Host "Тестирование API с curl.exe..." -ForegroundColor Green

Write-Host "`n1. Тест с правильным API-ключом:" -ForegroundColor Yellow
curl.exe -H "X-API-KEY: test-api-key-123" http://localhost:8000/api/organizations/1

Write-Host "`n2. Тест без API-ключа:" -ForegroundColor Yellow
curl.exe http://localhost:8000/api/organizations/1

Write-Host "`n3. Тест с неправильным API-ключом:" -ForegroundColor Yellow
curl.exe -H "X-API-KEY: invalid-key" http://localhost:8000/api/organizations/1

Write-Host "`nТестирование завершено!" -ForegroundColor Green 