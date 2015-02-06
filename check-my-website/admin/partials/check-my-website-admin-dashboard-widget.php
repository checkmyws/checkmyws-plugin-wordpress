<?php

/**
 * Provide a dashboard widget view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://checkmy.ws
 * @since      1.0.0
 *
 * @package    check-my-website
 * @subpackage check-my-website/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="header">

<p style="float: right;margin: 0 12px 0 0;">
<span class="dashicons dashicons-chart-area" style="font-size: 18px;"></span> <a href="index.php?page=check-my-website" style="vertical-align: top;"><?php _e( 'Dashboard', 'check-my-website' ); ?></a>
<span class="dashicons dashicons-forms" style="font-size: 18px;"></span> <a href="options-general.php?page=check-my-website-settings" style="vertical-align: top;"><?php _e( 'Settings', 'check-my-website' ); ?></a>
</p>

<?php

if ( $data['global'] ) {
	echo '<p><span class="cmws-label cmws-label-' . $data['global']['label'] . '">' . $data['global']['state'] . '</span> <a class="cmws-link" target="_blank" href="' . $data['global']['url'] . '">' . $data['global']['url'] . '</a></p>';
} else {
	echo '<p><span class="cmws-danger">' . __( 'No url', 'check-my-website' ) . '</span></p>';
}

?>

</div>

<?php

if ( $data['global'] ) {
	echo '<div class="cmws-column cmws-column-6"><strong>' . __( 'State duration:', 'check-my-website' ) . '</strong> <span class="cmws-font cmws-' . $data['global']['label'] . '">' . $data['global']['state_duration'] . ' day</span></div>';
	echo '<div class="cmws-column cmws-column-6"><strong>' . __( 'Availability (24h):', 'check-my-website' ) . '</strong> <span>' . $data['global']['availability'] . '<span> %</span></span></div>';
	echo '<div class="cmws-column cmws-column-6"><strong>' . __( 'Last time response:', 'check-my-website' ) . '</strong> ' . cmws_convert( $data['global']['latest_response_time'], $default_unit ) . '<span class="cmws-widget-font"> ' . $default_unit . '</span></div>';
	echo '<div class="cmws-column cmws-column-6"><strong>' . __( 'Average time (24h):', 'check-my-website' ) . '</strong> ' . cmws_convert( $data['global']['average_time'], $default_unit ) . '<span class="cmws-widget-font"> ' . $default_unit . '<span></div>';
} else {
	echo '<p><span class="cmws-danger">' . __( 'No data', 'check-my-website' ) . '</span></p>';
}

echo '<div class="clear"></div>';

if ( $data['yslow'] ) {
	echo '<p>';
	echo '<div class="cmws-column cmws-column-6"><strong>' . __( 'Performance (YSlow):', 'check-my-website' ) . '</strong> <span class="cmws-text-center cmws-font cmws-label cmws-label-' . $data['yslow']['label'] . '">' . $data['yslow']['grade'] . '</span></div>';
	echo '<div class="cmws-column cmws-column-6"><strong>' . __( 'Score:', 'check-my-website' ) . '</strong> <span class="cmws-font">' . $data['yslow']['score'] . '</span></div><div class="cmws-column cmws-column-6"><strong>' . __( 'Page load time:', 'check-my-website' ) . '</strong> <span class="cmws-font">' . cmws_convert( $data['yslow']['page_load_time'], 's' ) . 's' . '</span></div>';
	echo '</p>';
} else {
	echo '<p><span class="cmws-danger">' . __( 'No data', 'check-my-website' ) . '</span></p>';
}

?>

<div class="clear"></div>

