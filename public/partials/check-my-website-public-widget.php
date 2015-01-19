<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="<?php echo $style; ?>">

<?php

	// Display widget title if title is entered.
	if ( $title ) {

		echo $before_title . $title . $after_title;

	}

	// Display text if text is entered/
	if ( $text ) {

		echo $text . '<br/>';

	}

	// Display url if url is checked.
	if ( $url == true ) {

		$urlFilter = array( 'http://', 'https://' );
		$urlReplace = '';

?>
         
		<div class="cmws-panel cmws-panel-default cmws-panel-widget cmws-color">
			<div class="cmws-panel-body cmws-font">
				<span class="cmws-label cmws-label-success"><?php echo state( $data['status']['state'] ); ?></span> <a class="cmws-link" target="_blank" href="<?php echo $data['status']['url']; ?>"><?php echo str_replace( $urlFilter, $urlReplace, $data['status']['url'] ); ?></a>
			</div>
		</div>

<?php

	}

	// Display availability on 24h if availability is checked
	if ( $availability == true ) {

		$lastKey = key( array_slice( $data['week']['series']['checks.' . $api->get_api_key() . '.state.all']['data'], -1, 1, TRUE ) );

?>

		<div class="cmws-list-group">
                	<span class="cmws-list-group-item cmws-color-alt cmws-font-alt">Availability (24h)</span>
			<span class="cmws-list-group-item cmws-color cmws-font"><span class="cmws-widget-font-x2"><?php echo $data['week']['series']['checks.' . $api->get_api_key() . '.state.all']['data'][$lastKey][1]; ?> %</span></span>
                </div>

<?php

	}

	// Display last time response (average) if checkbox is checked
	if ( $check == true ) {

		$avg = array_sum( $data['status']['lastvalues']['httptime'] ) / count( $data['status']['lastvalues']['httptime'] );

?>

		<div class="cmws-list-group">
			<span class="cmws-list-group-item cmws-color-alt cmws-font-alt">Last response time</span>
			<span class="cmws-list-group-item cmws-color cmws-font"><span class="cmws-widget-font-x2"><?php echo convert( round( $avg ), $unit ) . ' ' . $unit; ?></span></span>
		</div>

<?php

	}

	// Display average time if checkbox is checked
        if ( $average == true ) {

                $avg = array_sum( $data['status']['lastvalues']['httptime'] ) / count( $data['status']['lastvalues']['httptime'] );

?>

                <div class="cmws-list-group">
                        <span class="cmws-list-group-item cmws-color-alt cmws-font-alt">Average time (24h)</span>
                        <span class="cmws-list-group-item cmws-color cmws-font"><span class="cmws-widget-font-x2"><?php echo convert( round( $average_time ), $unit ) . ' ' . $unit; ?></span></span>
                </div>

<?php

        }

	// Display check location(s) if location is checked
	if ( $location == true ) {

		$lastCheck = new DateTime();
                $lastCheck->SetTimestamp( $data['status']['metas']['lastcheck'] );

?>

                <div class="cmws-list-group">
			<span class="cmws-list-group-item cmws-color-alt cmws-font-alt" >States (<?php echo $lastCheck->format( 'H:i:s'); ?>)</span>

<?php

			foreach ( $data['status']['lastvalues']['httptime'] as $key => $value ) {
                                echo '<span class="cmws-list-group-item cmws-color cmws-font">' . flag( substr( $key, 0, 2 ) ) . '<span class="cmws-label cmws-label-success">' . state( $data['status']['states'][$key] ) . '</span> ' . '<span class="cmws-label cmws-label-info cmws-pull-right">' . convert( $value, $unit ) . $unit . '</span>' . poller( $key, $style ) . '<br></span>';
       		        }

?>

                </div>

<?php

	}

	// Display YSlow data if yslow is checked
	if ( $yslow == true ) {

		$pageLoadTime = convert( $data['status']['metas']['yslow_page_load_time'], $unit );
                $score = $data['status']['metas']['yslow_score'];

?>

                <div class="cmws-panel cmws-panel-default cmws-panel-widget cmws-color">
			<div class="cmws-panel-heading cmws-color-alt">YSlow</div>
			<div class="cmws-panel-body cmws-widget-height cmws-text-center">
				<span class="cmws-widget-font-x2 cmws-label cmws-label-<?php echo $yslow_data['label']; ?>"><?php echo $yslow_data['grade']; ?></span><br/><br/><span class="widget-font">Score: <?php echo $yslow_data['score']; ?></span>
			</div>
		</div>

<?php

	}

?>

</div>
