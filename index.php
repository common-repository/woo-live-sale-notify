<?php

/*
  Plugin Name: Woo Live Sale Notify
  Plugin URI: https://layerdeveloper.com/portfolio
  Description: Show live sale notifation on the front end for WooCommerce.
  Version: 1.0
  Author: Zeshan Abdullah
  Author URI: https://www.fiverr.com/aliali44
 */

// Exit if accessed directly 
  if (!defined('ABSPATH'))
    exit;
  /**
* creating a table for saving notification default setting
* 
*/
function wooLiveNotifySetting()
{      	
  global $wpdb; 
  $db_table_name = $wpdb->prefix . 'woo_live_notify';  // table name
  $charset_collate = $wpdb->get_charset_collate();
  $sql = "CREATE TABLE $db_table_name (
                id int(11) NOT NULL auto_increment,
                notification varchar(1500) default '',
                bg_color varchar(20),
                text_color varchar(20),
                border_size varchar(4),
                border_color varchar(20),
                shadow varchar(50),
                bg_image varchar(400),
                bg_size varchar(8),
                bg_gradient varchar(150),
                position varchar(1),
                effects varchar(1),
                product_option varchar(20),
                product_ids varchar(80),
                buyer_names varchar(800),
                location_names varchar(900),
                number_of_notify varchar(10),
                on_screen varchar(5),
                after_notify varchar(10),
                beep varchar(1),
                on_mobile varchar(1),
                in_time varchar(1),
                not_show varchar(80),
                only_live_sale varchar(1),
                  UNIQUE KEY id (id)
        ) $charset_collate;";

   require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
   dbDelta( $sql );
   add_option( 'test_db_version', $test_db_version );
   
   $wpdb->insert( $db_table_name, array( 'notification' => '<!-- Pop up start--><div class="woo-live-sale-pop-up woo-popup-4"><div class="woo-live-sale-product-pic" style="background-image:url(https://image.ibb.co/iceHYe/1.jpg)"></div><div class="woo-live-sale-right-cont-pdetails"><span class="cross-hide-live-sale">✕</span><div class="woo-live-sale-right-comp-text"><span class="pop-up-p-name">Someone</span> from <span class="pop-up-area-name">Warner, NH</span> purchased a </div><div class="woo-live-sale-right-pr-off-name">Men Boston Clear Sungla and Someting</div></div><div class="clear-fix"></div><div class="woo-live-sale-pr-sale-time">5 hours ago</div></div><!-- Pop up end -->', 'bg_color' => 'white', 'text_color' => '#55586c', 'border_size' =>'0px', 'border_color' =>'black', 'shadow' =>'0px 2px 10px 0px #d5d5d5', 'bg_image' => 'none', 'bg_size' => '100%', 'bg_gradient' =>'none', 'position'=>'1','effects'=>'2', 'product_option'=>'product-stock', 'product_ids'=>'','buyer_names'=>'Alexis Maynes<br/>Micheal Sauls<br/>Kourtney Coe<br/>Sharolyn Gagliano<br/>Yuri Dare<br/>Dawn Hanner<br/>Garland Hermanson<br/>Kristi Scriber<br/>Coleen Beam<br/>Holley Jeffery<br/>Carmella Bongiovanni<br/>Alfonzo Gehrke<br/>Sam Benner<br/>Tran Hand<br/>Dexter Hains<br/>Shirley Carta<br/>Kamilah Alejandre<br/>Guadalupe Ketter<br/>Israel Adamson<br/>Elisa Purgason<br/>','location_names'=>'Warner, NH<br/>East Natchitoches, PA<br/>Lyon, WV<br/>Willow Run, IL<br/>Conyersville, AZ<br/>Mount Baker, NY<br/>Farmington Lake, OK<br/>Martins Corner, TX<br/>Pickerel Narrows, MT<br/>Willaha, OH<br/>Center, MA<br/>Spring City, MS<br/>Mittenlane, TX<br/>East Waterford, ME<br/>Coltman, WV<br/>Scottsville, KS<br/>Hebron, AZ<br/>Longview, MA<br/>Emerson, MT<br/>North Knoxville, AL<br/>', 'number_of_notify'=>'15,20', 'on_screen'=>'5','after_notify'=>'5, 10', 'beep'=>'0', 'on_mobile'=>'1', 'in_time'=>'1', 'not_show'=>'cart,checkout,account,blog', 'only_live_sale'=>'0'    ) );

} 


