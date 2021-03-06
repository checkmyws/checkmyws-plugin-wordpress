<?php

/**
 * Define all functions for the plugin.
 *
 * @link       http://checkmy.ws
 * @since      1.0.0
 *
 * @package    check-my-website
 * @subpackage check-my-website/includes/functions
 */

/**
 * Convert a time value into millisecond or second.
 *
 * @since    1.0.0
 * @var      integer    $valueToConcert       The value to convert.
 * @var      string    $unitToConvert	The unit to convert to.
 */
function cmws_convert( $valueToConvert, $unitToConvert ) {

	if ( $unitToConvert == 'ms' ) {
		$valueConverted = $valueToConvert / 1;
	} else if ( $unitToConvert == 's' ) {
		$valueConverted = $valueToConvert / 1000;
	}

	return $valueConverted;

}

/**
 * Format and return YSlow data.
 *
 * @since    1.0.0
 * @var      array    $data       The data to format.
 */
function cmws_yslow( $data ) {

	$score = $data['yslow_score'];
	$page_load_time = $data['yslow_page_load_time'];

	if ( $score >= '90' ) {
	        $grade = 'A';
		$label = 'success';
        } elseif ( $score >= '80' ) {
        	$grade = 'B';
		$label = 'warning';
        } elseif ( $score >= '70' ) {
        	$grade = 'C';
		$label = 'danger';
        } elseif ( $score >= '60' ) {
        	$grade = 'D';
		$label = 'danger';
        } elseif ( $score >= '50' ) {
        	$grade = 'E';
		$label = 'danger';
        } elseif ( $score < '50' ) {
        	$grade = 'F';
		$label = 'danger';
        } else {
        	$grade = '?';
		$label = 'info';
	}

	return array( 'page_load_time' => $page_load_time, 'score' => $score, 'grade' => $grade, 'label' => $label );
}

/**
 * Explode a poller id and return a formated poller name.
 *
 * @since    1.0.0
 * @var      string    $pollerToConvert       The poller id to explode and format.
 */
function cmws_poller_name( $pollerToConvert ) {

        list( $state, $location, $isp, $bandwidth) = explode( ':', $pollerToConvert );

        $locations = array( 'AMS' => 'Amsterdam', 'BHS' => 'Beauharnois', 'DA' => 'Dallas', 'FRA' => 'Frankfurt', 'LDN' => 'London', 'LA' => 'Los Angeles', 'MRL' => 'Montreal', 'NY' => 'New-York', 'PAR' => 'Paris', 'RBX' => 'Roubaix' );
        $isps = array( 'DGO' => 'DigitalOcean', 'GDI' => 'Gandi', 'LND' => 'Linode', 'ONL' => 'Online', 'OVH' => 'OVH', 'OVZ' => 'OpenVZ.ca', 'VLR' => 'Vultr' );

        if ( isset( $locations[$location] ) ) {
                $pollerLocation = $locations[$location];
        } else {
                $pollerLocation = $location;
        }

        if ( isset( $isps[$isp] ) ) {
                $pollerIsp = $isps[$isp];
        } else {
                $pollerIsp = $isp;
        }

        $poller = $pollerLocation . ' - ' . $pollerIsp;

        return $poller;

}

/**
 * Format and return poller data.
 *
 * @since    1.0.0
 * @var      string    $poller_id       The poller id.
 * @var      string    $poller_time       The poller response time.
 * @var      string    $poller_code       The poller state.
 */
function cmws_poller( $poller_id, $poller_time, $poller_code ) {

	$state = $label = $flag = $name = $time = NULL;

	if ( isset( $poller_id ) ) :
		$flag = strtolower( substr( $poller_id, 0, 2 ) );
	        $name = cmws_poller_name( $poller_id );
	endif;

	if ( isset( $poller_code ) ) :
		$state = cmws_state( 'poller', $poller_code );
        	$label = cmws_label( 'poller', $poller_code );
	endif;

	if ( isset( $poller_time ) ) :
		$time = $poller_time;
	endif;

        return array( 'state' => $state, 'label' => $label, 'flag' => $flag, 'name' => $name, 'time' => $time );

}

