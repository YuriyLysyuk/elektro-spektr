<?php

/**
 * Блок с формой «Не нашли нужного товара?»
 *
 * @package cabel
 * @author Yuriy Lysyuk
 * @since 1.0.0
 **/

$blockDontFind = get_field('block_dont_find', 'options');

if ($blockDontFind) {

	echo ' <section class="dont-find">';
	echo '	<div class="wrap-grid">';
	echo '		<div class="h2">' . esc_html($blockDontFind['title']) . '</div>';
	echo '		<div class="h3 dont-find__desc">' . esc_html($blockDontFind['subtitle']) . '</div>';
	echo '		<form action="#" class="dont-find__form form-order">';
	echo '			<div class="wrap-grid">';
	echo '				<input type="text" class="dont-find__form-input" name="Имя" placeholder="' . esc_html($blockDontFind['placeholder_name']) . '">';
	echo '				<input type="tel" class="dont-find__form-input masked-phone" name="Телефон" placeholder="' . esc_html($blockDontFind['placeholder_phone']) . '" required>';
	echo '				<input type="text" class="dont-find__form-input" name="Email" placeholder="' . esc_html($blockDontFind['placeholder_comment']) . '">';
	echo '				<input type="hidden" name="Примечание" value="Не нашли нужного товара">';
	echo '				<button type="submit" class="wp-block-button__link button-mini dont-find__form-submit">' . esc_html($blockDontFind['button_text']) . '</button>';
	echo '			</div>';
	echo '		</form>';
	echo '		<div class="dont-find__politics">' . $blockDontFind['privacy_text'] . '</div>';
	echo '	</div>';
	echo '</section>';
}
