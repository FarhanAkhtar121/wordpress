<?php
if (absint($number_of_products) > 0):
    $products = aftwpl_get_products($number_of_products, $category, $show, $orderby, $order);

    ?>
    <div class="aftwpl-product-list row">
        <?php echo wp_kses_post(apply_filters('woocommerce_before_widget_product_list', '<ul class="aftwpl_product_list_widget woocommerce">'));


        while ($products->have_posts()):
            $products->the_post();

            ?>
            <li <?php post_class('col-sm-6'); ?> >
                <div class="product-wrap-pl clearfix" data-mh="aftwpl-product-list">
                            <span class="aftwpl-product-list-left col-sm-4 col-xs-4">
                                <span class="aftwpl-product-list-thumb">


                                <?php aftwpl_get_block('product-thumb', true, false); ?>

                            </span>
                            </span>
                <span class="aftwpl-product-list-right col-sm-8 col-xs-8">
                            <span class="aftwpl-product-list-desc">
                                <?php aftwpl_get_block('product-add-to-cart', true, false); ?>


                        </span>
                        </span>
                </div>        
            </li>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>

        <?php echo wp_kses_post(apply_filters('woocommerce_after_widget_product_list', '</ul>')); ?>
    </div>
<?php endif; ?>