register_activation_hook( __FILE__, 'wooLiveNotifySetting' );
include_once 'admin/admin.php';

// ==================== Including necessary files ======================//
function wlsnFontEndFiles() {
        
        global $wpdb;
        $table_name = $wpdb->prefix . 'woo_live_notify';
        $notify_db_details = $wpdb->get_row("SELECT not_show FROM $table_name WHERE id = '1' ");
        $notShowOnPages = $notify_db_details->not_show;

        //not include files on the selected pages
        if ( class_exists( 'WooCommerce' ) ) {
             $addFiles = 0;
        
          if ( is_page( 'cart' ) || is_cart() ) {
            if (strpos($notShowOnPages, 'cart') !== false) {
            $addFiles = 1; 
            }
          }
          elseif ( is_front_page() && is_home() ) {
               // Default homepage
            if (strpos($notShowOnPages, 'home') !== false) {
            $addFiles = 1; 
            }
             }
             elseif (is_page( 'checkout' ) || is_checkout()) {
            if (strpos($notShowOnPages, 'checkout') !== false) {
            $addFiles = 1; 
            }
             }
             elseif (is_account_page()) {
            if (strpos($notShowOnPages, 'account') !== false) {
             $addFiles = 1; 
            }
             }
              elseif (is_single() && !is_product()) {
            if (strpos($notShowOnPages, 'blog') !== false) {
             $addFiles = 1; 
            }
             }             
           }

    if ($addFiles != 1) {
      wp_enqueue_style('wlsnReceive', plugins_url('/assets/css/animate.css', __FILE__));
    wp_enqueue_style('wlsnReceiveStyle', plugins_url('/assets/css/style.css', __FILE__));
    wp_enqueue_style('wlsnReceive', plugins_url('/assets/font-awesome/css/font-awesome.min.css', __FILE__));
    wp_enqueue_script('wlsnReceive', plugins_url('/assets/js/logic.js',__FILE__ ));
    //wp_enqueue_style('https://fonts.googleapis.com/css?family=Open+Sans:400,800');
    wp_localize_script('wlsnReceive', 'wlsnURL', array(
        'wlsn_ajax_url' => admin_url('admin-ajax.php')
        ));
    }
    
}

add_action('wp_enqueue_scripts', 'wlsnFontEndFiles');



// =================== Ajax recieved for notification ======================//
//Ajax call receive
add_action('wp_ajax_nopriv_wlsnReciveNotificaiton', 'wlsnReciveNotificaiton');
add_action('wp_ajax_wlsnReciveNotificaiton', 'wlsnReciveNotificaiton');
$resultNotify = array();

function wlsnReciveNotificaiton() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'woo_live_notify';
        $notify_db_details = $wpdb->get_row("SELECT * FROM $table_name WHERE id = '1' ");
        //basic setting 
        global $resultNotify;
        $resultNotify[0][0] = esc_html($notify_db_details->position);
        $resultNotify[0][1] = esc_html($notify_db_details->effects);
        $resultNotify[0][2] = esc_html($notify_db_details->product_option);
        $resultNotify[0][3] = esc_html($notify_db_details->product_ids);
        $resultNotify[0][4] = htmlspecialchars_decode($notify_db_details->buyer_names);
        //buyer names replacing <br/> to comma
        $resultNotify[0][4] = str_replace('<br/>', ',', $resultNotify[0][4]);
        //location names replacing <br/> to comma
        $resultNotify[0][5]   = htmlspecialchars_decode($notify_db_details->location_names);
        $resultNotify[0][5]   = str_replace('<br/>', '__', $resultNotify[0][5]);
        $resultNotify[0][6]   = esc_html($notify_db_details->number_of_notify);
        $resultNotify[0][7]   = esc_html($notify_db_details->on_screen);
        $resultNotify[0][8]   = esc_html($notify_db_details->after_notify);
        $resultNotify[0][9]   = esc_html($notify_db_details->beep);
        $resultNotify[0][10]  = esc_html($notify_db_details->on_mobile);
        $resultNotify[0][11]  = htmlspecialchars_decode($notify_db_details->notification);
        $resultNotify[0][12]  = esc_html($notify_db_details->in_time);
        $resultNotify[0][13]  = esc_html($notify_db_details->only_live_sale);

        //Getting post details
        $only_live_sale     =  esc_html($_POST['only_live_sale']); 

        if ($resultNotify[0][13] == "1" && $only_live_sale == "0") {
          //getting running order details
          wlsngetLatestOrderIdCheck();

        }
        elseif ($resultNotify[0][13] == "1" && $only_live_sale == "2") {
          //getting running order details
          wlsngetLatestOrderDetails();

        }
        elseif (trim($notify_db_details->product_option) == "running-orders") {
          //getting running order details
          wlsnRunningOrderGetDetails("running-orders");

        }
        elseif (trim($notify_db_details->product_option) == "completed-orders") {
          wlsnCompletedOrderGetDetails("completed");
        }
        elseif (trim($notify_db_details->product_option) == "product-stock") {
          wlsnProductstockGetDetails("product-stock", $resultNotify[0][4], $resultNotify[0][5], $resultNotify[0][6]);
        }
        elseif (trim($notify_db_details->product_option) == "pro-manually") {
          wlsnProductManuallyGetDetails("pro-manually", $resultNotify[0][3], $resultNotify[0][4], $resultNotify[0][5]);
        }
        
  exit();
}


