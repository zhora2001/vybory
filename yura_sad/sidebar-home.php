<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Home Widgets Template
 *
 *
 * @file           sidebar-home.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2014 CyberChimps
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/responsive/sidebar-home.php
 * @link           http://codex.wordpress.org/Theme_Development#Widgets_.28sidebar.php.29
 * @since          available since Release 1.0
 */
?>
<?php responsive_widgets_before(); // above widgets container hook ?>
	<div id="widgets" class="home-widgets">
		<div id="home_widget_1" class="grid col-300">
			<?php responsive_widgets(); // above widgets hook ?>

			<?php if ( !dynamic_sidebar( 'home-widget-1' ) ) : ?>
				<div class="widget-wrapper">
					<a href="http://www.dobrosad.com.ua/?product_cat=dereva">
					<div class="widget-title-home"><h3 style="font-weight:bold;color: #759001"><?php _e( 'Плодові дерева', 'responsive' ); ?></h3></div>
					<div class="textwidget">
						<img src="<?php echo get_template_directory_uri().'/images/box1.jpg'?>" alt="responsivepro">
					</div>
					<div class="textwidget"><?php _e( 'Одно-дворічні садженці плодових дерев - пересика, черешні, вишні, яблуні, груші, сливи, айва, абрикос. Для садженців використовуються високоякісні прищепи - айва, алича, пуміселект, М9, М106 або 54-118, колт, антипка.', 'responsive' ); ?></div>
					</a>

				</div><!-- end of .widget-wrapper -->
			<?php endif; //end of home-widget-1 ?>

			<?php responsive_widgets_end(); // responsive after widgets hook ?>
		</div><!-- end of .col-300 -->

		<div id="home_widget_2" class="grid col-300">
			<?php responsive_widgets(); // responsive above widgets hook ?>

			<?php if ( !dynamic_sidebar( 'home-widget-2' ) ) : ?>
				<div class="widget-wrapper">
					<a href="http://www.dobrosad.com.ua/?product_cat=kusch">
					<div class="widget-title-home"><h3 style="font-weight:bold;color: #759001"><?php _e( 'Ягідні кущі', 'responsive' ); ?></h3></div>
					<div class="textwidget">
						<img src="<?php echo get_template_directory_uri().'/images/box2.jpg'?>" alt="responsivepro">
					</div>
					<div class="textwidget"><?php _e( 'Неперевершене джерело вітамінів та корисних речовин є ягідні кущі. Пропонуємо вам широкий вибір сортів чорної смородини, порічки, білої смородини, малини, аґруса, фундука. В наявності сорти нової селекції та перевірені часом сорти.', 'responsive' ); ?></div>
				</a>
				</div><!-- end of .widget-wrapper -->
			<?php endif; //end of home-widget-2 ?>

			<?php responsive_widgets_end(); // after widgets hook ?>
		</div><!-- end of .col-300 -->

		<div id="home_widget_3" class="grid col-300 fit">
			<?php responsive_widgets(); // above widgets hook ?>

				<?php if ( !dynamic_sidebar( 'home-widget-3' ) ) : ?>
				<div class="widget-wrapper">
					<a href="http://www.dobrosad.com.ua/?product_cat=decorat">
					<div class="widget-title-home"><h3 style="font-weight:bold;color: #759001"><?php _e( 'Декоративні рослини', 'responsive' ); ?></h3></div>
					<div class="textwidget">
						<img src="<?php echo get_template_directory_uri().'/images/box3.jpg'?>" alt="responsivepro">
					</div>
    					<div class="textwidget"><?php _e( '
Декоративні рослини - кращі для ландшафтного дизайну. На сьогоднішній день існує безліч їх різновидів, які дивують різноманіттям кольору і формою крон. За допомогою комбінацій цих рослин можна створювати дуже ефектні композиції.', 'responsive' ); ?></div>
			</a>
				</div><!-- end of .widget-wrapper -->
			<?php endif; //end of home-widget-3 ?>

			<?php responsive_widgets_end(); // after widgets hook ?>
		</div><!-- end of .col-300 fit -->
	</div><!-- end of #widgets -->
<?php responsive_widgets_after(); // after widgets container hook ?>
