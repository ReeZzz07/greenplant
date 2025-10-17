# Руководство по развертыванию на Beget.com

## Диагностика ошибок 500

### Шаг 1: Просмотр логов ошибок

На Beget.com логи находятся в:
```
/logs/php_errors.log
```

**Как просмотреть логи:**
1. Зайдите в Файловый менеджер на beget.com
2. Перейдите в папку `/logs/`
3. Откройте файл `php_errors.log`
4. Посмотрите последние строки - там будут детали ошибки

Или через SSH:
```bash
tail -50 /logs/php_errors.log
```

### Шаг 2: Проверка логов Laravel

Laravel логи находятся в:
```
/storage/logs/laravel.log
```

Просмотр последних 100 строк через SSH:
```bash
tail -100 storage/logs/laravel.log
```

## Решение типичных проблем

### Проблема 1: Таблицы базы данных не созданы

**Симптомы:** 
- Ошибки типа "Table doesn't exist"
- Ошибки на главной странице и в админке

**Решение:**

1. Подключитесь к хостингу через SSH
2. Перейдите в корневую папку сайта:
```bash
cd ~/your-domain.com/public_html
```

3. Выполните миграции:
```bash
php artisan migrate --force
```

### Проблема 2: Таблицы пустые (нет начальных данных)

**Симптомы:**
- Главная страница показывает 500 ошибку
- Страницы настроек в админке не работают

**Решение:**

Выполните сидеры для создания необходимых записей:

```bash
# Основные сидеры
php artisan db:seed --force

# Или отдельные сидеры
php artisan db:seed --class=HomePageSectionTitleSeeder --force
php artisan db:seed --class=SliderSeeder --force
php artisan db:seed --class=HomePageFeatureSeeder --force
```

### Проблема 3: Права доступа к папкам

**Решение:**

Установите правильные права:
```bash
chmod -R 775 storage bootstrap/cache
chmod -R 777 storage/logs
```

### Проблема 4: Не создана символическая ссылка storage

**Симптомы:**
- Изображения не загружаются
- Ошибки при загрузке файлов в админке

**Решение:**
```bash
php artisan storage:link
```

### Проблема 5: Кэш конфигурации

**Решение:**

Очистите весь кэш:
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

Затем пересоздайте кэш конфигурации:
```bash
php artisan config:cache
php artisan route:cache
```

### Проблема 6: Неправильный .env файл

**Проверьте настройки в .env:**

```env
APP_NAME="Green Plant"
APP_ENV=production
APP_KEY=base64:ВАШ_КЛЮЧ_СГЕНЕРИРОВАННЫЙ_ARTISAN
APP_DEBUG=false
APP_URL=https://your-domain.com

# База данных Beget
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=имя_базы_данных
DB_USERNAME=имя_пользователя
DB_PASSWORD=пароль

# Email настройки Beget (если есть)
MAIL_MAILER=smtp
MAIL_HOST=smtp.beget.com
MAIL_PORT=465
MAIL_USERNAME=your-email@your-domain.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=your-email@your-domain.com
MAIL_FROM_NAME="${APP_NAME}"
```

**ВАЖНО:** Если вы изменили .env, выполните:
```bash
php artisan config:clear
php artisan config:cache
```

## Полная последовательность развертывания на Beget

### 1. Загрузка файлов

Загрузите все файлы проекта в папку:
```
/your-domain.com/public_html/
```

**Структура должна быть:**
```
public_html/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/         (содержимое этой папки - корень сайта)
│   ├── index.php
│   ├── .htaccess
│   └── assets/
├── resources/
├── routes/
├── storage/
├── vendor/
├── .env
└── artisan
```

### 2. Настройка Document Root

В панели Beget установите Document Root:
```
/your-domain.com/public_html/public
```

### 3. Создание базы данных

1. В панели Beget создайте базу данных MySQL
2. Запомните: имя базы, имя пользователя, пароль

### 4. Настройка .env файла

Создайте файл `.env` в корне проекта (на уровне с `artisan`):
```bash
cp .env.example .env
```

Отредактируйте его (см. раздел "Проблема 6" выше)

### 5. Установка зависимостей

```bash
composer install --no-dev --optimize-autoloader
```

### 6. Генерация ключа приложения

```bash
php artisan key:generate
```

### 7. Выполнение миграций

```bash
php artisan migrate --force
```

### 8. Заполнение базы начальными данными

```bash
php artisan db:seed --force
```

### 9. Создание символической ссылки

```bash
php artisan storage:link
```

### 10. Настройка прав доступа

```bash
chmod -R 775 storage bootstrap/cache
chmod -R 777 storage/logs
```

### 11. Оптимизация для production

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Специфика Beget.com

### SSH доступ

1. В панели управления включите SSH доступ
2. Данные для подключения:
   - Хост: your-login.beget.tech
   - Порт: 22
   - Логин: ваш логин от beget
   - Пароль: ваш пароль от beget

### Версия PHP

Beget поддерживает разные версии PHP. Проверьте текущую версию:
```bash
php -v
```

Для переключения версии PHP используйте команду:
```bash
php80  # для PHP 8.0
php81  # для PHP 8.1
php82  # для PHP 8.2
```

### Composer на Beget

Composer установлен глобально, используйте:
```bash
composer --version
```

### Cron задачи (если нужны)

В панели Beget → Cron → Добавить задание:
```bash
* * * * * cd /home/your-login/your-domain.com/public_html && php artisan schedule:run >> /dev/null 2>&1
```

## Быстрое исправление текущих проблем

Выполните эти команды по порядку через SSH:

```bash
# 1. Перейдите в папку сайта
cd ~/your-domain.com/public_html

# 2. Очистите кэш
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 3. Проверьте миграции
php artisan migrate:status

# 4. Если таблицы не созданы, выполните миграции
php artisan migrate --force

# 5. Заполните таблицы начальными данными
php artisan db:seed --class=HomePageSectionTitleSeeder --force
php artisan db:seed --class=SliderSeeder --force
php artisan db:seed --class=HomePageFeatureSeeder --force
php artisan db:seed --class=HomePageGallerySeeder --force

# 6. Создайте символическую ссылку
php artisan storage:link

# 7. Установите права
chmod -R 775 storage bootstrap/cache
chmod -R 777 storage/logs

# 8. Пересоздайте кэш
php artisan config:cache
php artisan route:cache

# 9. Проверьте логи
tail -50 storage/logs/laravel.log
```

## Проверка работоспособности

После выполнения всех команд:

1. ✅ Главная страница должна открываться
2. ✅ Админ-панель должна работать
3. ✅ Настройки hero-секции должны сохраняться
4. ✅ Страница "Заголовки секций" должна открываться

## Если проблема не решена

1. **Проверьте логи Laravel:**
   ```bash
   tail -100 storage/logs/laravel.log
   ```

2. **Проверьте логи PHP:**
   ```bash
   tail -100 ~/logs/php_errors.log
   ```

3. **Включите режим отладки (ВРЕМЕННО):**
   Измените в `.env`:
   ```
   APP_DEBUG=true
   ```
   
   Затем:
   ```bash
   php artisan config:clear
   ```
   
   Откройте сайт в браузере - увидите детальную ошибку.
   
   **ВАЖНО:** После диагностики верните `APP_DEBUG=false`!

## Контакты поддержки Beget

- Email: support@beget.com
- Телефон: +7 (495) 721-80-88
- Онлайн-чат в панели управления

## Полезные ссылки

- Панель управления: https://cp.beget.com/
- База знаний Beget: https://beget.com/ru/kb
- Документация Laravel: https://laravel.com/docs

