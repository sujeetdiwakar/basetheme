<?php
/**
 * The template for displaying search results pages
 *
 * @package    WordPress
 * @subpackage Custom_Theme
 * @since      1.0
 * @version    1.0
 */

get_header(); ?>

<main id="main">
	<?php if ( have_posts() ) : ?>
		<h1><?php _e( 'Search results: ' ); ?>&ldquo;<?php echo get_search_query(); ?>&rdquo;</h1>

		<?php while ( have_posts() ) : the_post(); ?>
			<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
			<?php the_excerpt(); ?>
		<?php endwhile;
		else : ?>
		<p><?php _e( 'Post Not Found !' ); ?></p>
	<?php endif;
	get_template_part( 'template-parts/content', 'paginate' ); ?>
</main>
<?php get_footer(); ?>
