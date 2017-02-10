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

	add_image_size( 'k2k-featured-image', 640, 9999 );
	add_image_size( 'k2k-hero', 1280, 1000, true );
	add_image_size( 'k2k-thumbnail-avatar', 100, 100, true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Top', 'k2k' ),
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
}
add_action( 'widgets_init', 'k2k_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function k2k_scripts() {
        // Enqueue Google Fonts: Noto Sans and Noto Serif
        wp_enqueue_style( 'k2k-fonts', k2k_fonts_url(), array(), null );
        
        // Enqueue Early Access Font Noto Sans Korean
        wp_enqueue_style( 'k2k-ea-font', 'http://fonts.googleapis.com/earlyaccess/notosanskr.css' );
        
        // Enqueue Noto Sans Mono
        
	wp_enqueue_style( 'k2k-style', get_stylesheet_uri() );

	wp_enqueue_script( 'k2k-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array( 'jquery' ), '20170210', true );
        wp_localize_script( 'k2k-navigation', 'k2kScreenReaderText', array(
            'expand'    => __( 'Expand child menu', 'k2k' ),
            'collapse'  => __( 'Collapse child menu', 'k2k' )
        ));

	wp_enqueue_script( 'k2k-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'k2k_scripts' );

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