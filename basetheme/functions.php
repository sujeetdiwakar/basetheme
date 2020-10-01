<?php
/**
 * Register Custom Navigation Walker
 */
function register_navwalker() {
	require_once get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';
}

require_once get_template_directory() . '/inc/general.php';

add_action( 'after_setup_theme', 'register_navwalker' );

// include js in the Base-Theme
function base_theme_scripts() {
	if ( ! is_admin() ) {
		global $wp_query;

		// load a JS file from Base-Theme
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'script-js', get_bloginfo( 'template_url' ) . '/assets/js/main.js', [ 'jquery' ], '1.0.0', true );
		wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', [ 'jquery' ], '4.5.2', true );

		wp_enqueue_script( 'load-more', get_template_directory_uri() . '/assets/js/load-more.js', [ 'jquery' ], '1.0.0', true );

		wp_localize_script( 'load-more', 'load_more_params', [
			'ajax_url'     => admin_url( 'admin-ajax.php' ),
			'current_page' => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
			'max_page'     => $wp_query->max_num_pages
		] );

		// load a CSS file from base-Theme
		wp_enqueue_style( 'bootstrap', get_stylesheet_directory_uri() . '/assets/css/bootstrap.css', [], '4.5.2' );
		wp_enqueue_style( 'style-css', get_bloginfo( 'template_url' ) . '/assets/css/main.css' );
	}
}

add_action( 'wp_enqueue_scripts', 'base_theme_scripts' );

// enable post thumbnail option start here
add_theme_support( 'post-thumbnails' );

// enable image cropping sizes start here
function base_theme_image_theme_setup() {
	add_image_size( 'post-image', 320, 260, true );
	add_image_size( 'post-thumb', 520, 460, true );
}

add_action( 'after_setup_theme', 'base_theme_image_theme_setup' );

// assign custom thumbnail size start here
if ( has_post_thumbnail() ) {
	the_post_thumbnail( 'post-image' );
}

// assign media library images start here
add_filter( 'image_size_names_choose', 'base_theme_image_custom_sizes' );

function base_theme_image_custom_sizes( $sizes ) {
	return array_merge( $sizes, [
		'post-image' => __( 'Post Image' ),
	] );
}

// wp nav menu option start here
function register_my_menus() {
	register_nav_menus(
		[
			'header_menu' => 'Header Menu',
			'footer_menu' => 'Footer Menu',
		]
	);
}

add_action( 'init', 'register_my_menus' );
// wp nav menu option end here



// side bar option start here
if ( function_exists( 'register_sidebar' ) ) {

	register_sidebar( [
		'name'          => 'Footer Widgets',
		'id'            => 'footer_widgets',
		'description'   => 'This area for Footer Widgets',
		'before_widget' => '<aside class="footer__module %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>',
	] );
}
// side bar option end here

// custom excerpt length
function custom_excerpt_length( $length ) {
	return 25;
}

add_filter( 'excerpt_length', 'custom_excerpt_length' );

// Define additional option pages
if ( function_exists( 'acf_add_options_page' ) ) {

	$options = acf_add_options_page( [
		'page_title' => 'Theme options',
		'menu_title' => 'Theme options',
		'menu_slug'  => 'options-theme',
		'capability' => 'edit_posts',
		'redirect'   => false
	] );
}

//Register theme custom post types
function register_custom_post_types() {

	register_post_type( 'movie',
		[
			'labels'             => [
				'name'          => 'Movies',
				'singular_name' => 'Movie',
				'menu_name'     => 'Movies',
			],
			'public'             => true,
			'publicly_queryable' => true,
			'menu_icon'          => 'dashicons-clipboard',
			'has_archive'        => true,
			'rewrite'            => [ 'slug' => 'movie' ],
			'supports'           => [
				'title',
				'editor',
				'thumbnail',
				'author'
			],
		]
	);

	register_post_type( 'project', [
		'labels'    => [
			'name'          => __( 'Projects' ),
			'singular_name' => __( 'Project' ),
			'menu_name'     => __( 'Projects' ),
		],
		'public'    => true,
		'menu_icon' => 'dashicons-location',
		'rewrite'   => [ 'slug' => 'project' ],
		'supports'  => [ 'title', 'editor', 'thumbnail' ]
	] );
}

