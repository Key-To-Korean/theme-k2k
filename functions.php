<?php
/**
 * components functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package K2K
 */

if ( ! function_exists( 'k2k_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the aftercomponentsetup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function k2k_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on components, use a find and replace
	 * to change 'k2k' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'k2k', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	add_image_size( 'k2k-featured-image', 840, 400, true );
	add_image_size( 'k2k-thumbnail', 200, 140, true );
	//add_image_size( 'k2k-thumbnail-avatar', 100, 100, true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1'    => esc_html__( 'Top', 'k2k' ),
                'menu-2'    => esc_html__( 'Home', 'k2k' ),
                'menu-3'    => esc_html__( 'Footer', 'k2k' ),
                'social'    => esc_html__( 'Social Menu', 'k2k' )
	) );

	/**
	 * Add support for core custom logo.
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 200,
		'width'       => 200,
		'flex-width'  => true,
		'flex-height' => true,
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'k2k_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'k2k_setup' );


/**
 * Register custom fonts.
 */
function k2k_fonts_url() {
	$fonts_url = '';

	/**
	 * Translators: If there are characters in your language that are not
	 * supported by Noto Sans and Noto Serif, translate this to 'off'. 
         * Do not translate into your own language.
	 */
	$noto_sans = _x( 'on', 'Noto Sans font: on or off', 'k2k' );
        $noto_serif = _x( 'on', 'Noto Serif font: on or off', 'k2k' );
        
        $font_families = array();

	if ( 'off' !== $noto_sans ) {
                $font_families[] = 'Noto+Sans:400,400i,700,700i';
        }
        if ( 'off' !== $noto_serif ) {
                $font_families[] = 'Noto+Serif:400,700';
        }
        
        if ( in_array( 'on', array( $noto_sans, $noto_serif ) ) ) {
		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}


/**
 * Add preconnect for Google Fonts.
 *
 * @since K2K    1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function k2k_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'k2k-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'k2k_resource_hints', 10, 2 );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 * This content width is for embedded (external) content like YouTube videos, etc.
 * It doesn't apply to internal content like images, Featured Images, etc.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function k2k_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'k2k_content_width', 640 );
}
add_action( 'after_setup_theme', 'k2k_content_width', 0 );

/**
 * Return early if Custom Logos are not available.
 *
 * @todo Remove after WP 4.7
 */
function k2k_the_custom_logo() {
	if ( ! function_exists( 'the_custom_logo' ) ) {
		return;
	} else {
		the_custom_logo();
	}
}


/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images.
 *
 * @origin Twenty Seventeen 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 * 
 * @TODO  Find responsive breakpoints and adjust these values
 */
function k2k_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];
	if ( 900 <= $width ) {
		$sizes = '(min-width: 900px) 700px, 900px';
	}
	if ( is_active_sidebar( 'sidebar-1' ) || is_active_sidebar( 'sidebar-2' ) ) {
		$sizes = '(min-width: 900px) 600px, 900px';
	}
	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'k2k_content_image_sizes_attr', 10, 2 );

/**
 * Filter the `sizes` value in the header image markup.
 *
 * @origin Twenty Seventeen 1.0
 *
 * @param string $html   The HTML image tag markup being filtered.
 * @param object $header The custom header object returned by 'get_custom_header()'.
 * @param array  $attr   Array of the attributes for the image tag.
 * @return string The filtered header image HTML.
 * 
 * @TODO  Find responsive breakpoints and adjust these values
 */
function k2k_header_image_tag( $html, $header, $attr ) {
	if ( isset( $attr['sizes'] ) ) {
		$html = str_replace( $attr['sizes'], '100vw', $html );
	}
	return $html;
}
add_filter( 'get_header_image_tag', 'k2k_header_image_tag', 10, 3 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails.
 *
 * @origin Twenty Seventeen 1.0
 *
 * @param array $attr       Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size       Registered image size or flat array of height and width dimensions.
 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
 * 
 * @TODO  Find responsive breakpoints and adjust these values
 */
function k2k_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( !is_singular() ) {
		if ( is_active_sidebar( 'sidebar-1' ) ) {
			$attr['sizes'] = '(max-width: 900px) 90vw, 800px';
		} else {
			$attr['sizes'] = '(max-width: 1000px) 90vw, 1000px';
		}
	} else {
		$attr['sizes'] = '100vw';
	}
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'k2k_post_thumbnail_sizes_attr', 10, 3 );


/**
 * Add 'odd' and 'even' post classes
 * 
 * @source http://www.goldenapplewebdesign.com/alternating-post-classes-with-odd-even-styling/
 */
