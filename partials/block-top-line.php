<?php

/**
 * Верхнее меню сайта
 *
 * @package cabel
 * @author Yuriy Lysyuk
 * @since 1.0.0
 **/

echo '<div class="top-line">';
echo '	<div class="wrap-grid">';

$logo = get_field('logo', 'options');
echo '		<a href="/" class="top-line__logo">' . ($logo ? wp_get_attachment_image($logo, "full") : "Логотип") . '</a>';

$phoneLink = get_field('phone_link', 'options');
$phoneView = get_field('phone_view', 'options');
echo '		<div class="top-line__phone-wrap">';
echo '			<a class="top-line__phone" href="tel:' . $phoneLink . '"><i class="fas fa-phone-alt"></i> ' . $phoneView . '</a>';

$callback = get_field('callback', 'options');
$callbackName = get_field('callback_name', 'options');
echo '			<a href="#" class="top-line__callback open-modal-common" data-modal-title="' . esc_html($callback['popup_title']) . '" data-modal-button-text="' . esc_html($callback['popup_button']) . '">' . esc_html($callbackName) . '</a>';

echo '		</div>';
echo '		<form action="' . esc_url(home_url('/')) . '" role="search" method="get" class="top-line__search-form">';
echo '			<input type="text" class="search-form__input" placeholder="Поиск по каталогу" value="' . get_search_query() . '" name="s" />';
echo '			<button type="submit" class="search-form__button"></button>';
echo '		</form>';
echo '		<button class="top-line__toggle" onclick="this.classList.toggle(\'top-line__toggle-opened\');this.setAttribute(\'aria-expanded\', this.classList.contains(\'opened\'))" aria-label="Главное меню">';
echo '			<svg class="toggle__svg" width="100" height="100" viewBox="0 0 100 100">';
echo '				<path class="toggle__line toggle__line-1" d="M 20,29.000046 H 80.000231 C 80.000231,29.000046 94.498839,28.817352 94.532987,66.711331 94.543142,77.980673 90.966081,81.670246 85.259173,81.668997 79.552261,81.667751 75.000211,74.999942 75.000211,74.999942 L 25.000021,25.000058" />';
echo '				<path class="toggle__line toggle__line-2" d="M 20,50 H 80" />';
echo '				<path class="toggle__line toggle__line-3" d="M 20,70.999954 H 80.000231 C 80.000231,70.999954 94.498839,71.182648 94.532987,33.288669 94.543142,22.019327 90.966081,18.329754 85.259173,18.331003 79.552261,18.332249 75.000211,25.000058 75.000211,25.000058 L 25.000021,74.999942" />';
echo '			</svg>';
echo '		</button>';

if (have_rows('menu', 'options')) {
	echo '		<nav class="top-line__menu">';
	while (have_rows('menu', 'options')) {
		the_row();
		$menuName = get_sub_field('name');
		$menuIsPopup = get_sub_field('is_popup');

		if ($menuIsPopup) {
			$menuUrl = "#";
			$menuPopupTitle = get_sub_field('popup_title');
			$menuPopupButton = get_sub_field('popup_button');
			echo '<a href="' . esc_url($menuUrl) . '" class="open-modal-common" data-modal-title="' . esc_html($menuPopupTitle) . '" data-modal-button-text="' . esc_html($menuPopupButton) . '">' . esc_html($menuName) . '</a>';
		} else {
			$menuUrl = get_sub_field('url');
			echo '<a href="' . esc_url($menuUrl) . '">' . esc_html($menuName) . '</a>';
		}
	}
	echo '		</nav>';
}

echo '	</div>'; // wrap-grid
echo '</div>'; // top-line
echo '<div class="top-line-placeholder"></div>';