add_action( 'init', 'register_custom_post_types' );

//register taxonomy
function register_taxonomies() {

	register_taxonomy( 'movie_type', [ 'movie' ],
		[
			'hierarchical'      => true,
			'labels'            => [
				'name'          => __( 'Movie Types' ),
				'singular_name' => __( 'Movie Type' ),
				'menu_name'     => __( 'Movie Types' ),
			],
			'show_ui'           => true,
			'show_admin_column' => true,
			'rewrite'           => [ 'slug' => __( 'type' ) ],
		]
	);

	register_taxonomy( 'movie_lang', [ 'movie' ],
		[
			'hierarchical'      => true,
			'labels'            => [
				'name'          => __( 'Movie Languages' ),
				'singular_name' => __( 'Movie Language' ),
				'menu_name'     => __( 'Movie Languages' ),
			],
			'show_ui'           => true,
			'show_admin_column' => true,
			'rewrite'           => [ 'slug' => __( 'lang' ) ],
		]
	);

	register_taxonomy( 'project_cat', [ 'project' ], [
		'labels'            => [
			'name'          => __( 'Categories' ),
			'singular_name' => __( 'Category' ),
			'menu_name'     => __( 'Categories' ),
		],
		'hierarchical'      => true,
		'show_admin_column' => true,
		'rewrite'           => [ 'slug' => 'cat' ]
	] );
}

add_action( 'init', 'register_taxonomies' );

function add_archive_placeholders( $page_templates, $instance, $post ) {

	if ( $post && $post->post_type != 'page' ) {
		return $page_templates;
	}

	$post_types = get_post_types( [ '_builtin' => false ] );

	foreach ( $post_types as $post_type ) {
		if ( ( $post_type_object = get_post_type_object( $post_type ) ) != null && $post_type_object->has_archive ) {
			$page_templates[ 'archive_' . $post_type ] = sprintf( __( 'Archive - %s', 'text_domain' ), $post_type_object->labels->singular_name );
		}
	}

	return $page_templates;
}

add_filter( 'theme_page_templates', 'add_archive_placeholders', 10, 3 );

function redirect_to_archive() {

	if ( is_singular( 'page' ) ) {
		$template = str_replace( 'archive_', '', get_page_template_slug( get_queried_object_id() ) );
		$types    = get_post_types( [ 'has_archive' => true ], 'names' );

		if ( in_array( $template, $types ) ) {
			wp_safe_redirect( get_post_type_archive_link( $template ) );
			exit();
		}
	}
}

add_action( 'template_redirect', 'redirect_to_archive' );

function load_posts() {

	$paged = $_POST['page'] + 1;

	if ( ! empty( $paged ) ) {

		$args = [
			'post_type' => 'post',
			'paged'     => $paged,
		];

		$my_post = new WP_Query( $args );

		while ( $my_post->have_posts() ):
			$my_post->the_post(); ?>
			<div class="col-md-4"><?php get_template_part( 'template-parts/loop', 'post' ); ?></div>
		<?php endwhile;
		wp_reset_postdata();
	}

	wp_die();
}

add_action( 'wp_ajax_load_posts', 'load_posts' );
add_action( 'wp_ajax_nopriv_load_posts', 'load_posts' );

function load_ajax_movie_posts() {

	$paged  = $_REQUEST['page'] + 1;
	$type   = $_REQUEST['type'];
	$lang   = $_REQUEST['lang'];
	$rating = $_REQUEST['rating'];

	if ( ! empty( $paged ) ) {

		$args = [
			'post_type'      => 'movie',
			'paged'          => $paged,
			'posts_per_page' => 3,
		];

		if ( ! empty( $type ) )
			$args['tax_query'][] =
				[
					'taxonomy' => 'movie_type',
					'field'    => 'slug',
					'terms'    => @$_REQUEST['type'],
				];


		if(!empty(! empty( $lang )))
			$args['tax_query'][] =
				[
					'taxonomy' => 'movie_lang',
					'field'    => 'slug',
					'terms'    => @$_REQUEST['lang'],
			    ];


		if( !empty($rating) ) {
			$args['meta_query'][] = [
				'key'     => 'rating',
				'value'   => $rating,
				'compare' => '=',
			];
		}

		$my_post = new WP_Query( $args );

		while ( $my_post->have_posts() ):
			$my_post->the_post(); ?>
			<div class="col-md-4"><?php get_template_part( 'template-parts/loop', 'movie' ); ?></div>
		<?php endwhile;
		wp_reset_postdata();
	}

	wp_die();
}

