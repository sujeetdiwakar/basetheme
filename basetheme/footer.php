<?php
/**
 * The template for displaying the footer
 */
?>
	<footer class="footer bg-primary">
		<?php if ( is_active_sidebar( 'footer_widgets' ) ): ?>
			<div class="footer__widgets container">
				<?php dynamic_sidebar( 'footer_widgets' ); ?>
			</div>
		<?php endif; ?>
		<p class="text-center"><?php echo __( '©' ) . date( ' Y ' ) . __( 'All Rights Reserved.' ); ?>
			<a style="color: #fff;" href="<?php echo get_option( 'home' ); ?>/"><?php bloginfo( 'name' ); ?>.</a>
		</p>
	</footer>
</div>

<?php wp_footer(); ?>
</body>
</html>
