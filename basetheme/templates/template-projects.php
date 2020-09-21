<?php
/*
 * Template name: Project Page
 */
get_header();

$paged         = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$post_per_page = 1;
if ( ! empty( @$_REQUEST['cat'] ) && ! empty( @$_REQUEST['rating'] ) ) {
	$args = [
		'post_type'      => 'project',
		'posts_per_page' => $post_per_page,
		'paged'          => $paged,
		'meta_query'     => [
			[
				'key'     => 'project_rating',
				'value'   => @$_REQUEST['rating'],
				'compare' => '=',
			]
		],
		'tax_query'      => [
			[
				'taxonomy' => 'project_cat',
				'field'    => 'slug',
				'terms'    => @$_REQUEST['cat'],
			]
		]
	];
} elseif ( ! empty( @$_REQUEST['cat'] ) ) {
	$args = [
		'post_type'      => 'project',
		'posts_per_page' => $post_per_page,
		'paged'          => $paged,
		'tax_query'      => [
			[
				'taxonomy' => 'project_cat',
				'field'    => 'slug',
				'terms'    => @$_REQUEST['cat'],
			]
		]
	];
} elseif ( ! empty( @$_REQUEST['rating'] ) ) {
	$args = [
		'post_type'      => 'project',
		'posts_per_page' => $post_per_page,
		'paged'          => $paged,
		'meta_query'     => [
			[
				'key'     => 'project_rating',
				'value'   => @$_REQUEST['rating'],
				'compare' => '=',
			]
		],

	];
} else {
	$args = [
		'post_type'      => 'project',
		'posts_per_page' => $post_per_page,
		'paged'          => $paged,
	];
}

$projects = new WP_Query( $args );
?>
	<main>
		<div class="container filters">
			<form action="<?php echo get_permalink(); ?>">
				<?php
				$terms = get_terms( [ 'taxonomy' => 'project_cat', 'hide_empty' => false ] );
				if ( $terms ):?>
					<select name="cat" onchange="this.form.submit();">
						<option value="">Select Categories</option>
						<?php foreach ( $terms as $term ): ?>
							<option value="<?php echo $term->slug; ?>" <?php echo ( @$_REQUEST['cat'] == $term->slug ) ? "selected" : null; ?>><?php echo $term->name; ?></option>
						<?php endforeach; ?>
					</select>
				<?php endif; ?>

				<select name="rating" onchange="this.form.submit();">
					<option value="">Select Rating</option>
					<option value="1" <?php echo ( @$_REQUEST['rating'] == 1 ) ? 'selected' : ''; ?>>1</option>
					<option value="2" <?php echo ( @$_REQUEST['rating'] == 2 ) ? 'selected' : ''; ?>>2</option>
					<option value="3" <?php echo ( @$_REQUEST['rating'] == 3 ) ? 'selected' : ''; ?>>3</option>
					<option value="4" <?php echo ( @$_REQUEST['rating'] == 4 ) ? 'selected' : ''; ?>>4</option>
					<option value="5" <?php echo ( @$_REQUEST['rating'] == 5 ) ? 'selected' : ''; ?>>5</option>
				</select>
			</form>
		</div>

		<div class="container">
			<?php if ( $projects->have_posts() ): ?>
				<div class="project__list">
					<ul>
						<?php while ( $projects->have_posts() ): $projects->the_post(); ?>
							<li class="col-md-4">
								<?php get_template_part( 'template-parts/loop', 'project' ); ?>
							</li>
						<?php endwhile; ?>
					</ul>
				</div>
				<?php wp_reset_postdata();
			endif; ?>
		</div>
		<?php
		$paginate = paginate_links( [
			'format'    => '?paged=%#%',
			'current'   => max( 1, get_query_var( 'paged' ) ),
			'total'     => $projects->max_num_pages,
			'prev_text' => '<',
			'next_text' => '>',
		] );
		if ( $paginate ):?>
			<div class="container paginate">
				<?php echo $paginate; ?>
			</div>
		<?php endif; ?>
	</main>
<?php get_footer();
