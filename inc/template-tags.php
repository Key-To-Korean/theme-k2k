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

        if ( is_singular() ) {
            echo '<span class="byline">' . k2k_get_svg( array( 'icon' => 'material-account-circle' ) ) . ' ' . $byline . '</span>';
        }
        echo '<span class="posted-on">' . k2k_get_svg( array( 'icon' => 'material-schedule' ) ) . ' ' . $posted_on . '</span>'; // WPCS: XSS OK.

        if ( k2k_show_word_count() && is_singular() ) {
                printf( '<span class="word-count">%s %s</span>', 
                        k2k_get_svg( array( 'icon' => 'material-subject' ) ), 
                        sprintf( _nx( '%s min read', '%s min read', k2k_word_count(), 'time to read', 'k2k' ), k2k_word_count() ) 
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
            
//                k2k_breadcrumbs();

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( '', 'k2k' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">%1$s</span>', $tags_list ); // WPCS: XSS OK.
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
 * Post navigation (previous / next post) for the side buttons.
 */
function k2k_post_side_navigation() {
    the_post_navigation( array(
            'next_text'         => '<span class="screen-reader-text">' . __( 'Next post: ', 'k2k' ) . '%title</span>' . k2k_get_svg( array( 'icon' => 'material-arrow-forward' ) ),
            'prev_text'         => k2k_get_svg( array( 'icon' => 'material-arrow-backward' ) ) . '<span class="screen-reader-text">' . __( 'Previously: ', 'k2k' ) . '%title</span>',
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
            printf( '<span class="cat-links row">' . esc_html__( '%1$s', 'k2k' ) . '</span>', $categories_list ); // WPCS: XSS OK.
    }
    
//    global $post;
//    
//    if ( !is_home() ) {
//        echo '<span id="breadcrumbs" class="breadcrumbs">';
//        echo '<a href="';
//        echo get_option( 'home' );
//        echo '">';
//        echo 'Home';
//        echo '</a>';
//        
//        if ( is_category() || is_single() ) {
////            echo '<li>';
//            the_category('');
//            if ( is_single() ) {
////                echo '</li><li>';
//                the_title();
////                echo '</li>';
//            }
//        } 
        else if ( is_page() ) {
            if( $post->post_parent ) {
                $ancestors = get_post_ancestors( $post->ID );
                $title = get_the_title();
                
                foreach ( $ancestors as $ancestor ) {
                    $output = '<a href="' . get_permalink( $ancestor ) . '" title="' . get_the_title( $ancestor ) . '">' . get_the_title( $ancestor ) . '</a>';    
                }
                
                echo $output;
                echo '<strong title="' . $title . '"> ' . $title . '</strong>';
            } else {
                echo '<strong> ' . get_the_title() . '</strong>';
            }
        } 
//        else if ( is_tag() ) { single_tag_title(); }
//        else if ( is_day() ) { echo "Archive for "; the_time( 'F jS, Y' ); }
//        else if ( is_month() ) { echo "Archive for "; the_time( 'F, Y' ); }
//        else if ( is_year() ) { echo "Archive for "; the_time( 'Y' ); }
//        else if ( is_author() ) { echo "Author Archive"; }
//        else if ( isset( $_GET[ 'paged' ] ) && !empty( $_GET[ 'paged' ] ) ) { echo "Blog Archives"; }
//        else if ( is_search() ) { echo "Search Results"; }
        
//        echo '</span>';
//    }
    
//    // Categories
//        if ( 'post' === get_post_type() || 'jetpack-portfolio' === get_post_type() ) {
//		/* translators: used between list items, there is a space after the comma */
//                if( 'post' === get_post_type() ) {
//                    $categories_list = get_the_category_list( __( '</li><li>', 'jinn' ) );
//                } elseif ( 'jetpack-portfolio' === get_post_type() ) {
//                    $categories_list = get_the_term_list( $post->ID, 'jetpack-portfolio-type', '', '</li><li>', '' );
//                }
//                $first = strpos( $categories_list, '</a>' );
//                $first_cat = substr( $categories_list, 0, ( $first + 4 ) );
//                $replaced = str_replace( '<a ', '<a class="first-cat-link" ', $first_cat );
//                $the_rest = substr( $categories_list, ( $first + 4 ) );
//
//		if ( $categories_list && k2k_categorized_blog() ) {
//                        echo '<span class="cat-links">';
//                        if( 'post' === get_post_type() ) {
//                            esc_html_e( 'Filed under: ', 'jinn' );
//                        } elseif( 'jetpack-portfolio' === get_post_type() ) {
//                            esc_html_e( 'Project type: ', 'jinn' );
//                        }
//                        echo wp_kses( $replaced, array( 
//                                            'a' => array( 
//                                                'href' => array(),
//                                                'class' => array(),
//                                                'rel' => array()
//                                            ) ) );
//                        if( ! empty( $the_rest ) ) {
//                            echo '<span class="jinn_cat_switch"><i class="fa fa-angle-down"></i></span>';
//                            printf( '<ul class="submenu dropdown">' . wp_kses( $the_rest, array( 
//                                            'li' => array( 'class' => array() ),
//                                            'a' => array(
//                                                'href' => array(),
//                                                'class' => array(),
//                                                'rel' => array()
//                                            ) ) ) . '</ul>', 
//                                    wp_kses( $the_rest, array( 
//                                            'li' => array( 'class' => array() ),
//                                            'a' => array(
//                                                'href' => array(),
//                                                'class' => array(),
//                                                'rel' => array()
//                                            ) ) ) ); // WPCS: XSS OK.     
//                        }
//                        echo '</span>';
//		}
//	}          
    
}

/**
 * Customize ellipsis at end of excerpts.
 */
function k2k_excerpt_more( $more ) {
    $more_str = " <a href='" . get_permalink() . "'><span class='screen-reader-text'>Continue reading " . get_the_title() . "</span>&hellip;</a>";
    return $more_str;
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
 * Add an author box below posts
 * @link http://www.wpbeginner.com/wp-tutorials/how-to-add-an-author-info-box-in-wordpress-posts/
 */
function k2k_author_box() {
    global $post;
    
    // Detect if a post author is set
    if ( isset( $post->post_author ) ) {
        
        /*
         * Get Author info
         */
        $display_name = get_the_author_meta( 'display_name', $post->post_author );                  // Get the author's display name  
            if ( empty ( $display_name ) ) $display_name = get_the_author_meta( 'nickname', $post->post_author ); // If display name is not available, use nickname
        $user_desc =    get_the_author_meta( 'user_description', $post->post_author );              // Get bio info
        $user_site =    get_the_author_meta( 'url', $post->post_author );                           // Website URL
        $user_posts =   get_author_posts_url( get_the_author_meta( 'ID', $post->post_author ) );    // Link to author archive page
        if( get_header_image() ) $header_image = 'style="background-image: url(\'' . get_header_image() . '\');"';
        //echo $header_image;
        /*
         * Create the Author box
         */
        ?>
        <aside class="author_bio_section_bg" style="background-image: url('<?php header_image(); ?>');">
        <?php
        // $author_details  = '<aside class="author_bio_section_bg" ' . $header_image . '>';
              $author_details .= '<div class="author_bio_section">';  
        $author_details .= '<div class="author_bio_container">';
        $author_details .= '<p class="entry-meta label">' . esc_html__( 'About the author', 'k2k' ) . ' <span class="show-hide-author"><i class="fa fa-minus-circle"></i></span></p>';
        
//        $author_details .= '<h3 class="author-title"><span>' . esc_html__( 'About ', 'k2k' );
//            if ( is_author() ) $author_details .= $display_name;        // If an author archive, just show the author name
//            else $author_details .= esc_html__( 'the Author', 'k2k' ); // If a regular page, show "About the Author"
//        $author_details .= '</span></h3>';
        
        $author_details .= '<div class="author-box">';
                $author_details .= '<section class="author-avatar">' . get_avatar( get_the_author_meta( 'user_email' ), 240 );
                $author_details .= '</section>';

        $author_details .= '<section class="author-info">';
        
        if ( ! empty( $display_name ) && ! is_author() ) {          // Don't show this name on an author archive page
            $author_details .= '<h3 class="author-name">';
            $author_details .= '<a class="fn" href="' . esc_url( $user_posts ) . '">' . $display_name . '</a>';
            $author_details .= '</h3>';
        }
        if ( ! is_author() ) {  // Don't show the meta info on an author archive page
                $author_details .= '<p class="author-links entry-meta"><span class="vcard"><a class="fn" href="' . esc_url( $user_posts ) . '">' . esc_html__( 'More posts', 'k2k' ) . '</a></span>';

                // Check if author has a website in their profile
                if ( ! empty( $user_site ) ) 
                    $author_details .= '<a class="author-site" href="' . esc_url( $user_site ) . '" target="_blank" rel="nofollow">' . esc_html__( 'Website', 'k2k' ) . '</a></p>';
                else $author_details .= '</p>';
                }
        if ( ! empty( $user_desc ) ) 
            $author_details .= '<p class="author-description">' . $user_desc . '</p>';
        
        $author_details .= '</section>';
        $author_details .= '</div>';
        $author_details .= '</div><!-- .author_bio_container -->';
            $author_details .= '</div><!-- .author_bio_container_bg -->';
        $author_details .= '</aside>';
        
        echo wp_kses_post( $author_details );

    }
    
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