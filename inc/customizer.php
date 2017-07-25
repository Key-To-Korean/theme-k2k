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
        
        /**
         * Dark Logo
         */
        $wp_customize->add_setting( 'dark_logo',
                array(
                    'priority'          => 10,
                    'sanitize_callback' => 'k2k_sanitize_upload',
                ));
        
        $wp_customize->add_control( new WP_Customize_Image_Control( 
                $wp_customize,
                'dark_logo',
                array(
                    'section'           => 'title_tagline',
                    'label'             => __( '(Optional) Dark Logo', 'k2k' ),
                    'description'       => __( 'Add a darker version of your logo that will look good on a light background.', 'k2k' )
                )));
        
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
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function k2k_customize_preview_js() {
	wp_enqueue_script( 'k2k_customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'k2k_customize_preview_js' );
