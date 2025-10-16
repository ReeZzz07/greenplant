# 🎨 Настройки наложения для личного кабинета

## Обзор

В настройки личного кабинета добавлены расширенные возможности настройки фонового изображения hero-секции, аналогичные настройкам других страниц сайта (каталог, блог, контакты).

## 📋 Что добавлено

### 1. **Настройки наложения (Overlay)**

- **Тип наложения** (`overlay_type`):
  - `none` - Без наложения
  - `darken` - Затемнение (черный полупрозрачный слой)
  - `lighten` - Осветление (белый полупрозрачный слой)

- **Прозрачность наложения** (`overlay_opacity`):
  - Диапазон: 0-100%
  - Ползунок с отображением текущего значения в реальном времени
  - Применяется только если выбран тип наложения `darken` или `lighten`

### 2. **Настройки позиционирования фона**

- **Позиция фона** (`background_position`):
  - Слева сверху (`left top`)
  - По центру сверху (`center top`)
  - Справа сверху (`right top`)
  - Слева по центру (`left center`)
  - **По центру** (`center center`) - *по умолчанию*
  - Справа по центру (`right center`)
  - Слева снизу (`left bottom`)
  - По центру снизу (`center bottom`)
  - Справа снизу (`right bottom`)

- **Размер фона** (`background_size`):
  - **Покрыть всю область** (`cover`) - *по умолчанию, рекомендуется*
  - Вместить полностью (`contain`)
  - Автоматически (`auto`)
  - Растянуть (`100% 100%`)

### 3. **Live Preview (Предпросмотр в реальном времени)**

- Все изменения настроек отображаются мгновенно в окне предпросмотра
- Не требуется сохранение для просмотра результата
- JavaScript автоматически обновляет превью при изменении любого параметра
- Показывает реальный вид hero-секции с текстом "Личный кабинет"

## 🗂️ Структура базы данных

### Таблица: `account_page_settings`

