# 📦 Руководство по автоматическим бэкапам GreenPlant

## ✅ Установлено

Пакет **spatie/laravel-backup** успешно установлен и настроен!

---

## ⚠️ Важно для OSPanel (Windows)

### Настройка mysqldump

Добавьте путь к mysqldump в переменную окружения PATH или укажите в `config/backup.php`:

```php
'backup' => [
    'source' => [
        'databases' => [
            'mysql' => [
                'dump_command_path' => 'C:\\OSPanel\\modules\\database\\MySQL-8.0-Win10\\bin\\', // Путь к mysqldump
            ],
        ],
    ],
],
```

**Или проще:** Добавьте в `.env`:

```env
DB_DUMP_PATH=C:\OSPanel\modules\database\MySQL-8.0-Win10\bin
```

### Отключение email уведомлений (для локальной разработки)

В `config/backup.php` найдите:

```php
'notifications' => [
    'notifications' => [
        \Spatie\Backup\Notifications\Notifications\BackupHasFailedNotification::class => ['mail'],
        \Spatie\Backup\Notifications\Notifications\UnhealthyBackupWasFoundNotification::class => ['mail'],
        \Spatie\Backup\Notifications\Notifications\CleanupHasFailedNotification::class => ['mail'],
        \Spatie\Backup\Notifications\Notifications\BackupWasSuccessfulNotification::class => ['mail'],
    ],
],
```

Измените на `[]` чтобы отключить:

```php
'notifications' => [
    'notifications' => [
        \Spatie\Backup\Notifications\Notifications\BackupHasFailedNotification::class => [],
        // ... и т.д.
    ],
],
```

---

## 🚀 Быстрый старт

### 1. Создать бэкап вручную

```bash
php artisan backup:run
```

Это создаст полный бэкап:
- Базы данных MySQL
- Всех файлов проекта (кроме vendor и node_modules)
- Сохранит в `storage/app/backups/`

### 2. Просмотреть список бэкапов

```bash
php artisan backup:list
```

### 3. Очистить старые бэкапы

```bash
php artisan backup:clean
```

Удалит бэкапы старше настроенного периода (по умолчанию 7 дней).

---

## ⚙️ Настройка автоматических бэкапов

### Для Windows (OSPanel)

Используйте **Планировщик заданий Windows**:

1. Откройте Планировщик заданий Windows (`Win + R` → `taskschd.msc`)
2. Создайте новое задание:
   - **Имя:** GreenPlant Backup
   - **Триггер:** Ежедневно в 3:00 AM
   - **Действие:** Запуск программы
   - **Программа:** `C:\OSPanel\modules\php\PHP-8.1\php.exe`
   - **Аргументы:** `artisan backup:run`
   - **Рабочая папка:** `C:\OSPanel\home\g-plant.local`

3. Создайте еще одно задание для очистки старых бэкапов:
   - **Имя:** GreenPlant Backup Clean
   - **Триггер:** Еженедельно по воскресеньям в 4:00 AM
   - **Действие:** Запуск программы
   - **Программа:** `C:\OSPanel\modules\php\PHP-8.1\php.exe`
   - **Аргументы:** `artisan backup:clean`
   - **Рабочая папка:** `C:\OSPanel\home\g-plant.local`

### Для Linux/Mac (Production)

Добавьте в crontab (`crontab -e`):

```cron
# Ежедневный бэкап в 3:00 AM
0 3 * * * cd /path/to/greenplant && php artisan backup:run >> /dev/null 2>&1

# Очистка старых бэкапов каждое воскресенье в 4:00 AM
0 4 * * 0 cd /path/to/greenplant && php artisan backup:clean >> /dev/null 2>&1
```

---

## 📊 Что включено в бэкап

### База данных:
- ✅ Все таблицы MySQL
- ✅ Все данные (товары, заказы, пользователи и т.д.)

### Файлы:
- ✅ Весь код приложения
- ✅ Загруженные изображения (`storage/app/public/`)
- ✅ Конфигурационные файлы
- ❌ **Исключено:** vendor, node_modules (занимают много места)

---

## 🔧 Настройка хранения

### Текущая настройка (локальное хранение):

Бэкапы сохраняются в `storage/app/backups/`

### Хранение на внешнем сервере (рекомендуется для production):

#### 1. Amazon S3

В `.env` добавьте:

```env
AWS_ACCESS_KEY_ID=your-access-key
AWS_SECRET_ACCESS_KEY=your-secret-key
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your-bucket-name
```

В `config/backup.php` измените:

```php
'destination' => [
    'disks' => [
        'local', // локальная копия
        's3',    // копия на S3
    ],
],
```

#### 2. Dropbox

