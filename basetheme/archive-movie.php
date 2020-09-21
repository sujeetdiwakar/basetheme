<?php
/*
 *
 */
$content = apply_filters( 'the_content', get_post_field( 'post_content', get_archive()->ID ) );
global $wp_query;
$max = $wp_query->max_num_pages;
get_header(); ?>

	<main role="main">
		<div class="container"><br>
			<h1 class="text-center"><?php echo post_type_archive_title( '', false ); ?></h1>

			<?php get_template_part('template-parts/content','filters'); ?>
			<br>

			<?php if ( $content ): ?>
				<div class="jumbotron">
					<?php echo $content; ?>
				</div>
			<?php endif;

			if ( have_posts() ): ?>
				<div class="row js-movie-posts">
					<?php while ( have_posts() ):
						the_post(); ?>
						<div class="col-md-4"><?php get_template_part( 'template-parts/loop', 'movie' ); ?></div>
					<?php endwhile; ?>
				</div>
			<?php else:
				get_template_part( 'template-parts/content', 'none' );
			endif;

			if ( $max > 1 ):?>
				<div class="text-center">
					<a data-type="<?php echo @$_REQUEST['type']; ?>" data-lang="<?php echo @$_REQUEST['lang']; ?>" data-rating="<?php echo @$_REQUEST['rating']; ?>" href="#" class="btn btn-primary js-movie-more">More posts </a>
				</div>
			<?php endif; ?>
			<br>
		</div>
	</main>

<?php get_footer();
