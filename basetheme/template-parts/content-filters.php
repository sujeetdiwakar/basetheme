<?php
$types = get_terms( [ 'taxonomy' => 'movie_type', 'orderby' => 'ID', 'order' => 'DESC' ] );
$langs = get_terms( [ 'taxonomy' => 'movie_lang', 'orderby' => 'ID', 'order' => 'DESC' ] );

if ( ! empty( $types ) || ! empty( $langs ) ):?>
	<br>
	<form method="get">
		<div class="row">
			<?php if ( ! empty( $types ) ): ?>
				<div class="col-md-4">
					<select name="type" class="form-control" onchange="this.form.submit();">
						<option value="">Select Type</option>
						<?php foreach ( $types as $type ): ?>
							<option value="<?php echo $type->slug; ?>"<?php echo( $type->slug == @$_REQUEST['type'])?'selected':''; ?>><?php echo $type->name; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $langs ) ): ?>
				<div class="col-md-4">
					<select class="form-control" name="lang" onchange="this.form.submit();">
						<option value="">Select Language</option>
						<?php foreach ( $langs as $lang ): ?>
							<option value="<?php echo $lang->slug; ?>" <?php echo($lang->slug == @$_REQUEST['lang'])?'selected':''; ?>><?php echo $lang->name; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			<?php endif; ?>
			<div class="col-md-4">
				<select name="rating" class="form-control" onchange="this.form.submit();">
					<option value="">Select Rating</option>
					<option value="1"<?php echo( 1 == @$_REQUEST['rating'])?'selected':''; ?>>1</option>
					<option value="2"<?php echo( 2 == @$_REQUEST['rating'])?'selected':''; ?>>2</option>
					<option value="3"<?php echo( 3 == @$_REQUEST['rating'])?'selected':''; ?>>3</option>
					<option value="4"<?php echo( 4 == @$_REQUEST['rating'])?'selected':''; ?>>4</option>
					<option value="5"<?php echo( 5 == @$_REQUEST['rating'])?'selected':''; ?>>5</option>
				</select>
			</div>
		</div>
	</form>
<?php endif; ?>
