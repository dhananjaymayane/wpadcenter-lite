<?php
/**
 Plugin Name: WP AdCenter Lite
 Version: 1.0
 Plugin URI: http://wpadcenter.com
 Description: Advertising management plugin for WordPress
 Author:  WPEka Team
 Author URI: http://club.wpeka.com
 **/


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

//	**** Require functions and display zone files ****//
if ( ! defined( 'WP_ADCENTER_LITE_PLUGIN_DIR' ) ) {
	define( 'WP_ADCENTER_LITE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'WP_ADCENTER_PUBLIC_DIR' ) ) {
	define( 'WP_ADCENTER_PUBLIC_DIR', WP_ADCENTER_LITE_PLUGIN_DIR.'public/' );
}	

if( ! defined( 'WP_ADCENTER_ADMIN_DIR' ) ){
	define( 'WP_ADCENTER_ADMIN_DIR', WP_ADCENTER_LITE_PLUGIN_DIR.'admin/' );
}	

if( ! defined( 'WP_ADCENTER_LITE_PLUGIN_URL' ) ){
	define( 'WP_ADCENTER_LITE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

if( ! defined( 'WP_ADCENTER_PUBLIC_URL' ) ){
	define( 'WP_ADCENTER_PUBLIC_URL', WP_ADCENTER_LITE_PLUGIN_URL.'public/' );
}

if( ! defined( 'WP_ADCENTER_ADMIN_URL' ) ){
	define( 'WP_ADCENTER_ADMIN_URL', WP_ADCENTER_LITE_PLUGIN_URL.'admin/' );
}	
$pluginUrl = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_wpadcenter_lite() {
	/**
	 * On activation, set a time, frequency and name of an action hook to be scheduled.
 	*/
	wp_schedule_event( time(), 'daily', 'wpadcenter_daily_event_hook' );
	require_once WP_ADCENTER_LITE_PLUGIN_DIR . 'includes/class-wpadcenter-lite-activator.php';
	WPAdcenter_Lite_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_wpadcenter_lite() {
	require_once WP_ADCENTER_LITE_PLUGIN_DIR . 'includes/class-wpadcenter-lite-deactivator.php';
	WPAdcenter_Lite_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wpadcenter_lite' );
register_deactivation_hook( __FILE__, 'deactivate_wpadcenter_lite' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require_once WP_ADCENTER_LITE_PLUGIN_DIR.'includes/wpadcenter-lite-ajax.php';
require_once WP_ADCENTER_LITE_PLUGIN_DIR . 'includes/class-wpadcenter-lite.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wpadcenter_lite() {

	$plugin = new WPAdcenter_Lite();
	$plugin->run();

}
run_wpadcenter_lite();
