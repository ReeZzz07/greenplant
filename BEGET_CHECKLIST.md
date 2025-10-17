# ✅ Чек-лист по исправлению ошибок на Beget.com

## Что нужно сделать прямо сейчас

### 1️⃣ Подключитесь к серверу через SSH

```bash
ssh ваш-логин@ваш-логин.beget.tech
```

📖 **Не знаете как?** → Читайте `docs/BEGET_SSH_CONNECTION.md`

---

### 2️⃣ Перейдите в папку сайта

```bash
cd ~/ваш-домен.com/public_html
```

---

### 3️⃣ Выполните команды исправления

**Вариант А: Автоматический скрипт** (рекомендуется)
```bash
bash fix-beget-errors.sh
```

**Вариант Б: Вручную** (скопируйте все команды разом)
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan migrate --force
php artisan db:seed --class=SliderSeeder --force
php artisan db:seed --class=HomePageFeatureSeeder --force
php artisan db:seed --class=HomePageGallerySeeder --force
php artisan db:seed --class=HomePageSectionTitleSeeder --force
php artisan db:seed --class=AddHomePageHeroSettingsSeeder --force
php artisan storage:link
chmod -R 775 storage bootstrap/cache
chmod -R 777 storage/logs
php artisan config:cache
php artisan route:cache
```

---

### 4️⃣ Проверьте результат

Откройте в браузере:
- ✅ Главная страница: `https://ваш-домен.com/`
- ✅ Админка: `https://ваш-домен.com/admin`
- ✅ Настройки Hero: `https://ваш-домен.com/admin/hero-settings`
- ✅ Заголовки секций: `https://ваш-домен.com/admin/home-page-section-titles`

---

## 🔍 Если всё ещё есть ошибки

### Посмотрите логи:
```bash
tail -50 storage/logs/laravel.log
```

### Проверьте .env файл:
```bash
cat .env | grep -E "APP_|DB_"
```

Должно быть примерно так:
```
APP_NAME="Green Plant"
APP_ENV=production
APP_KEY=base64:длинная_строка_ключа
APP_DEBUG=false
APP_URL=https://ваш-домен.com
DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE=имя_базы
DB_USERNAME=пользователь
DB_PASSWORD=пароль
```

### Временно включите отладку:
```bash
nano .env
# Измените APP_DEBUG=false на APP_DEBUG=true
# Сохраните: Ctrl+O, Enter, Ctrl+X
php artisan config:clear
```

Откройте сайт - увидите детальную ошибку.

**⚠️ ВАЖНО:** После диагностики верните `APP_DEBUG=false`!

---

## 📋 Контрольный список

Отметьте выполненные пункты:

- [ ] SSH подключение работает
- [ ] Перешел в папку сайта (`cd ~/домен.com/public_html`)
- [ ] Очистил кэш (`php artisan cache:clear` и т.д.)
- [ ] Выполнил миграции (`php artisan migrate --force`)
- [ ] Запустил сидеры (SliderSeeder, HomePageFeatureSeeder и т.д.)
- [ ] Создал симлинк storage (`php artisan storage:link`)
- [ ] Установил права (`chmod -R 775 storage`)
- [ ] Пересоздал кэш конфигурации (`php artisan config:cache`)
- [ ] Проверил главную страницу - работает ✅
- [ ] Проверил админку - работает ✅
- [ ] Проверил настройки Hero - сохраняются ✅
- [ ] Проверил заголовки секций - открываются ✅

---

## 🆘 Нужна помощь?

### Документация:
- 📘 **Быстрое решение:** `BEGET_QUICK_FIX.md`
- 📙 **Полное руководство:** `docs/BEGET_DEPLOYMENT_GUIDE.md`
- 📗 **SSH подключение:** `docs/BEGET_SSH_CONNECTION.md`

### Поддержка Beget:
- 📧 Email: support@beget.com
- 📞 Телефон: +7 (495) 721-80-88
- 💬 Онлайн-чат: https://cp.beget.com/

---

## ⏱️ Сколько времени это займет?

- **Опытный пользователь:** 5 минут
- **Новичок:** 15-20 минут

---

## 💡 Совет

Если что-то пошло не так, не паникуйте! Все можно исправить. Просмотрите логи, они подскажут точную проблему.

**Удачи! 🍀**

