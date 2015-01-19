<?php

/**
 * Register all actions and filters for the plugin
 *
 * @link       http://checkmy.ws
 * @since      1.0.0
 *
 * @package    check-my-website
 * @subpackage check-my-website/includes
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @since      1.0.0
 * @package    check-my-website
 * @subpackage check-my-website/includes
 * @author     Check my Website by NOVATEEK <contact@checkmy.ws>

/**
 * Add a new action to the collection to be registered with WordPress.
 *
 * @since    1.0.0
 * @var      string               $hook             The name of the WordPress action that is being registered.
 * @var      object               $component        A reference to the instance of the object on which the action is defined.
 * @var      string               $callback         The name of the function definition on the $component.
 * @var      int      Optional    $priority         The priority at which the function should be fired.
 * @var      int      Optional    $accepted_args    The number of arguments that should be passed to the $callback.
 */
function convert( $valueToConvert, $unitToConvert ) {

	if ( $unitToConvert == 'ms' ) {
		$valueConverted = $valueToConvert / 1;
	} else if ( $unitToConvert == 's' ) {
		$valueConverted = $valueToConvert / 1000;
	}

	return $valueConverted;

}

/**
 * A utility function that is used to register the actions and hooks into a single
 * collection.
 *
 * @since    1.0.0
 * @access   private
 * @var      array                $hooks            The collection of hooks that is being registered (that is, actions or filters).
 * @var      string               $hook             The name of the WordPress filter that is being registered.
 * @var      object               $component        A reference to the instance of the object on which the filter is defined.
 * @var      string               $callback         The name of the function definition on the $component.
 * @var      int      Optional    $priority         The priority at which the function should be fired.
 * @var      int      Optional    $accepted_args    The number of arguments that should be passed to the $callback.
 * @return   type                                   The collection of actions and filters registered with WordPress.
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
 * Register the filters and actions with WordPress.
 *
 * @since    1.0.0
 */
function cmws_poller_name( $pollerToConvert ) {

        list( $state, $location, $isp, $bandwidth) = explode( ':', $pollerToConvert );

        $locations = array( 'AMS' => 'Amsterdam', 'BHS' => 'Beauharnois', 'DA' => 'Dallas', 'FRA' => 'Frankfurt', 'LDN' => 'London', 'LA' => 'Los Angeles', 'MRL' => 'Montreal', 'NY' => 'New-York', 'PAR' => 'Paris' );
        $isps = array( 'DGO' => 'DigitalOcean', 'GDI' => 'Gandi', 'LND' => 'Linode', 'ONL' => 'Online', 'OVH' => 'OVH', 'OVZ' => 'OpenVZ.ca', 'VLR' => 'Vultr' );

        if ( $locations[$location] ) {
                $pollerLocation = $locations[$location];
        } else {
                $pollerLocation = $location;
        }

        if ( $isps[$isp] ) {
                $pollerIsp = $isps[$isp];
        } else {
                $pollerIsp = $isp;
        }

        $poller = $pollerLocation . ' - ' . $pollerIsp;

        return $poller;

}

/**
 * Register the filters and actions with WordPress.
 *
 * @since    1.0.0
 */
function cmws_poller( $id, $time, $code ) {

	$state = cmws_state( 'poller', $code );
        $label = cmws_label( 'poller', $code );
	$flag = strtolower( substr( $id, 0, 2 ) );
        $name = cmws_poller_name( $id );

        return array( 'state' => $state, 'label' => $label, 'flag' => $flag, 'name' => $name, 'time' => $time );

}

function cmws_state( $type, $code ) {

	switch ( $type ) {

		case 'poller':
			$states = array( '-3' => 'Disable', '-2' => 'Unschedule', '-1' => 'Pending', '0' => 'Ok', '1' => 'Warning', '2' => 'Down', '3' => 'Unknown' );

        		if ( $states[$code] ) {
                		$state = $states[$code];
        		} else {
                		$state = 'Unknown';
        		}
		break;

		case 'log':
			$states = array( '0' => 'Ok', '1' => 'Warning', '2' => 'Critical' );

			if ( $states[$code] ) {
        			$state = $states[$code];
       			} else {
        			$state = 'Unknown';
        		}
		break;

		default:
			$state = 'Unknown';

	}

	return $state;

}

