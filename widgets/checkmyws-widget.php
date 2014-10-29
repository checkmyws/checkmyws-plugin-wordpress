<?php

// Load prerequisites classes
require_once( dirname(__DIR__) . '/classes/checkmyws-api.php');
require_once( dirname(__DIR__) . '/classes/checkmyws-metrics.php');

// Check my Website widget
class checkmyws_widget extends WP_Widget {

	// Init widget
	function __construct() {

		// Declare widget
        	parent::__construct('checkmyws', 'Check my Website', array('description' => 'Display monitoring data of your website.'));

	}

	// Display widget on the frontend
	function widget($args, $instance) {

		// Extract widget args
		extract($args);

		// Load Check my Website API and metrics classes
		$api = new checkmyws_api;
		$metric = new checkmyws_metrics;

		// Get URL ID to connect API
		$id = $api->checkmyws_api_id();

		// Get status and metrics data arrays from API
		$status = $api->checkmyws_api_status($id);
		$metrics = $api->checkmyws_api_metrics($id);

		// Get widget parameters
		$title = apply_filters('widget_title', $instance['title']);
		$text = $instance['text'];
		$id = $instance['id'];
		$url = $instance['url'];
		$measurement = $instance['measurement'];
		$style = $instance['style'];
		$date = $instance['date'];
		$check = $instance['check'];
		$state = $instance['state'];
		$change = $instance['change'];
		$duration = $instance['duration'];
		$availability = $instance['availability'];
		$location = $instance['location'];
		$yslow = $instance['yslow'];
		$cmw = $instance['cmw'];

		// Start widget displaying
    		echo $before_widget;

		// Display widget title if title is entered
		if ( $title ) {
			echo $before_title.$title.$after_title;
		}

		// Display text if text is entered
		if ( $text ) {
			echo '<div class="'. $stylesheet . '">'.$text.'</div>';
		}

		// Display id if id is entered
		//if( $id ) {
                //        echo '<div class="widget-text">' . $id . '</div>';
                //}

		// Display url if url is checked
		if ( $url == true ) {
			echo '<br/><div class="' . $stylesheet . '">';
			echo '<h3>URL checked</h3>';
			echo $status['url'];
			echo '</div>';
		}

		// Apply style selected
                if ( $style == 'classic' ) {
                        $stylesheet = 'checkmyws-widget-classic';
                } else if ( $style == 'checkmyws' ) {
                        $stylesheet = 'checkmyws-widget-full';
                }

		// Apply measurement unit selected
                if ( $measurement == 'millisecond' ) {
                        // Set 'ms' unit
                        $unit = 'ms';
                } else if ( $measurement == 'second' ) {
                        // Set 's' unit
                        $unit = 's';
                }

		// Display date if date is checked
		if ( $date == true ) {
			$lastcheck = new DateTime();
			$lastcheck->setTimestamp( $status['metas']['lastcheck'] );
			echo '<br/><div class="' . $stylesheet . '">';
			echo '<h3>Last check time</h3>';
			echo $lastcheck->format( 'H:i:s' );
			echo '</div>';
		}

		// Display availability on 24h if availability is checked
		if ( $availability == true ) {
			echo '<br/><div class="' . $stylesheet . '">';
			echo '<h3>Availability (24h)</h3>';
			echo '100 %';
			echo '</div>';
		}

		// Display last time response (average) if check is checked
		if ( $check == true ) {
			$avg = array_sum( $status['lastvalues']['httptime'] ) / count( $status['lastvalues']['httptime'] );
			//$avg = round( $avg );
			echo '<br/><div class="' . $stylesheet . '">';
			echo '<h3>Last time response</h3>';
			echo $metric->checkmyws_metrics_conversion( round( $avg ), $unit ) . ' ' . $unit;
			echo '</div>';
		}

		// Display check location(s) if location is checked
		if ( $location == true ) {
			echo '<br/>';
			echo '<div class="' . $stylesheet . '">';
			echo '<h3>States</h3>';
			echo '<ul>';
			foreach( $status['lastvalues']['httptime'] as $key => $value ) {
  				echo '<li>' . $key . ': ' . $metric->checkmyws_metrics_conversion( $value, $unit ) . ' ' . $unit . '</li>';
			}
			echo '</ul>';
			echo '</div>';
		}

		// Display YSlow data if yslow is checked
		if ( $yslow == true ) {
			echo '<br/>';
			echo '<div class="' . $stylesheet . '">';
			echo '<h3>YSlow</h3>';
			echo 'Page Load Time: ' . $metric->checkmyws_metrics_conversion( $status['metas']['yslow_page_load_time'], $unit ) . ' ' . $unit . '<br/>';
			echo 'Score: ' . $status['metas']['yslow_score'] . ' %';
			echo '</div>';
		}

		// Display Check my Website link if cmw is checked
                if ( $cmw == true ) {
			echo '<br/>';
                        echo '<div class="' . $stylesheet . '">';
                        echo '<a href="https://checkmy.ws" style="font-size:0.7em;float:right;" target="_blank"><em>Powered by Check my Website.</em></a>';
			echo '</div>';
                }

		// Stop widget displaying
         	echo $after_widget;

	}

