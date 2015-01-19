<?php

/**
 * Provide a dashboard view for the plugin.
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

<!-- Dashboard starts -->

		<div class="cmws-content">

			<div class="cmws-text-center">

			<?php 

				if ( !isset( $data ) ) {
					echo '<span class="cmws-label cmws-label-danger">API key parameter is required to this plugin to work. Please go to Settings page to set it.</span><br/><br/>';
				}

			?>

			</div>

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

						include( plugin_dir_path( __FILE__ ) . 'check-my-website-admin-overview.php' );

      						break;

      					case 'logs' :

						include( plugin_dir_path( __FILE__ ) . 'check-my-website-admin-logs.php' );

      						break;

      					case 'metrics' :

						include( plugin_dir_path( __FILE__ ) . 'check-my-website-admin-metrics.php' );

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

<!-- Dashboard ends -->
