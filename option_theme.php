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

if (!defined('ABSPATH')) {
  die('-1');
}


add_shortcode('moein_product_archive', 'product_archive');

function remove_quantity()
{
  $cart = WC()->instance()->cart;
  $id = '82';
  $cart_id = $cart->generate_cart_id($id);
  $cart_item_id = $cart->find_product_in_cart($cart_id);

  if ($cart_item_id)
    $cart->set_quantity($cart_item_id, 1);




  // console($id, 'id');
  // console($cart_id, 'cart_id');
  // console($cart_item_id, 'cart_item_id');
}



add_action('wp_footer', 'script_query_page');

function script_query_page()
{
  $current_page = $_SERVER['SCRIPT_URI'];
  $page_cart = 'https://' . $_SERVER['SERVER_NAME'] . '/cart/';
  $page_category = 'https://' . $_SERVER['SERVER_NAME'] . '/category/';
  // $page_shop_en = 'https://' . $_SERVER['SERVER_NAME'] . '/en/shop/' ;

  // console("current_page: " . $current_page); 
  // console("page_shop_en: " . substr($current_page,0,strlen($page_shop_en)));
  // console('page_shop_fa: ' . $page_shop_fa);

  if ($current_page == $page_cart) {
    script_page_cart();
  } elseif ($current_page == $page_category) {
    script_page_category();
  } //elseif($current_page == substr($current_page,0,strlen($page_shop_en))){
  //     script_page_shop_EnToFa();
  // }
}

function script_page_category()
{

  global $woocommerce;
  $items = $woocommerce->cart->get_cart();

  foreach ($items as $item => $values) {
    console($values['data']->get_id(), "id product");
    // console($values['data'], "data");
    // console($values['data']->get_description(), "description");
    // $product_description = '
    // <p id="product_description_' . $values['data']->get_id() . '" hidden>
    //   ' . $values['data']->get_description() . '
    // </p>
    // ';
    // console($values['data']->description(), "description");
    // console($values['data']['description'], "description");

    // var_dump($values);
    // $product_description = get_post($item[$values['data']->get_id()])->post_content;
    // console($product_description, "product_description");


    // $_product =  wc_get_product( $values['data']->get_id()); 
    // echo "<b>".$_product->get_title().'</b>  <br> Quantity: '.$values['quantity'].'<br>'; 
    // $price = get_post_meta($values['product_id'] , '_price', true);
    // echo "  Price: ".$price."<br>";
  }

  // $order = new WC_Order('82');

  // foreach ($order->get_items() as $item)
  // {
  //     $product_description = get_post($item['product_id'])->post_content; // I used wordpress built-in functions to get the product object 
  //     // console($product_description, 'product_description222');
  // }

  echo '<style>' . resource("box-number") . resource("style-card-product") . '</style>' . resource("script-category", "js");


}

function product_archive (){
  // $products = wc_get_products( array( 'status' => 'publish', 'limit' => -1 ) );

  // foreach ( $products as $product ){
    // echo '<pre class="moein_pre">';
    // echo  $product->get_status() . ' - (get_status)';  // Product status
    // echo  $product->get_type() . ' - (get_type)';  // Product type
    // echo  $product->get_id() . ' - (get_id)';    // Product ID
    // echo  $product->get_title() . ' - (get_title)'; // Product title
    // echo  $product->get_slug() . ' - (get_slug)'; // Product slug
    // echo  $product->get_price() . ' - (get_price)'; // Product price
    // echo  $product->get_catalog_visibility() . ' - (get_catalog_visibility)'; // Product visibility
    // echo  $product->get_stock_status() . ' - (get_stock_status)'; // Product stock status
    // echo  $product->get_description() . ' - (get_description)'; // Product get_description
    // // product date image
    // echo $product->get_image(); // Returns the main product image.
    // echo $product->get_image_id(); // Get main image ID.
    // // product date information
    // echo $product->get_date_created()->date('Y-m-d H:i:s');
    // echo $product->get_date_modified()->date('Y-m-d H:i:s');
    // echo '</pre>';
  // }

  $products = wc_get_products( array( 'status' => 'publish', 'limit' => -1 ) );

  ?>

  <div class="products-image-category">

  </div>

  <div class="products-slug">
    <?php
    // Get Woocommerce product categories WP_Term objects
    $categories = get_terms( ['taxonomy' => 'product_cat'] );

    // Getting a visual raw output
    // echo '<pre>'; var_dump( $categories ); echo '</pre>';
    // echo '<pre>'; var_dump( $categories[1] ); echo '</pre>';
    // echo '<pre>'; var_dump( $categories[1]['name'] ); echo '</pre>';
    // $all_category = json_decode( $categories, true );
    ?>
    <ul class="list-category">

      <?php
        foreach ($categories as $category => $value) {
          echo $category . "<br>";
          // echo $value . "<br>";

          if($category == "name"){
            echo '<li class="item-category">' . $value  . '</li>';
          }
        }
      ?>
    </ul>

    </div>
  </div>
<button id="test1" style="color:white">
  click me
</button>
  <div class="products-archive">
    <?php
    foreach ($products as $product) {
      ?>

      <!-- card of product -->
      <div id="cart_product" class="product_card" data-category="<?php echo $product->get_slug(); ?>">
        <a href="<?php echo get_permalink($product->get_id()); ?>">
        <div class="product-img">
          <?php echo $product->get_image(); ?>
        </div>
        <div class="product-data">
          <div class="product-title">
            <h2><?php echo $product->get_title(); ?></h2>
          </div>
          <div class="product-des">
            <p><?php echo $product->get_description(); ?></p>
          </div>
          <div class="product-price">
            <?php echo $product->get_price_html(); ?>
          </div>
          <div class="product-quantity">
              <p> + 1 - </p>
          </div>
        </div>
        <a>
      </div>
      

      <?php
    }
    ?>
  </div>
  <?php

}

