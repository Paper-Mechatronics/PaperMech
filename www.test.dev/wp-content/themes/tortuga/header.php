<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Tortuga
 */
 
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<div id="page" class="hfeed site">
		
		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'tortuga' ); ?></a>
		
		<div id="header-top" class="header-bar-wrap"><?php do_action( 'tortuga_header_bar' ); ?></div>
		
		<header id="masthead" class="site-header clearfix" role="banner">

			
			<div class="header-main container clearfix">
						
				<div id="logo" class="site-branding clearfix">
				
					
					<?php tortuga_site_title(); ?>
					<?php tortuga_site_description(); ?>
					
				</div><!-- .site-branding -->
				<div class="header-widgets clearfix">

				
					
					<?php // Display Header Widgets
					if( is_active_sidebar( 'header' ) ) : 
			
						dynamic_sidebar( 'header' );
						
					endif; ?>
					
				</div><!-- .header-widgets -->
				
			
			</div><!-- .header-main -->
			
			<div id="main-navigation-wrap" class="primary-navigation-wrap">
				
				<nav id="main-navigation" class="primary-navigation navigation container clearfix" role="navigation">
					<?php tortuga_site_logo(); ?>
					<?php 
						// Display Main Navigation
						wp_nav_menu( array(
							'theme_location' => 'primary', 
							'container' => false, 
							'menu_class' => 'main-navigation-menu', 
							'echo' => true, 
							'fallback_cb' => 'tortuga_default_menu')
						);
					?>
				</nav><!-- #main-navigation -->
				
			</div>
		
		</header><!-- #masthead -->
		
		<?php tortuga_breadcrumbs(); ?>
		<?php if(is_front_page() ) : ?>
		<?php tortuga_header_image(); ?>
		<?php endif; ?>
		
			
		<div id="content" class="site-content container clearfix">