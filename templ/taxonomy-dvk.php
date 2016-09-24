<?php
/**
 * The template for displaying Post Format pages
 *
 * Used to display archive-type pages for posts with a post format.
 * If you'd like to further customize these Post Format views, you may create a
 * new template file for each specific one.
 *
 * @todo https://core.trac.wordpress.org/ticket/23257: Add plural versions of Post Format strings
 * and remove plurals below.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header();

$spysok_diln = "";
if(is_user_role('raion'))
{
$key = 'raion';
$var2 = get_user_meta( $current_user->ID, $key, true );
			$dil1=cut_diln($var2);
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
$termin = wp_get_post_terms( $post->ID, 'dvk', false);
	$flag = '';
?>


	<section id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			<?php
			foreach ($dil1 as $key1) {
				if (trim($key1['n_diln']) == trim($termin[0]->name))
				$flag = "TRUE";
					}
	
				if(is_user_logged_in() && ( current_user_can('manage_options') || is_user_role("raion")
				|| is_user_role("dilnich") || is_user_role("kusch"))
				 && !($flag == ''))
			{
				if ( have_posts() ) : ?>

			<header class="archive-header">
				<h1 class="archive-title">
					<?php
				echo "asdfasdfa ";
						if ( is_tax( 'post_format', 'post-format-aside' ) ) :
							_e( 'Asides', 'twentyfourteen' );

						elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
							_e( 'Images', 'twentyfourteen' );

						elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
							_e( 'Videos', 'twentyfourteen' );

						elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
							_e( 'Audio', 'twentyfourteen' );

						elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
							_e( 'Quotes', 'twentyfourteen' );

						elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
							_e( 'Links', 'twentyfourteen' );

						elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
							_e( 'Galleries', 'twentyfourteen' );

						else :
							_e( 'Archives', 'twentyfourteen' );

						endif;
					?>
				</h1>
			</header><!-- .archive-header -->

			<?php
					// Start the Loop.
					while ( have_posts() ) : the_post();

						/*
						 * Include the post format-specific template for the content. If you want to
						 * use this in a child theme, then include a file called called content-___.php
						 * (where ___ is the post format) and that will be used instead.
						 */
					get_template_part( 'content-dvk', get_post_format() );

					endwhile;
					// Previous/next page navigation.
					twentyfourteen_paging_nav();

				else :
					// If no content, include the "No posts found" template.
					get_template_part( 'content', 'none' );

				endif;
			}
			else {
			echo " <p> У Вас недостатньо повноважень для перегляду даних на цій дільниці!</p>";
			 }

			?>

		</div><!-- #content -->
	</section><!-- #primary -->

<?php
get_sidebar( 'content' );
get_sidebar();
get_footer();
