<?php

/**
 * Template Name: Главная
 *
 * @package cabel
 * @author Yuriy Lysyuk
 * @since 1.0.0
 **/

// Выводим блок с цифрами
add_action('ly_content_area', 'ly_numbers_block');

// Выводим блок каталога со списком категорий
add_action('ly_content_area', 'ly_catalog_block');

// Выводим блок с видео
add_action('ly_content_area', 'ly_video_block');

// Выводим блок с отличиями
add_action('ly_content_area', 'ly_differences_block');

// Выводим блок с формой «Не нашли нужного товара?»
add_action('ly_content_area', 'ly_dont_find_block');

// Выводим блок с поставщиками
add_action('ly_content_area', 'ly_suppliers_block');

// Выводим блок с SEO-текстом
add_action('ly_content_area', 'ly_text_block');

// Remove all from structural wrap
add_theme_support('genesis-structural-wraps', []);

get_header();

do_action('ly_content_area');

get_footer();
