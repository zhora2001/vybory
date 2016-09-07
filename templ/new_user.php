<?php
/*
Template Name: Реєстрація нового користувача
 */


 get_header(); ?>
 <script src="<?php echo get_template_directory_uri() ?>/js/for_reg_users.js">
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

 function is_user_role( $role, $user_id = null ) {
   $user = is_numeric( $user_id ) ? get_userdata( $user_id ) : wp_get_current_user();

   if( ! $user )
     return false;

   return in_array( $role, (array) $user->roles );
 }
	$current_user = wp_get_current_user();
   if(is_user_logged_in() && ( current_user_can('manage_options') || is_user_role("raion")))
   {
 	$current_user = wp_get_current_user(); // получим данные о текущем залогиненом юзере else { // если не залогинен, покажем форму для логина
    ?>



<form name="registrationform" id="registrationform" method="post" class="userform" action=""> <!-- обратите внимание на класс, по этому классу на форму вешается обработка из первой статьи -->
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
               <input  type="text" name="email" id="email"
               value = "<?php echo wp_generate_password(8, false).
               '@'.wp_generate_password(8, false).'.com'; ?>" required/>
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
              <input id="r_diln" type="radio" name="radio" checked />
              <label for="r_diln">Дільничний</label>
            </li>
        <li class="val_data">
              <input id="r_kusch" type="radio" name="radio" />
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
            $result = csv_to_array(__DIR__.'/diln.csv',';');


            $kus = array();
            $tmp_kus = array();
            $temp_a = array();
            $dil = array();
            $rayon = array();
            $tmp_rayon = array();
            //echo print_r($result);
            foreach($result as $var11)
              {
            //echo ($var11[1]); //
                array_push($tmp_kus, $var11['kusch']);
                array_push($tmp_rayon, $var11['rayon']);
                $temp_a[0] = ['diln'=>$var11['diln'], 'n_diln'=>$var11['n_diln']];
                //$new_kusch[$i] = ['kusch'=>$var1, 'n_diln'=>$q];
                array_push($dil,$temp_a[0]);
              }
            $tmp_kus = array_unique($tmp_kus);
            $tmp_rayon = array_unique($tmp_rayon);
            $temp_a = array();

            foreach($tmp_kus as $var1)
                {
                  $q = ''; $i = 0;
                      foreach ($result as $var11) {
                      if ($var11['kusch'] == $var1)
                      $q .= $var11['n_diln'].", ";
                  }
            $temp_a[0] = ['kusch'=>$var1, 'n_diln'=>$q];
            //$new_kusch[$i] = ['kusch'=>$var1, 'n_diln'=>$q];
            array_push($kus,$temp_a[0]);
            $i += 1;
            }

            foreach($tmp_rayon as $var1)
                {
                  $q = ''; $i = 0;
                      foreach ($result as $var11) {
                      if ($var11['rayon'] == $var1)
                      $q .= $var11['n_diln'].", ";
                  }
            $temp_a[0] = ['rayon'=>$var1, 'n_diln'=>$q];
            //$new_kusch[$i] = ['kusch'=>$var1, 'n_diln'=>$q];
            array_push($rayon,$temp_a[0]);
            $i += 1;
            }

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
          echo " <option disabled selected>Выберіть дільницю</option>
          ";
          ?>
        </select>
  </label>
  <label for="ksch">
    <select id = "vv1" name="ksch" hidden="">
      <option disabled selected>Виберіть кущ</option>
      <?php

        $i=1;

        $key = 'kusch';
        $var2 = get_user_meta( $user->ID, $key, true );

        foreach($kus as $var1)
        {
        $q0=$var1['kusch'];
        $q1=$var1['n_diln'];

        echo "<option value=".$var1['n_diln']."><strong>$q0</strong> - дільниці ($q1])</option>";
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
</ul><input type="hidden" name="nonce" value="<?php echo wp_create_nonce('register_me_nonce'); ?>"> <!-- поле со строкой безопасности, будем проверять её в обработчике чтобы убедиться, что форма отправлена откуда надо -->
	<input type="hidden" name="action" value="register_me"> <!-- обязательное поле, по нему запустится нужная функция -->
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
