<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package K2K
 */

if ( ! is_active_sidebar( 'footer-1' ) ) { 
	return;
}
?>

<aside id="footer-widget-sidebar" class="widget-area footer-widgets container" role="complementary">
	<?php dynamic_sidebar( 'footer-1' ); ?>
</aside>
