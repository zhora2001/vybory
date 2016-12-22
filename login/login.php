<?php
session_start();
//проверяет соответствие коду CAPTCHA
if ($_SESSION["code"] == $_POST["captcha"]) {
  //сообщаем строку true, если код соответствует
$nonce = isset($_POST['nonce']) ? $_POST['nonce'] : ''; // сначала возьмем строку безопасности
if (!wp_verify_nonce($nonce, 'login_me_nonce')) wp_send_json_error(array('message' => 'Данные присланные со сторонней страницы ', 'redirect' => false)); // проверим её специальной функцией, а если строки не совпадут отправляем json ответ с ошибкой, функция wp_send_json_error сама прекратит работу скрипта

if (is_user_logged_in()) wp_send_json_error(array('message' => 'Вы уже авторизованы.', 'redirect' => false)); // теперь проверим не залогинен ли уже юзер, если да, то ошибка

$log = isset($_POST['log']) ? $_POST['log'] : false; // получаем данные с формы
$pwd = isset($_POST['pwd']) ? $_POST['pwd'] : false;
$redirect_to = isset($_POST['redirect_to']) ? $_POST['redirect_to'] : false;
$rememberme = isset($_POST['rememberme']) ? $_POST['rememberme'] : false;

if (!$log) wp_send_json_error(array('message' => 'Поле логин или email не заполнено', 'redirect' => false)); // если что то из полей пусто - ошибка
if (!$pwd) wp_send_json_error(array('message' => 'Поле пароль не заполнено', 'redirect' => false));

$user = get_user_by( 'login', $log ); // саначала попробуем найти юзера по логину
if (!$user) $user = get_user_by( 'email', $log ); // если там пусто, значит попробуем получить юзера по мылу

if (!$user) wp_send_json_error(array('message' => 'Ошибочное логин/email или пароль.', 'redirect' => false)); // если в обоих случаях пустота, значит такого юзера нет - возвращаем ошибку и умираем
if (get_user_meta( $user->ID, 'has_to_be_activated', true ) != false) wp_send_json_error(array('message' => 'Пользователь еще не активирован.', 'redirect' => false)); // закомментить если не используется активация, см. след. статьи

$log = $user->user_login; // если скрипт работает значит юзер есть - достанем логин

$creds = array( // создаем массив с данными для логина
	'user_login' => $log,
	'user_password' => $pwd,
	'remember' => $rememberme
);

$user = wp_signon( $creds, false ); // пробуем залогинется
if (is_wp_error($user))
wp_send_json_error(array('message' => 'Помилкові логін або пароль.', 'redirect' => false));
else wp_send_json_success(array('message' => 'Раді Вас бачити...'.$user->display_name.'. Завантажуємось ...', 'redirect' => site_url()));
	// иначе все прошло ок и юзера залогинили пишем что все ок и отпраляем
}
else {
  //сообщаем строку false, если код не соответствует
wp_send_json_error(array('message' => 'Введіть вірно код із зображення.', 'redirect' => false));

}

?>