/**
 * Format and return state.
 *
 * @since    1.0.0
 * @var      string    $type       The item type to format.
 * @var      integer    $code       The last item state.
 */
function cmws_state( $type, $code ) {

	switch ( $type ) {

		case 'poller':
			$states = array( '-3' => __( 'Disable', 'check-my-website' ), '-2' => __( 'Unschedule', 'check-my-website' ), '-1' => __( 'Pending', 'check-my-website' ), '0' => __( 'Ok', 'check-my-website' ), '1' => __( 'Warning', 'check-my-website' ), '2' => __( 'Down', 'check-my-website' ), '3' => __( 'Unknown', 'check-my-website' ) );

        		if ( isset( $states[$code] ) ) {
                		$state = $states[$code];
        		} else {
                		$state = __( 'Unknown', 'check-my-website' );
        		}
		break;

		case 'log':
			$states = array( '0' => __( 'Ok', 'check-my-website' ), '1' => __( 'Warning', 'check-my-website' ), '2' => __( 'Critical', 'check-my-website' ) );

			if ( isset( $states[$code] ) ) {
        			$state = $states[$code];
       			} else {
        			$state = __( 'Unknown', 'check-my-website' );
        		}
		break;

		default:
			$state = __( 'Unknown', 'check-my-website' );

	}

	return $state;

}

/**
 * Return label.
 *
 * @since    1.0.0
 * @var      string    $type       The item type to format.
 * @var      integer    $code       The last item state.
 */
function cmws_label( $type, $code ) {

	switch ( $type ) {

                case 'poller':
			$labels = array( '0' => 'success', '1' => 'warning', '2' => 'danger' );

		        if ( isset( $labels[$code] ) ) {
                		$label = $labels[$code];
        		} else {
                		$label = 'info';
        		}
		break;

                case 'log':
		        $labels = array( '0' => 'success', '1' => 'warning', '2' => 'danger' );

        		if ( isset( $labels[$code] ) ) {
                		$label = $labels[$code];
        		} else {
                		$label = 'info';
        		}
		break;

                default:
                        $state = 'info';

        }

        return $label;

}

/**
 * Return message description.
 *
 * @since    1.0.0
 * @var      integer    $code       The last item state.
 */
