<div class="card" style="width: 18rem; margin: 20px auto">
	<?php if ( has_post_thumbnail() ): ?>
		<img class="card-img-top" src="<?php the_post_thumbnail_url( 'post-thumb' ); ?>" alt="Card image cap">
	<?php endif; ?>
	<div class="card-body">
		<h5 class="card-title"><?php the_title(); ?></h5>
		<p class="card-text"><?php the_excerpt(); ?></p>
		<a href="<?php the_permalink(); ?>" class="btn btn-primary">Read More</a>
	</div>
</div>
