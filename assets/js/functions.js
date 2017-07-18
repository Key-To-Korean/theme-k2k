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
}) ( jQuery );

