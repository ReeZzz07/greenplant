# 🚀 GreenPlant Deployment Cheatsheet

**Распечатайте для удобства**

---

## 📋 Pre-Deployment Checklist

### Критичные настройки .env
```env
APP_ENV=production
APP_DEBUG=false           ← ОБЯЗАТЕЛЬНО!
APP_URL=https://ваш-домен.ru

DB_DATABASE=u1234567_greenplant
DB_USERNAME=u1234567_user
DB_PASSWORD=***

MAIL_HOST=smtp.reg.ru
MAIL_PORT=587
MAIL_ENCRYPTION=tls
```

---

## 🔑 Команды развертывания (SSH)

```bash
# 1. Установка зависимостей
composer install --optimize-autoloader --no-dev

# 2. Генерация ключа
php artisan key:generate

# 3. Права доступа
chmod -R 775 storage bootstrap/cache

# 4. База данных
php artisan migrate --force
php artisan db:seed --class=RoleSeeder --force
php artisan db:seed --class=CustomerRoleSeeder --force
php artisan db:seed --class=RecreateAdminSeeder --force

# 5. Storage link
php artisan storage:link

# 6. Кеширование
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

---

## 🔄 Команды обновления

```bash
# Очистка кешей
php artisan optimize:clear

# Обновление
git pull origin main
composer install --no-dev

# Миграции (если есть)
php artisan migrate --force

# Новые кеши
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

---

## 🗄️ Создание БД в REG.RU

1. **Панель управления** → **Базы данных MySQL**
2. **Создать базу данных**
   - Имя: `u1234567_greenplant`
   - Кодировка: `utf8mb4_unicode_ci`
3. **Создать пользователя**
   - Имя: `u1234567_user`
   - Пароль: (сложный!)
4. **Назначить права**: ВСЕ

---

## 📧 Email настройки

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.reg.ru
MAIL_PORT=587
MAIL_USERNAME=полный@email.ru
MAIL_PASSWORD=***
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@домен.ru
```

**Проверка**:
```bash
php artisan tinker
Mail::raw('Test', fn($m) => $m->to('test@test.ru')->subject('Test'));
```

---

## ⏰ Cron задача

**Панель → Планировщик задач (Cron)**

```
* * * * * cd /home/u1234567/domains/ваш-домен.ru/laravel && php artisan schedule:run >> /dev/null 2>&1
```

---

## 🔗 Настройка public_html

### Вариант 1: Symlink (SSH)
```bash
rm -rf public_html
ln -s /home/.../laravel/public public_html
```

### Вариант 2: Панель управления
Установите корневую папку: `/laravel/public`

---

## 🔐 Данные администратора

**После первого seeder**:
- URL: `https://ваш-домен.ru/admin`
- Email: `admin@greenplant.ru`
- Пароль: `password`

**⚠️ СРАЗУ ИЗМЕНИТЕ ПАРОЛЬ!**

---

## 🐛 Решение проблем

### 500 Internal Server Error
```bash
chmod -R 775 storage bootstrap/cache
php artisan key:generate
tail -n 50 storage/logs/laravel.log
```

### Изображения не отображаются
```bash
php artisan storage:link
chmod -R 775 storage/app/public
```

### База данных не подключается
- Проверьте данные в .env
- Проверьте права пользователя в phpMyAdmin

### Email не отправляются
- Проверьте MAIL_* в .env
- Убедитесь что email существует
- Проверьте логи: `storage/logs/laravel.log`

---

## ✅ Quick Checklist

- [ ] `APP_DEBUG=false`
- [ ] `APP_ENV=production`
- [ ] APP_KEY сгенерирован
- [ ] БД создана и подключена
- [ ] Миграции выполнены
- [ ] Seeders запущены
- [ ] Storage link создан
- [ ] Права доступа установлены
- [ ] Кеши созданы
- [ ] Cron задача настроена
- [ ] SSL сертификат установлен
- [ ] Email работает
- [ ] Админ пароль изменен

---

## 📞 Поддержка

**REG.RU**: 8 800 505-06-06

**Документация**:
- `docs/DEPLOYMENT_REGRU_GUIDE.md` - полное руководство
- `docs/PRODUCTION_CHECKLIST.md` - 114 проверок
- `docs/QUICK_DEPLOY_GUIDE.md` - за 10 минут

---

## 🎯 Ожидаемые результаты

- Главная страница: **< 2 сек**
- PageSpeed Insights: **85-95**
- SSL Labs: **Grade A**

---

**Версия**: 2.4.0  
**Дата**: 16.10.2025

