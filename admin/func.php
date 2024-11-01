<?php
// ======================== Ajax recevied for setting 1 ============================//
add_action('wp_ajax_wlsn_update_setting', 'wlsnUpdateSetting');
function wlsnUpdateSetting(){
if (isset($_POST['settings'])) { // Setting style tab
  wlsnSettingUpdate1();
}
elseif (isset($_POST['layouts_tab'])) {
    wlsnLayoutsTabUpdate();
}
elseif (isset($_POST['position'])) {
    wlsnPositionTabUpdate();
}
elseif (isset($_POST['effects'])) {
    wlsneffectsTabUpdate();
}
elseif (isset($_POST['products'])) {
    wlsnProductsTabUpdate();
}
elseif (isset($_POST['commonSetting'])) {

    wlsnCommonSettingTabUpdate();

}
exit();
}

function wlsnSettingUpdate1(){
  if(isset($_POST['notification'], $_POST['bg_color'], $_POST['text_color'], $_POST['border_size'], $_POST['border_color'], $_POST['shadow'], $_POST['bg_image'], $_POST['bg_size'], $_POST['bg_grad'])){
    $notification = htmlspecialchars($_POST['notification']);
    $bg_color     = sanitize_text_field($_POST['bg_color']);
    $text_color   = sanitize_text_field($_POST['text_color']);
    $border_size  = sanitize_text_field($_POST['border_size']);
    $border_color = sanitize_text_field($_POST['border_color']);
    $shadow       = sanitize_text_field($_POST['shadow']);
    $bg_image     = sanitize_text_field($_POST['bg_image']);
    $bg_size      = sanitize_text_field($_POST['bg_size']);
   // $bg_grad      = sanitize_text_field($_POST['bg_grad']);

    //sending setting 1 details to database
    global $wpdb;
    $table_name = $wpdb->prefix . 'woo_live_notify';
    $update = "UPDATE $table_name SET notification = '$notification', bg_color = '$bg_color',
    text_color = '$text_color', border_size = '$border_size', border_color = '$border_color',
    shadow = '$shadow', bg_image = '$bg_image', bg_size = '$bg_size'   WHERE id = 1";
    $results = $wpdb->query( $update );
    echo "1";

    
  }
}
// ============================== Tab 2 update =========================//
function wlsnLayoutsTabUpdate(){
    if (isset($_POST['layouts_tab'], $_POST['notifyHTML'])) {
        //sending setting 2 details to database
        $notification = $_POST['notifyHTML'];
    global $wpdb;
    $table_name = $wpdb->prefix . 'woo_live_notify';
    $update = "UPDATE $table_name SET notification = '$notification' WHERE id = 1";
    $results = $wpdb->query( $update );
    echo "1";   
    }
}
// ============================== Tab 3 update =========================//
function wlsnPositionTabUpdate(){
    if (isset($_POST['position'])) {
        //sending setting 2 details to database
        $position = $_POST['position'];
    global $wpdb;
    $table_name = $wpdb->prefix . 'woo_live_notify';
    $update = "UPDATE $table_name SET position = '$position' WHERE id = 1";
    $results = $wpdb->query( $update );
    echo "1";   
    }
}
// ============================== Tab 4 update =========================//
function wlsneffectsTabUpdate(){
    if (isset($_POST['effects'])) {
        //sending setting 2 details to database
        $effects = $_POST['effects'];
    global $wpdb;
    $table_name = $wpdb->prefix . 'woo_live_notify';
    $update = "UPDATE $table_name SET effects = '$effects' WHERE id = 1";
    $results = $wpdb->query( $update );
    echo "1";   
    }
}

// ============================== Tab 4 update =========================//
function wlsnProductsTabUpdate(){
    if (isset($_POST['products'], $_POST['product_ids'],$_POST['buyerNames'],$_POST['buyerLocation'],$_POST['only_live_sale'] )) {
        //sending setting 2 details to database
        $products       = sanitize_text_field($_POST['products']);
        $product_ids    = sanitize_text_field($_POST['product_ids']);
        $buyerNames     = htmlspecialchars($_POST['buyerNames']);
        $buyerLocation  = htmlspecialchars($_POST['buyerLocation']);
        $onlyLiveSale   = sanitize_text_field($_POST['only_live_sale']);
    global $wpdb;
    $table_name = $wpdb->prefix . 'woo_live_notify';
    $update = "UPDATE $table_name SET product_option = '$products', product_ids = '$product_ids', buyer_names = '$buyerNames', location_names ='$buyerLocation', only_live_sale = '$onlyLiveSale' WHERE id = 1";
    $results = $wpdb->query( $update );
    echo "1";   
    }
}
// ============================== Tab 5 update =========================//
function wlsnCommonSettingTabUpdate(){
    if (isset($_POST['commonSetting'], $_POST['minMaxNotify'],$_POST['onScreen'],$_POST['afterNotify'],$_POST['beep'],$_POST['onMobile'], $_POST['inTime'], $_POST['notShow'] )) {
        //sending setting 5 details to database
        $minMaxNotify   = sanitize_text_field($_POST['minMaxNotify']);
        $onScreen       = sanitize_text_field($_POST['onScreen']);
        $afterNotify    = sanitize_text_field($_POST['afterNotify']);
        $beep           = sanitize_text_field($_POST['beep']);
        $onMobile       = sanitize_text_field($_POST['onMobile']);
        $inTime         = sanitize_text_field($_POST['inTime']);
        $notShow        = sanitize_text_field($_POST['notShow']);
    global $wpdb;
    $table_name = $wpdb->prefix . 'woo_live_notify';
    $update = "UPDATE $table_name SET number_of_notify = '$minMaxNotify', on_screen = '$onScreen', after_notify = '$afterNotify', beep ='$beep', on_mobile ='$onMobile', in_time = '$inTime', not_show = '$notShow'  WHERE id = 1";
    $results = $wpdb->query( $update );
   echo "1";       
    }


}




// ===================== Running orders count=================//
function wlsnGetOrdersCountFromStatus( $status ){
    global $wpdb;

    // We add 'wc-' prefix when is missing from order staus
    $status = 'wc-' . str_replace('wc-', '', $status);

    return $wpdb->get_var("
        SELECT count(ID)  FROM {$wpdb->prefix}posts WHERE post_status LIKE '$status' AND `post_type` LIKE 'shop_order'
    ");
}

// =========================== Get instock products ======================//
function wlsnGetInstockProductsCount(){
    global $wpdb;
    // The SQL query
    $result = $wpdb->get_col( "
        SELECT COUNT(p.ID)
        FROM {$wpdb->prefix}posts as p
        INNER JOIN {$wpdb->prefix}postmeta as pm ON p.ID = pm.post_id
        WHERE p.post_type LIKE '%product%'
        AND p.post_status LIKE 'publish'
        AND pm.meta_key LIKE '_stock_status'
        AND pm.meta_value LIKE 'instock'
    " );

    return reset($result);
}



