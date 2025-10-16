# Инструкция по установке GreenPlant CMS

## Быстрый старт

### 1. Установка зависимостей

```bash
composer install
```

Если у вас не установлен Composer, скачайте его с https://getcomposer.org/

### 2. Настройка базы данных

Создайте базу данных MySQL с именем `greenplant`:

```sql
CREATE DATABASE greenplant CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Или через PHPMyAdmin/Adminer.

### 3. Настройка окружения

Файл `.env` уже создан. Проверьте настройки подключения к БД:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=greenplant
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Генерация ключа приложения

```bash
php artisan key:generate
```

### 5. Запуск миграций и заполнение БД

```bash
php artisan migrate --seed
```

Эта команда создаст все необходимые таблицы и заполнит их тестовыми данными.

### 6. Создание символической ссылки для загрузок

```bash
php artisan storage:link
```

### 7. Запуск сервера разработки

```bash
php artisan serve
```

Сайт будет доступен по адресу: http://localhost:8000

## Доступ к админ-панели

URL: http://localhost:8000/admin

### Учетные данные администратора:
- **Email:** admin@greenplant.ru
- **Пароль:** admin123

### Учетные данные контент-менеджера:
- **Email:** manager@greenplant.ru
- **Пароль:** manager123

## Что уже создано

### Модели данных:
- ✅ User (пользователи с ролями)
- ✅ Product (товары - туи)
- ✅ Category (категории товаров)
- ✅ BlogPost (статьи блога)
- ✅ Testimonial (отзывы клиентов)
- ✅ Setting (настройки сайта)

### Роли и разрешения:
- ✅ **Администратор** - полный доступ ко всем функциям
- ✅ **Контент-менеджер** - управление товарами, блогом, отзывами

### База данных:
- ✅ 5 категорий туи
- ✅ 8 товаров (сорта туи) с подробными описаниями
- ✅ 5 отзывов клиентов
- ✅ Настройки сайта (телефон, email, адрес и т.д.)

## Следующие шаги

Необходимо создать:
1. Контроллеры для админ-панели
2. Представления (Views) для админки
3. Контроллеры для фронтенда
4. Интеграция существующего HTML шаблона с Laravel

## Структура проекта

```
g-plant.local/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/          # Контроллеры админки
│   │   └── Frontend/       # Контроллеры фронтенда
│   ├── Models/             # Модели данных
│   └── Providers/          # Сервис-провайдеры
├── database/
│   ├── migrations/         # Миграции БД
│   └── seeders/            # Сидеры для наполнения БД
├── routes/
│   ├── web.php            # Веб-маршруты
│   ├── api.php            # API-маршруты
│   └── console.php        # Консольные команды
├── resources/
│   └── views/             # Blade-шаблоны (нужно создать)
├── public/                # Публичные файлы
├── assets/                # Текущий HTML шаблон
└── docs/                  # Документация
```

## Возможные проблемы

### Ошибка подключения к БД
Проверьте, что MySQL запущен и настройки в `.env` верны.

### Class not found
Выполните:
```bash
composer dump-autoload
```

### Permission denied для storage
В Windows обычно не требуется, но если возникают проблемы:
```bash
icacls storage /grant Users:F /t
icacls bootstrap/cache /grant Users:F /t
```

## Полезные команды

```bash
# Очистка кэша
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Пересоздание БД (осторожно, удалит все данные!)
php artisan migrate:fresh --seed

# Создание нового контроллера
php artisan make:controller Admin/ProductController --resource

# Создание новой модели с миграцией
php artisan make:model ModelName -m
```

## Поддержка

При возникновении вопросов обращайтесь к документации Laravel: https://laravel.com/docs/10.x

