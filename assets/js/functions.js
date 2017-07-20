/* 
 * File functions.js
 * 
 * Containing various JS functions for the theme.
 * 
 * 1. Centered images full bleed
 */
( function( $ ) {
    $( 'figure.wp-caption.aligncenter' ).removeAttr( 'style' );
    $( 'img.aligncenter' ).wrap( '<figure class="centered-image" />' );
    
    // Turn on site search
    $( '#site-search-button, .search-toggle' ).click( function() {
        if( $( '#secondary' ).hasClass( 'active' ) ) {
            $( '#secondary' ).removeClass( 'active' );
        }
        
        $( '.site-search-overlay' ).toggleClass( 'active' );
        $( '.site-search-overlay .search-field' ).focus();
        
        // Turn off site search when it's not in focus
        $( '.site-search-overlay .search-field' ).focusout( function() {
           $( '.site-search-overlay' ).removeClass( 'active' ); 
        });
    });
    
    //f( $( '.site-search-overlay .search-field' ) ).focus() 
    
    // Activate the sidebar
    $( '#site-sidebar-button' ).click( function() {
        if( $( '.site-search-overlay' ).hasClass( 'active' ) ) {
            $( '.site-search-overlay' ).removeClass( 'active' );
        }
        $( '#secondary' ).toggleClass( 'active' );
    });
}) ( jQuery );

