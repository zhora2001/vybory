<?php

$nonce = $_POST['nonce'];
$nonce1 = $_POST['nonce1'];
//$nonce = isset($_POST['nonce']) ? $_POST['nonce'] : ''; // сначала возьмем скрытое поле nonce

if (!wp_verify_nonce($nonce, 'reg_nuser')) wp_send_json_error(array('message' => 'Данні відправлені з стороньої адреси '.$nonce." ".$nonce1." ", 'redirect' => false)); // проверим его, и если вернулся фолс - исаользуем wp_send_json_error и умираем

if (!(is_user_logged_in() && ( current_user_can('manage_options') || is_user_role("raion"))))
   wp_send_json_error(array('message' => 'Реєстрація користувачів недоступна.', 'redirect' => false));


// теперь возьмем все поля и рассуем по переменным
$user_login = isset($_POST['tel']) ? $_POST['tel'] : '';
$user_email = isset($_POST['user_email']) ? $_POST['user_email'] : '';
$pass1 = isset($_POST['pass1']) ? $_POST['pass1'] : '';
$first_name = isset($_POST['ufamily']) ? $_POST['ufamily'] : '';
$last_name = isset($_POST['uname']) ? $_POST['uname'] : '';
$diln = isset($_POST['dl'])? $_POST['dl']:'';
$kusch = isset($_POST['ksch'])? $_POST['ksch']: '';

$redirect_to = isset($_POST['redirect_to']) ? $_POST['redirect_to'] : false;

// теперь проверим нужные поля на заполненность и валидность
if (!$user_email) wp_send_json_error(array('message' => 'Email - обязательное поле.', 'redirect' => false));
if (!preg_match("|^[-0-9a-z_\.]+@[-0-9a-z_^\.]+\.[a-z]{2,6}$|i", $user_email)) wp_send_json_error(array('message' => 'Ошибочный формат email', 'redirect' => false));
if (!$user_login) wp_send_json_error(array('message' => 'Логин - обязательное поле.', 'redirect' => false));
if (!$pass1) wp_send_json_error(array('message' => 'Пароль - обязательное поле.', 'redirect' => false));
if ($diln && $kusch) wp_send_json_error(array('message' => 'Не вибрано дільницю або кущ.', 'redirect' => false));


$userdata = array(
		'user_login' => $_POST['tel'],
		'user_pass'  => $_POST['pass1'],
		'user_email' => $_POST['user_email'],
		'first_name' => $_POST['ufamily'],
		'nickname'   => $_POST['uname'],
	);
// теперь проверим все ли ок с паролями
if (strlen($pass1) < 4) wp_send_json_error(array('message' => 'Слишком короткий пароль', 'redirect' => false));
if (false !== strpos(wp_unslash($pass1), "\\" ) ) wp_send_json_error(array('message' => 'Пароль не может содержать обратные слеши "\\"', 'redirect' => false));

$user_id = wp_insert_user( $userdata );


// если есть ошибки
if (is_wp_error($user_id) && $user_id->get_error_code() == 'existing_user_email') wp_send_json_error(array('message' => 'Пользователь с таким email уже существует.', 'redirect' => false));
elseif (is_wp_error($user_id) && $user_id->get_error_code() == 'existing_user_login') wp_send_json_error(array('message' => 'Пользователь с таким логином уже существует.', 'redirect' => false));
elseif (is_wp_error($user_id) && $user_id->get_error_code() == 'empty_user_login') wp_send_json_error(array('message' => 'Логин только латиницей.', 'redirect' => false));
elseif (is_wp_error($user_id)) wp_send_json_error(array('message' => $user_id->get_error_code(), 'redirect' => false));


add_user_meta( $user_ID, "diln", $_POST['dl'],true );
add_user_meta( $user_ID, "kusch", $_POST['ksch'],true );
add_user_meta( $user_ID, "tel", $_POST['tel'],true );

wp_send_json_success(array('message' => 'Користувач зареєстрований.', 'redirect' => false)); // говорим что все прошло ок, если нужен редирект то вместо false поставьте $redirect_to

?>
