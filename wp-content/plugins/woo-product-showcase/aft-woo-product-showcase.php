<?php
/*
 * Plugin Name:       Woo Product Showcase
 * Plugin URI:		  https://wordpress.org/plugins/woo-product-showcase/	
 * Description:       WooCommerce Product List Widget and Shortcodes | WooCommerce Product Grid Widget and Shortcodes | WooCommerce Category and Product List Widget and Shortcodes. The plugin facilitate multiple WooCommerce product widgets and shortcodes in grid and list view with the selected product category.
 * Version:           1.0.3
 * Author:            AF themes
 * Author URI:        https://afthemes.com/
 * Text Domain:       woo-product-showcase
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.html
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );  // prevent direct access

if ( ! class_exists( 'AFTWPL_Woo_Product_Showcase' ) ) :
	
	class AFTWPL_Woo_Product_Showcase {


		/**
		 * Plugin version.
		 *
		 * @var string
		 */
		const VERSION = '1.0.3';

		/**
		 * Instance of this class.
		 *
		 * @var object
		 */
		protected static $instance = null;


		/**
		 * Initialize the plugin.
		 */
		public function __construct(){


            /**
             * Define global constants
             **/
            defined('AFTWPL_BASE_FILE') or define('AFTWPL_BASE_FILE', __FILE__);
            defined('AFTWPL_BASE_DIR') or define('AFTWPL_BASE_DIR', dirname(AFTWPL_BASE_FILE));
            defined('AFTWPL_PLUGIN_URL') or define('AFTWPL_PLUGIN_URL', plugin_dir_url(__FILE__));
            defined('AFTWPL_PLUGIN_DIR') or define('AFTWPL_PLUGIN_DIR', plugin_dir_path(__FILE__));

				
				/**
				 * Check if WooCommerce is active
				 **/
				if ( class_exists('WooCommerce') ) {

                    include_once 'includes/aftwpl-common-functions.php';
                    include_once 'includes/aftwpl-backend.php';                  ;
                    include_once 'includes/aftwpl-custom-style.php';
                    include_once 'includes/aftwpl-frontend.php';


                } else {
					

					add_action( 'admin_notices', array( $this, 'aftwpl_woocommerce_missing_notice' ) );
				}

			} // end of contructor




		/**
		 * Return an instance of this class.
		 *
		 * @return object A single instance of this class.
		 */
		public static function get_instance() {
			
			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		/**
		 * WooCommerce fallback notice.
		 *
		 * @return string
		 */
		public function aftwpl_woocommerce_missing_notice() {
			echo '<div class="notice notice-warning is-dismissible"><p>' . sprintf( __( 'Woo Product Showcase requires %s to be activated. It will serve some special product listing widgets and shortcodes for your site.', 'woo-price-list' ), '<a href="http://www.woothemes.com/woocommerce/" target="_blank">' . __( 'WooCommerce', 'woo-price-list' ) . '</a>' ) . '</p></div>';
			if ( isset( $_GET['activate'] ) )
                 unset( $_GET['activate'] );	
		}




			

	}// end of the class

add_action( 'plugins_loaded', array( 'AFTWPL_Woo_Product_Showcase', 'get_instance' ), 0 );

endif;