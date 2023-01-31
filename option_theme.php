<?php

/**
 * Plugin Name: Option Theme - Eight
 * Plugin URI:  https://eightco.org
 * Description: All Option of Your Site
 * Version:     0.1
 * Author:      eightco
 * Author URI:  https://eightco.org
 * Text Domain: woo-ajax-add-to-cart
 * License: GPLv3
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}


add_shortcode('moein_remove_quantity','remove_quantity');

function remove_quantity(){
    $cart = WC()->instance()->cart;
    $id = '82';
    $cart_id = $cart->generate_cart_id($id);
    $cart_item_id = $cart->find_product_in_cart($cart_id);
    
    if($cart_item_id)
       $cart->set_quantity($cart_item_id,1);
    
    
    
    
    console($id , 'id');
    console($cart_id , 'cart_id');
    console($cart_item_id , 'cart_item_id');
}



add_action( 'wp_footer', 'script_query_page' );

function script_query_page(){
    $current_page = $_SERVER['SCRIPT_URI'];
    $page_cart = 'https://' . $_SERVER['SERVER_NAME'] . '/cart/' ;
    // $page_shop_en = 'https://' . $_SERVER['SERVER_NAME'] . '/en/shop/' ;
    
        // console("current_page: " . $current_page); 
        // console("page_shop_en: " . substr($current_page,0,strlen($page_shop_en)));
        // console('page_shop_fa: ' . $page_shop_fa);
    
    if ($current_page == $page_cart){
        // console("single_product true");
        script_page_cart();
    } //elseif($current_page == substr($current_page,0,strlen($page_shop_en))){
    //     script_page_shop_EnToFa();
    // }
}

function script_page_cart(){
    echo '
    <style>
        .quantity_cart{
            width: 25%;
            color: #FFD15E;
            position: absolute;
            background: #2c2c2c;
            left: 0px;
            top: 35px;
            display: flex;
            flex-wrap: nowrap;
            align-content: stretch;
            justify-content: space-evenly;
            align-items: center;
            border: 1px solid #FFD15E;
            border-radius: 50px;
            margin-left: 20px;
            height: 40px;
            font-size: 20px;
            padding: 0px 3px 5px 3px;
        }
        .quantity_cart span{
            color: #FFD15E !important;
        }
        .quantity_cart input{
            width: 50% !important;
            color: white;
            background: #2c2c2c;
            padding: 0px;
            text-align:center;
            border-color: #0000;
            padding: 2px 0px 0px 3px;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
    <script>
        addEventListener("load", (event) => {
            var len_num_product = document.getElementsByClassName("input-text").length;
            var quantity_product = `
            <div class="quantity_cart">
                <span class="quantity_cart_plus" id="quantity_cart_plus_nth">+</span>
                <input class="number_quantity_cart" id="quantity_cart_nth" type="number" name="cart_quantity" min="1" max="10" />
                <span class="quantity_cart_minus" id="quantity_cart_minus_nth">-</span>
            </div>
            `;
            var tag_input = document.querySelectorAll("input[type=number]");
            console.log(tag_input.length);
            console.log(tag_input);
            for(var i = 0 ; i < len_num_product ; i++){
                document.getElementsByClassName("woolentor-cart-product-content")[i].innerHTML += quantity_product.split("nth").join(i);
                
                document.getElementById("quantity_cart_" + i).value = tag_input[i].value;

                document.getElementById("quantity_cart_plus_" + i).onclick= function () {
                    // document.getElementById("quantity_cart_" + i).value ++;
                    document.getElementById(event.srcElement.id).value ++;
                    tag_input[i].value = document.getElementById("quantity_cart_" + i).value;
                }
                
                document.getElementById("quantity_cart_minus_" + i).onclick= function () {
                document.getElementById("quantity_cart_" + i).value --;
                tag_input[i].value = document.getElementById("quantity_cart_" + i).value;
                }
            }

            const click_quantity = (event) => {
            var id_target = event.srcElement.id;
            if (id_target.search("plus"))
                document.getElementById(id_target).value ++;
            else
                document.getElementById(id_target).value --;
            tag_input[id_target.slice(-1)].value = document.getElementById(id_target).value;
            }
        });


    </script>
    ';
}

function console($txt , $key = null){
    echo'
        <script>
            console.log("moein - ' .$key . ' - ' . $txt . '");
        </script>
    ';
}