add_action( 'wp_ajax_load_ajax_movie_posts', 'load_ajax_movie_posts' );
add_action( 'wp_ajax_nopriv_load_ajax_movie_posts', 'load_ajax_movie_posts' );

function add_404_placeholders( $page_templates, $instance, $post ) {
	if ( $post && $post->post_type != 'page' ) {
		return $page_templates;
	}

	$page_templates['404'] = __( '404 - Page not Found' );

	return $page_templates;
}

add_filter( 'theme_page_templates', 'add_404_placeholders', 10, 3 );

function redirect_to_404() {
	if ( is_singular( 'page' ) && is_page_template( '404' ) ) {
		global $wp_query;

		$wp_query->set_404();

		status_header( 404 );
		get_template_part( 404 );

		exit();
	}
}

add_action( 'template_redirect', 'redirect_to_404' );

function redirect() {
	global $wp_rewrite;

	if ( ! isset( $wp_rewrite ) || ! is_object( $wp_rewrite ) || ! $wp_rewrite->get_search_permastruct() ) {
		return;
	}

	$search_base = $wp_rewrite->search_base;

	if ( is_search() && ! is_admin() && strpos( $_SERVER['REQUEST_URI'], "/{$search_base}/" ) === false && strpos( $_SERVER['REQUEST_URI'], '&' ) === false ) {
		wp_redirect( get_search_link() );
		exit();
	}
}

function rewrite( $url ) {
	return str_replace( '/?s=', '/search/', $url );
}

define( 'NICE_SEARCH', true );

if ( NICE_SEARCH ) {
	add_action( 'template_redirect', 'redirect' );
	add_filter( 'wpseo_json_ld_search_url', 'rewrite' );
}

