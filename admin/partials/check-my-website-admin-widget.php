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

<pre>
<?php
print_r( $api->get_api_data() );
?>
</pre>