	// Save widget entered values on the widget admin panel
	function update($new_instance, $old_instance) {

		// Link widget paramaters to save
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['text'] = strip_tags($new_instance['text']);
		$instance['id'] = strip_tags($new_instance['id']);
		$instance['url'] = strip_tags($new_instance['url']);
		$instance['measurement'] = strip_tags($new_instance['measurement']);
		$instance['style'] = strip_tags($new_instance['style']);
		$instance['date'] = strip_tags($new_instance['date']);
		$instance['check'] = strip_tags($new_instance['check']);
		$instance['state'] = strip_tags($new_instance['state']);
		$instance['change'] = strip_tags($new_instance['change']);
		$instance['duration'] = strip_tags($new_instance['duration']);
                $instance['availability'] = strip_tags($new_instance['availability']);
		$instance['location'] = strip_tags($new_instance['location']);
		$instance['yslow'] = strip_tags($new_instance['yslow']);
		$instance['cmw'] = strip_tags($new_instance['cmw']);

		// Send the new widget parameters
    		return $instance;

	}

	// Display widget form on the widget admin panel
	function form($instance) {

		// Load Check my Website API class
		$api = new checkmyws_api;
		//$status = $api->checkmyws_api_status();

		// Declare widget parameters
		$title = esc_attr($instance['title']);
		$text = esc_attr($instance['text']);
		$measurement = esc_attr($instance['measurement']);
		$style = esc_attr($instance['style']);
		$id = $api->checkmyws_api_id();
		$url = esc_attr($instance['url']);
		$date = esc_attr($instance['date']);
		$check = esc_attr($instance['check']);
		$state = esc_attr($instance['state']);
		$change = esc_attr($instance['change']);
		$duration = esc_attr($instance['duration']);
                $availability = esc_attr($instance['availability']);
		$location = esc_attr($instance['location']);
		$yslow = esc_attr($instance['yslow']);
		$cmw = esc_attr($instance['cmw']);

		// Start widget form displaying
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
                        <label for="<?php echo $this->get_field_id('id'); ?>">URL ID</label>
                        <input class="widefat" id="<?php echo $this->get_field_id('id'); ?>" name="<?php echo $this->get_field_name('id'); ?>" type="text" value="<?php echo $id; ?>" disabled />
                </p>

		<p>
			<label for="<?php echo $this->get_field_id('url'); ?>">Display URL</label>
			<input class="widefat" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" type="checkbox" value="1" <?php checked( '1', $url ); ?> />
		</p>

		<p>
                        <label for="<?php echo $this->get_field_id('style'); ?>">Style</label>
                        <select class="widefat" id="<?php echo $this->get_field_id('style'); ?>" name="<?php echo $this->get_field_name('style'); ?>">
                                <?php
                                $styles = array( 'classic', 'checkmyws' );
                                foreach ( $styles as $stylesheet ) {
                                        echo '<option value="' . $stylesheet . '"', $style == $stylesheet ? ' selected="selected" ' : '', '>', $stylesheet, '</option>';
                                }
                                ?>
                        </select>
                </p>

		 <p>
                        <label for="<?php echo $this->get_field_id('measurement'); ?>">Measurement unit</label>
                        <select class="widefat" id="<?php echo $this->get_field_id('measurement'); ?>" name="<?php echo $this->get_field_name('measurement'); ?>">
                                <?php
                                $options = array( 'millisecond', 'second' );
                                foreach ( $options as $option ) {
                                        echo '<option value="' . $option . '" id="' . $option . '"', $measurement == $option ? ' selected="selected"' : '', '>', $option, '</option>';
                                }
                                ?>
                        </select>
                </p>

		<p>
			<label for="<?php echo $this->get_field_id('date'); ?>">Display check date</label>
			<input class="widefat" id="<?php echo $this->get_field_id('date'); ?>" name="<?php echo $this->get_field_name('date'); ?>" type="checkbox" value="1" <?php checked( '1', $date ); ?> />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('check'); ?>">Display last response time</label>
			<input class="widefat" id="<?php echo $this->get_field_id('check'); ?>" name="<?php echo $this->get_field_name('check'); ?>" type="checkbox" value="1" <?php checked( '1', $check ); ?> />
		</p>

		<p>
                        <label for="<?php echo $this->get_field_id('availability'); ?>">Display availability (24h)</label>
                        <input class="widefat" id="<?php echo $this->get_field_id('availability'); ?>" name="<?php echo $this->get_field_name('availability'); ?>" type="checkbox" value="1" <?php checked( '1', $availability ); ?> />
                </p>

		<p>
			<label for="<?php echo $this->get_field_id('location'); ?>">Display check location(s) information</label>
			<input class="widefat" id="<?php echo $this->get_field_id('location'); ?>" name="<?php echo $this->get_field_name('location'); ?>" type="checkbox"  value="1" <?php checked( '1', $location ); ?> />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('yslow'); ?>">Display YSlow information</label>
			<input class="widefat" id="<?php echo $this->get_field_id('yslow'); ?>" name="<?php echo $this->get_field_name('yslow'); ?>" type="checkbox" value="1" <?php checked( '1', $yslow ); ?> />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('cmw'); ?>">Display Check My Website link</label>
			<input class="widefat" id="<?php echo $this->get_field_id('cmw'); ?>" name="<?php echo $this->get_field_name('cmw'); ?>" type="checkbox" value="1" <?php checked( '1', $cmw ); ?> />
		</p>

    		<?php
		// Stop widget form displaying

	}

}

?>
