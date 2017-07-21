<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package K2K
 */

if ( ! is_active_sidebar( 'sidebar-1' ) &&  // Main Sidebar
     ! is_active_sidebar( 'sidebar-2' ) &&  // Archives / Index Sidebar
     ! is_active_sidebar( 'sidebar-3' ) ) { // Page Sidebar
	return;
}

// If it's an Archive AND the Archive Sidebar has widgets
if ( is_archive() && is_active_sidebar( 'sidebar-2' ) ) : 
?>

<aside id="secondary" class="widget-area" role="complementary">
	<?php dynamic_sidebar( 'sidebar-2' ); ?>
</aside>

<?php
// OR if it's a Page AND the Page Sidebar has widgets
elseif ( is_page() && is_active_sidebar( 'sidebar-3' ) ) : 
?>

<aside id="secondary" class="widget-area" role="complementary">
	<?php dynamic_sidebar( 'sidebar-3' ); ?>
</aside>

<?php
// Last case scenario: Display the Main Sidebar 
else :
?>

<aside id="secondary" class="widget-area" role="complementary">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>

<?php
endif;
