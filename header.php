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
<div id="page" class="site <?php echo ( is_page() || is_archive() || is_home() || is_search() || is_404() ) ? 'show-sidebar' : ''; ?>">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'k2k' ); ?></a>

            <!-- Site Search over EVERYTHING else - pushes site down if opened -->
            <div id="site-search-container" class="search-box-wrapper clear" style="display: none;">
                <div class="site-search clear">
                    <?php get_search_form(); ?>
                </div><!-- .site-search -->
            </div><!-- #site-search-container -->
            
            <div class="header-flash row">
                <div class="header-contact">
                     <ul>
                         <li>Brooklyn, NY 10036, United States</li>
                         <li>1-800-123-1234</li>
                         <li>info@eco-nature.com</li>
                     </ul>
                </div>
                <?php k2k_social_menu(); ?>
                <div class="search-toggle">
                    <i class="fa fa-search"></i>
                    <a href="#search-container" class="screen-reader-text"><?php _e( 'Search this site', 'jkl' ); ?></a>
                </div>
            </div>
        
            <header role="banner" id="masthead" class="site-header <?php 
                if ( get_header_image() && is_front_page() ) : ?>
                    header-image" style="background-image: url('<?php header_image(); ?>')
                <?php elseif( ! is_front_page() ) : ?>
                    not-front
                    <?php if( has_post_thumbnail() ) : ?>
                    " style="background-image: url('<?php the_post_thumbnail_url(); ?>')
                    <?php endif; ?>
                <?php endif; ?>">
                
                <div class="gradient-overlay"></div>
                
                <div class="site-header-container">
                
                    <?php get_template_part( 'components/header/site', 'branding' ); ?>

                    <?php if ( is_front_page() ) {
                        get_template_part( 'components/navigation/navigation', 'top' ); 
                    }
                    ?>
                </div><!-- .site-header-container -->

            </header>
            
            <?php if ( ! is_front_page() ) {
                get_template_part( 'components/navigation/navigation', 'top' ); 
            }
            ?>
            
            <div class="site-search-button site-side-button">
                <i id="site-search-button" class="fa fa-search"></i>
            </div>
            <div class="site-search-overlay">
                <?php get_search_form(); ?>
            </div>
            
            <div class="site-sidebar-button site-side-button">
                <i id="site-sidebar-button" class="fa fa-backward"></i>
            </div>
        
        
	<div id="content" class="site-content">
