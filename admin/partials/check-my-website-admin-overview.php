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
				<div class="cmws-panel-heading cmws-color-alt">Url monitored</div>
                                <div class="cmws-panel-body cmws-font">
					
	                        <?php

        	                        if ( $data['global'] ) {
			                        echo '<span class="cmws-label cmws-label-' . $data['global']['label'] . '">' . $data['global']['state'] . '</span> <a class="cmws-link" target="_blank" href="' . $data['global']['url'] . '">' . $data['global']['url'] . '</a>';
					} else {
						echo '<span class="cmws-danger">No url</span>';
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
					<div class="cmws-panel-heading cmws-color-alt">State duration</div>
					<div class="cmws-panel-body cmws-widget-height">

					<?php

                        	                if ( $data['global'] ) {
							echo '<span class="cmws-widget-font-x3">' . $data['global']['state_duration'] . ' day</span><br/><span class="cmws-widget-font cmws-' . $data['global']['label'] . '">' . $data['global']['last_date'] . '</span>';
                                                } else {
                                                        echo '<span class="cmws-danger">No data</span>';
                                                }

                                       	?>

                               		</div>
                       		</div>
                	</div>
	        	<div class="cmws-cell">
        	        	<div class="cmws-list-group">
                                	<span class="cmws-list-group-item cmws-color-alt cmws-font-alt" >States (<?php echo $data['global']['last_time']; ?>)</span>

                                	<?php

						if ( $data['pollers'] ) {
                                        		foreach ( $data['pollers'] as $poller => $poller_values ) {
								echo '<span class="cmws-list-group-item cmws-color cmws-font"><img class="cmws-flag cmws-flag-' . $poller_values['flag'] . '" src="' . plugins_url( '/assets/blank.gif', __DIR__ ) . '" alt="" /><span class="cmws-label cmws-label-' . $poller_values['label'] . '">' . $poller_values['state'] . '</span> ' . '<span class="cmws-label cmws-label-info cmws-pull-right">' . convert( $poller_values['time'], $default_unit ) . $default_unit . '</span>' . $poller_values['name'] . '<br></span>';
                                        		}
						} else {
							echo '<span class="cmws-list-group-item cmws-color cmws-font cmws-danger">No pollers</span>';
						}

                                	?>

                       		</div>
			</div>
			<div class="cmws-cell">
                                <div class="cmws-list-group">
                                        <span class="cmws-list-group-item cmws-color-alt cmws-font-alt" >Informations</span>

					<?php

                                                if ( $data['infos'] ) {
							foreach ( $data['infos'] as $info => $info_values ) {
								if ( $info_values ) {
									echo '<span class="cmws-list-group-item cmws-color cmws-font">' . $info_values['name'] . ' <span class="cmws-label cmws-label-' . $info_values['label'] . ' cmws-pull-right">' . $info_values['data'] . '</span><br/></span>';
								}
							}
                                                } else {
                                                        echo '<span class="cmws-list-group-item cmws-color cmws-font cmws-danger">No data</span>';
                                                }

                                        ?>

                                </div>
                        </div>
		</div>
        	<div class="cmws-column cmws-column-9">
                	<div class="cmws-column cmws-column-3">
                       		<div class="cmws-cell">
                               		<div class="cmws-panel cmws-panel-default cmws-panel-widget cmws-color">
                                    		<div class="cmws-panel-heading cmws-color-alt">YSlow</div>
                                        	<div class="cmws-panel-body cmws-widget-height cmws-text-center">

						<?php

                                                	if ( $data['yslow'] ) {
                                                        	echo '<span class="cmws-widget-font-x2 cmws-label cmws-label-' . $data['yslow']['label'] . '">' . $data['yslow']['grade'] . '</span><br/><br/><span class="widget-font">Score: ' . $data['yslow']['score'] . '</span>';
                                                	} else {
                                                        	echo '<span class="cmws-danger">No data</span>';
                                                	}

                                        	?>

                                        	</div>
                                	</div>
                        	</div>
			</div>
                	<div class="cmws-column cmws-column-3">
                   		<div class="cmws-cell">
                              		<div class="cmws-panel cmws-panel-default cmws-panel-widget cmws-color">
                                      		<div class="cmws-panel-heading cmws-color-alt">Availability (24h)</div>
                                        	<div class="cmws-panel-body cmws-widget-height">

						<?php

                                                        if ( $data['global'] ) {
                                                                echo '<span class="cmws-widget-font-x3">' . $data['global']['availability'] . '<span class="cmws-widget-font"> %</span></span><br/><span class="cmws-widget-font cmws-info">a day</span>';
                                                        } else {
                                                                echo '<span class="cmws-danger">No data</span>';
                                                        }

                                                ?>						

                                        	</div>
                               		</div>
                        	</div>
                	</div>
			<div class="cmws-column cmws-column-3">
                       		<div class="cmws-cell">
                               		<div class="cmws-panel cmws-panel-default cmws-panel-widget cmws-color">
                                       		<div class="cmws-panel-heading cmws-color-alt">Last time response</div>
                                        	<div class="cmws-panel-body cmws-widget-height">

						<?php

                                                        if ( $data['global'] ) {
                                                                echo '<span class="cmws-widget-font-x3">' . convert( $data['global']['last_time_response'], $default_unit ) . '<span class="cmws-widget-font"> ' . $default_unit . '</span></span>';
                                                        } else {
                                                                echo '<span class="cmws-danger">No data</span>';
                                                        }

                                                ?>

                                        	</div>
                                	</div>
                        	</div>
                	</div>
                	<div class="cmws-column cmws-column-3">
                     		<div class="cmws-cell">
                               		<div class="cmws-panel cmws-panel-default cmws-panel-widget cmws-color">
                                       		<div class="cmws-panel-heading cmws-color-alt">Average time (24h)</div>
                                        	<div class="cmws-panel-body cmws-widget-height">

						<?php

                                                        if ( $data['global'] ) {
                                                                echo '<span class="cmws-widget-font-x3">' . convert( $data['global']['average_time'], $default_unit ) . '<span class="cmws-widget-font"> ' . $default_unit . '<span></span>';
                                                        } else {
                                                                echo '<span class="cmws-danger">No data</span>';
                                                        }

                                                ?>

                                        	</div>
                                	</div>
                       		</div>
                	</div>
                	<div class="cmws-column cmws-column-12">
                       		<div class="cmws-cell">
                               		<div class="cmws-panel cmws-panel-default cmws-panel-widget cmws-color">
                                       		<div class="cmws-panel-heading cmws-color-alt">Logs (24h)</div>
                                        	<div class="cmws-panel-body">
							<table class="cmws-table cmws-table-striped" cmws-font>
								<tbody>	

								<?php

									if ( $data['logs'] ) {
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
                                             					echo '<span class="cmws-info">No messages</span>';
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
