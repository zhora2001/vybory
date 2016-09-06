<?php
/*
Plugin Name: 1Vybory Organizer
Description: Организация виборчої компании
Version: 0.01
Author: Івасик Телесик
Author URI:
include ('my_wydget.php');
*/

require_once dirname(__FILE__).'/login/route.php'; // подключаем распределитель дел

function cp1251_to_utf8 ($txt)  {
    $in_arr = array (
        chr(208), chr(192), chr(193), chr(194),
        chr(195), chr(196), chr(197), chr(168),
        chr(198), chr(199), chr(200), chr(201),
        chr(202), chr(203), chr(204), chr(205),
        chr(206), chr(207), chr(209), chr(210),
        chr(211), chr(212), chr(213), chr(214),
        chr(215), chr(216), chr(217), chr(218),
        chr(219), chr(220), chr(221), chr(222),
        chr(223), chr(224), chr(225), chr(226),
        chr(227), chr(228), chr(229), chr(184),
        chr(230), chr(231), chr(232), chr(233),
        chr(234), chr(235), chr(236), chr(237),
        chr(238), chr(239), chr(240), chr(241),
        chr(242), chr(243), chr(244), chr(245),
        chr(246), chr(247), chr(248), chr(249),
        chr(250), chr(251), chr(252), chr(253),
        chr(254), chr(255)
    );

    $out_arr = array (
        chr(208).chr(160), chr(208).chr(144), chr(208).chr(145),
        chr(208).chr(146), chr(208).chr(147), chr(208).chr(148),
        chr(208).chr(149), chr(208).chr(129), chr(208).chr(150),
        chr(208).chr(151), chr(208).chr(152), chr(208).chr(153),
        chr(208).chr(154), chr(208).chr(155), chr(208).chr(156),
        chr(208).chr(157), chr(208).chr(158), chr(208).chr(159),
        chr(208).chr(161), chr(208).chr(162), chr(208).chr(163),
        chr(208).chr(164), chr(208).chr(165), chr(208).chr(166),
        chr(208).chr(167), chr(208).chr(168), chr(208).chr(169),
        chr(208).chr(170), chr(208).chr(171), chr(208).chr(172),
        chr(208).chr(173), chr(208).chr(174), chr(208).chr(175),
        chr(208).chr(176), chr(208).chr(177), chr(208).chr(178),
        chr(208).chr(179), chr(208).chr(180), chr(208).chr(181),
        chr(209).chr(145), chr(208).chr(182), chr(208).chr(183),
        chr(208).chr(184), chr(208).chr(185), chr(208).chr(186),
        chr(208).chr(187), chr(208).chr(188), chr(208).chr(189),
        chr(208).chr(190), chr(208).chr(191), chr(209).chr(128),
        chr(209).chr(129), chr(209).chr(130), chr(209).chr(131),
        chr(209).chr(132), chr(209).chr(133), chr(209).chr(134),
        chr(209).chr(135), chr(209).chr(136), chr(209).chr(137),
        chr(209).chr(138), chr(209).chr(139), chr(209).chr(140),
        chr(209).chr(141), chr(209).chr(142), chr(209).chr(143)
    );

    $txt = str_replace($in_arr,$out_arr,$txt);
    return $txt;
}

function csv_to_array($filename='', $delimiter=',')
{
    if(!file_exists($filename) || !is_readable($filename))
        return FALSE;

    $header = NULL;
    $data = array();
    if (($handle = fopen($filename, 'r')) !== FALSE)
    {
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
        {
            if(!$header)
                $header = cp1251_to_utf8($row);
            else
                $data[] = array_combine($header, $row);
        }
        fclose($handle);
    }
    return $data;
}

function parse_csv($file, $options = null) {
    $delimiter = empty($options['delimiter']) ? "," : $options['delimiter'];
    $to_object = empty($options['to_object']) ? false : true;
    $str = file_get_contents($file);
    $lines = explode("\n", $str);
    //pr($lines);
    $field_names = explode($delimiter, array_shift($lines));
    foreach ($lines as $line) {
        // Skip the empty line
        if (empty($line)) continue;
        $fields = explode($delimiter, $line);
        $_res = $to_object ? new stdClass : array();
        foreach ($field_names as $key => $f) {
            if ($to_object) {
                $_res->{$f} = $fields[$key];
            } else {
                $_res[$f] = $fields[$key];
            }
        }
        $res[] = $_res;
    }
    return $res;
}

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF']))
{ die('You are not allowed to call this page directly.'); }

