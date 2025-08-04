# Постоянная настройка алиаса curl в профиле PowerShell

Write-Host "Настройка постоянного алиаса curl..." -ForegroundColor Green

# Проверяем, существует ли профиль PowerShell
$profilePath = $PROFILE.CurrentUserAllHosts
Write-Host "Путь к профилю: $profilePath" -ForegroundColor Yellow

# Создаем директорию профиля, если её нет
$profileDir = Split-Path $profilePath -Parent
if (!(Test-Path $profileDir)) {
    Write-Host "Создаем директорию профиля..." -ForegroundColor Yellow
    New-Item -ItemType Directory -Path $profileDir -Force
}

# Проверяем, существует ли профиль
if (!(Test-Path $profilePath)) {
    Write-Host "Создаем новый профиль PowerShell..." -ForegroundColor Yellow
    New-Item -ItemType File -Path $profilePath -Force
}

# Добавляем настройку алиаса в профиль
$aliasConfig = @"

# Настройка алиаса curl для использования curl.exe
if (Get-Alias -Name curl -ErrorAction SilentlyContinue) {
    Remove-Item Alias:curl -Force
}
Set-Alias -Name curl -Value curl.exe

"@

# Проверяем, есть ли уже эта настройка в профиле
$profileContent = Get-Content $profilePath -Raw -ErrorAction SilentlyContinue
if ($profileContent -and $profileContent.Contains("Set-Alias -Name curl -Value curl.exe")) {
    Write-Host "Настройка curl уже есть в профиле" -ForegroundColor Green
} else {
    Write-Host "Добавляем настройку curl в профиль..." -ForegroundColor Yellow
    Add-Content -Path $profilePath -Value $aliasConfig
    Write-Host "Настройка добавлена в профиль!" -ForegroundColor Green
}

# Применяем настройку для текущей сессии
Write-Host "Применяем настройку для текущей сессии..." -ForegroundColor Yellow
if (Get-Alias -Name curl -ErrorAction SilentlyContinue) {
    Remove-Item Alias:curl -Force
}
Set-Alias -Name curl -Value curl.exe

Write-Host "`nПроверяем алиас:" -ForegroundColor Green
Get-Alias curl

Write-Host "`nТеперь curl будет использовать curl.exe во всех новых сессиях PowerShell!" -ForegroundColor Green
Write-Host "Для применения в текущей сессии выполните: . `$PROFILE" -ForegroundColor Cyan 