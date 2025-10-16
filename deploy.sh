#!/bin/bash

# ========================================
# GreenPlant - Production Deployment Script
# ========================================
# Этот скрипт автоматизирует процесс развертывания на REG.RU
# Использование: bash deploy.sh

echo "🚀 Начинаем развертывание GreenPlant..."
echo "========================================"

# Проверка окружения
if [ ! -f .env ]; then
    echo "❌ Файл .env не найден!"
    echo "📋 Скопируйте docs/ENV_PRODUCTION_TEMPLATE.md в .env и заполните данные"
    exit 1
fi

# Проверка APP_ENV
APP_ENV=$(grep APP_ENV .env | cut -d '=' -f2)
if [ "$APP_ENV" != "production" ]; then
    echo "⚠️  ВНИМАНИЕ: APP_ENV не установлен в production!"
    echo "Текущее значение: $APP_ENV"
    read -p "Продолжить? (y/n): " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[Yy]$ ]]; then
        exit 1
    fi
fi

# Проверка APP_DEBUG
APP_DEBUG=$(grep APP_DEBUG .env | cut -d '=' -f2)
if [ "$APP_DEBUG" = "true" ]; then
    echo "❌ КРИТИЧНО: APP_DEBUG=true в production!"
    echo "Измените на APP_DEBUG=false в файле .env"
    exit 1
fi

echo "✅ Проверки окружения пройдены"
echo ""

# 1. Установка зависимостей
echo "📦 Установка Composer зависимостей..."
composer install --optimize-autoloader --no-dev
if [ $? -ne 0 ]; then
    echo "❌ Ошибка установки зависимостей"
    exit 1
fi
echo "✅ Зависимости установлены"
echo ""

# 2. Генерация ключа приложения (если не существует)
APP_KEY=$(grep APP_KEY .env | cut -d '=' -f2)
if [ -z "$APP_KEY" ]; then
    echo "🔑 Генерация APP_KEY..."
    php artisan key:generate --force
    echo "✅ APP_KEY сгенерирован"
else
    echo "✅ APP_KEY уже существует"
fi
echo ""

# 3. Очистка старых кешей
echo "🧹 Очистка старых кешей..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
echo "✅ Кеши очищены"
echo ""

# 4. Миграции базы данных
echo "🗄️  Выполнение миграций..."
read -p "Запустить миграции? (y/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    php artisan migrate --force
    if [ $? -ne 0 ]; then
        echo "❌ Ошибка миграций"
        exit 1
    fi
    echo "✅ Миграции выполнены"
else
    echo "⏭️  Миграции пропущены"
fi
echo ""

# 5. Seeding (только для первого развертывания)
read -p "Запустить seeders? (только для первого развертывания) (y/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    echo "🌱 Запуск seeders..."
    php artisan db:seed --class=RoleSeeder --force
    php artisan db:seed --class=CustomerRoleSeeder --force
    echo "✅ Seeders выполнены"
else
    echo "⏭️  Seeders пропущены"
fi
echo ""

# 6. Storage link
echo "🔗 Создание символической ссылки storage..."
php artisan storage:link
echo "✅ Storage link создан"
echo ""

# 7. Установка прав доступа
echo "🔐 Установка прав доступа..."
chmod -R 775 storage
chmod -R 775 bootstrap/cache
echo "✅ Права доступа установлены"
echo ""

# 8. Оптимизация для production
echo "⚡ Оптимизация для production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
echo "✅ Оптимизация завершена"
echo ""

# 9. Проверка .htaccess
if [ ! -f public/.htaccess ]; then
    if [ -f public/.htaccess.production ]; then
        echo "📄 Копирование .htaccess для production..."
        cp public/.htaccess.production public/.htaccess
        echo "✅ .htaccess скопирован"
    else
        echo "⚠️  Файл public/.htaccess не найден!"
    fi
else
    echo "✅ public/.htaccess существует"
fi
echo ""

# 10. Итоговая информация
echo "========================================"
echo "🎉 Развертывание завершено!"
echo "========================================"
echo ""
echo "📋 Проверьте следующее:"
echo "  ✅ Домен указывает на папку /public"
echo "  ✅ PHP версия 8.1 или выше"
echo "  ✅ База данных создана и доступна"
echo "  ✅ Email настройки работают"
echo "  ✅ SSL сертификат установлен (HTTPS)"
echo ""
echo "🔧 Настройка Cron задачи:"
echo "  * * * * * cd $(pwd) && php artisan schedule:run >> /dev/null 2>&1"
echo ""
echo "📊 Для создания администратора выполните:"
echo "  php artisan db:seed --class=RecreateAdminSeeder --force"
echo ""
echo "🌐 Откройте сайт и проверьте работу!"
echo ""