register_activation_hook (__FILE__, 'tvk_activated');
register_deactivation_hook (__FILE__, 'tvk_deactivated');


function tvk_activated ()
{
  $result = add_role(
  	'dilnich', 'Дільничний',
  	array(
      'create_posts'         => true,
      'read'         => true,  // true разрешает эту возможность
  		'edit_posts'   => true,  // true разрешает редактировать посты
  		'delete_posts' => false, // false запрещает удалять посты
      'upload_files' => true,
    )
  );

  $result = add_role(
  	'kusch', 'Кущовий',
  	array(
      'create_posts'         => true,
      'read'         => true,  // true разрешает эту возможность
  		'edit_posts'   => true,  // true разрешает редактировать посты
  		'delete_posts' => false, // false запрещает удалять посты
      'upload_files' => true,
  	)
  );

  $result = add_role(
    'raion', 'Районний',
    array(
      'read'         => true,  // true разрешает эту возможность
      'edit_posts'   => true,  // true разрешает редактировать посты
      'delete_posts' => true, // false запрещает удалять посты
      'upload_files' => true,
    )
  );

}


function tvk_deactivated ()
{
remove_role('dilnich');
remove_role('kusch');
remove_role('raion');
}

// Відключаємо обновлення
remove_action('load-update-core.php','wp_update_themes');
add_filter('pre_site_transient_update_themes',create_function('$a', "return null;"));
wp_clear_scheduled_hook('wp_update_themes');

// Додаємо колонки в список користувачів

add_filter('manage_users_columns', 'add_users_comm_column', 4);
function add_users_comm_column( $columns ){
	$columns['diln'] = 'Дільниця.';
	$columns['kusch'] = 'Кущ'; // добавляет дату реги
	//unset( $columns['posts'] ); // удаляет колонку посты

	return $columns;
}

/*
add_filter('manage_posts_columns', 'add_posts_comm_column', 4);
function add_posts_comm_column( $columns ){
	$columns['diln'] = 'Дільниця.';

	return $columns;
}
*/

// Заповнюємо додаткові колонки в списку користувачів

add_filter('manage_users_custom_column', 'fill_users_comm_column', 5, 3); // wp-admin/includes/class-wp-posts-list-table.php
function fill_users_comm_column( $foo, $column_name, $user_id ) {
	global $wpdb;

//	$userdata = get_user_meta( $user_id, $key, true );

	if( $column_name == 'diln' ){
		$w = get_user_meta( $user_id, 'diln', true );
		$out = $w? '<p>'. $w .'</p>' : '';
	}
	elseif( $column_name == 'kusch' ){
		$w = get_user_meta( $user_id, 'kusch', true );
		$out = $w? '<p>'. $w .'</p>' : '';
	}

	return $out;
}


// Створення та заповнення мeтаданих користувача
    add_action('user_new_form', 'tvk_new_role_field');
    add_action('show_user_profile', 'tvk_new_role_field');
    add_action('edit_user_profile', 'tvk_new_role_field');

    function wpdocs_plugin_admin_init() {
        // Register our script.
        wp_register_script( 'my-plugin-script', plugins_url( 'js/glavn.js', __FILE__ ) );
    }
    add_action( 'admin_init', 'wpdocs_plugin_admin_init' );


