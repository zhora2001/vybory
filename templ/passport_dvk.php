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
  <style>
h1 {
    margin-top: 10px;
    margin-left: 50px;
    margin-bottom: 10px;
    }

.input_prihil {width: 97%;}
table.input_prihil, td, tr{ border: 0px;
border-collapse: collapse;
}
input, textarea, select {
  border:none;
  border-bottom: 1px solid;
    border-top:0px; width:100%;
    margin-bottom:2px;
    font-weight:bold;}
.input_chk {width: auto; padding: 5px;}
.im_data
{width:20%;
text-align: right;
padding-right: 10px;
padding-top:0px;
padding-bottom:10px;
vertical-align: bottom;}

.val_data
{vertical-align: bottom;
  width:30%;
}
.adres
{
vertical-align: top;
}
.check_b {
text-align: right;}

.check_b label {
display: block;
margin-right: 15px;
}
.check_b1 {
text-align: left;}
.check_b1 label {
display: block;
margin-left: 5px;
}
.btn1 {
//  width: 50%;
   margin-top: 30px;
   margin-left: 20px;
   margin-right: 20px;
   margin-bottom: 20px;
}
#btn_prihil
{
margin-left: 700px;
margin-bottom: 20px;
}

 input.btn1{width: 75%;}
 .n_dil {margin-bottom: 15px;}
 .prihil_nyk {height: 20px;}
 .prihil_nyk p {
   line-height: 1;
   margin-bottom: 0px;
   margin-top: 0px;
   -webkit-margin-before:0em;
  -webkit-margin-after:0em;
}
  .prihil_nyk a {
    line-height: 1;
//    text-decoration: underline;
  }
  .change_prihil, .view_prihil
  {
    margin-top: -2px;
    margin-left: 15px;
    font-weight: bold;
    font-size: 0.8em;
    text-decoration: underline
}
.various
{
  margin-left: 15px;
//  font-weight: bold;
//  font-size: 0.8em;
//  text-decoration: underline
}

</style>

 <div id="main-content" class="main-content">
   <div id="primary" class="content-area" style="padding-top:18px;">
   <div id="content" class="site-content" role="main">

      <?php // Выводим форму

if(is_user_logged_in() && (is_user_role('dilnich')
|| is_user_role("kusch")
|| is_user_role("raion")) )
{
    $current_user = wp_get_current_user();
    $var2 = get_user_meta( $current_user->ID);

      ?>
<button id="btn_prihil" type="button"> Відкрити форму</button>
<div id="output"></div>
        <div id="input_prihil">
        <h1>Паспорт ДВК</h1>
    <br>
      <form method="post" enctype="multipart/form-data" id="add_object">
    <table class="input_prihil">
        <tr>
          <td class="im_data">
            Номер дільниці:
          </td>
          <td  id="nom_dil">
              <input type="text" id="n_diln" name="n_diln" value = "1" required/>
              <input type="text" id="n_prih" name="n_prih" value = "-1" hidden=""/>
          </td>
          <td>
                  </td>
                  <td>
                  </td>
        </tr>

        <tr>
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
             <td class="im_data">
               <label for="ustanov"> Установи в межах ДВК </label>
             </td>
            <td class="val_data">
                  <textarea  type="text" name="ustanovy" id="ustanovy" /></textarea>
            </td>
        </tr>
          <tr>
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
            <textarea type="text"  name="pidpryems" id="pidpryems" required/></textarea>
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
      <td class="im_data" rowspan="2">
         <label for="spysok_boss">Список найбільш впливових людей</label><br /><br />
        </td>
        <td class="val_data" rowspan="2">
          <textarea type="text"  name="spysok_boss" id="spysok_boss" required/></textarea>
        </td>
        <td class="im_data"  rowspan="2">
           <label for="misce_zustr1"></label>
        </td>
        <td class="val_data"  rowspan="2">
            <textarea   type="text"  name="misce_zustr1" id="misce_zustr1" hidden/></textarea>
        </td>
    </tr>
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

$prihil = pods( 'pasport_dvk', $params );
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
