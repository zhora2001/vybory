<?php
/*
Template Name: Введення проблеми на дільниці
 */
 //<?php
 //wp_nav_menu( array( 'theme_location' => 'primary', 'items_wrap' => '<ul><li id="item-id">Список: </li>%3$s</ul>' ) );
 //

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
  <h1>Внесення проблеми</h1>
    <ul class="new_input">
          <li class="im_data" hidden="">
          <label>  Номер округу:</label>
          </li>
          <li  class="val_data" id="nom_dil">
              <input type="text" id="n_diln" name="n_diln"  hidden="" required/>
              <input type="text" id="n_prih" name="n_prih" value = "-1" hidden=""/>
          <select id = "spys_diln" name="dl" hidden="">
                  <?php
            $var3 = '1';
            $var33 = '1';

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
              if ($var33 == 1 )
          {
          echo "<option value=".$var1['n_diln'].">Округ № $a </option>";
          $var33 = '0';
          }
          else {
            echo "<option value=".$var1['n_diln'].">Округ № $a </option>";
          }
              }

      //      if ($var3 == '1')
      //    echo ' <option value="" selected>Выберіть округ</option>';
          ?>
        </select>
      </li>
      <li class="im_data">
        <label for="title_p" > Назва проблеми </label>
      </li>
      <li class="val_data">
        <input type="text" class="val_input" name="title_p" id="title_p" required/>
      </li>
      <li class="im_data" hidden>
      <label for="status_p"> Статус проблеми </label>
      </li>
        <li class="val_data" style="float:left;" hidden>
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
      <textarea type="text" class="val_input" name="opys_p" id="opys_p" required/>
      </textarea>
    </li>

    <li class="im_data" >
    <label for="propos_v">Пропозиції щодо вирішення </label><br /><br />
    </li>
    <li class="val_data">
    <textarea type="text" class="val_input" name="propos_v" id="propos_v" /></textarea>
    </li>
    <li class="im_data" >
      <label for="declar" > Фото (jpg) </label>
    </li>
    <li class="val_data">
      <input type='file' class="val_input" style="float:none;" name='declar[]' id='declar'>
    </input>
    <li class="im_data" >
    </li>
          <div >
       <a href="#" id="dod_declar">додати ще</a>
      </div>
    </li>
    <br/>
    <li class="im_data" hidden>
      <label for="smi" > Висвітлення в ЗМІ </label>
    </li>
    <li class="val_data"  hidden>
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
<li>
  <input class = "btn1" type="submit" name="button" value="Записати" id="sub"/>
</li>
</ul>
</form>
<div id="output"></div>
</div>


<?php

// echo print_r($var2);

// Create and find in one shot


    global $post;

    $args = array(
    	'post_type'=> 'problemy',
      'author'=> get_current_user_id(),
    );

    $myposts = new WP_Query( $args );
    //$myposts = get_posts('post_type=problemy');

    if ( $myposts->have_posts() ) :
    				// Start the Loop.
    				while ( $myposts->have_posts() ) : $myposts->the_post();
            ?>
                        <div>
                            <a class="various" data-fancybox-type="iframe" href="<?php echo get_permalink(); ?>"></a>

            <?php
            get_template_part( 'content', get_post_format() );
?>
</div>
<?php
  				endwhile;
  				// Previous/next post navigation.
  				twentyfourteen_paging_nav();

  			else :
  				// If no content, include the "No posts found" template.
  				get_template_part( 'content', 'none' );

  			endif;

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
