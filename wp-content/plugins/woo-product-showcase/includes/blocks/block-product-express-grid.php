<div class="aftwpl-product-list row">
    <?php
    if (0 != absint($category)):
        //do_action('action_aftwpl_get_term_data', $category );

        if ($term = get_term_by('id', $category, 'product_cat')):
            $term_name = $term->name;
            $term_link = get_term_link($term);
            $products_count = $term->count;
            $term_desc = term_description($category, 'product_cat');
            $meta = get_term_meta($category);

            if (isset($meta['thumbnail_id'])) {
                $thumb_id = $meta['thumbnail_id'][0];
                $thumb_url = wp_get_attachment_image_src($thumb_id, 'ramp-medium-square');
                $url = $thumb_url[0];
            } else {
                $url = '';
            } ?>

            <div class="aftwpl-product-catgory col-sm-6">
                <div class="product-wrap-pl">

                <?php if(!empty($url)): ?>
                    <div class="aftwpl-category-image">
                        <img src="<?php echo esc_url($url); ?>" alt="">
                    </div>
                <?php endif; ?>
                <div class="aftwpl-category-desc">
                    <h2 class="aftwpl-category-title">
                        <a href="<?php echo esc_url($term_link); ?>">
                            <?php echo esc_html($term_name); ?>
                            <?php echo '(' . $products_count . ')'; ?>
                        </a>
                    </h2>
                    <div class="aftwpl-item-metadata">
                        <?php echo $term_desc; ?>
                    </div>
                </div>
            </div>
            </div>
        <?php
        endif;
    endif;

    if (absint( $number_of_products ) > 0):

        $products = aftwpl_get_products($number_of_products, $category, $show, $orderby, $order);

        ?>


        <?php echo wp_kses_post(apply_filters('woocommerce_before_widget_product_list', '<ul class="aftwpl_product_express_grid_widget woocommerce">'));


        while ($products->have_posts()):
            $products->the_post();
            ?>
            <li <?php post_class('col-sm-3'); ?>>
                <div class="product-wrap-pl"  data-mh="aftwpl-product-express-grid">
                            <span class="aftwpl-product-list-left">
                            <span class="aftwpl-product-list-thumb">
                                <?php aftwpl_get_block('product-thumb', true, false); ?>

                            </span>
                            </span>
                <span class="aftwpl-product-list-right">
                            <span class="aftwpl-product-list-desc">
                                <?php aftwpl_get_block('product-add-to-cart', true, false); ?>


                        </span>
                        </span>
                </div>        
            </li>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>

        <?php echo wp_kses_post(apply_filters('woocommerce_after_widget_product_list', '</ul>')); ?>


    <?php endif; ?>
</div>