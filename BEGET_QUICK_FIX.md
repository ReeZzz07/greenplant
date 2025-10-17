# 🚨 Быстрое решение ошибок 500 на Beget.com

## Проблема
- ❌ Главная страница - ошибка 500
- ❌ Настройки hero-секции не сохраняются (500)
- ❌ Страница "Заголовки секций" не открывается (500)

## ⚡ Быстрое решение (5 минут)

### Вариант 1: Автоматический скрипт

1. Подключитесь к серверу через SSH
2. Перейдите в папку сайта:
   ```bash
   cd ~/ваш-домен.com/public_html
   ```
3. Получите последние обновления:
   ```bash
   git pull origin main
   ```
4. Запустите скрипт:
   ```bash
   bash fix-beget-errors.sh
   ```

### Вариант 2: Ручные команды

Подключитесь по SSH и выполните команды по порядку:

```bash
# 1. Перейдите в папку сайта
cd ~/ваш-домен.com/public_html

# 2. Получите последние обновления
git pull origin main

# 3. Очистите кэш
php artisan cache:clear && php artisan config:clear && php artisan route:clear && php artisan view:clear

# 3. Выполните миграции (создание таблиц)
php artisan migrate --force

# 4. Заполните таблицы данными
php artisan db:seed --class=SliderSeeder --force
php artisan db:seed --class=HomePageFeatureSeeder --force
php artisan db:seed --class=HomePageGallerySeeder --force
php artisan db:seed --class=HomePageSectionTitleSeeder --force
php artisan db:seed --class=AddHomePageHeroSettingsSeeder --force

# 5. Создайте символическую ссылку для изображений
php artisan storage:link

# 6. Установите права доступа
chmod -R 775 storage bootstrap/cache
chmod -R 777 storage/logs

# 7. Пересоздайте кэш
php artisan config:cache && php artisan route:cache

# 8. Проверьте результат
echo "✅ Готово! Проверьте сайт в браузере."
```

## 🔍 Диагностика (если не помогло)

### Просмотр логов ошибок:
```bash
tail -50 storage/logs/laravel.log
```

### Проверка конфигурации .env:
```bash
cat .env | grep -E "APP_|DB_"
```

### Временное включение отладки:

1. Откройте файл `.env`
2. Измените:
   ```
   APP_DEBUG=true
   ```
3. Очистите кэш:
   ```bash
   php artisan config:clear
   ```
4. Откройте сайт - увидите детальную ошибку
5. **ВАЖНО:** После диагностики верните `APP_DEBUG=false`

## ✅ Проверка результата

После выполнения команд проверьте:

1. **Главная страница** - должна открываться без ошибок
2. **Админ-панель** → Контент → Hero-секция → Сохранение - должно работать
3. **Админ-панель** → Контент → Заголовки секций - должно открываться

## 📋 Типичные причины ошибок и решения

| Проблема | Причина | Решение |
|----------|---------|---------|
| "Table doesn't exist" | Не выполнены миграции | `php artisan migrate --force` |
| "Column not found" | Старая версия БД | `php artisan migrate:fresh --seed --force` ⚠️ **Удалит все данные!** |
| "Permission denied" | Неправильные права | `chmod -R 775 storage` |
| Изображения не загружаются | Нет симлинка | `php artisan storage:link` |
| Постоянная ошибка 500 | Проблема с .env | Проверьте настройки БД в .env |

## 🆘 Если ничего не помогло

1. **Проверьте настройки .env:**
   - `APP_KEY` должен быть заполнен
   - `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` должны быть правильными
   - `APP_URL` должен соответствовать вашему домену

2. **Проверьте версию PHP:**
   ```bash
   php -v
   ```
   Должна быть PHP 8.0 или выше

3. **Проверьте установку Composer:**
   ```bash
   composer install --no-dev --optimize-autoloader
   ```

4. **Свяжитесь с поддержкой Beget:**
   - Email: support@beget.com
   - Телефон: +7 (495) 721-80-88

## 📚 Дополнительная документация

Полная инструкция: `docs/BEGET_DEPLOYMENT_GUIDE.md`

## ⚠️ Важные замечания

1. Все команды с `--force` используются для production-окружения
2. Не используйте `APP_DEBUG=true` на рабочем сайте постоянно
3. Регулярно делайте бэкапы базы данных
4. Храните файл `.env` в безопасности

## 🎯 Контрольный список

- [ ] SSH подключение работает
- [ ] Файлы загружены на сервер
- [ ] .env файл настроен правильно
- [ ] База данных создана в панели Beget
- [ ] Миграции выполнены
- [ ] Сидеры запущены
- [ ] Права доступа установлены
- [ ] Кэш очищен и пересоздан
- [ ] Сайт работает без ошибок

---

**Удачи! 🚀**

