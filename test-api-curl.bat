@echo off
echo Тестирование API с curl.exe
echo.

echo 1. Тест с правильным API-ключом:
curl.exe -H "X-API-KEY: test-api-key-123" http://localhost:8000/api/organizations/1
echo.
echo.

echo 2. Тест без API-ключа:
curl.exe http://localhost:8000/api/organizations/1
echo.
echo.

echo 3. Тест с неправильным API-ключом:
curl.exe -H "X-API-KEY: invalid-key" http://localhost:8000/api/organizations/1
echo.
echo.

echo Тестирование завершено!
pause 