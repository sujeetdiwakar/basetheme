jQuery( function( $ ) {
	$( '.js-load-more' ).click( function( e ) {
		e.preventDefault();
		var button = $( this ),
			data = {
				'action': 'load_posts',
				'page': load_more_params.current_page,
			};

		$.ajax( {
			url: load_more_params.ajax_url,
			data: data,
			type: 'POST',
			beforeSend() {
				button.text( 'Loading...' )
			},
			success( data ) {
				if ( data ) {
					button.text( 'More posts' );
					$( '.js-posts' ).append( data );
					load_more_params.current_page ++;
					if ( load_more_params.current_page == load_more_params.max_page ) {
						button.remove();
					}
				} else {
					button.remove();
				}

			}

		} );
	} );

	$( '.js-movie-more' ).click( function( e ) {
		e.preventDefault();

		var button = $( this ),
			$type = $( this ).data( 'type' ),
			$lang = $( this ).data( 'lang' ),
			$rating = $(this).data('rating'),
		data = {
			'action': 'load_ajax_movie_posts',
			'page': load_more_params.current_page,
			'type': $type,
			'lang': $lang,
			'rating': $rating,
		};

		$.ajax( {
			url: load_more_params.ajax_url,
			data: data,
			type: 'POST',
			beforeSend() {
				button.text( 'Loading...' )
			},
			success( data ) {
				if ( data ) {
					button.text( 'More posts' );
					$( '.js-movie-posts' ).append( data );
					load_more_params.current_page ++;
					if ( load_more_params.current_page == load_more_params.max_page ) {
						button.remove();
					}
				} else {
					button.remove();
				}

			}

		} );
	} );

} );
