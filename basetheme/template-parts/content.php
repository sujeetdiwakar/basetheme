<?php
/**
 * The template part for displaying content
 */
if ( get_the_content() ):?>
	<div class="container" style="margin: 20px auto;">
		<?php the_content(); ?>
	</div>
<?php endif;
