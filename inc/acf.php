<?php

/**
 * ACF Customizations
 *
 * @package      cabel
 * @author       Yuriy Lysyuk
 * @since        1.0.0
 **/



/**
 * Register Options Page
 *
 */
function ly_register_options_page()
{
	if (function_exists('acf_add_options_page')) {
		acf_add_options_page([
			'title' => 'Настройки темы',
			'capability' => 'manage_options',
		]);
	}
}
// Register options page
add_action('init', 'ly_register_options_page');


// Изменяем расположение сохранения настроек ACF Local JSON в /acf папку внутри темы
add_filter('acf/settings/save_json', function () {
	return get_stylesheet_directory() . '/acf';
});

// Включаем /acf папку в список мест, в которых ищутся файлы ACF Local JSON
add_filter('acf/settings/load_json', function ($paths) {
	// remove original path (optional)
	unset($paths[0]);

	$paths[] = get_stylesheet_directory() . '/acf';
	return $paths;
});

// хук для регистрации
add_action('init', 'product_category_taxonomy', 0);
function product_category_taxonomy()
{

	// список параметров: wp-kama.ru/function/get_taxonomy_labels
	register_taxonomy('product-category', ['product'], [
		'label'                 => '', // определяется параметром $labels->name
		'labels'                => [
			'name'              => 'Категории',
			'singular_name'     => 'Категория',
			'search_items'      => 'Поиск категорий',
			'all_items'         => 'Все категории',
			'view_item '        =>  'Просмотреть категорию',
			'parent_item'       => 'Родительская категория',
			'parent_item_colon' => 'Родительская категория:',
			'edit_item'         => 'Изменить категорию',
			'update_item'       => 'Обновить категорию',
			'add_new_item'      => 'Добавить новую категорию',
			'new_item_name'     => 'Название новой категории',
			'menu_name'         => 'Категории',
			'not_found' 				=> 'Категорий не найдено',
			'no_terms'					=> 'Категорий нет',
		],
		'description'           => 'Категории товаров', // описание таксономии
		'public'                => true,
		'hierarchical'          => true,
		'publicly_queryable' 		=> false,
		'query_var'         		=> true,
		'rewrite' => array('hierarchical' => true),
		'show_admin_column'     => true, // авто-создание колонки таксы в таблице ассоциированного типа записи. (с версии 3.5)
		'show_in_rest'          => true, // добавить в REST API
		// 'rest_base'             => null, // $taxonomy
	]);
}

// Регистрируем произвольный тип записи для марки
function product_post_type()
{
	$labels = [
		'name' => 'Товары',
		'singular_name' => 'Товар',
		'menu_name' => 'Товары',
		'name_admin_bar' => 'Товар',
		'archives' => 'Архивы товаров',
		'attributes' => 'Атрибуты товаров',
		'parent_item_colon' => 'Родительский товар',
		'all_items' => 'Все товары',
		'add_new_item' => 'Добавить новый товар',
		'add_new' => 'Добавить новый',
		'new_item' => 'Новый товар',
		'edit_item' => 'Редактировать товар',
		'update_item' => 'Обновить товар',
		'view_item' => 'Посмотреть товар',
		'view_items' => 'Посмотреть товары',
		'search_items' => 'Найти товары',
		'not_found' => 'Не найдено',
		'not_found_in_trash' => 'Не найдено в корзине',
		'featured_image' => 'Фото товара',
		'set_featured_image' => 'Установить фото товара',
		'remove_featured_image' => 'Удалить фото товара',
		'use_featured_image' => 'Использовать как фото товара',
		'insert_into_item' => 'Вставить в товар',
		'uploaded_to_this_item' => 'Загружено в этот товар',
		'items_list' => 'Список товаров',
		'items_list_navigation' => 'Навигация по списку товаров',
		'filter_items_list' => 'Фильтрация списка товаров',
	];
	$args = [
		'label' => 'Товар',
		'description' => 'Товар к продаже',
		'labels' => $labels,
		'supports' => ['title', 'thumbnail'],
		'hierarchical' => false,
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 5,
		'menu_icon' => 'dashicons-cart',
		'show_in_admin_bar' => false,
		'show_in_nav_menus' => false,
		'can_export' => true,
		'has_archive' => false,
		'exclude_from_search' => true,
		'publicly_queryable' => false,
		'capability_type' => 'page',
		'query_var'          => true,
		'rewrite' => false,
		'show_in_rest' => true,
		'taxonomies' => ['product-category'],

	];
	register_post_type('product', $args);
}
add_action('init', 'product_post_type', 0);
