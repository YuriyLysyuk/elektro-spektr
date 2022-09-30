<?php

/**
 * Блок со списком товаров в подкатегории
 *
 * @package cabel
 * @author Yuriy Lysyuk
 * @since 1.0.0
 **/

//  Показываем только на странице подкатегории
if (!is_page_template('templates/subcategory-page.php')) {
	return;
}

$the_query = ly_get_products();

if ($the_query->have_posts()) {

	// Настройки блока
	$blockSettings = get_field('block_subcategory_list', 'options');
	// Тексты для попапа каталога
	$popupSettings = get_field('subcategory_list_popup', 'options');

	echo '<section class="subcategory-list">';

	while ($the_query->have_posts()) {
		$the_query->the_post();

		// ID связанной страницы
		$relPageID = get_field('product_rel_page_id', get_the_id());
		// Картинка товара
		$productImg = get_the_post_thumbnail(get_the_id(), 'category-thumb');
		// Описание товара
		$productDesc = get_field('product_desc', get_the_id());
		// Тексты кнопки на категории
		$firstButtonText = esc_html($blockSettings['popup_button_text']);
		$secondButtonText = esc_html($blockSettings['more_button_text']);

		// Третий попап
		$thirdPopupButtonText = esc_html($popupSettings['click_popup_button_text']);

		// Если связанная страница задана
		if ($relPageID) {
			// Получаем ссылку на привязанную страницу
			$pageLinkUrl = get_permalink($relPageID[0]);

			// Первая ссылка
			$firstPageLinkBegin = '<a href="' . esc_url($pageLinkUrl) . '" class="subcategory-list__item-img">';
			// Вторая ссылка
			$secondPageLinkBegin = '<a href="' . esc_url($pageLinkUrl) . '" class="subcategory-list__item-title h4">';
			// Четвертая ссылка
			$fourthPageLinkBegin = '<a href="' . esc_url($pageLinkUrl) . '" class="wp-block-button__link has-background has-blue-background-color has-text-color has-white-color button-mini">';
		} else {
			// Первый попап
			$firstPopupButtonText = esc_html($popupSettings['click_img_button_text']);
			$firstPopupData = ' data-modal-title="' . get_the_title() . '" data-modal-button-text="' . $firstPopupButtonText . '"';
			$firstPageLinkBegin = '<a href="#" class="subcategory-list__item-img open-modal-common"' . $firstPopupData . '>';
			// Второй попап
			$secondPopupButtonText = esc_html($popupSettings['click_title_button_text']);
			$secondPopupData = ' data-modal-title="' . get_the_title() . '" data-modal-button-text="' . $secondPopupButtonText . '"';
			$secondPageLinkBegin = '<a href="#" class="subcategory-list__item-title h4 open-modal-common"' . $secondPopupData . '>';

			// Четвертый попап
			$fourthPopupButtonText = esc_html($popupSettings['click_more_button_text']);
			$fourthPopupData = ' data-modal-title="' . get_the_title() . '" data-modal-button-text="' . $fourthPopupButtonText . '"';
			$fourthPageLinkBegin = '<a href="#" class="wp-block-button__link has-background has-blue-background-color has-text-color has-white-color button-mini open-modal-common"' . $fourthPopupData . '>';
		}

		echo '<div class="subcategory-list__item">';
		echo $firstPageLinkBegin;
		echo $productImg;
		echo '</a>';
		echo $secondPageLinkBegin . get_the_title() . '</a>';
		echo '<p class="subcategory-list__item-desc">' . esc_html($productDesc) . '</p>';
		echo '<div class="subcategory-list__item-buttons">';
		echo '	<a href="#" class="wp-block-button__link button-mini open-modal-common" data-modal-title="' . get_the_title() . '" data-modal-button-text="' . $thirdPopupButtonText . '">' . $firstButtonText . '</a>';
		echo $fourthPageLinkBegin . $secondButtonText . '</a>';
		echo '</div>'; // .subcategory-list__item-buttons
		echo '</div>'; // .subcategory-list__item

	}

	wp_reset_postdata();

	// Выводим пагинацию
	if (function_exists("ly_pagination")) {
		ly_pagination($the_query->max_num_pages);
	}

	echo '</section>';
}
