# ✅ Исправление готово! Что делать дальше

## 🎉 Проблемы исправлены!

Найдено и исправлено 2 проблемы:

**Проблема 1:** В файле `SliderSeeder.php` использовались неправильные названия колонок:
- ❌ `link_text` и `link_url` (неправильно)
- ✅ `button_text` и `button_link` (правильно)

**Проблема 2:** Отсутствовала миграция для таблицы `home_page_section_titles`:
- ✅ Создана миграция `2025_10_17_182151_create_home_page_section_titles_table.php`

Все исправления загружены в Git!

---

## 📋 Инструкция для Beget (скопируйте команды)

### Способ 1: Одной командой (самый быстрый)

Подключитесь по SSH и выполните:

```bash
cd ~/ваш-домен.com/public_html && \
git pull origin main && \
php8.2 artisan cache:clear && \
php8.2 artisan config:clear && \
php8.2 artisan route:clear && \
php8.2 artisan view:clear && \
php8.2 artisan migrate --force && \
php8.2 artisan db:seed --force && \
php8.2 artisan storage:link && \
chmod -R 775 storage bootstrap/cache && \
chmod -R 777 storage/logs && \
php8.2 artisan config:cache && \
php8.2 artisan route:cache && \
echo "✅ Готово!"
```

### Способ 2: Пошагово (если хотите контролировать процесс)

```bash
# 1. Перейдите в папку сайта
cd ~/ваш-домен.com/public_html

# 2. Получите исправления
git pull origin main

# 3. Очистите кэш
php8.2 artisan cache:clear
php8.2 artisan config:clear

# 4. Выполните миграции
php8.2 artisan migrate --force

# 5. Заполните базу данных
php8.2 artisan db:seed --force

# 6. Создайте symlink
php8.2 artisan storage:link

# 7. Установите права
chmod -R 775 storage bootstrap/cache

# 8. Пересоздайте кэш
php8.2 artisan config:cache
php8.2 artisan route:cache

# 9. Готово!
echo "✅ Всё работает!"
```

### Способ 3: Автоматический скрипт

```bash
cd ~/ваш-домен.com/public_html
bash fix-beget-errors.sh
```

---

## 🔍 Проверка

После выполнения команд откройте в браузере:

1. ✅ **Главная страница** - должна работать
2. ✅ **Админка /admin** - должна работать
3. ✅ **Hero-секция** - должна сохраняться
4. ✅ **Заголовки секций** - должны открываться

---

## 💡 Что было исправлено

В файлах:
- ✅ `database/seeders/SliderSeeder.php` - исправлены названия колонок (button_text, button_link)
- ✅ `database/migrations/2025_10_17_182151_create_home_page_section_titles_table.php` - создана недостающая миграция
- ✅ `fix-beget-errors.sh` - добавлен шаг получения обновлений из Git
- ✅ Все инструкции обновлены

---

## 🆘 Если всё ещё ошибка

### Посмотрите логи:
```bash
tail -50 storage/logs/laravel.log
```

### Проверьте, что база данных пустая перед заполнением

Если вы уже запускали сидеры ранее, они могут дать ошибку дублирования. В таком случае:

**Вариант А: Очистить и заново**
```bash
php8.2 artisan migrate:fresh --seed --force
```
⚠️ **ВНИМАНИЕ:** Это удалит ВСЕ данные из базы!

**Вариант Б: Запустить только проблемные сидеры**
```bash
php8.2 artisan db:seed --class=SliderSeeder --force
php8.2 artisan db:seed --class=HomePageFeatureSeeder --force
php8.2 artisan db:seed --class=HomePageGallerySeeder --force
php8.2 artisan db:seed --class=HomePageSectionTitleSeeder --force
php8.2 artisan db:seed --class=AddHomePageHeroSettingsSeeder --force
```

---

## 📞 Поддержка

Если проблема не решилась:

**Beget:**
- 📧 support@beget.com
- 📞 +7 (495) 721-80-88
- 💬 Онлайн-чат: https://cp.beget.com/

---

**Всё готово! Запускайте команды и проверяйте сайт! 🚀**

