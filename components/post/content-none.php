<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package K2K
 */

?>

<header class="page-header">
        <h1 class="page-title">
            <?php 
            if ( is_404() ) {
                esc_html_e( 'Page not available', 'k2k' ); 
            } elseif ( is_search() ) {
                /* translators: %s = search query */
                printf( esc_html__( 'Nothing found for &ldquo;%s&rdquo;', 'k2k' ), get_search_query() );
            } else {
                esc_html_e( 'Nothing found', 'k2k' ); 
            }
            ?>
        </h1>
</header><!-- .page-header -->

<section id="primary" class="content-area not-found <?php echo is_404()? 'error-404' : 'no-results'; ?>">
    <main id="main" class="site-main" role="main">
        
        <div class="page-content">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'k2k' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'k2k' ); ?></p>
			<?php get_search_form();
                        
                elseif ( is_404() ) : ?>

			<p><?php esc_html_e( 'You seem to be lost. To find what you are looking for check out the most recent articles below or try a search:', 'k2k' ); ?></p>
			<?php get_search_form();

		else : ?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'k2k' ); ?></p>
			<?php get_search_form();

		endif; ?>
	</div>
        
        <?php
        if ( is_404() || is_search() ) {
        ?>
                <h2 class="page-title secondary-title"><?php esc_html_e( 'Recent posts:', 'k2k' ); ?></h2>
                <?php
                // Get the 10 latest posts
                $args = array(
                        'posts_per_page' => 10
                );
                $latest_posts_query = new WP_Query( $args );
                // The Loop
                if ( $latest_posts_query->have_posts() ) {
                                while ( $latest_posts_query->have_posts() ) {
                                        $latest_posts_query->the_post();
                                        // Get the standard index page content
                                        get_template_part( 'components/post/content', get_post_format() );
                                }
                } 
                /* Restore original Post Data */
                wp_reset_postdata();
        } // endif
        ?>
        
    </main>
</section><!-- .no-results -->

<?php
get_sidebar();
get_footer();