# Инструкция по развертыванию на продакшене

## Подготовка к развертыванию

### 1. Настройка сервера

Минимальные требования:
- PHP 8.1 или выше
- MySQL 5.7+ или MariaDB 10.3+
- Composer
- Node.js и NPM (для компиляции ассетов)
- Apache/Nginx

### 2. Настройка окружения

Скопируйте `.env.example` в `.env` и настройте:

```env
APP_NAME=GreenPlant
APP_ENV=production
APP_KEY=    # Сгенерируйте через php artisan key:generate
APP_DEBUG=false
APP_URL=https://ваш-домен.ru

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=greenplant
DB_USERNAME=ваш_пользователь
DB_PASSWORD=ваш_пароль

# Email настройки
MAIL_MAILER=smtp
MAIL_HOST=smtp.yandex.ru
MAIL_PORT=465
MAIL_USERNAME=info@greenplant.ru
MAIL_PASSWORD=ваш_пароль_от_почты
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=info@greenplant.ru
MAIL_FROM_NAME=GreenPlant
```

### 3. Установка зависимостей

```bash
# Установка PHP зависимостей
composer install --optimize-autoloader --no-dev

# Генерация ключа приложения
php artisan key:generate

# Миграции БД
php artisan migrate --seed --force

# Создание символической ссылки
php artisan storage:link

# Кэширование конфигурации
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 4. Настройка прав доступа

```bash
# Linux/Mac
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Windows (обычно не требуется)
```

### 5. Настройка веб-сервера

#### Apache (.htaccess уже настроен)
Убедитесь что `mod_rewrite` включен:
```bash
a2enmod rewrite
systemctl restart apache2
```

Document Root должен указывать на папку `public/`

#### Nginx
```nginx
server {
    listen 80;
    server_name ваш-домен.ru;
    root /path/to/greenplant/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## 🔒 Безопасность

### Обязательно измените:
1. ✅ Пароли администраторов в БД
2. ✅ `APP_KEY` в `.env`
3. ✅ Пароли БД
4. ✅ `APP_DEBUG=false` в продакшене

### Создание нового администратора:

```bash
php artisan tinker
```

```php
$user = new App\Models\User();
$user->name = 'Ваше имя';
$user->email = 'ваш@email.ru';
$user->password = Hash::make('новый_пароль');
$user->save();
$user->assignRole('admin');
```

### Изменение пароля существующего пользователя:

```bash
php artisan tinker
```

```php
$user = App\Models\User::where('email', 'admin@greenplant.ru')->first();
$user->password = Hash::make('новый_безопасный_пароль');
$user->save();
```

## 🌐 SSL сертификат

Рекомендуется использовать Let's Encrypt:

```bash
# Установка Certbot
apt-get install certbot python3-certbot-nginx

# Получение сертификата
certbot --nginx -d ваш-домен.ru -d www.ваш-домен.ru
```

## 📊 Мониторинг и логи

Логи находятся в `storage/logs/laravel.log`

Просмотр последних ошибок:
```bash
tail -f storage/logs/laravel.log
```

## 🔄 Обновление сайта

```bash
# Получить обновления
git pull origin main

# Установить зависимости
composer install --optimize-autoloader --no-dev

# Запустить новые миграции
php artisan migrate --force

# Очистить и пересоздать кэш
php artisan config:clear
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Перезапустить очереди (если используются)
php artisan queue:restart
```

## 💾 Резервное копирование

### Бэкап базы данных:
```bash
mysqldump -u пользователь -p greenplant > backup_$(date +%Y%m%d).sql
```

### Бэкап файлов:
```bash
tar -czf backup_files_$(date +%Y%m%d).tar.gz storage/app/public
```

### Автоматический бэкап (cron):
```bash
0 3 * * * /usr/bin/mysqldump -u пользователь -pпароль greenplant > /backups/db_$(date +\%Y\%m\%d).sql
```

## 🚨 Troubleshooting

### 500 Internal Server Error
1. Проверьте права на `storage/` и `bootstrap/cache/`
2. Проверьте логи в `storage/logs/laravel.log`
3. Убедитесь что `.env` настроен правильно

### Изображения не загружаются
```bash
php artisan storage:link
```

### Ошибки доступа
```bash
php artisan cache:clear
php artisan config:clear
```

## 📞 Поддержка

При возникновении проблем:
1. Проверьте логи: `storage/logs/laravel.log`
2. Проверьте настройки `.env`
3. Документация Laravel: https://laravel.com/docs/10.x

---

**GreenPlant CMS v1.0**

