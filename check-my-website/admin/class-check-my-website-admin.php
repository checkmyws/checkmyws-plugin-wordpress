<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and hooks for
 * enqueue styles, scripts, widgets and pages.
 *
 * @link       https://checkmy.ws
 * @since      1.0.0
 *
 * @package    check-my-website
 * @subpackage check-my-website/admin
 * @author     Check my Website by NOVATEEK <contact@checkmy.ws>
 */
class Check_my_Website_Admin {

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
	 * @var      string    $plugin_name       The name of this plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin-side.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/check-my-website-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the javascripts for the admin-side.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name . '-admin', plugin_dir_url( __FILE__ ) . 'js/check-my-website-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name . '-flot', plugin_dir_url( __FILE__ ) . 'js/flot/jquery.flot.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name . '-flot-time', plugin_dir_url( __FILE__ ) . 'js/flot/jquery.flot.time.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name . '-flot-threshold', plugin_dir_url( __FILE__ ) . 'js/flot/jquery.flot.threshold.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name . '-flot-tooltip', plugin_dir_url( __FILE__ ) . 'js/flot/jquery.flot.tooltip.js', array( 'jquery' ), $this->version, false );

	}

	/**
         * Register the dashboard widgets for the admin-side.
         *
         * @since    1.0.0
         */
        public function enqueue_widgets() {

                wp_add_dashboard_widget( $this->plugin_name, 'Check my Website', array( $this, 'dashboard_widget' ) );

        }

	/**
         * Register the pages for the admin-side.
         *
         * @since    1.0.0
         */
        public function enqueue_pages() {

		// Register the settings page of the plugin.
                add_options_page( 'Check my Website', 'Check my Website', 'manage_options', 'check-my-website-settings', array( $this, 'settings_page' ) );

		// Register the dashboard page of the plugin.
		add_dashboard_page( 'Check my Website', 'Check my Website', 'manage_options', 'check-my-website', array( $this, 'dashboard_page' ) );

        }

	/**
         * Register the settings sections for the settings page of the plugin.
         *
         * @since    1.0.0
         */
        private function enqueue_sections() {

		add_settings_section('api_section', 'API', array( $this, 'section_api'), 'check-my-website-settings');
		add_settings_section('options_section', 'Options', array( $this, 'section_options'), 'check-my-website-settings');

        }

	/**
         * Register the settings fields for the settings sections.
         *
         * @since    1.0.0
         */
        private function enqueue_fields() {

		add_settings_field('api_key', __( 'URL ID', 'check-my-website' ), array( $this, 'set_api_key'), 'check-my-website-settings', 'api_section');
		add_settings_field('api_interval', __( 'Request interval', 'check-my-website' ), array( $this, 'set_api_interval'), 'check-my-website-settings', 'api_section');
		add_settings_field('default_style', __( 'Default style', 'check-my-website' ), array( $this, 'set_default_style'), 'check-my-website-settings', 'options_section');
		add_settings_field('default_unit', __( 'Default time unit', 'check-my-website' ), array( $this, 'set_default_unit'), 'check-my-website-settings', 'options_section');
		add_settings_field('shortcode', __( 'Enable shortcode', 'check-my-website' ), array( $this, 'set_shortcode'), 'check-my-website-settings', 'options_section');
		add_settings_field('dashboard_widget', __( 'Show dashboard widget', 'check-my-website' ), array( $this, 'set_dashboard_widget'), 'check-my-website-settings', 'options_section');
		add_settings_field('widget', __( 'Show widget', 'check-my-website' ), array( $this, 'set_widget'), 'check-my-website-settings', 'options_section');

        }

	/**
         * Register the settings and sanitizations for the settings page of the plugin.
         *
         * @since    1.0.0
         */
        public function enqueue_settings() {

		// Load settings sections and fields to register.
		$this->enqueue_sections();
		$this->enqueue_fields();

		// Register and save settings.
		register_setting( 'cmws_settings', 'cmws_settings', array( $this, 'validate') );

        }

	/**
         * Sanitize the saved settings values of the settings page of the plugin.
         *
         * @since    1.0.0
	 * @var      array    $inputs       The saved settings values of the  plugin.
         */
        public function validate( $inputs ) {

		//$options = get_option(' checkmyws_options ');
                //$options['checkmyws-settings-url-id'] = ( $inputs['checkmyws-settings-url-id'] );

                return $inputs;

        }

	/**
         * Display the api section in the settings page of the plugin.
         *
         * @since    1.0.0
         */
        public function section_api() {

		echo '<p>' . __( 'Set Check my Website API parameters.', 'check-my-website' ) . '<br/>';
		echo '<em>' . __( 'Note: you must have a subscription account to enable API access and get data.', 'check-my-website' )  . '</em></p>';

        }

	/**
         * Display the options section in the settings page of the plugin.
         *
         * @since    1.0.0
         */
        public function section_options() {

                echo '<p>' . __( 'Set general options.', 'check-my-website' ) . '</p>';

        }

	/**
         * Display the key field in the settings page of the plugin.
         *
         * @since    1.0.0
         */
        public function set_api_key() {

		$options = get_option( 'cmws_settings' );
                echo '<input type="text" name="cmws_settings[api_key]" placeholder="624e853d-b0f3-9bf9-8417-c7157aze7t" value="' . $options['api_key'] . '" />';

        }

	/**
         * Display the interval field in the settings page of the plugin.
         *
         * @since    1.0.0
         */
        public function set_api_interval() {

		$options = get_option( 'cmws_settings' );

		$values = array( '1', '5', '10' );

		echo '<select name="cmws_settings[api_interval]">';
			foreach ( $values as $value ) {
				echo '<option value="' .  $value . '" ' . selected( $options['api_interval'], $value ) . '>' . $value . ' minute(s)</option>';
			}
		echo '</select>';

        }

	/**
         * Display the style field in the settings page of the plugin.
         *
         * @since    1.0.0
         */
        public function set_default_style() {

		$options = get_option( 'cmws_settings' );

		$styles = array( 'check-my-website-classic' => 'Classic', 'check-my-website-light' => 'Light', 'check-my-website-dark' => 'Dark' );

                echo '<select name="cmws_settings[default_style]">';
                        foreach ( $styles as $key => $value ) {
                                echo '<option value="' .  $key . '" ' . selected( $options['default_style'], $key ) . '>' . $value . '</option>';
                        }
                echo '</select>';

        }

	/**
         * Display the unit field in the settings page of the plugin.
         *
         * @since    1.0.0
         */
        public function set_default_unit() {

		$options = get_option( 'cmws_settings' );

                $units = array( 'ms' => 'Millisecond', 's' => 'Second' );

                echo '<select name="cmws_settings[default_unit]">';
                        foreach ( $units as $key => $value ) {
                                echo '<option value="' .  $key . '" ' . selected( $options['default_unit'], $key ) . '>' . $value . '</option>';
                        }
                echo '</select>';

        }

	/**
         * Display the shortcode field in the settings page of the plugin.
         *
         * @since    1.0.0
         */
        public function set_shortcode() {

                $options = get_option( 'cmws_settings' );
		echo '<input type="hidden" name="cmws_settings[shortcode]" value="0" />';
		echo '<input type="checkbox" name="cmws_settings[shortcode]" id="shortcode" value="1" ' . checked( $options['shortcode'], 1, false ) . '/>';

        }

	/**
         * Display the dashboard widget field in the settings page of the plugin.
         *
         * @since    1.0.0
         */
        public function set_dashboard_widget() {

		$options = get_option( 'cmws_settings' );
		echo '<input type="hidden" name="cmws_settings[dashboard_widget]" value="0" />';
                echo '<input type="checkbox" name="cmws_settings[dashboard_widget]" id="dashboard_widget" value="1" ' . checked( $options['dashboard_widget'], 1, false ) . '/>';

        }

	/**
         * Display the widget field in the settings page of the plugin.
         *
         * @since    1.0.0
         */
        public function set_widget() {

                $options = get_option( 'cmws_settings' );
                echo '<input type="hidden" name="cmws_settings[widget]" value="0" />';
                echo '<input type="checkbox" name="cmws_settings[widget]" id="widget" value="1" ' . checked( $options['widget'], 1, false ) . '/>';

        }

	/**
         * Display the settings page of the plugin.
         *
         * @since    1.0.0
         */
        public function settings_page() {

		global $pagenow;

                $current = 'settings';

		// Define page tabs.
                $tabs = array( 'settings' => __( 'Settings', 'check-my-website' ), 'dashboard' => __( 'Go to Dashboard', 'check-my-website' ) );

                if ( isset ( $_GET['tab'] ) ) {
                        $current = $_GET['tab'];
                };

		settings_errors( 'cmws_settings', false );

		// Display page.
		include( plugin_dir_path( __FILE__ ) . 'partials/check-my-website-admin-header.php' );
                include( plugin_dir_path( __FILE__ ) . 'partials/check-my-website-admin-settings.php' );
                include( plugin_dir_path( __FILE__ ) . 'partials/check-my-website-admin-footer.php' );

        }

	/**
         * Display the dashboard page of the plugin.
         *
         * @since    1.0.0
         */
        public function dashboard_page() {

		global $pagenow;

		$current = 'overview';

		// Define page tabs.
		$tabs = array( 'overview' => __( 'Overview', 'check-my-website' ), 'logs' => __( 'Logs', 'check-my-website' ), 'metrics' => __( 'Metrics', 'check-my-website' ), 'settings' => __( 'Go to Settings', 'check-my-website' ) );

		if ( isset ( $_GET['tab'] ) ) {
			$current = $_GET['tab']; 
		};

		// Load default parameters.
		$options = get_option( 'cmws_settings' );
                $default_api_key = $options['api_key'];
		$default_style = $options['default_style'];
		$default_unit = $options['default_unit'];

		// Load api data.
		if ( isset( $default_api_key ) ) { 
                	$api = new Check_my_Website_Api( $default_api_key );
			$data = cmws_data( $api->get_api_data() );
		} else {
			$data = NULL;
		}	
	
		// Display page.	
		include( plugin_dir_path( __FILE__ ) . 'partials/check-my-website-admin-header.php' );
                include( plugin_dir_path( __FILE__ ) . 'partials/check-my-website-admin-dashboard.php' );
		include( plugin_dir_path( __FILE__ ) . 'partials/check-my-website-admin-footer.php' );

        }

	/**
         * Display the dashboard widget of the plugin.
         *
         * @since    1.0.0
         */
        public function dashboard_widget() {

		// Load default parameters.
                $options = get_option( 'cmws_settings' );
                $default_api_key = $options['api_key'];
                $default_style = $options['default_style'];
                $default_unit = $options['default_unit'];

                // Load api data.
                if ( isset( $default_api_key ) ) {
                        $api = new Check_my_Website_Api( $default_api_key );
                        $data = cmws_data( $api->get_api_data() );
                } else {
                        $data = NULL;
                }

		// Display dashboard widget.
                include( plugin_dir_path( __FILE__ ) . 'partials/check-my-website-admin-dashboard-widget.php' );

        }

}

?>