function tvk_new_role_field($user) {
wp_enqueue_script('my-plugin-script');

        ?>
        <script  type="text/javascript">
          jQuery(function(){
            var endings = ["mail.ru", "list.ru", "rambler.ru", "yandex.ru", "gmail.com"],
                symbols = "qwertyuiopasdfghjklzxcvbnm1234567890";
            function rand(min, max) {
                return (min + Math.random() * (max - min + 1)) | 0;
                  }

                    function getRandomStr(len) {
                        var ret = ""
                          for (var i = 0; i < len; i++)
                            ret += symbols[rand(0, symbols.length - 1)];
                              return ret;
                            }

                              function getEmail() {
                                  var a = getRandomStr(rand(3, 5)),
                                  b = getRandomStr(rand(3, 5));
                                  return a + "." + b + "@" + endings[rand(0, endings.length - 1)];
                                }


          jQuery("#url").parent().parent().hide();
          jQuery("#send_user_notification").prop("checked",false);
          jQuery("#send_user_notification").parent().parent().parent().hide();
          if(jQuery("#email").val.Trim() != '')
          jQuery("#email").val(getEmail);

          </script>
        <table class="form-table" id="dn">
            <tr class="form-field">
                <th scope="row"><label for="mail_chimp">Дільниці </label></th>
                <td>
                  <label for="dl">
		                  <select id = "vv" name="dl">
 		                        <?php
                            $var3 = '1';
                            $result = csv_to_array(__DIR__.'/diln.csv',';');
                            $key = 'diln';
                            $var2 = get_user_meta( $user->ID, $key, true );



                            foreach($result as $var1)
                            {
                              echo "<div>";
                                    echo  print_r($var1);
                                echo "</div>";
                              if( trim($var1) == trim($var2))
                              {
                              $a = cp1251_to_utf8 ($var1['diln']);
                              echo "<option value=".$var1['n_diln']." selected>Дільниця № $a </option>";
                              $var3 = '2';
                              }
                              else {
                                $a = $var1['diln'];
                                echo "<option value=".$var1['n_diln']." selected>Дільниця № $a </option>";
                        //          echo "<option value=".$var1.">Дільниця № $var1 </option>";

                              }
                            }
                            if ($var3 == '1')
                          echo " <option disabled selected>Выберіть дільницю</option>
    	                    ";
                          ?>
                        </select>
                  </label>
                </td>
            </tr>
        </table>
        <table class="form-table" id="kusch">
          <tr class="form-field">
                <th scope="row"><label for="mail_chimp">Виберіть Кущ </label></th>
                <td>

                  <label for="ksch">
                    <select id = "vv1" name="ksch">
                      <option disabled selected>Виберіть кущ</option>
                      <?php

                        $result = file(__DIR__.'/kusch.txt');
                        $i=1;
                        foreach($result as $var1)
                        {
                        $q=explode(";",$var1);
                        echo "<option value=".$q[1]."><strong>$q[0]</strong> - дільниці ($q[1])</option>";
                        $i++;
                      }
                      ?>
                    </select>
                  </label>
                </td>

        </table>
        <script  type="text/javascript">

        jQuery("#dn").hide();
        jQuery("#kusch").hide();

                  	if (jQuery('#role'))
        		{
        		if(!(jQuery('#role').val() != ''))
            {
            jQuery("#role [value='dilnich']").prop('selected', true).
        		jQuery("#dn").show();
            jQuery("#kusch").hide();
        		}
        		else
        		{
        		   jQuery("#dn").hide();
        			 jQuery("#kusch").hide();
        		}
          }
          else
          {
             jQuery("#dn").show();
             jQuery("#kusch").show();
          }


                  //jQuery('.wp-generate-pw').click();})
          jQuery(function(){});

</script>      <?php
    }

// Зміна та корегування даних про дільницю

    add_action( 'user_register', 'meta_diln', 10, 1 );

    function meta_diln ( $user_id ) {
//        if (isset($_POST['email']) && isset($_POST['mail_chimp']) && $_POST['mail_chimp'] == 'on') {
//            mailchimp_subscribe($_POST['email']);
//        }
	add_user_meta( $user_ID, "diln", $_POST['dl'],false );
	add_user_meta( $user_ID, "kusch", $_POST['ksch'],false );
 }

  //Save new field for user in users_meta table
//    add_action('user_register', 'save_meta_diln_field');
    add_action('edit_user_profile_update', 'save_meta_diln_field');

    function save_meta_diln_field($user_id) {

        if (!current_user_can('edit_user', $user_id)) {
            return false;
        }

//        if (isset($_POST['mail_chimp']) && $_POST['mail_chimp'] == 'on') {
//            update_usermeta($user_id, 'mail_chimp', true);
//        }
//        else {
//            update_usermeta($user_id, 'mail_chimp', false);
//  ////            mailchimp_unsubscribe(get_userdata($user_id)->user_email);
//        }

add_user_meta( $user_ID, "diln", $_POST['dl'],false );
add_user_meta( $user_ID, "kusch", $_POST['ksch'],false );

            update_usermeta($user_id, 'diln', $_POST['dl']);
            update_usermeta($user_id, 'kusch', $_POST['ksch']);
    }


// Отключаем возможность редактировать профиль
/*
    function gb_disable_user_profile() {
      if( IS_PROFILE_PAGE === true )
      {
        wp_die( 'Пожалуйста, свяжитесь с администрацией сайта, если хотите отредактировать свой профиль.' );
      }
        remove_menu_page( 'profile.php' );
        remove_submenu_page( 'users.php', 'profile.php' );
        }

  add_action( 'admin_init', 'gb_disable_user_profile' );

*/
// Обмеження для своїх постів

  function posts_for_current_author($query) {
//      global $pagenow;
       global $pagenow;

      if ( !is_user_logged_in() )
{
//   if ( $query->is_front_page() && $query->is_main_query() )
  $query->set('author','7');
}
else
{
  $current_user = wp_get_current_user();
    if ( $current_user->ID !=7 )
    $query->set('author__not_in',array(7));
      if( 'edit.php' != $pagenow || !$query->is_admin )
          return $query;
      if( !current_user_can( 'edit_others_posts' ) ) {
          global $user_ID;
          $query->set('author', $user_ID);
            }
          }
      return $query;
  }
//add_filter('pre_get_posts', 'posts_for_current_author');


function wph_ban_color_scheme() {
    global $_wp_admin_css_colors;
    $_wp_admin_css_colors = 0;
}
add_action('admin_head', 'wph_ban_color_scheme');

// Отключаем профиль для редактирования
function gb_disable_user_profile() {

$user = wp_get_current_user();
 //if( IS_PROFILE_PAGE === true )
 {
//if ( !in_array('administrator', $user->roles ))
//  wp_die( 'Пожалуйста, свяжитесь с администрацией сайта, если хотите отредактировать свой профиль.' );
 }


 if ( !in_array('administrator', $user->roles))
{ remove_menu_page( 'profile.php' );
 remove_submenu_page( 'users.php', 'profile.php' );
}
}
add_action( 'admin_init', 'gb_disable_user_profile' );


function gb_admin_bar_render() {
 global $wp_admin_bar;
 $wp_admin_bar->remove_menu('edit-profile', 'user-actions');
}
add_action( 'wp_before_admin_bar_render', 'gb_admin_bar_render' );


// Перенаправление при входе на главную

function gb_login_redirect( $redirect_to, $user )
{
 global $user;

if ( $user->user_login != 'admin' ){
 $redirect_to = '/';
 }
return $redirect_to;
}
add_filter( 'login_redirect', 'gb_login_redirect', 10, 3 );

if (!function_exists('disableAdminBar')) {

	function disableAdminBar(){

  	remove_action( 'admin_footer', 'wp_admin_bar_render', 1000 ); // for the admin page
    remove_action( 'wp_footer', 'wp_admin_bar_render', 1000 ); // for the front end

    function remove_admin_bar_style_backend() {  // css override for the admin page
      echo '<style>body.admin-bar #wpcontent, body.admin-bar #adminmenu { padding-top: 0px !important; }</style>';
    }

    add_filter('admin_head','remove_admin_bar_style_backend');

    function remove_admin_bar_style_frontend() { // css override for the frontend
      echo '<style type="text/css" media="screen">
      html { margin-top: 0px !important; }
      * html body { margin-top: 0px !important; }
      </style>';
    }

    add_filter('wp_head','remove_admin_bar_style_frontend', 99);

  }

}

// add_filter('admin_head','remove_admin_bar_style_backend'); // Original version
add_action('init','disableAdminBar'); // New version
if (!function_exists('disableAdminBar')) {

	function disableAdminBar(){

  	remove_action( 'admin_footer', 'wp_admin_bar_render', 1000 ); // for the admin page
    remove_action( 'wp_footer', 'wp_admin_bar_render', 1000 ); // for the front end

    function remove_admin_bar_style_backend() {  // css override for the admin page
      echo '<style>body.admin-bar #wpcontent, body.admin-bar #adminmenu { padding-top: 0px !important; }</style>';
    }

    add_filter('admin_head','remove_admin_bar_style_backend');

    function remove_admin_bar_style_frontend() { // css override for the frontend
      echo '<style type="text/css" media="screen">
      html { margin-top: 0px !important; }
      * html body { margin-top: 0px !important;
       }
      .admin-bar.masthead-fixed .site-header
      {top: 0px;}</style>';
    }

    add_filter('wp_head','remove_admin_bar_style_frontend', 99);

  }

}

// add_filter('admin_head','remove_admin_bar_style_backend'); // Original version
add_action('init','disableAdminBar'); // New version






// Создаем виджет BlogTool.ru


class btru_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Выбираем ID для своего виджета
'btru_widget',

// Название виджета, показано в консоли
__('BlogTool Widget', 'btru_widget_domain'),

// Описание виджета
array( 'description' => __( 'Простенький виджет для демонстрации BlogTool.ru', 'btru_widget_domain' ), )
);
}

