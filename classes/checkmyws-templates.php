<?php

// Check my Website API
class checkmyws_api {

	// Init API
        function __construct() {
		//$website = array( $this, 'checkmyws_api_id' );
		//$status = array( $this, 'checkmyws_api_status( $website )' );
		//$metrics = array( $this, 'checkmyws_api_metrics( $website )' );
		//$logs = array( $this, 'checkmyws_api_logs( $website )' );
        }

	// Get API URL ID and return a code
        function checkmyws_api_id() {

		$options = get_option( 'checkmyws_options' );
		$website = $options[ 'checkmyws-settings-url-id' ];
 
		return $website;

	}

	// Get JSON status data from API and return an array
	function checkmyws_api_status( $id ) {

		$url = 'https://api.checkmy.ws/api/status/' . $id;
		$file = file_get_contents( $url );
		$status = json_decode( $file, true );

		return $status;

	}

	// Get JSON metrics data from API and return an array
	function checkmyws_api_metrics( $id ) {

                $url = 'https://api.checkmy.ws/api/status/metrics/' . $id;
                $file = file_get_contents( $url );
		$metrics = json_decode( $file, true );

		return $metrics;

        }

	// Get JSON logs data from API and return an array
	function checkmyws_api_logs( $id ) {

                $url = 'https://api.checkmy.ws/api/status/logs/' . $id;
                $file = file_get_contents( $url );
		$logs = json_decode( $file, true );

		return $logs;

        }
}

?>
