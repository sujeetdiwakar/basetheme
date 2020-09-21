<?php
global $wp_query;
$max = $wp_query->max_num_pages;
get_header(); ?>

	<main role="main">
		<div class="container">
			<br>
			<h1 class="text-center"><?php echo get_the_title( get_option( 'page_for_posts' ) ); ?></h1>
			<?php if ( have_posts() ): ?>
				<div class="row js-posts">
					<?php while ( have_posts() ):
						the_post(); ?>
						<div class="col-md-4"><?php get_template_part( 'template-parts/loop', 'post' ); ?></div>
					<?php endwhile; ?>
				</div>
			<?php else:

				get_template_part( 'template-parts/content', 'none' );
			endif;

			if ( $max > 1 ):?>
				<div class="text-center">
					<a href="#" class="btn btn-primary js-load-more">More posts</a>
				</div>
			<?php endif; ?>
			<br>
		</div>
	</main>

<?php get_footer();
