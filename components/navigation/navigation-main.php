<nav id="site-navigation" class="main-navigation not-front" role="navigation">
    <div class="main-navigation-container container">
        <?php 
        if ( get_theme_mod( 'dark_logo' ) ) { ?>
        
            <a class="logo screen-reader-text" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">        
                <img src="<?php echo get_theme_mod( 'dark_logo' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
                <p class="site-title"><?php bloginfo( 'name' ); ?></p>
            </a>
    
        <?php } else {
            
            k2k_the_custom_logo();
            
        } ?>
    
	<button class="menu-toggle" aria-controls="top-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'k2k' ); ?></button>
	
        <?php wp_nav_menu( 
                array( 
                    'theme_location' => 'menu-1', 
                    'menu_id' => 'top-menu',
                    'item_spacing' => 'discard'
                    ) ); 
        ?>
    </div><!-- .main-navigation-container -->
</nav>
