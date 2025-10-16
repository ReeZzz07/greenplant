# ⚡ Production Optimization Guide для GreenPlant

Руководство по оптимизации Laravel приложения для максимальной производительности на REG.RU

---

## 📋 Содержание

1. [Кеширование](#кеширование)
2. [Оптимизация Composer](#оптимизация-composer)
3. [Настройки PHP](#настройки-php)
4. [Оптимизация БД](#оптимизация-бд)
5. [Статические файлы](#статические-файлы)
6. [Мониторинг производительности](#мониторинг-производительности)

---

## 🚀 Кеширование

### 1. Configuration Caching

Кеширует все файлы конфигурации в один файл:

```bash
php artisan config:cache
```

**Эффект**: Ускоряет загрузку конфигурации в 10+ раз

**Важно**: После изменения любого файла в `config/` или `.env` нужно повторно выполнить:
```bash
php artisan config:clear
php artisan config:cache
```

### 2. Route Caching

Кеширует все маршруты:

```bash
php artisan route:cache
```

**Эффект**: Ускоряет регистрацию маршрутов в 5+ раз

**Ограничение**: Не работает с Closure маршрутами. Все маршруты должны использовать контроллеры.

**После изменения `routes/`**:
```bash
php artisan route:clear
php artisan route:cache
```

### 3. View Caching

Прекомпилирует все Blade шаблоны:

```bash
php artisan view:cache
```

**Эффект**: Ускоряет первую загрузку страниц

**После изменения views**:
```bash
php artisan view:clear
php artisan view:cache
```

### 4. Event Caching

Кеширует обнаружение событий и слушателей:

```bash
php artisan event:cache
```

**После изменения событий**:
```bash
php artisan event:clear
php artisan event:cache
```

### 5. Optimize Command

Комбинированная команда оптимизации:

```bash
php artisan optimize
```

Выполняет:
- `config:cache`
- `route:cache`

### 6. Очистка всех кешей

Если что-то пошло не так:

```bash
php artisan optimize:clear
```

Или по отдельности:
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear
```

---

## 📦 Оптимизация Composer

### 1. Production установка

Установите зависимости с оптимизацией:

```bash
composer install --optimize-autoloader --no-dev
```

**Флаги**:
- `--optimize-autoloader` - оптимизирует autoloader
- `--no-dev` - не устанавливает dev-зависимости

### 2. Дополнительная оптимизация

Для максимальной производительности:

```bash
composer dump-autoload --optimize --apcu --no-dev
```

**Флаги**:
- `--optimize` - создает map классов
- `--apcu` - использует APCu для кеширования (если доступен)
- `--no-dev` - исключает dev-пути

### 3. Проверка зависимостей

Убедитесь что в `vendor/` только production зависимости:

```bash
composer show --tree
```

Не должно быть:
- phpunit
- mockery
- facade/ignition
- laravel/sail
- и других dev-пакетов

---

## 🔧 Настройки PHP

### 1. Оптимальные значения для REG.RU

Создайте `.user.ini` в корне проекта (или настройте через панель управления):

```ini
; Память
memory_limit = 256M

; Загрузка файлов
upload_max_filesize = 10M
post_max_size = 10M
max_file_uploads = 20

; Время выполнения
max_execution_time = 300
max_input_time = 300

; Opcache (если доступен)
opcache.enable = 1
opcache.memory_consumption = 128
opcache.interned_strings_buffer = 8
opcache.max_accelerated_files = 4000
opcache.revalidate_freq = 60
opcache.fast_shutdown = 1
opcache.enable_cli = 0

; Session
session.gc_maxlifetime = 7200
session.cookie_lifetime = 0
session.cookie_secure = 1
session.cookie_httponly = 1

; Security
expose_php = Off
display_errors = Off
log_errors = On
error_reporting = E_ALL & ~E_DEPRECATED & ~E_STRICT
```

### 2. Проверка Opcache

Проверьте включен ли Opcache:

```php
<?php
// create file: public/phpinfo.php (удалите после проверки!)
phpinfo();
```

Найдите секцию "Zend OPcache" - должно быть "Opcache enabled: true"

**ВАЖНО**: Удалите `phpinfo.php` после проверки!

### 3. APCu (если доступен)

Если APCu доступен на вашем тарифе:

```env
# .env
CACHE_DRIVER=apcu
SESSION_DRIVER=apcu
```

Проверьте доступность:
```bash
php -m | grep apcu
```

---

## 🗄️ Оптимизация БД

### 1. Индексы

Убедитесь что все внешние ключи проиндексированы.

Уже настроено в миграциях:
- `products.category_id`
- `orders.user_id`
- `order_items.order_id`
- `order_items.product_id`
- `user_addresses.user_id`

### 2. Query Optimization

В production следите за N+1 проблемой.

**Плохо** (N+1):
```php
$orders = Order::all();
foreach ($orders as $order) {
    echo $order->user->name; // Запрос для каждого заказа!
}
```

**Хорошо** (Eager Loading):
```php
$orders = Order::with('user')->get();
foreach ($orders as $order) {
    echo $order->user->name; // Один запрос!
}
```

### 3. Database Caching

Для часто используемых данных:

```php
// Кеширование категорий на 1 час
$categories = Cache::remember('categories', 3600, function () {
    return Category::all();
});
```

### 4. Pagination

Используйте пагинацию для больших списков:

```php
// Вместо
$products = Product::all(); // Загружает ВСЕ товары!

// Используйте
$products = Product::paginate(20); // По 20 товаров на страницу
```

### 5. Database Connection Pooling

В `.env` для production:

```env
DB_CONNECTION=mysql
DB_PERSISTENT=true  # Persistent connections
```

---

## 📁 Статические файлы

### 1. Сжатие изображений

Перед загрузкой на сервер сжимайте изображения:

**Инструменты**:
- TinyPNG.com
- ImageOptim (Mac)
- FileOptimizer (Windows)

**Целевой размер**:
- Главные изображения: < 200KB
- Миниатюры: < 50KB
- Иконки: < 10KB

### 2. WebP формат

Если браузеры поддерживают, используйте WebP:

```php
// В контроллере при загрузке
$image = Image::make($request->file('image'));
$image->encode('webp', 90)->save('path/to/image.webp');
```

### 3. Browser Caching

В `.htaccess` уже настроено:

```apache
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpg "access plus 1 year"
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
</IfModule>
```

### 4. Gzip Compression

В `.htaccess` уже настроено:

```apache
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/css text/javascript application/javascript
</IfModule>
```

### 5. CDN (опционально)

Для ускорения можно использовать CDN:
- CloudFlare (бесплатный план)
- KeyCDN
- BunnyCDN

---

## 📊 Мониторинг производительности

### 1. Laravel Debugbar (только для development!)

```bash
# НИКОГДА не включайте в production!
composer require barryvdh/laravel-debugbar --dev
```

### 2. Laravel Telescope (опционально)

Для мониторинга в production:

```bash
composer require laravel/telescope
php artisan telescope:install
php artisan migrate
```

**Важно**: Ограничьте доступ только админам в `TelescopeServiceProvider`.

### 3. Логирование медленных запросов

В `AppServiceProvider.php`:

```php
use Illuminate\Support\Facades\DB;

public function boot()
{
    // Логировать запросы дольше 1 секунды
    DB::listen(function ($query) {
        if ($query->time > 1000) {
            Log::warning('Slow query', [
                'sql' => $query->sql,
                'bindings' => $query->bindings,
                'time' => $query->time
            ]);
        }
    });
}
```

### 4. Application Performance Monitoring

**Сервисы**:
- New Relic (платный)
- Blackfire.io (платный)
- Scout APM (платный)

Для небольших проектов достаточно:
- Встроенное логирование Laravel
- Google Analytics
- Uptime мониторинг

---

## 🎯 Быстрый checklist оптимизации

Выполните перед запуском в production:

```bash
#!/bin/bash

# 1. Оптимизация Composer
composer install --optimize-autoloader --no-dev

# 2. Кеширование
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# 3. Проверка
php artisan about
```

---

## 📈 Ожидаемые результаты

После всех оптимизаций:

### Скорость загрузки:
- **Главная страница**: < 2 секунды
- **Страница товара**: < 1.5 секунды
- **Админка**: < 2.5 секунды

### PageSpeed Insights:
- **Performance**: 85-95
- **Accessibility**: 90-100
- **Best Practices**: 90-100
- **SEO**: 90-100

### GTmetrix:
- **Performance Grade**: B или выше
- **Structure Grade**: B или выше
- **Fully Loaded Time**: < 3 секунды

---

## 🔍 Проверка оптимизации

### 1. Проверьте кеши

```bash
# Должны существовать файлы:
ls -la bootstrap/cache/config.php
ls -la bootstrap/cache/routes-v7.php
ls -la bootstrap/cache/packages.php
ls -la bootstrap/cache/services.php
```

### 2. Проверьте autoloader

```bash
# Должен быть optimized
grep "classMap" vendor/composer/autoload_classmap.php
```

### 3. Проверьте размер vendor

```bash
# Должен быть ~30-50MB (без dev-пакетов)
du -sh vendor/
```

### 4. Проверьте логи медленных запросов

```bash
# Должно быть пусто или минимум записей
grep "Slow query" storage/logs/laravel.log
```

---

## 🚨 Важные напоминания

### ⚠️ После обновления кода

Всегда очищайте кеши после изменений:

```bash
php artisan optimize:clear
php artisan optimize
```

### ⚠️ Режим обслуживания

При обновлении используйте maintenance mode:

```bash
# Включить
php artisan down --secret="токен-для-доступа"

# Обновление...
git pull
composer install --no-dev
php artisan migrate --force
php artisan optimize:clear
php artisan optimize

# Выключить
php artisan up
```

### ⚠️ Логирование

В production:
- `LOG_LEVEL=error` (не debug!)
- `LOG_CHANNEL=daily` (ротация логов)
- Регулярно очищайте старые логи

---

## 📚 Дополнительные ресурсы

- [Laravel Performance Optimization](https://laravel.com/docs/10.x/deployment#optimization)
- [PHP Performance Best Practices](https://www.php.net/manual/en/opcache.configuration.php)
- [MySQL Optimization](https://dev.mysql.com/doc/refman/8.0/en/optimization.html)

---

**Версия**: 1.0  
**Дата**: 16 октября 2025  
**Проект**: GreenPlant

