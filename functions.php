<?php

/**
 * Enqueue styles and scripts for the child theme.
 *
 * This function loads the parent theme's stylesheet and enqueues a custom JavaScript file from the child theme.
 */
function easy_store_pro_lion_child_enqueue_styles() {

    wp_enqueue_style(
        'grand-sunrise-parent-style',
        get_parent_theme_file_uri( 'style.css' )
    );

    if(!is_product() && !is_product_category() && !is_tag()) {
        wp_enqueue_style( 'primary', get_stylesheet_directory_uri() . '/assets/css/primary.css' );
    }

    wp_enqueue_script('child-custom-script', get_stylesheet_directory_uri() . '/assets/js/custom-script.js', array('jquery'), null, true);

}
add_action('wp_enqueue_scripts', 'easy_store_pro_lion_child_enqueue_styles');


/**
 * Load the plugin text domain for translations
 */
function easy_store_pro_lion_load_textdomain() {

    load_child_theme_textdomain('easy-store-pro-lion', get_stylesheet_directory() . '/languages');

}
add_action('after_setup_theme', 'easy_store_pro_lion_load_textdomain');


/**
 * Manage the homepage widget sidebar area
 *
 * This function includes the sidebar widget before other main widget areas in the HTML structure
 * on the front page.
 */
if ( ! function_exists( 'easy_store_pro_lion_front_page_side_bar_area' ) ) :
    function easy_store_pro_lion_front_page_side_bar_area() {
        if ( is_front_page() ) {

            echo '<div id="sidebar-shop" class="widget-area sidebar" style="display: block" role="complementary">';
            $default_sidebar = apply_filters( 'easy_store_filter_shop_sidebar_id', 'easy_store_shop_sidebar', 'shop-sidebar' );

            if ( is_active_sidebar( $default_sidebar ) ) {
                dynamic_sidebar( $default_sidebar );
            } else {
                do_action( 'easy_store_action_left_sidebar', $default_sidebar, 'shop-sidebar' );
            }
            echo '</div><!-- #sidebar-shop -->';
        }
    }
endif;
add_action( 'easy_store_before_content', 'easy_store_pro_lion_front_page_side_bar_area', 4 );


// Remove the current hook for the sidebar, if it hasn't been removed already
remove_action( 'woocommerce_sidebar', 'easy_store_woocommerce_get_sidebar', 10 );

// Add a new hook for the sidebar before the list of products
add_action( 'woocommerce_before_main_content', 'easy_store_woocommerce_get_sidebar', 1);

// Add sidebar before the page content
add_action( 'easy_store_before_page_content', 'easy_store_woocommerce_get_sidebar', 1);


/**
 * Displays a warning notice on the WooCommerce checkout page.
 *
 * This notice informs customers about invoice details and the importance of verifying their information.
 */
if ( ! function_exists( 'easy_store_pro_lion_woocommerce_checkout_add_info' ) ) :

    function easy_store_pro_lion_woocommerce_checkout_add_info(){
        echo '
            <div class="es-lion-notice es-lion-notice-warning es-lion-is-dismissible">
                <p>' . __('If you need an invoice addressed differently from the delivery address, please fill in the <i style="text-transform: capitalize">billing address</i> fields and then separately fill the <i style="text-transform: capitalize">shipping address</i> fields.', 'easy-store-pro-lion') . '</p>
                <p>' . __('Please double-check all the information, as invoices cannot be changed to a different name.', 'easy-store-pro-lion') . '</p>
            </div>
        ';


   }

endif;
add_action('woocommerce_checkout_before_customer_details', 'easy_store_pro_lion_woocommerce_checkout_add_info', 5);


/**
 * Disable image zoom on WooCommerce product pages
 *
 */
function easy_store_pro_lion_disable_woocommerce_image_zoom() {
    remove_theme_support( 'wc-product-gallery-zoom' );
}
add_action( 'after_setup_theme', 'easy_store_pro_lion_disable_woocommerce_image_zoom', 100 );


/**
 * Adds custom inline CSS styles for WooCommerce products on small screens.
 *
 */
function  easy_store_pro_lion_add_inline_styles() {
    echo '<style>
        @media screen and (max-width: 480px) {
            .woocommerce ul.products li.product, 
            .woocommerce-page ul.products li.product {
                float: left !important;
                width: 47% !important;
            }
            .woocommerce ul.products[class*=columns-] li.product:nth-child(2n),
            .woocommerce-page ul.products[class*=columns-] li.product:nth-child(2n){
                float: right !important;
            }
        }
    </style>';
}
add_action('wp_head', 'easy_store_pro_lion_add_inline_styles');

