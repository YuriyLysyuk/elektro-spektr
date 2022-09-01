<?php

/**
 * Блок с цифрами
 *
 * @package cabel
 * @author Yuriy Lysyuk
 * @since 1.0.0
 **/

$blockNumbers = get_field('block_numbers', 'options');

if ($blockNumbers) {
	echo ' <section class="numbers">';
	echo '	<div class="wrap-grid">';
	echo '		<div class="numbers__item">';
	echo '			<div class="h3">' .  esc_html($blockNumbers['item_1_number']) . ' <span>' . esc_html($blockNumbers['item_1_title']) . '</span></div>';
	echo '			<p>' . $blockNumbers['item_1_desc'] . '</p>';
	echo '		</div>';
	echo '		<div class="numbers__item">';
	echo '			<div class="h3">' .  esc_html($blockNumbers['item_2_number']) . ' <span>' . esc_html($blockNumbers['item_2_title']) . '</span></div>';
	echo '			<p>' . $blockNumbers['item_2_desc'] . '</p>';
	echo '		</div>';
	echo '		<div class="numbers__item">';
	echo '			<div class="h3">' .  esc_html($blockNumbers['item_3_number']) . ' <span>' . esc_html($blockNumbers['item_3_title']) . '</span></div>';
	echo '			<p>' . $blockNumbers['item_3_desc'] . '</p>';
	echo '		</div>';
	echo '	</div>';
	echo '</section>';
}
