<?php

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @link       https://checkmy.ws
 * @since      1.0.0
 *
 * @package    check-my-website
 * @subpackage check-my-website/includes/classes
 * @author     Check my Website by NOVATEEK <contact@checkmy.ws>
 */
class Check_my_Website_Activator {

	/**
	 * Plugin activation.
	 *
	 * Table creation for plugin use.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
            
		// Load wpdb.
		global $wpdb;

		// Define plugin table.
        	$plugin_table = $wpdb->prefix . 'check_my_website';
        
		if( $wpdb->get_var( "SHOW TABLES LIKE " . $plugin_table . ";" ) != $plugin_table ) {

			if ( ! empty( $wpdb->charset ) )
				$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";

			if ( ! empty( $wpdb->collate ) )
				$charset_collate .= " COLLATE $wpdb->collate";
 
			// Define plugin table.
            		$sql = "CREATE TABLE " . $plugin_table . " (
			     `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			     `api_key` varchar(50) NOT NULL,
			     `api_time` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			     `api_data` longtext NOT NULL,
			     PRIMARY KEY (`id`)
		           ) $charset_collate;";
            
			// Create plugin table.
           		require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
            		dbDelta( $sql );

		}

	}

}

?>
