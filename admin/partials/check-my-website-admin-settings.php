<?php

/**
 * Provide a settings view for the plugin.
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

	<div class="cmws-content">

		<h3 class="nav-tab-wrapper">

                <?php
                        foreach( $tabs as $tab => $name ){
                                $class = ( $tab == $current ) ? ' nav-tab-active' : '';
                                if ( $tab == 'dashboard' ) {
                                        echo '<a class="nav-tab' . $class . '" href="index.php?page=check-my-website">' . $name . '</a>';
                                } else {
                                        echo '<a class="nav-tab' . $class . '" href="?page=check-my-website-settings&tab=' . $tab . '">' . $name . '</a>';
                                };

                        }
                ?>

                </h3>

                <?php
                        if ( $pagenow == 'options-general.php' && $_GET['page'] == 'check-my-website-settings' ) {

				if ( isset ( $_GET['tab'] ) ) $tab = $_GET['tab'];
				else $tab = 'settings';

				switch ( $tab ){
                                        case 'settings' :
		?>

		<div class="wrap">
			<form method="post" action="options.php">

                        <?php
                                settings_fields( 'cmws_settings' );
		                do_settings_sections( 'check-my-website-settings' );
                               	submit_button();
                        ?>

                	</form>
		</div>

		<?php
					break;
				};

			};
                ?>

	</div>

