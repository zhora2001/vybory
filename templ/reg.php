<?php
/*
Template Name: Вхід користувача
 */


 get_header(); ?>
 <script src="<?php echo get_template_directory_uri() ?>/js/for_users.js">
 </script>
 <div id="main-content" class="main-content">
   <div id="primary" class="content-area">
    <div id="content" class="site-content" role="main">

    <div style="margin-left:10px; border:none;">

 <?php if (is_user_logged_in()) { // если юзер залогинен, стандартная ф-я вп
 	$current_user = wp_get_current_user(); // получим данные о текущем залогиненом юзере ?>
 <p>Ви ввійшли як, <?php echo $current_user->display_name; ?>. <a href="#" class="logout" data-nonce="<?php echo wp_create_nonce('logout_me_nonce'); ?>">Выйти</a></p> <!-- покажем приветствие и ссылку на выход, в атрибут data-nonce запишем строку для проверки безопасности -->
 <?php } else { // если не залогинен, покажем форму для логина ?>
 <form name="loginform" id="loginform" method="post" class="userform" action=""> <!-- обычная форма, по сути нам важен только класс -->
 	<input type="text" name="log" id="user_login" placeholder="Логин или email"> <!-- сюда будут писать логин или email -->
 	<input type="password" name="pwd" id="user_pass" placeholder="Пароль"> <!-- ну пароль -->
 	<input name="rememberme" type="checkbox" value="forever"> Запомнить меня <!-- запомнить ли сессию, forever - навсегда,  -->
 	<input type="submit" value="Войти"> <!-- субмит -->
 	<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>"> <!-- куда отправим юзера если все прошло ок -->
 	<input type="hidden" name="nonce" value="<?php echo wp_create_nonce('login_me_nonce'); ?>"> <!-- поле со строкой безопасности, будем проверим её в обработчике чтобы убедиться, что форма отправлена откуда надо, аргумент login_me_nonce, конечно, лучше поменять на свой -->
 	<input type="hidden" name="action" value="login_me"> <!-- обязательное поле, по нему запустится нужная функция -->
 	<div class="response"></div> <!-- ну сюда будем пихать ответ от сервера -->
 </form>
 <?php }  ?>
 </div>
</div><!-- #content -->
</div><!-- #primary -->
 <?php get_sidebar( 'content' ); ?>
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer();
