<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 * @author     Your Name <email@example.com>
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
	 * Register the stylesheets for the Dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Admin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Admin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/check-my-website-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Admin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Admin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/check-my-website-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
         * Register the widgets for the dashboard.
         *
         * @since    1.0.0
         */
        public function enqueue_widgets() {

                /**
                 * This function is provided for demonstration purposes only.
                 *
                 * An instance of this class should be passed to the run() function
                 * defined in Plugin_Name_Admin_Loader as all of the hooks are defined
                 * in that particular class.
                 *
                 * The Plugin_Name_Admin_Loader will then create the relationship
                 * between the defined hooks and the functions defined in this
                 * class.
                 */

                wp_add_dashboard_widget( $this->plugin_name, 'Check my Website', array( $this, 'widget' ) );

        }

	/**
         * Register the Pages for the dashboard.
         *
         * @since    1.0.0
         */
        public function enqueue_pages() {

                /**
                 * This function is provided for demonstration purposes only.
                 *
                 * An instance of this class should be passed to the run() function
                 * defined in Plugin_Name_Admin_Loader as all of the hooks are defined
                 * in that particular class.
                 *
                 * The Plugin_Name_Admin_Loader will then create the relationship
                 * between the defined hooks and the functions defined in this
                 * class.
                 */

                add_options_page( 'Check my Website', 'Check my Website', 'manage_options', 'check-my-website-setting', array( $this, 'setting' ) );
		add_dashboard_page( 'Check my Website', 'Check my Website', 'manage_options', 'check-my-website', array( $this, 'dashboard' ) );

        }

	/**
         * Register the Settings Sections for the dashboard.
         *
         * @since    1.0.0
         */
        public function enqueue_sections() {

                /**
                 * This function is provided for demonstration purposes only.
                 *
                 * An instance of this class should be passed to the run() function
                 * defined in Plugin_Name_Admin_Loader as all of the hooks are defined
                 * in that particular class.
                 *
                 * The Plugin_Name_Admin_Loader will then create the relationship
                 * between the defined hooks and the functions defined in this
                 * class.
                 */

                //add_settings_section( 'checkmyws-settings-url', 'URL', array( $this, 'url_section' ), 'check-my-website-setting' );
                //add_settings_section( 'checkmyws-settings-style', 'Style', array( $this, 'style_section' ), 'check-my-website-setting' );
		//add_settings_section('homepage_settings', 'Homepage Settings', array( $this, 'section_homepage'), 'check-my-website-setting');
		//add_settings_section('footer_settings', 'Footer Settings', array( $this, 'section_footer'), 'check-my-website-setting');
		add_settings_section('general_settings', 'General', array( $this, 'define_general_section'), 'check-my-website-setting');
		add_settings_section('supplements_settings', 'Supplements', array( $this, 'define_supplements_section'), 'check-my-website-setting');

        }

	/**
         * Register the Settings Fields for the dashboard.
         *
         * @since    1.0.0
         */
        public function enqueue_fields() {

                /**
                 * This function is provided for demonstration purposes only.
                 *
                 * An instance of this class should be passed to the run() function
                 * defined in Plugin_Name_Admin_Loader as all of the hooks are defined
                 * in that particular class.
                 *
                 * The Plugin_Name_Admin_Loader will then create the relationship
                 * between the defined hooks and the functions defined in this
                 * class.
                 */

                //add_settings_field( 'checkmyws-settings-url-id', 'Default URL ID code', array( $this, 'url_option' ), 'check-my-website-setting', 'checkmyws-settings-url' );
                //add_settings_field( 'checkmyws-settings-style-select', 'Default style', array( $this, 'style_option' ), 'check-my-website-setting', 'checkmyws-settings-style' );
		//add_settings_field('button1text', 'Button 1 Text', array( $this, 'button1text_setting'), 'check-my-website-setting', 'homepage_settings');
		add_settings_field('key', 'API key', array( $this, 'define_key'), 'check-my-website-setting', 'general_settings');
		add_settings_field('interval', 'Request interval', array( $this, 'define_interval'), 'check-my-website-setting', 'general_settings');
		add_settings_field('style', 'Style', array( $this, 'define_style'), 'check-my-website-setting', 'general_settings');
		add_settings_field('unit', 'Time unit', array( $this, 'define_unit'), 'check-my-website-setting', 'general_settings');
		add_settings_field('shortcode', 'Shortcode', array( $this, 'define_shortcode'), 'check-my-website-setting', 'supplements_settings');
		add_settings_field('widget', 'Widget', array( $this, 'define_widget'), 'check-my-website-setting', 'supplements_settings');

        }

