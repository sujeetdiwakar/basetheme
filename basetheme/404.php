<?php
/**
 * The template for displaying 404 pages
 */

get_header();

if ( ( $post = get_404() ) && ! empty( $post ) ) : ?>
	<?php setup_postdata( $post ); ?>

	<main>
		<div class="container">
			<?php the_content(); ?>
		</div>
	</main>

	<?php wp_reset_postdata(); ?>
<?php else : ?>
	<main>
		<div class="container">
			<div class="content">
				<h1><?php _e( 'Page not found' ); ?></h1>
			</div>
		</div>
	</main>
<?php endif;
get_footer(); ?>
