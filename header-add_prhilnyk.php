<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
	<style>
	h1 {
	margin-top: -30px;
	margin-left: 50px;
	margin-bottom: 20px;}

	.input_prihil {width: 100%;}
	table.input_prihil, td, tr{ border: 0px;
	border-collapse: collapse;
	}

	.im_data
	{
	width:20%;
	text-align: right;
	padding-right: 10px;
	vertical-align: top;}

	.val_data
	{vertical-align: top;
	  width:30%;
		font-weight: bold;
	}
	.im_data>p
	{
margin-bottom: 10px;

	}
	</style>

</head>

<body <?php body_class(); ?>>
