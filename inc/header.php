<?php

/**
 * Header
 *
 * @package      cabel
 * @author       Yuriy Lysyuk
 * @since        1.0.0
 **/

// Remove genesis header
remove_action('genesis_header', 'genesis_do_header');
remove_action('genesis_after_header', 'genesis_do_nav');
remove_action('genesis_after_header', 'genesis_do_subnav');


/**
 * Добавляем стили к блоку с хедером
 *
 */
function ly_site_header_attr($attributes)
{
	$attributes['class'] .= ' top';

	// Если шаблон страницы отличный от перечисленных, добавляем класс
	(is_page_template('templates/front-page.php')
		|| is_page_template('templates/category-page.php')
		|| is_page_template('templates/subcategory-page.php')) ?: $attributes['class'] .= ' template-wo-top-slider';


	$attributes['id'] = 'top';

	$attributes = wp_parse_args($attributes, genesis_attributes_entry([]));

	return $attributes;
}
add_filter('genesis_attr_site-header', 'ly_site_header_attr');

// Выводим верхнее меню
add_action('genesis_header', 'ly_top_line_block', 10);

// Выводим верхний слайдер
add_action('genesis_header', 'ly_top_slider_block', 10);