function script_page_cart()
{
  echo "<style>" . resource("box-number") . resource("style-cart") . resource("style-category") . "</style>" . resource("script-cart", "js");
}


function resource($elem, $type = null)
{
  switch ($elem) {
    case "box-number":
      $result = '
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
      ';
      break;
    case "style-cart":
      $result = '
            .button:nth-child(1){
                display: none !important;
            }
            .input-text {
                display: none;
            }
        ';
      break;
    case "script-cart":
      $result = '
            // check every secend cart if not have data
            setInterval(time_check_frm,1000);
            function time_check_frm(){
              var exist_elem = document.getElementsByClassName("number_quantity_cart").length;
              // console.log("exist_elem - " + exist_elem);
              if(exist_elem == 0)
                cart_quantity_product();
            }
            
              //Click on + or - quantity
              const click_quantity = (id) => {
                var id_target = id.split("_");
                id_target = id_target[id_target.length-1];
                
                //add or minus with click on + - and change input box
                if (id.search("plus")>0){
                  document.getElementById("quantity_cart_" + id_target).value ++;
                }
                else{
                  if(document.getElementById("quantity_cart_" + id_target).value > 0) {
                    document.getElementById("quantity_cart_" + id_target).value --;
                  }
                }
            
                //put new value to input box woocommerce
                document.getElementsByClassName("input-text")[id_target].value = document.getElementById("quantity_cart_" + id_target).value;
                //enable button update cart and click it
                document.getElementsByClassName("button")[0].removeAttribute("disabled");
                document.getElementsByClassName("button")[0].click();
            
              }
            
              function cart_quantity_product (){
                var len_num_product = document.getElementsByClassName("input-text").length;
                
                //add box quantity (- 1 +) HTML to end of div
                var quantity_product = `
                  <div class="quantity_cart">
                      <span class="quantity_cart_plus" onclick="click_quantity(this.id)" id="quantity_cart_plus_nth">+</span>
                      <input class="number_quantity_cart" id="quantity_cart_nth" type="number" name="cart_quantity" min="1" max="10" disabled=""/>
                      <span class="quantity_cart_minus" onclick="click_quantity(this.id)" id="quantity_cart_minus_nth">-</span>
                  </div>
                `;
            
                //get all value of [input] number cart woocommerce
                var tag_input = document.querySelectorAll("input[type=number]");
                for(var i = 0 ; i < len_num_product ; i++){
                    //replace nth to id for per rendring
                    document.getElementsByClassName("woolentor-cart-product-content")[i].innerHTML += quantity_product.split("nth").join(i);
                    
                    //put value of [input] number cart woocommerce to my [input] quantity box
                    document.getElementById("quantity_cart_" + i).value = tag_input[i].value;
            
                    //show recycle bin if cart is one
                    if (document.getElementById("quantity_cart_" + i).value == 1){
                      document.querySelectorAll("a.woolentor-cart-product-actions-btn")[i].style = "display: block !important;";
                    }
                }
              }
        ';
      break;
    case "script-category":
      $result = '
        var len_card_product = document.getElementsByClassName("product_card").length;
        
        for(var i = 0 ; i <= len_card_product ; i++){
          document.getElementById("test1").addEventListener("click", function(){
            console.log(document.getElementsByClassName("product_card")[i].getAttribute("data-category"));
          });
        }

      ';
      break;
    case "style-category":
      $result = '
      .products-slug{
        display: inline-block;
        padding: 0px !important;
        background: #00000000;
        max-width: 50px;
        width: 50px;
      }
      .list-category{
        list-style-type: none;
        white-space: nowrap;
      }
      .item-category{
        float: right;
        display: inline-block;
        color: white;
        text-align: right;
        margin: 0px 12px;
        padding: 5px 10px;
        border-radius: 15px;
        background: #414141;
      }
      ';
      break;
    case "style-card-product":
      $result = '
      .product_card{
        border: 1px solid #606060 !important;
        border-radius: 5px;
        height: 150px;
        margin: 20px;
        padding: 5px 10px 10px 1px;
      }
      .product-data{
        width: 78%;
        float: left;
      }
      .product-price{
        color: #939393;
      }

      .product-img{
        width: 40%;
        padding-top: 15px;
        padding-right: 0px;
        position: absolute;
      }
      .product-img img{
        border-radius: 100%;
        height: 80px;
        width: 80px !important;
        object-fit: cover;
      }
      .product-title{
        margin-bottom: 7px;
        color: #FFFFFF;
      }
      .product-title h2{
        font-family: "Inter";
        font-style: normal;
        font-weight: 500;
        font-size: 16px;
        line-height: 19px;
      }
      .product-title{
        color: white
      }
      .product-des p{
        font-family: "Inter";
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        text-align: right;
      }
      .product-des{
        color: #BDBDBD;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2; /* number of lines to show */
                line-clamp: 2; 
        -webkit-box-orient: vertical;
        padding-left: 10px;
      }
      .woocommerce-Price-currencySymbol{
        color: #939393;
      }
      ';
      break;
  }

  if ($type == 'style' || $type == 'css')
    $result = '<style>' . $result . '</style>';
  if ($type == 'script' || $type == 'js')
    $result = '<script>' . $result . '</script>';
  return $result;
}

function console($txt, $key = null)
{
  echo '
        <script>
            console.log("moein - ' . $key . ' - ' . $txt . '");
        </script>
    ';
}