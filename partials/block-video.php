<?php

/**
 * Блок с цифрами
 *
 * @package cabel
 * @author Yuriy Lysyuk
 * @since 1.0.0
 **/

$blockVideo = get_field('block_video', 'options');
$popupSettings = get_field('block_video_popup', 'options');

if ($blockVideo && $blockVideo['link']) {
	echo ' <section class="video">';
	echo '	<div class="wrap-grid">';
	echo '		<div class="video__youtube">';
	echo '			<iframe width="560" height="315" src="' . esc_url($blockVideo['link']) . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
	echo '		</div>';
	echo '		<div class="video__text">';
	echo '			<div class="h3">' . esc_html($blockVideo['title']) . '</div>';
	echo '			<p>' . esc_html($blockVideo['desc']) . '</p>';
	echo '			<p><strong>' . esc_html($blockVideo['advantages']) . '</strong></p>';
	echo '			<div class="video__button">';
	echo '				<a href="#" class="wp-block-button__link open-modal-common" data-modal-title="' . esc_html($popupSettings['title']) . '" data-modal-button-text="' . esc_html($popupSettings['button_text']) . '">' . esc_html($blockVideo['button_text']) . '</a>';
	echo '			</div>';
	echo '		</div>';
	echo '</section>';
}
