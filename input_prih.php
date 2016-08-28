<?php
/*
Template Name: Введення прихільника
 */


 get_header(); ?>

 <script src="<?php echo get_template_directory_uri() ?>/js/jquery.maskedinput.min.js">
 </script>
  <script src="<?php echo get_template_directory_uri() ?>/js/input_pr.js">
 </script>
  <style>
table.input_prihil, td, tr{ border: 0px;
border-collapse: collapse;
}
input, textarea {
  border:none;
  border-bottom: 1px solid;
    border-top:0px; width:100%;
    margin-bottom:2px;
    font-weight:bold;}
.im_data
{width:15%;
text-align: right;
padding-right: 10px;
padding-top:10px;
padding-bottom:10px;
vertical-align: bottom;}

.val_data
{vertical-align: bottom;
  width:35%;
};
.adres
{
vertical-align: top;
}

</style>
 <div id="main-content" class="main-content">
   <div id="primary" class="content-area">
    <div id="content" class="site-content" role="main">

        <?php
      /*// подготовим актуальные данные таксономий
      $childs = "";
      $parents ="";
      $tags = "";

      $cats = get_terms('custom_tax_like_cat', 'orderby=name&hide_empty=0&parent=0'); // получим все термины(элементы) таксономии с иерархией
      foreach ($cats as $cat) { // пробежим по каждому полученному термину
          $parents.="<option value='$cat->term_id' />$cat->name</option>"; // суем id и название термина в строку для вывода внутри тэга select
          $childs_array = get_terms('custom_tax_like_cat', 'orderby=name&hide_empty=0&parent='.$cat->term_id); // возьмем все дочерние термины к текущему
      	foreach ($childs_array as $child){
      		$childs.="<option value='$child->term_id' class='$cat->term_id' />$child->name</option>"; // делаем то же самое, класс должен быть равным id родительского термина чтобы плагин chained работал
      	}
      }

      $tags_array = get_terms('custom_tax_like_tag', 'orderby=none&hide_empty=0&parent=0'); // получим все термины таксономии без вложенности
      foreach ($tags_array as $tag) { // пробежим по каждому
        $tags .= '<label><input type="radio" name="tag" value="'.$tag->term_id.'">'.$tag->name.'</label>'; // суем все в radio баттоны
      }
    */  ?>
      <?php // Выводим форму ?>
      <form method="post" enctype="multipart/form-data" id="add_object">
      <table class="input_prihil">
        <tr>
          <td class="im_data">
            <label for="ufamily" > Призвіще </label>
          </td>
            <td class="val_data">
              <input type="text" id="ufamily" required/>
             </td>

        </tr>
 <tr>     <td class="im_data">	<label for="uid"> Ім'я </label></td>
    <td class="val_data">	<input  type="text" id="uname" required/></td>
    <td class="im_data">
      <label for="pasport_copy" > Копія паспорта </label>
    </td>
    <td class="val_data">
     <input type='file' id='pasport_copy[]' />
     <a href="#" id="passport">Завантажити ще</a>
   </td>
</tr>
      <tr>  <td class="im_data">	<label for="ubatk">По-батькові </label></td>
        <td class="val_data">	<input  type="text" type="text" id="ubatk" required/></td>
</tr>
<tr>  <td class="im_data"> <label for="beathday">Дата народження </label></td>
   <td class="val_data">	<input  type="text"  id="beathday" required/></td>
</tr>

<tr> <td class="im_data"> <label for="tel_o">Телефон (осн.) </label></td>
    <td class="val_data">	<input  type="text" id="tel_o" required/></td>
</tr>
      <tr> <td class="im_data">  <label for="tel_dod">Телефон (дод.)</label></td>
        <td class="val_data">	<input  type="text" id="tel_dod"/></td>
</tr>
<tr>
  <td class="im_data" rowspan="2">  <label for="adressa">Адреса </label>
  </td>
  <td class="adres" rowspan="2"><textarea type="text"  id="adressa" required/></textarea>
    </td>
</tr>
      <tr> <td class="im_data"> <label for="sotc_merega">Профиль в соцмережах або скайп</label></td>
         <td class="val_data">	<input  type="text" id="sotc_merega"/></td>
</tr>

  <tr>  <td colspan="4">
    	<label id="first_img" class='imgs'>Дополнительные фото(произвольное):
        <input type='file' id='imgs[]'/></label>
        <a href="#1" id="add_img">Загрузить еще фото</a>
</td>
</tr colspan="4">
   <td>	<input type="submit" name="button" value="Отправить" id="sub"/> </td>
</tr colspan="4">
   	<div id="output"></div> <?php // сюда будем выводить ответ ?>
</tr> </table>
</div><!-- #content -->
</div><!-- #primary -->
 <?php get_sidebar( 'content' ); ?>
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer();
