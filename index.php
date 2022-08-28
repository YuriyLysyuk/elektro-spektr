<?php

/**
 * Index
 *
 * @package cabel
 * @author Yuriy Lysyuk
 * @since 1.0.0
 **/

// Добавляем обертку для контента
add_theme_support('genesis-structural-wraps', ['site-inner']);

// Выводим блок с хлебными крошками
add_action('ly_before_site_inner_wrap', 'ly_breadcrumbs_block');

// Initialize Genesis.
genesis();