// ============================ Running order details =======================//
function wlsnRunningOrderGetDetails($order_status){
$filters = array(
    'post_status' => 'any',
    'post_type' => 'shop_order',
    'posts_per_page' => 40,
    'paged' => 1,
    'orderby' => 'modified',
    'order' => 'ASC'
);

$loop = new WP_Query($filters);

//result arrays
$j = 1;
global $resultNotify;
while ($loop->have_posts()) {
    $loop->the_post();
    $order = new WC_Order($loop->post->ID);
    foreach ($order->get_items() as $key => $product_item) {
    //storing product notification details details

      if ($j <= $loop->post_count) {
     if ($order_status == "running-orders") {
        if ($order->get_status( ) == "processing"  || $order->get_status( ) == "pending" || $order->get_status( ) == "on-hold") {
      $resultNotify[$j][0] = $product_item['product_id'];
      $resultNotify[$j][1] = $product_item['name'];
      $featured_image      = wp_get_attachment_image_src( get_post_thumbnail_id($product_item['product_id']));
      $resultNotify[$j][2] = $featured_image[0];
      $resultNotify[$j][3] = $order->get_billing_first_name();
      $resultNotify[$j][4] = $order->get_billing_last_name();
      $resultNotify[$j][5] = $order->get_billing_city();
      $resultNotify[$j][6] = $order->get_billing_state();
      $resultNotify[$j][7] = get_the_title( $product_item['product_id'] );
      $resultNotify[$j][8] = get_permalink($resultNotify[$j][0]);
      $j++;
      }
      }
      }    
    }
      
}

echo json_encode($resultNotify);
}
// ============================ Completed orders =======================//
function wlsnCompletedOrderGetDetails($order_status){
$filters = array(
    'post_status' => 'any',
    'post_type' => 'shop_order',
    'posts_per_page' => 40,
    'paged' => 1,
    'orderby' => 'modified',
    'order' => 'ASC'
);

$loop = new WP_Query($filters);
//result arrays

$j = 1;
global $resultNotify;
while ($loop->have_posts()) {
    $loop->the_post();
    $order = new WC_Order($loop->post->ID);
    foreach ($order->get_items() as $key => $product_item) {
    //storing product notification details details
     if ($order_status == "completed") {
        if ($order->get_status( ) == "completed") {
        $resultNotify[$j][0] = $product_item['product_id'];
      $resultNotify[$j][1] = $product_item['name'];
      $featured_image      = wp_get_attachment_image_src( get_post_thumbnail_id($product_item['product_id']));
      $resultNotify[$j][2] = $featured_image[0];
      $resultNotify[$j][3] = $order->get_billing_first_name();
      $resultNotify[$j][4] = $order->get_billing_last_name();
      $resultNotify[$j][5] = $order->get_billing_city();
      $resultNotify[$j][6] = $order->get_billing_state();
      $resultNotify[$j][7] = get_the_title( $product_item['product_id'] );
      $resultNotify[$j][8] = get_permalink($resultNotify[$j][0]);
      $j++;
      }
      }    
    }
      
}
echo json_encode($resultNotify);
}