// Создаем код для виджета -
// сначала небольшая идентификация

public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );
// до и после идентификации переменных темой
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];

$order = "&orderby=date&order=DESC";
$s2 = ' selected="selected"';
if (isset ($_POST['select']))
{
if ($_POST['select'] == 'title')
{ $order = "&orderby=title&order=ASC"; $s1 = ' selected="selected"'; $s2 = '';
add_filter('pre_get_posts', 'posts_for_current_author');
wp_head();
echo "dad ad";
}
if ($_POST['select'] == 'newest') { $order = "&orderby=date&order=DESC"; $s2 = ' selected="selected"';
remove_filter('pre_get_posts', 'posts_for_current_author');
wp_head();
the_content();
echo "fffffffffffffffffffffffff dad ad";
}
if ($_POST['select'] == 'oldest') { $order = "&orderby=date&order=ASC"; $s3 = ' selected="selected"'; $s2 = '';

	$arg =  'author=-1' ;
$query = new WP_Query( $arg );
	while ( $query->have_posts() ) {

	$query->the_post();
	?>
	<li>

	<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
	</li>
		<?php
		}

		?>

		<script>
	<!--				location.href = "<?php get_option('home');?>/?<?php echo $arg?>";
		</script>
		<?php

	wp_reset_postdata();

 }
if ($_POST['select'] == 'modified') {
  $order = "&orderby=modified"; $s4 = ' selected="selected"'; $s3 = '';


  	$args =  array(
	'meta_query' => array(
		'relation' => 'OR',
		array(
			'key' => 'diln','value' => '16')));
//  $query = new WP_Query( array( 'meta_key' => 'diln', 'meta_value' => '16',));
  $query = new WP_Query( $args);
  	while ( $query->have_posts() ) {

  	$query->the_post();
  	?>
  	<li>

  	<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
  	</li>
  		<?php
  		}

  		?>

  		<script>
  	<!--				location.href = "<?php get_option('home');?>/?<?php echo $arg?>";
  		</script>
  		<?php

  	wp_reset_postdata();




 }
 }
