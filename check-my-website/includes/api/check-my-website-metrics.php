<?php

/**
 * Display api data to json format.
 *
 * This is used to get and display api data from database.
 *
 * @link       https://checkmy.ws
 * @since      1.0.0
 *
 * @package    check-my-website
 * @subpackage check-my-website/includes/api
 * @author     Check my Website by NOVATEEK <contact@checkmy.ws>
 */

/**
 * Define header content-type to json.
 */
header('Content-type: application/json');

/**
 * Load wordpress functions.
 */
//require_once $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php';
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );

/**
 * Include the class responsible for defining all actions that occur with the api.
 */
require_once '../classes/class-check-my-website-api.php';

/**
 * Get api data and convert it to json.
 */
$options = get_option( 'cmws_settings' );
$api = new Check_my_Website_Api( $options['api_key'] );
$data = json_encode( $api->get_api_data() );

/**
 * Display data.
 */
echo $data;

?>
