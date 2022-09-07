<?php

/**
 * Блок с модальными окнами
 *
 * @package cabel
 * @author Yuriy Lysyuk
 * @since 1.0.0
 **/

$blockModal = get_field('block_modal', 'options');


echo '<div id="modal-common" class="modal-common" data-iziModal-subtitle="' . esc_html($blockModal['subtitle']) . '">';
echo '	<div class="message-row">';
echo '		<div class="message message--recieved">';
echo '			<div class="message-avatar">';
echo wp_get_attachment_image($blockModal['avatar'], "full");
echo '			</div>';
echo '			<div class="message-bubble">';
echo '				<p>' . esc_html($blockModal['avatar_text']) . '</p>';
echo '			</div>';
echo '		</div>';
echo '	</div>';
echo '	<form class="modal-common__form form-order" action="#">';
echo '		<input type="text" class="" name="Имя" placeholder="' . esc_html($blockModal['placeholder_name']) . '">';
echo '		<input type="tel" class="masked-phone" name="Телефон" placeholder="' . esc_html($blockModal['placeholder_phone']) . '" required>';
echo '		<input type="text" class="" name="Комментарий" placeholder="' . esc_html($blockModal['placeholder_comment']) . '">';

echo '		<input type="hidden" class="modal-common__what" name="Примечание" value="">';

echo '		<button type="submit" class="wp-block-button__link button-mini modal-common__button">Получить&nbsp;консультацию</button>';

echo '		<div class="privacy-text">' . $blockModal['privacy_text'] . '</div>';
echo '	</form>';
echo '</div>';

$modalThankyou = get_field('modal_thankyou', 'options');

echo '<div id="modal-thankyou" class="modal-thankyou" data-iziModal-title="' . esc_html($modalThankyou['title']) . '" data-iziModal-subtitle="' . esc_html($modalThankyou['subtitle']) . '"></div>';
