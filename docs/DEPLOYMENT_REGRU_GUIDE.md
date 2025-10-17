# 🚀 Полное руководство по развертыванию на REG.RU

**Проект:** GreenPlant  
**Хостинг:** REG.RU  
**Дата:** Октябрь 2025

---

## 📋 Содержание

1. [Требования](#требования)
2. [Подготовка проекта](#подготовка-проекта)
3. [Настройка хостинга REG.RU](#настройка-хостинга-regru)
4. [Загрузка файлов](#загрузка-файлов)
5. [Настройка окружения](#настройка-окружения)
6. [Настройка базы данных](#настройка-базы-данных)
7. [Финальная конфигурация](#финальная-конфигурация)
8. [Проверка работы](#проверка-работы)
9. [Решение проблем](#решение-проблем)
10. [Обновление сайта](#обновление-сайта)

---

## 🔧 Требования

### Минимальные требования хостинга:

- ✅ **PHP**: 8.1 или выше (рекомендуется 8.2)
- ✅ **MySQL**: 5.7 или выше (или MariaDB 10.3+)
- ✅ **Память PHP**: минимум 128MB (рекомендуется 256MB)
- ✅ **Расширения PHP**:
  - OpenSSL
  - PDO
  - Mbstring
  - Tokenizer
  - XML
  - Ctype
  - JSON
  - BCMath
  - GD или Imagick (для работы с изображениями)
  - Fileinfo
- ✅ **SSH доступ**: желательно (для Artisan команд)
- ✅ **Composer**: доступен через SSH или установлен локально

### Рекомендуемый тариф REG.RU:

- **Хостинг Linux "Профессиональный"** или выше
- Причины:
  - SSH доступ
  - Достаточно ресурсов (память, CPU)
  - Composer установлен
  - Возможность настройки Cron

---

## 📦 Подготовка проекта

### 1. Проверка локальной версии

Убедитесь, что проект работает локально без ошибок:

```bash
# Запустите тесты
php artisan test

# Проверьте логи
tail -n 50 storage/logs/laravel.log

# Очистите кеши
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### 2. Удаление ненужных файлов

Создайте чистую копию проекта без dev-зависимостей:

```bash
# Установите production зависимости
composer install --optimize-autoloader --no-dev

# Удалите node_modules если есть
rm -rf node_modules

# Убедитесь что .env не будет загружен
# Он должен быть в .gitignore
```

### 3. Подготовка архива для загрузки

```bash
# Создайте архив проекта (без .git, node_modules, vendor)
zip -r greenplant.zip . -x "*.git*" "node_modules/*" ".env" "storage/logs/*"
```

**Альтернатива**: используйте Git для развертывания (если хостинг поддерживает).

---

## ⚙️ Настройка хостинга REG.RU

### 1. Вход в панель управления

1. Откройте [https://www.reg.ru/](https://www.reg.ru/)
2. Войдите в личный кабинет
3. Перейдите в раздел **"Хостинг и VPS"**
4. Выберите ваш хостинг

### 2. Настройка PHP версии

1. В панели управления найдите **"Управление версиями PHP"**
2. Выберите **PHP 8.1** или **PHP 8.2**
3. Сохраните изменения
4. Проверьте что включены необходимые расширения:
   - OpenSSL
   - PDO
   - Mbstring
   - XML
   - GD/Imagick
   - Fileinfo

### 3. Создание базы данных MySQL

1. Перейдите в **"Базы данных MySQL"**
2. Нажмите **"Создать базу данных"**
3. Укажите:
   - **Имя БД**: `u1234567_greenplant` (пример)
   - **Кодировка**: `utf8mb4_unicode_ci`
4. Создайте пользователя БД:
   - **Имя**: `u1234567_user` (пример)
   - **Пароль**: Сложный пароль (сохраните!)
5. Назначьте пользователю все права на БД
6. **Запишите**:
   - Имя БД
   - Имя пользователя
   - Пароль
   - Хост (обычно `localhost`)

### 4. Настройка доменаПапки

Определите структуру папок на сервере:

```
/home/u1234567/
  └── domains/
      └── ваш-домен.ru/
          ├── public_html/ (корневая папка сайта)
          └── laravel/       (сюда загрузим Laravel)
```

**ВАЖНО**: Laravel должен быть **выше** корневой папки сайта!

---

## 📤 Загрузка файлов

### Способ 1: FTP/SFTP (проще)

#### Через FileZilla или другой FTP-клиент:

1. **Подключитесь к серверу**:
   - **Хост**: FTP адрес из панели REG.RU
   - **Пользователь**: ваш логин хостинга
   - **Пароль**: пароль хостинга
   - **Порт**: 21 (FTP) или 22 (SFTP)

2. **Создайте структуру папок**:
   ```
   /home/u1234567/domains/ваш-домен.ru/laravel/
   ```

3. **Загрузите все файлы проекта** в `/laravel/`:
   - app/
   - bootstrap/
   - config/
   - database/
   - public/
   - resources/
   - routes/
   - storage/
   - composer.json
   - artisan
   - и т.д.

4. **Настройте символическую ссылку** (через SSH или панель):
   ```bash
   # Удалите старую public_html если есть
   rm -rf /var/u3275574/data/www/g-plant.ru/public_html
   
   # Создайте symlink на Laravel public
   ln -s /var/u3275574/data/www/g-plant.ru/laravel/public /var/u3275574/data/www/g-plant.ru/public_html
   ```

   **Если SSH недоступен**, используйте панель управления файлами REG.RU.

### Способ 2: SSH + Git (для опытных)

```bash
# Подключитесь по SSH
ssh u1234567@ваш-домен.ru

# Перейдите в папку
cd /home/u1234567/domains/ваш-домен.ru/

# Клонируйте репозиторий
git clone https://github.com/ReeZzz07/greenplant.git laravel

# Перейдите в папку проекта
cd laravel

# Установите зависимости
composer install --optimize-autoloader --no-dev
```

---

## 🔐 Настройка окружения

### 1. Создание файла .env

**Через SSH**:

```bash
cd /home/u1234567/domains/ваш-домен.ru/laravel
nano .env
```

**Или через FTP**: создайте файл `.env` и загрузите на сервер.

### 2. Заполнение .env

Используйте шаблон из `docs/ENV_PRODUCTION_TEMPLATE.md`:

```env
APP_NAME="GreenPlant"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://ваш-домен.ru

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=u1234567_greenplant
DB_USERNAME=u1234567_user
DB_PASSWORD=ваш_пароль_от_бд

MAIL_MAILER=smtp
MAIL_HOST=smtp.reg.ru
MAIL_PORT=587
MAIL_USERNAME=ваш@email.ru
MAIL_PASSWORD=пароль_от_почты
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@ваш-домен.ru
MAIL_FROM_NAME="GreenPlant"

# ... остальные настройки
```

### 3. Генерация APP_KEY

**Через SSH**:

```bash
php artisan key:generate
```

**Без SSH**: сгенерируйте локально и скопируйте в .env на сервере.

---

## 🗄️ Настройка базы данных

### 1. Импорт структуры БД

**Через SSH**:

```bash
cd /home/u1234567/domains/ваш-домен.ru/laravel

# Запустите миграции
php artisan migrate --force
```

**Без SSH**: используйте phpMyAdmin в панели REG.RU:
1. Экспортируйте БД локально: `php artisan migrate --pretend > schema.sql`
2. Импортируйте через phpMyAdmin

### 2. Заполнение начальными данными

```bash
# Роли и разрешения
php artisan db:seed --class=RoleSeeder --force
php artisan db:seed --class=CustomerRoleSeeder --force

# Создание администратора
php artisan db:seed --class=RecreateAdminSeeder --force
```

**Данные администратора** (из seeder):
- Email: `admin@greenplant.ru`
- Пароль: `password` (ИЗМЕНИТЕ после первого входа!)

### 3. Импорт контента (опционально)

Если у вас есть контент с локального сайта:

```bash
# Экспортируйте локальную БД
mysqldump -u root -p greenplant > backup.sql

# Импортируйте на сервер через phpMyAdmin
# Или через SSH:
mysql -u u1234567_user -p u1234567_greenplant < backup.sql
```

---

## ⚡ Финальная конфигурация

### 1. Установка прав доступа

```bash
# Через SSH
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Убедитесь что owner правильный
chown -R u3275574:u3275574 storage
chown -R u3275574:u3275574 bootstrap/cache
```

**Через FTP**: установите права 755 или 775 на:
- `storage/`
- `storage/app/`
- `storage/framework/`
- `storage/logs/`
- `bootstrap/cache/`

### 2. Создание символической ссылки storage

```bash
php artisan storage:link
```

Это создаст `public/storage` -> `storage/app/public`.

### 3. Оптимизация для production

```bash
# Кеширование конфигурации
php artisan config:cache

# Кеширование маршрутов
php artisan route:cache

# Кеширование представлений
php artisan view:cache

# Общая оптимизация
php artisan optimize
```

### 4. Настройка .htaccess

Убедитесь что в `public/.htaccess` есть:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    
    # Force HTTPS
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}/$1 [R=301,L]
    
    # ... остальные правила
</IfModule>
```

Если нужно, скопируйте `public/.htaccess.production` в `public/.htaccess`.

### 5. Настройка Cron задач

В панели управления REG.RU:

1. Перейдите в **"Планировщик задач (Cron)"**
2. Добавьте новую задачу:
   - **Период**: Каждую минуту (`* * * * *`)
   - **Команда**:
     ```bash
     cd /var/www/u3275574/data/www/g-plant/ && php artisan schedule:run >> /dev/null 2>&1
     ```
3. Сохраните

Это необходимо для автоматических бэкапов и других задач по расписанию.

### 6. Настройка SSL сертификата

1. В панели REG.RU перейдите в **"SSL сертификаты"**
2. Выпустите бесплатный **Let's Encrypt** сертификат для вашего домена
3. Активируйте его
4. Проверьте что `APP_URL` в `.env` использует `https://`

---

## ✅ Проверка работы

### 1. Проверка главной страницы

Откройте `https://ваш-домен.ru`

**Ожидаемый результат**: главная страница сайта GreenPlant

**Если ошибка 500**:
- Проверьте логи: `storage/logs/laravel.log`
- Проверьте права на `storage/` и `bootstrap/cache/`
- Проверьте `.env` (особенно `APP_KEY`)

### 2. Проверка админ-панели

Откройте `https://ваш-домен.ru/admin`

**Ожидаемый результат**: страница входа в админку

**Войдите**:
- Email: `admin@greenplant.ru`
- Пароль: `password`

**После входа**: сразу смените пароль в профиле!

### 3. Проверка изображений

Откройте любой товар с изображением.

**Если изображения не отображаются**:
```bash
php artisan storage:link
chmod -R 775 storage/app/public
```

### 4. Проверка email

Создайте тестовый заказ и проверьте приходит ли email.

**Если email не приходят**:
- Проверьте `MAIL_*` настройки в `.env`
- Проверьте логи: `storage/logs/laravel.log`
- Убедитесь что почтовый ящик существует на REG.RU

### 5. Проверка форм

Протестируйте:
- ✅ Форму обратной связи
- ✅ Оформление заказа
- ✅ Регистрацию пользователя
- ✅ Вход/выход

---

## 🐛 Решение проблем

### Ошибка 500 - Internal Server Error

**Причины и решения:**

1. **Неправильные права доступа**:
   ```bash
   chmod -R 775 storage
   chmod -R 775 bootstrap/cache
   ```

2. **Отсутствует APP_KEY**:
   ```bash
   php artisan key:generate
   ```

3. **Ошибка в .env**:
   - Проверьте синтаксис
   - Убедитесь что все обязательные поля заполнены

4. **Проверьте логи**:
   ```bash
   tail -n 50 storage/logs/laravel.log
   ```

### Ошибка 404 - Not Found

**Причины:**

1. **public_html не указывает на Laravel public**:
   - Проверьте символическую ссылку
   - Или измените корневую папку в панели управления

2. **mod_rewrite не включен**:
   - Обратитесь в поддержку REG.RU
   - Обычно включен по умолчанию

### База данных не подключается

**Проверьте:**

1. **Данные подключения в .env**:
   - `DB_HOST` (обычно `localhost`)
   - `DB_DATABASE` (имя БД)
   - `DB_USERNAME` (пользователь БД)
   - `DB_PASSWORD` (пароль)

2. **Права пользователя БД**:
   - В phpMyAdmin проверьте что пользователь имеет все права

3. **Запустите тест подключения**:
   ```bash
   php artisan tinker
   >>> DB::connection()->getPdo();
   ```

### Изображения не загружаются

**Решение:**

```bash
# Создайте symlink
php artisan storage:link

# Установите права
chmod -R 775 storage/app/public

# Проверьте что папка существует
ls -la public/storage
```

### Email не отправляются

**Проверьте:**

1. **Настройки SMTP в .env**:
   ```env
   MAIL_HOST=smtp.reg.ru
   MAIL_PORT=587
   MAIL_USERNAME=полный@email.ru
   MAIL_PASSWORD=правильный_пароль
   MAIL_ENCRYPTION=tls
   ```

2. **Отправьте тестовое письмо**:
   ```bash
   php artisan tinker
   >>> Mail::raw('Test', function($msg) { $msg->to('test@example.com')->subject('Test'); });
   ```

3. **Проверьте логи**:
   ```bash
   tail -n 50 storage/logs/laravel.log
   ```

### Проблемы с Composer

**Если Composer недоступен через SSH**:

1. Установите зависимости локально:
   ```bash
   composer install --optimize-autoloader --no-dev
   ```

2. Загрузите папку `vendor/` на сервер через FTP

**Внимание**: Загрузка `vendor/` может занять много времени из-за количества файлов.

---

## 🔄 Обновление сайта

### Автоматизированное обновление (через SSH)

Используйте скрипт `deploy.sh`:

```bash
# Подключитесь по SSH
ssh u1234567@ваш-домен.ru

# Перейдите в папку проекта
cd /home/u1234567/domains/ваш-домен.ru/laravel

# Загрузите изменения (если используете Git)
git pull origin main

# Запустите deployment скрипт
bash deploy.sh
```

Скрипт автоматически:
- ✅ Установит зависимости
- ✅ Выполнит миграции
- ✅ Очистит кеши
- ✅ Создаст новые кеши
- ✅ Установит права доступа

### Ручное обновление (через FTP)

1. **Создайте резервную копию**:
   - Скачайте папку `laravel/` на локальный компьютер
   - Сделайте backup БД через phpMyAdmin

2. **Загрузите новые файлы**:
   - Загрузите измененные файлы через FTP
   - **НЕ** перезаписывайте `.env`!

3. **Обновите БД** (если есть новые миграции):
   ```bash
   php artisan migrate --force
   ```

4. **Очистите кеши**:
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan route:clear
   php artisan view:clear
   php artisan optimize
   ```

---

## 📊 Мониторинг и поддержка

### Регулярное обслуживание

**Еженедельно**:
- ✅ Проверяйте логи ошибок: `storage/logs/laravel.log`
- ✅ Проверяйте работу бэкапов
- ✅ Мониторьте место на диске

**Ежемесячно**:
- ✅ Обновляйте зависимости Composer
- ✅ Проверяйте обновления Laravel
- ✅ Анализируйте статистику посещений

### Резервное копирование

**Автоматические бэкапы** настроены через `spatie/laravel-backup`:

- Выполняются ежедневно (через Cron)
- Сохраняются в `storage/app/backups/`
- Email уведомления на `BACKUP_NOTIFICATION_EMAIL`

**Ручной бэкап**:

```bash
# Через SSH
php artisan backup:run

# Через phpMyAdmin (только БД)
# Экспорт -> Сохранить
```

**Скачайте бэкапы** с сервера регулярно!

### Логи и мониторинг

**Просмотр логов**:

```bash
# Последние ошибки
tail -n 100 storage/logs/laravel.log

# Логи в реальном времени
tail -f storage/logs/laravel.log
```

**Очистка старых логов**:

```bash
# Удалить логи старше 30 дней
find storage/logs -type f -name "*.log" -mtime +30 -delete
```

---

## 📞 Поддержка

### Контакты REG.RU

- **Телефон**: 8 800 505-06-06
- **Email**: support@reg.ru
- **Чат**: в личном кабинете
- **Документация**: [help.reg.ru](https://help.reg.ru)

### Полезные ссылки

- [Документация Laravel](https://laravel.com/docs)
- [FAQ REG.RU по хостингу](https://help.reg.ru/hosting)
- [Настройка PHP на REG.RU](https://help.reg.ru/hosting/php)
- [Работа с SSH на REG.RU](https://help.reg.ru/hosting/ssh)

---

## ✅ Checklist финальной проверки

Перед открытием сайта для публики проверьте:

### Безопасность
- [ ] `APP_ENV=production` в .env
- [ ] `APP_DEBUG=false` в .env
- [ ] Сложный пароль администратора
- [ ] SSL сертификат установлен и работает
- [ ] `.env` файл защищен (не доступен публично)
- [ ] `storage/` и `bootstrap/cache/` не доступны публично

### Функциональность
- [ ] Главная страница загружается
- [ ] Админ-панель доступна и работает
- [ ] Изображения отображаются
- [ ] Форма обратной связи отправляет email
- [ ] Оформление заказа работает
- [ ] Email уведомления приходят
- [ ] Регистрация пользователей работает
- [ ] Корзина функционирует

### Производительность
- [ ] Кеши созданы (`config:cache`, `route:cache`, `view:cache`)
- [ ] Сжатие gzip включено
- [ ] Кеширование браузера настроено
- [ ] Изображения оптимизированы

### SEO
- [ ] Robots.txt настроен
- [ ] Sitemap.xml создан и доступен
- [ ] Meta-теги заполнены
- [ ] Google Analytics подключен
- [ ] Яндекс.Метрика подключена

### Резервное копирование
- [ ] Cron задача настроена
- [ ] Тестовый бэкап выполнен
- [ ] Email уведомления о бэкапах приходят

---

**Дата создания**: 16 октября 2025  
**Версия документа**: 1.0  
**Автор**: GreenPlant Development Team

**Удачного развертывания! 🚀**