function cmws_message( $code ) {

        $messages = array( '3' => __( 'Internal error', 'check-my-website' ), '4' => __( 'Job Timeout', 'check-my-website' ), '5' => __( 'Socket Unreachable', 'check-my-website' ), '6' => __( 'Pattern not found', 'check-my-website' ), '7' => __( 'HTTP Code Missmatch', 'check-my-website' ), '8' => __( 'Time limit Reached', 'check-my-website' ), '9' => __( 'TCP Socket Unreachable', 'check-my-website' ), '10' => __( 'HTTP Connection Error', 'check-my-website' ), '11' => __( 'HTTP Read Timeout', 'check-my-website' ), '12' => __( 'HTTP Connect Timeout', 'check-my-website' ), '13' => __( 'HTTP Socket Error', 'check-my-website' ), '14' => __( 'HTTP SSL handshake failed', 'check-my-website' ), '15' => __( 'DNS Socket error', 'check-my-website' ), '16' => __( 'DNS Timeout', 'check-my-website' ), '17' => __( 'DNS Error', 'check-my-website' ), '19' => __( 'Invalid URI scheme', 'check-my-website' ), '20' => __( 'Socket Timeout', 'check-my-website' ), '21' => __( 'Pattern found', 'check-my-website' ), '22' => __( 'Max retries has been reached', 'check-my-website' ), '30' => __( 'Email notification => {0}', 'check-my-website' ), '31' => __( 'SMS notification => {0}', 'check-my-website' ), '520' => __( '520 Web server is returning an unknown error', 'check-my-website' ), '80' => __( 'Invoice <a href=\'/api/invoices/pdf/{0}\' target=\'_blank\'>{0}</a> was created', 'check-my-website' ), '81' => __( 'Invoice <a href=\'/api/invoices/pdf/{0}\' target=\'_blank\'>{0}</a>, payment succeeded', 'check-my-website' ), '82' => __( 'Invoice <a href=\'/api/invoices/pdf/{0}\' target=\'_blank\'>{0}</a>, payment failed', 'check-my-website' ), '83' => __( 'Subscribed to {1} {2} plan with {3} URL', 'check-my-website' ), '84' => __( 'Subscription will be canceled at end of current period', 'check-my-website' ), '85' => __( 'Subscription was canceled', 'check-my-website' ), '86' => __( 'Subscription was updated', 'check-my-website' ), '90' => __( 'Addons => {1} SMS was added', 'check-my-website' ), '100' => __( '100 Continue', 'check-my-website' ), '101' => __( '101 Switching Protocols', 'check-my-website' ), '102' => __( '102 Processing', 'check-my-website' ), '118' => __( '118 Connection timed out', 'check-my-website' ), '200' => __( '200 Ok', 'check-my-website' ), '201' => __( '201 Created', 'check-my-website' ), '202' => __( '202 Accepted', 'check-my-website' ), '203' => __( '203 Non-Authoritative Information', 'check-my-website' ), '204' => __( '204 No Content', 'check-my-website' ), '205' => __( '205 Reset Content', 'check-my-website' ), '206' => __( '206 Partial Content', 'check-my-website' ), '207' => __( '207 Multi-Status', 'check-my-website' ), '210' => __( '210 Content Different', 'check-my-website' ), '226' => __( '226 IM Used', 'check-my-website' ), '300' => __( '300 Multiple Choices', 'check-my-website' ), '301' => __( '301 Moved Permanently', 'check-my-website' ), '302' => __( '302 Moved Temporarily', 'check-my-website' ), '303' => __( '303 See Other', 'check-my-website' ), '304' => __( '304 Not Modified', 'check-my-website' ), '305' => __( '305 Use Proxy', 'check-my-website' ), '307' => __( '307 Temporary Redirect', 'check-my-website' ), '308' => __( '308 Permanent Redirect', 'check-my-website' ), '310' => __( '310 Too many Redirects', 'check-my-website' ), '400' => __( '400 Bad Request', 'check-my-website' ), '401' => __( '401 Unauthorized', 'check-my-website' ), '402' => __( '402 Payment Required', 'check-my-website' ), '403' => __( '403 Forbidden', 'check-my-website' ), '404' => __( '404 Not Found', 'check-my-website' ), '405' => __( '405 Method Not Allowed', 'check-my-website' ), '406' => __( '406 Not Acceptable', 'check-my-website' ), '407' => __( '407 Proxy Authentication', 'check-my-website' ), '408' => __( '408 Request Time-out', 'check-my-website' ), '409' => __( '409 Conflict', 'check-my-website' ), '410' => __( '410 Gone', 'check-my-website' ), '411' => __( '411 Length Required', 'check-my-website' ), '412' => __( '412 Precondition Failed', 'check-my-website' ), '413' => __( '413 Request Entity Too Large', 'check-my-website' ), '414' => __( '414 Request-URI Too Long', 'check-my-website' ), '415' => __( '415 Unsupported Media Type', 'check-my-website' ), '416' => __( '416 Requested range unsatisfiable', 'check-my-website' ), '417' => __( '417 Expectation failed', 'check-my-website' ), '418' => __( '418 I\u2019m a teapot', 'check-my-website' ), '422' => __( '422 Unprocessable entity', 'check-my-website' ), '423' => __( '423 Locked', 'check-my-website' ), '424' => __( '424 Method failure', 'check-my-website' ), '425' => __( '425 Unordered Collection', 'check-my-website' ), '426' => __( '426 Upgrade Required', 'check-my-website' ), '428' => __( '428 Precondition Required', 'check-my-website' ), '429' => __( '429 Too Many Requests', 'check-my-website' ), '431' => __( '431 Request Header Fields Too Large', 'check-my-website' ), '501' => __( '501 Not Implemented', 'check-my-website' ), '449' => __( '449 Retry With', 'check-my-website' ), '450' => __( '450 Blocked by Windows Parental Controls', 'check-my-website' ), '456' => __( '456 Unrecoverable Error', 'check-my-website' ), '510' => __( '510 Not extended', 'check-my-website' ), '509' => __( '509 Bandwidth Limit Exceeded', 'check-my-website' ), '499' => __( '499 Client has closed connection', 'check-my-website' ), '500' => __( '500 Internal Server Error', 'check-my-website' ), '-2' => __( 'Unschedule', 'check-my-website' ), '502' => __( '502 Bad Gateway ou Proxy Error', 'check-my-website' ), '503' => __( '503 Service Unavailable', 'check-my-website' ), '504' => __( '504 Gateway Time-out', 'check-my-website' ), '505' => __( '505 HTTP Version not supported', 'check-my-website' ), '506' => __( '506 Variant also negociate', 'check-my-website' ), '507' => __( '507 Insufficient storage', 'check-my-website' ), '508' => __( '508 Loop detected', 'check-my-website' ), '-3' => __( 'Disable', 'check-my-website' ), '-1' => __( 'Pending', 'check-my-website' ) );

        if ( isset( $messages[$code] ) ) {
                $message = $messages[$code];
        } else {
                $message = __( 'Undefined', 'check-my-website' );
        }

        return $message;

}

