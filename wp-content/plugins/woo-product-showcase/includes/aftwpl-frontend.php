<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


/**
 * Woo Product Shortcode
 *
 * Allows user to get Woo Product Shortcode.
 *
 * @class   AFTWPL_Woo_Product_Showcase_Frontend
 */


class AFTWPL_Woo_Product_Showcase_Frontend {



	/**
	 * Init and hook in the integration.
	 *
	 * @return void
	 */


	public function __construct() {
		$this->id                 = 'AFTWPL_Woo_Product_Showcase_Frontend';
		$this->method_title       = __( 'Woo Product Shortcode Frontend', 'wp-post-author' );
		$this->method_description = __( 'Woo Product Shortcode Frontend', 'wp-post-author' );
		
		// Actions
        add_action( 'wp_enqueue_scripts', array( $this, 'woo_product_showcase_enqueue_style') );

        include_once 'shortcodes/aftwpl-shortcodes.php';


	}


	/**
	 * Loading  frontend styles.
	 */

	public function woo_product_showcase_enqueue_style(){


        wp_register_style('aftwpl-bootstrap', AFTWPL_PLUGIN_URL .'lib/bootstrap/css/bootstrap.min.css');
        wp_enqueue_style('aftwpl-bootstrap');
        wp_register_style('aftwpl-frontend-style', AFTWPL_PLUGIN_URL .'assets/css/aftwpl-frontend-style.css', array('aftwpl-bootstrap'), '', 'all');
        wp_enqueue_style('aftwpl-frontend-style');
        wp_add_inline_style( 'aftwpl-frontend-style', aftwpl_custom_style() );
        wp_enqueue_script('jquery');
        wp_enqueue_script('matchheight', AFTWPL_PLUGIN_URL.'lib/jquery-match-height/jquery.matchHeight.min.js', array('jquery'), '', true);


    }




}

$aftwpl_frontend = new AFTWPL_Woo_Product_Showcase_Frontend();