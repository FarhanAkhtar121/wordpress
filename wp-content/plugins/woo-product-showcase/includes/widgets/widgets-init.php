<?php

// Load widget base.
require_once AFTWPL_BASE_DIR . '/includes/widgets/widgets-base.php';

/* Theme Widgets*/
require AFTWPL_BASE_DIR . '/includes/widgets/widget-product-list.php';
require AFTWPL_BASE_DIR . '/includes/widgets/widget-product-grid.php';
require AFTWPL_BASE_DIR . '/includes/widgets/widget-product-express-grid.php';

/* Register site widgets */
if ( ! function_exists( 'woo_product_showcase_widgets' ) ) :
    /**
     * Load widgets.
     *
     * @since 1.0.0
     */
    function woo_product_showcase_widgets() {

        register_widget( 'AFTWPL_Product_List' );
        register_widget( 'AFTWPL_Product_Grid' );
        register_widget( 'AFTWPL_Product_Express_List' );




    }
endif;
add_action( 'widgets_init', 'woo_product_showcase_widgets' );
