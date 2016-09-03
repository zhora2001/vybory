<?php
/*
Template Name: Інформація про прихільника
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

//get_header();
require_once __DIR__.'/header-add_prhilnyk.php';
?>
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
		<h1>Картка прихільника</h1>
			<?php
				// Start the Loop.
//				while ( have_posts() ) : the_post();
//		                      		 <h1>	<?php echo $post->ID;

					$prihil = pods('add_prhilnyk', $post->ID );
//					$prihil = pods('add_prhilnyk',$post->ID);
?>
					<h2>Дільниця № <?php echo  $prihil->display( 'n_diln');?> </h2>
					<table class="input_prihil" >
					<tr>
						<td class="im_data">
							<p>	Призвіще</p>
						</td>
						<td class="val_data">
				        <?php echo  $prihil->display( 'ufamily');?>
						</td>
						<td class="im_data">
							<p>	Ім'я		</p>
						</td>
						<td class="val_data">
				        <?php echo  $prihil->display( 'uname');?>
							</td>
					</tr>
					<tr>
						<td class="im_data">
							<p>	По-батькові		</p>
						</td>
						<td class="val_data">
								<?php echo  $prihil->display( 'ubatk')?>
							</td>
						<td class="im_data">
							<p> День народження		</p>
						</td>
						<td class="val_data">
								<?php echo  $prihil->display( 'beathday') ?>
							</td>
					</tr>
					<tr>
						 <td class="im_data">
								<p>Телефон (осн.) </p>
							</td>
							<td class="val_data">
								<?php echo  $prihil->display( 'tel_o'); ?>
								</td>
							<td class="im_data">
								<p>Телефон (дод.)</p>
							</td>
							<td class="val_data">
							<?php echo  $prihil->display( 'tel_dod'); ?>
							</td>
					</tr>
					<tr>
						<td class="im_data">
							<p>	Адреса </p>
						</td>
						<td class="val_data">
								<?php echo  $prihil->display( 'adressa');?>
							</td>
						<td class="im_data">
							<p> Соцмережі		</p>
						</td>
						<td class="val_data">
								<?php echo  $prihil->display( 'beathday'); ?>
							</td>
					</tr>
					</table>
<?php
					/*
					  Include the post format-specific template for the content. If you want to
					 use this in a child theme, then include a file called called content-___.php
					  (where ___ is the post format) and that will be used instead.
					 */
//					get_template_part( 'content', get_post_format() );

					// Previous/next post navigation.
//					twentyfourteen_post_nav();
//
					// If comments are open or we have at least one comment, load up the comment template.
//					if ( comments_open() || get_comments_number() ) {
//						comments_template();
//					}
//				endwhile;
//
 ?>
		</div><!-- #content -->
	</div><!-- #primary -->

<?php
//get_sidebar( 'content' );
//get_sidebar();
//get_footer();
