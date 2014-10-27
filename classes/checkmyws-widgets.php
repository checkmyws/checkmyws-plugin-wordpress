<?php

class checkmyws_widgets {

	function __construct() {
		include( dirname(__DIR__) . '/widgets/checkmyws-widget.php' );
		add_action('widgets_init', array( $this, 'checkmyws_widgets_register' ) );
	}

	function checkmyws_widgets_register() {
                register_widget('checkmyws_widget');
        }	
}

?>
