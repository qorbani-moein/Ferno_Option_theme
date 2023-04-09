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
  $page_home = 'https://' . $_SERVER['SERVER_NAME'] . '/';
  // $page_shop_en = 'https://' . $_SERVER['SERVER_NAME'] . '/en/shop/' ;

  console("current_page: " . $current_page);
  console("page_home: " . $page_home);
  // console("page_shop_en: " . substr($current_page,0,strlen($page_shop_en)));
  // console('page_shop_fa: ' . $page_shop_fa);

  if ($current_page == $page_cart) {
    script_page_cart();
    style_page_cart();
  } elseif ($current_page == $page_category) {
    script_page_category();
  } elseif ($current_page == $page_home) {
    console("script_page_home");
    script_page_home();
  }
  //elseif($current_page == substr($current_page,0,strlen($page_shop_en))){
  //     script_page_shop_EnToFa();
  // }
}

function script_page_home(){
  echo resource("script-home", "js") . resource("style-home", "css");
}

function script_page_category(){
  echo '<style>' . resource("style-card-product") . resource("style-category") . '</style>' . resource("script-category", "js");
}
function style_page_cart(){
  ?>
    <style>
      .woocommerce-error{
        display: none;
      }
    </style>
  <?php
}
function product_archive(){
  // $products = wc_get_products( array( 'status' => 'publish', 'limit' => -1 ) );

  // foreach ( $products as $product ){
  // echo '<pre class="moein_pre">';
  // echo  $product->get_status() . ' - (get_status)';  // Product status
  // echo  $product->get_type() . ' - (get_type)';  // Product type
  // echo  $product->get_id() . ' - (get_id)';    // Product ID
  // echo  $product->get_title() . ' - (get_title)'; // Product title
  // echo  $product->get_slug() . ' - (get_slug)'; // Product slug
  // echo  $product->get_categories() . ' - (get_categories)'; // Product categories
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

  $products = wc_get_products(array('status' => 'publish', 'limit' => -1));

?>

  <div id="popup_over" class="popup_over">
    <div id="popup_product" class="popup_product">
      <div class="close-popup" id="popup_over"><span>×</span></div>
      <div class="popup_product_img">
        <img id="popup_product_img" src="" src="" alt="#">
      </div>
      <div class="popup_product_data">
        <div class="popup-row-title-price">
          <div class="popup_product_title">

          </div>
          <div class="popup_product_price">
            <span>قیمت</span>
          </div>
        </div>
        <div class="popup_product_des">

        </div>
      </div>
      <div class="popup_product_add_to_cart">
        <a href="#" class="popup_product_btn_addtocart">افزودن به یادداشت سفارش</a>
      </div>
    </div>
  </div>



  <div id="products-image-category" class="products-image-category">
    <img class="img-product" src="<?php echo "https://menu.fernofood.com/wp-content/uploads/2023/03/01.jpg"; ?>">
    <h1 class="caption-img-product"></h1>
  </div>

  <div id="products-slug" class="products-slug">
    <?php
    // Get Woocommerce product categories WP_Term objects
    $categories = get_terms(['taxonomy' => 'product_cat']);

    // Getting a visual raw output
    // echo '<pre>'; var_dump( $categories ); echo '</pre>';
    // echo '<pre>'; var_dump( $categories[1] ); echo '</pre>';
    // echo '<pre>'; var_dump( $categories[1]['name'] ); echo '</pre>';
    // $all_category = json_decode( $categories, true );
    ?>
    <ul class="list-category">
      <!-- <li class="item-category">همه</li> -->
      <?php
      foreach ($categories as $category => $value) {
        echo '<li class="item-category">';
        foreach ($value as $item => $value_item) {
          if ($item == "name" && $value_item != "") {
            // echo '<li class="item-category">' . $value_item . '<li>';
            echo $value_item;
          }
        }
        echo "</li>";
      }
      ?>
    </ul>

  </div>
  </div>

  <div id="products_archive" class="products-archive">
    <?php
    $j = 0;
    foreach ($products as $product) {
    ?>

      <?php
      // echo "<pre>" . var_dump($product->get_category_ids()) . "</pre>";
      // echo "<pre>" . var_dump($product->get_categories()) . "</pre>";
      echo '<div class="value_category_' . $j++ . '" hidden>' . $product->get_categories() . "</div>";
      $categories_product = $product->get_category_ids();
      ?>
      <!-- card of product -->
      <div id="cart_product" class="product_card" data-id="<?php echo $product->get_id(); ?>" data-category="<?php echo urldecode($categories_product[0]); ?>">
        <a href="javascript:popup('<?php echo $j - 1 ?>');">
          <div style="opacity: 0;" class="product-img">
            <?php echo $product->get_image(array(1024, 1024)); ?>
          </div>
          <div class="product-data">
            <div class="product-title">
              <a href="javascript:popup('<?php echo $j - 1 ?>');<?php //echo get_permalink($product->get_id()); ?>">
                <h2><?php echo $product->get_title(); ?></h2>
              </a>
            </div>
            <div class="product-des">
              <?php echo $product->get_description(); ?>
            </div>
            <div class="product-price">
              <?php echo $product->get_price_html(); ?>
            </div>
            <div class="moein-product-quantity" hidden="">

              <?php
              global $woocommerce;
              $items = $woocommerce->cart->get_cart();

              foreach ($items as $item => $values) {
                // $_product =  wc_get_product( $values['data']->get_id()); 
                if ($values['data']->get_id() == $product->get_id()) {
                  if (!isset($values['quantity']))
                    echo '0';
                  else
                    echo $values['quantity'];
                }
                // echo "<b>".$_product->get_title().'</b>  <br> Quantity: '.$values['quantity'].'<br><br><br>' . '
                // <p style="color:white;">get_id= ' . $values['data']->get_id() . '</p> 
                // <p style="color:white;">$product->get_id()= ' . $product->get_id() . '</p>'; 
                // $price = get_post_meta($values['product_id'] , '_price', true);
                // echo "  Price: ".$price."<br>";
              }
              ?>
            </div>
          </div>
        </a>
      </div>


    <?php
    }
    ?>
  </div>
<?php

}

