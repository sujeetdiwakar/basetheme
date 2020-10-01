jQuery( function( $ ) {

	var $filter = $( '.js-filter' );
	var $slider = $( '#js-price-filter' );

	$( document ).on( 'change', '.js-filter input[type="checkbox"], .js-order', function( e ) {
		e.preventDefault();

		var $add_filters = $( '.js-additional input[type="checkbox"]', $filter ).filter( ':checked' ).map( function() {
				return this.value;
			} ).get().join( '|' ),

			$rating_filter = $( '.js-rating input[type="checkbox"]', $filter ).filter( ':checked' ).map( function() {
				return this.value;
			} ).get().join( '|' ),

			$order = $( '.js-order' ).val(),
			$pack = $( '#js-package-key' ).val(),
			$price = $slider.val(),
			$qs = '?qs=1';

		if ( '' !== $add_filters && typeof $add_filters !== 'undefined' ) {
			$qs = $qs + '&qtr=' + $add_filters;
		}

		if ( '' !== $rating_filter && typeof $rating_filter !== 'undefined' ) {
			$qs = $qs + '&qr=' + $rating_filter;
		}

		if ( '' !== $price && typeof $price !== 'undefined' ) {
			$qs = $qs + '&price=' + $price;
		}

		if ( '' !== $order && typeof $order !== 'undefined' ) {
			$qs = $qs + '&ord=' + $order;
		}

		if ( '' !== $pack && typeof $pack !== 'undefined' ) {
			$qs = $qs + '&pk=' + $pack;
		}

		var new_url = $( '.js-additional' ).data( "filter" );
		new_url += $qs;

		$( window.location ).attr( 'href', new_url );
	} );

	/* load more filter */
	var $more = $( '.js-more-load' );
	var x = 2;
	$( '.js-additional .filter__block:lt(' + x + ')' ).show();
	var $blocks = $( '.js-additional .filter__block' ).size();

	if ( $more.length > 0 ) {

		$more.click( function( event ) {
			event.preventDefault();

			x = (x + 1 <= $blocks) ? x + 1 : $blocks;
			$( '.js-additional .filter__block:lt(' + x + ')' ).show();

			if ( $blocks === x ) {
				$more.remove();
			}
		} );
	}

	var $block = $( '.js-additional .filter__block' );
	$block.each( function() {
		var $li = $( this ).children( 'ul' ).children( 'li' );
		$( '.js-additional .filter__block ul li:nth-child(7)' ).nextAll( 'li' ).hide();
		if ( $li.length > 7 ) {
			$( this ).append( '<a class="more" href="#">Meer</a>' );
		}
	} );

	var x = 7;
	$( '.js-additional .filter__block .more' ).click( function( event ) {
		event.preventDefault();
		var size_li = $( this ).siblings( 'ul' ).children( 'li' ).size();
		x = (x + 3 <= size_li) ? x + 3 : size_li;
		$( this ).siblings( 'ul' ).children( 'li:lt(' + x + ')' ).show();
		if ( size_li === x ) {
			$( this ).remove();
		}
	} );

} );
