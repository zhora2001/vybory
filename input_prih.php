<?php
/*
Template Name: Введення прихільника
 */


 get_header(); ?>
 <script src="<?php echo get_template_directory_uri() ?>/js/input_pr.js">
 </script>
 <div id="main-content" class="main-content">
   <div id="primary" class="content-area">
    <div id="content" class="site-content" role="main">

    <div style="margin-left:10px; border:none;">

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
      	<label> Призвіще <input type="text" name="ufamily" required/></label>
      	<label> Ім\\'я <input name="uname" required/></label>
      	<label>По-батькові <input type="text" name="ubatk"/></label>
      	<label>Телефон <input name="tel"/></label>
      	<label id="first_img" class='imgs'>Дополнительные фото(произвольное): <input type='file' name='imgs[]'/></label>
      	<a href="#" id="add_img">Загрузить еще фото</a>
      	<input type="submit" name="button" value="Отправить" id="sub"/>
      	<div id="output"></div> <?php // сюда будем выводить ответ ?>

 </div>
</div><!-- #content -->
</div><!-- #primary -->
 <?php get_sidebar( 'content' ); ?>
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer();
