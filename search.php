<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package K2K
 */

get_header(); ?>

<?php
if ( have_posts() ) : ?>

        <header class="page-header">
                <h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'humescores' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
        </header><!-- .page-header -->

<?php
else:
    
    get_template_part( 'components/post/content', 'none' );
    return;
    
endif;
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'components/post/content' );

			endwhile;

			the_posts_pagination( array(
                            'prev_text'     => __( 'Newer', 'k2k' ),
                            'next_text'     => __( 'Older', 'k2k' ),
                            'before_page_number'    => '<span class="screen-reader-text">' . __( 'Page ', 'k2k' ) . '</span>',
                        ) );
                        ?>

		</main>
	</section>
<?php
get_sidebar();
get_footer();
