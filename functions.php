<?php

function easystore_pro_child_enqueue_styles() {

    wp_enqueue_style(
        'grand-sunrise-parent-style',
        get_parent_theme_file_uri( 'style.css' )
    );

    wp_enqueue_script('child-custom-script', get_stylesheet_directory_uri() . '/assets/js/custom-script.js', array('jquery'), null, true);

}

add_action('wp_enqueue_scripts', 'easystore_pro_child_enqueue_styles');


/**
 * Manage the homepage widget sidebar area
 *
 * This function includes the sidebar widget before other main widget areas in the HTML structure
 * on the front page.
 */
if ( ! function_exists( 'easy_store_front_page_side_bar_area' ) ) :
    function easy_store_front_page_side_bar_area() {
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

add_action( 'easy_store_before_content', 'easy_store_front_page_side_bar_area', 4 );



// Remove the current hook for the sidebar, if it hasn't been removed already
remove_action( 'woocommerce_sidebar', 'easy_store_woocommerce_get_sidebar', 10 );

// Add a new hook for the sidebar before the list of products
add_action( 'woocommerce_before_main_content', 'easy_store_woocommerce_get_sidebar', 1);


/**
 * Displays a warning notice on the WooCommerce checkout page.
 *
 * This notice informs customers about invoice details and the importance of verifying their information.
 */
if ( ! function_exists( 'easy_store_woocommerce_checkout_add_info' ) ) :

    function easy_store_woocommerce_checkout_add_info(){
        if($_SERVER['SERVER_NAME'] == 'diabetyk1.pl') {
            //PL
            echo '
             
            <div class="notice notice-warning is-dismissible">
                <p>Jeśli potrzebujesz faktury na adres inny niż adres dostawy, proszę wypełnić pola <i style="text-transform: capitalize">adres rozliczeniowy</i>, a następnie osobno wypełnić pola <i style="text-transform: capitalize">adres dostawy</i></p>
                <p>Proszę dokładnie sprawdzić wszystkie dane, ponieważ faktur nie będzie można zmienić na inne nazwisko.</p>
            </div>         
        
           ';
        }elseif ($_SERVER['SERVER_NAME'] == 'sensor.loc'){
            //TEST
            echo '
             
            <div class="notice notice-warning is-dismissible">
                <p>If you need an invoice addressed differently from the delivery address, please fill in the <i style="text-transform: capitalize">billing address</i> fields and then separately fill the <i style="text-transform: capitalize">shipping address</i> fields.</p>
                <p>Please double-check all the information, as invoices cannot be changed to a different name.</p>
            </div>         
        
           ';
        }elseif ($_SERVER['SERVER_NAME'] == 'diabet1.ro'){

            echo '
             
            <div class="notice notice-warning is-dismissible">
                <p>Dacă aveți nevoie de o factură pe o adresă diferită de adresa de livrare, vă rugăm să completați câmpurile <i style="text-transform: capitalize">adresă de facturare</i> și apoi să completați separat câmpurile <i style="text-transform: capitalize">adresă de livrare</i>.</p>
                <p>Vă rugăm să verificați cu atenție toate datele, deoarece facturile nu pot fi modificate pe un alt nume.</p>
            </div>         
        
           ';

        }
   }

endif;

add_action('woocommerce_checkout_before_customer_details', 'easy_store_woocommerce_checkout_add_info', 5);


/**
 * Disable image zoom on WooCommerce product pages
 *
 */
function disable_woocommerce_image_zoom() {
    remove_theme_support( 'wc-product-gallery-zoom' );
}
add_action( 'after_setup_theme', 'disable_woocommerce_image_zoom', 100 );


