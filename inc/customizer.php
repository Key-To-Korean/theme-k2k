<?php
/**
 * K2K Theme Customizer
 *
 * @package K2K
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function k2k_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
        
        /*
         * Custom Customizer Customizations
         * #1: Settings, #2: Controls
         */
        
        /**
         * Dark Logo
         */
        $wp_customize->add_setting( 'dark_logo',
                array(
                    'priority'          => 10,
                    'sanitize_callback' => 'k2k_sanitize_upload',
                ));
        
        $wp_customize->add_control( 
                new WP_Customize_Image_Control( 
                        $wp_customize,
                        'dark_logo', array(
                            'section'           => 'title_tagline',
                            'label'             => __( '(Optional) Dark Logo', 'k2k' ),
                            'description'       => __( 'Add a darker version of your logo that will look good on a light background.', 'k2k' )
                        )
                ));
        
        /**
         * Extended Blog Description
         */
        $wp_customize->add_setting( 'blogdescription_xl',
                array(
                    'default'           => '',
                    'sanitize_callback' => 'k2k_sanitize_html',
                    'priority'          => 20
                ));
        
        $wp_customize->add_control( 'blogdescription_xl',
                array(
                    'type'              => 'text',
                    'section'           => 'title_tagline',
                    'label'             => __( 'Extended Blog Description', 'k2k' ),
                    'description'       => __( 'You can put a descriptive paragraph here, including HTML links.', 'k2k' )
                ));
        
        /* ///////////////// GRADIENT ////////////////// */
        /* 
         * Gradient Color #1 
         * (Interactive Color #1)
         */
        $wp_customize->add_setting( 'grad1_color', 
                array(
                    'default'           => 'rgba(81, 207, 102, 0.8)', // k2k green
                    'type'              => 'theme_mod',
                    'sanitize_callback' => 'k2k_sanitize_rgba_color',
                    'transport'         => 'postMessage'
                ));
        

        $wp_customize->add_control( 
                new WP_Customize_Color_Control(
                        $wp_customize,
                        'grad1_color', array(
                            'label'         => __( 'Interactive Color #1', 'k2k' ),
                            'description'   => __( 'Set the first interactive color. This color controls the LEFT gradient, links, and sidebar borders.', 'k2k' ),
                            'section'       => 'colors',
                        )
                ));
        
        /* 
         * Gradient Color #2 
         * (Interactive Color #2)
         */

        $wp_customize->add_setting( 'grad2_color', 
                array(
                    'default'           => 'rgba(50, 154, 240, 0.8)', // k2k blue
                    'type'              => 'theme_mod',
                    'sanitize_callback' => 'k2k_sanitize_rgba_color', 
                    'transport'         => 'postMessage'
                ));
        

        $wp_customize->add_control( 
                new WP_Customize_Color_Control(
                        $wp_customize,
                        'grad2_color', array(
                            'label'         => __( 'Interactive Color #2', 'k2k' ),
                            'description'   => __( 'Set the second interactive color. This color controls the RIGHT gradient, footer background, and search and sidebar buttons.', 'jinn' ),
                            'section'       => 'colors',
                        )
                ));
        
        /* ///////////////// SIDEBAR LAYOUT ////////////////// */
        
        /* 
         * Select Sidebar Layout 
         */
        // Add Sidebar Layout Section
        $wp_customize->add_section( 'k2k-options', 
                array(
                    'title'         => __( 'Theme Options', 'k2k' ),
                    'capability'    => 'edit_theme_options',
                    'description'   => __( 'Change the default display options for the theme.', 'k2k' ),
                ));
        
        // Sidebar Layout setting
        $wp_customize->add_setting( 'layout_setting',
                array(
                    'default'           => 'no-sidebar',
                    'type'              => 'theme_mod',
                    'sanitize_callback' => 'k2k_sanitize_layout',
                    'transport'         => 'postMessage'
                ));
        
        // Sidebar Layout Control
        $wp_customize->add_control( 'layout_control',
                array(
                    'settings'          => 'layout_setting',
                    'type'              => 'radio',
                    'label'             => __( 'Sidebar position', 'k2k' ),
                    'choices'           => array(
                            'no-sidebar'    => __( 'No sidebar (default)', 'k2k' ),
                            'sidebar-right' => __( 'Sidebar right', 'k2k' ),
                            'sidebar-left'  => __( 'Sidebar left', 'k2k' ),
                    ),
                    'section'           => 'k2k-options'
                ) );
        
        /**
	 * Front Page sections 
	 *
	 * @since Jinn 2.1.2
	 *
	 * @param $page_names array
	 */
	$page_names = array( 'services', 'clients', 'about', 'contact' );

	// Create a setting and control for each of the sections available in the theme.
	for ( $i = 0; $i < count( $page_names ); $i++ ) {
		$wp_customize->add_setting( 'panel_' . $page_names[$i], array(
			'default'           => false,
			'sanitize_callback' => 'absint',
//			'transport'         => 'postMessage',
		) );

		$wp_customize->add_control( 'panel_' . $page_names[$i], array(
			/* translators: %s is the front page section name */
			'label'          => sprintf( __( '%s Page Content', 'k2k' ), ucwords( $page_names[$i] ) ),
			'description'    => ( 0 !== $i ? '' : __( 'Select pages to feature in each area from the dropdowns. Add an image to a section by setting a featured image in the page editor. Empty sections will not be displayed.', 'k2k' ) ),
			'section'        => 'static_front_page',
			'type'           => 'dropdown-pages',
			'allow_addition' => true,
			'active_callback' => 'k2k_is_static_front_page',
		) );

//		$wp_customize->selective_refresh->add_partial( 'panel_' . $page_names[$i], array(
//			'selector'            => '#' . $page_names[$i],
//			'render_callback'     => 'k2k_front_page_section',
//			'container_inclusive' => true,
//		) );
	}
        
        /**
         * Show Post Word Count / Reading Time
         */
        $wp_customize->add_setting( 'k2k_display_reading_time', 
                array(
                    'default'           => 1,
                    'sanitize_callback' => 'k2k_sanitize_checkbox',
                ));

        $wp_customize->add_control( 'k2k_display_reading_time', 
                array(
                    'label'       => esc_html__( 'Display estimated reading time on posts', 'k2k' ),
                    'section'     => 'k2k-options',
                    'type'        => 'checkbox',
                ));
        
        /**
         * Show Theme Info
         */
        $wp_customize->add_setting( 'show_theme_info',
                array(
                    'default'           => 1,
                    'sanitize_callback' => 'k2k_sanitize_checkbox'
                ));
        
        $wp_customize->add_control( 'show_theme_info',
                array(
                    'label'             => __( 'Show theme info in Footer?', 'k2k' ),
                    'type'              => 'checkbox',
                    'section'           => 'k2k-options'
                ));
        
        /**
         * Show Copyright Date
         */
        $wp_customize->add_setting( 'show_copyright',
                array(
                    'default'           => 1,
                    'sanitize_callback' => 'k2k_sanitize_checkbox'
                ));
        
        $wp_customize->add_control( 'show_copyright',
                array(
                    'label'             => __( 'Show copyright dates in Footer?', 'k2k' ),
                    'type'              => 'checkbox',
                    'section'           => 'k2k-options'
                ));
}
add_action( 'customize_register', 'k2k_customize_register' );

