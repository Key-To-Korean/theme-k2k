<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package K2K
 */

if ( ! function_exists( 'k2k_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function k2k_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( '%s', 'post date', 'k2k' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		esc_html_x( '%s', 'post author', 'k2k' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="byline">' . k2k_get_svg( array( 'icon' => 'material-account-circle' ) ) . ' ' . $byline . '</span>';
        echo '<span class="posted-on">' . k2k_get_svg( array( 'icon' => 'material-schedule' ) ) . ' ' . $posted_on . '</span>'; // WPCS: XSS OK.

        if ( k2k_show_word_count() ) {
                printf( '<span class="word-count">%s %s</span>', 
                        k2k_get_svg( array( 'icon' => 'material-timelapse' ) ), 
                        sprintf( _nx( '%s Minute', '%s Minutes', k2k_word_count(), 'time to read', 'k2k' ), k2k_word_count() ) 
                );
        }
        
        if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		// echo ( ! is_archive() && ! is_home() && ! is_search() ) ? '<br>' : ' ';
                echo ' <span class="comments-link">';
		comments_popup_link( 
                        k2k_get_svg( array( 'icon' => 'comment' ) ) . esc_html__( ' Leave a comment', 'k2k' ), 
                        k2k_get_svg( array( 'icon' => 'comment' ) ) . esc_html__( ' 1', 'k2k' ), 
                        k2k_get_svg( array( 'icon' => 'comment-discussion' ) ) . esc_html__( ' %', 'k2k' ) );
		echo '</span>';
	}
        
        edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( '%s Edit %s', 'k2k' ),
                        k2k_get_svg( array( 'icon' => 'material-mode-edit' ) ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;

if ( ! function_exists( 'k2k_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function k2k_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() && is_singular() ) {

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( '', 'k2k' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Keywords: %1$s', 'k2k' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

}
endif;

/**
 * Post navigation (previous / next post) for single posts.
 */
function k2k_post_navigation() {
    the_post_navigation( array(
            'next_text'         => '<span class="meta-nav" aria-hidden="true">' . __( 'Next post:', 'k2k' ) . '</span>' .
                                        '<span class="screen-reader-text">' . __( 'Next post:', 'k2k' ) . '</span>' .
                                        '<span class="post-title">%title</span>',
            'prev_text'         => '<span class="meta-nav" aria-hidden="true">' . __( 'Previously:', 'k2k' ) . '</span>' .
                                        '<span class="screen-reader-text">' . __( 'Previously:', 'k2k' ) . '</span>' .
                                        '<span class="post-title">%title</span>',
            'in_same_term'      => true,
    ) );
}

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function k2k_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'k2k_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'k2k_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so k2k_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so k2k_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in k2k_categorized_blog.
 */
function k2k_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'k2k_categories' );
}
add_action( 'edit_category', 'k2k_category_transient_flusher' );
add_action( 'save_post',     'k2k_category_transient_flusher' );

/**
 * Breadcrumbs function
 */
function k2k_breadcrumbs() {
    
    /* translators: used between list items, there is a space after the comma */
    $categories_list = get_the_category_list( ' ' );
    if ( $categories_list && k2k_categorized_blog() ) {
            printf( '<span class="breadcrumbs cat-links row">' . esc_html__( '%1$s', 'k2k' ) . '</span>', $categories_list ); // WPCS: XSS OK.
    }
    
}

/**
 * Customize ellipsis at end of excerpts.
 */
function k2k_excerpt_more( $more ) {
    return " &hellip;";
}
add_filter( 'excerpt_more', 'k2k_excerpt_more' );

/**
 * Filter excerpt length to 100 words.
 */
function k2k_excerpt_length( $length ) {
    return 100;
}
add_filter( 'excerpt_length', 'k2k_excerpt_length' );

/**
 * Fancy excerpts
 * 
 * @link: http://wptheming.com/2015/01/excerpt-versus-content-for-archives/
 */
function k2k_fancy_excerpt() {
    global $post;
    if ( has_excerpt() ) :
        the_excerpt();
    elseif ( @strpos ( $post->post_content, '<!--more-->' ) ) :
        the_content();
    elseif ( str_word_count ( $post->post_content ) < 100 ) :
        the_content();
    else :
        the_excerpt();
    endif;
}

/**
 * Dynamic Copyright
 */
 function k2k_dynamic_copyright() {
    
    global $wpdb;
    
    $copyright_dates = $wpdb->get_results( "SELECT YEAR(min(post_date_gmt)) AS firstdate, YEAR(max(post_date_gmt)) AS lastdate FROM $wpdb->posts WHERE post_status = 'publish' " );
    $output = '';
    $blog_name = get_bloginfo();
    
    if ( $copyright_dates ) {
        $copyright = "&copy; " . $copyright_dates[0]->firstdate;
        if ( $copyright_dates[0]->firstdate != $copyright_dates[0]->lastdate ) {
            $copyright .= " &ndash; " . $copyright_dates[0]->lastdate;
        }
        $output = $copyright . " " . $blog_name;
    }
    echo $output;
    
}