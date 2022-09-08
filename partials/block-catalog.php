<?php

/**
 * Блок каталога со списком категорий
 * На главной странице выводит родительские категории
 * На странице категории выводит подкатегории дочерние категории
 *
 * @package cabel
 * @author Yuriy Lysyuk
 * @since 1.0.0
 **/

global $post;
// Получаем ID текущей страницы
$currentPageID = $post->ID;
// Заголовок блока
$blockTitle = '';
// Настройки блока
$blockSettings = [
	'front_page' => get_field('front_page_catalog', 'options'),
	'category_page' => get_field('category_page_catalog', 'options'),
];
// Тексты для попапа каталога
$popupSettings = get_field('catalog_popup', 'options');
// Список категорий
$terms = '';

// Определяем шаблон вывода страницы
if (is_page_template('templates/front-page.php')) {
	// Заголовок блока
	$blockTitle = esc_html($blockSettings['front_page']['title']);
	// Текст кнопки на категории
	$termButtonText = esc_html($blockSettings['front_page']['button_text']);
	// Текст кнопки попапа
	$popupButtonText = esc_html($popupSettings['front_page_button_text']);

	// Запрашиваем категории первого уровня, которые разрешено показывать в слайдере
	$terms = get_terms([
		'taxonomy'   => 'product-category',
		'parent'     => 0,
		'hide_empty' => false,
	]);
} elseif (is_page_template('templates/category-page.php')) {
	// Заголовок блока
	$blockTitle = esc_html($blockSettings['category_page']['title']);
	// Текст кнопки на слайдере
	$termButtonText = esc_html($blockSettings['category_page']['button_text']);
	// Текст кнопки попапа
	$popupButtonText = esc_html($popupSettings['category_page_button_text']);

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

	// Запрашиваем все подкатегории текущей категории
	$terms = get_terms([
		'taxonomy'   => 'product-category',
		'parent'     => $currentCategory[0]->term_id,
		'hide_empty' => false,
	]);
}

if (!empty($terms) && !is_wp_error($terms)) {
	echo '<section class="catalog">';
	echo '	<div class="wrap-grid">';
	echo '		<div class="h2">' . $blockTitle . '</div>';
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

	echo '	</div>'; // .wrap-grid
	echo '</section>';
}
