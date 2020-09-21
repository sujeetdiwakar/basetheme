<?php
/**
 * The template for displaying the footer
 */
?>
	<footer class="footer bg-primary">
		<p class="text-center"><?php echo __( '©' ) . date( ' Y ' ) . __( 'All Rights Reserved.' ); ?>
			<a style="color: #fff;" href="<?php echo get_option( 'home' ); ?>/"><?php bloginfo( 'name' ); ?>.</a>
		</p>
	</footer>
</div>

<?php wp_footer(); ?>
</body>
</html>
