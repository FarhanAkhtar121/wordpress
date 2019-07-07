<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}


/**
 * Woo Product Showcase
 *
 * Allows user to get Woo Product Showcase.
 *
 * @class   AFTWPL_Woo_Product_Showcase_Backend
 */
class AFTWPL_Woo_Product_Showcase_Backend
{

    /**
     * Init and hook in the integration.
     *
     * @return void
     */


    public function __construct()
    {
        $this->id = 'AFTWPL_Woo_Product_Showcase_Backend';
        $this->method_title = __('Woo Product Showcase Backend', 'woo-product-showcase');
        $this->method_description = __('Woo Product Showcase Backend', 'woo-product-showcase');

        include_once 'widgets/widgets-init.php';



        add_action('admin_menu', array($this, 'aftwpl_register_settings_menu_page'));
        add_action('admin_init', array($this, 'aftwpl_display_options'));




    }

    /**
     * Register a aftwpl settings page
     */
    public function aftwpl_register_settings_menu_page()
    {
        add_menu_page(
            __('Woo Product Showcase', 'woo-product-showcase'),
            'Woo Product Showcase',
            'manage_options',
            'woo-product-showcase',
            array($this, 'aftwpl_settings_menu_page_callback'),
            'dashicons-feedback',
            56

        );
    }

