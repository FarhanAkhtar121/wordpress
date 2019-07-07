<?php

function aftwpl_get_products($number_of_products, $category, $show, $orderby, $order ){


    $product_visibility_term_ids = wc_get_product_visibility_term_ids();

    $query_args = array(
        'posts_per_page' => $number_of_products,
        'post_status'    => 'publish',
        'post_type'      => 'product',
        'no_found_rows'  => 1,
        'order'          => $order,
        'meta_query'     => array(),
        'tax_query'      => array(
            'relation' => 'AND',
        ),
    );

    if ( absint($category) > 0 ) {
        $query_args['tax_query'][] = array(
            'taxonomy' => 'product_cat',
            'field'    => 'term_taxonomy_id',
            'terms'    => $category

        );

    }



    switch ( $show ) {
        case 'featured' :
            $query_args['tax_query'][] = array(
                'taxonomy' => 'product_visibility',
                'field'    => 'term_taxonomy_id',
                'terms'    => $product_visibility_term_ids['featured'],
            );
            break;
        case 'onsale' :
            $product_ids_on_sale    = wc_get_product_ids_on_sale();
            $product_ids_on_sale[]  = 0;
            $query_args['post__in'] = $product_ids_on_sale;
            break;
    }

    switch ( $orderby ) {
        case 'price' :
            $query_args['meta_key'] = '_price';
            $query_args['orderby']  = 'meta_value_num';
            break;
        case 'rand' :
            $query_args['orderby']  = 'rand';
            break;
        case 'sales' :
            $query_args['meta_key'] = 'total_sales';
            $query_args['orderby']  = 'meta_value_num';
            break;
        default :
            $query_args['orderby']  = 'date';
    }

    return new WP_Query( apply_filters( 'aftwpl_widget_query_args', $query_args ) );
}


/**
 * Returns all categories.
 *
 * @since RAMP 1.0.0
 */
if (!function_exists('aftwpl_get_terms')):
    function aftwpl_get_terms( $category_id = 0, $taxonomy='category', $default='' ){
        $taxonomy = !empty($taxonomy) ? $taxonomy : 'category';

        if ( $category_id > 0 ) {
            $term = get_term_by('id', absint($category_id), $taxonomy );
            if($term)
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
                    if( $default != 'first' ){
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
 * @since RAMP 1.0.0
 */
if (!function_exists('aftwpl_get_terms_link')):
    function aftwpl_get_terms_link( $category_id = 0 ){

        if (absint($category_id) > 0) {
            return get_term_link(absint($category_id), 'category');
        } else {
            return get_post_type_archive_link('post');
        }
    }
endif;


add_action('wp_loaded', 'aftwpl_woocommerce_template_loop_hooks');
function aftwpl_woocommerce_template_loop_hooks(){

    add_action('aftwpl_woocommerce_template_loop_product_link_open', 'woocommerce_template_loop_product_link_open');
    add_action('aftwpl_woocommerce_template_loop_product_link_close', 'woocommerce_template_loop_product_link_close');
    add_action('aftwpl_woocommerce_show_product_loop_sale_flash', 'woocommerce_show_product_loop_sale_flash');
    add_action('aftwpl_woocommerce_template_loop_product_thumbnail', 'woocommerce_template_loop_product_thumbnail');
    add_action('aftwpl_woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title');
    add_action('aftwpl_woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
    add_action('aftwpl_woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price');
    add_action('aftwpl_woocommerce_template_loop_add_to_cart', 'woocommerce_template_loop_add_to_cart');
}
