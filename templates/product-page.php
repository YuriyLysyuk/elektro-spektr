<?php

/**
 * Template Name: Продукт
 *
 * @package cabel
 * @author Yuriy Lysyuk
 * @since 1.0.0
 **/

// Выводим блок с хлебными крошками
add_action('ly_content_area', 'ly_breadcrumbs_block');

// Выводим блок с информацией о товаре
add_action('ly_content_area', 'ly_product_content_block');

// Выводим блок с формой «Не нашли нужного товара?»
add_action('ly_content_area', 'ly_dont_find_block');

// Выводим блок с SEO-текстом
add_action('ly_content_area', 'ly_text_block');

// Remove all from structural wrap
add_theme_support('genesis-structural-wraps', []);

get_header();

do_action('ly_content_area');

get_footer();
