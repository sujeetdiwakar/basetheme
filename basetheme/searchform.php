<?php
/**
 * Template for displaying search forms
 */
?>

<form class="searchform form-inline my-2 my-lg-0" id="searchform" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<fieldset>
		<input class="form-control mr-sm-2" type="text" name="s" id="s" placeholder="<?php _e( 'Search...' ); ?>">

		<button class="btn btn-outline-light my-2 my-sm-0" id="searchsubmit" type="submit"><?php _e( 'Search' ); ?></button>
	</fieldset>
</form>
