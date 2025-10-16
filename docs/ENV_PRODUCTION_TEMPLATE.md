# Production Environment Template для REG.RU

Скопируйте содержимое ниже в файл `.env` на сервере и заполните своими данными.

```env
# ========================================
# PRODUCTION ENVIRONMENT - REG.RU HOSTING
# ========================================

APP_NAME="GreenPlant"
APP_ENV=production
APP_KEY=
# Генерируется: php artisan key:generate

APP_DEBUG=false
# КРИТИЧНО: В production ВСЕГДА false!

APP_URL=https://ваш-домен.ru
# Замените на ваш домен

APP_TIMEZONE=Europe/Moscow
APP_LOCALE=ru
APP_FALLBACK_LOCALE=ru

# ========================================
# БАЗА ДАННЫХ
# ========================================

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=имя_базы_данных
# Формат: u1234567_dbname

DB_USERNAME=пользователь_бд
# Формат: u1234567_user

DB_PASSWORD=пароль_от_бд
# Используйте СЛОЖНЫЙ пароль!

# ========================================
# ОЧЕРЕДИ И КЕШ
# ========================================

QUEUE_CONNECTION=database
CACHE_DRIVER=file
SESSION_DRIVER=file
SESSION_LIFETIME=120

# ========================================
# EMAIL
# ========================================

MAIL_MAILER=smtp
MAIL_HOST=smtp.reg.ru
MAIL_PORT=587
MAIL_USERNAME=ваш@email.ru
MAIL_PASSWORD=пароль_от_почты
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@ваш-домен.ru
MAIL_FROM_NAME="${APP_NAME}"

# ========================================
# РЕЗЕРВНЫЕ КОПИИ
# ========================================

BACKUP_NOTIFICATION_EMAIL=admin@ваш-домен.ru

# ========================================
# ЛОГИРОВАНИЕ
# ========================================

LOG_CHANNEL=daily
LOG_LEVEL=error
LOG_DAYS=14

# ========================================
# ПРОЧЕЕ
# ========================================

BROADCAST_DRIVER=log
FILESYSTEM_DISK=public

# Аналитика
GOOGLE_ANALYTICS_ID=
YANDEX_METRIKA_ID=
GOOGLE_SITE_VERIFICATION=
YANDEX_VERIFICATION=

# Настройки
IMAGE_COMPRESSION_QUALITY=85
MAX_UPLOAD_SIZE=2048
ROBOTS_ALLOW_INDEXING=true
```

## ✅ Checklist перед развертыванием

- [ ] `APP_ENV=production`
- [ ] `APP_DEBUG=false`
- [ ] `APP_KEY` сгенерирован
- [ ] `APP_URL` установлен правильно
- [ ] Все `DB_*` параметры заполнены
- [ ] `MAIL_*` настройки проверены
- [ ] Сложные пароли для БД
- [ ] `.env` НЕ добавлен в Git
- [ ] `storage/` и `bootstrap/cache/` доступны для записи (chmod 775)

