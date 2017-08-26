<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package K2K
 */

get_header();

// Start the Loop
while ( have_posts() ) : the_post();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

						<?php
                        if ( is_single() ) { ?>
                            <div class="breadcrumbs-container">
                                <div class="breadcrumbs  entry-meta">
                                    <?php k2k_breadcrumbs(); ?>
                                </div>
                            </div>
                        <?php }

			get_template_part( 'components/post/content', get_post_format() );

			// k2k_post_navigation();

                        k2k_author_box();

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

			// New section for infinite scroll
			?>
			<nav class="navigation post-navigation load-previous" role="navigation">
				<span class="nav-subtitle"><?php esc_html_e( 'Previous post', 'k2k' ); ?></span>
				<div class="nav-links">
					<div class="nav-previous">
						<?php $previous_post = get_previous_post(); ?>
						<a href="<?php echo get_permalink( $previous_post->ID ); ?>" data-id="<?php echo $previous_post->ID; ?>">
							<?php echo $previous_post->post_title; ?>
						</a>
						<div class="ajax-loader">
							<img src="<?php echo get_theme_file_uri('js/spinner.svg'); ?>" width="32" height="32">
						</div>
					</div>
				</div>
			</nav>
			<?php
                        k2k_post_navigation();
		?>

		</main>
	</div>
<?php
endwhile; // End of the loop.

get_sidebar();
get_footer();