// ============================ Get products from product stock =======================//
function wlsnProductstockGetDetails($order_status, $b_names, $l_names, $number_of_notify){

$j = 1;
global $resultNotify;
 $args = array(
        'post_type'      => 'product',
        'posts_per_page' => 30,
    );
    $loop = new WP_Query( $args );
    while ( $loop->have_posts() ) : $loop->the_post();
        global $product;
        $resultNotify[$j][0] = get_the_ID();
        $featured_image      = wp_get_attachment_image_src( get_post_thumbnail_id($loop->post->ID));
        $resultNotify[$j][2] = $featured_image[0];
        $resultNotify[$j][7] = get_the_title();
        $resultNotify[$j][8] = get_permalink();
        $j++;
    endwhile;
    wp_reset_query();


    // Buyer and location names
    $names    = explode(',', $b_names);
    $location = explode('__', $l_names);
    //getting usr row -cookies
    $userRowLength = wlsnUserRowSave(sizeof($names));
      for ($i=1; $i < $number_of_notify; $i++) { 
      //$resultNotify[$j][1] = $product_item['name'];
      $resultNotify[$i][3] = substr($names[$i + $userRowLength], 0, strpos($names[$i + $userRowLength], ' '));
      $resultNotify[$i][4] = substr($names[$i + $userRowLength], strpos($names[$i + $userRowLength], ' '), strlen($names[$i + $userRowLength]) );
      $resultNotify[$i][5] = substr($location[$i + $userRowLength], 0, strpos($location[$i + $userRowLength], ','));
      $resultNotify[$i][6] = substr($location[$i + $userRowLength], strpos($location[$i + $userRowLength], ' '), strlen($location[$i + $userRowLength]) );


      }

          //copying products
    for ($copyStart = $j -1 , $copyMin = 1; $j < $number_of_notify; $j++, $copyMin++) { 
    	$resultNotify[$j-1][0] = $resultNotify[$copyMin][0]; 
        $resultNotify[$j-1][2] = $resultNotify[$copyMin][2]; 
        $resultNotify[$j-1][7] = $resultNotify[$copyMin][7];
        $resultNotify[$j-1][8] = $resultNotify[$copyMin][8];
        if ($copyMin >= $j) {
        	$copyMin = 1;
        }
    }

echo json_encode($resultNotify);
}


function wlsnProductManuallyGetDetails($type, $pro_ids, $buyers, $location){
global $resultNotify;
$j = 1;

$product_ids = explode(',', $pro_ids);
foreach ($product_ids as $val) {
$v = (int)$val;
$product = wc_get_product( $v );
//getting product details
  $resultNotify[$j][0] = $product->get_id();
  $resultNotify[$j][2] = get_the_post_thumbnail_url( $product->get_id(), 'post-thumbnail' );
  $resultNotify[$j][7] = $product->get_name();
  $resultNotify[$j][8] = get_permalink( $product->get_id() );
 // echo $resultNotify[$j][2];
  $j++;
}
  // Buyer and location names
    $names    = explode(',', $buyers);
    $loc = explode('__', $location);
      for ($i=1; $i < $j; $i++) { 
      //$resultNotify[$j][1] = $product_item['name'];
      $resultNotify[$i][3] = substr($names[$i], 0, strpos($names[$i], ' '));
      $resultNotify[$i][4] = substr($names[$i], strpos($names[$i], ' '), strlen($names[$i]) );
      $resultNotify[$i][5] = substr($loc[$i], 0, strpos($loc[$i], ','));
      $resultNotify[$i][6] = substr($loc[$i], strpos($loc[$i], ','), strlen($loc[$i]) );
      
    }
    //product repeats

    $jStart = $j - 1;
    if ($j<20) {

      for ( ;$j <=20; $j++, $jStart++) { 
        $resultNotify[$j][0] = $resultNotify[$jStart][0];
        $resultNotify[$j][2] = $resultNotify[$jStart][2];
        $resultNotify[$j][7] = $resultNotify[$jStart][7];
        $resultNotify[$j][8] = $resultNotify[$jStart][8];

      $resultNotify[$j][3] = substr($names[$j], 0, strpos($names[$j], ' '));
      $resultNotify[$j][4] = substr($names[$j], strpos($names[$j], ' '), strlen($names[$j]) );
      $resultNotify[$j][5] = substr($loc[$j], 0, strpos($loc[$j], ','));
      $resultNotify[$j][6] = substr($loc[$j], strpos($loc[$j], ','), strlen($loc[$j]) );
      
      if ($jStart >= $j - 1) {
        $jStart = $j - 1;
      }

      }
    }
   echo json_encode($resultNotify);
}
// ================================ Deleting table after uninstalling the plugin=======================//
register_deactivation_hook( __FILE__, 'wlsnRemoveDBTableOnUninstall' );
function wlsnRemoveDBTableOnUninstall() {
     global $wpdb;
     $table_name = $wpdb->prefix . 'woo_live_notify';
     $sql = "DROP TABLE IF EXISTS $table_name";
     $wpdb->query($sql);
     delete_option("my_plugin_db_version");
} 

