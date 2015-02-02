<?php

/**
 * Provide an admin-facing view for the widget plugin (form).
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://checkmy.ws
 * @since      1.0.0
 *
 * @package    check-my-website
 * @subpackage check-my-website/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
</p>

<p>
	<label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text'); ?></label>
	<textarea class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>
</p>

<p>
	<label for="<?php echo $this->get_field_id('url'); ?>">Show URL</label>
	<input class="widefat" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" type="checkbox" value="1" <?php checked( '1', $url ); ?> />
</p>

<p>
	<label for="<?php echo $this->get_field_id('style'); ?>">Select widget style</label>
	<select class="widefat" id="<?php echo $this->get_field_id('style'); ?>" name="<?php echo $this->get_field_name('style'); ?>">
        <?php
                foreach ( $styles as $style_key => $style_value ) {
                	echo '<option value="' . $style_key . '"', $style == $style_key ? ' selected="selected" ' : '', '>', $style_value, '</option>';
                }
        ?>
        </select>
</p>

<p>
	<label for="<?php echo $this->get_field_id('unit'); ?>">Select time unit</label>
	<select class="widefat" id="<?php echo $this->get_field_id('unit'); ?>" name="<?php echo $this->get_field_name('unit'); ?>">
	<?php
		foreach ( $units as $unit_key => $unit_value ) {
			echo '<option value="' . $unit_key . '" id="' . $unit_key . '"', $unit == $unit_key ? ' selected="selected"' : '', '>', $unit_value, '</option>';
                }
        ?>
        </select>
</p>

<p>
	<label for="<?php echo $this->get_field_id('latest'); ?>">Show lastest response time</label>
	<input class="widefat" id="<?php echo $this->get_field_id('latest'); ?>" name="<?php echo $this->get_field_name('latest'); ?>" type="checkbox" value="1" <?php checked( '1', $latest ); ?> />
</p>

<p>
	<label for="<?php echo $this->get_field_id('availability'); ?>">Show availability (24h)</label>
	<input class="widefat" id="<?php echo $this->get_field_id('availability'); ?>" name="<?php echo $this->get_field_name('availability'); ?>" type="checkbox" value="1" <?php checked( '1', $availability ); ?> />
</p>

<p>
	<label for="<?php echo $this->get_field_id('average'); ?>">Show average time (24h)</label>
	<input class="widefat" id="<?php echo $this->get_field_id('average'); ?>" name="<?php echo $this->get_field_name('average'); ?>" type="checkbox" value="1" <?php checked( '1', $average ); ?> />
</p>

<p>
	<label for="<?php echo $this->get_field_id('poller'); ?>">Show states/pollers information</label>
	<input class="widefat" id="<?php echo $this->get_field_id('poller'); ?>" name="<?php echo $this->get_field_name('poller'); ?>" type="checkbox"  value="1" <?php checked( '1', $poller ); ?> />
</p>

<p>
	<label for="<?php echo $this->get_field_id('yslow'); ?>">Show performance (YSlow) information</label>
	<input class="widefat" id="<?php echo $this->get_field_id('yslow'); ?>" name="<?php echo $this->get_field_name('yslow'); ?>" type="checkbox" value="1" <?php checked( '1', $yslow ); ?> />
</p>

