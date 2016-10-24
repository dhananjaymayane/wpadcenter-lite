<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_wpadcenter_lite() {
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
require WP_ADCENTER_LITE_PLUGIN_DIR . 'includes/class-wpadcenter-lite.php';

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
