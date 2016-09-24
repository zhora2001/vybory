<?php
/*
Template Name: Введення прихільника
 */


 get_header(); ?>

 <script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/js/jquery.fancybox.pack.js"></script>
 <script src="<?php echo get_template_directory_uri() ?>/js/jquery.maskedinput.min.js">
 </script>
  <script src="<?php echo get_template_directory_uri() ?>/js/input_pr.js">
 </script>
 <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/js/jquery.fancybox.css" type="text/css" media="screen" />
 <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/css/style_v.css" type="text/css" media="all" />

 <div id="main-content" class="main-content">
   <div id="primary" class="content-area" style="padding-top:18px;">
   <div id="content" class="site-content" role="main">
           <?php

if(is_user_logged_in() && (is_user_role('dilnich')
|| is_user_role("kusch")
|| is_user_role("raion")
|| current_user_can('manage_options') ) )
{
    $current_user = wp_get_current_user();
    $var2 = get_user_meta( $current_user->ID);

      ?>
<button id="btn_prihil" type="button"> Відкрити форму</button>
        <div id="input_prihil" class="form_input">
        <h1>Ведення прихільника</h1>
    <br>
      <form method="post" enctype="multipart/form-data" id="add_object">
    <table class="input_prihil">
        <tr>
          <td class="im_data">
            Номер дільниці:
          </td>
          <td  id="nom_dil">
              <input type="text" id="n_diln" name="n_diln" value = "" hidden disabled required/>
              <input type="text" id="n_prih" name="n_prih" value = "-1" hidden=""/>
          <select id = "spys_diln" name="dl">
                  <?php
            $var3 = '1';
            $spysok_diln = "";
            if(is_user_role('raion'))
            {
            $key = 'raion';
            $var2 = get_user_meta( $current_user->ID, $key, true );
                  $dil1=cut_diln($var2);
                  echo print_r($dil1);
                  echo $var2;
            }
            elseif (is_user_role('kusch')) {
              $key = 'kusch';
              $var2 = get_user_meta( $current_user->ID, $key, true );
                    $dil1=cut_diln($var2);
            }
            elseif (is_user_role('dilnich')) {
              $key = 'diln';
              $var2 = get_user_meta( $current_user->ID, $key, true );
                    $dil1=cut_diln($var2);
            }
            else
            $dil1 = get_dil('diln');

            $key = 'diln';
            $var2 = get_user_meta($current_user->id, $key, true );
            foreach($dil1 as $var1)
            {
              $a =  $var1['n_diln']." ".$var1['diln'];
              if ($spysok_diln == "")
              $spysok_diln = "'".$var1['n_diln']."'";
              else
              $spysok_diln .= ",'".$var1['n_diln']."'";
              echo "<option value=".$var1['n_diln'].">Дільниця № $a </option>";
              }

            if ($var3 == '1')
          echo ' <option value="" selected>Выберіть дільницю</option>';
          ?>
        </select>

          </td>
            <td>
          </td>
          <td>
                  </td>
          </td>
        </tr>

        <tr>
            <td class="im_data">
              <label for="ufamily" > Призвіще </label>
            </td>
            <td class="val_data">
              <input type="text" name="ufamily" id="ufamily" required/>
             </td>
             <td class="im_data">
               <label for="uid"> Ім'я </label>
             </td>
            <td class="val_data">
                  <input  type="text" name="uname" id="uname" required/>
            </td>

        </tr>
     <tr>
          <td class="im_data">
            	<label for="ubatk">По-батькові </label>
          </td>
          <td class="val_data">
            <input  type="text" name="ubatk" id="ubatk" required/>
          </td>
          <td class="im_data">
            <label for="beathday">Дата народження </label>
          </td>
          <td class="val_data">
            <input  type="text"  name="beathday" id="beathday" required/>
          </td>
      </tr>
        <tr>
           <td class="im_data">
              <label for="tel_o">Телефон (осн.) </label>
            </td>
            <td class="val_data">
              <input  type="text" name="tel_o" id="tel_o" required/>
              </td>
            <td class="im_data">
              <label for="tel_dod">Телефон (дод.)</label>
            </td>
            <td class="val_data">
              <input  type="text" name="tel_dod" id="tel_dod"/>
            </td>
        </tr>
        <tr>
          <td class="im_data" rowspan="2">
             <label for="adressa">Адреса </label><br /><br />
            </td>
            <td class="adres" rowspan="2">
              <textarea type="text"  name="adressa" id="adressa" required/></textarea>
            </td>
            <td class="im_data"  rowspan="2">
               <label for="sotc_merega">Профиль в соцмережах або скайп</label>
            </td>
            <td class="val_data"  rowspan="2">
              	<textarea   type="text"  name="sotc_merega" id="sotc_merega"/></textarea>
            </td>
        </tr>
              <tr>
                      <td>
                      </td>
                      <td>
                      </td>
              </tr>
              <tr>
                <td class="im_data">
                  <label for="id_kod" > Ід.код. </label>
                </td>
                <td class="val_data">
                  <input type="text" name="id_kod" id="id_kod"/>
                </td>
                <td class="im_data">
                  <label for="id_kod_copy" > Копія ід.кода </label>
                </td>
                <td class="val_data">
                  <input type='file' name='id_kod_copy' id='id_kod_copy' />
                </td>
              </tr>
              <tr>
                    <td class="im_data" style="vertical-align:top; border-bottom:1px solid;">
                      <label for="declar" > Декларація (jpg) </label>
                    </td>
                    <td class="val_data">
                      <input type='file' name='declar[]' id='declar'>
			</input>
                       <a href="#" id="dod_declar">додати ще</a>
                    </td>
                    <td class="im_data">
                      <label for="auto_b" > Автобіографія (txt,rtf,doc) </label>
                    </td>
                    <td class="val_data">
                      <input type='file' name='auto_b' id='auto_b' />
                    </td>
              </tr>
              <tr>
                <td class="im_data"  style="vertical-align:top; border-bottom:1px solid;">
                  <label for="passport[]" class='imgs'>Копія паспорта:</label>
                  </td>
                  <td class="val_data">
                    <input type='file' name='passport[]' id='passport'/>
                       <a href="#" id="pass">додати ще</a>
                     </td>
              </tr>
              <tr>
                <td>                </td>
                <td class = "check_b" >
                    <label for="deputat">Депутат
                      <input class="input_chk" type="checkbox"  id = "deputat" name = "deputat"/>
                    </label>
                    <label for="likar">Лікар
                      <input class="input_chk" type="checkbox" id = "likar" name = "likar"/>
                    </label>
                    <label for="derzh_sl">Держслужбовець
                      <input class="input_chk" type="checkbox" id = "derzh_sl" name = "derzh_sl"/>
                    </label>
                    <label for="bezrob">Безробітний
                      <input class="input_chk" type="checkbox" id = "bezrob" name = "bezrob"/>
                    </label>
                    <label for="pensioner">Пенсіонер
                      <input class="input_chk" type="checkbox" id = "pensioner" name = "pensioner"/>
                    </label>
                  </td>
                  <td>

                  </td>
    <td class = "check_b1"  >
      <label for="ato">
        <input class="input_chk" type="checkbox"  id = "ato" name = "ato"/>
        Учасник АТО
      </label>
      <label for="invalid">
      <input class="input_chk" type="checkbox" id = "invalid" name = "invalid"/>
      Інвалід
    </label>
    <label for="autoritet">
      <input class="input_chk" type="checkbox" id = "autoritet" name = "autoritet"/>
      Авторитетна особа
    </label>
    <label for="uchitel">
      <input class="input_chk" type="checkbox" id = "uchitel" name = "uchitel"/>
      Вчитель
    </label>
    <label for="pidpr">
      <input class="input_chk" type="checkbox" id = "pidpr" name = "pidpr"/>
      Підприємець
    </label>

  </td>
  </tr>
  <tr>  </tr>

  <tr>
    <td>

    </td>
    <td>

    </td>
       <td>

     </td>
        <td>
          <div >
          <input class = "btn1" type="submit" name="button" value="Записати" id="sub"/>
          </div>
        </td>
</tr>
</table>
</form>
<div id="output"></div>
</div>


<?php

// echo print_r($var2);


$params = array(
//'join' => 'LEFT JOIN `ds_postmeta` as `d1`  ON `d1`.`post_id` = `t`.`id`',
//    'where' => "d1.meta_key = 'n_diln'  and d1.meta_value = '1'",
'join' => 'JOIN `ds_postmeta` as `d`  ON `d`.`post_id` = `t`.`id`',
    'where' => "`d`.meta_key = 'n_diln' and meta_value in (".$spysok_diln.")",
  'limit'   => -1  // Return all rows
);

// Create and find in one shot
?>
<div id="input_prihil" class="form_input">
<h1>Список прихільників</h1>
<?php
$prihil = pods( 'add_prhilnyk', $params );
$f = array('ufamily', 'uname', 'ubatk');
if ( 0 < $prihil->total() ) {
    while ( $prihil->fetch() ) {
$id = $prihil->id();
?>
<?php // сюда будем выводить ответ ?>
<div class="prihil_nyk">
    <a class="various" data-fancybox-type="iframe" href="<?php echo get_post_permalink($id); ?>">
        <?php echo
                  $prihil->display( 'ufamily')." &nbsp&nbsp".
                  $prihil->display( 'uname')." &nbsp&nbsp".
                  $prihil->display( 'ubatk')." &nbsp&nbsp </a>";
                  ?> <a href="#" style = "display:none;" class="change_prihil"> Змінити </a>
                    <p class='dani_prihil'>Дата нар.:
                  <?php echo $prihil->display( 'beathday')." &nbsp&nbspТел: ".
                  $prihil->display( 'tel_o')." &nbsp&nbsp Адреса:".
                  $prihil->display( 'adressa')."&nbsp&nbsp" ; ?></p>
                <p>
                  <?php
                  $auth = $prihil->display( 'author');
                // echo $prihil->display('post_author');
                      $a = "Дільниця № ".$prihil->display( 'n_diln')." &nbsp&nbsp"."Додано: ".get_the_author_meta( 'display_name', $auth)." ".
                  //    get_the_author_meta( 'last_name', $auth)." ".
                  //    get_the_author_meta( 'login', $auth)." ".
                  " &nbsp&nbsp ".
                      $prihil->display( 'date');
                  echo $a;
                    // get_the_author_meta( $field, $userID );$prihil->display( 'author');
                    ?>
                  <!--- <a data-fancybox-type="iframe" href="<?php echo get_post_permalink($id); ?>" style = "display:none;" class="view_prihil"> Перегляд </a> --->
                    </p>
    <p hidden class="id_p"><?php echo $prihil->display( 'id'); ?> </p>

</div>



<?php
}
}
/*
<p>Author: <?php echo $prihil->display( 'the_author' ); ?></p>
<br />
<p>Category: <?php echo $prihil->display( 'category' ); ?></p>
*/
/*



$q = array('post_type'=>'add_prhilnyk');
$my_posts = get_posts($q);
foreach ($my_posts as $post) :
setup_postdata($post);
?>
<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
</h2>
<?php echo $post->ID; ?>
<?php print_r(get_post_meta($post->ID, 'ufamily')); ?>
<?php print_r(get_post_custom()); ?>

<h2 class="entry-title"><?php the_content(); ?>><?php  ?>
</h2>

<?php endforeach; */
?>
</div>
<?php
}
else {
echo " <p> У Вас недостатньо повноважень!</p>";
 }

?>

</div>
</div><!-- #content -->
<!-- #primary -->


 <?php
 get_sidebar( 'content' ); ?>
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer();
