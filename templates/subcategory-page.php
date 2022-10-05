<?php

/**
 * Template Name: Подкатегория
 *
 * @package cabel
 * @author Yuriy Lysyuk
 * @since 1.0.0
 **/

// Выводим блок с хлебными крошками
add_action('ly_content_area', 'ly_breadcrumbs_block');

// Выводим блок со слайдером категорий
add_action('ly_content_area', 'ly_category_slider_block');

// Обертка для контента подкатегории (открывающая)
add_action('ly_content_area', 'ly_subcategory_content_wrap_open');

// Выводим блок с фильтром товаров в подкатегории
add_action('ly_content_area', 'ly_subcategory_filter_block');

// Выводим блок со списком товаров в подкатегории
add_action('ly_content_area', 'ly_subcategory_list_block');

// Обертка для контента подкатегории (закрывающая)
add_action('ly_content_area', 'ly_subcategory_content_wrap_close');

// Выводим блок с формой «Не нашли нужного товара?»
add_action('ly_content_area', 'ly_dont_find_block');

// Выводим блок с SEO-текстом
add_action('ly_content_area', 'ly_text_block');

// Remove all from structural wrap
add_theme_support('genesis-structural-wraps', []);

get_header();

do_action('ly_content_area');

get_footer();
