<?php
add_action('wp_print_scripts','include_scripts'); // повесим функцию на событие вывода скриптов
function include_scripts(){
  wp_deregister_script('jquery');
wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"), false, '1.3.2');
wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-form'); // добавим в скрипты плагин jQuery forms
    wp_enqueue_script('for_users', get_template_directory_uri() . '/js/for_users.js', array('jquery-form')); // добавим скрипт обработки форм
    wp_enqueue_script('input_pr.js', get_template_directory_uri() . '/js/input_pr.js', array('jquery-form')); // добавим скрипт обработки форм
    wp_enqueue_script('jquery-chained', '//www.appelsiini.net/projects/chained/jquery.chained.min.js'); // добавим плагин для связанных селект листов
    wp_localize_script( 'jquery', 'ajax_var', // добавим объект с глобальными JS переменными
	array(
	    'url' => admin_url('admin-ajax.php'), // и сунем в него путь до AJAX обработчика
	)
    );

        wp_localize_script( 'jquery', 'ajaxdata', // функция для передачи глобальных js переменных на страницу, первый аргумент означет перед каким скриптом вставить переменные, второй это название глобального js объекта в котором эти переменные будут храниться, последний аргумент это массив с самими переменными
			array(
   				'url' => admin_url('admin-ajax.php'), // передадим путь до нативного обработчика аякс запросов в wp, в js можно будет обратиться к ней так: ajaxdata.url
   				'nonce' => wp_create_nonce('add_object') // передадим уникальную строку для механизма проверки аякс запроса, ajaxdata.nonce
			)
		);
}


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

add_action( 'wp_ajax_nopriv_add_object_ajax', 'add_object' ); // крепим на событие wp_ajax_nopriv_add_object_ajax, где add_object_ajax это параметр action, который мы добавили в перехвате отправки формы, add_object - ф-я которую надо запустить
add_action('wp_ajax_add_object_ajax', 'add_object'); // если нужно чтобы вся бадяга работала для админов
function add_object() {
	$errors = ''; // сначала ошибок нет

	$nonce = $_POST['nonce']; // берем переданную формой строку проверки
	if (!wp_verify_nonce($nonce, 'add_object')) { // проверяем nonce код, второй параметр это аргумент из wp_create_nonce
		$errors .= 'Данные отправлены с левой страницы '; // пишим ошибку
	}

	// запишем все поля
	$parent_cat = (int)$_POST['parent_cats']; // переданный id термина таксономии с вложенностью (родитель)
	$child_cat = (int)$_POST['child_cats']; // id термина таксономии с вложенностью (его дочка)
	$tag = (int)$_POST['tag']; // id обычной таксономии
	$title = strip_tags($_POST['post_title']); // запишем название поста
	$content = wp_kses_post($_POST['post_content']); // контент
	$string_field = strip_tags($_POST['string_field']); // произвольное поле типа строка
	$text_field = wp_kses_post($_POST['text_field']); // произвольное поле типа текстарея

	// проверим заполненность, если пусто добавим в $errors строку
	if (!$parent_cat) $errors .= 'Не выбрано "Кастом категория-родитель"';
    if (!$child_cat) $errors .= 'Не выбрано "Кастом категория-ребенок xD"';
    if (!$tag) $errors .= 'Не выбрано "Кастом тэг"';
    if (!$title) $errors .= 'Не заполнено поле "Тайтл"';
    if (!$content) $errors .= 'Не заполнено поле "Пост контент"';

    // далее проверим все ли нормально с картинками которые нам отправили
    if ($_FILES['img']) { // если была передана миниатюра
   		if ($_FILES['img']['error']) $errors .= "Ошибка загрузки: " . $_FILES['img']['error'].". (".$_FILES['img']['name'].") "; // серверная ошибка загрузки
    	$type = $_FILES['img']['type'];
		if (($type != "image/jpg") && ($type != "image/jpeg") && ($type != "image/png")) $errors .= "Формат файла может быть только jpg или png. (".$_FILES['img']['name'].")"; // неверный формат
	}

	if ($_FILES['imgs']) { // если были переданны дополнительные картинки, пробежимся по ним в цикле и проверим тоже самое
		foreach ($_FILES['imgs']['name'] as $key => $array) {
			if ($_FILES['imgs']['error'][$key]) $errors .= "Ошибка загрузки: " . $_FILES['imgs']['error'][$key].". (".$key.$_FILES['imgs']['name'][$key].") ";
    		$type = $_FILES['imgs']['type'][$key];
			if (($type != "image/jpg") && ($type != "image/jpeg") && ($type != "image/png")) $errors .= "Формат файла может быть только jpg или png. (".$_FILES['imgs']['name'][$key].")";
		}
	}

	if (!$errors) { // если с полями все ок, значит можем добавлять пост
		$fields = array( // подготовим массив с полями поста, ключ это название поля, значение - его значение
			'post_type' => 'qq', // нужно указать какой тип постов добавляем, у нас это my_custom_post_type
	    	'post_title'   => $title, // заголовок поста
	        'post_content' => $content, // контент
	    );
	    $post_id = wp_insert_post($fields); // добавляем пост в базу и получаем его id

	    update_post_meta($post_id, 'string_field', $string_field); // заполняем произвольное поле типа строка
	    update_post_meta($post_id, 'text_field', $text_field); // заполняем произвольное поле типа текстарея

	    wp_set_object_terms($post_id, $parent_cat, 'custom_tax_like_cat', true); // привязываем к пост к таксономиям, третий параметр это слаг таксономии
	    wp_set_object_terms($post_id, $child_cat, 'custom_tax_like_cat', true);
	    wp_set_object_terms($post_id, $tag, 'custom_tax_like_tag', true);

	    if ($_FILES['img']) { // если основное фото было загружено
   			$attach_id_img = media_handle_upload( 'img', $post_id ); // добавляем картинку в медиабиблиотеку и получаем её id
   			update_post_meta($post_id,'_thumbnail_id',$attach_id_img); // привязываем миниатюру к посту
		}

		if ($_FILES['imgs']) { // если дополнительные фото были загружены
			$imgs = array(); // из-за того, что дефолтный массив с загруженными файлами в пхп выглядит не так как нужно, а именно вся инфа о файлах лежит в разных массивах но с одинаковыми ключами, нам нужно создать свой массив с блэкджеком, где у каждого файла будет свой массив со всеми данными
			foreach ($_FILES['imgs']['name'] as $key => $array) { // пробежим по массиву с именами загруженных файлов
				$file = array( // пишем новый массив
					'name' => $_FILES['imgs']['name'][$key],
					'type' => $_FILES['imgs']['type'][$key],
					'tmp_name' => $_FILES['imgs']['tmp_name'][$key],
					'error' => $_FILES['imgs']['error'][$key],
					'size' => $_FILES['imgs']['size'][$key]
				);
				$_FILES['imgs'.$key] = $file; // записываем новый массив с данными в глобальный массив с файлами
				$imgs[] = media_handle_upload( 'imgs'.$key, $post_id ); // добавляем текущий файл в медиабиблиотека, а id картинки суем в другой массив
			}
			update_post_meta($post_id,'multifile_field',$imgs); // привязываем все картинки к посту
		}
	}

	if ($errors) wp_send_json_error($errors); // если были ошибки, выводим ответ в формате json с success = false и умираем
	else wp_send_json_success('Все прошло отлично! Добавлено ID:'.$post_id); // если все ок, выводим ответ в формате json с success = true и умираем

	die(); // умрем еще раз на всяк случ
}
