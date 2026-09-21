# PHP MVC Core (Router + MySQL + AJAX + Auth + News + Bootstrap UI)

## Структура

```
bootstrap.php            — точка инициализации (config, автозагрузка, редирект http<->https, старт сессии)
index.php                — точка входа веб-сервера: require bootstrap.php + Router::run()
.htaccess                — редирект всех запросов на index.php

config/config.php        — БД, режим отладки, BASE_URL, переключатель протокола (APP_SCHEME)

core/                     — ядро фреймворка
  Autoloader.php
  Db.php                    — PDO-обёртка (singleton)
  Router.php                — разбор URL, вызов контроллера/action
  Controller.php             — render, json, model, redirect, isLoggedIn/requireAuth
  Model.php
  View.php                     — рендер вида + обёртка в общий шаблон
  Session.php
  Cookie.php

app/
  controllers/
    MainController.php    — главная (hero + фичи + тизер новостей)
    UserController.php
    AuthController.php    — регистрация / вход / выход
    NewsController.php    — список новостей с пагинацией + детальная страница
  models/
    UserModel.php
    NewsModel.php          — getPaginated(), countAll(), getBySlug(), getLatest()
  views/
    template.php           — общий шаблон на Bootstrap 5 (навбар, alert'ы, футер)
    main/index.php
    user/index.php, user/view.php
    auth/register.php, auth/login.php
    news/index.php         — карточки + пагинация
    news/view.php           — полная новость

public/js/app.js
public/css/style.css      — кастомные стили поверх Bootstrap (hero, карточки, футер)
database.sql              — таблицы users, news (+ 14 демо-новостей для пагинации)
```

## Переключатель http/https

В `config/config.php`:

```php
define('APP_SCHEME', 'auto');   // 'auto' | 'http' | 'https'
```

- `'auto'` — сайт работает по тому протоколу, по которому пришёл запрос (обычный режим).
- `'https'` — все http-запросы будут редиректиться (301) на https.
- `'http'` — наоборот, https будет редиректиться на http.

Редирект выполняется в `bootstrap.php` до старта роутера. Также доступны константы
`CURRENT_SCHEME` (реальный протокол запроса), `SITE_SCHEME` (действующий протокол
с учётом настройки) и `SITE_URL` (полный адрес сайта). `Cookie::set()` сам
проставляет флаг `secure` на основе `SITE_SCHEME`.

## Новости + пагинация

Маршруты:

| URL                          | Действие                              |
|--------------------------------|-----------------------------------------|
| `/news/index`                   | 1-я страница списка (5 новостей)         |
| `/news/index/page/2`             | 2-я страница и т.д.                       |
| `/news/view/slug/<slug>`          | Полная новость по человекопонятному slug   |

`NewsModel::getPaginated($page, $perPage)` считает `LIMIT/OFFSET` из номера
страницы, `NewsController` сам ограничивает номер страницы диапазоном
`[1, totalPages]`, чтобы `/news/index/page/999` не показывал пустую страницу
с ошибкой. `database.sql` уже содержит 14 демо-новостей (при `PER_PAGE = 5`
получится 3 страницы) — текст в них — заглушки для примера, замените на свои.

## Оформление

Общий шаблон (`app/views/template.php`) подключает Bootstrap 5 и Bootstrap
Icons через CDN, шрифт Poppins с Google Fonts. Страница собрана из блоков:

- **Навбар** — липкий, с градиентом, показывает вход/регистрацию либо имя
  вошедшего пользователя.
- **Hero** на главной — заголовок, подзаголовок, кнопки.
- **Блок «Что внутри»** — три карточки-преимущества.
- **Тизер новостей** — 3 последние новости с главной.
- **CTA-блок** с AJAX-поиском пользователей.
- **Футер** — три колонки (о проекте, разделы, контакты) + копирайт.

Кастомные стили — в `public/css/style.css` (переменные `--brand-1/2/3`
задают градиент, дальше можно перекрасить весь сайт, поменяв только их).

## Установка

1. Импортировать `database.sql`.
2. Настроить `config/config.php` (БД + при необходимости `APP_SCHEME`).
3. Document root -> папка проекта (Apache + `mod_rewrite`; для Nginx —
   `try_files $uri $uri/ /index.php?$query_string;`).
4. Открыть `/` — увидите главную с новостями; `/auth/register` — создать
   пользователя.

## Как добавить новую фичу

1. `app/controllers/XxxController.php extends Controller`.
2. `app/models/XxxModel.php extends Model`.
3. `app/views/xxx/*.php` — только контент, без шапки/футера (их подставит
   `template.php`).
