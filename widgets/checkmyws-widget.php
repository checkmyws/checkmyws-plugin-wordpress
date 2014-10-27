<?php

include_once( dirname(__DIR__) . '/classes/checkmyws-api.php');

class checkmyws_widget extends WP_Widget {

	function __construct() {
        	parent::__construct('checkmyws', 'Check my Website', array('description' => 'Display monitoring data of your website.'));
	}

	function widget($args, $instance) {
		extract( $args );

		$api = new checkmyws_api;
		$id = $api->checkmyws_api_id();
		$status = $api->checkmyws_api_status($id);

		$title = apply_filters('widget_title', $instance['title']);
		$textarea = $instance['textarea'];
		$select = $instance['select'];

		$websiteid = $instance['websiteid'];
		$location = $instance['location'];
		$yslow = $instance['yslow'];

    		echo $before_widget;

		if ( $title ) {
			echo $before_title . $title . $after_title;
		}

		// if text is entered in the textarea
		if ( $textarea ) {
			echo '<div class="widget-textarea">' . $textarea . '</div>';
		}

		// output text depended on which option is picked
		if ( $select == 'one' ) {
			echo 'Option One is Selected';
		} else if ( $select == 'two' ) {
			echo 'Option Two is Selected';
		} else {
			echo 'Option Three is Selected';
		}

		if ( $websiteid ) {
			echo '<div class="widget-text">' . $websiteid . '</div>';
		}

		if ( $location == true ) {
			echo '<div class="widget-text">';
			echo '<h3>Location(s)</h3>';
			echo '<ul>';
			foreach($status['lastvalues']['httptime'] as $key => $value) {
  				echo '<li>' . $key . ': ' . $value . ' ms</li>';
			}
			echo '</ul>';
			echo '</div>';
		}

		if ( $yslow == true ) {
			echo '<div class="widget-text">';
			echo '<h3>YSlow</h3>';
			echo 'Page Load Time: ' . $status['metas']['yslow_page_load_time'] . ' ms<br/>';
			echo 'Score: ' . $status['metas']['yslow_score'] . ' %';
			//echo '<pre>';
			//print_r($status);
			//echo '</pre>';
			echo '</div>';
		}

                if ( $yslow == true ) {
			echo '<br/>';
                        echo '<div class="widget-text">';
                        echo '<a href="https://checkmy.ws" style="font-size:0.7em;float:right;" target="_blank"><em>Monitored by Check my Website.</em></a>';
		echo '</div>';
                }

         	echo $after_widget;

	}


	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['textarea'] = strip_tags($new_instance['textarea']);
		$instance['select'] = strip_tags($new_instance['select']);
		$instance['websiteid'] =  strip_tags($new_instance['websiteid']);
		$instance['location'] = strip_tags($new_instance['location']);
		$instance['yslow'] = strip_tags($new_instance['yslow']);

    		return $instance;
	}

	function form($instance) {
		$api = new checkmyws_api;
		$status = $api->checkmyws_api_status();
		$title = esc_attr($instance['title']);
		$textarea = esc_attr($instance['textarea']);
		$select = esc_attr($instance['select']);
		//$websiteid = esc_attr($instance['websiteid']);
		$websiteid = $api->checkmyws_api_id();
		$location = esc_attr($instance['location']);
		$yslow = esc_attr($instance['yslow']);

		?>

		<p>
      			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title'); ?></label>
      			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
    		</p>

		<p>
    			<label for="<?php echo $this->get_field_id('textarea'); ?>"><?php _e('Textarea:'); ?></label>
    			<textarea class="widefat" id="<?php echo $this->get_field_id('textarea'); ?>" name="<?php echo $this->get_field_name('textarea'); ?>"><?php echo $textarea; ?></textarea>
    		</p>

		<p>
			<label for="<?php echo $this->get_field_id('select'); ?>"><?php _e('This is a select menu'); ?></label>
			<select name="<?php echo $this->get_field_name('select'); ?>" id="<?php echo $this->get_field_id('select'); ?>" class="widefat">
				<?php
				$options = array('one', 'two', 'three');
				foreach ($options as $option) {
					echo '<option value="' . $option . '" id="' . $option . '"', $select == $option ? ' selected="selected"' : '', '>', $option, '</option>';
				}
				?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('websiteid'); ?>">Website ID</label>
			<input class="widefat" id="<?php echo $this->get_field_id('websiteid'); ?>" name="<?php echo $this->get_field_name('websiteid'); ?>" type="text" value="<?php echo $websiteid; ?>" disabled />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('location'); ?>">Display location(s) information</label>
			<input class="widefat" id="<?php echo $this->get_field_id('location'); ?>" name="<?php echo $this->get_field_name('location'); ?>" type="checkbox"  value="1" <?php checked( '1', $location ); ?> />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('yslow'); ?>">Display YSlow information</label>
			<input class="widefat" id="<?php echo $this->get_field_id('yslow'); ?>" name="<?php echo $this->get_field_name('yslow'); ?>" type="checkbox" value="1" <?php checked( '1', $yslow ); ?> />
		</p>

    		<?php
	}

}

?>
