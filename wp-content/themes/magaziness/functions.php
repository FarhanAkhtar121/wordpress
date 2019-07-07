<?php
/*This file is part of magaziness child theme.

All functions of this file will be loaded before of parent theme functions.
Learn more at https://codex.wordpress.org/Child_Themes.

Note: this function loads the parent stylesheet before, then child theme stylesheet
(leave it in place unless you know what you are doing.)
*/

function magaziness_enqueue_child_styles() {
    $min = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
    $parent_style = 'magazine-7-style';

    $fonts_url = 'https://fonts.googleapis.com/css?family=Bitter:400,400italic,700';
    wp_enqueue_style('magaziness-google-fonts', $fonts_url, array(), null);
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/bootstrap/css/bootstrap' . $min . '.css');
    wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style(
        'magaziness',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'bootstrap', $parent_style ),
        wp_get_theme()->get('Version') );


}
add_action( 'wp_enqueue_scripts', 'magaziness_enqueue_child_styles' );


/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function magaziness_customize_register($wp_customize) {    

     $wp_customize->get_setting( 'archive_layout' )->default = 'archive-layout-full';

}
add_action('customize_register', 'magaziness_customize_register', 99999);

/*Add the demo file*/
function magaziness_add_demo_files($demos) {
    $demos[] = array(
        'import_file_name'             => esc_html__( 'Child - Magaziness', 'magaziness' ),
        'local_import_file'            => trailingslashit( get_stylesheet_directory() ) . 'demo-content/magaziness/magazine-7.xml',
        'local_import_widget_file'     => trailingslashit( get_stylesheet_directory() ) . 'demo-content/magaziness/magazine-7.wie',
        'local_import_customizer_file' => trailingslashit( get_stylesheet_directory() ) . 'demo-content/magaziness/magazine-7.dat',
        'import_preview_image_url'     => trailingslashit( get_stylesheet_directory_uri() ) . 'demo-content/assets/magazine-7-magaziness.jpg',
        'preview_url'                  => 'https://demo.afthemes.com/magazine-7/magaziness',
    );
    return $demos;
}
add_filter( 'aft_demo_import_files', 'magaziness_add_demo_files');

function magaziness_override_banner_advertisment_function(){
    remove_action('magazine_7_action_banner_advertisement', 'magazine_7_banner_advertisement', 10 );
}
add_action('wp_loaded', 'magaziness_override_banner_advertisment_function');

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function magaziness_widgets_init()
{
    
    register_sidebar(array(
        'name'          => esc_html__('Frontpage Banner Ad Section', 'magaziness'),
        'id'            => 'home-advertisement-widgets',
        'description'   => esc_html__('Add widgets for frontpage banner section advertisement.', 'magaziness'),
        'before_widget' => '<div id="%1$s" class="widget magazine-7-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title widget-title-1"><span>',
        'after_title' => '</span></h2>',
    ));

   


}

add_action('widgets_init', 'magaziness_widgets_init');

    /**
     * Advertisement Banner
     *
     * @since Magazine 7 1.0.0
     *
     */
    function magaziness_banner_advertisement()
    {

        if (('' != magazine_7_get_option('banner_advertisement_section')) ) { ?>
            <div class="banner-promotions-wrapper">
                <?php if (('' != magazine_7_get_option('banner_advertisement_section'))):

                    $magazine_7_banner_advertisement = magazine_7_get_option('banner_advertisement_section');
                    $magazine_7_banner_advertisement = absint($magazine_7_banner_advertisement);
                    $magazine_7_banner_advertisement = wp_get_attachment_image($magazine_7_banner_advertisement, 'full');
                    $magazine_7_banner_advertisement_url = magazine_7_get_option('banner_advertisement_section_url');
                    $magazine_7_banner_advertisement_url = isset($magazine_7_banner_advertisement_url) ? esc_url($magazine_7_banner_advertisement_url) : '#';
                    $magazine_7_open_on_new_tab = magazine_7_get_option('banner_advertisement_open_on_new_tab');
                    $magazine_7_open_on_new_tab = ('' != $magazine_7_open_on_new_tab) ? '_blank' : '';

                    ?>
                    <div class="container">
                        <a href="<?php echo esc_url($magazine_7_banner_advertisement_url); ?>" target="<?php echo esc_attr($magazine_7_open_on_new_tab); ?>">
                            <?php echo $magazine_7_banner_advertisement; ?>
                        </a>
                    </div>
                <?php endif; ?>
                

            </div>
            <!-- Trending line END -->
            <?php
        }

        if (is_active_sidebar('home-advertisement-widgets')): ?>
                    
                    <div class="container">
                        <?php dynamic_sidebar('home-advertisement-widgets'); ?>
                    </div>
                   

                <?php endif;
    }


add_action('magazine_7_action_banner_advertisement', 'magaziness_banner_advertisement', 10);

