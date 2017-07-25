<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package K2K
 */

get_header(); ?>

<?php
if ( have_posts() ) : ?>

    <header class="page-header">
            <?php
                    the_archive_title( '<h1 class="page-title">', '</h1>' );
                    the_archive_description( '<div class="taxonomy-description">', '</div>' );
            ?>
    </header>

<?php 
else : 
    
    get_template_part( 'components/post/content', 'none' );
    return;
    
endif; ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">   
                    
			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'components/post/content', get_post_format() );

			endwhile;

			the_posts_pagination( array(
                            'prev_text'     => k2k_get_svg( array( 'icon' => 'level-up' ) ) . __( 'Newer', 'k2k' ),
                            'next_text'     => __( 'Older', 'k2k' ) . k2k_get_svg( array( 'icon' => 'level-down' ) ),
                            'before_page_number'    => '<span class="screen-reader-text">' . __( 'Page ', 'k2k' ) . '</span>',
                        ) );
                        ?>

		</main>
	</div>
<?php
get_sidebar();
get_footer();
