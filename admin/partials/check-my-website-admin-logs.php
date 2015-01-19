<?php

/**
 * Provide the dashboard logs view for the plugin.
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

<!-- Logs starts -->

<div class="cmws-table">
	<div class="cmws-row">
		<div class="cmws-cell">
               		<div class="cmws-panel cmws-panel-default cmws-color">
                       		<div class="cmws-panel-heading cmws-color-alt">Messages</div>
                        	<div class="cmws-panel-body">
					<table class="cmws-table cmws-table-striped" cmws-font>
                                        	<tbody>

						<?php
							if ( $data['logs'] ) {
								foreach ( $data['logs'] as $log => $log_values ) {
                                                        		echo '<tr>';
                                                        			echo '<td><span class="cmws-label cmws-label-' . $log_values['label'] . '">' . $log_values['state'] . '</span></td>';
                                                                		echo '<td>' . $log_values['date'] . '</span></td>';
                                                                		echo '<td>' . $log_values['source'] . '</span></td>';
                                                                		echo '<td>' . $log_values['message'] . '</span></td>';
                                                        		echo '</tr>';
                                                		}
							} else {
                                        			echo '<span>No messages</span>';
                                        		}
						?>

						</tbody>
					</table>
                        	</div>
			</div>
		</div>
	</div>
</div>

<br style="clear:both" />

<!-- Logs ends -->
