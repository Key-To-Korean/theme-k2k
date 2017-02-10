<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package K2K
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
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'k2k' ); ?></a>

            <!-- Site Search over EVERYTHING else - pushes site down if opened -->
            <div id="site-search-container" class="search-box-wrapper clear">
                <div class="site-search clear small-12 columns">
                    <?php get_search_form(); ?>
                </div><!-- .site-search -->
            </div><!-- #site-search-container -->
            <div class="search-toggle">
                <i class="fa fa-search">O</i>
                <a href="#search-container" class="screen-reader-text"><?php _e( 'Search this site', 'jkl' ); ?></a>
            </div>
        
            <header role="banner" id="masthead" class="site-header <?php 
                if ( get_header_image() && is_front_page() ) : ?>
                    header-image" style="background-image: url('<?php header_image(); ?>')
                <?php endif; ?>">
                
                <div class="gradient-overlay"></div>
                
		<?php get_template_part( 'components/header/site', 'branding' ); ?>

		<?php get_template_part( 'components/navigation/navigation', 'top' ); ?>

		<?php k2k_social_menu(); ?>

            </header>
        
        
	<div id="content" class="site-content">
