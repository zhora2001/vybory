<?php
/*
Template Name: Реєстрація нового користувача
 */


 get_header(); ?>
 <script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/js/jquery.fancybox.pack.js">
 </script>
 <script src="<?php echo get_template_directory_uri() ?>/js/jquery.maskedinput.min.js">
 </script>
<script  src="<?php echo get_template_directory_uri() ?>/js/new_users.js">
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
    <div id="content" class="site-content" role="main">
    <div style="margin-left:10px; border:none;">

 <?php

 	 if(is_user_logged_in() && ( current_user_can('manage_options') || is_user_role("raion")))
   {
 	$current_user = wp_get_current_user(); // получим данные о текущем залогиненом юзере else { // если не залогинен, покажем форму для логина
    ?>



<form name="new_user_form" id="new_user_form" method="post" class="userform" action="">
  <!-- обратите внимание на класс, по этому классу на форму вешается обработка из первой статьи -->
<ul>
        <li class="im_data">
        <label for="ufamily"> Призвіще </label>
        </li>
          <li class="val_data">
            <input type="text" name="ufamily" id="ufamily" required/>
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
             <input  type="text" name="tel" id="tel" required/>
       </li>
     </ul>
     <ul>
         <li class="im_data">
           <label for="uid"> Пароль </label>
         </li>
        <li class="val_data">
              <input  type="text" name="pass1" id="pass1"
              value = "<?php echo wp_generate_password(6, false); ?>" required/>
            </input>
        </li>
      </ul>

      <ul>
          <li class="im_data">
            <label for="uid"> Е-майл </label>
          </li>
         <li class="val_data">
               <input  type="text" name="user_email" id="user_email"
               value = "<?php echo wp_generate_password(8, false).
               '@'.wp_generate_password(2, false).'me.ua'; ?>" required/>
             </input>
         </li>
       </ul>

      <ul>
        <li class="im_data">
          <p>
            Повноваження:
        </p>
        </li>
          <li class="val_data">
              <input id="r_diln" type="radio" name="r_diln"/>
              <label for="r_diln">Дільничний</label>
            </li>
        <li class="val_data">
              <input id="r_kusch" type="radio" name="r_kusch" />
              <label for="r_kusch">Кущовий</label>
          </li>

  </ul>
  <ul>
        <li class="im_data">
          <p>
            Дільниці:
        </p>
      </li>
        <li class="val_data">
          <label for="dl">
                <select id = "vv" name="dl">
                  <?php
            $var3 = '1';

            $key = 'diln';
            $var2 = get_user_meta( $user->ID, $key, true );

            foreach($dil as $var1)
            {
              if( trim($var1['n_diln']) == trim($var2))
              {
              $a = $var1['diln'];
              echo "<option value=".$var1['n_diln']." selected>Дільниця № $a </option>";
              $var3 = '2';
              }
              else {
                $a =  $var1['n_diln']." ".$var1['diln'];
                echo "<option value=".$var1['n_diln'].">Дільниця № $a </option>";
                }
            }
            if ($var3 == '1')
          echo ' <option value="" selected>Выберіть дільницю</option>';
          ?>
        </select>
  </label>
  <label for="ksch">
    <select id = "vv1" name="ksch" hidden="">
      <option  value="" selected>Виберіть кущ</option>
      <?php

        $i=1;

        $key = 'kusch';
        foreach($kus as $var1)
        {
        $q0=$var1['kusch'];
          $q1=trim($var1['n_diln']);
        echo '<option value='.'"'.$q1.'"'."><strong>$q0</strong> - дільниці ($q1)</option>";
        $i++;
      }
      ?>
    </select>
  </label>
</li>
</ul>

<ul>
  <li class="im_data">
    <label for="send_sms">
      Відправити пароль СМС
    </label>
  </li>
  <li class="val_data">
  <input type="checkbox" id="send_sms" name="send_sms" >
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
 <?php }
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