/**
 * Format and return log data.
 *
 * @since    1.0.0
 * @var      array    $data       The data to format.
 */
function cmws_log( $data ) {

	$state = $label = $date = $source = $message = $display = NULL;

	if ( isset( $data ) ) :
		$state = cmws_state( 'log', $data['state'] );
		$label = cmws_label( 'log', $data['state'] );
		$date = cmws_date( $data['timestamp'], 'full' );
		$source = 'all';
		$message = cmws_message( $data['msg'] );
		$display = cmws_display( $data['timestamp'] );
	endif;

        return array( 'state' => $state, 'label' => $label, 'date' => $date, 'source' => $source, 'message' => $message, 'display' => $display );
}

/**
 * Format and return informations data.
 *
 * @since    1.0.0
 * @var      array    $data       The data to format.
 */
function cmws_infos( $data ) {

	$dns_expiration = $ssl_expiration = $requests = $not_found = $js_errors = $redirects = NULL;

	// Define dns expiration.
	if ( isset( $data['status']['metas']['dns_expiration_timestamp'] ) ) :
		$dns_expiration['name'] = __( 'DNS Expiration', 'check-my-website' );
       		$dns_expiration['data'] = cmws_date( $data['status']['metas']['dns_expiration_timestamp'], 'date' );
		$dns_expiration['label'] = 'info';
	endif;

	// Define ssl cert expiration.
        if ( isset( $data['status']['metas']['ssl_cert_expiration_timestamp'] ) ) :
                $ssl_expiration['name'] = __( 'SSL Expiration', 'check-my-website' );
                $ssl_expiration['data'] = cmws_date( $data['status']['metas']['ssl_cert_expiration_timestamp'], 'date' );
                $ssl_expiration['label'] = 'info';
	endif;

	// Define requests.
	if ( isset( $data['status']['metas']['requests'] ) ) :
		$requests['name'] = __( 'Number of HTTP requests', 'check-my-website' );
        	$requests['data'] = $data['status']['metas']['requests'];
		if ( $data['status']['metas']['requests'] >= 100 ) {
                	$requests['label'] = 'danger';
        	} elseif ( ( $data['status']['metas']['requests'] >= 50 ) && ( $data['status']['metas']['requests'] < 100 ) ) {
                	$requests['label'] = 'warning';
        	} else {
			$requests['label'] = 'success';
		}
	endif;

	// Define not found.
        if ( isset( $data['status']['metas']['notFound'] ) ) :
		$not_found['name'] = __( 'Number of HTTP 404 responses', 'check-my-website' );
        	$not_found['data'] = $data['status']['metas']['notFound'];
		if ( $data['status']['metas']['notFound'] >= 1 ) {
               		$not_found['label'] = 'danger';
        	} else {
                	$not_found['label'] = 'success';
        	}
	endif;

	// Define js errors.
        if ( isset( $data['status']['metas']['jsErrors'] ) ) :
		$js_errors['name'] = __( 'Number of JavaScript errors', 'check-my-website' );
        	$js_errors['data'] = $data['status']['metas']['jsErrors'];
		if ( $data['status']['metas']['jsErrors'] >= 1 ) {
                	$js_errors['label'] = 'warning';
        	} else {
                	$js_errors['label'] = 'success';
        	}
	endif;

	// Define redirects.
        if ( isset( $data['status']['metas']['redirects'] ) ) :
		$redirects['name'] = __( 'Number of HTTP redirects (301 or 302)', 'check-my-website' );
        	$redirects['data'] = $data['status']['metas']['redirects'];
		if ( $data['status']['metas']['redirects'] >= 2 ) {
			$redirects['label'] = 'warning';
		} else {
			$redirects['label'] = 'success';
		}
	endif;

	return array( 'dns_expiration' => $dns_expiration, 'ssl_expiration' => $ssl_expiration, 'requests' => $requests, 'not_found' => $not_found, 'js_errors' => $js_errors, 'redirects' => $redirects );

}

