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
}
