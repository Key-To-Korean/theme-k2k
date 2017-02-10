		<div class="site-branding">
                    
                    <?php k2k_the_custom_logo(); ?>
                    
                    <div class="site-branding-text">
			<?php
			if ( is_front_page() && is_home() ) : ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else : ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php
			endif;

			$description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() ) : ?>
                                <p class="site-description">
                                <?php if ( get_theme_mod( 'blogdescription_xl' ) != '' ) : 
                                       echo get_theme_mod( 'blogdescription_xl' );
                                else : echo $description; /* WPCS: xss ok. */
				endif; ?>
                                </p>
			<?php
			endif; ?>
                    </div><!-- .site-branding-text -->
		</div><!-- .site-branding -->