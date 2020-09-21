<?php
/**
 * The template part for displaying paginate content
 *
 */
$args     = [
	'prev_text' => __( '« Prev' ),
	'next_text' => __( 'Next »' ),
];
$paginate = paginate_links( $args );
if ( ! empty( $paginate ) ): ?>
	<div class="paginate">
		<?php if ( ! get_previous_posts_link() ): ?>
			<span class="prev is-disabled">
				<?php _e( '« Prev' ); ?>
			</span>
		<?php endif;

		echo $paginate;

		if ( ! get_next_posts_link() ): ?>
			<span class="next is-disabled">
				<?php _e( 'Next »' ); ?>
			</span>
		<?php endif; ?>
	</div>
<?php endif; ?>
