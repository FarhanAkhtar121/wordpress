<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}


// [bartag foo="foo-value"]
function woo_product_showcase_shortcodes($atts)
{
    $aftwpl = shortcode_atts(array(
        'title' => '',
        'mode' => 'grid',
        'number_of_products' => 6,
        'product_cat' => 0,
        'show' => '',
        'orderby' => 'date',
        'order' => 'desc',
    ), $atts);

    $title = isset($aftwpl['title']) ? esc_html($aftwpl['title']) : '';
    $mode = !empty($aftwpl['mode']) ? esc_attr($aftwpl['mode']) : 'grid';
    $number_of_products = !empty($aftwpl['number_of_products']) ? absint($aftwpl['number_of_products']) : 6;
    $category = !empty($aftwpl['product_cat']) ? absint($aftwpl['product_cat']) : 0;
    $show = !empty($aftwpl['show']) ? esc_attr($aftwpl['show']) : '';
    $orderby = !empty($aftwpl['orderby']) ? esc_attr($aftwpl['orderby']) : 'date';
    $order = !empty($aftwpl['order']) ? esc_attr($aftwpl['order']) : 'desc';

    ob_start();
    ?>
    <div class="aftwpl-product-showcase-shortcode">
        <?php if (!empty($title)): ?>
            <h2 class="widget-title aftwpl-section-title">
                <span><?php echo $title; ?></span>
            </h2>
        <?php endif; ?>
        <?php if ($mode == 'list'): ?>
            <?php include AFTWPL_PLUGIN_DIR . '/includes/blocks/block-product-list.php'; ?>
        <?php elseif ($mode == 'express-grid'): ?>
            <?php include AFTWPL_PLUGIN_DIR . '/includes/blocks/block-product-express-grid.php'; ?>
        <?php else: ?>
            <?php include AFTWPL_PLUGIN_DIR . '/includes/blocks/block-product-grid.php'; ?>
        <?php endif; ?>

    </div>
    <?php
    return ob_get_clean();
}

add_shortcode('woo-product-showcase', 'woo_product_showcase_shortcodes');