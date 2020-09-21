<?php
if ( ! function_exists( 'get_size' ) ) {

	function get_size( $file ) {
		$bytes = filesize( $file );
		$s     = [ 'b', 'Kb', 'Mb', 'Gb' ];
		$e     = floor( log( $bytes ) / log( 1024 ) );

		return sprintf( '%.2f ' . $s[ $e ], ( $bytes / pow( 1024, floor( $e ) ) ) );
	}
}

if ( ! function_exists( 'strip_phone_number' ) ) {

	function strip_phone_number( $phone_number ) {
		$phone_number = str_replace( ' ', '', $phone_number );
		$phone_number = str_replace( '-', '', $phone_number );
		$phone_number = str_replace( '.', '', $phone_number );
		$phone_number = str_replace( '(0)', '', $phone_number );
		$phone_number = str_replace( '(', '', $phone_number );
		$phone_number = str_replace( ')', '', $phone_number );
		$phone_number = str_replace( '+', '00', $phone_number );

		return $phone_number;
	}
}

if ( ! function_exists( 'format_price' ) ) {

	function format_price( $price, $zeros = true ) {
		// Check if Woocommerce is active, if so use build in Woocommerce function
		if ( function_exists( 'wc_price' ) ) {
			return wc_price( $price );
		}

		$price = str_replace( '.', ',', $price );
		$price = '&euro; ' . $price;

		if ( $zeros === false ) {
			if ( substr( $price, - 3 ) == ',00' ) {
				$price = substr( $price, 0, - 3 ) . ',-';
			}
		}

		return $price;
	}
}

if ( ! function_exists( 'get_current_url' ) ) {

	function get_current_url() {
		global $wp;

		$current_url = esc_url( add_query_arg( esc_url( $_SERVER['QUERY_STRING'] ), '', home_url( $wp->request ) ) );

		if ( substr( $current_url, - 1 ) != '/' && strpos( $current_url, '?' ) === false ) {
			$current_url = $current_url . '/';
		}

		return $current_url;
	}
}

if ( ! function_exists( 'the_current_url' ) ) {

	function the_current_url() {
		echo get_current_url();
	}
}

if ( ! function_exists( 'reading_time' ) ) {
//estimated reading time
	function reading_time() {
		if ( is_singular( 'post' ) ) {
			$post_id = get_the_ID();
			$content = get_post_field( 'post_content', $post_id );

			$word_count  = str_word_count( strip_tags( $content ) );
			$readingtime = ceil( $word_count / 100 );

			if ( $readingtime == 1 ) {
				$timer = __( " min" );
			} else {
				$timer = __( " min" );
			}
			$totalreadingtime = $readingtime . $timer;

			return $totalreadingtime;
		}
	}
}

if ( ! function_exists( 'get_archive' ) ) {

	function get_archive( $post_type = false ) {
		// If no post type use the wp_query to find one
		if ( ! $post_type ) {
			global $wp_query;
			$post_type = $wp_query->query_vars['post_type'];
		}

		// Check is post type exist
		if ( post_type_exists( $post_type ) ) {
			$posts = get_posts( [
				'post_type'      => 'page',
				'post_status'    => 'publish',
				'posts_per_page' => 1,
				'orderby'        => 'menu_order',
				'order'          => 'asc',
				'meta_query'     => [
					[
						'key'   => '_wp_page_template',
						'value' => 'archive_' . $post_type,
					],
				],
			] );

			if ( $posts ) {
				return reset( $posts );
			}
		}

		return false;
	}
}

if ( ! function_exists( 'get_404' ) ) {

	function get_404() {
		if ( is_404() ) {
			$posts = get_posts( [
				'post_type'      => 'page',
				'post_status'    => 'publish',
				'posts_per_page' => 1,
				'orderby'        => 'menu_order',
				'order'          => 'asc',
				'meta_query'     => [
					[
						'key'   => '_wp_page_template',
						'value' => '404',
					],
				],
			] );

			if ( $posts ) {
				return reset( $posts );
			}
		}

		return false;
	}
}

