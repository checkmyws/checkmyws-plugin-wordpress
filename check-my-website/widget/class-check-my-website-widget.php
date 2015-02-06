<?php
/**
 * The widget functionality of the plugin.
 *
 * Defines the plugin name, version, and hooks for 
 * enqueue, display and save the widget.
 *
 * @link       https://checkmy.ws
 * @since      1.0.0
 *
 * @package    check-my-website
 * @subpackage check-my-website/widget
 * @author     Check my Website by NOVATEEK <contact@checkmy.ws>
 */
class Check_my_Website_Widget extends WP_Widget {

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
	public function __construct( $plugin_name = 'check-my-website', $version = '1.0.0' ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		parent::__construct( $this->plugin_name, 'Check my Website', array( 'description' => 'Display the performance of your website to your public.' ) );

	}

	/**
	 * Display the widget on the public side of the site.
	 *
	 * @since    1.0.0
	 * @var      array    $args       The arguments of the widget.
         * @var      array    $instance    The saved values of the widget.
	 */
	public function widget( $args, $instance ) {

		// Extract widget arguments.
		extract( $args );

		// Load saved values (parameters).
		$title = apply_filters('widget_title', $instance['title']);
                $text = $instance['text'];
		$url = $instance['url'];
		$style = $instance['style'];
		$unit = $instance['unit'];
		$latest = $instance['latest'];
                $state = $instance['state'];
		$average = $instance['average'];
                $availability = $instance['availability'];
                $poller = $instance['poller'];
                $yslow = $instance['yslow'];

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

		// Display widget.
		echo $before_widget;
		echo '<div class="' . $style . '">';
		include( plugin_dir_path( __DIR__ ) . 'public/partials/check-my-website-public-widget.php' );
		echo '</div>';
		echo $after_widget;

	}

	/**
         * Save the widget parameters on the admin side of the site.
         *
         * @since    1.0.0
	 * @var      array    $new_instance       The new saved values of the widget.
         * @var      array    $old_instance    The old saved values of the widget.
         */
        public function update( $new_instance, $old_instance ) {

		// Define instance.
		$instance = $old_instance;

		// Update widget values.
                $instance['title'] = strip_tags($new_instance['title']);
                $instance['text'] = strip_tags($new_instance['text']);
		$instance['url'] = strip_tags($new_instance['url']);
		$instance['style'] = strip_tags($new_instance['style']);
		$instance['unit'] = strip_tags($new_instance['unit']);
		$instance['latest'] = strip_tags($new_instance['latest']);
		$instance['average'] = strip_tags($new_instance['average']);
                $instance['state'] = strip_tags($new_instance['state']);
                $instance['availability'] = strip_tags($new_instance['availability']);
                $instance['poller'] = strip_tags($new_instance['poller']);
                $instance['yslow'] = strip_tags($new_instance['yslow']);

		// Return saved values.
		return $instance;

	}

	/**
         * Display the widget on the admin side of the site.
         *
         * @since    1.0.0
	 * @var      array    $instance       The instance of the widget.
         */
        public function form( $instance ) {

		// Load default parameters.
                $options = get_option( 'cmws_settings' );

		// Define default values.
		$defaults = array( 'title' => 'Check my Website', 'text' => '', 'url' => true, 'style' => $options['default_style'], 'unit' => $options['default_unit'], 'latest' => false, 'average' => false, 'state' => false, 'availability' => false, 'poller' => false, 'yslow' => false );
                $instance = wp_parse_args( (array) $instance, $defaults );

		// Load saved values (parameters).
		$title = esc_attr($instance['title']);
                $text = esc_attr($instance['text']);
		$url = esc_attr($instance['url']);
		$style = esc_attr($instance['style']);
		$unit = esc_attr($instance['unit']);
		$latest = esc_attr($instance['latest']);
		$average = esc_attr($instance['average']);
                $state = esc_attr($instance['state']);
                $availability = esc_attr($instance['availability']);
                $poller = esc_attr($instance['poller']);
                $yslow = esc_attr($instance['yslow']);

		// Define some values association.
		$styles = array( 'check-my-website-classic' => 'Classic', 'check-my-website-light' => 'Light', 'check-my-website-dark' => 'Dark' );
		$units = array( 'ms' => 'Millisecond', 's' => 'Second' );

		// Display widget form.
		include( plugin_dir_path( __DIR__ ) . 'admin/partials/check-my-website-admin-widget.php' );

	}

	/**
         * Register the widget for the site.
         *
         * @since    1.0.0
         */
	function enqueue_widgets() {

                register_widget('Check_my_Website_Widget');

        }

}
?>
