<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'rnscv_db');
                   	
/** Имя пользователя MySQL */
define('DB_USER', 'rnscv_db');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', 'D6qGAMZt');

/** Имя сервера MySQL */
define('DB_HOST', 'rnscv.mysql.ukraine.com.ua');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8mb4');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '.nl)sLUR_IA3a-D{eq#ECz0@kN}ibT.8{jfw&*>+r?~, m>6KJ~-T$Wz.#oC,3p{');
define('SECURE_AUTH_KEY',  'S{EpT:fa9W:ZUHqZRNu6G ,Df5LhUl-Yk(l,ZsAtZ}) SS1Vv7HtB_xY08A$k-OD');
define('LOGGED_IN_KEY',    'g=8cFa!]5o#w>HGtz`{}&r+r?lVCAb8~.v!mN9e]0>$g7LnT57/Uq~kSN4/~D&B>');
define('NONCE_KEY',        'LBM0~>%1.|Ai_M:duy:?#UNT/0TNBX^^9h0AVW{^[N2B g.Gue38Jh#eYGa6))yH');
define('AUTH_SALT',        ' T4s_YZzW2#kpxV:fYnpoOZ711$LKdBf<*Ee>rWq-803]pI)A-f04Jhk}kHe*h-a');
define('SECURE_AUTH_SALT', ':#iNxs5]KMzjqrk}+a+.HI@%))6v)BJ6Ypas*o6BXG.R=}^b`glsZlM9g`LMD(l ');
define('LOGGED_IN_SALT',   '|fz^XUbsTEw]E:,] G/Jw$0^o>@et$(o`~V2@-fh&6Hm3 |laUn^RoXWTA-7~u:Q');
define('NONCE_SALT',       'cC;y/YkRiiJk[CB3n6e}KpC>iX4DcrMXI|w,rG(AS<AbE/ /9&HD<?g1m&yp42Ua');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'ds_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 * 
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