function section_homepage() {}
	function section_footer() {}

	/**
         * Register the Settings for the dashboard.
         *
         * @since    1.0.0
         */
        public function enqueue_settings() {

                /**
                 * This function is provided for demonstration purposes only.
                 *
                 * An instance of this class should be passed to the run() function
                 * defined in Plugin_Name_Admin_Loader as all of the hooks are defined
                 * in that particular class.
                 *
                 * The Plugin_Name_Admin_Loader will then create the relationship
                 * between the defined hooks and the functions defined in this
                 * class.
                 */

		$this->enqueue_sections();
		$this->enqueue_fields();

                //register_setting( 'checkmyws-settings-options', 'checkmyws_options', array( $this, 'validate') );
		//register_setting('theme_options', 'theme_options', array( $this, 'validate_setting'));
		register_setting( 'check_my_website_settings', 'check_my_website_settings', array( $this, 'validate_setting') );

        }

function validate_setting($theme_options) {
	return $theme_options;
}

function button1text_setting() {
	$options = get_option('theme_options');
	echo '<input name="theme_options[button1text_setting]" type="text" value="' . $options['button1text_setting'] . '" />';
}

function phonenumber() {
	$options = get_option('theme_options');
	echo '<input name="theme_options[phonenumber]" type="text" value="' . $options['phonenumber'] . '" />';
}

	// Validate option entered
        function validate( $arr_input ) {

		$options = get_option(' checkmyws_options ');
                $options['checkmyws-settings-url-id'] = ( $arr_input['checkmyws-settings-url-id'] );

                return $options;

        }

	/**
         * Display the Url Section in the Setting Page for the dashboard.
         *
         * @since    1.0.0
         */
        public function define_general_section() {

                /**
                 * This function is provided for demonstration purposes only.
                 *
                 * An instance of this class should be passed to the run() function
                 * defined in Plugin_Name_Admin_Loader as all of the hooks are defined
                 * in that particular class.
                 *
                 * The Plugin_Name_Admin_Loader will then create the relationship
                 * between the defined hooks and the functions defined in this
                 * class.
                 */

		echo '<p>Settings to get data from Check my Website API and display it.</p>';

        }

	/**
         * Display the Url Section in the Setting Page for the dashboard.
         *
         * @since    1.0.0
         */
        public function define_supplements_section() {

                /**
                 * This function is provided for demonstration purposes only.
                 *
                 * An instance of this class should be passed to the run() function
                 * defined in Plugin_Name_Admin_Loader as all of the hooks are defined
                 * in that particular class.
                 *
                 * The Plugin_Name_Admin_Loader will then create the relationship
                 * between the defined hooks and the functions defined in this
                 * class.
                 */

                echo '<p>Settings to disable/enable Check my Website shortcode and widget.</p>';

        }

	/**
         * Display the Url Option in the Setting Page for the dashboard.
         *
         * @since    1.0.0
         */
        public function define_key() {

                /**
                 * This function is provided for demonstration purposes only.
                 *
                 * An instance of this class should be passed to the run() function
                 * defined in Plugin_Name_Admin_Loader as all of the hooks are defined
                 * in that particular class.
                 *
                 * The Plugin_Name_Admin_Loader will then create the relationship
                 * between the defined hooks and the functions defined in this
                 * class.
                 */

		$options = get_option( 'check_my_website_settings' );

                echo '<input type="text" name="check_my_website_settings[key]" value="' . $options['key'] . '" />';

        }

	/**
         * Display the Style Section in the Setting Page for the dashboard.
         *
         * @since    1.0.0
         */
        public function define_interval() {

                /**
                 * This function is provided for demonstration purposes only.
                 *
                 * An instance of this class should be passed to the run() function
                 * defined in Plugin_Name_Admin_Loader as all of the hooks are defined
                 * in that particular class.
                 *
                 * The Plugin_Name_Admin_Loader will then create the relationship
                 * between the defined hooks and the functions defined in this
                 * class.
                 */

		$options = get_option( 'check_my_website_settings' );

		$values = array( '1', '5', '10' );

		echo '<select name="check_my_website_settings[interval]">';
			foreach ( $values as $value ) {
				echo '<option value="' .  $value . '" ' . selected( $options['interval'], $value ) . '>' . $value . ' minute(s)</option>';
			}
		echo '</select>';

        }

	/**
         * Display the Style Option in the Setting Page for the dashboard.
         *
         * @since    1.0.0
         */
        public function define_style() {

                /**
                 * This function is provided for demonstration purposes only.
                 *
                 * An instance of this class should be passed to the run() function
                 * defined in Plugin_Name_Admin_Loader as all of the hooks are defined
                 * in that particular class.
                 *
                 * The Plugin_Name_Admin_Loader will then create the relationship
                 * between the defined hooks and the functions defined in this
                 * class.
                 */

		$options = get_option( 'check_my_website_settings' );

		$styles = array( 'check-my-website-classic' => 'Classic', 'check-my-website-light' => 'Light', 'check-my-website-dark' => 'Dark' );

                echo '<select name="check_my_website_settings[style]">';
                        foreach ( $styles as $key => $value ) {
                                echo '<option value="' .  $key . '" ' . selected( $options['style'], $key ) . '>' . $value . '</option>';
                        }
                echo '</select>';

        }

	/**
         * Display the Url Option in the Setting Page for the dashboard.
         *
         * @since    1.0.0
         */
        public function define_unit() {

                /**
                 * This function is provided for demonstration purposes only.
                 *
                 * An instance of this class should be passed to the run() function
                 * defined in Plugin_Name_Admin_Loader as all of the hooks are defined
                 * in that particular class.
                 *
                 * The Plugin_Name_Admin_Loader will then create the relationship
                 * between the defined hooks and the functions defined in this
                 * class.
                 */

		$options = get_option( 'check_my_website_settings' );

                $units = array( 'ms' => 'Millisecond', 's' => 'Second' );

                echo '<select name="check_my_website_settings[unit]">';
                        foreach ( $units as $key => $value ) {
                                echo '<option value="' .  $key . '" ' . selected( $options['unit'], $key ) . '>' . $value . '</option>';
                        }
                echo '</select>';

        }

	/**
         * Display the Url Option in the Setting Page for the dashboard.
         *
         * @since    1.0.0
         */
        public function define_shortcode() {

                /**
                 * This function is provided for demonstration purposes only.
                 *
                 * An instance of this class should be passed to the run() function
                 * defined in Plugin_Name_Admin_Loader as all of the hooks are defined
                 * in that particular class.
                 *
                 * The Plugin_Name_Admin_Loader will then create the relationship
                 * between the defined hooks and the functions defined in this
                 * class.
                 */

                $options = get_option( 'check_my_website_settings' );

		$values = array( 'Disable', 'Enable' );

		foreach ( $values as $value ) {
			echo '<input type="radio" name="check_my_website_settings[shortcode]" value="' . $value  . '" ' . checked( $options['shortcode'], $value, false ) . '/>' . $value . ' ';
		}

        }

	/**
         * Display the Url Option in the Setting Page for the dashboard.
         *
         * @since    1.0.0
         */
        public function define_widget() {

                /**
                 * This function is provided for demonstration purposes only.
                 *
                 * An instance of this class should be passed to the run() function
                 * defined in Plugin_Name_Admin_Loader as all of the hooks are defined
                 * in that particular class.
                 *
                 * The Plugin_Name_Admin_Loader will then create the relationship
                 * between the defined hooks and the functions defined in this
                 * class.
                 */

		$options = get_option( 'check_my_website_settings' );

                $values = array( 'None', 'Public only', 'Admin only', 'Public and Admin' );

                echo '<select name="check_my_website_settings[widget]">';
                        foreach ( $values as $value ) {
                                echo '<option value="' .  $value . '" ' . selected( $options['widget'], $value ) . '>' . $value . '</option>';
                        }
                echo '</select>';

        }

	/**
         * Display the Check my Website Settings page for the dashboard.
         *
         * @since    1.0.0
         */
        public function setting() {

                /**
                 * This function is provided for demonstration purposes only.
                 *
                 * An instance of this class should be passed to the run() function
                 * defined in Plugin_Name_Admin_Loader as all of the hooks are defined
                 * in that particular class.
                 *
                 * The Plugin_Name_Admin_Loader will then create the relationship
                 * between the defined hooks and the functions defined in this
                 * class.
                 */

		global $pagenow;

                $current = 'settings';

                $tabs = array( 'settings' => 'Settings', 'dashboard' => 'Dashboard' );

                if ( isset ( $_GET['tab'] ) ) {
                        $current = $_GET['tab'];
                };

		include( plugin_dir_path( __FILE__ ) . 'partials/check-my-website-admin-header.php' );
                include( plugin_dir_path( __FILE__ ) . 'partials/check-my-website-admin-settings.php' );
                include( plugin_dir_path( __FILE__ ) . 'partials/check-my-website-admin-footer.php' );

        }

	/**
         * Display the Check my Website page for the dashboard.
         *
         * @since    1.0.0
         */
        public function dashboard() {

                /**
                 * This function is provided for demonstration purposes only.
                 *
                 * An instance of this class should be passed to the run() function
                 * defined in Plugin_Name_Admin_Loader as all of the hooks are defined
                 * in that particular class.
                 *
                 * The Plugin_Name_Admin_Loader will then create the relationship
                 * between the defined hooks and the functions defined in this
                 * class.
                 */

		global $pagenow;

		$current = 'overview';

		$tabs = array( 'overview' => 'Overview', 'logs' => 'Logs', 'metrics' => 'Metrics', 'settings' => 'Settings' );

		if ( isset ( $_GET['tab'] ) ) {
			$current = $_GET['tab']; 
		};

		// Load default parameters.
		$options = get_option( 'check_my_website_settings' );
                $default_api_key = $options['key'];
		$default_style = $options['style'];
		$default_unit = $options['unit'];

		// Load api data.
		if ( isset( $default_api_key ) ) { 
                	$api = new Check_my_Website_Api( $default_api_key );
			$data = cmws_data( $api->get_api_data() );
		} else {
			$data = NULL;
		}	
		
		include( plugin_dir_path( __FILE__ ) . 'partials/check-my-website-admin-header.php' );
                include( plugin_dir_path( __FILE__ ) . 'partials/check-my-website-admin-dashboard.php' );
		include( plugin_dir_path( __FILE__ ) . 'partials/check-my-website-admin-footer.php' );

        }

	/**
         * Display the Check my Website widget for the dashboard.
         *
         * @since    1.0.0
         */
        public function widget() {

                /**
                 * This function is provided for demonstration purposes only.
                 *
                 * An instance of this class should be passed to the run() function
                 * defined in Plugin_Name_Admin_Loader as all of the hooks are defined
                 * in that particular class.
                 *
                 * The Plugin_Name_Admin_Loader will then create the relationship
                 * between the defined hooks and the functions defined in this
                 * class.
                 */

		// Load default parameters.
                $options = get_option( 'check_my_website_settings' );
                $default_api_key = $options['key'];
                $default_style = $options['style'];
                $default_unit = $options['unit'];

                // Load api data.
                if ( isset( $default_api_key ) ) {
                        $api = new Check_my_Website_Api( $default_api_key );
                        $data = cmws_data( $api->get_api_data() );
                } else {
                        $data = NULL;
                }

                include( plugin_dir_path( __FILE__ ) . 'partials/check-my-website-admin-dashwidget.php' );

        }

}

?>