```sql
CREATE TABLE account_page_settings (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    hero_background_image VARCHAR(255) NULL,
    overlay_type VARCHAR(255) DEFAULT 'none',
    overlay_opacity INT DEFAULT 50,
    background_position VARCHAR(255) DEFAULT 'center center',
    background_size VARCHAR(255) DEFAULT 'cover',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

**Изменения:**
- ❌ Удалена старая структура с `key`/`value`
- ✅ Добавлены специализированные поля для каждой настройки
- ✅ Все настройки в одной записи (используется первая запись)

## 📁 Файлы

### Миграция
- `database/migrations/2025_10_16_153304_add_overlay_settings_to_account_page_settings_table.php`

### Модель
- `app/Models/AccountPageSetting.php`
  - Метод `getSettings()` - получает или создает настройки с значениями по умолчанию
  - Fillable поля: все новые настройки

### Контроллер
- `app/Http/Controllers/Admin/AccountPageSettingController.php`
  - `index()` - отображение формы настроек
  - `update()` - сохранение всех настроек с валидацией
  - `deleteImage()` - удаление фонового изображения

### Views

#### Админка
- `resources/views/admin/account-page-settings/index.blade.php`
  - Полностью переделан с добавлением всех настроек
  - Live preview с JavaScript
  - Интерактивные элементы управления

#### Frontend (Shared Partial)
- `resources/views/frontend/account/partials/hero.blade.php` ⭐ **НОВЫЙ**
  - Универсальный partial для hero-секции
  - Применяет все настройки из БД
  - Автоматический расчет overlay стилей
  - Поддержка динамических заголовков и подзаголовков

#### Обновленные страницы
Все страницы теперь используют общий partial `hero.blade.php`:
- `resources/views/frontend/account/dashboard.blade.php`
- `resources/views/frontend/account/profile.blade.php`
- `resources/views/frontend/account/orders.blade.php`
- `resources/views/frontend/account/order-show.blade.php`
- `resources/views/frontend/account/addresses.blade.php`
- `resources/views/frontend/customer-auth.blade.php`

## 🎯 Использование

### В админке

1. Перейдите: **Админка** → **Настройки** → **Главная страница** → **Личный кабинет**
2. Загрузите фоновое изображение (или используйте текущее)
3. Настройте тип и прозрачность наложения
4. Выберите позицию и размер фона
5. Наблюдайте изменения в окне предпросмотра
6. Нажмите **"Сохранить настройки"**

### Во frontend views

Использование нового partial:

```blade
@include('frontend.account.partials.hero', [
    'title' => 'Мой заголовок',
    'subtitle' => 'Необязательный подзаголовок' // опционально
])
```

Параметры:
- `title` (обязательный) - основной заголовок hero-секции
- `subtitle` (опциональный) - дополнительный текст под заголовком

## 💡 Преимущества новой реализации

### 1. **Единообразие**
- Все страницы личного кабинета используют одну hero-секцию
- Одни настройки для всех страниц
- Консистентный дизайн

### 2. **Гибкость**
- Полный контроль над внешним видом фона
- Улучшение читаемости через overlay
- Адаптация под любое изображение

### 3. **Удобство**
- Live preview - видите результат до сохранения
- Интуитивные элементы управления
- Не требуется знание CSS

### 4. **Производительность**
- Один запрос к БД для получения всех настроек
- Кеширование модели через `getSettings()`
- Минимальный overhead

### 5. **Поддерживаемость**
- Централизованный partial для hero-секции
- Легко добавлять новые страницы
- Простое изменение общего дизайна

## 🔧 Технические детали

### JavaScript Live Preview

Функция `updatePreview()` обновляет превью при изменении:
- Фонового изображения
- Типа наложения
- Прозрачности
- Позиции фона
- Размера фона

Обработчики событий:
```javascript
document.getElementById('overlay_type').addEventListener('change', updatePreview);
document.getElementById('overlay_opacity').addEventListener('input', updatePreview);
document.getElementById('background_position').addEventListener('change', updatePreview);
document.getElementById('background_size').addEventListener('change', updatePreview);
```

### PHP расчет Overlay

В `hero.blade.php`:
```php
$overlayStyle = '';
if ($settings->overlay_type === 'darken') {
    $overlayOpacity = $settings->overlay_opacity / 100;
    $overlayStyle = "background: rgba(0, 0, 0, {$overlayOpacity});";
} elseif ($settings->overlay_type === 'lighten') {
    $overlayOpacity = $settings->overlay_opacity / 100;
    $overlayStyle = "background: rgba(255, 255, 255, {$overlayOpacity});";
}
```

### HTML структура с Overlay

```html
<div class="hero-wrap" style="background-image: url(...); background-size: ...; background-position: ...; position: relative;">
    <!-- Overlay слой (если включен) -->
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(...);"></div>
    
    <!-- Контент (поверх overlay) -->
    <div class="container" style="position: relative; z-index: 1;">
        <h1>{{ $title }}</h1>
    </div>
</div>
```

## 📊 Значения по умолчанию

При первом запуске или отсутствии настроек создается запись с:
```php
[
    'hero_background_image' => null, // используется assets/images/bg_6.jpg
    'overlay_type' => 'none',
    'overlay_opacity' => 50,
    'background_position' => 'center center',
    'background_size' => 'cover',
]
```

## ✅ Что работает

- ✅ Загрузка и удаление фонового изображения
- ✅ Настройка типа наложения (нет/затемнение/осветление)
- ✅ Регулировка прозрачности от 0 до 100%
- ✅ Выбор позиции фона (9 вариантов)
- ✅ Выбор размера фона (4 варианта)
- ✅ Live preview всех изменений
- ✅ Применение настроек ко всем страницам личного кабинета
- ✅ Fallback на изображение по умолчанию

## 🎨 Рекомендации по использованию

### Для темных изображений
- Используйте `overlay_type: lighten`
- Установите прозрачность 30-50%
- Текст будет хорошо читаться

### Для светлых изображений
- Используйте `overlay_type: darken`
- Установите прозрачность 40-60%
- Контраст с белым текстом улучшится

### Для контрастных изображений
- Используйте `overlay_type: darken`
- Установите прозрачность 50-70%
- Получите равномерный фон

### Позиционирование
- **Для пейзажей**: `center center` + `cover`
- **Для портретов**: `center top` + `cover`
- **Для паттернов**: `left top` + `auto` или `contain`

## 🔗 Связанные файлы

- Маршруты: `routes/web.php` (секция Account Page Settings)
- Стили: встроены в view
- JavaScript: встроен в view (не требует внешних библиотек)

---

**Дата обновления:** 16 октября 2025  
**Версия:** 1.0  
**Автор:** GreenPlant Development Team

