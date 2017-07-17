<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package K2K
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
	<?php if ( '' != get_the_post_thumbnail() ) : ?>
        <div class="entry-header-container row">
		<div class="post-thumbnail" style="background: url(' <?php the_post_thumbnail_url(); ?> ');">
			<!--<a href="<?php //the_permalink(); ?>">-->
				<?php //the_post_thumbnail( 'k2k-featured-image' ); ?>
			<!--</a>-->
		</div>
	<?php endif; ?>
            
        <?php if ( is_single() ) { k2k_breadcrumbs(); } ?>

	<header class="entry-header">
		<?php
			if ( is_single() ) {
				the_title( '<h1 class="entry-title">', '</h1>' );
			} else {
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			}

		if ( 'post' === get_post_type() ) : ?>
		<?php get_template_part( 'components/post/content', 'meta' ); ?>
		<?php
		endif; ?>
	</header>
            
        <?php if ( '' != get_the_post_thumbnail() ) { echo '</div><!-- .entry-header-container -->'; } ?>
            
	<div class="entry-content row">
		<?php
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'k2k' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'k2k' ),
				'after'  => '</div>',
			) );
		?>
	</div>
	<?php get_template_part( 'components/post/content', 'footer' ); ?>
</article><!-- #post-## -->