```bash
composer require spatie/flysystem-dropbox
```

Настройте в `config/filesystems.php` и используйте аналогично S3.

---

## 📧 Email уведомления о бэкапах

### Настройка уведомлений:

В `config/backup.php` найдите секцию `notifications`:

```php
'notifications' => [
    'mail' => [
        'to' => 'admin@greenplant.ru',
        'from' => [
            'address' => env('MAIL_FROM_ADDRESS', 'info@greenplant.ru'),
            'name' => env('MAIL_FROM_NAME', 'GreenPlant Backup'),
        ],
    ],
],
```

При успешном/неудачном бэкапе вы получите email.

---

## 🔄 Восстановление из бэкапа

### 1. Найдите нужный бэкап

```bash
php artisan backup:list
```

Или посмотрите в `storage/app/backups/GreenPlant/`

### 2. Распакуйте архив

Бэкап сохранен как `.zip` файл. Распакуйте его:

```bash
unzip storage/app/backups/GreenPlant/2025-10-16-03-00-00.zip -d /tmp/restore
```

### 3. Восстановите базу данных

```bash
mysql -u root -p greenplant < /tmp/restore/db-dumps/mysql-greenplant.sql
```

### 4. Восстановите файлы

```bash
# Восстановите storage
cp -r /tmp/restore/storage/app/public/* storage/app/public/

# Или восстановите весь проект (осторожно!)
# cp -r /tmp/restore/* /path/to/greenplant/
```

---

## 📊 Размер бэкапов

### Примерные размеры:

- **База данных:** 5-50 MB (зависит от количества заказов)
- **Изображения:** 10-500 MB (зависит от количества загруженных фото)
- **Код:** 2-5 MB
- **Итого:** 17-555 MB на один бэкап

### Рекомендации:

- Храните бэкапы за **последние 7 дней** (по умолчанию)
- Настройте автоматическую очистку старых бэкапов
- Для production используйте внешнее хранилище (S3/Dropbox)

---

## 🧪 Тестирование бэкапов

### Проверка что бэкап работает:

```bash
# 1. Создайте тестовый бэкап
php artisan backup:run --only-db

# 2. Проверьте что файл создан
ls -lh storage/app/backups/GreenPlant/

# 3. Проверьте содержимое
unzip -l storage/app/backups/GreenPlant/latest.zip
```

### Регулярно проверяйте:

- ✅ Бэкапы создаются по расписанию
- ✅ Файлы не повреждены (можно распаковать)
- ✅ База данных в бэкапе полная
- ✅ Email уведомления приходят

---

## 🔐 Безопасность бэкапов

### Важно:

1. **Защитите доступ к бэкапам** - в них есть пароли и данные
2. **Шифруйте бэкапы** при передаче на внешние сервера
3. **Не храните бэкапы только локально** - при сбое сервера потеряете всё
4. **Тестируйте восстановление** раз в месяц

### Настройка шифрования (опционально):

В `config/backup.php`:

```php
'backup' => [
    'password' => env('BACKUP_PASSWORD'),
    'encryption' => 'default',
],
```

В `.env`:

```env
BACKUP_PASSWORD=your-strong-password-here
```

---

## 📝 Логи бэкапов

Логи сохраняются в `storage/logs/laravel.log`

Найти записи о бэкапах:

```bash
grep "backup" storage/logs/laravel.log
```

---

## ❓ FAQ

**Q: Сколько места занимают бэкапы?**  
A: Примерно 20-100 MB за один бэкап. За 7 дней ~200-700 MB.

**Q: Можно ли делать бэкап только БД?**  
A: Да! `php artisan backup:run --only-db`

**Q: Можно ли делать бэкап только файлов?**  
A: Да! `php artisan backup:run --only-files`

**Q: Как часто делать бэкапы?**  
A: Рекомендуется ежедневно в ночное время (3-4 AM).

**Q: Что делать если бэкап не создается?**  
A: Проверьте:
  1. Права на запись в `storage/app/`
  2. Лог файл `storage/logs/laravel.log`
  3. Настройки MySQL (доступ для mysqldump)

---

## 🎯 Рекомендации

### Для локальной разработки:
- ✅ Бэкапы каждый день
- ✅ Хранить локально
- ✅ Очистка старше 7 дней

### Для production:
- ✅ Бэкапы каждый день
- ✅ Хранить локально + S3/Dropbox
- ✅ Email уведомления
- ✅ Очистка старше 30 дней
- ✅ Тестовое восстановление раз в месяц

---

**Бэкапы настроены и готовы к работе! 🎉**

**Следующий шаг:** Запустите `php artisan backup:run` чтобы создать первый бэкап.

