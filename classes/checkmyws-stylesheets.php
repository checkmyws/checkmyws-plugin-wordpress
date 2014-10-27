<?php

class checkmyws_stylesheets {

        function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'checkmyws_admin_style' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'checkmyws_frontend_style' ) );
        }

        function checkmyws_admin_style() {
		 wp_enqueue_style( 'checkmyws-admin-style', plugins_url( 'assets/styles/checkmyws-admin.css', __DIR__ ) );
        }

	function checkmyws_frontend_style() {
		 wp_enqueue_style( 'checkmyws-frontend-style', plugins_url( 'assets/styles/checkmyws.css', __DIR__ ) );
	}
}

?>
