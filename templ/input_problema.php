<?php
/*
Template Name: Введення проблеми на дільниці
 */
 get_header(); ?>

 <script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/js/jquery.fancybox.pack.js"></script>
 <script src="<?php echo get_template_directory_uri() ?>/js/jquery.maskedinput.min.js">
 </script>
  <script src="<?php echo get_template_directory_uri() ?>/js/input_problema.js">
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
    $terms1 = get_terms("vyd_problemy", 'orderby=term_id&hide_empty=0');
    $terms = get_terms("status_p", 'orderby=term_id&hide_empty=0');
        ?>
<button id="btn_prihil" type="button"> Відкрити форму</button>
        <div id="input_prihil" class="form_input">
<form method="post" enctype="multipart/form-data" id="add_object">
    <ul class="new_input">
          <li class="im_data">
          <label>  Номер дільниці:</label>
          </li>
          <li  class="val_data" id="nom_dil">
              <input type="text" id="n_diln" name="n_diln" value = "" disabled required/>
              <input type="text" id="n_prih" name="n_prih" value = "-1" hidden=""/>
          <select id = "spys_diln" name="dl">
                  <?php
            $var3 = '1';

            $key = 'diln';
            $var2 = get_user_meta(   $current_user->id, $key, true );
            foreach($dil as $var1)
            {
              if( trim($var1['n_diln']) == trim($var2))
              {
                $a =  $var1['n_diln']." ".$var1['diln'];
              echo "<option value=".$var1['n_diln']." selected>Дільниця № $a </option>";
              $var3 = '2';
              }
              else {
                if (current_user_can('manage_options'))
                {
                $a =  $var1['n_diln']." ".$var1['diln'];
                echo "<option value=".$var1['n_diln'].">Дільниця № $a </option>";
              }
                }
            }
            if ($var3 == '1')
          echo ' <option value="" selected>Выберіть дільницю</option>';
          ?>
        </select>
      </li>
      <h1>Внесення проблеми</h1>
      <li class="im_data">
        <label for="title_p" > Назва проблеми </label>
      </li>
      <li class="val_data">
        <input type="text" class="val_input" name="title_p" id="title_p" required/>asdf asdf asdf
      </li>
      <li class="im_data">
      <label for="status_p"> Статус проблеми </label>
      </li>
        <li class="val_data" style="float:left;">
          <?php
          echo '<select id = "status_p" name="status_p">';
           $count = count($terms);
           if($count > 0){
             foreach ($terms as $term) {
                 echo "<option value=".$term->term_id.">$term->name</option>";
      //    	   echo "<li>".$term->name."</li>";
           }
           }
           echo "</select>";
          ?>
      </li>
      <li class="im_data">
      <label for="vyd_problemy"> Вид проблеми </label>
      </li>
      <li class="val_data">
          <?php
           echo '<select id = "vyd_problemy" name="vyd_problemy">';
            $count = count($terms1);
            if($count > 0){
              foreach ($terms1 as $term1) {
                echo "<option value=".$term1->term_id.">$term1->name</option>";
              }
            }
            echo "</select>";
          ?>
      </li>
      <br />
    <li class="im_data" >
     <label for="opys_p">Опис проблеми </label><br /><br />
   </li>
    <li class="val_data">
      <textarea type="text" class="val_input" name="opys_p" id="opys_p" required/> asdf asd f</textarea>
    </li>
    <li class="im_data" >
      <label for="declar" > Фото (jpg) </label>
    </li>
    <li class="val_data">
      <input type='file' name='declar[]' id='declar'>
    </input>
       <a href="#" id="dod_declar">додати ще</a>
    </li>
    <li class="im_data" >
      <label for="smi" > Висвітлення в ЗМІ </label>
    </li>
    <li class="val_data"  >
      <textarea type="text"  class="val_input" style="height:5em;" name="smi" id="smi"/>
    </textarea>
    </li>
<li class="im_data" >
  <label for="kontakt" > Контакти </label>
</li>
<li class="val_data"  >
  <input type="text"  class="val_input" name="kontakt" id="kontakt"/>
</input>
</li>
<li class="im_data" >
<label for="propos_v">Пропозиції щодо вирішення </label><br /><br />
</li>
<li class="val_data">
<textarea type="text" class="val_input" name="propos_v" id="propos_v" /></textarea>
</li>
<li>
  <input class = "btn1" type="submit" name="button" value="Записати" id="sub"/>
</li>
</ul>
</form>
<div id="output"></div>
</div>


<?php

// echo print_r($var2);


$params = array(
//'join' => 'LEFT JOIN `ds_postmeta` as `d1`  ON `d1`.`post_id` = `t`.`id`',
//    'where' => "d1.meta_key = 'n_diln'  and d1.meta_value = '1'",
//'join' => 'JOIN `ds_postmeta` as `d`  ON `d`.`post_id` = `t`.`id`',
//    'where' => "`d`.meta_key = 'n_diln' and meta_value = '5'",


    //'limit'   => -1  // Return all rows
);

// Create and find in one shot

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
                  "Дільниця № ".$prihil->display( 'n_diln')." &nbsp&nbsp".
                  $prihil->display( 'ufamily')." &nbsp&nbsp".
                  $prihil->display( 'uname')." &nbsp&nbsp".
                  $prihil->display( 'ubatk')." &nbsp&nbsp".
                  $prihil->display( 'beathday')." &nbsp&nbsp".
                  $prihil->display( 'adressa')."&nbsp&nbsp" ; ?></a>
                  <span>
                    <a data-fancybox-type="iframe" href="<?php echo get_post_permalink($id); ?>" style = "display:none;" class="view_prihil"> Перегляд </a>
                  </span>
                  <span>
                    <a href="#" style = "display:none;" class="change_prihil"> Змінити </a>
                  </span>
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
