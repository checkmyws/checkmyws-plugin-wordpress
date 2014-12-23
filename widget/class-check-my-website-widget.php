<?php

/**
 * The widget-facing functionality of the plugin.
 *
 * @link       http://checkmy.ws
 * @since      1.0.0
 *
 * @package    check-my-website
 * @subpackage check-my-website/widget
 */

/**
 * The widget-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
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
	 */
	public function widget( $args, $instance ) {

		$title = apply_filters('widget_title', $instance['title']);
                $text = $instance['text'];

		echo $before_widget;

		if ( $title ) {
                        echo $before_title.$title.$after_title;
                }

		if ( $text ) {
                        echo '<div class="'. $stylesheet . '">'.$text.'</div>';
                }

		echo $after_widget;

	}

	/**
         * Save the widget parameters on the admin side of the site.
         *
         * @since    1.0.0
         */
        public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
                $instance['title'] = strip_tags($new_instance['title']);
                $instance['text'] = strip_tags($new_instance['text']);

		return $instance;

	}

	/**
         * Display the widget on the admin side of the site.
         *
         * @since    1.0.0
         */
        public function form( $instance ) {

		//$defaults = array( 'title' => 'Check my Website', 'id' => $api->checkmyws_api_id(), 'url' => true );
                $instance = wp_parse_args( (array) $instance, $defaults );

		$title = esc_attr($instance['title']);
                $text = esc_attr($instance['text']);

		?>

                <p>
                        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title'); ?></label>
                        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
                </p>

                <p>
                        <label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text'); ?></label>
                        <textarea class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>
                </p>

		<?php

	}

	function enqueue_widgets() {

                register_widget('Check_my_Website_Widget');

        }


}
