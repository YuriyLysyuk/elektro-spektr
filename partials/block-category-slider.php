<?php

/**
 * Блок со слайдером категорий
 * На странице категории выводит параллельные категории
 * На странице подкатегории выводит параллельные подкатегории
 *
 * @package cabel
 * @author Yuriy Lysyuk
 * @since 1.0.0
 **/

global $post;
// Получаем ID текущей страницы
$currentPageID = $post->ID;
$blockSettings = [
	'category_page' => get_field('category_page_category_slider', 'options'),
	'subcategory_page' => get_field('subcategory_page_subcategory_slider', 'options'),
];
// Тексты на кнопках попапа слайдера
$popupSettings = get_field('category_slider_popup', 'options');
// Список категорий
$terms = '';

// Определяем текущую категорию
$currentCategory = get_terms([
	'taxonomy'   => 'product-category',
	'hide_empty' => false,
	'number'     => 1,
	'meta_query' => [
		[
			'key' => 'product_category_rel_page_id',
			'value' => '"' . $currentPageID . '"',
			'compare' => 'LIKE',
		],
	]
]);

// Определяем шаблон вывода страницы
// Если это страницы категории
if (is_page_template('templates/category-page.php')) {
	// Текст кнопки на слайдере
	$termButtonText = esc_html($blockSettings['category_page']['button_text']);
	// Текст кнопки попапа
	$popupButtonText = esc_html($popupSettings['category_page_button_text']);

	// Запрашиваем категории первого уровня, за исключением текущей
	$terms = get_terms([
		'taxonomy'   => 'product-category',
		'parent'     => 0,
		'hide_empty' => false,
		'exclude'    => $currentCategory[0]->term_id,
	]);
} elseif (is_page_template('templates/subcategory-page.php')) {
	// Текст кнопки на слайдере
	$termButtonText = esc_html($blockSettings['subcategory_page']['button_text']);
	// Текст кнопки попапа
	$popupButtonText = esc_html($popupSettings['subcategory_page_button_text']);

	// Запрашиваем все подкатегории текущей категории, за исключением текущей
	$terms = get_terms([
		'taxonomy'   => 'product-category',
		'parent'     => $currentCategory[0]->parent,
		'hide_empty' => false,
		'exclude'    => $currentCategory[0]->term_id,
	]);
}

// Выводим слайдер
// Если найдены категории и нет ошибки
if (!empty($terms) && !is_wp_error($terms)) {
	echo '<section class="category-slider">';
	echo '	<div class="wrap">';
	echo '		<div id="category-slider" class="owl-carousel owl-theme">';

	foreach ($terms as $term) {
		// Спец ID категории для запроса значений ACF 
		$acfTermId = 'product-category_' . $term->term_id;
		// ID связанной картинки
		$termImgID = get_field('product_category_img', $acfTermId);
		// Урл картинки для категории
		$termImg = wp_get_attachment_image_src($termImgID, 'category-thumb');
		if ($termImg) {
			$termImgUrl = $termImg[0];
		}

		// ID связанной страницы
		$termPageID = get_field('product_category_rel_page_id', $acfTermId);
		// Заголовок попапа
		$popupTitle = esc_html($term->name);

		// Если связанная страница задана
		if ($termPageID) {
			// Получаем ссылку на категорию
			$termLinkUrl = get_permalink($termPageID[0]);
			$termLinkBegin = '<a href="' . esc_url($termLinkUrl) . '" class="catalog__item" style="background-image: url(' . esc_url($termImgUrl) . ');">';
		} else {
			// Текст для попапа
			$popupData = ' data-modal-title="' . $popupTitle . '" data-modal-button-text="' . $popupButtonText . '"';
			$termLinkBegin = '<a href="#" class="catalog__item open-modal-common"' . $popupData . ' style="background-image: url(' . esc_url($termImgUrl) . ');">';
		}
		$termLinkEnd = '</a>';

		echo $termLinkBegin;
		echo '<div class="h4">' . esc_html($term->name) . '</div>';
		echo '<button class="wp-block-button__link has-background has-blue-background-color has-text-color has-white-color button-mini">' . $termButtonText . '</button>';
		echo $termLinkEnd;
	}

	echo '		</div>'; // #category-slider
	echo '	</div>'; // .wrap
	echo '</section>'; // .category-slider
}
