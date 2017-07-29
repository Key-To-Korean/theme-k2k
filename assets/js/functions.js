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
    
    
    /**
     * Test if inline SVGs are supported.
     * @link https://github.com/Mocernizr/Modernizr/
     */
    function supportsInlineSVG() {
        var div = document.createElement( 'div' );
        div.innerHTML = '<svg/>';
        return 'http://www.w3.org/2000/svg' === ( 'undefined' !== typeof SVGRect && div.firstChild && div.firstChild.namespaceURI );
    }
    if ( true === supportsInlineSVG() ) {
        document.documentElement.className = document.documentElement.className.replace( /(\s*)no-svg(\s*)/, '$1svg$2' );
    }
    
    
    /**
     * Back to Top button
     */
    var offset = 100;
    var speed = 250;
    var duration = 500;
    $( window ).scroll( function() {
        if ( $( this ).scrollTop() < offset ) {
            $( '.topbutton' ) .fadeOut( duration );
        } else {
            $( '.topbutton' ) .fadeIn( duration );
        }
    });
    $( '.topbutton' ).on( 'click', function() {
         $( 'html, body' ).animate( { scrollTop:0 }, speed );
         return false;
    });
    
    /**
     * Better Categories Widgets
     */
    $( '.widget_categories ul.children' ).parent().addClass( 'category-item-has-children' );
    
}) ( jQuery );

