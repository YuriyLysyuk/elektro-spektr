<?php

/**
 * Template Name: Категория
 *
 * @package cabel
 * @author Yuriy Lysyuk
 * @since 1.0.0
 **/

// Выводим блок с хлебными крошками
add_action('ly_content_area', 'ly_breadcrumbs_block');

// Выводим блок со слайдером категорий
add_action('ly_content_area', 'ly_category_slider_block');

// Выводим блок каталога со списком категорий
add_action('ly_content_area', 'ly_catalog_block');

// Выводим блок «Как мы работаем»
add_action('ly_content_area', 'ly_how_we_work_block');

// Выводим блок с формой «Не нашли нужного товара?»
add_action('ly_content_area', 'ly_dont_find_block');

// Выводим блок с клиентами
// add_action('ly_content_area', 'ly_clients_block');

// Выводим блок с SEO-текстом
add_action('ly_content_area', 'ly_text_block');

// Remove all from structural wrap
add_theme_support('genesis-structural-wraps', []);

get_header();

do_action('ly_content_area');

get_footer();
