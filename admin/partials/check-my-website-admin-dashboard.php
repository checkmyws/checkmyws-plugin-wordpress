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

<div class="wrap">

	<div class="checkmyws-settings-title">

	        <h2>Check my Website</h2>

		<div class="checkmyws-settings-description">

			<p>Get monitoring data from your <a href="https://checkmy.ws" target="_blank">Check my Website</a> account. Not registered ? Go to <a href="https://console.checkmy.ws" target="_blank">register a free account</a>.</p>
                
		</div>

	</div>

	<div class="checkmyws-settings-content">

		<h3 class="nav-tab-wrapper">

		<?php 
		foreach( $tabs as $tab => $name ){
        		$class = ( $tab == $current ) ? ' nav-tab-active' : '';
        		if ( $tab == 'settings' ) {
                		echo '<a class="nav-tab' . $class . '" href="options-general.php?page=check-my-website-setting">' . $name . '</a>';
        		} else {
                		echo '<a class="nav-tab' . $class . '" href="?page=check-my-website&tab=' . $tab . '">' . $name . '</a>';
     			};

    		}
		?>

    		</h3>

		<?php
		if ( $pagenow == 'index.php' && $_GET['page'] == 'check-my-website' ){

   			if ( isset ( $_GET['tab'] ) ) $tab = $_GET['tab'];
   			else $tab = 'overview';

   			switch ( $tab ){
      				case 'overview' :

					$options = get_option( 'check_my_website_settings' );
					$api_key = $options['key'];

					$api = new Check_my_Website_Api( $api_key );

					$data = $api->get_api_data();

					echo 'API : ' . $api->get_api_key() . ' key';

					echo '<pre>';
					print_r( $data );
					echo '</pre>';

         	?>
		
					Display data here.
         
		<?php
      				break;
      				case 'logs' :
         	?>

	        		       Enter your Google Analytics tracking code:
        
		 <?php
      				break;
      				case 'metrics' :
         	?>
               
					Enter the introductory text for the home page:
         
		<?php
      				break;
				case 'timeline' :
                ?>

        	        	        Enter the introductory text for the home page:

                <?php
                                break;
				case 'yslow' :
                ?>

                   		     Enter the introductory text for the home page:

                <?php
                                break;
   			};
		};

		?>

	</div>

	<div class="checkmyws-settings-like">

		<p>Do you like this plugin ?</p>

		<ul>
			<li><a target="_blank" href="http://twitter.com/home?status=I%20just%20monitored%20my%20WordPress%20site%20with%20%23checkmyws%20http%3A%2F%2Fwordpress.org%2Fextend%2Fplugins%2Fcheck-my-website%2F">Tweet about it</a></li>
			<li><a target="_blank" href="http://wordpress.org/extend/plugins/check-my-website/">Rate it on the repository</a></li>
		</ul>

	</div>

	<div class="checkmyws-settings-separator"></div>

	<div class="checkmyws-settings-icon"></div>
     
	<div class="checkmyws-settings-author">

		<p>Check my Website Plugin for Wordpress is distributed under GNU License. Developped and powered by <a href="http://checkmy.ws">checkmy.ws</a>.</p>
                        
	</div>

</div>
