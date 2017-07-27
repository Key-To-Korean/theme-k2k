<nav id="site-navigation" class="home-navigation" role="navigation">
	<button class="menu-toggle" aria-controls="home-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'k2k' ); ?></button>
	<?php wp_nav_menu( array( 'theme_location' => 'menu-2', 'menu_id' => 'home-menu' ) ); ?>
</nav>
