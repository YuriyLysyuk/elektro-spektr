<?php

/**
 * Пагинация
 *
 * @package      cabel
 * @author       Yuriy Lysyuk
 * @since        1.0.0
 **/

function ly_pagination($pages = '')
{
	// Настройки блока
	$blockSettings = get_field('block_subcategory_list', 'options');
	$range = 4;
	$showitems = $blockSettings['product_per_page'];

	global $paged;
	if (empty($paged)) $paged = 1;
	if ($pages == '') {
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if (!$pages) {
			$pages = 1;
		}
	}
	if (1 != $pages) {
		echo '	<div class="subcategory-list__pagination">';
		if ($paged > 1 && $showitems < $pages) echo '<a class="prev page-numbers" href="' . get_pagenum_link($paged - 1) . '#content"><i class="fas fa-arrow-left"></i></a> ';
		for ($i = 1; $i <= $pages; $i++) {
			if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems)) {
				echo ($paged == $i) ? '<span class="current">' . $i . '</span> ' : '<a class="page-numbers" href="' . get_pagenum_link($i) . '#content">' . $i . '</a> ';
			}
		}
		if ($paged < $pages && $showitems < $pages) echo ' <a class="next page-numbers" href="' . get_pagenum_link($paged + 1) . '#content"><i class="fas fa-arrow-right"></i></a> ';
		echo "</div>\n";
	}
}
