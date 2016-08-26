<?php
/*
Template Name: Внесення прихильника
 */


 get_header(); ?>
 <script src="<?php echo get_template_directory_uri() ?>/js/check_pr.js">
 </script>
<style> .empty_field {background: grey;}
  </style>
 <div id="main-content" class="main-content">


 <?php
 	if ( is_front_page() && twentyfourteen_has_featured_posts() ) {
 		// Include the featured content template.
 		get_template_part( 'featured-content' );
 	}
 ?>
 	<div id="primary" class="content-area">
 		<div id="content" class="site-content" role="main">

    <div style="margin-left:10px; border:none;">
            <form  class="prihil form_check form_style" method="post">
              <table style="border:none;">
  			<tr>
  				<td>Ім"'"я <font color="red">*</font>:</td>
  				<td><input type="text" size="30" name="extra[Name]" class = "rfield"></td>
  			</tr>
        <tr>
				<td>&nbsp;</td>
				<td colspan="2">
        <button type="submit" class="btnsubmit">"Внести"</button>
          </td>
			       </tr>
          </table>
        </form>
      </div>
		</div><!-- #content -->
	</div><!-- #primary -->

  <?php get_sidebar( 'content' ); ?>
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer();
