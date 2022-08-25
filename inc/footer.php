<?php

/**
 * Footer
 *
 * @package      cabel
 * @author       Yuriy Lysyuk
 * @since        1.0.0
 **/

// Remove genesis footer
remove_action('genesis_before_footer', 'genesis_footer_widget_areas');
remove_action('genesis_footer', 'genesis_footer_markup_open', 5);
remove_action('genesis_footer', 'genesis_do_footer');
remove_action('genesis_footer', 'genesis_footer_markup_close', 15);

// Выводим блок с футером
add_action('genesis_footer', 'ly_footer_block');

// Выводим плавающий блок с контактами
add_action('genesis_after_footer', 'ly_slick_line_block');

// Выводим блок с модальными окнами
add_action('genesis_after_footer', 'ly_modal_block');
