<nav id="site-navigation" class="main-navigation <?php if ( ! is_front_page() ) echo 'not-front'; ?>" role="navigation">
	<button class="menu-toggle" aria-controls="top-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'k2k' ); ?></button>
	<?php wp_nav_menu( array( 'theme_location' => 'menu-1', 'menu_id' => 'top-menu' ) ); ?>
</nav>
