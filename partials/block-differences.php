<?php

/**
 * Блок с отличиями
 *
 * @package cabel
 * @author Yuriy Lysyuk
 * @since 1.0.0
 **/

$blockDifferences = get_field('block_differences', 'options');
$items = $blockDifferences['items'];

if ($blockDifferences && $items) {

	echo ' <section class="differences">';
	echo '	<div class="wrap-grid">';
	echo '		<div class="h2">' . esc_html($blockDifferences['title']) . '</div>';
	foreach ($items as $item) {
		echo '<div class="differences__item">';
		echo '	<i class="fas ' . esc_html($item['icon']) . '"></i>';
		echo '	<p>' . esc_html($item['desc']) . '</p>';
		echo '</div>';
	}
	echo '	</div>';
	echo '</section>';
}
