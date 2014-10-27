<?php

class checkmyws_settings {

        function __construct() {
                add_action( 'admin_menu', array( $this, 'checkmyws_settings_menu' ) );
		add_action( 'admin_init', array( $this, 'checkmyws_settings_options' ) );
        }

        function checkmyws_settings_menu() {
                add_options_page( 'Check my Website', 'Check my Website', 'manage_options', 'checkmyws', array( $this, 'checkmyws_settings_page' ) );
        }

	function checkmyws_settings_options() {
		add_settings_section( 'checkmyws-settings-section-website', 'Website', array( $this, 'checkmyws_settings_section_website' ), 'checkmyws' );
		add_settings_field( 'checkmyws-settings-field-websiteid', 'Website ID code', array( $this, 'checkmyws_settings_field_websiteid' ), 'checkmyws', 'checkmyws-settings-section-website' );
		register_setting( 'checkmyws-settings-options', 'checkmyws_options', array( $this, 'checkmyws_settings_options_validate') );
        }

	function checkmyws_settings_section_website() {
		echo '<p>The website ID below is required to get data from Check my Website. You can find this value at the Check my Website console in the Preferences tab (Advanced mode) of your monitored website.</p>';
	}
 
	function checkmyws_settings_field_websiteid() {
		$options = get_option( 'checkmyws_options' );
		echo '<input type="text" name="checkmyws_options[checkmyws-settings-field-websiteid]" value="' . $options['checkmyws-settings-field-websiteid'] . '" />';
	}

	function checkmyws_settings_options_validate( $arr_input ) {
		$options = get_option(' checkmyws_options ');
		$options['checkmyws-settings-field-websiteid'] = ( $arr_input['checkmyws-settings-field-websiteid'] );
		return $options;
	}

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
