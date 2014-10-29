<?php
/**
* Plugin Name: Check my Website
* Plugin URI: http://checkmy.ws/
* Description: Display monitoring data from your Check my Website account.
* Version: 1.0
* Author: Check my Website
* Author URI: http://checkmy.ws/
**/

// Load Check my Website Stylesheets
require_once( plugin_dir_path(__FILE__) . 'classes/checkmyws-stylesheets.php' );
new checkmyws_stylesheets;

// Load Check my Website Settings page under the submenu Settings on Admin panel
require_once( plugin_dir_path( __FILE__ ) . 'classes/checkmyws-settings.php' );
new checkmyws_settings;

// Load Check my Website Widget
require_once( plugin_dir_path( __FILE__ ) . 'classes/checkmyws-widgets.php' );
new checkmyws_widgets;

?>
