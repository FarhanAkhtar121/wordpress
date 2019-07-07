<?php
if (!function_exists('aftwpl_get_products')) :
    /**
     * @param $number_of_products
     * @param $category
     * @param $show
     * @param $orderby
     * @param $order
     * @return WP_Query
     */
    function aftwpl_get_products($number_of_products, $category, $show, $orderby, $order)
    {


        $product_visibility_term_ids = wc_get_product_visibility_term_ids();

        $query_args = array(
            'posts_per_page' => $number_of_products,
            'post_status' => 'publish',
            'post_type' => 'product',
            'no_found_rows' => 1,
            'order' => $order,
            'meta_query' => array(),
            'tax_query' => array(
                'relation' => 'AND',
            ),
        );

        if (absint($category) > 0) {
            $query_args['tax_query'][] = array(
                'taxonomy' => 'product_cat',
                'field' => 'term_taxonomy_id',
                'terms' => $category

            );

        }


        switch ($show) {
            case 'featured' :
                $query_args['tax_query'][] = array(
                    'taxonomy' => 'product_visibility',
                    'field' => 'term_taxonomy_id',
                    'terms' => $product_visibility_term_ids['featured'],
                );
                break;
            case 'onsale' :
                $product_ids_on_sale = wc_get_product_ids_on_sale();
                $product_ids_on_sale[] = 0;
                $query_args['post__in'] = $product_ids_on_sale;
                break;
        }

        switch ($orderby) {
            case 'price' :
                $query_args['meta_key'] = '_price';
                $query_args['orderby'] = 'meta_value_num';
                break;
            case 'rand' :
                $query_args['orderby'] = 'rand';
                break;
            case 'sales' :
                $query_args['meta_key'] = 'total_sales';
                $query_args['orderby'] = 'meta_value_num';
                break;
            default :
                $query_args['orderby'] = 'date';
        }

        return new WP_Query(apply_filters('aftwpl_widget_query_args', $query_args));
    }
endif;

/**
 * Returns all categories.
 *
 * @since AFTWPL 1.0.0
 */
if (!function_exists('aftwpl_get_terms')):
    function aftwpl_get_terms($category_id = 0, $taxonomy = 'category', $default = '')
    {
        $taxonomy = !empty($taxonomy) ? $taxonomy : 'category';

        if ($category_id > 0) {
            $term = get_term_by('id', absint($category_id), $taxonomy);
            if ($term)
                return esc_html($term->name);


        } else {
            $terms = get_terms(array(
                'taxonomy' => $taxonomy,
                'orderby' => 'name',
                'order' => 'ASC',
                'hide_empty' => true,
            ));


            if (isset($terms) && !empty($terms)) {
                foreach ($terms as $term) {
                    if ($default != 'first') {
                        $array['0'] = __('Select Category', 'ramp');
                    }
                    $array[$term->term_id] = esc_html($term->name);
                }

                return $array;
            }
        }
    }
endif;

/**
 * Returns all categories.
 *
 * @since AFTWPL 1.0.0
 */
if (!function_exists('aftwpl_get_terms_link')):
    function aftwpl_get_terms_link($category_id = 0)
    {

        if (absint($category_id) > 0) {
            return get_term_link(absint($category_id), 'category');
        } else {
            return get_post_type_archive_link('post');
        }
    }
endif;


if (!function_exists('aftwpl_woocommerce_template_loop_hooks')) :

    function aftwpl_woocommerce_template_loop_hooks()
    {

        add_action('aftwpl_woocommerce_template_loop_product_link_open', 'woocommerce_template_loop_product_link_open');
        add_action('aftwpl_woocommerce_template_loop_product_link_close', 'woocommerce_template_loop_product_link_close');
        add_action('aftwpl_woocommerce_show_product_loop_sale_flash', 'woocommerce_show_product_loop_sale_flash');
        add_action('aftwpl_woocommerce_template_loop_product_thumbnail', 'woocommerce_template_loop_product_thumbnail');
        add_action('aftwpl_woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title');
        add_action('aftwpl_woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
        add_action('aftwpl_woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price');
        add_action('aftwpl_woocommerce_template_loop_add_to_cart', 'woocommerce_template_loop_add_to_cart');
    }
endif;

add_action('wp_loaded', 'aftwpl_woocommerce_template_loop_hooks');


if (!function_exists('aftwpl_get_block')) :
    /**
     * Retrieve the name of the highest priority template file that exists.
     *
     * Searches in the STYLESHEETPATH before TEMPLATEPATH so that themes which
     * inherit from a parent theme can just overload one file. If the template is
     * not found in either of those, it looks in the theme-compat folder last.
     *
     * @param string|array $template_names Template file(s) to search for, in order.
     * @param bool $load If true the template file will be loaded if it is found.
     * @param bool $require_once Whether to require_once or require. Default true.
     *                            Has no effect if $load is false.
     * @return string The template filename if one is located.
     */
    function aftwpl_get_block($template_name, $load = false, $include_once = true)
    {
        // No file found yet
        $located = false;


        // Continue if template is empty
        if (empty($template_name))
            return;

        // Trim off any slashes from the template name
        $template_name = ltrim($template_name, '/');
        $template_name = $template_name.'.php';

        // Check child theme first
        if (file_exists(trailingslashit(get_stylesheet_directory()) . 'woo-product-showcase/' . $template_name)) {
            $located = trailingslashit(get_stylesheet_directory()) . 'woo-product-showcase/' . $template_name;


            // Check parent theme next
        } elseif (file_exists(trailingslashit(get_template_directory()) . 'woo-product-showcase/' . $template_name)) {
            $located = trailingslashit(get_template_directory()) . 'woo-product-showcase/' . $template_name;


            // Check theme compatibility last
        } elseif (file_exists(trailingslashit(AFTWPL_PLUGIN_DIR) . 'includes/blocks/' . $template_name)) {
            $located = trailingslashit(AFTWPL_PLUGIN_DIR) . 'includes/blocks/' . $template_name;

        }

        if ((true == $load) && !empty($located)){
            if ( $include_once ) {
                include_once  $located;
            } else {
                include $located;
            }
        }

    }

endif;


function aftwpl_get_term_details($product_cat_id){


        $data = array();
        if ($term = get_term_by('id', $product_cat_id, 'product_cat')){
            $data['term_name'] = $term->name;
            $data['term_link'] = get_term_link($term);
            $data['products_count'] = $term->count;
            $data['term_desc'] = term_description($product_cat_id, 'product_cat');
            $meta = get_term_meta($product_cat_id);

            if (isset($meta['thumbnail_id'])) {
                $thumb_id = $meta['thumbnail_id'][0];
                $thumb_url = wp_get_attachment_image_src($thumb_id, 'ramp-medium-square');
                $data['url'] = $thumb_url[0];
            } else {
                $data['url'] = '';
            }
        }

        return $data;

}

add_action('action_aftwpl_get_term_data', 'aftwpl_get_term_details', 10, 1);