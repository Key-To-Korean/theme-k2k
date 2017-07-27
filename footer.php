<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package K2K
 */

?>

	</div>
        
        <footer id="colophon" role="contentinfo" class="site-footer <?php 
                if ( get_header_image() ) : ?>
                    footer-image" style="background: url('<?php header_image(); ?>') no-repeat center center fixed
                <?php endif; ?>">
                
                <div class="gradient-overlay"></div>
        
                <div class="footer-widgets-area">
                    <?php get_sidebar( 'footer' ); ?>
                </div>
                
                <div class="site-info-area">
                    <?php get_template_part( 'components/footer/site', 'info' ); ?>
                </div>
                
                <a href="#" class="topbutton">
                    <span class="screen-reader-text"><?php _e( 'Back to Top', 'k2k' ); ?></span>
                    <?php echo k2k_get_svg( array( 'icon' => 'material-arrow-upward' ) ); ?>
                </a>
                    
        </footer>
        
</div>
<?php wp_footer(); ?>

</body>
</html>
