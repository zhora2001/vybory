  <?php
/*
Template Name: Паспорт ДВК
 */


 get_header(); ?>

 <script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/js/jquery.fancybox.pack.js"></script>
 <script src="<?php echo get_template_directory_uri() ?>/js/jquery.maskedinput.min.js">
 </script>
  <script src="<?php echo get_template_directory_uri() ?>/js/passport_pr.js">
 </script>
 <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/js/jquery.fancybox.css" type="text/css" media="screen" />
 <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/css/style_v.css" type="text/css" media="all" />


 <div id="main-content" class="main-content">
   <div id="primary" class="content-area" style="padding-top:18px;">
   <div id="content" class="site-content" role="main">

      <?php // Выводим форму

if(is_user_logged_in() && (is_user_role('dilnich')
|| is_user_role("kusch")
|| is_user_role("raion")
|| current_user_can('manage_options')) )
{
    $current_user = wp_get_current_user();
    $var2 = get_user_meta( $current_user->ID);

      ?>
<button id="btn_prihil" type="button" hidden=""> Відкрити форму</button>

        <div id="input_prihil" class="form_input">
          <div id="output" class="povidoml" > </div>
                    <h1>Паспорт ДВК</h1>
    <br>
      <form method="post" enctype="multipart/form-data" id="add_passport">
    <table class="input_prihil">
        <tr>
          <td class="im_data">

            Номер дільниці:
          </td>
          <td  id="nom_dil" class="val_data">
              <input type="text" id="n_diln" name="n_diln" value = "1" hidden="" disabled required/>
              <input type="text" id="n_prih" name="n_prih" value = "-1" hidden=""/>
              <input type="text" id="nazva_d" name="nazva_d" value = "-1" hidden=""/>

              <select id = "spys_diln" name="dl">
                      <?php
                $var3 = '1';

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
                $var2 = get_user_meta(   $current_user->id, $key, true );


                foreach($dil1 as $var1)
                {
                //  if( trim($var1['n_diln']) == trim($var2))
            //      {
                    $a =  $var1['n_diln']." ".$var1['diln'];
                  echo "<option value=".$var1['n_diln'].">Дільниця № $a </option>";
                  $var3 = '2';
            //      }
          //        else {
          //          if (current_user_can('manage_options'))
        //            {
        //            $a =  $var1['n_diln']." ".$var1['diln'];
        //            echo "<option value=".$var1['n_diln'].">Дільниця № $a </option>";
          //        }
            //        }
                }
              //  if ($var3 == '1')
              echo ' <option value="" selected>Выберіть дільницю</option>';
              ?>
            </select>

          </td>
          <td class="im_data">
              <label for="vyd" > Вид </label>
                    </td>
                    <td class="val_data">
                      <select id = "vv1" name="ksch">
                        <option  value="0" selected>Сільська</option>
                        <option value='1'>Міська </option>
                        <option value='2'>Районна </option>
                      </select>

                  </td>
        </tr>

                  <td class="im_data" rowspan="2">
             <label for="adressa">Адреса </label><br /><br />
            </td>
            <td class="adres val_data" rowspan="2">
              <textarea type="text"  name="adressa" id="adressa" required/></textarea>
            </td>
           <td class="im_data" rowspan="2">
               <label for="mezhi">Межі ДВК</label>
            </td>
            <td class="val_data"  rowspan="2">
              	<textarea   type="text"  name="mezhi" id="mezhi"/></textarea>
            </td>
        </tr>

        <tr> <td> </td> <td> </td> <td> </td> <td> </td> </tr>
        <tr>
        <td class="im_data" rowspan="2">
           <label for="pidpryems">Основні підприємства</label><br /><br />
          </td>
          <td class="val_data" rowspan="2">
            <textarea type="text"  name="pidpryems" id="pidpryems"/></textarea>
          </td>
          <td class="im_data">
            <label for="ustanov"> Установи в межах ДВК </label>
          </td>
         <td class="val_data">
               <textarea  type="text" name="ustanovy" id="ustanovy" /></textarea>
         </td>
          </tr>
      <tr> <td> </td> <td> </td> <td> </td> <td> </td> </tr>
      <tr>
      <td class="im_data" rowspan="2">
         <label for="spysok_boss">Список найбільш впливових людей</label><br /><br />
        </td>
        <td class="val_data" rowspan="2">
          <textarea type="text"  name="spysok_boss" id="spysok_boss"/></textarea>
        </td>
        <td class="im_data"  rowspan="2">
             <label for="misce_zustr">Місце зустрічі з людьми</label>
          </td>
          <td class="val_data"  rowspan="2">
              <textarea   type="text"  name="misce_zustr" id="misce_zustr"/></textarea>
          </td>
      </tr>
    <tr> <td> </td> <td> </td> <td> </td> <td> </td> </tr>
<tr>
    <td>

    </td>
    <td>

    </td>
       <td>

     </td>
        <td>
          <div >
                  <br />
          <input class = "btn1" type="submit" name="button" value="Записати" id="sub"/>
          </div>
        </td>
</tr>
</table>
</form>

</div>


<?php

// echo print_r($var2);


$params = array(
//'join' => 'LEFT JOIN `ds_postmeta` as `d1`  ON `d1`.`post_id` = `t`.`id`',
//    'where' => "d1.meta_key = 'n_diln'  and d1.meta_value = '1'",
//'join' => 'JOIN `ds_postmeta` as `d`  ON `d`.`post_id` = `t`.`id`',
//    'where' => "`d`.meta_key = 'n_diln' and meta_value = '5'",
//    'limit'   => -1  // Return all rows
);

// Create and find in one shot

$prihil = pods( 'pasport_dvk', $params );
if($prihil)
{
$f = array('ufamily', 'uname', 'ubatk');
if ( $prihil->total() ) {
    while ( $prihil->fetch() ) {
$id = $prihil->id();
?>
<div class="prihil_nyk">
    <a class="various" data-fancybox-type="iframe"
    href=<?php echo '"'.get_post_permalink($id).'"';?>
    >
    <?php
        echo " Дільниця № ".$prihil->display( 'n_dbk')." &nbsp&nbsp".
                  $prihil->display( 'nazva')." &nbsp&nbsp".
                  //$prihil->display( 'adressa')." &nbsp&nbsp".
                  //$prihil->display( 'ubatk')." &nbsp&nbsp".
                  //$prihil->display( 'beathday')." &nbsp&nbsp".
                  $prihil->display( 'adressa');
                  ?>
              </a>
                <span>
                    <a data-fancybox-type="iframe" href="<?php echo get_post_permalink($id); ?>"
                      style = "display:none;" class="view_prihil"> Перегляд </a>
                  </span>
                  <span>
                    <a href="#" style = "display:none;" class="change_prihil"> Змінити </a>
                  </span>
    <p hidden class="id_p"><?php echo $prihil->display( 'id'); ?> </p>

</div>


<?php
}
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