function adjust_main_queries( $query ) {

	if ( ! is_admin() && $query->is_main_query() ) {

		if ( $query->is_search() ) {

			$query->set( 'posts_per_page', 12 );
		}
		
		if ( $query->is_tax() || is_post_type_archive( 'package' ) ) {

				$query->set( 'order', 'asc' );

				if ( isset( $_GET['pk'] ) && ! empty( $_GET['pk'] ) ) {
					$query->set( 's', esc_attr( $_GET['pk'] ) );
				}

				if ( isset( $_GET['qtr'] ) && ! empty( $_GET['qtr'] ) ) {
					$query->set( 'tax_query', '' );
					$items = esc_attr( $_GET['qtr'] );
					$qs    = explode( '|', $items );

					$tax_query[] = [
						'taxonomy' => 'filter_cat',
						'field'    => 'slug',
						'terms'    => $qs,
					];
					$query->set( 'tax_query', $tax_query );
				}

				if ( isset( $_GET['price'] ) && ! empty( $_GET['price'] ) ) {

					$price = esc_attr( $_GET['price'] );
					$p     = explode( ',', $price );

					if ( ! empty( $p ) && is_array( $p ) ) {
						$query->set( 'meta_query', [
								[
									'key'     => 'price',
									'value'   => [ $p[0], $p[1] ],
									'compare' => 'between',
									'type'    => 'numeric'
								]
							]
						);
					}
				}

				if ( isset( $_GET['qr'] ) && ! empty( $_GET['qr'] ) ) {

					$ratings = esc_attr( $_GET['qr'] );
					$stars   = explode( '|', $ratings );

					$package_ids = get_post_by_ratings( $stars );

					if ( ! empty( $package_ids ) && is_array( $package_ids ) ) {
						$query->set( 'post__in', $package_ids );
					} else {
						$query->set( 'post__in', [ 0 ] );
					}
				}

				if ( isset( $_GET['ord'] ) && ! empty( $_GET['ord'] ) ) {

					if ( $_GET['ord'] == 'low' || $_GET['ord'] == 'high' || $_GET['ord'] == 'alphabet' ) {

						$order = esc_attr( $_GET['ord'] );

						if ( $order == 'high' ) {
							$query->set( 'meta_key', 'price' );
							$query->set( 'orderby', 'meta_value_num' );
							$query->set( 'order', 'desc' );
						} elseif ( $order == 'low' ) {
							$query->set( 'meta_key', 'price' );
							$query->set( 'orderby', 'meta_value_num' );
							$query->set( 'order', 'asc' );
						} elseif ( $order == 'alphabet' ) {
							$query->set( 'orderby', 'title' );
							$query->set( 'order', 'asc' );
						}
					}
				}
			}

		if ( is_tax() || is_post_type_archive( 'movie' ) ) {

			$query->set( 'posts_per_page', 3 );

			if ( isset( $_REQUEST['type'] ) && ! empty( $_REQUEST['type'] ) ) {

				$query->set( 'tax_query', '' );

				$cats = esc_attr( $_REQUEST['type'] );

				$qs = explode( '|', $cats );

				$tax_query[] = [
					'taxonomy' => 'movie_type',
					'field'    => 'slug',
					'terms'    => $qs,
				];

				$query->set( 'tax_query', $tax_query );
			}

			if ( isset( $_REQUEST['rating'] ) && ! empty( $_REQUEST['rating'] ) ) {
				$query->set( 'meta_query', [
					[
						'key'     => 'rating',
						'compare' => '=',
						'value'   => $_REQUEST['rating'],
						//'type'    => 'numeric',
					]
				] );
			}

			if ( isset( $_REQUEST['lang'] ) && ! empty( $_REQUEST['lang'] ) ) {

				$query->set( 'tax_query', '' );

				$cats = esc_attr( $_REQUEST['lang'] );

				$qs = explode( '|', $cats );

				$tax_query[] = [
					'taxonomy' => 'movie_lang',
					'field'    => 'slug',
					'terms'    => $qs,
				];

				$query->set( 'tax_query', $tax_query );
			}
		}
	}

	return $query;
}

add_filter( 'pre_get_posts', 'adjust_main_queries' );

function cleanup_nav_walker( $classes, $item ) {
	$slug = sanitize_title( $item->title );

	// Fix core `active` behavior for custom post types
	if ( in_array( get_post_type(), get_post_types( [ '_builtin' => false ] ) ) ) {
		$classes = str_replace( 'current_page_parent', '', $classes );
		if ( get_post_type_archive_link( get_post_type() ) == strtolower( trim( $item->url ) ) ) {
			if ( is_search() || is_404() ) {
				$classes[] = '';
			} else {
				$classes[] = 'active';
			}
		}
	}

	// Remove most core classes
	//$classes = preg_replace( '/(current(-menu-|[-_]page[-_])(item|parent|ancestor))/', 'active', $classes );
	//$classes = preg_replace( '/^((menu|page)[-_\w+]+)+/', '', $classes );

	//Remove most core classes with condition
	if ( is_search() || is_404() ) {

	} else {
		$classes = preg_replace( '/(current(-menu-|[-_]page[-_])(item|parent|ancestor))/', 'active', $classes );
		$classes = preg_replace( '/^((menu|page)[-_\w+]+)+/', '', $classes );
	}

	// Add parent class
	if ( $item->is_subitem ) {
		$classes[] = 'has-children';
	}

	// Add `menu-<slug>` class
	$classes[] = 'menu-' . $slug;
	$classes   = array_unique( $classes );
	$classes   = array_map( 'trim', $classes );

	return array_filter( $classes );
}

add_filter( 'nav_menu_css_class', 'cleanup_nav_walker', 10, 2 );
add_filter( 'nav_menu_item_id', '__return_null' );


#https://rudrastyh.com/wordpress/ajax-post-filters.html
