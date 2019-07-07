<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function aftwpl_custom_style()
{
    $options = get_option('aftwpl_setting_options');
    $button_color = isset($options['aftwpl_global_button_color']) ? $options['aftwpl_global_button_color'] : '#e8e8e8';
    $button_text_color = isset($options['aftwpl_global_button_text_color']) ? $options['aftwpl_global_button_text_color'] : '#7d7d7d';
    $button_hover_color = isset($options['aftwpl_global_button_hover_color']) ? $options['aftwpl_global_button_hover_color'] : '#3e3e3e';
    $button_hover_text_color = isset($options['aftwpl_global_button_hover_text_color']) ? $options['aftwpl_global_button_hover_text_color'] : '#ffffff';
    $sale_color = isset($options['aftwpl_global_sale_color']) ? $options['aftwpl_global_sale_color'] : '#e43f0b';
    $sale_text_color = isset($options['aftwpl_global_sale_text_color']) ? $options['aftwpl_global_sale_text_color'] : '#ffffff';

    ob_start();
    ?>

    .aftwpl-product-list li .aftwpl-product-list-thumb span.onsale {
    background-color: <?php echo $sale_color; ?>;
    color: <?php echo $sale_text_color; ?>;
    }

    .woocommerce .aftwpl-product-list-add-to-cart a.button{
    background: <?php echo $button_color; ?>;
    color: <?php echo $button_text_color; ?>;
    }

    .woocommerce .aftwpl-product-list-add-to-cart a.button:hover{
    background-color: <?php echo $button_hover_color; ?>;
    color: <?php echo $button_hover_text_color; ?>;
    }

    <?php


    $custom_css = isset($options['aftwpl_custom_css']) ? ($options['aftwpl_custom_css']) : '';
    if (!empty($custom_css)):
        ?>

        <?php echo wp_strip_all_tags($custom_css); ?>


    <?php
    endif;
    return ob_get_clean();
}