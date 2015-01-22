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

<div class="cmws-table">
	<div class="cmws-row">
		<div class="cmws-column cmws-column-6">
			<div class="cmws-cell">
                		<div class="cmws-panel cmws-panel-default cmws-color">
                        		<div class="cmws-panel-heading cmws-color-alt"><span class="dashicons dashicons-chart-bar"></span> <?php _e( 'Response time', 'check-my-website' ); ?></div>
                                	<div class="cmws-panel-body">
						<div id="cmws-chart-httptime" style="width:100%;height:300px;">
							<span><?php _e( 'No metrics', 'check-my-website' ); ?></span>
						</div>
        	              	        </div>
				</div>
			</div>
		</div>
		<div class="cmws-column cmws-column-6">
        	        <div class="cmws-cell">
                	        <div class="cmws-panel cmws-panel-default cmws-color">
                        	        <div class="cmws-panel-heading cmws-color-alt"><span class="dashicons dashicons-chart-bar"></span> <?php _e( 'Availability', 'check-my-website' ); ?></div>
                                	<div class="cmws-panel-body">
						<div id="cmws-chart-state" style="width:100%;height:300px;">
							<span><?php _e( 'No metrics', 'check-my-website' ); ?></span>
						</div>
                        	  	</div>
                    	    	</div>
              		</div>
        	</div>
	</div>
</div>

<br style="clear:both" />

<!-- Metrics ends -->
