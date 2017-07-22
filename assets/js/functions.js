/* 
 * File functions.js
 * 
 * Containing various JS functions for the theme.
 * 
 * 1. Centered images full bleed
 */
( function( $ ) {
    
    /*
     * Center Aligned Images - full bleed on smaller screens
     */
    $( 'figure.wp-caption.aligncenter' ).removeAttr( 'style' );
    $( 'img.aligncenter' ).wrap( '<figure class="centered-image" />' );
    
    /*
     * Turn on site search
     */ 
    $( '#site-search-button, .search-toggle' ).click( function() {
        if( $( '#secondary' ).hasClass( 'active' ) ) {
            $( '#secondary' ).removeClass( 'active' );
        }
        
        // @TODO: Needs some work to turn OFF search when button is clicked again
        if( $( '.site-search-overlay' ).hasClass( 'active' ) ) {
            $( '.site-search-overlay' ).removeClass( 'active' );
        } else {
            $( '.site-search-overlay' ).addClass( 'active' );
            $( '.site-search-overlay .search-field' ).focus();
        }
 
    });
    // Turn off site search when it's not in focus
    $( '.site-search-overlay .search-field' ).focusout( function() {
       $( '.site-search-overlay' ).removeClass( 'active' ); 
    });
    
    /*
     * Activate the sidebar
     */ 
    $( '#site-sidebar-button' ).click( function() {
        if( $( '.site-search-overlay' ).hasClass( 'active' ) ) {
            $( '.site-search-overlay' ).removeClass( 'active' );
        }
        $( '#secondary' ).toggleClass( 'active' );
    });
    // Put back Sidebar when it's not hovered over
    $( '#secondary' ).mouseout( function() {
        if( $( '#secondary' ).hasClass( 'active' ) ) {
            $( '#secondary' ).removeClass( 'active' );
        }
    });
    
    /*
     * Create skewed avatars in Comments section
     */
    $( '.comments-body .vcard' ).addClass( 'skewed-thumbnail' );
    
    /*
     * Show / Hide Comments
     */ 
    $( '.view-comments' ).click( function() {
       $( '.view-the-comments' ).toggleClass( 'active' ); 
    });
    
}) ( jQuery );

