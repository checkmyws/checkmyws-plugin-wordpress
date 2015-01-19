<?php

/**
 * Provide a dashboard view for the plugin
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
<span class="dashicons dashicons-chart-area" style="font-size: 18px;"></span> <a href="index.php?page=check-my-website" style="vertical-align: top;">Dashboard</a>
<span class="dashicons dashicons-forms" style="font-size: 18px;"></span> <a href="options-general.php?page=check-my-website-setting" style="vertical-align: top;">Settings</a>
</p>

<?php

if ( $data['global'] ) {
	echo '<p><span class="cmws-label cmws-label-' . $data['global']['label'] . '">' . $data['global']['state'] . '</span> <a class="cmws-link" target="_blank" href="' . $data['global']['url'] . '">' . $data['global']['url'] . '</a></p>';
} else {
	echo '<p><span class="cmws-danger">No url</span></p>';
}

?>

</div>

<?php

if ( $data['global'] ) {
	echo '<div class="cmws-column cmws-column-6"><strong>State duration:</strong> <span class="cmws-font cmws-' . $data['global']['label'] . '">' . $data['global']['state_duration'] . ' day</span></div>';
	echo '<div class="cmws-column cmws-column-6"><strong>Availability (24h):</strong> <span>' . $data['global']['availability'] . '<span> %</span></span></div>';
	echo '<div class="cmws-column cmws-column-6"><strong>Last time response:</strong> ' . convert( $data['global']['last_time_response'], $default_unit ) . '<span class="cmws-widget-font"> ' . $default_unit . '</span></div>';
	echo '<div class="cmws-column cmws-column-6"><strong>Average time (24h):</strong> ' . convert( $data['global']['average_time'], $default_unit ) . '<span class="cmws-widget-font"> ' . $default_unit . '<span></div>';
} else {
	echo '<p><span class="cmws-danger">No data</span></p>';
}

echo '<div class="clear"></div>';

if ( $data['yslow'] ) {
	echo '<p>';
	echo '<div class="cmws-column cmws-column-6"><strong>Yslow:</strong> <span class="cmws-text-center cmws-font cmws-label cmws-label-' . $data['yslow']['label'] . '">' . $data['yslow']['grade'] . '</span></div>';
	echo '<div class="cmws-column cmws-column-6"><strong>Score:</strong> <span class="cmws-font">' . $data['yslow']['score'] . '</span></div><div class="cmws-column cmws-column-6"><strong>Page load time:</strong> <span class="cmws-font">' . convert( $data['yslow']['page_load_time'], 's' ) . 's' . '</span></div>';
	echo '</p>';
} else {
	echo '<p><span class="cmws-danger">No data</span></p>';
}

?>

<div class="clear"></div>

