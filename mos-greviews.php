<?php
/*
Plugin Name: Mos Google Reviews
Description: This plugin display Google Business Reviews on your websites through shortcode, so you can use it anywhere you want like inside post or page content, widgets area and so on.
Version: 0.0.1
Author: Md. Mostak Shahid
*/


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define MOS_GREVIEWS_FILE.
if ( ! defined( 'MOS_GREVIEWS_FILE' ) ) {
	define( 'MOS_GREVIEWS_FILE', __FILE__ );
}
// Define MOS_GREVIEWS_SETTINGS.
if ( ! defined( 'MOS_GREVIEWS_SETTINGS' ) ) {
  //define( 'MOS_GREVIEWS_SETTINGS', admin_url('/edit.php?post_type=post_type&page=plugin_settings') );
	define( 'MOS_GREVIEWS_SETTINGS', admin_url('/options-general.php?page=mos_greviews_settings') );
}
$mos_greviews_option = get_option( 'mos_greviews_option' );
$plugin = plugin_basename(MOS_GREVIEWS_FILE); 
require_once ( plugin_dir_path( MOS_GREVIEWS_FILE ) . 'mos-greviews-functions.php' );
require_once ( plugin_dir_path( MOS_GREVIEWS_FILE ) . 'mos-greviews-settings.php' );
//require_once ( plugin_dir_path( MOS_GREVIEWS_FILE ) . 'custom-settings.php' );

/*require_once('plugins/update/plugin-update-checker.php');
$pluginInit = Puc_v4_Factory::buildUpdateChecker(
	'https://raw.githubusercontent.com/mostak-shahid/update/master/mos-greviews.json',
	MOS_GREVIEWS_FILE,
	'mos-greviews'
);*/


register_activation_hook(MOS_GREVIEWS_FILE, 'mos_griviews_activate');
add_action('admin_init', 'mos_griviews_redirect');
 
function mos_griviews_activate() {
    $mos_griviews_option = array();
    // $mos_griviews_option['mos_login_type'] = 'basic';
    // update_option( 'mos_griviews_option', $mos_griviews_option, false );
    add_option('mos_griviews_do_activation_redirect', true);
}
 
function mos_griviews_redirect() {
    if (get_option('mos_griviews_do_activation_redirect', false)) {
        delete_option('mos_griviews_do_activation_redirect');
        if(!isset($_GET['activate-multi'])){
            wp_safe_redirect(MOS_GREVIEWS_SETTINGS);
        }
    }
}

// Add settings link on plugin page
function mos_greviews_settings_link($links) { 
  $settings_link = '<a href="'.MOS_GREVIEWS_SETTINGS.'">Settings</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
} 
add_filter("plugin_action_links_$plugin", 'mos_greviews_settings_link' );



