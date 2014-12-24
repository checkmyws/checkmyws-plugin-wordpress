<?php

/**
 * Fired during plugin uninstallation
 *
 * @link       http://checkmy.ws
 * @since      1.0.0
 *
 * @package    check-my-website
 * @subpackage check-my-website/includes
 */

/**
 * Fired during plugin uninstallation.
 *
 * This class defines all code necessary to run during the plugin's uninstallation.
 *
 * @since      1.0.0
 * @package    check-my-website
 * @subpackage check-my-website/includes
 * @author     Check my Website by NOVATEEK <contact@checkmy.ws>
 */
class Check_my_Website_Uninstaller {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function uninstall() {
        
        // Delete plugin option (settings).
		$option = 'check_my_website_settings';
		delete_option( $option );
        
        // Delete plugin table.
        global $wpdb;
        $plugin_table = $wpdb->prefix . 'check_my_website';
        $sql = "DROP TABLE IF EXISTS '" . $plugin_table . "';";
        $wpdb->query( $sql );

	}

}
