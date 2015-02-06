<?php

/**
 * Define the Check my Website api class.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://checkmy.ws
 * @since      1.0.0
 *
 * @package    check-my-website
 * @subpackage check-my-website/includes/classes
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
	 * Initialize the api client and load data.
	 *
	 * @since    1.0.0
	 * @var      string    $key    The api key.
	 */
	public function __construct( $key = NULL ) {

		// Define api key.
                $this->api_key = $key;

                // Define api url.
                $this->api_url = 'https://api.checkmy.ws/api';

                // Define api data.
                $this->api_data = array();

		// Load api.
		if ( ! is_null( $this->api_key ) ) :
			$this->run();
		endif;

	}

	/**
         * Return api key.
         *
         * @since    1.0.0
         */
	public function get_api_key() {

                return $this->api_key;

        }

	/**
         * Return api data.
         *
         * @since    1.0.0
         */
	public function get_api_data() {

		return $this->api_data;

        }

	/**
         * Set api data to database.
         *
         * @since    1.0.0
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
			if ( $request = @file_get_contents( $url ) ) :
	                        $data = json_decode( $request, true );
        	                $this->api_data[$name] = $data;
			endif;
                }

		// Format api data to table insert.
	        $serialized = serialize( $this->api_data );
        	$data = addslashes( $serialized );

                // Define sql query.
		$test = "SELECT api_key FROM " . $plugin_table . " WHERE api_key='" . $this->api_key . "';";
		$insert = "INSERT INTO " . $plugin_table . " (api_key, api_data) VALUES ('" . $this->api_key . "', '" . $data . "');";
		$update = "UPDATE " . $plugin_table . " SET api_data='" . $data . "' WHERE api_key='" . $this->api_key . "';";

                // Insertor update data to table.
		if ( $wpdb->get_var( $test ) != $this->api_key ) :
			$wpdb->query( $insert );
                else :
			$wpdb->query( $update );
                endif;

        }

	/**
         * Get api data from database.
         *
         * @since    1.0.0
         */
        private function get_db_data() {

		// Load wpdb.
                global $wpdb;

                // Define plugin table.
                $plugin_table = $wpdb->prefix . 'check_my_website';

		// Define sql query.
		$sql = "SELECT api_data FROM " . $plugin_table . " WHERE api_key='" . $this->api_key . "';";

		// Select data from table.
		$result = $wpdb->get_var( $sql );

		// Format api data to array.
		if ( $result ) :
			$unserialized = stripslashes( $result );
	        	$this->api_data = unserialize( $unserialized );
		else :
			$this->api_data = NULL;
		endif;

        }

	/**
         * Run to get or set data from api.
         *
         * @since    1.0.0
         */
        private function run() {
               
		// Load wpdb.
		global $wpdb;

		// Define plugin table.
                $plugin_table = $wpdb->prefix . 'check_my_website';

		// Get wordpress local time.
                $current_time = current_time( 'timestamp' );

		// Get api interval.
		$options = get_option( 'cmws_settings' );
		$interval = $options['api_interval'] * 60;

		// Define sql query.
		$sql = "SELECT api_time FROM " . $plugin_table . " WHERE api_key='" . $this->api_key . "';";

		// Get api time for an api key in plugin table.
                $api_time = $wpdb->get_var( $sql );
		$api_timestamp = strtotime( $api_time );

		// Calcul difference time.
		$difference = $current_time - $api_timestamp;

		// Get api data.
                if ( $difference <= $interval ) {
                        $this->get_db_data();
                } elseif ( $difference > $interval ) {
			if ( $this->set_db_data() != true ) :
				$this->get_db_data();
			endif;
                } else {
			exit();
		};

        }

}

?>
