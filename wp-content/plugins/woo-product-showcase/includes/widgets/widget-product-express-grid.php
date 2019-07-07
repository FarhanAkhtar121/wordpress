<?php
if (!class_exists('AFTWPL_Product_Express_List')) :
    /**
     * Adds AFTWPL_Product_Express_List widget.
     */
    class AFTWPL_Product_Express_List extends AFTWPL_Widget_Base
    {
        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $this->text_fields = array('aftwpl-categorised-product-title', 'aftwpl-product-number');
            $this->select_fields = array('aftwpl-select-product-category', 'aftwpl-product-show', 'aftwpl-select-product-orderby', 'aftwpl-select-product-order');

            $widget_ops = array(
                'classname' => 'aftwpl_product_express_list',
                'description' => __('Displays products from selected category in single column.', 'woo-product-showcase'),
                'customize_selective_refresh' => true,
            );

            parent::__construct('aftwpl_product_express_list', __('AFT Products Express List', 'woo-product-showcase'), $widget_ops);
        }

        /**
         * Front-end display of widget.
         *
         * @see WP_Widget::widget()
         *
         * @param array $args Widget arguments.
         * @param array $instance Saved values from database.
         */

        public function widget($args, $instance)
        {

            $instance = parent::aftwpl_sanitize_data($instance, $instance);


            /** This filter is documented in wp-includes/default-widgets.php */

            $title = apply_filters('widget_title', $instance['aftwpl-categorised-product-title'], $instance, $this->id_base);
            $number_of_products = isset($instance['aftwpl-product-number']) ? $instance['aftwpl-product-number'] : '4';
            $category = isset($instance['aftwpl-select-product-category']) ? $instance['aftwpl-select-product-category'] : '0';
            $show = isset($instance['aftwpl-product-show']) ? $instance['aftwpl-product-show'] : '';
            $orderby = isset($instance['aftwpl-select-product-orderby']) ? $instance['aftwpl-select-product-orderby'] : 'date';
            $order = isset($instance['aftwpl-select-product-order']) ? $instance['aftwpl-select-product-order'] : 'desc';

            // open the widget container
            echo $args['before_widget'];
            ?>
            <?php if (!empty($title)): ?>
            <h2 class="widget-title aftwpl-section-title">
                <span><?php echo esc_html($title); ?></span>
            </h2>
        <?php endif; ?>
            <?php if (class_exists('WooCommerce')): ?>
                <?php include AFTWPL_PLUGIN_DIR.'/includes/blocks/block-product-express-grid.php'; ?>
            <?php endif; ?>
            <?php
            //print_pre($all_posts);

            // close the widget container
            echo $args['after_widget'];
        }

        /**
         * Back-end widget form.
         *
         * @see WP_Widget::form()
         *
         * @param array $instance Previously saved values from database.
         */
        public function form($instance)
        {
            $this->form_instance = $instance;

            //print_pre($terms);
            $categories = aftwpl_get_terms(0, 'product_cat');

            $show = array(
                '' => __('All products', 'woocommerce'),
                'featured' => __('Featured products', 'woocommerce'),
                'onsale' => __('On-sale products', 'woocommerce'),
            );

            $orderby = array(
                'date' => __('Date', 'woocommerce'),
                'price' => __('Price', 'woocommerce'),
                'rand' => __('Random', 'woocommerce'),
                'sales' => __('Sales', 'woocommerce'),
            );

            $order = array(
                'asc' => __('ASC', 'woocommerce'),
                'desc' => __('DESC', 'woocommerce'),
            );




            if (isset($categories) && !empty($categories)) {
                // generate the text input for the title of the widget. Note that the first parameter matches text_fields array entry
                echo parent::aftwpl_generate_text_input('aftwpl-categorised-product-title', 'Title', 'AFT Product Express List');
                echo parent::aftwpl_generate_select_options('aftwpl-select-product-category', __('Select category', 'woo-product-showcase'), $categories);
                echo parent::aftwpl_generate_text_input('aftwpl-product-number', __('Number of products', 'woo-product-showcase'), '4', 'number');
                echo parent::aftwpl_generate_select_options('aftwpl-product-show', __('Show', 'woo-product-showcase'), $show);
                echo parent::aftwpl_generate_select_options('aftwpl-select-product-orderby', __('Orderby', 'woo-product-showcase'), $orderby);
                echo parent::aftwpl_generate_select_options('aftwpl-select-product-order', __('Order', 'woo-product-showcase'), $order);

            }

            //print_pre($terms);


        }

    }
endif;