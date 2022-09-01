<?php

/**
 * Блок верхнего слайдера
 *
 * @package cabel
 * @author Yuriy Lysyuk
 * @since 1.0.0
 **/

// Если шаблон страницы есть в перечисленных, выводим слайдер
if (
	is_page_template('templates/front-page.php')
	|| is_page_template('templates/category-page.php')
	|| is_page_template('templates/subcategory-page.php')
) {

	global $post;
	// Получаем ID текущей страницы
	$currentPageID = $post->ID;
	// Тексты на кнопках слайдера
	$blockSettings = [
		'front_page' => get_field('front_page_main_slider', 'options'),
		'category_page' => get_field('category_page_main_slider', 'options'),
		'subcategory_page' => get_field('subcategory_page_main_slider', 'options'),
	];
	// Тексты на кнопках попапа слайдера
	$popupSettings = get_field('main_slider_popup', 'options');
	// Список категорий
	$terms = '';

	// Определяем шаблон вывода страницы
	if (is_page_template('templates/front-page.php')) {
		// Текст кнопки на слайдере
		$termButtonText = esc_html($blockSettings['front_page']['button_text']);
		// Текст кнопки попапа
		$popupButtonText = esc_html($popupSettings['front_page_button_text']);

		// Запрашиваем категории первого уровня, которые разрешено показывать в слайдере
		$terms = get_terms([
			'taxonomy'   => 'product-category',
			'parent'     => 0,
			'hide_empty' => false,
			'meta_query' => [
				[
					'key' => 'product_category_show_in_main_slider',
					'value' => true,
				],
			]
		]);
	} elseif (is_page_template('templates/category-page.php')) {
		// Текст кнопки на слайдере
		$termButtonText = esc_html($blockSettings['category_page']['button_text']);
		// Текст кнопки попапа
		$popupButtonText = esc_html($popupSettings['category_page_button_text']);

		// Запрашиваем категорию, с которой связана текущая старница
		$terms = get_terms([
			'taxonomy'   => 'product-category',
			'hide_empty' => false,
			'meta_query' => [
				[
					'key' => 'product_category_rel_page_id',
					'value' => '"' . $currentPageID . '"',
					'compare' => 'LIKE',
				],
			],
		]);
	} elseif (is_page_template('templates/subcategory-page.php')) {
		// Текст кнопки на слайдере
		$termButtonText = esc_html($blockSettings['subcategory_page']['button_text']);
		// Текст кнопки попапа
		$popupButtonText = esc_html($popupSettings['subcategory_page_button_text']);

		// Запрашиваем категорию, с которой связана текущая старница
		$terms = get_terms([
			'taxonomy'   => 'product-category',
			'hide_empty' => false,
			'meta_query' => [
				[
					'key' => 'product_category_rel_page_id',
					'value' => '"' . $currentPageID . '"',
					'compare' => 'LIKE',
				],
			],
		]);
	}

	// Выводим слайдер
	// Если найдены категории и нет ошибки
	if (!empty($terms) && !is_wp_error($terms)) {
		echo '		<div id="top-slider" class="owl-carousel owl-theme">';

		foreach ($terms as $term) {
			// Спец ID категории для запроса значений ACF 
			$acfTermId = 'product-category_' . $term->term_id;
			// ID связанной картинки
			$termImgID = get_field('product_category_img', $acfTermId);
			// Урл картинки для категории
			$termImgUrl = wp_get_attachment_image_src($termImgID, 'full');
			// ID связанной страницы
			$termPageID = get_field('product_category_rel_page_id', $acfTermId);
			// Заголовок попапа
			$popupTitle = esc_html($term->name);

			// Если связанная страница задана и это шаблон главной
			if ($termPageID && is_page_template('templates/front-page.php')) {
				// Получаем ссылку на категорию
				$termLinkUrl = get_permalink($termPageID[0]);
				$termLink = '<a href="' . esc_url($termLinkUrl) . '" class="wp-block-button__link">' . $termButtonText . '</a>';
			} else {
				// Текст для попапа
				$popupData = ' data-modal-title="' . $popupTitle . '" data-modal-button-text="' . $popupButtonText . '"';
				$termLink = '<a href="#" class="wp-block-button__link open-modal-common"' . $popupData . '>' . $termButtonText . '</a>';
			}

			echo '			<div style="background-image: url(' . esc_url($termImgUrl[0]) . ');">';
			echo '				<div class="wrap">';
			echo '					<div class="top-slider__text">';
			echo '						<div class="h1">' . esc_html($term->name) . '</div>';
			echo $termLink;
			echo '					</div>';
			echo '				</div>';
			echo '			</div>';
		}

		echo '		</div>'; // #top-slider
	}
}