function script_page_cart()
{
  echo "<style>" . resource("box-number") . resource("style-cart") . "</style>" . resource("script-cart", "js");
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
            padding: 3px 0px 0px 3px;
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
            .woocommerce .woolentor-cart-list .product-name a, .woocommerce .woolentor-cart-list .product-name {
              font-size: 16px !important;
              font-weight: 300 !important;
            }
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
            //back menu in header
            document.getElementsByClassName("elementor-icon")[0].href = "https://menu.fernofood.com/category/";

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
                var target_cart = "quantity_cart_" + id_target;
                document.getElementsByClassName("input-text")[id_target].value = document.getElementById(target_cart).value;
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
      //back menu in header
      document.getElementsByClassName("elementor-icon")[0].href = "https://menu.fernofood.com";
      
      //
      
      
       
      //<script>
      //filter by category
      //add event click on category
      var len_category = document.getElementsByClassName("product_card").length;
      var action_list_li = [];
      for(var i = 0 ; i <= len_category - 1 ; i++){
        action_list_li[i] = document.getElementsByClassName("item-category")[i];
        if(action_list_li[i]){
          action_list_li[i].addEventListener("click", set_ua_value, false);
        }
      }
      
      //sticky menu in top page
      window.onscroll = function() {myFunction()};

      var menubar = document.getElementById("products-slug");
      var products_archive = document.getElementById("products_archive");

      var imagebar = document.getElementById("products-image-category");
      var sticky = 50 + menubar.offsetTop + imagebar.offsetTop;

      function myFunction() {
        // console.log("window.pageYOffset: " + window.pageYOffset);
        // console.log("sticky: " + sticky);
        if (window.pageYOffset >= 250) {
          menubar.classList.add("sticky");
          products_archive.classList.add("products-archive-top");
        } else {
          menubar.classList.remove("sticky");
          products_archive.classList.remove("products-archive-top");
        }
      }

      //save and get scrolling
      document.addEventListener("scroll", (event) => {
        const set_now = new Date();
        sessionStorage.setItem("scroll" , document.documentElement.scrollHeight  + "-" + set_now.getTime());
      });
      const set_now_ss = new Date();
      var s_scroll = sessionStorage.getItem("scroll");
      if(s_scroll != null){
        s_scroll = s_scroll.split("-");
        var xi = set_now_ss.getTime() - s_scroll[1];
        if(60000 > xi ){
          window.scrollTo(0, s_scroll[0]); 
        }
      }


      //click on tab items
      function set_ua_value (e) {
        if(e.target.nodeName == "LI") {
          
          //remove class menu actived
            // console.log("u.length: " + document.getElementsByClassName("item-category").length);
            for(var u = 0 ; u <= document.getElementsByClassName("item-category").length - 1 ; u++){
              // console.log("u: " + u);
              document.getElementsByClassName("item-category")[u].classList.remove("products-slug-active");
              
            }
            
            e.target.classList.add("products-slug-active");

            //find div of product has class"products-slug-active" for 
            for(var u = 0 ; u <= document.getElementsByClassName("item-category").length - 1 ; u++){
              var tab_items = document.getElementsByClassName("item-category")[u].className;
              if(tab_items.search("products-slug-active") > 0){
                // console.log(u);
                const set_now = new Date();
                
                // console.log(i + "-" + set_now.getTime());
                sessionStorage.setItem("tab-clicked", u + "-" + set_now.getTime());
              }
            }


          // console.log("e.target.innerHTML: " + e.target.innerHTML);
            //filter category
            var len_card_product = document.getElementsByClassName("product_card").length;
            var category_attr = e.target.innerHTML;
            document.getElementsByClassName("caption-img-product")[0].innerHTML = e.target.innerHTML;
            var category_attr_card;
            // console.log("len_card_product.length: " + len_card_product);
            for(var i = 0 ; i <= len_card_product -1 ; i++){
              
              // category_attr_card = document.getElementsByClassName("product_card")[i].getAttribute("data-category");
              category_attr_card = document.querySelectorAll(".value_category_" + i + " a");

              document.getElementsByClassName("product_card")[i].style.display = "block";
              // console.log("category_attr_card.length: " + category_attr_card.length );
              
              // console.log("i: " + i );
              for(var y = 0 ; y <= category_attr_card.length -1; y++){
                // console.log("y: " + y );
                // console.log("category_attr_card: " + category_attr_card[y].innerHTML);
                
                // if(category_attr == "همه"){
                //   document.getElementsByClassName("product_card")[i].style.display = "block";
                //   break;
                // }
                if(category_attr != category_attr_card[y].innerHTML){
                  // console.log("hidden");
                  document.getElementsByClassName("product_card")[i].style.display = "none";
                }else{
                  // console.log("show");
                  document.getElementsByClassName("product_card")[i].style.display = "block";
                  break;
                }

              }
              

              // document.getElementById("test1").addEventListener("click", function(){
              //   console.log(document.getElementsByClassName("product_card")[i].getAttribute("data-category"));
              // });
            }
          }

      }


      //Click on tabs
      // document.getElementsByClassName("item-category")[0].click();

      //sessionStorage.setItem("tab-clicked", u + "-" + set_now.getTime());

      console.log(sessionStorage.getItem("tab-clicked"));

      var user_clicked = sessionStorage.getItem("tab-clicked");
      if(user_clicked != null){
        user_clicked = user_clicked.split("-");
        const set_now = new Date();
        var xj = set_now.getTime() - user_clicked[1];
        if(60000 > xj ){
          document.getElementsByClassName("item-category")[user_clicked[0]].click();
          window.scrollTo(user_clicked[2], 0); 
        }else{
          document.getElementsByClassName("item-category")[0].click();
        }
      }else{
        document.getElementsByClassName("item-category")[0].click();
      }

      //scrollleft menu 
      /*console.log(sessionStorage.getItem("tab-scroll"));*/

      if(sessionStorage.getItem("tab-scroll") != null){
        var tab_scroll = sessionStorage.getItem("tab-scroll");
        tab_scroll = tab_scroll.split("_");
        const set_now = new Date();
        var xj = set_now.getTime() - tab_scroll[1];
        if(60000 > xj ){
          document.getElementById("products-slug").scroll(tab_scroll[0], 0);
        }
      }

      document.getElementById("products-slug").addEventListener("scroll", event => {
        const set_now = new Date();
        sessionStorage.setItem("tab-scroll", document.getElementById("products-slug").scrollLeft + "_" + set_now.getTime());
      }, { passive: true });




        console.log(sessionStorage.getItem("window-scroll"));

        if(sessionStorage.getItem("window-scroll") != null){
          var window_scroll = sessionStorage.getItem("window-scroll");
          window_scroll = window_scroll.split("_");
          const set_now = new Date();
          var xj = set_now.getTime() - window_scroll[1];
          if(60000 > xj ){
            window.scrollTo(0,window_scroll[0]); 
          }
        }

        window.onscroll = function() {listenwindowscroll()};


        function listenwindowscroll() {
          const set_now = new Date();
          sessionStorage.setItem("window-scroll", document.documentElement.scrollTop + "_" + set_now.getTime());
        }

        
















        

      //box number (- 1 +)
        
      // check every secend cart if not have data
      setInterval(time_check_frm,1000);
      function time_check_frm(){
        var exist_elem = document.getElementsByClassName("quantity_cart").length;
        // console.log("exist_elem: - " + exist_elem);
        if(exist_elem == 0 || exist_elem == "" || exist_elem == null)
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
          var target_cart = "quantity_cart_" + id_target;
          document.getElementsByClassName("input-text")[id_target].value = document.getElementById(target_cart).value;
          //enable button update cart and click it
          document.getElementsByClassName("button")[0].removeAttribute("disabled");
          document.getElementsByClassName("button")[0].click();
      
        }
      
        function cart_quantity_product (){
          // console.log("True true");
          // var len_cart = document.getElementsByClassName("moein-product-quantity").length;
          var woo_product_quantity = document.getElementsByClassName("moein-product-quantity");
          
          //add box quantity (- 1 +) HTML to end of div
          var quantity_product_html = `
            <div class="quantity_cart">
                <span class="quantity_cart_plus" onclick="click_quantity(this.id)" id="quantity_cart_plus_nth">+</span>
                <input class="number_quantity_cart" id="quantity_cart_nth" type="number" name="cart_quantity" min="1" max="10" />
                <span class="quantity_cart_minus" onclick="click_quantity(this.id)" id="quantity_cart_minus_nth">-</span>
            </div>
          `;
      
          //get all product woocommerce

          //get cart woocommerce
          for(var i = 0 ; i < woo_product_quantity.length ; i++){
              //replace nth to id for per rendring
              document.getElementsByClassName("moein-product-quantity")[i].outerHTML += quantity_product_html.split("nth").join(i);
              
              //put value of [input] number cart woocommerce to my [input] quantity box
              
              // console.log(woo_product_quantity[i].innerHTML);
              document.getElementById("quantity_cart_" + i).value = woo_product_quantity[i].innerHTML.trim();
              if(woo_product_quantity[i].innerHTML == 0)
                document.getElementsByClassName("quantity_cart")[i].style.display = "none";
              else
                document.getElementsByClassName("quantity_cart")[i].style.display = "flex";

              //show recycle bin if cart is one
              // if (document.getElementById("quantity_cart_" + i).value == 1){
              //   document.querySelectorAll("a.woolentor-cart-product-actions-btn")[i].style = "display: block !important;";
              // }
          }
        }

        //popup
        window.addEventListener("click", function(e){   
          // console.log(e.target);
          // console.log(e.target.innerHTML);
          if(e.target.innerHTML == "×"){
            document.getElementById("popup_over").classList.remove("popup_over_active");
          }
          if (document.getElementById("popup_product").contains(e.target)){
            // Clicked in box
          } else{
            document.getElementById("popup_over").classList.remove("popup_over_active");
            var popup_img = document.querySelectorAll(".popup_product_img img");
            popup_img[0].src="";
          }
        });

        function popup(id){
          
          // console.log("popup function id:" + id);
          document.getElementById("popup_over").classList.add("popup_over_active");
          
          //img popup
          var product_img = document.querySelectorAll(".product-img img");
          var popup_img = document.querySelectorAll(".popup_product_img img");
          popup_img[0].src = product_img[id].src;

          //description
          var product_des = document.querySelectorAll(".product-des");
          var popup_des = document.querySelectorAll(".popup_product_des");
          popup_des[0].innerHTML = product_des[id].innerHTML;
          
          //title
          var product_title = document.querySelectorAll(".product-title h2");
          var popup_title = document.querySelectorAll(".popup_product_title");
          popup_title[0].innerHTML = \'<h4>\' + product_title[id].innerHTML + \'</h4>\';

          //price
          var product_price = document.querySelectorAll(".product-price span bdi");
          var popup_price = document.querySelectorAll(".popup_product_price span");
          console.log(id);
          // console.log(product_price[id].innerHTML);
          popup_price[0].innerHTML = product_price[id].innerHTML;

          for(var i = 0 ; i <= 40 ; i++){
            console.log(i + " - " + product_price[i].innerHTML);

          }
          //btn add to card
          var product_id = document.getElementsByClassName("product_card")[id].getAttribute("data-id");
          var popup_btn_addtocard = document.querySelectorAll(".popup_product_add_to_cart");
          popup_btn_addtocard[0].innerHTML = \'<a rel="nofollow" href="?add-to-cart=\' + product_id + \'" data-product_id="\' + product_id + \'" class="popup_product_btn_addtocart ajax_add_to_cart"> + افزودن به یادداشت سفارش</a>\';
        }

      ';
      break;
    case "style-category":
      $result = '
      .popup_product_data{
        padding-top:32px;
      }
      .close-popup span{
        position: absolute;
        right: 24px;
        top: 5px;
        font-size: 32px;
        cursor: pointer;
      }
      .products-archive{
        margin-top: -10px;
        margin-bottom: 128px;

      }
      .products-archive-top{
        margin-top: 80px !important;
      }
      .products-slug{
        position: relative;
        top: -10px;
        right: 0px;
        background-color: #333;
        white-space: nowrap;
        display: inline-block;
        width: 100%;
        height: 72px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.25);
        overflow-x: auto;
        -ms-overflow-style: none;
        scrollbar-width: none;
        overflow-y: hidden;
        -ms-overflow-style: none;
        text-align: right;
      }
      .products-slug ul{
        list-style-type: none;
        margin: 0;
        padding: 18px 20px 0px 20px;
        overflow: hidden;
        background-color: #333333;
        display: inline-flex;
        overflow: auto;
        white-space: nowrap;
        color: white;
      }
      .products-slug li{
        float: right;
        display: inline-block;
        color: white;
        text-align: right;
        margin: 0px 6px;
        padding: 6px 18px 6px 18px;
        border-radius: 30px;
        background: #414141;
        cursor: pointer;
      }
      .products-slug-active{
        background: #FCBD1E !important;
        color: #2c2c2c !important;
      }
      .cat_active{
        background: #838383;
      }
      .img-product{
        width: 100%;
      }
      .caption-img-product{
        position: absolute;
        color: white;
        top: 160px;
        right: 26px;
        font-family: "Vazirmatn";
        font-style: normal;
        font-weight: 500;
        font-size: 20px;
        display:none;
      }
      
      .quantity_cart{
        width: 30%;
        color: #FFD15E;
        position: relative;
        background: #2c2c2c;
        left: 0px;
        top: -33px;
        display: flex;
        flex-wrap: nowrap;
        align-content: stretch;
        justify-content: space-evenly;
        align-items: center;
        border: 1px solid #FFD15E;
        border-radius: 50px;
        margin-left: 20px;
        height: 36px;
        font-size: 20px;
        padding: 5px 3px 5px 3px;
        float: left;
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
      moein-product-quantity{
        display:none;
      }
      /* popup */
      .popup_over{
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.7);
        transition: opacity 500ms;
        visibility: hidden;
        opacity: 0;
      }
      .popup_over_active {
        visibility: visible;
        opacity: 1;
        z-index: 10;
      }

      .popup_product{
        margin: 100px auto;
        padding: 20px;
        background: #303030;
        border-radius: 10px;
        width: 90%;
        position: relative;
        // transition: all 1s ease-in-out;
        color: white;
      }
      .popup_product_title h4{
        font-size: 18px;
      }
      .popup_product_price{
        font-size:18px;
      }
      .popup_product_des{
        padding-bottom: 20px;
        font-weight: 300 !important;
        font-size: 14px;
        padding-top: 10px;
      }
      .popup_product_btn_addtocart:active , .popup_product_btn_addtocart:hover{
        color:#FCBD1E !important;
      }
      .popup_product_btn_addtocart{
        padding: 10px 20px 15px 20px;
        border: 1px solid #FCBD1E;
        border-radius: 50px;
        color: white;
        text-align: center;
        width: 100%;
        display: inline-block;
      }
      .popup_product_add_to_cart{
        text-align: center;
        padding-bottom: 25px;
      }
      .popup_product_img img{
        max-width: 100%;
        border: none;
        box-shadow: none;
        margin-top: -105px;
      }
      .popup_product_img{
        text-align: center;
        /*background-image: url("https://menu.fernofood.com/wp-content/uploads/2023/03/Untitled.png");*/
        background-repeat: no-repeat;
        padding: 100px;
        background-position: center;
        height: 100px;
        background-size: contain;
        width: 100%;
        display: flex;
        justify-content: center;
      }
      #popup_product_img{
        border-radius: 5px;
        height: 210px;
        max-width: 210px !important;
      }
      .popup-row-title-price{
        display: flex;
        flex-wrap: nowrap;
        flex-direction: row;
        align-content: stretch;
        justify-content: space-between;
        align-items: center;
      }
      /* alert woocommerce */
      .woocommerce-notices-wrapper{
        display:none
      }
      .sticky {
        position: fixed;
        top: 0;
        width: 100%;
        z-index:5;
      }
      ';
      break;

    case "style-card-product":
      $result = '
      .product_card{
        border: 1px solid #606060 !important;
        border-radius: 5px;
        height: 180px;
        margin: 20px;
        padding: 12px 10px 12px 1px;
      }
      .product-data{
        width: 72%;
        float: left;
      }
      .product-price:not(.woocommerce-Price-currencySymbol){
        color: #fff;
      }

      .product-img{
        opacity: 1 !important;
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
      }
      .product-title a{
        color: #FFFFFF !important;
      }
      .products-slug::-webkit-scrollbar {
        display: none; /* for Chrome, Safari, and Opera */
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
        margin-bottom: 25px;
        font-size: 12px;
      }
      .woocommerce-Price-currencySymbol{
        color: #939393 !important;
        padding-right: 8px;
      }
      ';
      break;
    case "script-home":
      $result = '
      //back menu in header
      document.getElementsByClassName("elementor-icon")[0].style.display = "none";
      
      document.getElementById("moein_card_room_desk").addEventListener("click", show_comingsoon); 

      
      function show_comingsoon(){
        // console.log("show_comingsoon");
        unfade(document.getElementById("popup_coming_soon"));
      }
      function unfade(element) {
        var op = 0.1;  // initial opacity
        element.style.display = "block";
        var timer = setInterval(function () {
            if (op >= 1){
                clearInterval(timer);
            }
            element.style.opacity = op;
            element.style.filter = "alpha(opacity=" + op * 100 + ")";
            op += op * 0.1;
        }, 10);
          }
      ';
      break;
    case "style-home":
      $result = '
      .popup-coming-soon-line-bar{
        float: left;
        width: 60%;
      }
      .popup-coming-soon-line-bar hr{
        width: 30%;
        border: 2px solid #626262;
        border-radius: 20px;
        margin-top: 10px;
      }
      .popup-coming-soon{
        /*border-top-left-radius: 15px;
        border-top-right-radius: 15px;*/
        background: #303030;
        text-align: center;
        position: fixed;
        bottom: 0px;
        scale: 0.9;
        border-radius: 15px;
      }
      .over-screen{
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.7);
        transition: opacity 500ms;
        visibility: hidden;
        opacity: 0;
      }
      .popup-coming-soon-title{
        display: inline-block;
        text-align: center;
        width: 100%;
        color: white;
        padding-top: 85px;
      }
      .popup-coming-soon-loading img{ 
        width: 100%;
        padding-bottom: 24px;
      }
      .popup-coming-soon-contact-us{
        padding-top: 32px;
      }
      .popup-coming-soon-btn-contact-us{
        margin-top: 32px;
        padding: 32px;
      }
      .popup-coming-soon-icon , .popup-coming-soon-phone{
        background: #434343;
      }
      .popup-coming-soon-icon{
        padding: 12px 15px 12px 13px;
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
        border-left: 1px solid #8A8A8A;
      }
      .popup-coming-soon-icon svg{
        position: relative;
        top: 9px;
      }
      .popup-coming-soon-phone{
        padding: 12px 70px 12px 20px;
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
      }
      .popup-coming-soon-phone a{
        position: relative;
        top: 4px;
        color: white;
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
