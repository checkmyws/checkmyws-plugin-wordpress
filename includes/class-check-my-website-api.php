<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://checkmy.ws
 * @since      1.0.0
 *
 * @package    check-my-website
 * @subpackage check-my-website/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    check-my-website
 * @subpackage check-my-website/includes
 * @author     Check my Website by NOVATEEK <contact@checkmy.ws>
 */
class Check_my_Website_Api {

	/**
	 * The domain specified for this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $domain    The domain identifier for this plugin.
	 */
	private $api_key;

	/**
         * The domain specified for this plugin.
         *
         * @since    1.0.0
         * @access   private
         * @var      string    $domain    The domain identifier for this plugin.
         */
        private $api_url;

	/**
         * The domain specified for this plugin.
         *
         * @since    1.0.0
         * @access   private
         * @var      string    $domain    The domain identifier for this plugin.
         */
        private $api_data;

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $key ) {

		// Define api key.
                $this->api_key = $key;

                // Define api url.
                $this->api_url = 'https://api.checkmy.ws/api';

                // Define api data.
                $this->api_data = array();

		// Load api.
		$this->run();

	}

	public function get_api_key() {

                return $this->api_key;

        }

	public function get_api_data() {

		return $this->api_data;

        }

	/**
         * Set api data to database.
         *
         * @since    1.0.0
         * @param    string    $domain    The domain that represents the locale of this plugin.
         */
        private function set_db_data() {

		// Load wpdb.
		global $wpdb;

		// Define plugin table.
                $plugin_table = $wpdb->prefix . 'check_my_website';

		// Define api url.
		$requests = array(
                                        'status' => '/status/',
                                        'logs' => '/status/logs/',
                                        'metrics' => '/status/metrics/',
                                        'hour' => '/status/metrics/hour/',
                                        'day' => '/status/metrics/day/',
                                        'week' =>  '/status/metrics/week/',
                                        'month' => '/status/metrics/month/',
                                        'year' => '/status/metrics/year/'
                                );

		// Request api.
                foreach ( $requests as $name => $path ) {
                        $url = $this->api_url . $path . $this->api_key;
                        $request = file_get_contents( $url );
                        $data = json_decode( $request, true );
                        $this->api_data[$name] = $data;
                }

		// Format api data to table insert.
		$serialized = serialize( $this->api_data );
		$data = addslashes( $serialized );

		// Define sql query.
                $sql = "INSERT INTO " . $plugin_table . " (api_key, api_data) VALUES ('" . $this->api_key . "', '" . $data . "');";

		// Insert data to table.
		$wpdb->query( $sql );

        }

	/**
         * Get api data from database.
         *
         * @since    1.0.0
         * @param    string    $domain    The domain that represents the locale of this plugin.
         */
        private function get_db_data() {

		// Load wpdb.
                global $wpdb;

                // Define plugin table.
                $plugin_table = $wpdb->prefix . 'check_my_website';

		// Define sql query.
		$sql = "SELECT api_data FROM ( SELECT api_data, max(api_time) FROM " . $plugin_table . " WHERE api_key='" . $this->api_key . "' ) AS last_api_request;";

		// Select data from table.
		$result = $wpdb->get_var( $sql );

		// Format api data to array.
		$unserialized = stripslashes( $result );
	        $this->api_data = unserialize( $unserialized );

        }

	/**
         * Run to get or set data from api.
         *
         * @since    1.0.0
         * @param    string    $domain    The domain that represents the locale of this plugin.
         */
        private function run() {
                
		global $wpdb;

                $plugin_table = $wpdb->prefix . 'check_my_website';

                $current_time = current_time( 'timestamp' );

		$options = get_option( 'check_my_website_settings' );
		$interval = $options['interval'] * 60;

		// Define sql query.
                $sql = "SELECT max(api_time) AS api_time FROM " . $plugin_table . " WHERE api_key='" . $this->api_key . "';";

                $api_time = $wpdb->get_var( $sql );
		$format = strtotime( $api_time );

		$difference = $current_time - $format;

                if ( $difference <= $interval ) {
                        $this->get_db_data();
			echo 'difference : ' . $difference . ' - current : ' . $current_time . ' - format : ' . $format . ' - interval : ' . $interval;
                } elseif ( $difference > $interval ) {
			$this->set_db_data();
			echo 'difference : ' . $difference . ' - current : ' . $current_time . ' - format : ' . $format . ' - interval : ' . $interval;
                } else {
			exit();
		};

        }

}
