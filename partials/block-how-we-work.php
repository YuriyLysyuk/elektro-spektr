<?php

/**
 * Блок «Как мы работаем»
 *
 * @package cabel
 * @author Yuriy Lysyuk
 * @since 1.0.0
 **/

$block = get_field('block_how_we_work', 'options');
$items = $block['items'];

if ($block && $items) {

	echo ' <section class="how-we-work">';
	echo '	<div class="wrap-grid">';
	echo '		<div class="h2">' . esc_html($block['title']) . '</div>';
	foreach ($items as $item) {
		echo '<div class="how-we-work__item">';
		echo '	<i class="fas ' . esc_html($item['icon']) . '"></i>';
		echo '	<p>' . esc_html($item['title']) . '</p>';
		echo '	<p class="desc">' . esc_html($item['desc']) . '</p>';
		echo '</div>';
	}
	echo '	</div>';
	echo '</section>';
}
