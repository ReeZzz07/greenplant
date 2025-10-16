# 📚 Git Configuration для GreenPlant

**Дата**: 16 октября 2025  
**Версия**: 1.0

---

## 📋 Обзор

Git настроен для безопасного управления кодом проекта GreenPlant с защитой чувствительных данных.

---

## 🔒 Что НЕ включается в Git

### ✅ Критично для безопасности

#### Environment файлы
- ❌ `.env` - содержит пароли БД, API ключи, APP_KEY
- ❌ `.env.backup` - резервные копии
- ❌ `.env.production` - production настройки
- ❌ `.env.testing` - тестовые настройки

**Почему**: Содержат чувствительные данные

#### Security файлы
- ❌ `*.pem`, `*.key`, `*.crt` - SSL сертификаты
- ❌ `id_rsa`, `id_rsa.pub` - SSH ключи
- ❌ `*.p12`, `*.pfx` - ключи

**Почему**: Приватные ключи и сертификаты

---

### 🗂️ Laravel Framework

#### Vendor и зависимости
- ❌ `/vendor` - Composer пакеты
- ❌ `/node_modules` - NPM пакеты
- ❌ `composer.lock` - версии зависимостей
- ❌ `package-lock.json` - NPM версии

**Почему**: Генерируются из `composer.json` и `package.json`

#### Cache и Build
- ❌ `/bootstrap/cache/*.php` - кеши Laravel
- ❌ `/storage/framework/cache/*` - application cache
- ❌ `/storage/framework/sessions/*` - сессии
- ❌ `/storage/framework/views/*` - compiled Blade
- ❌ `/public/build` - compiled assets
- ❌ `/public/hot` - Vite hot reload

**Почему**: Генерируются автоматически

#### Logs
- ❌ `/storage/logs/*` - логи приложения

**Почему**: Содержат чувствительную информацию, генерируются автоматически

#### Backups
- ❌ `/storage/app/backups/*` - автоматические бэкапы
- ❌ `*.sql`, `*.sql.gz` - SQL дампы
- ❌ `*.backup` - backup файлы

**Почему**: Могут содержать чувствительные данные, очень большие

---

### 🛠️ Development Tools

#### IDE настройки
- ❌ `/.idea` - PhpStorm/IntelliJ
- ❌ `/.vscode` - Visual Studio Code
- ❌ `/.fleet` - JetBrains Fleet
- ❌ `*.swp`, `*.swo` - Vim

**Почему**: Персональные настройки разработчиков

#### OS файлы
- ❌ `.DS_Store` - macOS
- ❌ `Thumbs.db` - Windows
- ❌ `desktop.ini` - Windows

**Почему**: Системные файлы ОС

#### Testing
- ❌ `/.phpunit.cache` - PHPUnit cache
- ❌ `/coverage` - code coverage reports
- ❌ `phpunit.xml` - local config

**Почему**: Локальные настройки и отчеты

---

### 📝 Временная документация

Исключены временные отчеты (не нужны в production):
- ❌ `ANALYSIS_SUMMARY.md`
- ❌ `COMPLETED_TODAY.md`
- ❌ `CRITICAL_TASKS_COMPLETED.md`
- ❌ `FINAL_REPORT.md`
- ❌ `FONT_AWESOME_ICONS.md`
- ❌ `OVERLAY_SETTINGS_COMPLETED.md`
- ❌ `QUICK_START.md`
- ❌ `READY.md`
- ❌ `START_HERE.md`
- ❌ `TEST_*.md`
- ❌ `VERSION_*.md`
- ❌ `ACCOUNT_PAGE_SETTINGS_FEATURE.md`
- ❌ `CUSTOMER_ACCOUNT_FEATURE.md`
- ❌ `CREATE_ENV_EXAMPLE.md`

**Почему**: Временные файлы для разработки, не нужны на production

---

## ✅ Что ВКЛЮЧАЕТСЯ в Git

### 📦 Production файлы

#### Deployment
- ✅ `PRODUCTION_READY.md` - итоговая готовность
- ✅ `DEPLOYMENT_SUMMARY.md` - сводка
- ✅ `DEPLOYMENT_CHEATSHEET.md` - шпаргалка
- ✅ `deploy.sh` - deployment скрипт
- ✅ `.htaccess.root` - root .htaccess
- ✅ `docs/DEPLOYMENT_*.md` - руководства
- ✅ `docs/PRODUCTION_*.md` - production docs
- ✅ `docs/ENV_PRODUCTION_TEMPLATE.md` - .env шаблон

**Почему**: Необходимы для развертывания на сервере

#### Documentation
- ✅ `README.md` - основная документация
- ✅ `docs/roadmap.md` - roadmap проекта
- ✅ `docs/PROJECT_ANALYSIS_*.md` - анализ
- ✅ `docs/BACKUP_GUIDE.md` - руководство по бэкапам
- ✅ `docs/QUICK_IMPROVEMENTS_GUIDE.md` - улучшения
- ✅ `docs/ACCOUNT_PAGE_OVERLAY_SETTINGS.md` - настройки

**Почему**: Важная документация проекта

---

### 🔧 Configuration

