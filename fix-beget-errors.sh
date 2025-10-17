#!/bin/bash

# Скрипт для исправления ошибок 500 на Beget.com
# Использование: bash fix-beget-errors.sh

echo "🔧 Начинаем исправление ошибок..."
echo ""

# Шаг 1: Очистка кэша
echo "📝 Шаг 1: Очистка кэша..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
echo "✅ Кэш очищен"
echo ""

# Шаг 2: Проверка статуса миграций
echo "📝 Шаг 2: Проверка миграций..."
php artisan migrate:status
echo ""

# Шаг 3: Выполнение миграций (если нужно)
echo "📝 Шаг 3: Выполнение миграций..."
read -p "Выполнить миграции? (y/n): " -n 1 -r
echo ""
if [[ $REPLY =~ ^[Yy]$ ]]
then
    php artisan migrate --force
    echo "✅ Миграции выполнены"
else
    echo "⏭️  Миграции пропущены"
fi
echo ""

# Шаг 4: Заполнение базы данных
echo "📝 Шаг 4: Заполнение базы данных..."
read -p "Запустить все сидеры? (y/n): " -n 1 -r
echo ""
if [[ $REPLY =~ ^[Yy]$ ]]
then
    php artisan db:seed --force
    echo "✅ Сидеры выполнены"
else
    echo "Запустить только необходимые сидеры для главной страницы? (y/n): "
    read -p "" -n 1 -r
    echo ""
    if [[ $REPLY =~ ^[Yy]$ ]]
    then
        php artisan db:seed --class=SliderSeeder --force
        php artisan db:seed --class=HomePageFeatureSeeder --force
        php artisan db:seed --class=HomePageGallerySeeder --force
        php artisan db:seed --class=HomePageSectionTitleSeeder --force
        php artisan db:seed --class=AddHomePageHeroSettingsSeeder --force
        echo "✅ Необходимые сидеры выполнены"
    else
        echo "⏭️  Сидеры пропущены"
    fi
fi
echo ""

# Шаг 5: Создание символической ссылки
echo "📝 Шаг 5: Создание символической ссылки storage..."
php artisan storage:link
echo "✅ Символическая ссылка создана"
echo ""

# Шаг 6: Установка прав доступа
echo "📝 Шаг 6: Установка прав доступа..."
chmod -R 775 storage bootstrap/cache
chmod -R 777 storage/logs
echo "✅ Права доступа установлены"
echo ""

# Шаг 7: Создание кэша конфигурации
echo "📝 Шаг 7: Создание кэша конфигурации..."
php artisan config:cache
php artisan route:cache
echo "✅ Кэш конфигурации создан"
echo ""

# Шаг 8: Проверка логов
echo "📝 Шаг 8: Последние записи в логах Laravel..."
echo "════════════════════════════════════════════════════════════"
if [ -f storage/logs/laravel.log ]; then
    tail -20 storage/logs/laravel.log
else
    echo "Лог-файл не найден или пуст"
fi
echo "════════════════════════════════════════════════════════════"
echo ""

echo "✅ Готово! Проверьте работу сайта."
echo ""
echo "📌 Полезные команды для дальнейшей диагностики:"
echo "   - Просмотр логов: tail -50 storage/logs/laravel.log"
echo "   - Проверка .env: cat .env"
echo "   - Проверка прав: ls -la storage"
echo "   - Очистка всего кэша: php artisan optimize:clear"
echo ""

