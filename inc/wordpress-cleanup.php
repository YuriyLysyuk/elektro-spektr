<?php

/**
 * WordPress Cleanup
 *
 * @package      cabel
 * @author       Yuriy Lysyuk
 * @since        1.0.0
 **/

/**
 * Dont Update the Theme
 *
 * If there is a theme in the repo with the same name, this prevents WP from prompting an update.
 *
 * @since  1.0.0
 * @author Bill Erickson
 * @link   http://www.billerickson.net/excluding-theme-from-updates
 * @param  array $r Existing request arguments
 * @param  string $url Request URL
 * @return array Amended request arguments
 */
function ea_dont_update_theme($r, $url)
{
	if (0 !== strpos($url, 'https://api.wordpress.org/themes/update-check/1.1/'))
		return $r; // Not a theme update request. Bail immediately.
	$themes = json_decode($r['body']['themes']);
	$child = get_option('stylesheet');
	unset($themes->themes->$child);
	$r['body']['themes'] = json_encode($themes);
	return $r;
}
add_filter('http_request_args', 'ea_dont_update_theme', 5, 2);

/**
 * Clean Nav Menu Classes
 *
 */
function ea_clean_nav_menu_classes($classes)
{
	if (!is_array($classes))
		return $classes;

	foreach ($classes as $i => $class) {

		// Remove class with menu item id
		$id = strtok($class, 'menu-item-');
		if (0 < intval($id))
			unset($classes[$i]);

		// Remove menu-item-type-*
		if (false !== strpos($class, 'menu-item-type-'))
			unset($classes[$i]);

		// Remove menu-item-object-*
		if (false !== strpos($class, 'menu-item-object-'))
			unset($classes[$i]);

		// Change page ancestor to menu ancestor
		if ('current-page-ancestor' == $class) {
			$classes[] = 'current-menu-ancestor';
			unset($classes[$i]);
		}
	}

	// Remove submenu class if depth is limited
	if (isset($args->depth) && 1 === $args->depth) {
		$classes = array_diff($classes, array('menu-item-has-children'));
	}

	return $classes;
}
add_filter('nav_menu_css_class', 'ea_clean_nav_menu_classes', 5);

/**
 * Убираем атрибуты type у загружаемых стилей и скриптов
 *
 */
function rko_remove_type_attr($tag, $handle)
{
	return preg_replace("/type=['\"]text\/(javascript|css)['\"]/", '', $tag);
}
add_filter('style_loader_tag', 'rko_remove_type_attr', 10, 2);
add_filter('script_loader_tag', 'rko_remove_type_attr', 10, 2);

/**
 *  Disable emoji
 */
function rko_disable_emojis()
{
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('admin_print_styles', 'print_emoji_styles');
	remove_filter('the_content_feed', 'wp_staticize_emoji');
	remove_filter('comment_text_rss', 'wp_staticize_emoji');
	remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

	add_filter('tiny_mce_plugins', 'rko_disable_emojis_tinymce');
	add_filter('wp_resource_hints', 'rko_disable_emojis_remove_dns_prefetch', 10, 2);
}
add_action('init', 'rko_disable_emojis');

function rko_disable_emojis_tinymce($plugins)
{
	if (is_array($plugins)) {
		return array_diff($plugins, array('wpemoji'));
	} else {
		return array();
	}
}

function rko_disable_emojis_remove_dns_prefetch($urls, $relation_type)
{
	if ('dns-prefetch' == $relation_type) {
		/** This filter is documented in wp-includes/formatting.php */
		$emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/11/svg/');
		$urls = array_diff($urls, array($emoji_svg_url));

		$emoji_url = apply_filters('emoji_url', 'https://s.w.org/images/core/emoji/11/72x72/');
		$urls = array_diff($urls, array($emoji_url));
	}

	return $urls;
}

// Disable WP-API версий 1.x
add_filter('json_enabled', '__return_false');
add_filter('json_jsonp_enabled', '__return_false');

// Delete oembed links from head section
remove_action('wp_head', 'wp_oembed_add_discovery_links');

// If you want display oembed from other sites to your site, please comment next line
remove_action('wp_head', 'wp_oembed_add_host_js');

/**
 * Clean WP head
 */
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
remove_action('wp_head', 'wp_shortlink_wp_head', 10);


add_filter('wp_headers', 'pmg_kt_filter_headers', 10, 1);
function pmg_kt_filter_headers($headers)
{
	unset($headers['X-Pingback']);
	return $headers;
}

// Kill the rewrite rule
add_filter('rewrite_rules_array', 'pmg_kt_filter_rewrites');
function pmg_kt_filter_rewrites($rules)
{
	foreach ($rules as $rule => $rewrite) {
		if (preg_match('/trackback\/\?\$$/i', $rule)) {
			unset($rules[$rule]);
		}
	}
	return $rules;
}

// Kill bloginfo( 'pingback_url' )
add_filter('bloginfo_url', 'pmg_kt_kill_pingback_url', 10, 2);
function pmg_kt_kill_pingback_url($output, $show)
{
	if ($show == 'pingback_url') {
		$output = '';
	}
	return $output;
}

// remove RSD link
remove_action('wp_head', 'rsd_link');

// hijack options updating for XMLRPC
add_filter('pre_update_option_enable_xmlrpc', '__return_false');
add_filter('pre_option_enable_xmlrpc', '__return_zero');

add_filter('xmlrpc_enabled', '__return_false');

// Disable XMLRPC call
add_action('xmlrpc_call', 'pmg_kt_kill_xmlrpc');
function pmg_kt_kill_xmlrpc($action)
{
	if ('pingback.ping' === $action) {
		wp_die(
			'Pingbacks are not supported',
			'Not Allowed!',
			array('response' => 403)
		);
	}
}

/**
 * Remove wrong work metods XML-RPC Pingback
 */

function rko_block_xmlrpc_attacks($methods)
{
	unset($methods['pingback.ping']);
	unset($methods['pingback.extensions.getPingbacks']);
	return $methods;
}
add_filter('xmlrpc_methods', 'rko_block_xmlrpc_attacks');