function cmws_label( $type, $code ) {

	switch ( $type ) {

                case 'poller':
			$labels = array( '0' => 'success', '1' => 'warning', '2' => 'danger' );

		        if ( $labels[$code] ) {
                		$label = $labels[$code];
        		} else {
                		$label = 'info';
        		}
		break;

                case 'log':
		        $labels = array( '0' => 'success', '1' => 'warning', '2' => 'danger' );

        		if ( $labels[$code] ) {
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

function cmws_message( $code ) {

        $messages = array( '3' => 'Internal error', '4' => 'Job Timeout', '5' => 'Socket Unreachable', '6' => 'Pattern not found', '7' => 'HTTP Code Missmatch', '8' => 'Time limit Reached', '9' => 'TCP Socket Unreachable', '10' => 'HTTP Connection Error', '11' => 'HTTP Read Timeout', '12' => 'HTTP Connect Timeout', '13' => 'HTTP Socket Error', '14' => 'HTTP SSL handshake failed', '15' => 'DNS Socket error', '16' => 'DNS Timeout', '17' => 'DNS Error', '19' => 'Invalid URI scheme', '20' => 'Socket Timeout', '21' => 'Pattern found', '22' => 'Max retries has been reached', '30' => 'Email notification => {0}', '31' => 'SMS notification => {0}', '520' => '520 Web server is returning an unknown error', '80' => 'Invoice <a href=\'/api/invoices/pdf/{0}\' target=\'_blank\'>{0}</a> was created', '81' => 'Invoice <a href=\'/api/invoices/pdf/{0}\' target=\'_blank\'>{0}</a>, payment succeeded', '82' => 'Invoice <a href=\'/api/invoices/pdf/{0}\' target=\'_blank\'>{0}</a>, payment failed', '83' => 'Subscribed to {1} {2} plan with {3} URL', '84' => 'Subscription will be canceled at end of current period', '85' => 'Subscription was canceled', '86' => 'Subscription was updated', '90' => 'Addons => {1} SMS was added', '100' => '100 Continue', '101' => '101 Switching Protocols', '102' => '102 Processing', '118' => '118 Connection timed out', '200' => '200 Ok', '201' => '201 Created', '202' => '202 Accepted', '203' => '203 Non-Authoritative Information', '204' => '204 No Content', '205' => '205 Reset Content', '206' => '206 Partial Content', '207' => '207 Multi-Status', '210' => '210 Content Different', '226' => '226 IM Used', '300' => '300 Multiple Choices', '301' => '301 Moved Permanently', '302' => '302 Moved Temporarily', '303' => '303 See Other', '304' => '304 Not Modified', '305' => '305 Use Proxy', '307' => '307 Temporary Redirect', '308' => '308 Permanent Redirect', '310' => '310 Too many Redirects', '400' => '400 Bad Request', '401' => '401 Unauthorized', '402' => '402 Payment Required', '403' => '403 Forbidden', '404' => '404 Not Found', '405' => '405 Method Not Allowed', '406' => '406 Not Acceptable', '407' => '407 Proxy Authentication', '408' => '408 Request Time-out', '409' => '409 Conflict', '410' => '410 Gone', '411' => '411 Length Required', '412' => '412 Precondition Failed', '413' => '413 Request Entity Too Large', '414' => '414 Request-URI Too Long', '415' => '415 Unsupported Media Type', '416' => '416 Requested range unsatisfiable', '417' => '417 Expectation failed', '418' => '418 I\u2019m a teapot', '422' => '422 Unprocessable entity', '423' => '423 Locked', '424' => '424 Method failure', '425' => '425 Unordered Collection', '426' => '426 Upgrade Required', '428' => '428 Precondition Required', '429' => '429 Too Many Requests', '431' => '431 Request Header Fields Too Large', '501' => '501 Not Implemented', '449' => '449 Retry With', '450' => '450 Blocked by Windows Parental Controls', '456' => '456 Unrecoverable Error', '510' => '510 Not extended', '509' => '509 Bandwidth Limit Exceeded', '499' => '499 Client has closed connection', '500' => '500 Internal Server Error', '-2' => 'Unschedule', '502' => '502 Bad Gateway ou Proxy Error', '503' => '503 Service Unavailable', '504' => '504 Gateway Time-out', '505' => '505 HTTP Version not supported', '506' => '506 Variant also negociate', '507' => '507 Insufficient storage', '508' => '508 Loop detected', '-3' => 'Disable', '-1' => 'Pending' );

        if ( $messages[$code] ) {
                $message = $messages[$code];
        } else {
                $message = 'Undefined';
        }

        return $message;

}

function cmws_log( $data ) {

	$state = cmws_state( 'log', $data['state'] );
	$label = cmws_label( 'log', $data['state'] );
	$date = cmws_date( $data['timestamp'], 'full' );
	$source = 'all';
	$message = cmws_message( $data['msg'] );
	$display = cmws_display( $data['timestamp'] );

        return array( 'state' => $state, 'label' => $label, 'date' => $date, 'source' => $source, 'message' => $message, 'display' => $display );
}

function cmws_infos( $data ) {

	// Define dns expiration.
	if ( isset( $data['status']['metas']['dns_expiration_timestamp'] ) ) {
		$dns_expiration['name'] = 'DNS Expiration';
       		$dns_expiration['data'] = cmws_date( $data['status']['metas']['dns_expiration_timestamp'], 'date' );
		$dns_expiration['label'] = 'info';
	} else {
		$dns_expiration = false;
	}

	// Define ssl cert expiration.
        if ( isset( $data['status']['metas']['ssl_cert_expiration_timestamp'] ) ) {
                $ssl_expiration['name'] = 'SSL Expiration';
                $ssl_expiration['data'] = cmws_date( $data['status']['metas']['ssl_cert_expiration_timestamp'], 'date' );
                $ssl_expiration['label'] = 'info';
        } else {
                $ssl_expiration = false;
        }

	// Define requests.
	if ( isset( $data['status']['metas']['requests'] ) ) {
		$requests['name'] = 'Number of HTTP requests';
        	$requests['data'] = $data['status']['metas']['requests'];
		if ( $data['status']['metas']['requests'] >= 100 ) {
                	$requests['label'] = 'danger';
        	} elseif ( ( $data['status']['metas']['requests'] >= 50 ) && ( $data['status']['metas']['requests'] < 100 ) ) {
                	$requests['label'] = 'warning';
        	} else {
			$requests['label'] = 'success';
		}
	} else {
                $requests = false;
        }

	// Define not found.
        if ( isset( $data['status']['metas']['notFound'] ) ) {
		$not_found['name'] = 'Number of HTTP 404 responses';
        	$not_found['data'] = $data['status']['metas']['notFound'];
		if ( $data['status']['metas']['notFound'] >= 1 ) {
               		$not_found['label'] = 'danger';
        	} else {
                	$not_found['label'] = 'success';
        	}
	} else {
                $not_found = false;
        }

	// Define js errors.
        if ( isset( $data['status']['metas']['jsErrors'] ) ) {
		$js_errors['name'] = 'Number of JavaScript errors';
        	$js_errors['data'] = $data['status']['metas']['jsErrors'];
		if ( $data['status']['metas']['jsErrors'] >= 1 ) {
                	$js_errors['label'] = 'warning';
        	} else {
                	$js_errors['label'] = 'success';
        	}
	} else {
                $js_errors = false;
        }

	// Define redirects.
        if ( isset( $data['status']['metas']['redirects'] ) ) {
		$redirects['name'] = 'Number of HTTP redirects (301 or 302)';
        	$redirects['data'] = $data['status']['metas']['redirects'];
		if ( $data['status']['metas']['redirects'] >= 2 ) {
			$redirects['label'] = 'warning';
		} else {
			$redirects['label'] = 'success';
		}
	} else {
                $redirects = false;
        }

	return array( 'dns_expiration' => $dns_expiration, 'ssl_expiration' => $ssl_expiration, 'requests' => $requests, 'not_found' => $not_found, 'js_errors' => $js_errors, 'redirects' => $redirects );

}

function cmws_global( $data ) {

	// Define api key.
	$id = $data['status']['_id'];

	// Define url.
	$url = $data['status']['url'];

	// Define state and label.
        $state = cmws_state( 'poller', $data['status']['state'] );
        $label = cmws_label( 'poller', $data['status']['state'] );

	// Define last date and time.
        $last_date = cmws_date( $data['status']['laststatechange_bin'], 'full' );
	$last_time = cmws_date( $data['status']['laststatechange_bin'], 'time' );
        $state_duration = cmws_date_diff( $data['status']['laststatechange_bin'] );

	// Define last time response.
	$last_key = key( array_slice( $data['day']['series']['checks.' . $id . '.httptime']['data'], -1, 1, TRUE ) );
        $last_time_response = round( $data['day']['series']['checks.' . $id . '.httptime']['data'][$last_key][1] );

	// Define average time (24h).
	$sum = $count = 0;
        foreach ( $data['day']['series']['checks.' . $id . '.httptime']['data'] as $key => $values ) {
		//$day_interval = cmws_display( $values[0] );
		//if ( $day_interval == '1' ) {
                	$sum = $sum + $values[1];
                	$count = $count +1;
		//}
        }
      	$average_time = floor( $sum / $count );

	// Define availability (24h).
	$last_key = key( array_slice( $data['week']['series']['checks.' . $id . '.state.all']['data'], -1, 1, TRUE ) );
        $availability = round( $data['week']['series']['checks.' . $id . '.state.all']['data'][$last_key][1], 2 );

        return array( 'url' => $url, 'state' => $state, 'label' => $label, 'last_date' => $last_date, 'last_time' => $last_time, 'state_duration' => $state_duration, 'last_time_response' => $last_time_response, 'average_time' => $average_time, 'availability' => $availability );

}

function cmws_data( $data ) {

	if ( isset( $data ) ) {

		if ( isset( $data['status'] ) ) {
			
			// Define and fill global array.
			$global = cmws_global( $data );
			
			$infos = cmws_infos( $data );

			// Define and fill pollers array.
                	foreach ( $data['status']['lastvalues']['httptime'] as $key => $value ) {
                        	$pollers[$key] = cmws_poller( $key, $value, $data['status']['states'][$key] );
                	}

			// Define and fill yslow array.
	                $yslow = cmws_yslow( $data['status']['metas'] );
			
                } else {
                        $global = $infos = $pollers = $yslow = false;
                }

		// Define and fill logs array.
		if ( isset( $data['logs'][0] ) ) { 
			foreach ( $data['logs'] as $key => $value ) {
                        	$logs[$key] = cmws_log( $data['logs'][$key] );
                	}
		} else {
			$logs = false;
		}

        } else {

		// Define arrays to false.
		$global = $infos = $pollers = $logs = $yslow = false;

        }

	return array( 'global' => $global, 'infos' => $infos, 'pollers' => $pollers, 'logs' => $logs, 'yslow' => $yslow );

}

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

function cmws_timezone( $timestamp ) {

        $timezone_offet = get_option( 'gmt_offset' );

        $timestamp_to_timezone = new DateTime();
        $timestamp_to_timezone->setTimestamp( $timestamp );

        $timezoned =  $timestamp_to_timezone->getTimestamp() + ( $timezone_offet * 3600 );

        return $timezoned;

}

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