#### Laravel
- ✅ `composer.json` - зависимости
- ✅ `package.json` - NPM зависимости
- ✅ `artisan` - CLI tool
- ✅ `phpunit.xml.dist` - тесты (шаблон)
- ✅ `vite.config.js` - Vite config

#### Application
- ✅ `/app` - весь application код
- ✅ `/bootstrap` - bootstrap файлы (кроме cache)
- ✅ `/config` - конфигурация
- ✅ `/database` - миграции, seeders, factories
- ✅ `/public` - публичные файлы (кроме storage)
- ✅ `/resources` - views, assets
- ✅ `/routes` - маршруты
- ✅ `/tests` - тесты

---

### 📁 Storage Structure

#### Tracked (пустые папки с .gitkeep)
- ✅ `/storage/app/.gitkeep`
- ✅ `/storage/app/public/.gitkeep`
- ✅ `/storage/framework/cache/.gitkeep`
- ✅ `/storage/framework/sessions/.gitkeep`
- ✅ `/storage/framework/testing/.gitkeep`
- ✅ `/storage/framework/views/.gitkeep`
- ✅ `/storage/logs/.gitkeep`

**Почему**: Сохраняет структуру папок

#### Not Tracked (содержимое)
- ❌ Файлы внутри этих папок

**Почему**: Генерируются или загружаются на сервере

---

## 🎯 .gitattributes Configuration

### Нормализация переводов строк
- **LF** (`\n`) для всех текстовых файлов
- **CRLF** (`\r\n`) только для Windows batch файлов

### Binary файлы
- Изображения, шрифты, архивы - как binary
- Предотвращает повреждение при merge

### Export-ignore
При создании архива (`git archive`) исключаются:
- Тесты
- IDE настройки
- Временная документация
- Git файлы

---

## 📋 Команды для проверки

### Проверить игнорируемые файлы
```bash
git status --ignored
```

### Проверить какие файлы в Git
```bash
git ls-files
```

### Проверить .gitignore для файла
```bash
git check-ignore -v путь/к/файлу
```

### Удалить уже закоммиченные файлы из Git
```bash
# Удалить из Git, но оставить локально
git rm --cached путь/к/файлу

# Для папки
git rm --cached -r путь/к/папке
```

---

## ⚠️ Важные напоминания

### 🔴 НИКОГДА не коммитить:
1. `.env` файлы с реальными данными
2. Пароли, API ключи, токены
3. SSL сертификаты и приватные ключи
4. Backup файлы с production данными
5. Логи с чувствительной информацией

### ✅ Всегда проверяйте перед коммитом:
```bash
# Посмотрите что будет закоммичено
git status

# Проверьте изменения
git diff

# Проверьте staged изменения
git diff --staged
```

### 🔍 Если случайно закоммитили секреты:

1. **НЕ** просто удаляйте файл - он остается в истории!
2. Используйте `git filter-branch` или `BFG Repo-Cleaner`
3. Смените все скомпрометированные ключи/пароли
4. Force push (только если repo приватный и вы один)

```bash
# Удалить файл из всей истории (ОПАСНО!)
git filter-branch --force --index-filter \
  "git rm --cached --ignore-unmatch путь/к/файлу" \
  --prune-empty --tag-name-filter cat -- --all
```

---

## 📊 Статистика .gitignore

### Категории исключений:
- 🔒 Security: 11 правил
- 🗂️ Laravel: 25+ правил
- 🛠️ Development: 15+ правил
- 📝 Documentation: 15+ временных файлов
- 📦 Dependencies: 5 правил
- 💾 Backups: 6 правил

### Всего: ~80+ правил игнорирования

---

## 🔄 Git Workflow для команды

### 1. Начало работы
```bash
git clone https://github.com/ваш-repo/greenplant.git
cd greenplant
composer install
npm install
cp .env.example .env
php artisan key:generate
```

### 2. Работа над фичей
```bash
git checkout -b feature/название-фичи
# ... работа ...
git add .
git commit -m "Добавлена фича X"
git push origin feature/название-фичи
```

### 3. Перед коммитом всегда:
```bash
# Проверьте статус
git status

# Убедитесь что нет .env и других секретов
git diff

# Запустите тесты
php artisan test
```

---

## 📚 Дополнительные ресурсы

- [Git Documentation](https://git-scm.com/doc)
- [Laravel Deployment](https://laravel.com/docs/10.x/deployment)
- [.gitignore Templates](https://github.com/github/gitignore)
- [BFG Repo-Cleaner](https://rtyley.github.io/bfg-repo-cleaner/)

---

## ✅ Checklist конфигурации Git

- [X] `.gitignore` настроен
- [X] `.gitattributes` создан
- [X] `.env` в игноре
- [X] `/vendor` в игноре
- [X] `/node_modules` в игноре
- [X] Логи в игноре
- [X] Кеши в игноре
- [X] Бэкапы в игноре
- [X] Security файлы в игноре
- [X] Deployment docs в repo
- [X] Временные docs в игноре
- [X] README обновлен

---

**Версия документа**: 1.0  
**Дата создания**: 16 октября 2025  
**Проект**: GreenPlant v2.4.0

**Git настроен и готов к работе! 🎉**

