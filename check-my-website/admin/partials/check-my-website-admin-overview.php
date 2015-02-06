<?php

/**
 * Provide the dashboard overview view for the plugin.
 *
 * This file is used to markup the admin  aspects of the plugin.
 *
 * @link       https://checkmy.ws
 * @since      1.0.0
 *
 * @package    check-my-website
 * @subpackage check-my-website/admin/partials
 */
?>

<!-- Overview starts -->

<div class="cmws-table">
	<div class="cmws-row">
		<div class="cmws-cell">
			<div class="cmws-panel cmws-panel-default cmws-panel-widget cmws-color">
				<div class="cmws-panel-heading cmws-color-alt"><span class="dashicons dashicons-admin-site"></span> <?php _e( 'Url monitored', 'check-my-website' ); ?></div>
                                <div class="cmws-panel-body cmws-font">
					
	                        <?php

        	                        if ( isset( $data['global']['url'] ) ) {
			                        echo '<span class="cmws-label cmws-label-' . $data['global']['label'] . '">' . $data['global']['state'] . '</span> <a class="cmws-link" target="_blank" href="' . $data['global']['url'] . '">' . $data['global']['url'] . '</a>';
					} else {
						echo '<span>' . __( 'No url', 'check-mywebsite' ) . '</span>';
					}

				?>
						
                                </div>
			</div>
		</div>
	</div>
	<div class="cmws-row">
		<div class="cmws-column cmws-column-3">
			<div class="cmws-cell">
				<div class="cmws-panel cmws-panel-default cmws-panel-widget cmws-color">
					<div class="cmws-panel-heading cmws-color-alt"><span class="dashicons dashicons-calendar"></span> <?php _e( 'State duration', 'check-my-website' ); ?></div>
					<div class="cmws-panel-body cmws-widget-height">

					<?php

                        	                if ( isset( $data['global'] ) ) {
							echo '<span class="cmws-widget-font-x3">' . $data['global']['state_duration'] . ' ' .__( 'day(s)', 'check-my-website' ) . '</span><br/><span class="cmws-widget-font cmws-' . $data['global']['label'] . '">' . $data['global']['last_change_date'] . '</span>';
                                                } else {
                                                        echo '<span>' . __( 'No data', 'check-my-website' ) . '</span>';
                                                }

                                       	?>

                               		</div>
                       		</div>
                	</div>
	        	<div class="cmws-cell">
        	        	<div class="cmws-list-group">
                                	<span class="cmws-list-group-item cmws-color-alt cmws-font-alt" ><span class="dashicons dashicons-welcome-view-site"></span> <?php _e( 'States', 'check-my-website' ); ?> (<?php echo $data['global']['last_response_time']; ?>)</span>

                                	<?php

						if ( isset( $data['pollers'] ) ) {
                                        		foreach ( $data['pollers'] as $poller => $poller_values ) {
								echo '<span class="cmws-list-group-item cmws-color cmws-font"><img class="cmws-flag cmws-flag-' . $poller_values['flag'] . '" src="' . plugins_url( '/assets/blank.gif', dirname(__DIR__ )) . '" alt="" /><span class="cmws-label cmws-label-' . $poller_values['label'] . '">' . $poller_values['state'] . '</span> ' . '<span class="cmws-label cmws-label-info cmws-pull-right">' . cmws_convert( $poller_values['time'], $default_unit ) . $default_unit . '</span>' . $poller_values['name'] . '<br></span>';
                                        		}
						} else {
							echo '<span class="cmws-list-group-item cmws-color cmws-font">' . __( 'No pollers', 'check-my-website' ) . '</span>';
						}

                                	?>

                       		</div>
			</div>
			<div class="cmws-cell">
                                <div class="cmws-list-group">
                                        <span class="cmws-list-group-item cmws-color-alt cmws-font-alt" ><span class="dashicons dashicons-info"></span> <?php _e( 'Informations', 'check-my-website' ); ?></span>

					<?php

                                                if ( isset( $data['infos'] ) ) {
							foreach ( $data['infos'] as $info => $info_values ) {
								if ( isset ( $info_values ) ) {
									echo '<span class="cmws-list-group-item cmws-color cmws-font">' . $info_values['name'] . ' <span class="cmws-label cmws-label-' . $info_values['label'] . ' cmws-pull-right">' . $info_values['data'] . '</span><br/></span>';
								}
							}
                                                } else {
                                                        echo '<span class="cmws-list-group-item cmws-color cmws-font">' . __( 'No data', 'check-my-website' ) . '</span>';
                                                }

                                        ?>

                                </div>
                        </div>
		</div>
        	<div class="cmws-column cmws-column-9">
                	<div class="cmws-column cmws-column-3">
                       		<div class="cmws-cell">
                               		<div class="cmws-panel cmws-panel-default cmws-panel-widget cmws-color">
                                    		<div class="cmws-panel-heading cmws-color-alt"><span class="dashicons dashicons-awards"></span> <?php _e( 'Performance', 'check-my-website' ); ?> (YSlow)</div>
                                        	<div class="cmws-panel-body cmws-widget-height cmws-text-center">

						<?php

                                                	if ( isset( $data['yslow'] ) ) {
                                                        	echo '<span class="cmws-widget-font-x2 cmws-label cmws-label-' . $data['yslow']['label'] . '">' . $data['yslow']['grade'] . '</span><br/><br/><span class="widget-font">' . __( 'Score:', 'check-my-website' ) . ' ' . $data['yslow']['score'] . '</span>';
                                                	} else {
                                                        	echo '<span>' . __( 'No data', 'check-my-website' ) . '</span>';
                                                	}

                                        	?>

                                        	</div>
                                	</div>
                        	</div>
			</div>
                	<div class="cmws-column cmws-column-3">
                   		<div class="cmws-cell">
                              		<div class="cmws-panel cmws-panel-default cmws-panel-widget cmws-color">
                                      		<div class="cmws-panel-heading cmws-color-alt"><span class="dashicons dashicons-clock"></span> <?php _e( 'Availability', 'check-my-website' ); ?> (24h)</div>
                                        	<div class="cmws-panel-body cmws-widget-height">

						<?php

                                                        if ( isset( $data['global']['availability'] ) ) {
                                                                echo '<span class="cmws-widget-font-x3">' . $data['global']['availability'] . '<span class="cmws-widget-font"> %</span></span><br/><span class="cmws-widget-font cmws-info">' . __( 'a day', 'check-my-website' ) . '</span>';
                                                        } else {
                                                                echo '<span>' . __( 'No data', 'check-my-website' ) . '</span>';
                                                        }

                                                ?>						

                                        	</div>
                               		</div>
                        	</div>
                	</div>
			<div class="cmws-column cmws-column-3">
                       		<div class="cmws-cell">
                               		<div class="cmws-panel cmws-panel-default cmws-panel-widget cmws-color">
                                       		<div class="cmws-panel-heading cmws-color-alt"><span class="dashicons dashicons-dashboard"></span> <?php _e( 'Latest response time', 'check-my-website' ); ?></div>
                                        	<div class="cmws-panel-body cmws-widget-height">

						<?php

                                                        if ( isset( $data['global']['latest_response_time'] ) ) {
                                                                echo '<span class="cmws-widget-font-x3">' . cmws_convert( $data['global']['latest_response_time'], $default_unit ) . '<span class="cmws-widget-font"> ' . $default_unit . '</span></span><br/><span class="cmws-widget-font cmws-info">' . $data['global']['last_response_time'] . '</span>';
                                                        } else {
                                                                echo '<span>' . __( 'No data', 'check-my-website' ) . '</span>';
                                                        }

                                                ?>

                                        	</div>
                                	</div>
                        	</div>
                	</div>
                	<div class="cmws-column cmws-column-3">
                     		<div class="cmws-cell">
                               		<div class="cmws-panel cmws-panel-default cmws-panel-widget cmws-color">
                                       		<div class="cmws-panel-heading cmws-color-alt"><span class="dashicons dashicons-dashboard"></span> <?php _e( 'Average time', 'check-my-website' ); ?> (24h)</div>
                                        	<div class="cmws-panel-body cmws-widget-height">

						<?php

                                                        if ( isset( $data['global']['average_time'] ) ) {
                                                                echo '<span class="cmws-widget-font-x3">' . cmws_convert( $data['global']['average_time'], $default_unit ) . '<span class="cmws-widget-font"> ' . $default_unit . '<span></span>';
                                                        } else {
                                                                echo '<span>' . __( 'No data', 'check-my-website' ) . '</span>';
                                                        }

                                                ?>

                                        	</div>
                                	</div>
                       		</div>
                	</div>
                	<div class="cmws-column cmws-column-12">
                       		<div class="cmws-cell">
                               		<div class="cmws-panel cmws-panel-default cmws-panel-widget cmws-color">
                                       		<div class="cmws-panel-heading cmws-color-alt"><span class="dashicons dashicons-list-view"></span> <?php _e( 'Logs', 'check-my-website' ); ?> (24h)</div>
                                        	<div class="cmws-panel-body">
							<table class="cmws-table cmws-table-striped" cmws-font>
								<tbody>	

								<?php

									if ( isset( $data['logs'] ) ) {
										foreach ( $data['logs'] as $log => $log_values ) {
											if ( $log_values['display'] ) {
                                		                        			echo '<tr>';
													echo '<td><span class="cmws-label cmws-label-' . $log_values['label'] . '">' . $log_values['state'] . '</span></td>';
													echo '<td>' . $log_values['date'] . '</span></td>';
													echo '<td>' . $log_values['source'] . '</span></td>';
													echo '<td>' . $log_values['message'] . '</span></td>';
												echo '</tr>';
											}
										}
									} else {
                                             					echo '<span>' . __( 'No messages', 'check-my-website' ) . '</span>';
									}

								?>

								</tbody>
                                			</table>
                                        	</div>
                                	</div>
                        	</div>
                	</div>
		</div>
	</div>
</div>

<br style="clear:both" />

<!-- Overview ends -->
