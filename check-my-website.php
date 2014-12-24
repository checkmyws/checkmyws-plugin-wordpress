<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://checkmy.ws
 * @since             1.0.0
 * @package           check-my-website
 *
 * @wordpress-plugin
 * Plugin Name:       Check my Website
 * Plugin URI:        http://checkmy.ws/plugins/
 * Description:       Measure, alert, visualize and communicate about your website.
 * Version:           1.0.0
 * Author:            Check my Website by NOVATEEK
 * Author URI:        http://checkmy.ws/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       check-my-website
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_check_my_website() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-check-my-website-activator.php';
	Check_my_Website_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_check_my_website() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-check-my-website-deactivator.php';
	Check_my_Website_Deactivator::deactivate();
}

/**
 * The code that runs during plugin uninstallation.
 * This action is documented in includes/class-plugin-name-uninstaller.php
 */
function uninstall_check_my_website() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-check-my-website-uninstaller.php';
	Check_my_Website_Uninstaller::uninstall();
}

register_activation_hook( __FILE__, 'activate_check_my_website' );
register_deactivation_hook( __FILE__, 'deactivate_check_my_website' );
register_uninstall_hook( __FILE__, 'uninstall_check_my_website' );

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-check-my-website.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_check_my_website() {

	$plugin = new Check_my_Website();
	$plugin->run();

}
run_check_my_website();
