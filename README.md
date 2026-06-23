# Интернет-магазин видеоигр

Учебный проект на **Laravel 11** (PHP 8.3, MySQL, Blade + Bootstrap 5, TCPDF).
ГБПОУИО «ИАТ», 2026.

## Стек

- PHP 8.3, Laravel 11
- MySQL
- Blade + Bootstrap 5 (CDN)
- TCPDF (квитанции, день 10)
- Git

## Роли

- **Гость** — каталог, карточка товара, регистрация
- **Покупатель** — авторизация, корзина, список желаемого, оформление заказа, история + квитанция PDF, оплата
- **Администратор** — управление пользователями, каталогом, просмотр всех заказов

## Схема БД (по ER-модели)

| Таблица | Поля |
| --- | --- |
| users | id, email, password_hash, role (ENUM), created_at |
| games | id, title, description, price, genre, stock, is_hidden, created_at |
| orders | id, users_id, status (ENUM), total_price, created_at |
| order_items | id, orders_id, games_id, price_at_purchase, quantity |
| cart_items | id, users_id, games_id, quantity, added_at |
| wishlist | id, users_id, games_id, added_at |
| payments | id, orders_id, amount, status (ENUM), paid_at |

## Развёртывание

```bash
composer create-project laravel/laravel videogame-store
# скопировать файлы из этого репозитория в проект
```

В `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=videogame_store
DB_USERNAME=root
DB_PASSWORD=
```

```bash
php artisan migrate --seed
php artisan serve
```

Админ по умолчанию: **admin@store.local** / **password**

## План (16 дней)

Дни 1–8 готовы (фундамент). Дни 9–16: оформление заказа, история + PDF, оплата, админ-панели, безопасность, бэкапы.
