<?php

// Check my Website settings
class checkmyws_settings {

	// Init settings
        function __construct() {

                add_action( 'admin_menu', array( $this, 'checkmyws_settings_menu' ) );
		add_action( 'admin_init', array( $this, 'checkmyws_settings_options' ) );

        }

	// Load Check my Website menu and page
        function checkmyws_settings_menu() {

                add_options_page( 'Check my Website', 'Check my Website', 'manage_options', 'checkmyws', array( $this, 'checkmyws_settings_page' ) );

        }

	// Load Check my Website settings options
	function checkmyws_settings_options() {

		add_settings_section( 'checkmyws-settings-url', 'URL', array( $this, 'checkmyws_settings_url' ), 'checkmyws' );
		add_settings_field( 'checkmyws-settings-url-id', 'URL ID code', array( $this, 'checkmyws_settings_url_id' ), 'checkmyws', 'checkmyws-settings-url' );
		register_setting( 'checkmyws-settings-options', 'checkmyws_options', array( $this, 'checkmyws_settings_options_validate') );

        }

	// Display url options section
	function checkmyws_settings_url() {

		echo '<p>The URL ID below is required to get data from Check my Website API. You can find this value at the Check my Website console, in the Preferences tab (Advanced mode) of your monitored URL.</p>';

	}

	// Display url id option
	function checkmyws_settings_url_id() {

		$options = get_option( 'checkmyws_options' );
		echo '<input type="text" name="checkmyws_options[checkmyws-settings-url-id]" value="' . $options['checkmyws-settings-url-id'] . '" />';

	}

	// Validate option entered
	function checkmyws_settings_options_validate( $arr_input ) {

		$options = get_option(' checkmyws_options ');
		$options['checkmyws-settings-url-id'] = ( $arr_input['checkmyws-settings-url-id'] );

		return $options;

	}

	// Display Check my Website Settings page
        function checkmyws_settings_page() {

                echo '<div class="wrap">';
                        echo '<div class="checkmyws-settings-title">';
                                echo '<h2>Check my Website Settings</h2>';
                                echo '<div class="checkmyws-settings-description">';
                                        echo '<p>Get monitoring data from your <a href="https://checkmy.ws" target="_blank">Check my Website</a> account. Not registered ? Go to <a href="https://console.checkmy.ws" target="_blank">register a free account</a>.</p>';
                                echo '</div>';
                        echo '</div>';
                        echo '<div class="checkmyws-settings-content">';
                                echo '<form method="post" action="options.php">';
					settings_fields( 'checkmyws-settings-options' );
					do_settings_sections( 'checkmyws' );
					submit_button();
                                echo '</form>';
                        echo '</div>';
                echo '</div>';

        }

}

?>
