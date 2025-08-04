@echo off
echo Запуск тестового API сервера...
echo.
echo Сервер будет доступен по адресу: http://localhost:8080
echo.
echo Для тестирования используйте:
echo curl.exe -H "X-API-KEY: test-api-key-123" http://localhost:8080
echo.
echo Нажмите Ctrl+C для остановки сервера
echo.
php -S localhost:8080 test-api-endpoint.php
pause 