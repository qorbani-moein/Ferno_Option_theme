<?php

/*
 * Plugin Name: Option Theme - Eight
 * Description: All Option of Your Site
 * Plugin URI: https://eightco.org
 * Author: eightco.org
 * Version: 0.1
 * Author URI: https://eightco.org
 *
 * 
 */

 
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

// moein add ajax
function ajax_add_to_cart(){
    
    
    global $woocommerce;
    
    $remove_url = $woocommerce->cart->get_remove_url( $cart_item_key );
        echo '<a style="color:yellow;" href="'.$remove_url.'"class="remove-item">Remove-moein-item</a>';
        echo '<a style="color:blue;" href="">Empty</a>';
    foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $cart_item ) {
      if($cart_item['product_id'] == $current_package_id ){
        $remove_url = $woocommerce->cart->get_remove_url( $cart_item_key );
        echo '<a style="color:red" href="'.$remove_url.'class="remove-item">Remove-moein-item</a>';
      } 
    } 
    
}
// add_action('wp_footer','ajax_add_to_cart');
// add_action('wp_head','ajax_add_to_cart');
// add_action('wp-footer','ajax_add_to_cart');

add_shortcode('moein_remove_quantity','remove_quantity');

function remove_quantity(){
    $cart = WC()->instance()->cart;
    $id = '82';
    $cart_id = $cart->generate_cart_id($id);
    // $cart_item_id = $cart->find_product_in_cart($cart_id);
    
    // if($cart_item_id)
       $cart->set_quantity($cart_id,1);
    
    
    
    
    console($id , 'id');
    console($cart_id , 'cart_id');
    // console($cart_item_id , 'cart_item_id');
}





function console($txt , $key = null){
    echo'
        <script>
            console.log("moein - ' .$key . ' - ' . $txt . '");
        </script>
    ';
}




//Enqueue Ajax Scripts
function enqueue_cart_qty_ajax() {

    wp_register_script( 'cart-qty-ajax-js', get_template_directory_uri() . '/js/cart-qty-ajax.js', array( 'jquery' ), '', true );
    wp_localize_script( 'cart-qty-ajax-js', 'cart_qty_ajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    wp_enqueue_script( 'cart-qty-ajax-js' );

}
add_action('wp_enqueue_scripts', 'enqueue_cart_qty_ajax');

function ajax_qty_cart() {

    // Set item key as the hash found in input.qty's name
    $cart_item_key = $_POST['hash'];

    // Get the array of values owned by the product we're updating
    $threeball_product_values = WC()->cart->get_cart_item( $cart_item_key );

    // Get the quantity of the item in the cart
    $threeball_product_quantity = apply_filters( 'woocommerce_stock_amount_cart_item', apply_filters( 'woocommerce_stock_amount', preg_replace( "/[^0-9\.]/", '', filter_var($_POST['quantity'], FILTER_SANITIZE_NUMBER_INT)) ), $cart_item_key );

    // Update cart validation
    $passed_validation  = apply_filters( 'woocommerce_update_cart_validation', true, $cart_item_key, $threeball_product_values, $threeball_product_quantity );

    // Update the quantity of the item in the cart
    if ( $passed_validation ) {
        WC()->cart->set_quantity( $cart_item_key, $threeball_product_quantity, true );
    }

    // Refresh the page
    echo do_shortcode( '[woocommerce_cart]' );

    die();

}

add_action('wp_ajax_qty_cart', 'ajax_qty_cart');
add_action('wp_ajax_nopriv_qty_cart', 'ajax_qty_cart');

