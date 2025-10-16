# 🚀 Быстрое руководство по развертыванию

Краткая версия для быстрого развертывания GreenPlant на REG.RU

---

## ⚡ За 10 минут

### 1. Подготовка (локально)

```bash
# Упакуйте проект
zip -r greenplant.zip . -x "*.git*" ".env" "node_modules/*" "storage/logs/*"
```

### 2. На сервере REG.RU

#### 2.1. Создайте БД
- Панель управления → Базы данных MySQL
- Создайте БД и пользователя
- Запишите: имя БД, пользователь, пароль

#### 2.2. Загрузите файлы
- Через FTP загрузите в `/domains/ваш-домен.ru/laravel/`
- Или распакуйте zip через панель управления

#### 2.3. Создайте .env

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
DB_PASSWORD=ваш_пароль

MAIL_MAILER=smtp
MAIL_HOST=smtp.reg.ru
MAIL_PORT=587
MAIL_USERNAME=ваш@email.ru
MAIL_PASSWORD=пароль_почты
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@ваш-домен.ru
MAIL_FROM_NAME="GreenPlant"

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=database
LOG_CHANNEL=daily
LOG_LEVEL=error
```

### 3. Выполните команды (SSH)

```bash
# Перейдите в папку
cd /home/u1234567/domains/ваш-домен.ru/laravel

# Установите зависимости
composer install --optimize-autoloader --no-dev

# Генерация ключа
php artisan key:generate

# Права доступа
chmod -R 775 storage bootstrap/cache

# БД
php artisan migrate --force
php artisan db:seed --class=RoleSeeder --force
php artisan db:seed --class=CustomerRoleSeeder --force
php artisan db:seed --class=RecreateAdminSeeder --force

# Симлинк
php artisan storage:link

# Оптимизация
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### 4. Настройте домен

**Вариант А: Symlink**
```bash
rm -rf /home/u1234567/domains/ваш-домен.ru/public_html
ln -s /home/u1234567/domains/ваш-домен.ru/laravel/public /home/u1234567/domains/ваш-домен.ru/public_html
```

**Вариант Б**: В панели управления укажите корневую папку на `/laravel/public`

### 5. Настройте Cron

Панель → Cron задачи:
```
* * * * * cd /home/u1234567/domains/ваш-домен.ru/laravel && php artisan schedule:run >> /dev/null 2>&1
```

### 6. Проверьте

- ✅ Откройте https://ваш-домен.ru
- ✅ Войдите в админку: https://ваш-домен.ru/admin
  - Email: `admin@greenplant.ru`
  - Пароль: `password` (ИЗМЕНИТЕ!)
- ✅ Проверьте отправку email (форма обратной связи)

---

## 🔧 Без SSH (альтернатива)

Если SSH недоступен:

1. **Установите зависимости локально**:
   ```bash
   composer install --optimize-autoloader --no-dev
   ```

2. **Загрузите все включая `vendor/`** через FTP

3. **Создайте `.env` через панель управления**

4. **Создайте БД через phpMyAdmin**:
   - Экспортируйте схему локально
   - Импортируйте через phpMyAdmin

5. **Cron** настройте через панель

---

## ⚠️ Важные проверки

### Перед запуском
- [ ] `APP_ENV=production`
- [ ] `APP_DEBUG=false`
- [ ] Пароль админа изменен
- [ ] SSL сертификат установлен
- [ ] Email работает

### После запуска
- [ ] Главная страница открывается
- [ ] Админка доступна
- [ ] Изображения отображаются
- [ ] Формы работают
- [ ] Email отправляются

---

## 📞 Помощь

**Полная документация**: [DEPLOYMENT_REGRU_GUIDE.md](DEPLOYMENT_REGRU_GUIDE.md)

**Checklist**: [PRODUCTION_CHECKLIST.md](PRODUCTION_CHECKLIST.md)

**Оптимизация**: [PRODUCTION_OPTIMIZATION.md](PRODUCTION_OPTIMIZATION.md)

**Поддержка REG.RU**: 8 800 505-06-06

---

## 🔄 Обновление сайта

```bash
cd /home/u1234567/domains/ваш-домен.ru/laravel

# Загрузите новые файлы через FTP или git pull

# Затем:
php artisan migrate --force
php artisan optimize:clear
php artisan optimize
```

---

**Время развертывания**: ~10-15 минут  
**Сложность**: ⭐⭐☆☆☆

**Удачи! 🚀**