/**
 * Format and return global data.
 *
 * @since    1.0.0
 * @var      array    $data       The data to format.
 */
function cmws_global( $data ) {

	$id = $url = $state = $label = $last_change_date = $last_change_time = $state_duration = $last_response_time = $latest_response_time = $average_time = $availability = NULL;

	// Define api key.
	if ( isset( $data['status']['_id'] ) ) :
		$id = $data['status']['_id'];
	endif;

	// Define url.
	if ( isset( $data['status']['url'] ) ) :
		$url = $data['status']['url'];
	endif;

	// Define state and label.
	if ( isset( $data['status']['state'] ) ) :
	        $state = cmws_state( 'poller', $data['status']['state'] );
        	$label = cmws_label( 'poller', $data['status']['state'] );
	endif;

	// Define last date and time duration.
	if ( isset( $data['status']['laststatechange_bin'] ) ) :
	        $last_change_date = cmws_date( $data['status']['laststatechange_bin'], 'full' );
		$last_change_time = cmws_date( $data['status']['laststatechange_bin'], 'time' );
	        $state_duration = cmws_date_diff( $data['status']['laststatechange_bin'] );
	endif;

	// Define last response time (date).
	if ( isset( $data['status']['metas']['lastcheck'] ) ) :
		$last_response_time = cmws_date( $data['status']['metas']['lastcheck'], 'time' );
	endif;

	// Define latest response time.
	if ( isset( $data['day']['series']['checks.' . $id . '.httptime']['data'] ) ) :
		$last_key = key( array_slice( $data['day']['series']['checks.' . $id . '.httptime']['data'], -1, 1, TRUE ) );
	        $latest_response_time = round( $data['day']['series']['checks.' . $id . '.httptime']['data'][$last_key][1] );
	endif;

	// Define average time (24h).
	if ( isset( $data['day']['series']['checks.' . $id . '.httptime']['data'] ) ) :
		$sum = $count = 0;
        	foreach ( $data['day']['series']['checks.' . $id . '.httptime']['data'] as $key => $values ) {
			//$day_interval = cmws_display( $values[0] );
			//if ( $day_interval == '1' ) {
        	        	$sum = $sum + $values[1];
                		$count = $count +1;
			//}
        	}
      		$average_time = floor( $sum / $count );
	endif;

	// Define availability (24h).
	if ( isset( $data['week']['series']['checks.' . $id . '.state.all']['data'] ) ) :
		$last_key = key( array_slice( $data['week']['series']['checks.' . $id . '.state.all']['data'], -1, 1, TRUE ) );
        	$availability = round( $data['week']['series']['checks.' . $id . '.state.all']['data'][$last_key][1], 2 );
	endif;

        return array( 'id' => $id, 'url' => $url, 'state' => $state, 'label' => $label, 'last_change_date' => $last_change_date, 'last_change_time' => $last_change_time, 'state_duration' => $state_duration, 'last_response_time' => $last_response_time, 'latest_response_time' => $latest_response_time, 'average_time' => $average_time, 'availability' => $availability );

}

/**
 * Format and return all data.
 *
 * @since    1.0.0
 * @var      array    $data       The data to format.
 */
