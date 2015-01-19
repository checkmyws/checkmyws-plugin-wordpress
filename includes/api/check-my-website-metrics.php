<?php

/**
 * Display api data to json format. 
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
 */

/**
 * Define header content-type to json.
 */
header('Content-type: application/json');

/**
 * Load wordpress functions.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php';

/**
 * Include the class responsible for defining all actions that occur with the api.
 */
require_once '../classes/class-check-my-website-api.php';

/**
 * Get api data and convert it to json.
 */
$api = new Check_my_Website_Api( '624e853d-90f3-4bf9-8417-c78157ed38e4' );
$data = json_encode( $api->get_api_data() );

/**
 * Display data.
 */
echo $data;

?>