/**
 * Sanitize HTML
 */
function k2k_sanitize_html( $input ) {
        return wp_kses_post( force_balance_tags( $input ), array( 'a' => array( 'href' => array() ) ) );
}

/**
 * Sanitize Upload
 */
function k2k_sanitize_upload( $input ) {
        return esc_url_raw( $input );
}

/**
 * Sanitize the checkbox.
 *
 * @param int $input.
 * @return boolean|string
 */
function k2k_sanitize_checkbox( $input ) {
	return ( 1 == $input ) ? 1 : '';
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function k2k_customize_preview_js() {
	wp_enqueue_script( 'k2k_customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'k2k_customize_preview_js' );



if ( ! function_exists( 'k2k_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see k2k_custom_header_setup().
 */
function k2k_header_style() {
	$header_text_color = get_header_textcolor();
        $inter_a = get_theme_mod( 'grad1_color' );
        $inter_b = get_theme_mod( 'grad2_color' );

	// If no custom options for text are set, let's bail
	// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value.
	if ( HEADER_TEXTCOLOR != $header_text_color ) {

            // If we get this far, we have custom styles. Let's do this.
            ?>
            <style type="text/css">
            <?php
                    // Has the text been hidden?
                    if ( 'blank' == $header_text_color ) :
            ?>
                    .site-title,
                    .site-description {
                            position: absolute;
                            clip: rect(1px, 1px, 1px, 1px);
                    }
            <?php
                    // If the user has set a custom color for the text use that.
                    else :
            ?>
                    .site-title a,
                    .site-description {
                            color: #<?php echo esc_attr( $header_text_color ); ?>;
                    }
            <?php endif; ?>
            </style>
            <?php
            
        }
        
        // Check if the gradient/interactive color is changed,
        // if so, create a new <style> element for the new color(s)
        if ( '#66F485' != $inter_a || '#17ACFE' != $inter_b ) { ?>
            <style type="text/css">
                .gradient-overlay {
                    /* Vivid colors */
                    background: <?php echo esc_attr( $inter_a ); ?>; /* Old browsers */
                    background: -moz-linear-gradient(left, <?php echo esc_attr( $inter_a ); ?> 0%, <?php echo esc_attr( $inter_b ); ?> 100%); /* FF3.6-15 */
                    background: -webkit-linear-gradient(left, <?php echo esc_attr( $inter_a ); ?> 0%, <?php echo esc_attr( $inter_b ); ?> 100%); /* Chrome10-25,Safari5.1-6 */
                    background: linear-gradient(to right, <?php echo esc_attr( $inter_a ); ?> 0%, <?php echo esc_attr( $inter_b ); ?> 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
                    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo esc_attr( $inter_a ); ?>', endColorstr='<?php echo esc_attr( $inter_b ); ?>',GradientType=1 ); /* IE6-9 */
                }
            </style>
        <?php 
        }
}
endif; // k2k_header_style
