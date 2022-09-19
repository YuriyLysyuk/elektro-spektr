<?php

/**
 * Плавающий блок с контактами
 *
 * @package cabel
 * @author Yuriy Lysyuk
 * @since 1.0.0
 **/

$block = get_field('slick_line', 'options');
$popupSettings = get_field('slick_line_popup', 'options');
$phoneLink = get_field('phone_link', 'options');
$phoneView = get_field('phone_view', 'options');

if ($block) {
	echo '<section class="slick-line-footer">';
	echo '	<div class="wrap">';
	echo '		<div class="slick-line__text">';
	echo '		<a href="#" class="open-modal-common" data-modal-title="' . esc_html($popupSettings['title']) . '" data-modal-button-text="' . esc_html($popupSettings['button_text']) . '">' . esc_html($block['button_text']) . '</a> ';
	echo $block['desc'];
	echo '		<a href="tel:' . $phoneLink . '">' . $phoneView . '</a>';
	echo '		</div>'; // .slick-line__text
	echo '	</div>'; // .wrap
	echo '</section>'; // .site-footer
}


// <section class="slick-line">
// 	<div class="wrap">
// 		<div class="slick-line__text"><a href="#" class="open-modal-common" data-modal-title="Закажите звонок"
// 				data-modal-button-text="Заказать звонок">Закажите звонок</a> и получите расчет стоимости продукции через 8
// 			минут.
// 			Звоните: <a href="tel:74957995153">8 (495) 799-51-53</a></div>
// 	</div>
// </section>
