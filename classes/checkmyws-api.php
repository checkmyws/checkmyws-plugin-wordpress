<?php

class checkmyws_api {

        function __construct() {
		//$website = array( $this, 'checkmyws_api_id' );
		//$status = array( $this, 'checkmyws_api_status( $website )' );
		//$metrics = array( $this, 'checkmyws_api_metrics( $website )' );
		//$logs = array( $this, 'checkmyws_api_logs( $website )' );
        }

        function checkmyws_api_id() {
		$options = get_option( 'checkmyws_options' );
		$website = $options[ 'checkmyws-settings-field-websiteid' ];
                return $website;
	}

	function checkmyws_api_status( $id ) {
		$url = 'https://api.checkmy.ws/api/status/' . $id;
		$file = file_get_contents( $url );
		$status = json_decode( $file, true );
		return $status;
	}

	function checkmyws_api_metrics( $id ) {
                $url = 'https://api.checkmy.ws/api/status/metrics/' . $id;
                $file = file_get_contents( $url );
		$metrics = json_decode( $file, true );
		return $metrics;
        }

	function checkmyws_api_logs( $id ) {
                $url = 'https://api.checkmy.ws/api/status/logs/' . $id;
                $file = file_get_contents( $url );
		$logs = json_decode( $file, true );
		return $logs;
        }
}

?>
