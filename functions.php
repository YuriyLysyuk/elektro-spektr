<?php

/**
 * Cabel functions
 *
 * @package      cabel
 * @author       Yuriy Lysyuk
 * @since        1.0.0
 */

/**
 * Theme setup.
 *
 */
add_action('genesis_setup', 'ly_theme_setup', 15);
function ly_theme_setup()
{

	define(
		'CHILD_THEME_VERSION',
		filemtime(get_stylesheet_directory() . '/dist/css/main.min.css')
	);

	add_theme_support('post-thumbnails');

	// Кастомный размер для изображений категорий в списке категорий
	add_image_size('category-thumb', 480, 256);

	// Includes
	include_once get_stylesheet_directory() . '/inc/wordpress-cleanup.php';
	include_once get_stylesheet_directory() . '/inc/genesis-changes.php';
	include_once get_stylesheet_directory() . '/inc/markup.php';
}

/**
 * Global enqueues
 *
 */
function ly_global_enqueues()
{
	/**
	 * JS
	 */
	wp_enqueue_script(
		'owl-carousel',
		get_stylesheet_directory_uri() . '/dist/vendor/owl.carousel/owl.carousel.min.js',
		['jquery'],
		"2.3.4",
		true
	);

	wp_enqueue_script(
		'izi-modal',
		get_stylesheet_directory_uri() . '/dist/vendor/iziModal/iziModal.min.js',
		['jquery'],
		"1.6.0",
		true
	);

	wp_enqueue_script(
		'masked-input',
		get_stylesheet_directory_uri() . '/dist/vendor/maskedInput/jquery.maskedinput.min.js',
		['jquery'],
		"1.4.1",
		true
	);

	wp_enqueue_script(
		'izi-toast',
		get_stylesheet_directory_uri() . '/dist/vendor/iziToast/iziToast.min.js',
		['jquery'],
		"1.4.0",
		true
	);
	// ToDo сменить источник на dist при публикации
	wp_enqueue_script(
		'ly-script',
		get_stylesheet_directory_uri() . '/app/js/app.js',
		['jquery'],
		filemtime(get_stylesheet_directory() . '/app/js/app.js'),
		true
	);


	/**
	 * CSS
	 */
	wp_enqueue_style(
		'owl-carousel',
		get_stylesheet_directory_uri() . '/dist/vendor/owl.carousel/assets/owl.carousel.min.css',
		[],
		"2.3.4"
	);

	wp_enqueue_style(
		'owl-theme',
		get_stylesheet_directory_uri() . '/dist/vendor/owl.carousel/assets/owl.theme.default.min.css',
		[],
		"2.3.4"
	);

	wp_enqueue_style(
		'izi-modal',
		get_stylesheet_directory_uri() . '/dist/vendor/iziModal/iziModal.min.css',
		[],
		"1.6.0"
	);

	wp_enqueue_style(
		'izi-toast',
		get_stylesheet_directory_uri() . '/dist/vendor/iziToast/iziToast.min.css',
		[],
		"1.4.0"
	);
	// ToDo сменить источник на dist при публикации
	wp_enqueue_style(
		'ly-style',
		get_stylesheet_directory_uri() . '/app/css/main.min.css',
		[],
		CHILD_THEME_VERSION
	);

	// Move jQuery to footer
	if (!is_admin()) {
		wp_deregister_script('jquery');

		// jquery из cdn гугла
		wp_register_script(
			'jquery',
			'https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js',
			false,
			null,
			true
		);

		wp_enqueue_script('jquery');
	}
}
add_action('wp_enqueue_scripts', 'ly_global_enqueues');

/**
 * Add favicon
 *
 */
function rko_favicon()
{
	// generics
	echo '<link rel="icon" href="' .
		get_stylesheet_directory_uri() .
		'/favicon.png" sizes="64x64">';
}
add_action('wp_head', 'rko_favicon');
