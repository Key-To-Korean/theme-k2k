<div class="site-info container">
    <?php if ( has_nav_menu( 'menu-3' ) ) : ?>
            <nav class="footer-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer Menu', 'k2k' ); ?>">
                    <?php
                            wp_nav_menu( array(
                                    'theme_location' => 'menu-3',
                                    'menu_class'     => 'footer-menu',
                                    'depth'          => 1,
//                                    'link_before'    => '<span class="screen-reader-text">',
//                                    'link_after'     => '</span>' . k2k_get_svg( array( 'icon' => 'chain' ) ),
                            ) );
                    ?>
            </nav><!-- .social-navigation -->
    <?php endif; ?>
    
    <?php if ( has_nav_menu( 'social' ) ) : ?>
            <nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Social Links Menu', 'k2k' ); ?>">
                    <?php
                            wp_nav_menu( array(
                                    'theme_location' => 'social',
                                    'menu_class'     => 'social-links-menu',
                                    'depth'          => 1,
                                    'link_before'    => '<span class="screen-reader-text">',
                                    'link_after'     => '</span>' . k2k_get_svg( array( 'icon' => 'chain' ) ),
                            ) );
                    ?>
            </nav><!-- .social-navigation -->
    <?php endif; ?>
    <div class="credits">
        <?php 
        printf( esc_html__( '%1$s is a %2$s theme designed by %3$s.', 'k2k' ), 
                '<strong>K2K</strong>', 
                '<a href="http://wordpress.org"><i class="fa fa-wordpress"><span class="screen-reader-text">WordPress</span></i></a>', 
                '<a href="http://aaronsnowberger.com/" rel="designer" title="Aaron Snowberger">Aaron</a>' ); 
        ?>
    </div><!-- .credits -->
    <div class="copyright">
        <?php k2k_dynamic_copyright(); ?>
    </div>
</div><!-- .site-info -->