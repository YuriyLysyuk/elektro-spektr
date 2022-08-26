<?php

/**
 * Page
 *
 * @package cabel
 * @author Yuriy Lysyuk
 * @since 1.0.0
 **/

// Добавляем обертку для контента
add_theme_support('genesis-structural-wraps', []);

// Выводим блок с хлебными крошками
add_action('ly_content_area', 'ly_breadcrumbs_block');

// Выводим блок с поиском
add_action('ly_content_area', 'ly_search_block');

// Выводим блок с формой «Не нашли нужного товара?»
add_action('ly_content_area', 'ly_dont_find_block');

get_header();

do_action('ly_content_area');

get_footer();
