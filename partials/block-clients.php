<?php

/**
 * Блок с клиентами
 *
 * @package cabel
 * @author Yuriy Lysyuk
 * @since 1.0.0
 **/

$block = get_field('block_clients', 'options');
$items = $block['items'];

if ($block && $items) {

	echo ' <section class="suppliers">';
	echo '	<div class="wrap-grid">';
	echo '		<div class="h2">' . esc_html($block['title']) . '</div>';
	foreach ($items as $item) {
		echo '	<div class="suppliers__item">';
		echo wp_get_attachment_image($item['img'], 'full');
		echo '	</div>';
	}
	echo '	</div>';
	echo '</section>';
}
