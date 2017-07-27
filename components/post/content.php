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
    
        <div class="entry-header-container">
    
	<?php if ( '' != get_the_post_thumbnail() ) : ?>
		<div class="post-thumbnail-container skewed-thumbnail">
			<a href="<?php the_permalink(); ?>">
				<div class="post-thumbnail" style="background: url(' <?php the_post_thumbnail_url(); ?> ');">
                                </div>
			</a>
		</div>
	<?php endif; ?> 

	<header class="entry-header <?php echo get_the_post_thumbnail() ? 'has-thumbnail' : ''; ?>">
		<?php
			if ( is_single() ) {
				the_title( '<h1 class="entry-title">', '</h1>' );
			} else {
                                if ( is_sticky() ) {
                                    echo '<p class="pinned-post">' . __( 'Pinned Post', 'k2k' ) . '</p>';
                                }
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			}

		if ( 'post' === get_post_type() ) : ?>
		<?php get_template_part( 'components/post/content', 'meta' ); 
                
                if ( is_singular() ) {
                    echo k2k_get_svg( array( 'icon' => 'flourish-one' ) );
                }
                
		endif; ?>
	</header>
            
        </div><!-- .entry-header-container -->
        
        <?php if ( is_singular() || ( is_sticky() && ! is_search() ) ) : ?>
            
	<div class="entry-content row <?php echo is_sticky() ? 'sticky' : ''; ?>">
            
                <?php if ( is_single() ) { k2k_breadcrumbs(); } 
                
                    if ( ! is_single() && is_sticky() ) { 
                        
                        k2k_fancy_excerpt(); 
                        
                    } else {
            
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'k2k' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'k2k' ),
				'after'  => '</div>',
			) );
                        
                    }
                ?>
	</div>
	<?php get_template_part( 'components/post/content', 'footer' ); 
        
        if ( is_singular() ) {
            echo k2k_get_svg( array( 'icon' => 'flourish-one' ) );
        }
        
        endif; ?>
        
</article><!-- #post-## -->