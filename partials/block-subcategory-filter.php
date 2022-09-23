<?php

/**
 * Блок с фильтром товаров в подкатегории
 *
 * @package cabel
 * @author Yuriy Lysyuk
 * @since 1.0.0
 **/

//  Показываем только на странице подкатегории
if (!is_page_template('templates/subcategory-page.php')) {
	return;
}

// Инициализируем фильтр и глобальную переменную
init_subcategory_filter();

// Вытаскиваем переменные из глобальной
$postID = $GLOBALS['subcategory_filter']['postID'];

// Обнуляем фильтр
$filter = [];
// Загружаем фильтр для текущей страницы если он есть
if ($GLOBALS['subcategory_filter']['filter']) {
	$filter = $GLOBALS['subcategory_filter']['filter'];
}

// Если фильтр получен
if ($filter) {

	$block = get_field('block_subcategory_filter', 'options');

	echo '<aside class="subcategory-filter">';
	echo '	<div class="h3">' . esc_html($block['title']) . '</div>';

	echo '	<div class="subcategory-filter__tabs">';
	echo '	<form action="' . site_url() . '/wp-admin/admin-ajax.php" method="POST" id="filter">';
	foreach ($filter['sub_fields'] as $param) {
		// Собираем в массив значения параметра из урла
		$getValues = [];
		if (isset($_GET[$param['name']])) {
			$getValues = explode(',', $_GET[$param['name']]);
		}


		// Устанавляваем расскрытие таба, есть ли отметка на каком либо параметре внутри
		// HTML вариантов
		$choicesHtml = '';
		// Отметка раскрытия таба
		$tabChecked = '';
		// Обрабатываем варианты параметра
		foreach ($param['choices'] as $key => $value) {
			// Отмечен ли текущий параметр
			$paramChecked = '';
			if (in_array($key, $getValues)) {
				// Если есть — расскрываем таб
				$tabChecked = $paramChecked = ' checked="checked"';
			}
			$paramID = $param['key'] . '_' . $key;
			$choicesHtml .= '<label class="subcategory-filter__tab-param" for="' . $paramID . '">' . esc_html($value);
			$choicesHtml .= '	<input type="checkbox" name="' . $param['name'] . '" value="' . $key . '" id="' . $paramID . '"' . $paramChecked . '>';
			$choicesHtml .= '	<span class="subcategory-filter__tab-param-checkmark"></span>';
			$choicesHtml .= '</label>';
		}

		echo '		<div class="subcategory-filter__tab">';
		echo '			<input type="checkbox" id="' . $param['key'] . '"' . $tabChecked . '>';
		echo '			<label class="subcategory-filter__tab-label" for="' . $param['key'] . '">' . esc_html($param['label']) . '</label>';
		echo '			<div class="subcategory-filter__tab-content">';
		echo $choicesHtml;
		echo '			</div>'; // .subcategory-filter__tab-content
		echo '		</div>'; // .subcategory-filter__tab
	}
	echo '		<div class="filter-notification__wrap">';
	echo '			<div class="filter-notification iziToast-target"></div>';
	echo '		</div>'; // .filter-notification__wrap
	// Скрытое поле указывает на то, какую функцию использовать для обработки
	echo '		<input type="hidden" name="ly_post_id" value="' . $postID . '">';
	// Скрытое поле указывает на то, какую функцию использовать для обработки
	echo '		<input type="hidden" name="action" value="ly_filter">';
	echo '	</form>';
	echo '	</div>'; // .subcategory-filter__tabs
	echo '	<div class="subcategory-filter__reset"><a href="' . get_the_permalink() . '"><i class="fas fa-times"></i> Сбросить</a></div>';
	echo '</aside>';
}
