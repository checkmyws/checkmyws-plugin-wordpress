<?php

/**
 * The widget functionality of the plugin.
 *
 * @link       http://checkmy.ws
 * @since      1.0.0
 *
 * @package    check-my-website
 * @subpackage check-my-website/widget
 */

/**
 * The widget functionality of the plugin.
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

		extract( $args );

		$title = apply_filters('widget_title', $instance['title']);
                $text = $instance['text'];
		$url = $instance['url'];
		$style = $instance['style'];
		$unit = $instance['unit'];
		$check = $instance['check'];
                $state = $instance['state'];
		$average = $instance['average'];
                $availability = $instance['availability'];
                $location = $instance['location'];
                $yslow = $instance['yslow'];
                $cmw = $instance['cmw'];

		$options = get_option( 'check_my_website_settings' );
                $api_key = $options['key'];

		// Load api data.
                $api = new Check_my_Website_Api( $api_key );
		$data = $api->get_api_data();

		// Get yslow information.
                $yslow_data = yslow( $data );

		// Get average time on 24h.
                $last_key = key( array_slice( $data['week']['series']['checks.' . $api->get_api_key() . '.httptime']['data'], -1, 1, TRUE ) );
                $sum = 0;
                $count= 0;
                foreach ( $data['day']['series']['checks.' . $api->get_api_key() . '.httptime']['data'] as $key => $value ) {
                	$sum = $sum + $data['day']['series']['checks.' . $api->get_api_key() . '.httptime']['data'][$key][1];
                        $count = $count +1;
                }
                $average_time = $sum / $count;

		echo $before_widget;

		include( plugin_dir_path( __DIR__ ) . 'public/partials/check-my-website-public-widget.php' );

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
		$instance['url'] = strip_tags($new_instance['url']);
		$instance['style'] = strip_tags($new_instance['style']);
		$instance['unit'] = strip_tags($new_instance['unit']);
		$instance['check'] = strip_tags($new_instance['check']);
		$instance['average'] = strip_tags($new_instance['average']);
                $instance['state'] = strip_tags($new_instance['state']);
                $instance['availability'] = strip_tags($new_instance['availability']);
                $instance['location'] = strip_tags($new_instance['location']);
                $instance['yslow'] = strip_tags($new_instance['yslow']);
                $instance['cmw'] = strip_tags($new_instance['cmw']);

		return $instance;

	}

	/**
         * Display the widget on the admin side of the site.
         *
         * @since    1.0.0
         */
        public function form( $instance ) {

		//$defaults = array( 'title' => 'Check my Website', 'id' => $api->checkmyws_api_id(), 'url' => true );
                //$instance = wp_parse_args( (array) $instance, $defaults );

		$title = esc_attr($instance['title']);
                $text = esc_attr($instance['text']);
		$url = esc_attr($instance['url']);
		$style = esc_attr($instance['style']);
		$unit = esc_attr($instance['unit']);
		$check = esc_attr($instance['check']);
		$average = esc_attr($instance['average']);
                $state = esc_attr($instance['state']);
                $availability = esc_attr($instance['availability']);
                $location = esc_attr($instance['location']);
                $yslow = esc_attr($instance['yslow']);
                $cmw = esc_attr($instance['cmw']);

		?>

                <p>
                        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title'); ?></label>
                        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
                </p>

                <p>
                        <label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text'); ?></label>
                        <textarea class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>
                </p>

		 <p>
                        <label for="<?php echo $this->get_field_id('url'); ?>">Display URL</label>
                        <input class="widefat" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" type="checkbox" value="1" <?php checked( '1', $url ); ?> />
                </p>

		<p>
                        <label for="<?php echo $this->get_field_id('style'); ?>">Style</label>
                        <select class="widefat" id="<?php echo $this->get_field_id('style'); ?>" name="<?php echo $this->get_field_name('style'); ?>">
                                <?php
                                $styles = array( 'check-my-website-classic' => 'Classic', 'check-my-website-light' => 'Light', 'check-my-website-dark' => 'Dark' );
                                foreach ( $styles as $stylesheet => $styletitle ) {
                                        echo '<option value="' . $stylesheet . '"', $style == $stylesheet ? ' selected="selected" ' : '', '>', $styletitle, '</option>';
                                }
                                ?>
                        </select>
                </p>

		 <p>
                        <label for="<?php echo $this->get_field_id('unit'); ?>">Time unit</label>
                        <select class="widefat" id="<?php echo $this->get_field_id('unit'); ?>" name="<?php echo $this->get_field_name('unit'); ?>">
                                <?php
                                $units = array( 'ms' => 'Millisecond', 's' => 'Second' );
                                foreach ( $units as $key => $value ) {
                                        echo '<option value="' . $key . '" id="' . $key . '"', $unit == $key ? ' selected="selected"' : '', '>', $value, '</option>';
                                }
                                ?>
                        </select>
                </p>

		<p>
                        <label for="<?php echo $this->get_field_id('check'); ?>">Last response time</label>
                        <input class="widefat" id="<?php echo $this->get_field_id('check'); ?>" name="<?php echo $this->get_field_name('check'); ?>" type="checkbox" value="1" <?php checked( '1', $check ); ?> />
                </p>

                <p>
                        <label for="<?php echo $this->get_field_id('availability'); ?>">Availability (24h)</label>
                        <input class="widefat" id="<?php echo $this->get_field_id('availability'); ?>" name="<?php echo $this->get_field_name('availability'); ?>" type="checkbox" value="1" <?php checked( '1', $availability ); ?> />
                </p>
	
		<p>
                        <label for="<?php echo $this->get_field_id('average'); ?>">Show average time (24h)</label>
                        <input class="widefat" id="<?php echo $this->get_field_id('average'); ?>" name="<?php echo $this->get_field_name('average'); ?>" type="checkbox" value="1" <?php checked( '1', $average ); ?> />
                </p>

                <p>
                        <label for="<?php echo $this->get_field_id('location'); ?>">State(s) information</label>
                        <input class="widefat" id="<?php echo $this->get_field_id('location'); ?>" name="<?php echo $this->get_field_name('location'); ?>" type="checkbox"  value="1" <?php checked( '1', $location ); ?> />
                </p>

                <p>
                        <label for="<?php echo $this->get_field_id('yslow'); ?>">YSlow information</label>
                        <input class="widefat" id="<?php echo $this->get_field_id('yslow'); ?>" name="<?php echo $this->get_field_name('yslow'); ?>" type="checkbox" value="1" <?php checked( '1', $yslow ); ?> />
                </p>

                <p>
                        <label for="<?php echo $this->get_field_id('cmw'); ?>">Promote Check My Website</label>
                        <input class="widefat" id="<?php echo $this->get_field_id('cmw'); ?>" name="<?php echo $this->get_field_name('cmw'); ?>" type="checkbox" value="1" <?php checked( '1', $cmw ); ?> />
                </p>

		<?php

	}

	function enqueue_widgets() {

                register_widget('Check_my_Website_Widget');

        }


}

?>
