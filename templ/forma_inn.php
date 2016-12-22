<?php
/*
Template Name: Пошук в базі інн
 */


 get_header(); ?>
 <script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/js/jquery.fancybox.pack.js">
 </script>
 <script src="<?php echo get_template_directory_uri() ?>/js/jquery.maskedinput.min.js">
 </script>
<script  src="<?php echo get_template_directory_uri() ?>/js/form_inn.js">
 </script>
 <style>
 ul {
   list-style-type: none;
   float: none;
 }
 input['text']
 {
   width: 370px;
 }
li.im_data
 {
   width: 170px;
  // margin-left: 15px;
   list-style-type: none;
   float:left;
 }
 .response
 {
margin-top: 10px;
color: red;
 }

 li.val_data
 {
float:none;
list-style-type: none;
 }
 </style>

 <div id="main-content" class="main-content">
   <div id="primary" class="content-area">
    <div id="content" class="site-content" role="main" style="padding-left:50px;">
    <div class="form_input">

 <?php

 	 if(is_user_logged_in() && ( current_user_can('manage_options') || is_user_role("raion")))
   {



?>
<form name="new_user_form" id="new_user_form" method="post" class="userform" action="">
  <!-- обратите внимание на класс, по этому классу на форму вешается обработка из первой статьи -->
<ul class="new_input">
        <li class="im_data">
        <label for="ufamily"> Призвіще </label>
        </li>
          <li class="val_data" style="border:solid 1px pink;">
            <input type="text" name="ufamily" id="ufamily" value="Кандідат" required/>
        </li>
      </ul>
      <ul>
        <li class="im_data">
         <label for="uid"> Ім'я </label>
       </li>
      <li class="val_data">
            <input  type="text" name="uname" id="uname" required/>
      </li>
    </ul>
    <ul>
        <li class="im_data">
          <label for="uid"> Логін (номер телефона) </label>
        </li>
       <li class="val_data">
             <input  type="text" name="tel" id="tel" value="candidat"required/>
       </li>
     </ul>
<ul>
<li class="im_data">
<br />
</li>
  <li class="val_data">
  <input type="submit" value="Зареєструвати"> <!-- субмит -->
  </li>
  <!--- </ul><input type="hidden" name="nonce" value="<?php echo wp_create_nonce('register_me_nonce'); ?>"> --><!-- поле со строкой безопасности, будем проверять её в обработчике чтобы убедиться, что форма отправлена откуда надо -->
	<!--- <input type="hidden" name="action" value="register_me"> -->
	<div class="response"></div> <!-- ну сюда будем пихать ответ от сервера -->
 </form>
<?php
     global $wpdb;

    $fivesdrafts = $wpdb->get_results("select * from ds_inn where inn like '311%'",ARRAY_A);


    foreach ($fivesdrafts as $fivesdraft) {
    	echo $fivesdraft['lastname']." ".$fivesdraft['firstname']." ".$fivesdraft['fathername']." ".
    		$fivesdraft['birthday']." ". $fivesdraft['inn']." ".$fivesdraft['geo']." ". $fivesdraft['address']." ".
    		$fivesdraft['house']." ". $fivesdraft['number'];
    	echo "<br>";
    }

 }
 else {

echo " <p> У Вас недостатньо повноважень!</p>";
  }
?>
<br />
<br />
<br />
 </div>
</div><!-- #content -->
</div><!-- #primary -->
 <?php get_sidebar( 'content' ); ?>
</div><!-- #main-content -->
<?php
get_sidebar();
get_footer();
