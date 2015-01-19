<?php

/**
 * Provide the dashboard metrics view for the plugin.
 *
 * This file is used to markup the admin aspects of the plugin.
 *
 * @link       https://checkmy.ws
 * @since      1.0.0
 *
 * @package    check-my-website
 * @subpackage check-my-website/admin/partials
 */
?>

<!-- Metrics starts -->

<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery.ajax({
        	type: "GET",
        	dataType: "json",
        	url: "/wp-content/plugins/check-my-website/includes/api/check-my-website-metrics.php"
	})
	.done(function(data) {
        	console.log("Data:", data['day']['series']['checks.624e853d-90f3-4bf9-8417-c78157ed38e4.httptime']['data'][0])
        	jQuery.plot("#placeholder", data['day']['series']['checks.624e853d-90f3-4bf9-8417-c78157ed38e4.httptime']['data'][0]);
	})
});
</script>

<div class="cmws-table">
	<div class="cmws-row">
		<div class="cmws-column cmws-column-6">
			<div class="cmws-cell">
                		<div class="cmws-panel cmws-panel-default cmws-color">
                        		<div class="cmws-panel-heading cmws-color-alt">Response time</div>
                                	<div class="cmws-panel-body" onload="alert('Bonjour !');" onunload="alert('Au revoir !');">
						<div id="placeholder" style="height:300px;"></div>
        	              	        </div>
				</div>
			</div>
		</div>
		<div class="cmws-column cmws-column-6">
        	        <div class="cmws-cell">
                	        <div class="cmws-panel cmws-panel-default cmws-color">
                        	        <div class="cmws-panel-heading cmws-color-alt">Availability</div>
                                	<div class="cmws-panel-body">
                                        	<span>No metrics</span>
                        	  	</div>
                    	    	</div>
              		</div>
        	</div>
		<div class="cmws-column cmws-column-6">
                	<div class="cmws-cell">
                        	<div class="cmws-panel cmws-panel-default cmws-color">
                                	<div class="cmws-panel-heading cmws-color-alt">Page load time</div>
                               		<div class="cmws-panel-body">
                                        	<span>No metrics</span>
                                	</div>
                      		</div>
                	</div>
        	</div>
	</div>
</div>

<br style="clear:both" />

<!-- Metrics ends -->