// ============== Get last order id ==================//
function wlsngetLatestOrderIdCheck(){
  
$filters = array(
    'post_status' => 'any',
    'post_type' => 'shop_order',
    'posts_per_page' => 1,
    'paged' => 1,
    'orderby' => 'modified',
    'order' => 'DESC'
);

$loop = new WP_Query($filters);
global $resultNotify;
//result arrays
while ($loop->have_posts()) {
    $loop->the_post();
    $order = new WC_Order($loop->post->ID);
    foreach ($order->get_items() as $key => $product_item) {
      $resultNotify[0][0] = "latest-order-date-check";
      $resultNotify[0][1] = $order->order_date;
      $resultNotify[0][2] = date('m-d-Y h:i:s', time());
    }
  }
  echo json_encode($resultNotify);

}

// ============================== Check if new order recieved and get details ====================//
function wlsngetLatestOrderDetails(){
  
$latestOrderDate = esc_html($_POST['lastOrderTime']);
$filters = array(
    'post_status' => 'any',
    'post_type' => 'shop_order',
    'posts_per_page' => 1,
    'paged' => 1,
    'orderby' => 'modified',
    'order' => 'DESC'
);


$loop = new WP_Query($filters);
global $resultNotify;
//result arrays
while ($loop->have_posts()) {
    $loop->the_post();
    $order = new WC_Order($loop->post->ID);
    foreach ($order->get_items() as $key => $product_item) {
      //product details
     
      $resultNotify[1][0] = $product_item['product_id'];
      $resultNotify[1][1] = $product_item['name'];
      $featured_image     = wp_get_attachment_image_src( get_post_thumbnail_id($product_item['product_id']));
      $resultNotify[1][2] = $featured_image[0];
      $resultNotify[1][3] = $order->get_billing_first_name();
      $resultNotify[1][4] = $order->get_billing_last_name();
      $resultNotify[1][5] = $order->get_billing_city();
      $resultNotify[1][6] = $order->get_billing_state();
      $resultNotify[1][7] = get_the_title( $product_item['product_id'] );
      $resultNotify[1][8] = get_permalink($resultNotify[$j][0]);
      //order check.
      $resultNotify[1][15] = $order->order_date;
      $resultNotify[1][16] = date('m-d-Y h:i:s', time());
     
    }

  }
  
  $previousDate = new DateTime( $latestOrderDate );
  $nowDate      = new DateTime( $resultNotify[1][15] );
   
  if ( $nowDate > $previousDate ) {
    $resultNotify[1][14] = "yes";
  }
  else{
   $resultNotify[1][14] = "no";
  }
  
 echo json_encode($resultNotify);

}
// ===================== User cookies ====================//

function wlsnUserRowSave($len){
  $cookie_name = "userRow";
  if(isset($_COOKIE[$cookie_name])) {
    $cookie_value = $_COOKIE[$cookie_name];
    if ($cookie_value > $len) {
      $cookie_value = 0;
    }
    else{
      $cookie_value = $cookie_value + 4;
    }
    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
} else {
    $_COOKIE[$cookie_name] = 0;
}

return $_COOKIE[$cookie_name];
}
