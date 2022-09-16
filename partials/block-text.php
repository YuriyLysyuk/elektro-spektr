<?php

/**
 * Блок с SEO-текстом
 *
 * @package cabel
 * @author Yuriy Lysyuk
 * @since 1.0.0
 **/

global $post;
// Получаем ID текущей страницы
$currentPageID = $post->ID;

$block = [
	'title' => get_field('seo-title', $currentPageID),
	'content' => get_field('seo-content', $currentPageID),
];

if ($block && $block['title'] && $block['content']) {
	echo ' <section class="text">';
	echo '	<div class="wrap">';
	echo '		<h1>' . $block['title'] . '</h1>';
	echo $block['content'];
	echo '	</div>';
	echo '</section>';
}
