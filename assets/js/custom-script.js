
/**
 * This script binds a click event to the widget title of product categories.
 * When the window width is 768 pixels or less, clicking on the widget title will toggle
 * the visibility of the product categories list.
 *
 * The click event is only active for window widths of 768 pixels or less.
 * When the window is resized, the click event is re-bound to ensure it behaves correctly.
 */
jQuery(document).ready(function($){

    function bindClickEvent() {
        if ($(window).width() <= 768) {
            $('.widget_product_categories .widget-title').off('click').on('click', function() {
                $('.widget_product_categories ul').slideToggle();
            });
        } else {
            $('.widget_product_categories .widget-title').off('click');
            $('.widget_product_categories ul').removeAttr( 'style' );
        }
    }

    bindClickEvent();

    $(window).resize(function() {
        bindClickEvent();
    });

});