function cmws_data( $data ) {

	$global = $infos = $pollers = $logs = $yslow = NULL;

	if ( isset( $data ) ) {
		// Define and fill global, infos, pollers and yslow array.
		if ( isset( $data['status'] ) ) :
			$global = cmws_global( $data );
			$infos = cmws_infos( $data );
                	foreach ( $data['status']['lastvalues']['httptime'] as $key => $value ) {
                        	$pollers[$key] = cmws_poller( $key, $value, $data['status']['states'][$key] );
                	}
	                $yslow = cmws_yslow( $data['status']['metas'] );
		endif;			
		// Define and fill logs array.
		if ( isset( $data['logs'][0] ) ) : 
			foreach ( $data['logs'] as $key => $value ) {
                        	$logs[$key] = cmws_log( $data['logs'][$key] );
                	}
		endif;
	}

	return array( 'global' => $global, 'infos' => $infos, 'pollers' => $pollers, 'logs' => $logs, 'yslow' => $yslow );

}

/**
 * Compare dates and return difference.
 *
 * @since    1.0.0
 * @var      timestamp    $dateToCompare       The date to compare.
 * @var      timestamp    $dateCompareTo       The date to compare to.
 */
function cmws_date_diff( $dateToCompare, $dateCompareTo = 'current' ) {

	$timezone_offet = get_option( 'gmt_offset' );

	$timestamp_to_compare = new DateTime();
        $timestamp_to_compare->setTimestamp( $dateToCompare );
        $timestamp_to_compare_timezoned =  $timestamp_to_compare->getTimestamp() + ( $timezone_offet * 3600 );

        if ( $dateCompareTo == 'current' ) {
		$timestamp_compare_to = current_time( 'timestamp' );

                $interval = floor( abs( $timestamp_to_compare_timezoned - $timestamp_compare_to ) /60 /60 /24 );
	} else {
		$timestamp_compare_to = new DateTime();
                $timestamp_compare_to->setTimestamp( $dateCompareTo );
                $timezoned_timestamp_compare_to =  $timestamp_compare_to->getTimestamp() + ( $timezone_offet * 3600 );

		$interval = floor( abs( $timezoned_timestamp_to_compare - $timezoned_timestamp_compare_to ) /60 /60 /24 );
	}

        return $interval;

}

/**
 * Format and return date.
 *
 * @since    1.0.0
 * @var      timestamp    $timestamp       The date to format.
 * @var      string    $format       The date format.
 */
function cmws_date( $timestamp, $format ) {

        $timestamp_timezoned = cmws_timezone( $timestamp );
        
	if ( $format == 'full' ) {
		$date = date_i18n( get_option( 'date_format' ) . ' - ' . get_option( 'time_format' ), $timestamp_timezoned );
	} elseif ( $format == 'date' ) {
		$date = date_i18n( get_option( 'date_format' ), $timestamp_timezoned );
	} else {
		$date = date_i18n( get_option( 'time_format' ), $timestamp_timezoned );
	}

	return $date;

}

/**
 * Return date timezoned.
 *
 * @since    1.0.0
 * @var      timestamp    $timestamp       The date to timezone.
 */
function cmws_timezone( $timestamp ) {

        $timezone_offet = get_option( 'gmt_offset' );

        $timestamp_to_timezone = new DateTime();
        $timestamp_to_timezone->setTimestamp( $timestamp );

        $timezoned =  $timestamp_to_timezone->getTimestamp() + ( $timezone_offet * 3600 );

        return $timezoned;

}

/**
 * Check date difference with current date and return display state.
 *
 * @since    1.0.0
 * @var      timestamp    $date       The date to compare.
 */
function cmws_display( $date ) {

	$timezone_offet = get_option( 'gmt_offset' );

	$current_timestamp = current_time( 'timestamp' );

        $timestamp_to_check = new DateTime();
        $timestamp_to_check->setTimestamp( $date );

        $full_timestamp_to_check =  $timestamp_to_check->getTimestamp() + ( $timezone_offet * 3600 );

        $timestamp_interval = floor( abs( $full_timestamp_to_check - $current_timestamp ) /60 /60 /24 );

        if ( $timestamp_interval < 1 ) {
                $display = true;
        } else {
                $display = false;
        }

        return $display;

}

?>
