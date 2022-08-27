<?php

/**
 * Subcategory filter functions
 *
 * @package      cabel
 * @author       Yuriy Lysyuk
 * @since        1.0.0
 **/

// Константа с массивом всех доступных фильтров (field key => field name)
define('SUBCATEGORY_FILTERS', serialize([
	// Кабельная продукция
	'5'	=> [
		'field_key' => 'field_6047a4c88944c',
		'field_name' => 'subcategory_filter_cable',
	]
]));

function init_subcategory_filter($post_id = false)
{
	// Обнуляем текущий фильтр
	$GLOBALS['subcategory_filter'] = [];

	// Получаем массив фильтров из константы
	$subcategoryFilters = unserialize(SUBCATEGORY_FILTERS);

	if ($post_id === false) {
		global $post;
		// Получаем ID текущей страницы
		$currentPageID = $post->ID;
	} else {
		$currentPageID = $post_id;
	}

	// Определяем текущую категорию
	$currentCategory = get_terms([
		'taxonomy'   => 'product-category',
		'hide_empty' => false,
		'number'     => 1,
		'meta_query' => [
			[
				'key' => 'product_category_rel_page_id',
				'value' => '"' . $currentPageID . '"',
				'compare' => 'LIKE',
			],
		]
	]);
	// Получаем ID родительской категории
	$parentCategoryID = $currentCategory[0]->parent;

	// Получаем имя фильтра в ACF
	$filterACFField = $subcategoryFilters[$parentCategoryID]['field_key'];
	// Загружаем фильтр для текущей страницы если он есть
	if ($filterACFField) {
		$filter = get_field_object($filterACFField, false, false);
	}

	if ($filter) {
		$GLOBALS['subcategory_filter'] = [
			'postID' => $currentPageID,
			'categoryID' => $currentCategory[0]->term_id,
			'parentCategoryID' => $parentCategoryID,
			'filterACFField' => $subcategoryFilters[$parentCategoryID],
			'filterSubFieldsPrefix' => 'subcategory_filter' . '_' . $filter['name'], // Имя группы полей, где находятся все фильтры
			'filter' => $filter,
			'filterSubFields' => $filter['sub_fields'],
		];
	}
}

function ly_get_products($global_post = [])
{
	// print_r($global_post);
	// Инициализируем фильтр и глобальную переменную
	if (!isset($GLOBALS['subcategory_filter'])) {
		init_subcategory_filter();
	}

	// Вытаскиваем переменные из глобальной
	$categoryID = $GLOBALS['subcategory_filter']['categoryID'];
	$filterSubFields  = $GLOBALS['subcategory_filter']['filterSubFields'];

	// Устанавливаем отношение фильтра
	$metaQuery = [
		'relation' => 'AND',
	];

	foreach ($filterSubFields as $param) {
		// Собираем в массив значения параметра из урла
		$getValues = [];

		// Обнуляем собранные значения
		$metaValues = [];
		// И составляем уточнение запроса, заданных фильтром
		foreach ($param['choices'] as $key => $value) {
			// 
			if (wp_doing_ajax() && $global_post) {
				// это AJAX запрос
				if (isset($global_post[$param['name']])) {
					// print_r($param['name']);
					$getValues = explode(',', $global_post[$param['name']]);
					// print_r($getValues);
				}
			} else {
				if (isset($_GET[$param['name']])) {
					$getValues = explode(',', $_GET[$param['name']]);
				}
			}
			if (in_array($key, $getValues)) {
				$metaValues[] = $key;
			}
		}


		if ($metaValues) {
			// print_r($metaValues);
			$metaQuery[] = [
				'key' => $GLOBALS['subcategory_filter']['filterSubFieldsPrefix'] . '_' . $param['name'],
				'value' => $metaValues,
				'compare'	=> 'IN'
			];
			// print_r($metaQuery);
		}
	}

	// Настройки блока
	$blockSettings = get_field('block_subcategory_list', 'options');
	// Текущая страница
	$paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;

	// Запрашиваем продукты
	$query = new WP_Query([
		'post_type'      => 'product',
		'orderby'     => 'date',
		'order'       => 'DESC',
		'post_status' => 'publish',
		'tax_query' => [
			[
				'taxonomy' => 'product-category',
				'field' => 'term_id',
				'terms' => $categoryID,
			]
		],
		'meta_query' => $metaQuery,
		'posts_per_page' => (int) $blockSettings['product_per_page'],
		'paged'          => $paged,
	]);

	return $query;
}

add_action('wp_ajax_ly_filter', 'ly_get_product_count'); // wp_ajax_{ACTION HERE} 
add_action('wp_ajax_nopriv_ly_filter', 'ly_get_product_count');

function ly_get_product_count()
{
	if (!$_POST['ly_post_id']) {
		wp_die();
	}

	// Инициализируем фильтр и глобальную переменную
	init_subcategory_filter($_POST['ly_post_id']);

	$query = ly_get_products($_POST);

	echo intval($query->found_posts);


	wp_die();
}

/**
 * Получает термин верхнего уровня, для указанного или текущего поста в цикле.
 *
 * @param  string      $taxonomy  Название таксономии
 * @param  int/object  $post_id   ID или объект поста
 *
 * @return string/wp_error Объект термина или false
 */
function ly_get_top_term($taxonomy, $post_id = 0)
{
	if (isset($post_id->ID)) $post_id = $post_id->ID;
	if (!$post_id)          $post_id = get_the_ID();

	$terms = get_the_terms($post_id, $taxonomy);

	if (!$terms || is_wp_error($terms))
		return $terms;

	// только первый
	$term = array_shift($terms);

	// найдем ТОП
	$parent_id = $term->parent;
	while ($parent_id) {
		$term = get_term_by('id', $parent_id, $term->taxonomy);
		$parent_id = $term->parent;
	}

	return $term;
}
