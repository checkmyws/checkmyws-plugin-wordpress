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

		// Define html.
		$html = '';

		// Load default parameters.
                $options = get_option( 'cmws_settings' );
		$default_api_key = $options['api_key'];
		$default_unit = $options['default_unit'];

                // Load api data.
                if ( isset( $default_api_key ) ) {
                        $api = new Check_my_Website_Api( $default_api_key );
                        $data = cmws_data( $api->get_api_data() );
                } else {
                        $data = NULL;
			return __( 'No data', 'check-my-website' );
                }

		// Extract arguments.
		extract(
    			shortcode_atts(
      				array(
					'display' => 'full',
					'label' => 'true',
					'url' => 'false',
					'state' => 'false',
					'duration' => 'false',
					'grade' => 'false',
					'score' => 'false',
					'availability' => 'false',
					'response' => 'false',
					'average' => 'false'
				), 
				$atts
			)
		);

		// Check display parameter.
		if ( ( $display == 'full' ) || ( $display == 'custom' ) ) {
			if ( $display == 'full' ) :
				$url = $state = $duration = $grade = $score = $availability = $response = $average = 'true';
			endif;
                } else {
			return __( 'Bad parameters', 'check-my-website' );
		}

		// Check url parameter.
		if ( $url == 'true' ) {
			if ( $html ) :
                                $html = $html . '<br/>';
                        endif;
                        if ( $label == 'true' ) :
                                $html = $html . __( 'Url', 'check-my-website' ) . ' : ';
                        endif;
			if ( isset( $data['global']['url'] ) ) :
	                	$html = $html . '<a href="' . $data['global']['url'] . '">' . $data['global']['url'] . '</a>';
			else :
				$html = $html . __( 'No data', 'check-my-website' );
			endif;
                } elseif ( $url != 'false' ) {
			return __( 'Bad parameters', 'check-my-website' );
		}

		// Check state parameter.
		if ( $state == 'true' ) {
                        if ( $html ) :
                                $html = $html . '<br/>';
                        endif;
			if ( $label == 'true' ) :
                                $html = $html . __( 'State', 'check-my-website' ) . ' : ';
                        endif;
			if ( isset( $data['global']['state'] ) ) :
	                        $html = $html . $data['global']['state'];
			else :
                                $html = $html . __( 'No data', 'check-my-website' );
                        endif;
                } elseif ( $state != 'false' ) {
                        return __( 'Bad parameters', 'check-my-website' );
                }

		// Check duration parameter.
		if ( $duration == 'true' ) {
                        if ( $html ) :
                                $html = $html . '<br/>';
                        endif;
                        if ( $label == 'true' ) :
                                $html = $html . __( 'State duration', 'check-my-website' ) . ' : ';
                        endif;
			if ( isset( $data['global']['state_duration'] ) ) :
	                        $html = $html . $data['global']['state_duration'] . ' ' .__( 'day(s)', 'check-my-website' );
			else :
                                $html = $html . __( 'No data', 'check-my-website' );
                        endif;
                } elseif ( $url != 'false' ) {
                        return __( 'Bad parameters', 'check-my-website' );
                }

		// Check grade parameter.
		if ( $grade == 'true' ) {
                	if ( $html ) :
                        	$html = $html . '<br/>';
                        endif;
			if ( $label == 'true' ) :
                                $html = $html . __( 'Grade', 'check-my-website' ) . ' : ';
                        endif;
			if ( isset( $data['yslow']['grade'] ) ) :
	                        $html = $html . $data['yslow']['grade'];
			else :
                                $html = $html . __( 'No data', 'check-my-website' );
                        endif;
                } elseif ( $duration != 'false' ) {
                        return __( 'Bad parameters', 'check-my-website' );
                }

		// Check score parameter.
		if ( $score == 'true' ) {
                        if ( $html ) :
                        	$html = $html . '<br/>';
                        endif;
			if ( $label == 'true' ) :
                                $html = $html . __( 'Score', 'check-my-website' ) . ' : ';
                        endif;
			if ( isset( $data['yslow']['score'] ) ) :
                	$html = $html . $data['yslow']['score'];
			else :
                                $html = $html . __( 'No data', 'check-my-website' );
                        endif;
                } elseif ( $score != 'false' ) {
                        return __( 'Bad parameters', 'check-my-website' );
                }

		// Check availability parameter.
		if ( $availability == 'true' ) {
                        if ( $html ) :
                                $html = $html . '<br/>';
                        endif;
                        if ( $label == 'true' ) :
                                $html = $html . __('Availability', 'check-my-website' ) . ' (24h) : ';
                        endif;
			if ( isset( $data['global']['availability'] ) ) :
	                        $html = $html . $data['global']['availability'] . ' %';
			else :
                                $html = $html . __( 'No data', 'check-my-website' );
                        endif;
                } elseif ( $availability != 'false' ) {
                        return __( 'Bad parameters', 'check-my-website' );
                }

		// Check response parameter.
		if ( $response == 'true' ) {
                        if ( $html ) :
                        	$html = $html . '<br/>';
                        endif;
			if ( $label == 'true' ) :
                                $html = $html . __( 'Response time', 'check-my-website' ) . ' : ';
                        endif;
			if ( isset( $data['global']['latest_response_time'] ) ) :
	                	$html = $html . cmws_convert( $data['global']['latest_response_time'], $default_unit ) . ' ' . $default_unit;
			else :
                                $html = $html . __( 'No data', 'check-my-website' );
                        endif;
                } elseif ( $response != 'false' ) {
                        return __( 'Bad parameters', 'check-my-website' );
                }


		// Check average parameter.
		if ( $average == 'true' ) {
                        if ( $html ) :
                                $html = $html . '<br/>';
                        endif;
                        if ( $label == 'true' ) :
                                $html = $html . __( 'Average', 'check-my-website' ) . ' (24h) : ';
                        endif;
			if ( isset( $data['global']['average_time'] ) ) :
	                        $html = $html . cmws_convert( $data['global']['average_time'], $default_unit ) . ' ' . $default_unit;
			else :
                                $html = $html . __( 'No data', 'check-my-website' );
                        endif;
                } elseif ( $average != 'false' ) {
                        return __( 'Bad parameters', 'check-my-website' );
                }

		// Return data to display.
		return $html;

        }

}
?>
