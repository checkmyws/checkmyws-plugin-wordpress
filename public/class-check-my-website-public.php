<?php
/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and hooks for
 * enqueue styles, scripts, widgets and shortcodes.
 *
 * @link       https://checkmy.ws
 * @since      1.0.0
 *
 * @package    check-my-website
 * @subpackage check-my-website/public
 * @author     Check my Website by NOVATEEK <contact@checkmy.ws>
 */
class Check_my_Website_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $plugin_name       The name of the plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		// Set variables.
		$this->plugin_name = $plugin_name;
		$this->version = $version;

		// Load plugin settings.
                $options = get_option( 'cmws_settings' );

                // Load shortcode according to plugin settings.
                if ( $options['shortcode'] == 1 ) {
                        add_shortcode( 'cmws', array( $this, 'shortcode' ) );
                };

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/check-my-website-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the javascripts for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		//wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/check-my-website-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
         * Define the shortcodes for the public-facing side of the site.
         *
         * @since    1.0.0
         */
        public function shortcode( $atts ) {

		$html = NULL;

		// Load default parameters.
                $options = get_option( 'cmws_settings' );
		$default_api_key = $options['api_key'];

                // Load api data.
                if ( isset( $default_api_key ) ) {
                        $api = new Check_my_Website_Api( $default_api_key );
                        $data = cmws_data( $api->get_api_data() );
                } else {
                        $data = NULL;
                }

		// Extract arguments.
		extract(
    			shortcode_atts(
      				array(
					'title' => 'Article',
					'latest' => false
				), 
				$atts
			)
		);

		if ( $latest ) :
			$html = $html . ' Latest time response : ' . $data['global']['last_time_response'];
		endif;

		return $html;

        }

}
?>
