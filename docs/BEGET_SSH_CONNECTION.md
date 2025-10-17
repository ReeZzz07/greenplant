# Подключение к Beget.com через SSH

## Включение SSH доступа

1. Войдите в панель управления: https://cp.beget.com/
2. Перейдите в раздел **SSH/SFTP**
3. Включите опцию **"SSH доступ"**
4. Дождитесь активации (обычно мгновенно)

## Данные для подключения

После включения SSH вы получите:

- **Хост:** ваш-логин.beget.tech
- **Порт:** 22
- **Логин:** ваш_логин_от_beget
- **Пароль:** ваш_пароль_от_beget

## Подключение через различные клиенты

### Windows - PowerShell / CMD

```powershell
ssh ваш-логин@ваш-логин.beget.tech
```

При первом подключении появится вопрос о добавлении сервера в trusted hosts - напишите `yes`

### Windows - PuTTY

1. Скачайте PuTTY: https://www.putty.org/
2. Запустите PuTTY
3. Заполните:
   - **Host Name:** ваш-логин.beget.tech
   - **Port:** 22
   - **Connection type:** SSH
4. Нажмите **Open**
5. Введите логин и пароль

### macOS / Linux - Terminal

```bash
ssh ваш-логин@ваш-логин.beget.tech
```

### VS Code - Remote SSH

1. Установите расширение "Remote - SSH"
2. Нажмите F1 → "Remote-SSH: Connect to Host"
3. Введите: `ssh ваш-логин@ваш-логин.beget.tech`
4. Введите пароль

## Навигация после подключения

После успешного подключения вы окажетесь в домашней директории:

```bash
# Показать текущую директорию
pwd
# Результат: /home/ваш-логин

# Перейти в папку сайта
cd ~/ваш-домен.com/public_html

# Или полный путь
cd /home/ваш-логин/ваш-домен.com/public_html

# Показать содержимое
ls -la
```

## Структура директорий на Beget

```
/home/ваш-логин/
├── ваш-домен.com/
│   └── public_html/          <- Здесь Laravel проект
│       ├── app/
│       ├── public/           <- Document Root (корень сайта)
│       ├── .env
│       └── artisan
├── logs/
│   └── php_errors.log        <- Логи PHP
└── tmp/
```

## Полезные команды после подключения

```bash
# Перейти в папку сайта
cd ~/ваш-домен.com/public_html

# Проверить версию PHP
php -v

# Проверить версию Composer
composer --version

# Проверить Laravel версию
php artisan --version

# Просмотр логов
tail -50 storage/logs/laravel.log

# Очистка кэша
php artisan cache:clear

# Запуск миграций
php artisan migrate --force

# Запуск сидеров
php artisan db:seed --force
```

## Переключение версии PHP

Beget поддерживает несколько версий PHP. Для переключения используйте команды:

```bash
# PHP 8.0
php80 artisan migrate

# PHP 8.1
php81 artisan migrate

# PHP 8.2 (рекомендуется)
php82 artisan migrate

# Проверить доступные версии
ls -la /usr/bin/php*
```

## Настройка SSH ключей (опционально, для удобства)

### Генерация SSH ключа (на вашем компьютере):

**Windows PowerShell:**
```powershell
ssh-keygen -t rsa -b 4096 -C "ваш-email@example.com"
```

**macOS / Linux:**
```bash
ssh-keygen -t rsa -b 4096 -C "ваш-email@example.com"
```

Ключ сохранится в:
- Windows: `C:\Users\ваше-имя\.ssh\id_rsa.pub`
- macOS/Linux: `~/.ssh/id_rsa.pub`

### Копирование ключа на сервер:

```bash
ssh-copy-id ваш-логин@ваш-логин.beget.tech
```

Или вручную:
1. Скопируйте содержимое файла `id_rsa.pub`
2. Подключитесь к серверу через SSH
3. Выполните:
```bash
mkdir -p ~/.ssh
nano ~/.ssh/authorized_keys
# Вставьте содержимое ключа, сохраните (Ctrl+O, Enter, Ctrl+X)
chmod 700 ~/.ssh
chmod 600 ~/.ssh/authorized_keys
```

После этого вы сможете подключаться без пароля!

## Загрузка файлов через SFTP

### FileZilla

1. Скачайте FileZilla: https://filezilla-project.org/
2. Подключение:
   - **Хост:** sftp://ваш-логин.beget.tech
   - **Порт:** 22
   - **Протокол:** SFTP
   - **Логин:** ваш-логин
   - **Пароль:** ваш-пароль

### WinSCP (Windows)

1. Скачайте WinSCP: https://winscp.net/
2. Новое подключение:
   - **Протокол:** SFTP
   - **Имя узла:** ваш-логин.beget.tech
   - **Порт:** 22
   - **Имя пользователя:** ваш-логин
   - **Пароль:** ваш-пароль

### VS Code - SFTP Extension

1. Установите расширение "SFTP"
2. Создайте файл `.vscode/sftp.json`:
```json
{
    "name": "Beget Server",
    "host": "ваш-логин.beget.tech",
    "protocol": "sftp",
    "port": 22,
    "username": "ваш-логин",
    "password": "ваш-пароль",
    "remotePath": "/home/ваш-логин/ваш-домен.com/public_html",
    "uploadOnSave": false,
    "ignore": [
        ".vscode",
        ".git",
        "node_modules",
        "vendor"
    ]
}
```

## Решение проблем с подключением

### "Connection refused"
- Убедитесь, что SSH доступ включен в панели управления
- Проверьте правильность хоста и порта

### "Permission denied"
- Проверьте правильность логина и пароля
- Попробуйте сбросить пароль в панели управления Beget

### "Too many authentication failures"
```bash
ssh -o IdentitiesOnly=yes ваш-логин@ваш-логин.beget.tech
```

### Медленное подключение
Добавьте в `~/.ssh/config` (на вашем компьютере):
```
Host beget
    HostName ваш-логин.beget.tech
    User ваш-логин
    Port 22
    Compression yes
    ServerAliveInterval 60
```

Теперь можно подключаться просто: `ssh beget`

## Безопасность

1. ⚠️ **Не используйте простые пароли**
2. ⚠️ **Не храните пароли в открытом виде**
3. ✅ Используйте SSH ключи вместо паролей
4. ✅ Регулярно меняйте пароли
5. ✅ Не подключайтесь из незащищенных сетей

## Полезные ссылки

- Панель управления: https://cp.beget.com/
- База знаний Beget: https://beget.com/ru/kb/how-to/ssh
- Документация SSH: https://www.openssh.com/manual.html

## Поддержка

Если возникли проблемы:
- Email: support@beget.com
- Телефон: +7 (495) 721-80-88
- Онлайн-чат в панели управления (самый быстрый способ!)

---

**Теперь вы готовы работать с сервером! 🚀**

