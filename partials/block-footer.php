<?php

/**
 * Футер сайта
 *
 * @package cabel
 * @author Yuriy Lysyuk
 * @since 1.0.0
 **/

$block = get_field('footer', 'options');
$logo = get_field('logo', 'options');
$popupSettings = get_field('footer_popup', 'options');

if ($block) {
	echo '<footer class="site-footer">';
	echo '	<div class="wrap-grid">';
	echo '		<div class="footer__logo">';
	echo '			<a href="/">' . ($logo ? wp_get_attachment_image($logo, "full") : "Логотип") . '</a>';
	echo '			<div class="footer__logo-desc">' . $block['desc'] . '</div>';
	echo '		</div>'; // .footer__logo
	echo '		<a href="#" class="footer__button wp-block-button__link button-mini open-modal-common" data-modal-title="' . esc_html($popupSettings['title']) . '" data-modal-button-text="' . esc_html($popupSettings['button_text']) . '">' . esc_html($block['button_text']) . '</a>';
	echo '	</div>'; // wrap-grid
	echo '</footer>'; // .site-footer
}
