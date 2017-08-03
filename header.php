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
<html <?php language_attributes(); ?> class="no-svg">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    
    <div class="site-search-overlay">
        <span class="close-search">x</span>
        <?php get_search_form(); ?>
    </div>
    
<div id="page" class="site <?php echo ( is_page() || is_archive() || is_home() || is_search() || is_404() ) ? 'show-sidebar' : ''; ?>">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'k2k' ); ?></a>

            <!-- Site Search over EVERYTHING else - pushes site down if opened -->
            <div id="site-search-container" class="search-box-wrapper clear" style="display: none;">
                <div class="site-search clear">
                    <?php get_search_form(); ?>
                </div><!-- .site-search -->
            </div><!-- #site-search-container -->
            
            <div class="header-flash row">
                <div class="header-contact container">
                    <?php 
                    $header_text1 = get_theme_mod( 'header_text1' );
                    $header_text2 = get_theme_mod( 'header_text2' );
                    $header_text3 = get_theme_mod( 'header_text3' );
                    
                    if ( $header_text1 || $header_text2 || $header_text3 ) : ?> 
                    <ul>
                        <?php 
                            echo $header_text1 ? "<li class='header-text-one'>$header_text1</li>" : ''; 
                            echo $header_text2 ? "<li class='header-text-two'>$header_text2</li>" : '';
                            echo $header_text3 ? "<li class='header-text-three'>$header_text3</li>" : '';
                        ?>
                    </ul>
                    <?php endif; ?>
                    
                    <?php if ( has_nav_menu( 'social' ) ) : ?>
                        <nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Social Links Menu', 'k2k' ); ?>">
                                <?php
                                        wp_nav_menu( array(
                                                'theme_location' => 'social',
                                                'menu_class'     => 'social-links-menu',
                                                'depth'          => 1,
                                                'link_before'    => '<span class="screen-reader-text">',
                                                'link_after'     => '</span>' /* . k2k_get_svg( array( 'icon' => 'chain' ) ),*/
                                        ) );
                                ?>
                        </nav><!-- .social-navigation -->
                    <?php endif; ?>
                        
                    <div class="search-toggle">
                        <i class="fa fa-search"></i>
                        <a href="#search-container" class="screen-reader-text"><?php _e( 'Search this site', 'jkl' ); ?></a>
                    </div>
                        
                </div><!-- .header-contact -->
                <?php // k2k_social_menu(); ?>

            </div><!-- .header-flash -->
        
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
                
                <div class="site-header-container container">
                
                    <?php get_template_part( 'components/header/site', 'branding' ); ?>

                    <?php if ( is_front_page() ) {
                        get_template_part( 'components/navigation/navigation', 'home' ); 
                    }
                    ?>
                </div><!-- .site-header-container -->

            </header>
            
            <?php //if ( ! is_front_page() ) {
                get_template_part( 'components/navigation/navigation', 'main' ); 
            //}
            ?>
            
            <div class="side-button-container">
            
                    <div class="site-side-button site-search-button">
                        <span class="screen-reader-text"><?php esc_html_e( 'Search', 'k2k' ); ?></span>
                        <i id="site-search-button" class="fa fa-search"></i>
                    </div>

                    <div class="site-side-button site-sidebar-button">
                        <span class="screen-reader-text"><?php esc_html_e( 'Sidebar', 'k2k' ); ?></span>
                        <i id="site-sidebar-button" class="fa fa-gear"></i>
                    </div>
                
                    <?php if ( is_single() ) { 
                            k2k_post_side_navigation();
                    } ?>
                            
                    <div class="site-side-button top-button-container">
                            <a href="#" class="topbutton">
                                <span class="screen-reader-text"><?php esc_html_e( 'Top', 'k2k' ); ?></span>
                                <?php echo k2k_get_svg( array( 'icon' => 'material-arrow-upward' ) ); ?>
                            </a>
                    </div>
                
            </div><!-- .side-button-container -->
        
        
	<div id="content" class="site-content container">
