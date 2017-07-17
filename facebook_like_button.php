<?php
/*
Plugin Name: Facebook Like Button by kms
Description: WordPress bővítmény a Facebook tetszik (ajánlom) gomb elhelyezésére. Megjeleníthető bejegyzés előtt, után, illetve az írások mellett bal oldalon úsztatva is.
Author: Miko Andras
Author URI: http://mikoandras.hu/en/
Plugin URI: http://mikoandras.hu/en/2011/09/12/wordpress-facebook-like-button/
Version: 1.2.0
License: GPL
*/
/*
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License version 2, 
    as published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
*/

if (! function_exists('is_admin')) {
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit();
}
/* Runs when plugin is activated */
register_activation_hook(__FILE__, 'facebook_like_install'); 
/* Runs on plugin deactivation*/
register_deactivation_hook(__FILE__, 'facebook_like_remove');
/* Register database fields */
function facebook_like_install () {
	add_option('km_fbl_button_caption', 'like', '', 'yes');
	add_option('km_fbl_button_layout', 'standard', '', 'yes');
	add_option('km_fbl_button_location', 'bottom', '', 'yes');
	add_option('km_fbl_button_version', 'iframe', '', 'yes');
	add_option('km_fbl_color_scheme', 'light', '', 'yes');
	add_option('km_fbl_extra_style', 'margin: 4px;', '', 'yes');
	add_option('km_fbl_left_space', '', '', 'yes');
	add_option('km_fbl_position', 'fixed', '', 'yes');
	add_option('km_fbl_script_load', 'true', '', 'yes');
	add_option('km_fbl_show_faces', 'true', '', 'yes');
	add_option('km_fbl_show_share', 'false', '', 'yes');
	add_option('km_fbl_show_on_home', 'false', '', 'yes');
	add_option('km_fbl_show_on_single', 'false', '', 'yes');
	add_option('km_fbl_top_space', '', '', 'yes');
	add_option('km_fbl_language', '', '', 'en_US');
}
/* Drop database fields */
function facebook_like_remove () {
	delete_option('km_fbl_button_caption');
	delete_option('km_fbl_button_layout');
	delete_option('km_fbl_button_location');
	delete_option('km_fbl_button_version');
	delete_option('km_fbl_color_scheme');
	delete_option('km_fbl_extra_style');
	delete_option('km_fbl_left_space');
	delete_option('km_fbl_position');
	delete_option('km_fbl_script_load');
	delete_option('km_fbl_show_faces');
	delete_option('km_fbl_show_share');
	delete_option('km_fbl_show_on_home');
	delete_option('km_fbl_show_on_single');
	delete_option('km_fbl_top_space');
	delete_option('km_fbl_language');
}
// Add the google plus one js library
function enqueue_km_fbl_scripts () {
	global $locale;
	wp_enqueue_script('facebooklike' . $locale, 'http://connect.facebook.net/' . $locale . '/all.js#xfbml=1');
}
// insert facebook script parent
function facebook_like_insert_div () {
	echo "<div id=\"fb-root\"></div>\n";
}
add_action('wp_footer', 'facebook_like_insert_div');
if (is_admin()) {
	$plugin_dir = dirname(plugin_basename(__FILE__));
	load_plugin_textdomain('facebook_like_button_by_kms', false, $plugin_dir . '/languages');
	require_once('fbl_admin_page.php');
	add_action('admin_menu', 'facebook_like_admin_menu');
} else {
	require_once('fbl_display.php');
	add_action('init', 'facebook_like_share_init');
	$auto = get_option('km_fbl_button_location');
	if ($auto != 'manual')
		add_filter('the_content', 'facebook_like_contents');
}
