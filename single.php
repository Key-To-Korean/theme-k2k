<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package K2K
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) : the_post();
                
                        if ( is_single() ) { ?>
                            <div class="breadcrumbs entry-meta">
                                <?php k2k_breadcrumbs(); ?>
                            </div>
                        <?php }

			get_template_part( 'components/post/content', get_post_format() );

			// k2k_post_navigation();
                        
                        k2k_author_box();

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
                        
                        k2k_post_navigation();

		endwhile; // End of the loop.
		?>

		</main>
	</div>
<?php
get_sidebar();
get_footer();
