# 🚀 НАЧНИТЕ ЗДЕСЬ - Исправление ошибок на Beget.com

## 🎯 Ваша проблема

- ❌ Главная страница - ошибка 500
- ❌ Настройки hero-секции не сохраняются
- ❌ Страница "Заголовки секций" не открывается

## ⚡ Решение за 5 минут

### Шаг 1: Подключитесь к серверу

Откройте PowerShell или CMD и выполните:

```bash
ssh ваш-логин@ваш-логин.beget.tech
```

Введите пароль от Beget.

❓ **Не знаете как подключиться?** → Читайте: `docs/BEGET_SSH_CONNECTION.md`

---

### Шаг 2: Перейдите в папку сайта

```bash
cd ~/ваш-домен.com/public_html
```

---

### Шаг 3: Получите последние обновления

```bash
git pull origin main
```

Это загрузит исправленные файлы с сервера.

---

### Шаг 4: Выполните исправления

Скопируйте и вставьте ВСЕ команды разом:

```bash
php artisan cache:clear && \
php artisan config:clear && \
php artisan route:clear && \
php artisan view:clear && \
php artisan migrate --force && \
php artisan db:seed --class=SliderSeeder --force && \
php artisan db:seed --class=HomePageFeatureSeeder --force && \
php artisan db:seed --class=HomePageGallerySeeder --force && \
php artisan db:seed --class=HomePageSectionTitleSeeder --force && \
php artisan db:seed --class=AddHomePageHeroSettingsSeeder --force && \
php artisan storage:link && \
chmod -R 775 storage bootstrap/cache && \
chmod -R 777 storage/logs && \
php artisan config:cache && \
php artisan route:cache && \
echo "✅ Готово! Проверьте сайт в браузере."
```

---

### Шаг 5: Проверьте результат

Откройте в браузере:
- https://ваш-домен.com/ - главная должна работать
- https://ваш-домен.com/admin - админка должна работать

---

## 📚 Дополнительные материалы

Если нужна более подробная информация:

1. **BEGET_QUICK_FIX.md** - быстрое решение с пояснениями
2. **BEGET_CHECKLIST.md** - чек-лист для проверки
3. **docs/BEGET_DEPLOYMENT_GUIDE.md** - полное руководство
4. **docs/BEGET_SSH_CONNECTION.md** - инструкция по SSH
5. **fix-beget-errors.sh** - автоматический скрипт исправления

---

## 🆘 Если не помогло

Посмотрите логи ошибок:

```bash
tail -50 storage/logs/laravel.log
```

Или временно включите отладку (в файле `.env`):
```
APP_DEBUG=true
```

Затем:
```bash
php artisan config:clear
```

Откройте сайт - увидите детальную ошибку.

**⚠️ После диагностики верните:** `APP_DEBUG=false`

---

## ✅ После исправления

Когда всё заработает:

1. Убедитесь что `APP_DEBUG=false` в `.env`
2. Создайте бэкап базы данных
3. Протестируйте основные функции сайта

---

## 📞 Поддержка

**Beget:**
- Email: support@beget.com
- Телефон: +7 (495) 721-80-88
- Чат: https://cp.beget.com/

---

**Всё получится! 🍀**

