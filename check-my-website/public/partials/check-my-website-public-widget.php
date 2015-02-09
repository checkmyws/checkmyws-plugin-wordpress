<?php
/**
 * Provide a public-facing view for the widget plugin.
 *
 * This file is used to markup the public-facing aspects
 * of the widget plugin.
 *
 * @link       https://checkmy.ws
 * @since      1.0.0
 *
 * @package    check-my-website
 * @subpackage check-my-website/public/partials
 * @author     Check my Website by NOVATEEK <contact@checkmy.ws>
 */
?>

<!-- Widget starts -->

<?php
	/**
         * Display widget title if title field is filled.
         *
         * @since    1.0.0
         */
	if ( $title ) {

		echo $before_title . $title . $after_title;

	}

	/**
         * Display text if text field is filled.
         *
         * @since    1.0.0
         */
	if ( $text ) {

		echo $text . '<br/>';

	}

	/**
         * Display url if url option is checked.
         *
         * @since    1.0.0
         */
	if ( $url == true ) {

		$urlFilter = array( 'http://', 'https://' );
		$urlReplace = '';
?>
         
		<div class="cmws-panel cmws-panel-default cmws-panel-widget cmws-color">
			<div class="cmws-panel-body cmws-font">

			<?php
				if ( $data['global']['url'] ) {
                                	echo '<span class="cmws-label cmws-label-' . $data['global']['label'] . '">' . $data['global']['state'] . '</span> <a class="cmws-link" target="_blank" href="' . $data['global']['url'] . '">' . str_replace( $urlFilter, $urlReplace, $data['global']['url'] ) . '</a>';
                                } else {
                                	echo '<span>' . __( 'No url', 'check-mywebsite' ) . '</span>';
                                }
                        ?>

			</div>
		</div>

<?php
	}

	/**
         * Display availability on 24h if availability option is checked.
         *
         * @since    1.0.0
         */
	if ( $availability == true ) {
?>
		<div class="cmws-panel cmws-panel-default cmws-panel-widget cmws-color">
			<div class="cmws-panel-heading cmws-color-alt"><?php _e( 'Availability', 'check-my-website' ); ?> (24h)</div>
                        <div class="cmws-panel-body">

                        <?php
	                	if ( $data['global']['availability'] ) {
					echo '<span class="cmws-widget-font-x2">' . $data['global']['availability'] . '<span class="cmws-widget-font"> %</span></span><br/><span class="cmws-widget-font cmws-info">a day</span>';
				} else {
                                	echo '<span>' . __( 'No data', 'check-my-website' ) . '</span>';
                                }
			?>

			</div>
		</div>

<?php
	}

	/**
         * Display latest time response if latest option is checked.
         *
         * @since    1.0.0
         */
	if ( $latest == true ) {
?>

		<div class="cmws-panel cmws-panel-default cmws-panel-widget cmws-color">
			<div class="cmws-panel-heading cmws-color-alt"> <?php _e( 'Lastest time response', 'check-my-website' ); ?></div>
			<div class="cmws-panel-body">

                        <?php
				if ( $data['global']['latest_response_time'] ) {
                                	echo '<span class="cmws-widget-font-x2">' . cmws_convert( $data['global']['latest_response_time'], $unit ) . '<span class="cmws-widget-font"> ' . $unit . '</span></span><br/><span class="cmws-widget-font cmws-info">' . $data['global']['last_response_time'] . '</span>';
                                } else {
                                	echo '<span>' . __( 'No data', 'check-my-website' ) . '</span>';
                                }
			?>

                       </div>
		</div>

<?php
	}

	/**
         * Display average time if average option is checked.
         *
         * @since    1.0.0
         */
        if ( $average == true ) {
?>

		<div class="cmws-panel cmws-panel-default cmws-panel-widget cmws-color">
			<div class="cmws-panel-heading cmws-color-alt"><?php _e( 'Average time', 'check-my-website' ); ?> (24h)</div>
                	<div class="cmws-panel-body">

                        <?php
				if ( $data['global'] ) {
                                	echo '<span class="cmws-widget-font-x2">' . cmws_convert( $data['global']['average_time'], $unit ) . '<span class="cmws-widget-font"> ' . $unit . '<span></span>';
                                } else {
                                	echo '<span class="cmws-danger">' . __( 'No data', 'check-my-website' ) . '</span>';
                                }
			?>

			</div>
		</div>

<?php
        }

	/**
         * Display states/pollers if poller option is checked.
         *
         * @since    1.0.0
         */
	if ( $poller == true ) {
?>

                <div class="cmws-list-group">
			<span class="cmws-list-group-item cmws-color-alt cmws-font-alt" ><?php _e( 'States', 'check-my-website' ); ?> (<?php echo $data['global']['last_response_time']; ?>)</span>

			<?php
				if ( $data['pollers'] ) {
					foreach ( $data['pollers'] as $poller => $poller_values ) {
						echo '<span class="cmws-list-group-item cmws-color cmws-font"><img class="cmws-flag cmws-flag-' . $poller_values['flag'] . '" src="' . plugins_url( '/assets/blank.gif', dirname(__DIR__ )) . '" alt="" /><span class="cmws-label cmws-label-' . $poller_values['label'] . '">' . $poller_values['state'] . '</span> ' . '<span class="cmws-label cmws-label-info cmws-pull-right">' . cmws_convert( $poller_values['time'], $unit ) . $unit . '</span>' . $poller_values['name'] . '<br></span>';
					}
				} else {
					echo '<span class="cmws-list-group-item cmws-color cmws-font">' . __( 'No pollers', 'check-my-website' ) . '</span>';
				}
			?>

		</div>

<?php
	}

	/**
         * Display performance if yslow option is checked.
         *
         * @since    1.0.0
         */
	if ( $yslow == true ) {
?>

		<div class="cmws-panel cmws-panel-default cmws-panel-widget cmws-color">
			<div class="cmws-panel-heading cmws-color-alt"><?php _e( 'Performance', 'check-my-website' ); ?> (YSlow)</div>
                	<div class="cmws-panel-body cmws-widget-height cmws-text-center">

                        <?php
				if ( $data['yslow'] ) {
                                	echo '<span class="cmws-widget-font-x2 cmws-label cmws-label-' . $data['yslow']['label'] . '">' . $data['yslow']['grade'] . '</span><br/><br/><span class="widget-font">' . __( 'Score:', 'check-my-website' ) . ' ' . $data['yslow']['score'] . '</span>';
                                } else {
                                	echo '<span>' . __( 'No data', 'check-my-website' ) . '</span>';
                                }
			?>

                        </div>
		</div>

<?php
	}
?>

<!-- Widget ends -->

