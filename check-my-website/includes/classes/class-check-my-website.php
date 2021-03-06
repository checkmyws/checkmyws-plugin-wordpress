<?php

/**
 * The core plugin class.
 *
 * This is used to define internationalization, dashboard-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @link       https://checkmy.ws
 * @since      1.0.0
 *
 * @package    check-my-website
 * @subpackage check-my-website/includes/classes
 * @author     Check my Website by NOVATEEK <contact@checkmy.ws>
 */
class Check_my_Website {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Check_my_Website_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the Dashboard and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'check-my-website';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_widget_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Check_my_Website_Loader. Orchestrates the hooks of the plugin.
	 * - Check_my_Website_i18n. Defines internationalization functionality.
	 * - Check my Wevsite Functions. Defines plugin functions.
	 * - Check_my_Website_Api. Defines Check my Website api functionality.
	 * - Check_my_Website_Admin. Defines all hooks for the dashboard.
	 * - Check_my_Website_Public. Defines all hooks for the public side of the site.
	 * - Check_my_Website_Widget. Defines all hooks for the widget.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/class-check-my-website-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/class-check-my-website-i18n.php';

		/**
                 * The class responsible for defining helpful tools and functions
                 * of the plugin.
                 */
                require_once plugin_dir_path( dirname( __FILE__ ) ) . 'functions/check-my-website-functions.php';

		/**
                 * The class responsible for defining all actions that occur with the api.
                 */
                require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/class-check-my-website-api.php';

		/**
		 * The class responsible for defining all actions that occur in the Dashboard.
		 */
		require_once plugin_dir_path( dirname( __DIR__ ) ) . 'admin/class-check-my-website-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __DIR__ ) ) . 'public/class-check-my-website-public.php';

		/**
                 * The class responsible for defining all actions that occur in the widget
                 * side of the site.
                 */
                require_once plugin_dir_path( dirname( __DIR__ ) ) . 'widget/class-check-my-website-widget.php';
		
		$this->loader = new Check_my_Website_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Check_my_Website_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Check_my_Website_i18n();
		$plugin_i18n->set_domain( $this->get_plugin_name() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the dashboard functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Check_my_Website_Admin( $this->get_plugin_name(), $this->get_version() );

		// Load the stylesheet on the admin-side.
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'enqueue_settings' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'enqueue_pages' );
	
		// Load plugin settings.	
		$options = get_option( 'cmws_settings' );

		// Define widget according to plugin settings.
		if ( $options['dashboard_widget'] == 1 ) { 
			$this->loader->add_action( 'wp_dashboard_setup', $plugin_admin, 'enqueue_widgets' );
		};

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Check_my_Website_Public( $this->get_plugin_name(), $this->get_version() );

		// Load plugin settings.
                $options = get_option( 'cmws_settings' );

		// Load the stylesheet on the public-side.
                if ( ( $options['shortcode'] == 1 ) || ( $options['widget'] == 1 ) ) :
			$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		endif;

		//$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
         * Register all of the hooks related to the widget functionality
         * of the plugin.
         *
         * @since    1.0.0
         * @access   private
         */
        private function define_widget_hooks() {

                $plugin_widget = new Check_my_Website_Widget( $this->get_plugin_name(), $this->get_version() );

		$options = get_option( 'cmws_settings' );

                if ( $options['widget'] == 1 ) {
	                $this->loader->add_action( 'widgets_init', $plugin_widget, 'enqueue_widgets' );
		};

        }

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Check_my_Website_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}

?>