    /**
     * Display a aftwpl settings page
     */
    public function aftwpl_settings_menu_page_callback()
    {

        // Set class property
        $options = get_option('aftwpl_setting_options');
        if (!empty($options)) {
            $this->options = $options;
        }

        ?>
        <div class="wrap">

            <h1><?php _e("Woo Product Showcase", 'woo-product-showcase'); ?></h1>

            <?php
            //we check if the page is visited by click on the tabs or on the menu button.
            //then we get the active tab.
            $active_tab = "aftwpl-global-settings";
            if (isset($_GET["tab"])) {
                if ($_GET["tab"] == "aftwpl-custom-css") {
                    $active_tab = "aftwpl-custom-css";
                }else {
                    $active_tab = "aftwpl-global-settings";
                }
            }
            ?>

            <!-- wordpress provides the styling for tabs. -->
            <h2 class="nav-tab-wrapper">
                <!-- when tab buttons are clicked we jump back to the same page but with a new parameter that represents the clicked tab. accordingly we make it active -->

                <a href="?page=woo-product-showcase&tab=aftwpl-global-settings"
                   class="nav-tab <?php if ($active_tab == 'aftwpl-global-settings') {
                       echo 'nav-tab-active';
                   } ?> ">
                    <?php _e('Global Settings', 'woo-product-showcase'); ?>
                </a>
                <a href="?page=woo-product-showcase&tab=aftwpl-custom-css"
                   class="nav-tab <?php if ($active_tab == 'aftwpl-custom-css') {
                       echo 'nav-tab-active';
                   } ?>">
                    <?php _e('Custom Styling', 'woo-product-showcase'); ?>
                </a>
            </h2>

            <form method="post" action="options.php">
                <?php
                if ($active_tab == 'aftwpl-global-settings') {
                    settings_fields("aftwpl_setting_group");
                    do_settings_sections("aftwpl-global-settings-section");
                    submit_button();
                }elseif ($active_tab == 'aftwpl-custom-css') {
                    settings_fields("aftwpl_setting_group");
                    do_settings_sections("aftwpl-custom-css-section");
                    submit_button();
                } else {
                    settings_fields("aftwpl_setting_group");
                    do_settings_sections("aftwpl-global-settings-section");
                }

                ?>
            </form>
        </div>
        <?php
    }

    public function aftwpl_display_options()
    {


        //here we display the sections and options in the settings page based on the active tab
        register_setting(
            "aftwpl_setting_group",
            "aftwpl_setting_options",
            array($this, 'aftwpl_sanitize')
        );
        if (isset($_GET["tab"])) {

            if ($_GET["tab"] == "aftwpl-custom-css") {

                add_settings_section(
                    "aftwpl_custom_css_section_id",
                    __("Custom styling", 'woo-product-showcase'),
                    array($this, "aftwpl_custom_css_section_info"),
                    "aftwpl-custom-css-section"
                );
                add_settings_field(
                    "aftwpl_custom_css_id",
                    __("Custom css box", 'woo-product-showcase'),
                    array($this,
                        "aftwpl_display_custom_css_options"),
                    "aftwpl-custom-css-section",
                    "aftwpl_custom_css_section_id"
                );
            } else {
                add_settings_section(
                    "aftwpl_global_settings_section_id",
                    __("Woo Product Showcase global settings", 'woo-product-showcase'),
                    array(),
                    "aftwpl-global-settings-section"
                );


                add_settings_field(
                    "aftwpl_appearance_id",
                    __("Appearance", 'woo-product-showcase'),
                    array($this,
                        "aftwpl_appearance_options"),
                    "aftwpl-global-settings-section",
                    "aftwpl_global_settings_section_id"
                );



            }
        } else {

              add_settings_section(
                    "aftwpl_global_settings_section_id",
                    __("Woo Product Showcase global settings", 'woo-product-showcase'),
                    array(),
                    "aftwpl-global-settings-section"
                );

              add_settings_field(
                    "aftwpl_appearance_id",
                    __("Appearance", 'woo-product-showcase'),
                    array($this,
                    "aftwpl_appearance_options"),
                    "aftwpl-global-settings-section",
                    "aftwpl_global_settings_section_id"
                );




        }

    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function aftwpl_sanitize($input)
    {
        $new_input = array();


        //global settings
        if (isset($input['aftwpl_global_button_color'])) {
            $new_input['aftwpl_global_button_color'] = sanitize_text_field($input['aftwpl_global_button_color']);
        }

        if (isset($input['aftwpl_global_button_text_color'])) {
            $new_input['aftwpl_global_button_text_color'] = sanitize_text_field($input['aftwpl_global_button_text_color']);
        }

        if (isset($input['aftwpl_global_button_hover_color'])) {
            $new_input['aftwpl_global_button_hover_color'] = sanitize_text_field($input['aftwpl_global_button_hover_color']);
        }

        if (isset($input['aftwpl_global_button_hover_text_color'])) {
            $new_input['aftwpl_global_button_hover_text_color'] = sanitize_text_field($input['aftwpl_global_button_hover_text_color']);
        }

        if (isset($input['aftwpl_global_sale_color'])) {
            $new_input['aftwpl_global_sale_color'] = sanitize_text_field($input['aftwpl_global_sale_color']);
        }

        if (isset($input['aftwpl_global_sale_text_color'])) {
            $new_input['aftwpl_global_sale_text_color'] = sanitize_text_field($input['aftwpl_global_sale_text_color']);
        }


        //custom css

        if (isset($input['aftwpl_custom_css'])) {
            $new_input['aftwpl_custom_css'] = wp_strip_all_tags($input['aftwpl_custom_css']);
        }


        return $new_input;
    }

    public function aftwpl_global_settings_section_info()
    {
        ?>
        <p class="aftwpl-global-settings-desc">
            <?php _e('Please set global settings for Woo Product Showcase widget and', 'woo-product-showcase'); ?>
            <?php
            $output = "";
            $output .= htmlspecialchars("<?php echo do_shortcodes('");
            $output .= "<span class='aftwpl-shortcodes-only' style='color: #0073aa;' >";
            $output .= '[woo-product-showcase]';
            $output .= "</span>";
            $output .= htmlspecialchars("'); ?>");
            echo $output;
            ?>
            <?php _e('shortcode.', 'woo-product-showcase'); ?>
        </p>
        <?php
    }

    public function aftwpl_appearance_options(){

        $button_color = isset($this->options['aftwpl_global_button_color']) ? $this->options['aftwpl_global_button_color'] : '#e8e8e8';
        $button_text_color = isset($this->options['aftwpl_global_button_text_color']) ? $this->options['aftwpl_global_button_text_color'] : '#7d7d7d';
        $button_hover_color = isset($this->options['aftwpl_global_button_hover_color']) ? $this->options['aftwpl_global_button_hover_color'] : '#3e3e3e';
        $button_hover_text_color = isset($this->options['aftwpl_global_button_hover_text_color']) ? $this->options['aftwpl_global_button_hover_text_color'] : '#ffffff';
        $sale_color = isset($this->options['aftwpl_global_sale_color']) ? $this->options['aftwpl_global_sale_color'] : '#e43f0b';
        $sale_text_color = isset($this->options['aftwpl_global_sale_text_color']) ? $this->options['aftwpl_global_sale_text_color'] : '#ffffff';



        ?>
        <p class="aftwpl-section-desc">
            <?php _e('Please set appearance for the Woo Product Showcase.', 'woo-product-showcase'); ?>
        </p>
        <table class="aftwpl-table aftwpl-appearance-table">
            <tr>
                <td><label for ="aftwpl_global_title" ><?php _e('Button Background Color', 'woo-product-showcase'); ?></label></td>
                <td><input type="color" name="aftwpl_setting_options[aftwpl_global_button_color]" value="<?php echo $button_color;  ?>"></td>
            </tr>
            <tr>
                <td><label for ="aftwpl_global_title" ><?php _e('Button Texts Color', 'woo-product-showcase'); ?></label></td>
                <td><input type="color" name="aftwpl_setting_options[aftwpl_global_button_text_color]" value="<?php echo $button_text_color;  ?>"></td>
            </tr>
            <tr>
                <td><label for ="aftwpl_global_title" ><?php _e('Button Hover Color', 'woo-product-showcase'); ?></label></td>
                <td><input type="color" name="aftwpl_setting_options[aftwpl_global_button_hover_color]" value="<?php echo $button_hover_color;  ?>"></td>
            </tr>
            <tr>
                <td><label for ="aftwpl_global_title" ><?php _e('Button Hover Texts Color', 'woo-product-showcase'); ?></label></td>
                <td><input type="color" name="aftwpl_setting_options[aftwpl_global_button_hover_text_color]" value="<?php echo $button_hover_text_color;  ?>"></td>
            </tr>
            <tr>
                <td><label for ="aftwpl_global_title" ><?php _e('Sale Backgound Color', 'woo-product-showcase'); ?></label></td>
                <td><input type="color" name="aftwpl_setting_options[aftwpl_global_sale_color]" value="<?php echo $sale_color;  ?>"></td>
            </tr>
            <tr>
                <td><label for ="aftwpl_global_title" ><?php _e('Sale Text Color', 'woo-product-showcase'); ?></label></td>
                <td><input type="color" name="aftwpl_setting_options[aftwpl_global_sale_text_color]" value="<?php echo $sale_text_color;  ?>"></td>
            </tr>

        </table>

        <?php
    }

    public function aftwpl_visibility_options()
    {  ?>

        <p class="aftwpl-section-desc">
            <?php _e('By default, output from the Woo Product Showcase will be visible for your front page, posts and single author page.', 'woo-product-showcase'); ?>
        </p>


        <?php

            $args = array(
                'public'   => true,
                '_builtin' => false,
            );
            $output = 'objects'; // names or objects, note names is the default
            $operator = 'and'; // 'and' or 'or'
            $post_types = get_post_types( $args, $output, $operator );

            if(isset($post_types) && !empty($post_types)):

        ?>

        <strong class="aftwpl-section-desc">
            <?php _e('If you need to show it from any other available post type, please check.', 'woo-product-showcase'); ?>
        </strong>
        <ul class="aftwpl-list">

            <?php
                foreach ( $post_types  as $post_type ):

                    $checked = '';
                    if ( isset($this->options['aftwpl_also_visibile_in_'.$post_type->name]) ) {
                        $checked = 'checked';
                    }
                    ?>
                    <li>
                        <input type="checkbox" name="aftwpl_setting_options[aftwpl_also_visibile_in_<?php echo $post_type->name; ?>]" value="<?php echo $post_type->name; ?>" <?php echo $checked; ?>><?php echo 'Also show on '. $post_type->labels->menu_name; ?>
                    </li>
                <?php endforeach; ?>
        </ul>
            <?php endif; ?>


    <?php }


    public function aftwpl_hide_from_post_content_options()
    {
        $checked = '';
        if (isset($this->options['hide_from_post_content'])) {
            $checked = 'checked';
        }

        ?>
        <input type="checkbox" name="aftwpl_setting_options[hide_from_post_content]"
               value="<?php echo 'hide'; ?>" <?php echo $checked; ?>><?php _e('Remove', 'woo-product-showcase'); ?>
        <p class="aftwpl-section-desc">
            <?php _e('When turned ON, the output from the Woo Product Showcase will no longer be automatically added to your post content. You\'ll need to manually add it using widgets, shortcodes or a PHP function.', 'woo-product-showcase'); ?>
        </p>
    <?php }


    public function aftwpl_custom_css_section_info()
    {
        ?>
        <p class="aftwpl-section-desc">
            <?php _e('Please paste appropriate css code snippets to the given area.', 'woo-product-showcase'); ?>
        </p>
        <?php
    }

    public function aftwpl_display_custom_css_options()
    {

        $custom_css = '';
        if (isset($this->options['aftwpl_custom_css'])) {
            $custom_css = ($this->options['aftwpl_custom_css']);
        }

        ?>
        <textarea id="aftwpl_custom_css" name="aftwpl_setting_options[aftwpl_custom_css]" rows="20"
                  cols="60"><?php echo $custom_css; ?></textarea>
        <?php
    }



}

$aftwpl_backend = new AFTWPL_Woo_Product_Showcase_Backend();