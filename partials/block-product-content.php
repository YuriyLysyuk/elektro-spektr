<?php

/**
 * Блок с информацией о товаре
 *
 * @package cabel
 * @author Yuriy Lysyuk
 * @since 1.0.0
 **/

global $post;
// Получаем ID текущей страницы
$pageID = $post->ID;

// Определяем текущий товар, привязанный к странице
$product = get_posts([
	'post_type'   => 'product',
	'post_status'   => 'publish',
	'numberposts'     => 1,
	'meta_query' => [
		[
			'key' => 'product_rel_page_id',
			'value' => '"' . $pageID . '"',
			'compare' => 'LIKE',
		],
	]
]);

if (!empty($product)) {
	// Настройки блока
	$blockSettings = get_field('product_page_info', 'options');
	// Тексты для попапа карточки
	$popupSettings = get_field('product_page_info_popup', 'options');

	$productID = $product[0]->ID;
	// Заголовок товара
	$productTitle = esc_html(get_the_title($productID));
	// Описание товара
	$productDesc = esc_html(get_field('product_desc', $productID));
	// Картинка товара
	$productImg = get_the_post_thumbnail($productID, 'full');
	$buttonText = esc_html($blockSettings['button_text']);
	$popupButtonText = esc_html($popupSettings['buy_button_text']);


	echo '<section class="product-content">';
	echo '	<div class="overview">';
	echo '		<div class="wrap-grid">';
	echo '			<div class="overview__img">' . $productImg . '</div>';
	echo '			<div class="overview__desc">';
	echo '				<div class="h2">' . $productTitle . '</div>';
	echo '				<p>' . $productDesc . '</p>';
	echo '				<button class="wp-block-button__link open-modal-common" data-modal-title="' . $productTitle . '" data-modal-button-text="' . $popupButtonText . '">' . $buttonText . '</button>';
	echo '			</div>'; // .overview__desc
	echo '		</div>'; // .wrap-grid
	echo '	</div>'; // .overview

	// Получаем массив фильтров из константы
	$subcategoryFilters = unserialize(SUBCATEGORY_FILTERS);
	// Получаем родительскую категорию
	$top_term = ly_get_top_term('product-category', $productID);
	// Получаем фильтр и его значения
	$attrFields = get_field($subcategoryFilters[$top_term->term_id]['field_name'], $productID);

	if (!empty($attrFields)) {
		// Определяем последний элемент (для вывода разделителя)
		$arrayKeys = array_keys($attrFields);
		$lastAttrLabel = end($arrayKeys);
		// 	Заголовок характеристик
		$specsTitle = esc_html($blockSettings['specs_title']);

		echo '	<div class="specs">';
		echo '		<div class="wrap-grid">';
		echo '			<div class="h2">' . $specsTitle . '</div>';

		foreach ($attrFields as $attrLabel => $attrName) {
			// Получаем значение атрибута
			$attr = get_field_object($subcategoryFilters[$top_term->term_id]['field_name'] . '_' . $attrLabel, $productID);

			echo '			<div class="specs__item-key">' . $attr['label'] . ':</div>';
			echo '			<div class="specs__item-value">' . $attr['choices'][$attrName] . '</div>';
			// Выводим разделитель если это не последний элемент
			echo ($attrLabel == $lastAttrLabel) ? '' : '<hr>';
		}

		echo '		</div>'; // .wrap-grid
		echo '	</div>'; // .specs
	}

	// 	Заголовок макроразмеров кабелей
	$sizesTitle = esc_html($blockSettings['cabel_sizes_title']);
	$sizes = get_field('cable_sizes', $productID);

	if ($sizes) {
		echo '	<div class="types">';
		echo '		<div class="wrap-grid">';
		echo '			<div class="h2">' . $sizesTitle . '</div>';
		foreach ($sizes as $size) {
			echo '			<a href="#" class="types__item open-modal-common" data-modal-title="' . esc_attr($size['size']) . '" data-modal-button-text="' . esc_attr($popupSettings['cable_size_button_text']) . '">' . esc_html($size['size']) . '</a>';
		}
		echo '		</div>'; // .wrap-grid
		echo '	</div>'; // .types
	}
	echo '</section>';
}