?>

<form method="post" id="order">
Сортировать:
<select name="select" onchange='this.form.submit()' style="width:200px">
<option value="title">по заголовку</option>
<option value="newest">по дате (сначала новые)</option>
<option value="oldest">по дате (сначала старые)</option>
<option value="modified">по дате изменения</option>
</select>
</form>
<?php
}

// Закрываем код виджета
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'Заголовок виджета', 'btru_widget_domain' );
}
// Для административной консоли
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<?php
}

// Обновление виджета
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
return $instance;
}
} // Закрываем класс btru_widget

// Регистрируем и запускаем виджет
function btru_load_widget() {
	register_widget( 'btru_widget' );
}
add_action( 'widgets_init', 'btru_load_widget' );


/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

// Введення прихільника через АЯКС
add_action( 'wp_ajax_nopriv_add_object_ajax', 'add_object' ); // крепим на событие wp_ajax_nopriv_add_object_ajax, где add_object_ajax это параметр action, который мы добавили в перехвате отправки формы, add_object - ф-я которую надо запустить
add_action('wp_ajax_add_object_ajax', 'add_object'); // если нужно чтобы вся бадяга работала для админов


function add_object() {
	$errors = ''; // сначала ошибок нет

	$nonce = $_POST['nonce']; // берем переданную формой строку проверки
	if (!wp_verify_nonce($nonce, 'add_object')) { // проверяем nonce код, второй параметр это аргумент из wp_create_nonce
		$errors .= 'Данные отправлены с левой страницы '; // пишим ошибку
	}

	// запишем все поля
  $n_diln = trim(strip_tags($_POST['n_diln'])); // переданный id термина таксономии с вложенностью (родитель)
  $n_prih = trim(strip_tags($_POST['n_prih'])); // переданный id термина таксономии с вложенностью (родитель)
  $ufamily = trim(strip_tags($_POST['ufamily'])); // переданный id термина таксономии с вложенностью (родитель)
	$uname =  trim(strip_tags($_POST['uname'])); // id термина таксономии с вложенностью (его дочка)
	$ubatk = trim(strip_tags($_POST['ubatk'])); // id обычной таксономии
  $beathday = strip_tags($_POST['beathday']); // id обычной таксономии

	$tel_o = $_POST['tel_o']; // запишем название поста
  $tel_dod = $_POST['tel_dod']; // запишем название поста
  $sotc_merega = strip_tags($_POST['sotc_merega']); // id обычной таксономии
	$adressa = wp_kses_post($_POST['adressa']); // контент
  $id_kod =  intval($_POST['id_kod']);
//	$string_field = strip_tags($_POST['string_field']); // произвольное поле типа строка
//	$text_field = wp_kses_post($_POST['text_field']); // произвольное поле типа текстарея

  $likar = $_POST['likar'];
  $deputat = $_POST['deputat'];
  $derzh_sl = $_POST['derzh_sl'];
  $bezrob = $_POST['bezrob'];
  $pensioner = $_POST['pensioner'];
  $ato = $_POST['ato'];
  $invalid = $_POST['invalid'];
  $autoritet = $_POST['autoritet'];
  $uchitel = $_POST['uchitel'];
  $pidpr = $_POST['pidpr'];


if ($ufamily == '' ||
    $uname == '' ||
    $ubatk == '' ||
    $adressa == '' ||
    $n_diln == ''||
    $beathday == '' )
     $errors .= 'Не всі обовязкові поля заповненні';

	// проверим заполненность, если пусто добавим в $errors строку
  /*  if (!$child_cat) $errors .= 'Не выбрано "Кастом категория-ребенок xD"';
    if (!$tag) $errors .= 'Не выбрано "Кастом тэг"';
    if (!$title) $errors .= 'Не заполнено поле "Тайтл"';
    if (!$content) $errors .= 'Не заполнено поле "Пост контент"';
*/
  $max_file_size = 2;
    // далее проверим все ли нормально с картинками которые нам отправили
    if ($_FILES['auto_b']) { // если была передана миниатюра
   		if ($_FILES['auto_b']['error']) $errors .= "Ошибка загрузки: " . $_FILES['img']['error'].". (".$_FILES['img']['name'].") "; // серверная ошибка загрузки
    	$type = $_FILES['auto_b']['type'];
      $size = $_FILES['auto_b']['size'];
		if (($type != "text/plain"))
    $errors .= "Формат файла може бути только text/plain (".$_FILES['auto_b']['name'].")" ; // неверный формат
    if ( $size >  $max_file_size*1024*1024)
    $errors .= "Об єм файла більше ніж ".$max_file_size."Мбайт."; // неверный формат
  }

//Копія кода
if ($_FILES['id_kod_copy']) { // если была передана миниатюра
  if ($_FILES['id_kod_copy']['error']) $errors .= "Ошибка загрузки: " . $_FILES['img']['error'].". (".$_FILES['img']['name'].") "; // серверная ошибка загрузки
  $type = $_FILES['id_kod_copy']['type'];
  $size = $_FILES['id_kod_copy']['size'];
if (($type != "image/jpg") && ($type != "image/jpeg") && ($type != "image/png"))
$errors .= "Формат файла может бути только jpg или png. (".$_FILES['id_kod_copy']['name'].")"; // неверный формат
if ( $size >  $max_file_size*1024*1024)
$errors .= "Об'єм файла більше ніж ".$max_file_size."Мбайт."; // неверный формат
}

/*  if ($_FILES['declar']) { // если была передана миниатюра
    if ($_FILES['declar']['error']) $errors .= "Ошибка загрузки: " . $_FILES['img']['error'].". (".$_FILES['img']['name'].") "; // серверная ошибка загрузки
    $type = $_FILES['declar']['type'];
    $size = $_FILES['declar']['size'];
  if (($type != "image/jpg") && ($type != "image/jpeg") && ($type != "image/png"))
  $errors .= "Формат файла может быть только jpg или png. (".$_FILES['declar']['name'].")"; // неверный формат
  if ( $size >  $max_file_size*1024*1024)
  $errors .= "Об'єм файла більше ніж ".$max_file_size."Мбайт."; // неверный формат
}
*/
	if ($_FILES['declar']) { // если были переданны дополнительные картинки, пробежимся по ним в цикле и проверим тоже самое
		foreach ($_FILES['declar']['name'] as $key => $array) {
			if ($_FILES['declar']['error'][$key]) $errors .= "Ошибка загрузки: " . $_FILES['declar']['error'][$key].". (".$key.$_FILES['declar']['name'][$key].") ";
    		$type = $_FILES['declar']['type'][$key];
			if (($type != "image/jpg") && ($type != "image/jpeg") && ($type != "image/png")) $errors .= "Формат файла может быть только jpg или png. (".$_FILES['declar']['name'][$key].")";
		}
	}

	if (!$errors) { // если с полями все ок, значит можем добавлять пост
		$fields = array( // подготовим массив с полями поста, ключ это название поля, значение - его значение
			'post_type' => 'add_prhilnyk', // нужно указать какой тип постов добавляем, у нас это my_custom_post_type
	    	'post_title'   => $ufamily, // заголовок поста
	        );
  //    save_post () ;

// Створюємо новий обєкт pods
if ($n_prih != '-1' && $n_prih != '')
  $pod = pods( 'add_prhilnyk' , $n_prih);
else
  $pod = pods( 'add_prhilnyk' );

 $title = $ufamily." ".$uname." ".$ubatk;
  $data = array(
    //'id' => $n_prih,
    'n_diln' => $n_diln,
    'title' =>  $title ,
    'ufamily'=> $ufamily, // заполняем произвольное поле типа строка
    'uname'=>  $uname, // заполняем произвольное поле типа строка
     'ubatk'=>  $ubatk, // заполняем произвольное поле типа строка
     'tel_o'=>  $tel_o, // заполняем произвольное поле типа строка
     'tel_dod'=>  $tel_dod, // заполняем произвольное поле типа строка
     'sotc_merega'=>  $sotc_merega, // заполняем произвольное поле типа строка
     'adressa'=>  $adressa, // заполняем произвольное поле типа строка
     'beathday'=>  $beathday, // заполняем произвольное поле типа строка
     'id_kod'=>  $id_kod, // заполняем произвольное поле типа строка
     'beathday'=>  $beathday, // заполняем произвольное поле типа строка
     'likar'=>  $likar,
      'deputat'=>  $deputat,
      'derzh_sl'=> $derzh_sl,
      'bezrob'=>  $bezrob,
      'pensioner'=>  $pensioner,
      'ato'=>  $ato,
      'invalid'=>  $invalid,
      'autoritet'=>  $autoritet,
      'uchitel'=>  $uchitel,
      'pidpr'=>  $pidpr,
       //'id_kod_copy' => pods_attachment_import ( $fil_url)
);
if ($pod != '')
{
  $post_id = $pod->id();
if( $post_id != $n_prih)
$post_id = $pod->add( $data );
else {
  $pod->save( $data );
}
    //  update_post_meta($post_id, 'text_field', $text_field); // заполняем произвольное поле типа текстарея

	  //  wp_set_object_terms($post_id, $parent_cat, 'custom_tax_like_cat', true); // привязываем к пост к таксономиям, третий параметр это слаг таксономии
	  //  wp_set_object_terms($post_id, $child_cat, 'custom_tax_like_cat', true);
	  //  wp_set_object_terms($post_id, $tag, 'custom_tax_like_tag', true);
  if ($_FILES['auto_b']) { // если основное фото было загружено
  		$attach_id_img = media_handle_upload( 'auto_b', $post_id ); // добавляем картинку в медиабиблиотеку и получаем её id
  		update_post_meta($post_id,'auto_b',$attach_id_img); // привязываем миниатюру к посту
		}

    if ($_FILES['id_kod_copy']) { // если основное фото было загружено
     $attach_id_img = media_handle_upload( 'id_kod_copy', $post_id ); // добавляем картинку в медиабиблиотеку и получаем её id
      update_post_meta($post_id,'kod_copy',$attach_id_img); // привязываем миниатюру к посту
    }

    if ($_FILES['passport']) { // если дополнительные фото были загружены
			$imgs = array(); // из-за того, что дефолтный массив с загруженными файлами в пхп выглядит не так как нужно, а именно вся инфа о файлах лежит в разных массивах но с одинаковыми ключами, нам нужно создать свой массив с блэкджеком, где у каждого файла будет свой массив со всеми данными
			foreach ($_FILES['passport']['name'] as $key => $array) { // пробежим по массиву с именами загруженных файлов
				$file = array( // пишем новый массив
					'name' => $_FILES['passport']['name'][$key],
					'type' => $_FILES['passport']['type'][$key],
					'tmp_name' => $_FILES['passport']['tmp_name'][$key],
					'error' => $_FILES['passport']['error'][$key],
					'size' => $_FILES['passport']['size'][$key]
				);
				$_FILES['passport'.$key] = $file; // записываем новый массив с данными в глобальный массив с файлами
				$imgs[] = media_handle_upload( 'passport'.$key, $post_id ); // добавляем текущий файл в медиабиблиотека, а id картинки суем в другой массив
			}
			update_post_meta($post_id,'pasport',$imgs); // привязываем все картинки к посту
	}

  if ($_FILES['declar']) { // если дополнительные фото были загружены
    $imgs = array(); // из-за того, что дефолтный массив с загруженными файлами в пхп выглядит не так как нужно, а именно вся инфа о файлах лежит в разных массивах но с одинаковыми ключами, нам нужно создать свой массив с блэкджеком, где у каждого файла будет свой массив со всеми данными
    foreach ($_FILES['declar']['name'] as $key => $array) { // пробежим по массиву с именами загруженных файлов
      $file = array( // пишем новый массив
        'name' => $_FILES['declar']['name'][$key],
        'type' => $_FILES['declar']['type'][$key],
        'tmp_name' => $_FILES['declar']['tmp_name'][$key],
        'error' => $_FILES['declar']['error'][$key],
        'size' => $_FILES['declar']['size'][$key]
      );
      $_FILES['declar'.$key] = $file; // записываем новый массив с данными в глобальный массив с файлами
      $imgs[] = media_handle_upload( 'declar'.$key, $post_id ); // добавляем текущий файл в медиабиблиотека, а id картинки суем в другой массив
    }
    update_post_meta($post_id,'declar',$imgs); // привязываем все картинки к посту
}

}
}
else
$errors .= "Трапилась помилка при додавані. Перевірте значення полів.";
	if ($errors) wp_send_json_error($errors); // если были ошибки, выводим ответ в формате json с success = false и умираем
	else wp_send_json_success('Все прошло отлично! Добавлено ID:'.$post_id.' '.$n_prih); // если все ок, выводим ответ в формате json с success = true и умираем

	die(); // умрем еще раз на всяк случ
}

