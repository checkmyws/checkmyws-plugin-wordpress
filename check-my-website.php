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
include( 'classes/checkmyws-stylesheets.php' );
new checkmyws_stylesheets;

// Load Check my Website Settings page under the submenu Settings on Admin panel
include( 'classes/checkmyws-settings.php' );
new checkmyws_settings;

// Load Check my Website Widget
include( 'classes/checkmyws-widgets.php' );
new checkmyws_widgets;

// Load Check my Website Shortcode

?>
