<?php
/**
 * The template used for displaying hero content
 *
 * @package K2K
 */
?>

<?php if ( has_post_thumbnail() ) : ?>
	<div class="k2k-hero">
		<?php the_post_thumbnail( 'k2k-hero' ); ?>
	</div>
<?php endif; ?>
