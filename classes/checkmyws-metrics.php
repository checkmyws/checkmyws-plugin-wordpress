<?php

class checkmyws_metrics {

        function __construct() {
        }

        function checkmyws_metrics_conversion( $valueToConvert, $unitToConvert  ) {
		if ( $unitToConvert == 'ms' ) {
                	$valueConverted = $valueToConvert / 1;
		} else if ( $unitToConvert == 's' ) {
			$valueConverted = $valueToConvert / 1000;
		}
		//$valueConverted = $conversion . ' ' . $unitToConvert;
		return $valueConverted;
	}

}

?>
