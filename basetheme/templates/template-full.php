<?php
/**
 * Template Name: Full Width Page
 */
get_header(); ?>

	<main role="main">
		<?php
		if ( have_posts() ) {
			// Start the loop.
			while ( have_posts() ) {
				the_post();
				get_template_part( 'template-parts/content', get_post_format() );
			}
		} else {

			get_template_part( 'template-parts/content', 'none' );
		} ?>
	</main>

<?php get_footer();
