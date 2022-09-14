<?php

/**
 * Блоки с контентом
 *
 * @package      cabel
 * @author       Yuriy Lysyuk
 * @since        1.0.0
 **/

// Блок с верхним меню
function ly_top_line_block()
{
	get_template_part('partials/block', 'top-line');
}

// Блок с верхним слайдером
function ly_top_slider_block()
{
	get_template_part('partials/block', 'top-slider');
}

// Блок с цифрами
function ly_numbers_block()
{
	get_template_part('partials/block', 'numbers');
}

// Блок с хлебными крошками
function ly_breadcrumbs_block()
{
	get_template_part('partials/block', 'breadcrumbs');
}

// Блок со слайдером категорий
function ly_category_slider_block()
{
	get_template_part('partials/block', 'category-slider');
}

// Блок с модальными окнами
function ly_modal_block()
{
	get_template_part('partials/block', 'modal');
}

// Блок каталога со списком категорий
function ly_catalog_block()
{
	get_template_part('partials/block', 'catalog');
}

// Блок с видео
function ly_video_block()
{
	get_template_part('partials/block', 'video');
}

// Блок с отличиями
function ly_differences_block()
{
	get_template_part('partials/block', 'differences');
}

// Блок с формой «Не нашли нужного товара?»
function ly_dont_find_block()
{
	get_template_part('partials/block', 'dont-find');
}