add_action( 'wp_ajax_nopriv_change_object_ajax', 'change_object' ); // крепим на событие wp_ajax_nopriv_add_object_ajax, где add_object_ajax это параметр action, который мы добавили в перехвате отправки формы, add_object - ф-я которую надо запустить
add_action('wp_ajax_change_object_ajax', 'change_object'); // если нужно чтобы вся бадяга работала для админов

function change_object() {
	$errors = ''; // сначала ошибок нет

	$nonce = $_REQUEST['nonce']; // берем переданную формой строку проверки
	if (!wp_verify_nonce($nonce, 'change_object')) { // проверяем nonce код, второй параметр это аргумент из wp_create_nonce
		$errors .= 'Данные отправлены с левой страницы '; // пишим ошибку
	}


	// запишем все поля
  $id_p = trim(strip_tags($_REQUEST['id_p'])); // переданный id термина таксономии с вложенностью (родитель)
  if ($id_p  > 0)
    $pod = pods( 'add_prhilnyk' , $id_p);


if (isset($pod))
{
$return = array(
  'message'   => 'Сохранено',
  'ID'        => 1
);
}
else {
  $errors.= "Не вірний код.";
}
  if ($errors) wp_send_json_error($errors); // если были ошибки, выводим ответ в формате json с success = false и умираем
	else wp_send_json_success($pod->export()); // если все ок, выводим ответ в формате json с success = true и умираем

	die(); // умрем еще раз на всяк случ
}
