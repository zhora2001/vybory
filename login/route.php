<?php


add_action('wp_ajax_nopriv_login_me', 'login_me'); // повесим функцию на аякс запрос с параметром action=login_user для неавторизованых пользователей
//add_action('wp_ajax_login_me', 'login_me'); // повесим функцию на аякс запрос с параметром action=login_user для авторизованых пользователей, будет логичнее этого не делать, т.к. логинется залогиненому не надо =/
function login_me(){
	require_once dirname(__FILE__) . '/login.php'; // тут подключим файл с обработкой действий при логине (лежит в той же папке что и route.php)
}

//add_action('wp_ajax_nopriv_logout_me', 'logout_me'); // повесим функцию на аякс запрос с параметром action=login_user для неавторизованых пользователей, тоже без смысла
add_action('wp_ajax_logout_me', 'logout_me'); // повесим функцию на аякс запрос с параметром action=logout_me для авторизованых пользователей
function logout_me() { // logout
   require_once dirname(__FILE__) . '/logout.php';  // подключим нужный обработчик
}
