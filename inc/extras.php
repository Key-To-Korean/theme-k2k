<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package K2K
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function k2k_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
                $classes[] = 'archive-view';
	}
	
	// Add a class of no-sidebar when there is no sidebar present
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	} else {
                $classes[] = 'has-sidebar'; 
        }
        
        // Add a class of no-sidebar when there is no sidebar present
	if ( is_page() && is_active_sidebar( 'sidebar-3' ) ) {
		$classes[] = 'has-page-sidebar';
	} 

	return $classes;
}
add_filter( 'body_class', 'k2k_body_classes' );

/**
 * Add a "STOP" at the end of the Post Content
 */
function k2k_end_content ( $content ) {
    $last_tag = strrpos( $content, '</' );
    $content_end = substr( $content, $last_tag );
    return substr( $content, 0, $last_tag ) . k2k_get_svg( array( 'icon' => 'material-stop' ) ) . $content_end;
}
add_filter( 'the_content', 'k2k_end_content' );

/**
 * Filters out the parentheses from Category Count
 * 
 * @param type $variable
 * @return type
 */
function k2k_categories_postcount_filter ( $count ) {
        $count = str_replace( '(', '<span class="post_count">', $count );
        $count = str_replace( ')', '</span>', $count );
        return $count;
}
add_filter( 'wp_list_categories','k2k_categories_postcount_filter' );

/**
 * Filters out the parentheses from Archives Count
 * 
 * @param type $variable
 * @return type
 */
function k2k_archive_postcount_filter ($count) {
   $count = str_replace( '(', '<span class="post_count">', $count );
   $count = str_replace( ')', '</span>', $count );
   return $count;
}
add_filter( 'get_archives_link', 'k2k_archive_postcount_filter' );