function k2k_odd_even_post_classes( $classes ) {
    global $current_class;
    if( is_archive() || is_search() || is_home() ) : 
        $classes[] = $current_class;
        $current_class = ( $current_class == 'odd' ) ? 'even' : 'odd';
    endif;
    return $classes;
}
add_filter( 'post_class', 'k2k_odd_even_post_classes' );
global $current_class;
$current_class = 'odd';


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function k2k_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Main Sidebar', 'k2k' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'The main site sidebar. Appears on Posts and most other content. If no other specialized sidebars are set, this will be used throughout the site on all Archives and Pages too.', 'k2k' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
        register_sidebar( array(
		'name'          => esc_html__( 'Archives Sidebar', 'k2k' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Sidebar specifically for archive pages.', 'k2k' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
        register_sidebar( array(
		'name'          => esc_html__( 'Page Sidebar', 'k2k' ),
		'id'            => 'sidebar-3',
		'description'   => esc_html__( 'Sidebar specifically for Pages.', 'k2k' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
        register_sidebar( array(
		'name'          => esc_html__( 'Footer Widgets', 'k2k' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Widget area for the footer. Applies to all pages.', 'k2k' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'k2k_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function k2k_scripts() {
        // Enqueue Google Fonts: Noto Sans and Noto Serif
        wp_enqueue_style( 'k2k-fonts', k2k_fonts_url(), array(), null );
        
        // Enqueue Early Access Font Noto Sans Korean
        // wp_enqueue_style( 'k2k-ea-font', 'http://fonts.googleapis.com/earlyaccess/notosanskr.css' );
        wp_enqueue_style( 'k2k-fa', get_template_directory_uri() . '/assets/fonts/font-awesome.min.css' );
        wp_enqueue_style( 'k2k-spoqa', get_template_directory_uri() . '/assets/fonts/k2k-fonts.css' );
        wp_enqueue_style( 'k2k-satisfy', 'https://fonts.googleapis.com/css?family=Satisfy|News+Cycle:700|Oswald:200,300,400,500,600,700|Yanone+Kaffeesatz:700' );
        
        // Enqueue Noto Sans Mono
        
	wp_enqueue_style( 'k2k-style', get_stylesheet_uri() );

	wp_enqueue_script( 'k2k-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array( 'jquery' ), '20170210', true );
        wp_localize_script( 'k2k-navigation', 'k2kScreenReaderText', array(
            'expand'    => __( 'Expand child menu', 'k2k' ),
            'collapse'  => __( 'Collapse child menu', 'k2k' )
        ));
        
        wp_enqueue_script( 'k2k-functions', get_template_directory_uri() . '/assets/js/functions.js', array( 'jquery' ), '20170718', true );

	wp_enqueue_script( 'k2k-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'k2k_scripts' );

/**
 * Returns true if the word count can be displayed in posts.
 *
 * @return bool
 */
function k2k_show_word_count() {
	$content = get_post_field( 'post_content', get_the_ID() );
	return in_array( get_post_type(), array( 'post' ) ) && ! empty( $content ) && (bool) 1 === (bool) get_theme_mod( 'k2k_display_reading_time', 1 );
}

if ( ! function_exists( 'k2k_word_count' ) ) :
/**
 * Gets the number of words in the post content.
 *
 * @link http://php.net/str_word_count
 * @link http://php.net/number_format
 */
function k2k_word_count() {
	$content = get_post_field( 'post_content', get_the_ID() );
	$count   = str_word_count( strip_tags( $content ) );
	$time    = $count / 250; // Roughly 250 wpm reading time
	return number_format( $time );
}
endif; // k2k_word_count

/*
 * Add Excerpts to Pages
 */
function k2k_add_excerpt_to_pages() {
    add_post_type_support( 'page', 'excerpt' );
}
add_action( 'init', 'k2k_add_excerpt_to_pages' );

/**
 * Custom header for this theme.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load SVG icon functions.
 */
require get_template_directory() . '/inc/icon-functions.php';

/**
 * Load Better Recent Posts Widget (replacing original Recent Posts Widget)
 */
require get_template_directory() . '/components/features/widgets/recent-posts.php';

/**
 * Load Better Recent Comments Widget (replacing original Recent Comments Widget)
 */
require get_template_directory() . '/components/features/widgets/recent-comments.php';

/**
 * Load Better Archives Widget (replacing original Archives Widget)
 */
require get_template_directory() . '/components/features/widgets/archives.php';

// Adds Links Section and Links Widget back into WordPress
add_filter( 'pre_option_link_manager_enabled', '__return_true' );