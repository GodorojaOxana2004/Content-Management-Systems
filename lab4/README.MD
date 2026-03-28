# USM Notes — WordPress Plugin

> **Лабораторная работа №4** · wp_cms · USM · Informatică · Anul II  
> Срок сдачи: **29 марта 2026**

---

## 📋 Содержание

- [Обзор проекта](#обзор-проекта)
- [Функциональность](#функциональность)
- [Требования](#требования)
- [Установка и запуск](#установка-и-запуск)
- [Пошаговое выполнение лабораторной работы](#пошаговое-выполнение-лабораторной-работы)
  - [Шаг 1. Подготовка среды](#шаг-1-подготовка-среды)
  - [Шаг 2. Создание основного файла плагина](#шаг-2-создание-основного-файла-плагина)
  - [Шаг 3. Регистрация Custom Post Type](#шаг-3-регистрация-custom-post-type-cpt)
  - [Шаг 4. Регистрация таксономии](#шаг-4-регистрация-пользовательской-таксономии)
  - [Шаг 5. Метабокс с датой напоминания](#шаг-5-метабокс-с-датой-напоминания)
  - [Шаг 6. Шорткод для отображения заметок](#шаг-6-шорткод-для-отображения-заметок)
  - [Шаг 7. Тестирование плагина](#шаг-7-тестирование-плагина)
- [Полный код плагина](#полный-код-плагина)
- [Справка по шорткоду](#справка-по-шорткоду)
- [Ответы на контрольные вопросы](#ответы-на-контрольные-вопросы)
- [Список использованных источников](#список-использованных-источников)

---

## Обзор проекта

**USM Notes** — плагин для WordPress, разработанный в рамках Лабораторной работы №4 по курсу **wp_cms** в Государственном Университете Молдовы (USM).  
Плагин добавляет на сайт раздел **«Заметки»** с поддержкой пользовательских приоритетов (таксономия), даты напоминания (метаполе) и гибкого шорткода для отображения на фронтенде.

| Свойство      | Значение                        |
|---------------|---------------------------------|
| Название      | USM Notes                       |
| Версия        | 1.0.0                           |
| Автор         | Оксана Годорожа                 |
| Курс          | wp_cms — USM, Informatică       |
| Срок сдачи    | 29 марта 2026                   |

---

## Функциональность

- ✅ **Custom Post Type (CPT)** — `usm_note` («Заметки»)
- ✅ **Пользовательская таксономия** — `note_priority` («Приоритет»: High / Medium / Low)
- ✅ **Метабокс** — поле даты напоминания с nonce-защитой, валидацией прошедших дат и обязательностью заполнения
- ✅ **Колонка в админке** — дата напоминания отображается в списке записей
- ✅ **Шорткод** `[usm_notes]` — фильтрация по приоритету и/или дате
- ✅ **Стили для фронтенда** — адаптивные карточки с цветовой кодировкой приоритетов
- ✅ Совместим с `WP_DEBUG` — без PHP-ошибок и предупреждений

---

## Требования

| Требование  | Минимальная версия |
|-------------|--------------------|
| WordPress   | 6.0+               |
| PHP         | 7.4+               |
| MySQL       | 5.7+               |

> **Рекомендуемое локальное окружение:** [LocalWP](https://localwp.com/), XAMPP или Docker с WordPress.

---

## Установка и запуск

### 1. Клонировать репозиторий

```bash
git clone https://github.com/<ваш-username>/usm-notes.git
```

### 2. Разместить плагин в WordPress

Скопируйте папку `usm-notes/` в:

```
wp-content/plugins/usm-notes/
```

### 3. Включить режим отладки в `wp-config.php`

```php
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
```

### 4. Активировать плагин

Войдите в **wp-admin → Плагины → Установленные плагины** → **Активировать USM Notes**

### 5. Проверить активацию

- В левом меню появится раздел **Заметки**
- Ошибок в браузере или в `wp-content/debug.log` быть не должно

---

## Пошаговое выполнение лабораторной работы

> Этот раздел — подробная инструкция: что делать, зачем и как именно.

---

### Шаг 1. Подготовка среды

**Цель:** настроить локальную копию WordPress и включить режим отладки.

1. Убедитесь, что WordPress установлен локально (LocalWP, XAMPP или аналог).
2. Откройте файловый менеджер и перейдите в папку:
   ```
   wp-content/plugins/
   ```
3. Создайте в ней новую папку `usm-notes/`.
4. Откройте файл `wp-config.php` (в корне WordPress) и найдите строку:
   ```php
   define( 'WP_DEBUG', false );
   ```
   Замените её на:
   ```php
   define( 'WP_DEBUG', true );
   define( 'WP_DEBUG_LOG', true );
   define( 'WP_DEBUG_DISPLAY', true );
   ```

   > **Зачем?** Это включает вывод PHP-ошибок прямо на экран и в лог-файл — удобно при разработке.

5. Сохраните файл.

---

### Шаг 2. Создание основного файла плагина

**Цель:** создать файл-точку входа с метаданными, которые WordPress читает для отображения плагина в админке.

1. Внутри папки `usm-notes/` создайте файл `usm-notes.php`.
2. Добавьте в него **шапку плагина** — это специальный блок комментариев, который WordPress читает автоматически:

```php
<?php
/**
 * Plugin Name: USM Notes
 * Plugin URI:  https://github.com/<ваш-username>/usm-notes
 * Description: Adds a Notes section with priorities and reminder dates.
 * Version:     1.0.0
 * Author:      Оксана Годорожа
 * License:     GPL2
 */

// Защита от прямого вызова файла
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
```

   > **Зачем `ABSPATH`?** Если кто-то попробует открыть файл плагина напрямую в браузере (без WordPress), скрипт немедленно завершится. Это базовая защита.

3. Сохраните файл.
4. Перейдите в **wp-admin → Плагины** — в списке появится **USM Notes**. Нажмите **Активировать**.
5. Убедитесь, что плагин активен (статус «Активен», нет красных ошибок).

![img](/images/1.png)

---

### Шаг 3. Регистрация Custom Post Type (CPT)

**Цель:** добавить в WordPress новый тип контента «Заметки» — отдельный раздел в админке, аналогичный «Записям» или «Страницам».

**Что такое CPT?**  
По умолчанию WordPress знает два типа контента: Posts (Записи) и Pages (Страницы). CPT — это способ создать свой тип, например «Заметки», «Продукты», «Сотрудники».

Добавьте в `usm-notes.php` следующий код:

```php
/**
 * Шаг 3. Регистрация CPT "usm_note"
 */
function usm_notes_register_cpt() {
    $labels = [
        'name'               => 'Заметки',
        'singular_name'      => 'Заметка',
        'add_new'            => 'Добавить',
        'add_new_item'       => 'Добавить заметку',
        'edit_item'          => 'Редактировать заметку',
        'new_item'           => 'Новая заметка',
        'view_item'          => 'Просмотреть заметку',
        'search_items'       => 'Найти заметки',
        'not_found'          => 'Заметок не найдено',
        'not_found_in_trash' => 'В корзине пусто',
        'menu_name'          => 'Заметки',
    ];

    $args = [
        'labels'       => $labels,
        'public'       => true,         // виден на фронтенде
        'has_archive'  => true,         // архивная страница /notes/
        'menu_icon'    => 'dashicons-sticky',
        'supports'     => [ 'title', 'editor', 'author', 'thumbnail' ],
        'show_in_rest' => true,         // поддержка Gutenberg
        'rewrite'      => [ 'slug' => 'notes' ],
    ];

    register_post_type( 'usm_note', $args );
}
add_action( 'init', 'usm_notes_register_cpt' );
```

**Что происходит:**
- `add_action('init', ...)` — WordPress вызывает нашу функцию при каждой загрузке страницы, на раннем этапе инициализации
- `register_post_type()` — официальная функция WordPress для создания CPT
- `'public' => true` — делает заметки доступными на фронтенде и в поиске
- `'has_archive' => true` — создаёт страницу `/notes/` со списком всех заметок
- `'supports'` — указывает, какие стандартные поля доступны в редакторе

После сохранения файла в левом меню wp-admin появится раздел **Заметки**.

> ⚠️ Если архивная страница `/notes/` не открывается — зайдите в **Настройки → Постоянные ссылки** и нажмите **Сохранить** (это обновляет `.htaccess`).

---

### Шаг 4. Регистрация пользовательской таксономии

**Цель:** добавить систему приоритетов (High / Medium / Low), которые можно присваивать заметкам — аналогично категориям у обычных записей.

**Что такое таксономия?**  
Таксономия — это способ группировки контента. WordPress из коробки имеет Categories и Tags. Мы создаём свою: «Приоритет».

```php
/**
 * Шаг 4. Регистрация таксономии "note_priority"
 */
function usm_notes_register_taxonomy() {
    $labels = [
        'name'              => 'Приоритеты',
        'singular_name'     => 'Приоритет',
        'search_items'      => 'Найти приоритеты',
        'all_items'         => 'Все приоритеты',
        'edit_item'         => 'Редактировать приоритет',
        'update_item'       => 'Обновить приоритет',
        'add_new_item'      => 'Добавить приоритет',
        'new_item_name'     => 'Название нового приоритета',
        'menu_name'         => 'Приоритеты',
    ];

    $args = [
        'labels'            => $labels,
        'hierarchical'      => true,    // как категории (не теги)
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,    // показывать в списке заметок
        'show_in_rest'      => true,
        'rewrite'           => [ 'slug' => 'priority' ],
    ];

    register_taxonomy( 'note_priority', 'usm_note', $args );
}
add_action( 'init', 'usm_notes_register_taxonomy' );
```

**Что происходит:**
- `'hierarchical' => true` — термины можно вкладывать друг в друга (родитель → дочерний), как у категорий
- `'show_admin_column' => true` — в списке заметок автоматически появится колонка «Приоритет»
- Второй аргумент `'usm_note'` — привязываем таксономию к нашему CPT

**Добавить термины приоритетов:**
После сохранения перейдите в **Заметки → Приоритеты** и создайте три термина:
- Название: `High`, Slug: `high`
- Название: `Medium`, Slug: `medium`
- Название: `Low`, Slug: `low`

---

### Шаг 5. Метабокс с датой напоминания

**Цель:** добавить в редактор заметки поле для ввода даты напоминания, сохранять её в базу данных и отображать в списке записей.

**Что такое метабокс?**  
Метабокс — это дополнительный блок (виджет) в редакторе WordPress. Мы создадим блок с полем `<input type="date">`.

Код состоит из четырёх частей:

#### 5.1 — Добавить метабокс в редактор

```php
/**
 * Шаг 5.1. Регистрация метабокса
 */
function usm_notes_add_meta_box() {
    add_meta_box(
        'usm_reminder_date',         // ID метабокса
        'Дата напоминания',          // Заголовок
        'usm_notes_render_meta_box', // Функция отрисовки
        'usm_note',                  // К какому CPT прикрепить
        'side',                      // Расположение: side / normal / advanced
        'high'                       // Приоритет в колонке
    );
}
add_action( 'add_meta_boxes', 'usm_notes_add_meta_box' );
```

#### 5.2 — Отрисовать HTML поля

```php
/**
 * Шаг 5.2. Отрисовка HTML метабокса
 */
function usm_notes_render_meta_box( $post ) {
    // Получаем сохранённое значение (если оно есть)
    $saved_date = get_post_meta( $post->ID, '_usm_reminder_date', true );

    // nonce-поле для защиты от CSRF
    wp_nonce_field( 'usm_notes_save_meta', 'usm_notes_nonce' );

    // Выводим сохранённые ошибки (если есть)
    $error = get_transient( 'usm_notes_error_' . $post->ID );
    if ( $error ) {
        echo '<p style="color:red; font-weight:bold;">' . esc_html( $error ) . '</p>';
        delete_transient( 'usm_notes_error_' . $post->ID );
    }
    ?>
    <p>
        <label for="usm_reminder_date"><strong>Due Date:</strong></label><br>
        <input
            type="date"
            id="usm_reminder_date"
            name="usm_reminder_date"
            value="<?php echo esc_attr( $saved_date ); ?>"
            min="<?php echo date('Y-m-d'); ?>"
            style="width:100%; margin-top:5px;"
            required
        >
    </p>
    <?php
}
```

> **Зачем `min="..."`?** HTML-атрибут `min` запрещает выбрать дату в прошлом прямо в браузере. Но это только клиентская проверка — поэтому обязательно добавляем серверную валидацию в следующем шаге.

#### 5.3 — Сохранить значение при сохранении записи

```php
/**
 * Шаг 5.3. Сохранение даты (с валидацией и nonce-проверкой)
 */
function usm_notes_save_meta( $post_id ) {
    // 1. Проверяем наличие nonce
    if ( ! isset( $_POST['usm_notes_nonce'] ) ) return;

    // 2. Проверяем подлинность nonce
    if ( ! wp_verify_nonce( $_POST['usm_notes_nonce'], 'usm_notes_save_meta' ) ) return;

    // 3. Пропускаем автосохранение
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

    // 4. Проверяем права пользователя
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    // 5. Получаем и очищаем значение
    $date = isset( $_POST['usm_reminder_date'] )
        ? sanitize_text_field( $_POST['usm_reminder_date'] )
        : '';

    // 6. Проверяем: поле не пустое
    if ( empty( $date ) ) {
        set_transient( 'usm_notes_error_' . $post_id, 'Поле "Дата напоминания" обязательно для заполнения.', 45 );
        return;
    }

    // 7. Проверяем: дата не в прошлом
    if ( $date < date( 'Y-m-d' ) ) {
        set_transient( 'usm_notes_error_' . $post_id, 'Дата не может быть в прошлом.', 45 );
        return;
    }

    // 8. Сохраняем в базу данных
    update_post_meta( $post_id, '_usm_reminder_date', $date );
}
add_action( 'save_post', 'usm_notes_save_meta' );
```

> **Подчёркивание перед `_usm_reminder_date`:** по договорённости в WordPress, метаданные с ключом, начинающимся с `_`, считаются «приватными» — они не видны в стандартном блоке «Пользовательские поля» в редакторе.

#### 5.4 — Показать дату в списке записей в админке

```php
/**
 * Шаг 5.4. Добавление колонки "Дата напоминания" в список заметок
 */
function usm_notes_add_admin_column( $columns ) {
    $columns['reminder_date'] = 'Дата напоминания';
    return $columns;
}
add_filter( 'manage_usm_note_posts_columns', 'usm_notes_add_admin_column' );

function usm_notes_render_admin_column( $column, $post_id ) {
    if ( $column === 'reminder_date' ) {
        $date = get_post_meta( $post_id, '_usm_reminder_date', true );
        echo $date ? esc_html( $date ) : '—';
    }
}
add_action( 'manage_usm_note_posts_custom_column', 'usm_notes_render_admin_column', 10, 2 );
```

---

### Шаг 6. Шорткод для отображения заметок

**Цель:** дать возможность вставлять список заметок на любую страницу сайта с помощью шорткода `[usm_notes]`.

**Что такое шорткод?**  
Шорткод — это специальный тег в квадратных скобках, который WordPress заменяет на HTML-код. Например, `[usm_notes priority="high"]` превратится в список карточек с заметками.

#### 6.1 — Функция обработки шорткода

```php
/**
 * Шаг 6. Шорткод [usm_notes priority="X" before_date="YYYY-MM-DD"]
 */
function usm_notes_shortcode( $atts ) {
    // Устанавливаем значения по умолчанию
    $atts = shortcode_atts( [
        'priority'    => '',
        'before_date' => '',
    ], $atts, 'usm_notes' );

    // Базовые аргументы для WP_Query
    $args = [
        'post_type'      => 'usm_note',
        'posts_per_page' => -1,          // показать все заметки
        'post_status'    => 'publish',
    ];

    // Фильтр по приоритету (таксономия)
    if ( ! empty( $atts['priority'] ) ) {
        $args['tax_query'] = [[
            'taxonomy' => 'note_priority',
            'field'    => 'slug',
            'terms'    => sanitize_text_field( $atts['priority'] ),
        ]];
    }

    // Фильтр по дате (метаполе)
    if ( ! empty( $atts['before_date'] ) ) {
        $args['meta_query'] = [[
            'key'     => '_usm_reminder_date',
            'value'   => sanitize_text_field( $atts['before_date'] ),
            'compare' => '<=',
            'type'    => 'DATE',
        ]];
    }

    $query = new WP_Query( $args );

    // Если заметок нет — выводим сообщение
    if ( ! $query->have_posts() ) {
        return '<p class="usm-no-notes">Нет заметок с заданными параметрами.</p>';
    }

    // Строим HTML вывод
    $output = '<div class="usm-notes-list">';
    while ( $query->have_posts() ) {
        $query->the_post();

        $date          = get_post_meta( get_the_ID(), '_usm_reminder_date', true );
        $terms         = get_the_terms( get_the_ID(), 'note_priority' );
        $priority      = $terms ? esc_html( $terms[0]->name ) : '—';
        $priority_slug = $terms ? esc_attr( $terms[0]->slug ) : 'none';

        $output .= sprintf(
            '<div class="usm-note usm-priority-%s">
                <h3 class="usm-note-title">%s</h3>
                <span class="usm-priority-badge usm-badge-%s">%s</span>
                <span class="usm-date">📅 %s</span>
                <div class="usm-content">%s</div>
            </div>',
            $priority_slug,
            esc_html( get_the_title() ),
            $priority_slug,
            $priority,
            esc_html( $date ),
            wp_kses_post( get_the_excerpt() )
        );
    }
    $output .= '</div>';
    wp_reset_postdata(); // сбрасываем глобальный запрос

    return $output;
}
add_shortcode( 'usm_notes', 'usm_notes_shortcode' );
```

#### 6.2 — CSS стили для фронтенда

```php
/**
 * Шаг 6.2. Подключение CSS стилей
 */
function usm_notes_enqueue_styles() {
    wp_add_inline_style( 'wp-block-library', '
        .usm-notes-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin: 20px 0;
        }
        .usm-note {
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 18px;
            width: calc(33% - 20px);
            box-shadow: 0 2px 6px rgba(0,0,0,0.07);
            border-left: 5px solid #ccc;
        }
        .usm-priority-high   { border-left-color: #e74c3c; }
        .usm-priority-medium { border-left-color: #f39c12; }
        .usm-priority-low    { border-left-color: #2ecc71; }
        .usm-note-title { margin: 0 0 10px; font-size: 1.1em; }
        .usm-priority-badge {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 12px;
            font-size: 0.8em;
            font-weight: bold;
            color: #fff;
            margin-bottom: 8px;
        }
        .usm-badge-high   { background: #e74c3c; }
        .usm-badge-medium { background: #f39c12; }
        .usm-badge-low    { background: #2ecc71; }
        .usm-date { display: block; color: #666; font-size: 0.9em; margin-bottom: 8px; }
        .usm-no-notes { color: #888; font-style: italic; }
        @media (max-width: 768px) {
            .usm-note { width: 100%; }
        }
    ' );
}
add_action( 'wp_enqueue_scripts', 'usm_notes_enqueue_styles' );
```

![img](/images/2.png)

![img](/images/3.png)
---

### Шаг 7. Тестирование плагина

**Цель:** убедиться, что всё работает — заметки создаются, приоритеты назначаются, даты сохраняются, шорткод отображает данные.

#### 7.1 — Создать термины приоритетов

1. Перейдите в **Заметки → Приоритеты**
2. Добавьте три термина:

| Название | Slug   |
|----------|--------|
| High     | high   |
| Medium   | medium |
| Low      | low    |

![img](/images/4.png)

#### 7.2 — Создать 5–6 заметок

Для каждой заметки:
1. **Заметки → Добавить заметку**
2. Заполните заголовок и краткое описание
3. В правой панели назначьте **Приоритет** (High / Medium / Low)
4. В метабоксе **Дата напоминания** выберите дату (не раньше сегодня)
5. Нажмите **Опубликовать**

**Пример набора тестовых заметок:**

| Заголовок                  | Приоритет | Дата напоминания |
|----------------------------|-----------|------------------|
| Сдать курсовую работу      | High      | 2026-03-25       |
| Прочитать документацию WP  | Medium    | 2026-04-10       |
| Обновить зависимости       | Low       | 2026-05-01       |
| Написать тесты             | High      | 2026-03-29       |
| Оформить README            | Medium    | 2026-04-05       |
| Записаться на экзамен      | Low       | 2026-06-01       |

![img](/images/5.png)

![img](/images/6.png)

#### 7.3 — Создать страницу «All Notes»

1. **Страницы → Добавить новую**
2. Заголовок: `All Notes`
3. В редакторе добавьте три блока «Шорткод»:

![img](/images/7.png)

```


4. Опубликуйте страницу и откройте её на фронтенде.

#### 7.4 — Проверки

- [ ] Все заметки отображаются при `[usm_notes]`
- [ ] Только High-заметки при `[usm_notes priority="high"]`
- [ ] Только заметки с датой ≤ 30 апреля при `[usm_notes before_date="2026-04-30"]`
- [ ] Сообщение «Нет заметок с заданными параметрами» при `[usm_notes priority="high" before_date="2026-01-01"]`
- [ ] Карточки имеют цветовую кодировку по приоритету
- [ ] Попытка сохранить заметку без даты — выводит ошибку
- [ ] Попытка ввести дату в прошлом — выводит ошибку

---

## Полный код плагина

Итоговый файл `usm-notes/usm-notes.php`:

```php
<?php
/**
 * Plugin Name: USM Notes
 * Description: Adds a Notes section with priorities and reminder dates.
 * Version:     1.0.0
 * Author:      Оксана Годорожа
 * License:     GPL2
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// === ШАГ 3: CPT ===
function usm_notes_register_cpt() {
    $labels = [
        'name' => 'Заметки', 'singular_name' => 'Заметка',
        'add_new' => 'Добавить', 'add_new_item' => 'Добавить заметку',
        'edit_item' => 'Редактировать', 'not_found' => 'Заметок не найдено',
        'menu_name' => 'Заметки',
    ];
    register_post_type( 'usm_note', [
        'labels' => $labels, 'public' => true, 'has_archive' => true,
        'menu_icon' => 'dashicons-sticky',
        'supports' => ['title','editor','author','thumbnail'],
        'show_in_rest' => true, 'rewrite' => ['slug' => 'notes'],
    ]);
}
add_action( 'init', 'usm_notes_register_cpt' );

// === ШАГ 4: ТАКСОНОМИЯ ===
function usm_notes_register_taxonomy() {
    $labels = [
        'name' => 'Приоритеты', 'singular_name' => 'Приоритет',
        'all_items' => 'Все приоритеты', 'add_new_item' => 'Добавить приоритет',
        'menu_name' => 'Приоритеты',
    ];
    register_taxonomy( 'note_priority', 'usm_note', [
        'labels' => $labels, 'hierarchical' => true, 'public' => true,
        'show_admin_column' => true, 'show_in_rest' => true,
        'rewrite' => ['slug' => 'priority'],
    ]);
}
add_action( 'init', 'usm_notes_register_taxonomy' );

// === ШАГ 5: МЕТАБОКС ===
function usm_notes_add_meta_box() {
    add_meta_box( 'usm_reminder_date', 'Дата напоминания',
        'usm_notes_render_meta_box', 'usm_note', 'side', 'high' );
}
add_action( 'add_meta_boxes', 'usm_notes_add_meta_box' );

function usm_notes_render_meta_box( $post ) {
    $saved_date = get_post_meta( $post->ID, '_usm_reminder_date', true );
    wp_nonce_field( 'usm_notes_save_meta', 'usm_notes_nonce' );
    $error = get_transient( 'usm_notes_error_' . $post->ID );
    if ( $error ) {
        echo '<p style="color:red;font-weight:bold;">' . esc_html( $error ) . '</p>';
        delete_transient( 'usm_notes_error_' . $post->ID );
    }
    ?>
    <p>
        <label for="usm_reminder_date"><strong>Due Date:</strong></label><br>
        <input type="date" id="usm_reminder_date" name="usm_reminder_date"
            value="<?php echo esc_attr( $saved_date ); ?>"
            min="<?php echo date('Y-m-d'); ?>"
            style="width:100%;margin-top:5px;" required>
    </p>
    <?php
}

function usm_notes_save_meta( $post_id ) {
    if ( ! isset( $_POST['usm_notes_nonce'] ) ) return;
    if ( ! wp_verify_nonce( $_POST['usm_notes_nonce'], 'usm_notes_save_meta' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    $date = sanitize_text_field( $_POST['usm_reminder_date'] ?? '' );

    if ( empty( $date ) ) {
        set_transient( 'usm_notes_error_' . $post_id, 'Поле "Дата напоминания" обязательно.', 45 );
        return;
    }
    if ( $date < date( 'Y-m-d' ) ) {
        set_transient( 'usm_notes_error_' . $post_id, 'Дата не может быть в прошлом.', 45 );
        return;
    }
    update_post_meta( $post_id, '_usm_reminder_date', $date );
}
add_action( 'save_post', 'usm_notes_save_meta' );

// Колонка в админке
function usm_notes_add_admin_column( $columns ) {
    $columns['reminder_date'] = 'Дата напоминания';
    return $columns;
}
add_filter( 'manage_usm_note_posts_columns', 'usm_notes_add_admin_column' );

function usm_notes_render_admin_column( $column, $post_id ) {
    if ( $column === 'reminder_date' ) {
        $date = get_post_meta( $post_id, '_usm_reminder_date', true );
        echo $date ? esc_html( $date ) : '—';
    }
}
add_action( 'manage_usm_note_posts_custom_column', 'usm_notes_render_admin_column', 10, 2 );

// === ШАГ 6: ШОРТКОД ===
function usm_notes_shortcode( $atts ) {
    $atts = shortcode_atts( ['priority' => '', 'before_date' => ''], $atts, 'usm_notes' );

    $args = ['post_type' => 'usm_note', 'posts_per_page' => -1, 'post_status' => 'publish'];

    if ( ! empty( $atts['priority'] ) ) {
        $args['tax_query'] = [[
            'taxonomy' => 'note_priority', 'field' => 'slug',
            'terms' => sanitize_text_field( $atts['priority'] ),
        ]];
    }
    if ( ! empty( $atts['before_date'] ) ) {
        $args['meta_query'] = [[
            'key' => '_usm_reminder_date',
            'value' => sanitize_text_field( $atts['before_date'] ),
            'compare' => '<=', 'type' => 'DATE',
        ]];
    }

    $query = new WP_Query( $args );
    if ( ! $query->have_posts() ) {
        return '<p class="usm-no-notes">Нет заметок с заданными параметрами.</p>';
    }

    $output = '<div class="usm-notes-list">';
    while ( $query->have_posts() ) {
        $query->the_post();
        $date  = get_post_meta( get_the_ID(), '_usm_reminder_date', true );
        $terms = get_the_terms( get_the_ID(), 'note_priority' );
        $priority      = $terms ? esc_html( $terms[0]->name ) : '—';
        $priority_slug = $terms ? esc_attr( $terms[0]->slug ) : 'none';
        $output .= sprintf(
            '<div class="usm-note usm-priority-%s">
                <h3 class="usm-note-title">%s</h3>
                <span class="usm-priority-badge usm-badge-%s">%s</span>
                <span class="usm-date">📅 %s</span>
                <div class="usm-content">%s</div>
            </div>',
            $priority_slug, esc_html( get_the_title() ),
            $priority_slug, $priority,
            esc_html( $date ), wp_kses_post( get_the_excerpt() )
        );
    }
    $output .= '</div>';
    wp_reset_postdata();
    return $output;
}
add_shortcode( 'usm_notes', 'usm_notes_shortcode' );

// CSS стили
function usm_notes_enqueue_styles() {
    wp_add_inline_style( 'wp-block-library', '
        .usm-notes-list { display:flex; flex-wrap:wrap; gap:20px; margin:20px 0; }
        .usm-note { background:#fff; border:1px solid #e0e0e0; border-radius:8px;
            padding:18px; width:calc(33% - 20px); box-shadow:0 2px 6px rgba(0,0,0,.07);
            border-left:5px solid #ccc; }
        .usm-priority-high   { border-left-color:#e74c3c; }
        .usm-priority-medium { border-left-color:#f39c12; }
        .usm-priority-low    { border-left-color:#2ecc71; }
        .usm-note-title { margin:0 0 10px; font-size:1.1em; }
        .usm-priority-badge { display:inline-block; padding:2px 10px; border-radius:12px;
            font-size:.8em; font-weight:bold; color:#fff; margin-bottom:8px; }
        .usm-badge-high { background:#e74c3c; }
        .usm-badge-medium { background:#f39c12; }
        .usm-badge-low { background:#2ecc71; }
        .usm-date { display:block; color:#666; font-size:.9em; margin-bottom:8px; }
        .usm-no-notes { color:#888; font-style:italic; }
        @media(max-width:768px){ .usm-note{ width:100%; } }
    ' );
}
add_action( 'wp_enqueue_scripts', 'usm_notes_enqueue_styles' );
```

---

## Справка по шорткоду

```
[usm_notes priority="SLUG" before_date="YYYY-MM-DD"]
```

| Атрибут       | Тип    | Обязателен | Описание                                                     |
|---------------|--------|------------|--------------------------------------------------------------|
| `priority`    | string | Нет        | Slug термина приоритета: `high`, `medium` или `low`          |
| `before_date` | string | Нет        | Дата ISO 8601 — показывает заметки с датой ≤ указанной       |

**Примеры:**

```
[usm_notes]                                        — все заметки
[usm_notes priority="high"]                        — только High
[usm_notes before_date="2026-04-30"]               — дата ≤ 30 апреля 2026
[usm_notes priority="medium" before_date="2026-06-01"]  — Medium до 1 июня
```

Если нет заметок, соответствующих фильтрам — выводится сообщение:  
**«Нет заметок с заданными параметрами.»**

---

## Ответы на контрольные вопросы

### 1. Чем пользовательская таксономия принципиально отличается от метаполя?

**Таксономия** — это классификатор с общим списком значений (терминов), которые могут присваиваться нескольким записям одновременно. Например, термин «High» хранится один раз в таблице `wp_terms` и связывается с любым количеством заметок через таблицу `wp_term_relationships`. Таксономия поддерживает нативные URL-архивы, виджеты, фильтрацию в wp-admin и REST API.

**Метаполе (post meta)** — произвольное значение, привязанное к конкретной записи и хранящееся в таблице `wp_postmeta`. Идеально для уникальных данных: даты, числа, URL.

| Критерий                | Таксономия                              | Метаполе                            |
|-------------------------|-----------------------------------------|-------------------------------------|
| Хранение                | `wp_terms` + `wp_term_relationships`    | `wp_postmeta`                       |
| Повторное использование | Да — один термин у многих записей       | Нет — уникально для каждой записи  |
| Нативная фильтрация     | Да (URL, виджет, `tax_query`)           | Только через `meta_query`           |
| Когда использовать      | Приоритет, Жанр, Категория              | Цена, Дата, Телефон                 |

> **Вывод:** Приоритет (`High/Medium/Low`) → **таксономия** (значения повторяются, нужна фильтрация). Дата напоминания → **метаполе** (уникальна для каждой заметки).

---

### 2. Зачем нужен nonce при сохранении метаполей и что произойдёт без него?

**Nonce (Number Used Once)** — одноразовый токен безопасности, привязанный к пользователю, действию и временному окну (~12 часов).

**Без nonce** злоумышленник может провести CSRF-атаку: создать скрытую HTML-форму на стороннем сайте, которая при открытии автоматически отправит POST-запрос от имени авторизованного администратора. WordPress без проверки nonce примет этот запрос и сохранит вредоносные данные.

**Цепочка защиты в коде:**
1. `wp_nonce_field('usm_notes_save_meta', 'usm_notes_nonce')` — генерирует токен и добавляет `<input type="hidden">` в форму редактора
2. `wp_verify_nonce($_POST['usm_notes_nonce'], 'usm_notes_save_meta')` — проверяет подлинность токена при сохранении
3. Если проверка не пройдена — `return` завершает функцию без сохранения

---

### 3. Какие аргументы register_post_type() и register_taxonomy() важны для фронтенда и UX?

| Аргумент                        | Влияние на UX и фронтенд                                                                                      |
|---------------------------------|---------------------------------------------------------------------------------------------------------------|
| `public => true`                | Делает CPT/таксономию видимой в поиске, архивах и фронтенде — без этого записи недоступны пользователям      |
| `has_archive => true`           | Создаёт архивную страницу `/notes/` со списком всех записей — важно для навигации и SEO                      |
| `rewrite => ['slug' => '...']`  | Формирует читаемые URL (`/notes/my-note/`) вместо технических `/?post_type=usm_note`                         |

Дополнительно: `show_in_rest => true` — включает Gutenberg-редактор и REST API, что критично для современных тем на блоках.

---

## Список использованных источников

1. [WordPress Developer Docs — register_post_type()](https://developer.wordpress.org/reference/functions/register_post_type/)
2. [WordPress Developer Docs — register_taxonomy()](https://developer.wordpress.org/reference/functions/register_taxonomy/)
3. [WordPress Developer Docs — add_meta_box()](https://developer.wordpress.org/reference/functions/add_meta_box/)
4. [WordPress Developer Docs — add_shortcode()](https://developer.wordpress.org/reference/functions/add_shortcode/)
5. [WordPress Developer Docs — wp_nonce_field()](https://developer.wordpress.org/reference/functions/wp_nonce_field/)
6. [WP Kama — register_post_type()](https://wp-kama.com/function/register_post_type)
7. [WP Kama — register_taxonomy()](https://wp-kama.com/function/register_taxonomy)
8. [WP Engine — How to Create a Custom WordPress Meta Box](https://wpengine.com/resources/create-custom-wordpress-meta-box/)
9. [Rudrastyh — WordPress Meta Boxes Ultimate Tutorial](https://rudrastyh.com/wordpress/meta-boxes.html)
10. [Tania Rascia — WordPress Custom Fields and Meta Boxes](https://www.taniarascia.com/wordpress-part-three-custom-fields-and-metaboxes/)
11. [Learn WordPress — Creating Custom Post Types and Taxonomies](https://learn.wordpress.org/lesson/creating-custom-post-types-and-taxonomies/)
12. [Платформа USM elearning — курс wp_cms](https://elearning.usm.md/course/view.php?id=7868)
