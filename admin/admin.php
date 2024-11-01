<?php
/*
** adding necessarey files
*/

include_once 'func.php';

function wooLiveSaleAdminFiles() {
    wp_enqueue_style('wooLiveSaleAdminFilesAnimateStyle', plugins_url('/css/animate.css', __FILE__));
    wp_enqueue_style('wooLiveSaleAdminFilesMainStyle', plugins_url('/css/style.css', __FILE__));
    wp_enqueue_style('wooLiveSaleAdminFilesFontAwesome', plugins_url('/font-awesome/css/font-awesome.min.css', __FILE__));
    wp_enqueue_script('wooLiveSaleAdminFilesCutomLogic', plugins_url('/js/logic.js',__FILE__ ));
    wp_enqueue_style('https://fonts.googleapis.com/css?family=Open+Sans:400,800');
}
add_action('admin_enqueue_scripts', 'wooLiveSaleAdminFiles');


//color picker
add_action( 'admin_enqueue_scripts', 'wooLiveSaleAdminColorPicker' );
function wooLiveSaleAdminColorPicker( $hook ) {

    if( is_admin() ) { 

        // Add the color picker css file       
        wp_enqueue_style( 'wp-color-picker' ); 

        // Include our custom jQuery file with WordPress Color Picker dependency
        wp_enqueue_script( 'wooLiveSalecustom-script-handle', plugins_url( 'js/custom-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true ); 
    }
}



/*Theme customize */
add_action( 'admin_menu', 'wooLiveSaleAdminPage' );

/**
 * Adds a new settings page under Setting menu
*/

function wooLiveSaleAdminPage() {
    add_options_page( __( 'Live Sale Admin' ), __( 'Woo Live Sale Notify' ), 'manage_options', 'wooLiveSaleAdminMainPage', 'wooLiveSaleAdminPageDisplay' );
}

/**
* Tabs Method 
*/
function wooLiveSaleAdminTabs( $current = 'first' ) {
    $tabs = array(
        'first'   => __( 'Style', 'plugin-textdomain' ), 
        'second'  => __( 'Layouts', 'plugin-textdomain' ),
        'third'  => __( 'Position', 'plugin-textdomain' ),
        'fourth'  => __( 'Effects', 'plugin-textdomain' ),
        'five'  => __( 'Products & Buyers', 'plugin-textdomain' ),
        'six'  => __( 'General Setting', 'plugin-textdomain' ),
    );
    $html = '<h2 class="wooLiveSalenav-tabnav-tab-wrapper">';
    foreach( $tabs as $tab => $name ){
        $class = ( $tab == $current ) ? 'nav-tab-active' : '';
        $html .= '<a class="nav-tab ' . esc_html($class) . '" href="?page=wooLiveSaleAdminMainPage&tab=' . esc_html($tab) . '">' . esc_html($name) . '</a>';
    }
    $html .= '</h2>';
    echo $html ;
}

function wooLiveSaleAdminPageDisplay(){
    ?>
    <div class="cont-p-dashboard">
        <div class="post_like_dislike_header wrap">Dashboard<span>Contact me for plugin/theme customization, start from $5. 
            <a href="https://www.fiverr.com/aliali44">Contact</a>
        </span>
    </div>
    <?php

    // ================== Tabs ========================//
    $tab = ( ! empty( $_GET['tab'] ) ) ? esc_attr( $_GET['tab'] ) : 'first';
    wooLiveSaleAdminTabs( $tab );


   // =========================== Tab 1 ========================//
    if ( $tab == 'first' ) {

        // Getting style tab setting details from the database
        global $wpdb;
        $table_name = $wpdb->prefix . 'woo_live_notify';
        $setting_style = $wpdb->get_row("SELECT * FROM $table_name WHERE id = '1' ");

        ?>
        <div class="woo-live-saleTabs woo-live-sale-firstTab">
            <div class="woo-left-col-sett woo-left-col-1">
                <table class="style-left-sett-tab">
                    <input type="text" class="setting-num hidden" value="1">
                    <tr>
                        <td class="label-woo-left">
                            Background color of the notificaiton
                        </td>
                        <td>
                            <input type="text" class='woo-bg-notify f-c-picker' value="<?php echo esc_html( $setting_style->bg_color ) ?>"/>
                        </td>
                        
                    </tr>
                    <tr>
                        <td class="label-woo-left">
                            Text color of the notification
                        </td>
                        <td>
                            <input type="text" class='woo-clr-notify f-c-picker' value="<?php echo esc_html( $setting_style->text_color ) ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-woo-left">
                            Set border size and border color
                        </td>
                        <td>
                            <input type="text" class="border-live-woo-notify" placeholder="e.g: 1" value="<?php echo esc_html( $setting_style->border_size ) ?>">
                            <span class="border-color-span">Set border color</span>
                            <input type="text" class='woo-border-color-notify f-c-picker' value="<?php echo esc_html( $setting_style->border_color ) ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-woo-left">
                            Want to show Box shadow
                        </td>
                        <td>
                            <label class="woo-live-switch woo-witch-boxshadow">
                              <input type="checkbox" value="<?php echo esc_html( $setting_style->shadow ) ?>" checked >
                              <span class="woo-live-slider woo-live-round"></span>
                          </label>
                      </td>
                  </tr>
                  <tr class="hide">
                    <td class="label-woo-left">
                        Notification Background image URL
                    </td>
                    <td>
                        <input type="text" class='woo-bg-image' placeholder="Background image URL" value="<?php echo esc_html( $setting_style->bg_image ) ?>"/>
                    </td>
                </tr>
                <tr class="hide">
                    <td class="label-woo-left">
                        Notification Background image size
                    </td>
                    <td>
                        <input type="text" class='woo-live-bg-size bg-img-size' placeholder="e.g: 100%" value="<?php echo esc_html( $setting_style->bg_size ) ?>"/>
                    </td>
                </tr>
                <tr class="hide">
                    <td class="label-woo-left">
                        Notification Gradient Background<a href="https://www.fiverr.com/aliali44"> Pro feature</a>
                        <span class="hidden sel-bg-grad"><?php echo esc_html( $setting_style->bg_gradient ) ?></span>
                    </td>
                    <td>
                        <div class="gradient-cont-live">
                            <div class="gradient-back-live"></div>
                            <input type="radio" name="grad-radio" gradient-color = "woo-lg-1" class="grad-input-radio" readonly="">
                        </div>
                        <div class="gradient-cont-live">
                            <div class="gradient-back-live"></div>
                            <input type="radio" name="grad-radio" gradient-color = "woo-lg-2" class="grad-input-radio">
                        </div>
                        <div class="gradient-cont-live">
                            <div class="gradient-back-live"></div>
                            <input type="radio" name="grad-radio" gradient-color = "woo-lg-3" class="grad-input-radio">
                        </div>
                        <div class="gradient-cont-live">
                            <div class="gradient-back-live"></div>
                            <input type="radio" name="grad-radio" gradient-color = "woo-lg-4" class="grad-input-radio">
                        </div>
                        <div class="gradient-cont-live">
                            <div class="gradient-back-live"></div>
                            <input type="radio" name="grad-radio" gradient-color = "woo-lg-5" class="grad-input-radio">
                        </div>
                        <div class="gradient-cont-live">
                            <div class="gradient-back-live"></div>
                            <input type="radio" name="grad-radio" gradient-color = "woo-lg-6" class="grad-input-radio">
                        </div>
                        <div class="gradient-cont-live">
                            <div class="gradient-back-live"></div>
                            <input type="radio" name="grad-radio" gradient-color = "woo-lg-7" class="grad-input-radio">
                        </div>
                        <div class="gradient-cont-live">
                            <div class="gradient-back-live"></div>
                            <input type="radio" name="grad-radio" gradient-color = "woo-lg-8" class="grad-input-radio">
                        </div>
                        <div class="gradient-cont-live">
                            <div class="gradient-back-live"></div>
                            <input type="radio" name="grad-radio" gradient-color = "woo-lg-9" class="grad-input-radio">
                        </div>
                        <div class="gradient-cont-live">
                            <div class="gradient-back-live"></div>
                            <input type="radio" name="grad-radio" gradient-color = "woo-lg-10" class="grad-input-radio">
                        </div>

                    </td>
                </tr>


            </table>


        </div>

        <div class="woo-left-col-sett woo-right-col-2">
            <!-- Pop up start-->
            <?php
            global $wpdb;
            $table_name = $wpdb->prefix . 'woo_live_notify';
            $notify_db_details = $wpdb->get_row("SELECT * FROM $table_name WHERE id = '1' ");
            echo htmlspecialchars_decode($notify_db_details->notification);
            ?>
            <!-- Pop up end -->

        </div>
        <div class="clear-fix">
        </div>
        <input type="button"  id="submit-1-tab" class="button button-primary btn-submit-lists" value="Save Changes">
    </div>
    

    <?php
}
    // =========================== Tab 2 ========================//
elseif($tab == 'second' ){
    ?>
    <div class="woo-live-saleTabs woo-live-sale-secondTab" id="sec-tab-det">
        <h2 class="s-header-1">Select a layout from pre made layouts</h2>
        <table class="tbl-notify-text-one">
         <tr>

            <div class="pop-up-list-layouts list-layouts-1">
               <!-- Pop up start-->
               <div class="woo-live-sale-pop-up woo-popup-2">
                <div class="woo-live-sale-product-pic" style="background-image:url(https://image.ibb.co/iceHYe/1.jpg)">

                </div>
                <div class="woo-live-sale-right-cont-pdetails">
                    <span class="cross-hide-live-sale">✕</span>
                    <div class="woo-live-sale-right-comp-text">
                        <span class="pop-up-p-name">Alaine Deland</span> in <span class="pop-up-area-name">Warner, NH</span> purchased a 
                    </div>
                    <div class="woo-live-sale-right-pr-off-name">
                        Men Boston Clear Sungla and Someting
                    </div>
                </div>
                <div class="clear-fix">
                </div>
                <div class="woo-live-sale-pr-sale-time">
                    5 hours ago
                </div>

            </div>

            <!-- Pop up end -->
            <div class="layout-label-input"><label>Select layout</label><input type="radio"></div>
        </div>

        <div class="pop-up-list-layouts list-layouts-1">
           <!-- Pop up start-->
           <div class="woo-live-sale-pop-up woo-popup-2">
            <div class="woo-live-sale-product-pic" style="background-image:url(https://image.ibb.co/iceHYe/1.jpg)">

            </div>
            <div class="woo-live-sale-right-cont-pdetails">
                <span class="cross-hide-live-sale">✕</span>
                <div class="woo-live-sale-right-comp-text">
                    <span class="pop-up-p-name">Someone</span> from <span class="pop-up-area-name">Warner, NH</span> purchased a 
                </div>
                <div class="woo-live-sale-right-pr-off-name">
                    Men Boston Clear Sungla and Someting
                </div>
            </div>
            <div class="clear-fix">
            </div>
            <div class="woo-live-sale-pr-sale-time">
                5 hours ago
            </div>

        </div>

        <!-- Pop up end -->
        <div class="layout-label-input"><label>Select layout</label><input type="radio">
        </div>

    </div>
    <!-- Pop up 3 -->
    <div class="pop-up-list-layouts list-layouts-1">
       <!-- Pop up start-->
       <div class="woo-live-sale-pop-up woo-popup-3">
        <div class="woo-live-sale-product-pic" style="background-image:url(https://image.ibb.co/iceHYe/1.jpg)">

        </div>
        <div class="woo-live-sale-right-cont-pdetails">
            <span class="cross-hide-live-sale">✕</span>
            <div class="woo-live-sale-right-comp-text">
                <span class="pop-up-p-name">Someone</span> from <span class="pop-up-area-name">Warner, NH</span> purchased a 
            </div>
            <div class="woo-live-sale-right-pr-off-name">
                Men Boston Clear Sungla and Someting
            </div>
        </div>
        <div class="clear-fix">
        </div>
        <div class="woo-live-sale-pr-sale-time">
            5 hours ago
        </div>

    </div>

    <!-- Pop up end -->
    <div class="layout-label-input"><label>Select layout</label><input type="radio">
    </div>

</div>

<!-- ================= Pop up 4 ======================== -->
<div class="pop-up-list-layouts list-layouts-1">
   <!-- Pop up start-->
   <div class="woo-live-sale-pop-up woo-popup-4">
    <div class="woo-live-sale-product-pic" style="background-image:url(https://image.ibb.co/iceHYe/1.jpg)">

    </div>
    <div class="woo-live-sale-right-cont-pdetails">
        <span class="cross-hide-live-sale">✕</span>
        <div class="woo-live-sale-right-comp-text">
            <span class="pop-up-p-name">Someone</span> from <span class="pop-up-area-name">Warner, NH</span> purchased a 
        </div>
        <div class="woo-live-sale-right-pr-off-name">
            Men Boston Clear Sungla and Someting
        </div>
    </div>
    <div class="clear-fix">
    </div>
    <div class="woo-live-sale-pr-sale-time">
        5 hours ago
    </div>

</div>

<!-- Pop up end -->
<div class="layout-label-input"><label>Select layout</label><input type="radio">
</div>

</div>
<!-- ================= Pop up 5 ======================== -->
<div class="pop-up-list-layouts list-layouts-1">
   <!-- Pop up start-->
   <div class="woo-live-sale-pop-up woo-popup-5">
    <div class="woo-live-sale-product-pic" style="background-image:url(https://image.ibb.co/iceHYe/1.jpg)">

    </div>
    <div class="woo-live-sale-right-cont-pdetails">
        <span class="cross-hide-live-sale">✕</span>
        <div class="woo-live-sale-right-comp-text">
            <span class="pop-up-p-name">Someone</span> from <span class="pop-up-area-name">Warner, NH</span> purchased a 
        </div>
        <div class="woo-live-sale-right-pr-off-name">
            Men Boston Clear Sungla and Someting
        </div>
    </div>
    <div class="clear-fix">
    </div>
    <div class="woo-live-sale-pr-sale-time">
        5 hours ago
    </div>

</div>

<!-- Pop up end -->
<div class="layout-label-input"><label>Select layout<a href="https://www.fiverr.com/aliali44">Pro feature</a></label><input type="radio" disabled>
</div>

</div>

<!-- ================= Pop up 6 ======================== -->
<div class="pop-up-list-layouts list-layouts-1">
   <!-- Pop up start-->
   <div class="woo-live-sale-pop-up woo-popup-6">
    <div class="woo-live-sale-product-pic" style="background-image:url(https://image.ibb.co/iceHYe/1.jpg)">

    </div>
    <div class="woo-live-sale-right-cont-pdetails">
        <span class="cross-hide-live-sale">✕</span>
        <div class="woo-live-sale-right-comp-text">
            <span class="pop-up-p-name">Someone</span> from <span class="pop-up-area-name">Warner, NH</span> purchased a 
        </div>
        <div class="woo-live-sale-right-pr-off-name">
            Men Boston Clear Sungla and Someting
        </div>
    </div>
    <div class="clear-fix">
    </div>
    <div class="woo-live-sale-pr-sale-time">
        5 hours ago
    </div>

</div>

<!-- Pop up end -->
<div class="layout-label-input"><label>Select layout<a href="https://www.fiverr.com/aliali44"> Pro feature</a></label><input type="radio" disabled>
</div>

</div>
<!-- ================= Pop up 7 ======================== -->
<div class="pop-up-list-layouts list-layouts-1">
   <!-- Pop up start-->
   <div class="woo-live-sale-pop-up woo-popup-7">
    <div class="woo-live-sale-product-pic" style="background-image:url(https://image.ibb.co/iceHYe/1.jpg)">

    </div>
    <div class="woo-live-sale-right-cont-pdetails">
        <span class="cross-hide-live-sale">✕</span>
        <div class="woo-live-sale-right-comp-text">
            <span class="pop-up-p-name">Someone</span> from <span class="pop-up-area-name">Warner, NH</span> purchased a 
        </div>
        <div class="woo-live-sale-right-pr-off-name">
            Men Boston Clear Sungla and Someting
        </div>
    </div>
    <div class="clear-fix">
    </div>
    <div class="woo-live-sale-pr-sale-time">
        5 hours ago
    </div>

</div>

<!-- Pop up end -->
<div class="layout-label-input"><label>Select layout <a href="https://www.fiverr.com/aliali44">Pro feature</a></label><input type="radio" disabled>
</div>

</div>
<!-- ================= Pop up 8 ======================== -->
<div class="pop-up-list-layouts list-layouts-1">
   <!-- Pop up start-->
   <div class="woo-live-sale-pop-up woo-popup-8">
    <div class="woo-live-sale-product-pic" style="background-image:url(https://image.ibb.co/iceHYe/1.jpg)">

    </div>
    <div class="woo-live-sale-right-cont-pdetails">
        <span class="cross-hide-live-sale">✕</span>
        <div class="woo-live-sale-right-comp-text">
            <span class="pop-up-p-name">Someone</span> from <span class="pop-up-area-name">Warner, NH</span> purchased a 
        </div>
        <div class="woo-live-sale-right-pr-off-name">
            Men Boston Clear Sungla and Someting
        </div>
    </div>
    <div class="clear-fix">
    </div>
    <div class="woo-live-sale-pr-sale-time">
        5 hours ago
    </div>

</div>

<!-- Pop up end -->
<div class="layout-label-input"><label>Select layout <a href="https://www.fiverr.com/aliali44">Pro feature</a></label><input type="radio" disabled>
</div>

</div>
<!-- ================= Pop up 9 ======================== -->
<div class="pop-up-list-layouts list-layouts-1">
   <!-- Pop up start-->
   <div class="woo-live-sale-pop-up woo-popup-9">
    <div class="woo-live-sale-product-pic" style="background-image:url(https://image.ibb.co/iceHYe/1.jpg)">

    </div>
    <div class="woo-live-sale-right-cont-pdetails">
        <span class="cross-hide-live-sale">✕</span>
        <div class="woo-live-sale-right-comp-text">
            <span class="pop-up-p-name">Someone</span> from <span class="pop-up-area-name">Warner, NH</span> purchased a 
        </div>
        <div class="woo-live-sale-right-pr-off-name">
            Men Boston Clear Sungla and Someting
        </div>
    </div>
    <div class="clear-fix">
    </div>
    <div class="woo-live-sale-pr-sale-time">
        5 hours ago
    </div>

</div>

<!-- Pop up end -->
<div class="layout-label-input"><label>Select layout <a href="https://www.fiverr.com/aliali44">Pro feature</a></label><input type="radio" disabled>
</div>

</div>
<!-- ================= Pop up 10 ======================== -->
<div class="pop-up-list-layouts list-layouts-1">
   <!-- Pop up start-->
   <div class="woo-live-sale-pop-up woo-popup-10">
    <div class="woo-live-sale-product-pic" style="background-image:url(https://image.ibb.co/iceHYe/1.jpg)">

    </div>
    <div class="woo-live-sale-right-cont-pdetails">
        <span class="cross-hide-live-sale">✕</span>
        <div class="woo-live-sale-right-comp-text">
            <span class="pop-up-p-name">Someone</span> from <span class="pop-up-area-name">Warner, NH</span> purchased a 
        </div>
        <div class="woo-live-sale-right-pr-off-name">
            Men Boston Clear Sungla and Someting
        </div>
    </div>
    <div class="clear-fix">
    </div>
    <div class="woo-live-sale-pr-sale-time">
        5 hours ago
    </div>

</div>

<!-- Pop up end -->
<div class="layout-label-input"><label>Select layout <a href="https://www.fiverr.com/aliali44">Pro feature</a></label><input type="radio" disabled>
</div>

</div>
<!-- ================= Pop up 11 ======================== -->
<div class="pop-up-list-layouts list-layouts-1">
   <!-- Pop up start-->
   <div class="woo-live-sale-pop-up woo-popup-11">
    <div class="woo-live-sale-product-pic" style="background-image:url(https://image.ibb.co/iceHYe/1.jpg)">

    </div>
    <div class="woo-live-sale-right-cont-pdetails">
        <span class="cross-hide-live-sale">✕</span>
        <div class="woo-live-sale-right-comp-text">
            <span class="pop-up-p-name">Someone</span> from <span class="pop-up-area-name">Warner, NH</span> purchased a 
        </div>
        <div class="woo-live-sale-right-pr-off-name">
            Men Boston Clear Sungla and Someting
        </div>
    </div>
    <div class="clear-fix">
    </div>
    <div class="woo-live-sale-pr-sale-time">
        5 hours ago
    </div>

</div>

<!-- Pop up end -->
<div class="layout-label-input"><label>Select layout <a href="https://www.fiverr.com/aliali44">Pro feature</a></label><input type="radio" disabled>
</div>

</div>
<!-- ================= Pop up 12 ======================== -->
<div class="pop-up-list-layouts list-layouts-1">
   <!-- Pop up start-->
   <div class="woo-live-sale-pop-up woo-popup-12">
    <div class="woo-live-sale-product-pic" style="background-image:url(https://image.ibb.co/iceHYe/1.jpg)">

    </div>
    <div class="woo-live-sale-right-cont-pdetails">
        <span class="cross-hide-live-sale">✕</span>
        <div class="woo-live-sale-right-comp-text">
            <span class="pop-up-p-name">Someone</span> from <span class="pop-up-area-name">Warner, NH</span> purchased a 
        </div>
        <div class="woo-live-sale-right-pr-off-name">
            Men Boston Clear Sungla and Someting
        </div>
    </div>
    <div class="clear-fix">
    </div>
    <div class="woo-live-sale-pr-sale-time">
        5 hours ago
    </div>

</div>

<!-- Pop up end -->
<div class="layout-label-input"><label>Select layout <a href="https://www.fiverr.com/aliali44">Pro feature</a></label><input type="radio" disabled>
</div>

</div>
<!-- ================= Pop up 13 ======================== -->
<div class="pop-up-list-layouts list-layouts-1">
   <!-- Pop up start-->
   <div class="woo-live-sale-pop-up woo-popup-13">
    <div class="woo-live-sale-product-pic" style="background-image:url(https://image.ibb.co/iceHYe/1.jpg)">
    </div>
    <div class="woo-live-sale-right-cont-pdetails">
        <span class="cross-hide-live-sale">✕</span>
        <div class="woo-live-sale-right-comp-text">
            <span class="pop-up-p-name">Someone</span> from <span class="pop-up-area-name">Warner, NH</span> purchased a 
        </div>
        <div class="woo-live-sale-right-pr-off-name">
            Men Boston Clear Sungla and Someting
        </div>
    </div>
    <div class="clear-fix">
    </div>
    <div class="woo-live-sale-pr-sale-time">
        5 hours ago
    </div>
</div>
<!-- Pop up end -->
<div class="layout-label-input"><label>Select layout <a href="https://www.fiverr.com/aliali44">Pro feature</a></label><input type="radio" disabled>
</div>
</div>
<!-- ================= Pop up 14 ======================== -->
<div class="pop-up-list-layouts list-layouts-1">
   <!-- Pop up start-->
   <div class="woo-live-sale-pop-up woo-popup-14">
    <div class="woo-live-sale-product-pic" style="background-image:url(https://image.ibb.co/iceHYe/1.jpg)">
    </div>
    <div class="woo-live-sale-right-cont-pdetails">
        <span class="cross-hide-live-sale">✕</span>
        <div class="woo-live-sale-right-comp-text">
            <span class="pop-up-p-name">Someone</span> from <span class="pop-up-area-name">Warner, NH</span> purchased a 
        </div>
        <div class="woo-live-sale-right-pr-off-name">
            Men Boston Clear Sungla and Someting
        </div>
    </div>
    <div class="clear-fix">
    </div>
    <div class="woo-live-sale-pr-sale-time">
        5 hours ago
    </div>
</div>
<!-- Pop up end -->
<div class="layout-label-input"><label>Select layout</label><input type="radio" disabled>
</div>
</div>
<!-- ================= Pop up 15 ======================== -->
<div class="pop-up-list-layouts list-layouts-1">
   <!-- Pop up start-->
   <div class="woo-live-sale-pop-up woo-popup-15">
    <div class="woo-live-sale-product-pic" style="background-image:url(https://image.ibb.co/iceHYe/1.jpg)">
    </div>
    <div class="woo-live-sale-right-cont-pdetails">
        <span class="cross-hide-live-sale">✕</span>
        <div class="woo-live-sale-right-comp-text">
            <span class="pop-up-p-name">Someone</span> from <span class="pop-up-area-name">Warner, NH</span> purchased a 
        </div>
        <div class="woo-live-sale-right-pr-off-name">
            Men Boston Clear Sungla and Someting
        </div>
    </div>
    <div class="clear-fix">
    </div>
    <div class="woo-live-sale-pr-sale-time">
        5 hours ago
    </div>
</div>
<!-- Pop up end -->
<div class="layout-label-input"><label>Select layout <a href="https://www.fiverr.com/aliali44">Pro feature</a></label><input type="radio" disabled>
</div>
</div>
<!-- ================= Pop up 16 ======================== -->
<div class="pop-up-list-layouts list-layouts-1">
   <!-- Pop up start-->
   <div class="woo-live-sale-pop-up woo-popup-16">
    <div class="woo-live-sale-product-pic" style="background-image:url(https://image.ibb.co/iceHYe/1.jpg)">
    </div>
    <div class="woo-live-sale-right-cont-pdetails">
        <span class="cross-hide-live-sale">✕</span>
        <div class="woo-live-sale-right-comp-text">
            <span class="pop-up-p-name">Someone</span> from <span class="pop-up-area-name">Warner, NH</span> purchased a 
        </div>
        <div class="woo-live-sale-right-pr-off-name">
            Men Boston Clear Sungla and Someting
        </div>
    </div>
    <div class="clear-fix">
    </div>
    <div class="woo-live-sale-pr-sale-time">
        5 hours ago
    </div>
</div>
<!-- Pop up end -->
<div class="layout-label-input"><label>Select layout</label><input type="radio" disabled>
</div>
</div>
<!-- ================= Pop up 17 ======================== -->
<div class="pop-up-list-layouts list-layouts-1">
   <!-- Pop up start-->
   <div class="woo-live-sale-pop-up woo-popup-17">
    <div class="woo-live-sale-product-pic" style="background-image:url(https://image.ibb.co/iceHYe/1.jpg)">
    </div>
    <div class="woo-live-sale-right-cont-pdetails">
        <span class="cross-hide-live-sale">✕</span>
        <div class="woo-live-sale-right-comp-text">
            <span class="pop-up-p-name">Someone</span> from <span class="pop-up-area-name">Warner, NH</span> purchased a 
        </div>
        <div class="woo-live-sale-right-pr-off-name">
            Men Boston Clear Sungla and Someting
        </div>
    </div>
    <div class="clear-fix">
    </div>
    <div class="woo-live-sale-pr-sale-time">
        5 hours ago
    </div>
</div>
<!-- Pop up end -->
<div class="layout-label-input"><label>Select layout <a href="https://www.fiverr.com/aliali44https://www.fiverr.com/aliali44">Pro feature</a></label><input type="radio" disabled>
</div>
</div>
<!-- ================= Pop up 18 ======================== -->
<div class="pop-up-list-layouts list-layouts-1">
   <!-- Pop up start-->
   <div class="woo-live-sale-pop-up woo-popup-18">
    <div class="woo-live-sale-product-pic" style="background-image:url(https://image.ibb.co/iceHYe/1.jpg)">
    </div>
    <div class="woo-live-sale-right-cont-pdetails">
        <span class="cross-hide-live-sale">✕</span>
        <div class="woo-live-sale-right-comp-text">
            <span class="pop-up-p-name">Someone</span> from <span class="pop-up-area-name">Warner, NH</span> purchased a 
        </div>
        <div class="woo-live-sale-right-pr-off-name">
            Men Boston Clear Sungla and Someting
        </div>
    </div>
    <div class="clear-fix">
    </div>
    <div class="woo-live-sale-pr-sale-time">
        5 hours ago
    </div>
</div>
<!-- Pop up end -->
<div class="layout-label-input"><label>Select layout <a href="https://www.fiverr.com/aliali44">Pro feature</a></label><input type="radio" disabled>
</div>
</div>
<!-- ================= Pop up 19 ======================== -->
<div class="pop-up-list-layouts list-layouts-1">
   <!-- Pop up start-->
   <div class="woo-live-sale-pop-up woo-popup-19">
    <div class="woo-live-sale-product-pic" style="background-image:url(https://image.ibb.co/iceHYe/1.jpg)">
    </div>
    <div class="woo-live-sale-right-cont-pdetails">
        <span class="cross-hide-live-sale">✕</span>
        <div class="woo-live-sale-right-comp-text">
            <span class="pop-up-p-name">Someone</span> from <span class="pop-up-area-name">Warner, NH</span> purchased a 
        </div>
        <div class="woo-live-sale-right-pr-off-name">
            Men Boston Clear Sungla and Someting
        </div>
    </div>
    <div class="clear-fix">
    </div>
    <div class="woo-live-sale-pr-sale-time">
        5 hours ago
    </div>
</div>
<!-- Pop up end -->
<div class="layout-label-input"><label>Select layout <a href="https://www.fiverr.com/aliali44">Pro feature</a></label><input type="radio" disabled>
</div>
</div>
<!-- ================= Pop up 20 ======================== -->
<div class="pop-up-list-layouts list-layouts-1">
   <!-- Pop up start-->
   <div class="woo-live-sale-pop-up woo-popup-20">
    <div class="woo-live-sale-product-pic" style="background-image:url(https://image.ibb.co/iceHYe/1.jpg)">
    </div>
    <div class="woo-live-sale-right-cont-pdetails">
        <span class="cross-hide-live-sale">✕</span>
        <div class="woo-live-sale-right-comp-text">
            <span class="pop-up-p-name">Someone</span> from <span class="pop-up-area-name">Warner, NH</span> purchased a 
        </div>
        <div class="woo-live-sale-right-pr-off-name">
            Men Boston Clear Sungla and Someting
        </div>
    </div>
    <div class="clear-fix">
    </div>
    <div class="woo-live-sale-pr-sale-time">
        5 hours ago
    </div>
</div>
<!-- Pop up end -->
<div class="layout-label-input"><label>Select layout <a href="https://www.fiverr.com/aliali44">Pro feature</a></label><input type="radio" disabled>
</div>
</div>
<!-- ================= Pop up 21 ======================== -->
<div class="pop-up-list-layouts list-layouts-1">
   <!-- Pop up start-->
   <div class="woo-live-sale-pop-up woo-popup-21">
    <div class="woo-live-sale-product-pic" style="background-image:url(https://image.ibb.co/iceHYe/1.jpg)">
    </div>
    <div class="woo-live-sale-right-cont-pdetails">
        <span class="cross-hide-live-sale">✕</span>
        <div class="woo-live-sale-right-comp-text">
            <span class="pop-up-p-name">Someone</span> from <span class="pop-up-area-name">Warner, NH</span> purchased a 
        </div>
        <div class="woo-live-sale-right-pr-off-name">
            Men Boston Clear Sungla and Someting
        </div>
    </div>
    <div class="clear-fix">
    </div>
    <div class="woo-live-sale-pr-sale-time">
        5 hours ago
    </div>
</div>
<!-- Pop up end -->
<div class="layout-label-input"><label>Select layout <a href="https://www.fiverr.com/aliali44">Pro feature</a></label><input type="radio" disabled>
</div>
</div>
<!-- ================= Pop up 22 ======================== -->
<div class="pop-up-list-layouts list-layouts-1">
   <!-- Pop up start-->
   <div class="woo-live-sale-pop-up woo-popup-22">
    <div class="woo-live-sale-product-pic" style="background-image:url(https://image.ibb.co/iceHYe/1.jpg)">
    </div>
    <div class="woo-live-sale-right-cont-pdetails">
        <span class="cross-hide-live-sale">✕</span>
        <div class="woo-live-sale-right-comp-text">
            <span class="pop-up-p-name">Someone</span> from <span class="pop-up-area-name">Warner, NH</span> purchased a 
        </div>
        <div class="woo-live-sale-right-pr-off-name">
            Men Boston Clear Sungla and Someting
        </div>
    </div>
    <div class="clear-fix">
    </div>
    <div class="woo-live-sale-pr-sale-time">
        5 hours ago
    </div>
</div>
<!-- Pop up end -->
<div class="layout-label-input"><label>Select layout <a href="https://www.fiverr.com/aliali44">Pro feature</a></label><input type="radio" disabled>
</div>
</div>

</td>
</tr>
</table>
<br>

<input type="button"  id="submit-2-tab" class="button button-primary btn-submit-lists" value="Save Changes">
</div>
<?php

}
     // =========================== Tab 3 ========================//
elseif($tab == 'third' ){
    global $wpdb;
    $table_name = $wpdb->prefix . 'woo_live_notify';
    $postion_get = $wpdb->get_row("SELECT position FROM $table_name WHERE id = '1' ");
    $pos_1 = $pos_2 = $pos_3 = $pos_4 = "";
    $pos = trim($postion_get->position);

    if ($pos =="1") {
        $pos_1 = "checked";
    }
    elseif ($pos =="2") {
        $pos_2 = "checked";
    }
    elseif ($pos =="3") {
        $pos_3 = "checked";
    }
    elseif ($pos =="4") {
        $pos_4 = "checked";
    }
    ?>
    <div class="woo-live-saleTabs woo-live-sale-thirdTab">
        <table class="tbl-3-sett">
            <tr>
                <td>
                    <img src="https://image.ibb.co/epGz7z/bottom_left_show.jpg">
                    <div class="r-show-images">
                        <label>Bottom left</label>
                        <input type="radio" value="1"  name="position" class="r-img-show r-img-show-b-left" <?php echo $pos_1 ?>>
                    </div>

                </td>
                <td>
                    <img src="https://image.ibb.co/jMyJ0K/bottom_right_show.jpg">
                    <div class="r-show-images">
                        <label>Bottom right</label>
                        <input type="radio" value="2" name="position" class="r-img-show r-img-show-b-left" <?php echo $pos_2 ?>>
                    </div>

                </td>
            </tr>
            <tr>
                <td>
                    <img src="https://image.ibb.co/dBST0K/top_left_show.jpg">
                    <div class="r-show-images">
                        <label>Top left</label>
                        <input type="radio" value="3" name="position" class="r-img-show r-img-show-b-left" <?php echo $pos_3 ?>>
                    </div>

                </td>
                <td>
                    <img src="https://image.ibb.co/hZZVEe/top_right_show.jpg">
                    <div class="r-show-images">
                        <label>Top right</label>
                        <input type="radio" value="4" name="position" class="r-img-show r-img-show-b-left" <?php echo $pos_4 ?>>
                    </div>

                </td>
            </tr>
        </table>
        <input type="button"  id="submit-3-tab" class="button button-primary btn-submit-lists" value="Save Changes">
    </div>

    <?php
}
     // =========================== Tab 4 ========================//
elseif($tab == 'fourth' ){
  global $wpdb;
  $table_name = $wpdb->prefix . 'woo_live_notify';
  $effects_get = $wpdb->get_row("SELECT effects FROM $table_name WHERE id = '1' ");
  $effect_1 = $effect_2 = $effect_3 = $effect_4 = "";
  $effects = esc_html(trim($effects_get->effects));


  if ($effects =="1") {
    $effect_1 = "checked";
}
elseif ($effects =="2") {
    $effect_2 = "checked";
}
elseif ($effects =="3") {
    $effect_3 = "checked";
}
elseif ($effects =="4") {
    $effect_4 = "checked";
}
?>

<div class="woo-live-saleTabs woo-live-fourths">
    <div class="effects-list-woo">
        <label>Bounce effects </label>
        <label class="woo-live-switch woo-witch-boxshadow">
          <input type="checkbox"  label-show="animated bounceInUp" effects-id="1" label-hide="animated bounceOut" <?php echo $effect_1 ?>>
          <span class="woo-live-slider woo-live-round"></span>
      </label>
  </div>
  <div class="effects-list-woo">
    <label>Fade effects </label>
    <label class="woo-live-switch woo-witch-boxshadow">
      <input type="checkbox"  label-show="animated fadeInUp" effects-id="2" label-hide="animated fadeOutDown" <?php echo $effect_2 ?>>
      <span class="woo-live-slider woo-live-round"></span>
  </label>
</div>
<div class="effects-list-woo">
    <label>Slide effects &nbsp;&nbsp;&nbsp;</label>
    <label class="woo-live-switch woo-witch-boxshadow">
      <input type="checkbox"  label-show="animated slideInUp" effects-id="3" label-hide="animated slideOutDown" <?php echo $effect_3 ?>>
      <span class="woo-live-slider woo-live-round"></span>
  </label>
</div>
<div class="effects-list-woo">
    <label>Jack effects </label>
    <label class="woo-live-switch woo-witch-boxshadow" >
      <input type="checkbox"  label-show="animated jackInTheBox" effects-id="4" label-hide="animated zoomOutDown" <?php echo $effect_4 ?>>
      <span class="woo-live-slider woo-live-round"></span>
  </label>
</div>





<!-- Pop up start-->
<div class="woo-live-sale-pop-up live-pop-up-4">
    <div class="woo-live-sale-product-pic" style="background-image:url(https://image.ibb.co/iceHYe/1.jpg)">

    </div>
    <div class="woo-live-sale-right-cont-pdetails">
        <span class="cross-hide-live-sale">✕</span>
        <div class="woo-live-sale-right-comp-text">
            Alaine Deland in Warner, NH purchased a 
        </div>
        <div class="woo-live-sale-right-pr-off-name">
            Men Boston Clear Sungla and Someting
        </div>
    </div>
    <div class="clear-fix">
    </div>
    <div class="woo-live-sale-pr-sale-time">
        5 hours ago
    </div>

</div>
<!-- Pop up end -->

<input type="button"  id="submit-4-tab" class="button button-primary btn-submit-lists" value="Save Changes">
</div>

<?php
}
         // =========================== Tab 5 ========================//
elseif($tab == 'five' ){
  global $wpdb;
  $table_name = $wpdb->prefix . 'woo_live_notify';
  $effects_get = $wpdb->get_row("SELECT product_option, product_ids, buyer_names, location_names, only_live_sale FROM $table_name WHERE id = '1' ");
  $effect_1 = $effect_2 = $effect_3 = $effect_4 = "";
  $effects = esc_html(trim($effects_get->product_option));
  $productIds = esc_html(trim($effects_get->product_ids));
  $buyerNames = htmlspecialchars_decode($effects_get->buyer_names);
  $buyerLoc = htmlspecialchars_decode($effects_get->location_names);
  $display_pro_ids = "";
  $onlyLiveSales = "";

  if ($effects =="running-orders") {
    $effect_1 = "checked";
}
elseif ($effects =="completed-orders") {
    $effect_2 = "checked";
}
elseif ($effects =="product-stock") {
    $effect_3 = "checked";
}
elseif ($effects =="pro-manually") {
    $effect_4 = "checked";
    $display_pro_ids = "table-row";
}
if ($effects_get->only_live_sale == "1") {
    $onlyLiveSales = "checked";
}
?>

<div class="woo-live-saleTabs woo-live-sale-secondTab">
    <h2 class="s-header-1">Select Products</h2>
    <table class="settings-tbls settings-2-tbl">
        <tr>
            <td class="lbl-left-woo-live-stt">
                Show products from Running, Pending, On hold, Processing orders
            </td>
            <td class="input-text-left-woo-live-stt">
                <label class="woo-live-switch show-rand-pr-woo">
                  <input type="checkbox" value="running-orders" <?php echo $effect_1 ?>>
                  <span class="woo-live-slider woo-live-round"></span>
              </label>
              <span class="order-status">
                  <?php 
                  if ($effect_1 == "checked") {
                     $pending_counts      = wlsnGetOrdersCountFromStatus( "pending" ); 
                     $processing_counts   = wlsnGetOrdersCountFromStatus( "processing" );
                     $onhold_counts       = wlsnGetOrdersCountFromStatus( "on-hold" );
                     $total_pro_counts    = $pending_counts + $processing_counts + $onhold_counts; 

                     if ($total_pro_counts <= 0) {
                       echo "No running orders. <a href='https://layerdeveloper.com/portfolio/woo-live-sale/#no-running' target='_blank'>Learn More</a>";
                   }
                   elseif ($total_pro_counts < 20) {
                     echo "Less than 20 orders <a href='https://layerdeveloper.com/portfolio/woo-live-sale/#completed-orders' target='_blank'><b>Learn More</b></a> ";
                 }  
             }

             ?>
         </span>
     </td>
 </tr>
 <tr>
    <td class="lbl-left-woo-live-stt">
        Show products from completed orders
    </td>
    <td class="input-text-left-woo-live-stt">
        <label class="woo-live-switch show-rand-pr-woo">
          <input type="checkbox" value="completed-orders" <?php echo $effect_2 ?>>
          <span class="woo-live-slider woo-live-round"></span>
      </label>
      <span class="order-status">
          <?php 
          if ($effect_2 == "checked") {
             $total_pro_counts      = wlsnGetOrdersCountFromStatus( "completed" ); 
             if ($total_pro_counts <= 0) {
               echo "No completed orders. ";
           }
           elseif ($total_pro_counts < 20) {
             echo "Less than 20 completed orders <a href='https://layerdeveloper.com/portfolio/woo-live-sale/#completed-orders' target='_blank'><b>Learn More</b></a> ";
         }  
     }

     ?>
 </span>
</td>
</tr>
<tr>
    <td class="lbl-left-woo-live-stt">
        Show products from product stock
    </td>
    <td class="input-text-left-woo-live-stt p-sto-sho">
        <label class="woo-live-switch show-rand-pr-woo">
          <input type="checkbox"  value="product-stock" <?php echo $effect_3 ?>>
          <span class="woo-live-slider woo-live-round"></span>
      </label>
      <span class="order-status">
          <?php 
          if ($effect_3 == "checked") {
              $total_pro_recevie = wlsnGetInstockProductsCount();
              if ($total_pro_recevie <= 20) {
                // echo "Less than 20 products <a href='https://layerdeveloper.com/portfolio/woo-live-sale/#less-products' target='_blank'><b>Learn More</b></a>";
             }

         }

         ?>
     </span>

 </td>
</tr>
<tr>
    <td class="lbl-left-woo-live-stt">
        I want to choose products manaully
    </td>
    <td class="input-text-left-woo-live-stt id-pro-man">
        <label class="woo-live-switch show-rand-pr-woo">
          <input type="checkbox"  value="pro-manually" <?php echo $effect_4 ?>>
          <span class="woo-live-slider woo-live-round"></span>
      </label>
  </td>
</tr>
<tr class="p-id-speci" style="display: <?php echo $display_pro_ids?>">
    <td class="lbl-left-woo-live-stt">
        Show specific products
    </td>
    <td>
        <textarea class="woo-live-texareas random-pro-ids-live" placeholder="Enter product id's seperated by commas"><?php echo $productIds;?></textarea><br>
        <a href="https://layerdeveloper.com/portfolio/woo-live-sale/#specific-products" target="_blank">Learn More</a>
        
    </td>
</tr>
<tr>
    <td class="lbl-left-woo-live-stt">
        Want to show only live sales
    </td>
    <td class="input-text-left-woo-live-stt woo-live-sale-last">
        <label class="woo-live-switch show-rand-pr-woo">
          <input type="checkbox"  value="" <?php echo $onlyLiveSales ?>>
          <span class="woo-live-slider woo-live-round"></span>
      </label>
  </td>
</tr>

</table>
<h2 class="s-header-1">Buyer details</h2>
<b><h3>&nbsp;&nbsp;Buyer names and buyer location </h3></b>
<table class="width-100-woo buy-det-list">
 <tr>
    <td>
        <textarea class="woo-text-are-live woo-in-txt-buyer-names" placeholder="Enter buyer names, one name on each line">
            <?php echo str_replace('<br/>', "\n", $buyerNames); ?></textarea>


            <textarea class="woo-text-are-live woo-in-txt-area-names" placeholder="Enter buyer area names, one area name on each line">
                <?php echo  str_replace('<br/>', "\n", $buyerLoc);?></textarea>
            </td>
        </tr>
    </table>
    <input type="button"  id="submit-5-tab" class="button button-primary btn-submit-lists" value="Save Changes">
</div>
<?php
}
     // =========================== Tab 6 ========================//
elseif($tab == 'six' ){
    global $wpdb;
    $table_name = $wpdb->prefix . 'woo_live_notify';
    $general_setting = $wpdb->get_row("SELECT number_of_notify, on_screen, after_notify, beep, on_mobile, in_time, not_show FROM $table_name WHERE id = '1' ");
    $min_max_notify = $general_setting->number_of_notify;
    $min_notify = substr($min_max_notify, 0, strpos($min_max_notify, ',')); 
    $max_notify = substr($min_max_notify, strpos($min_max_notify, ',')+1, strlen($min_max_notify) );
    $min_notify = trim($min_notify);
    $max_notify = trim($max_notify);
    $on_screen = $general_setting->on_screen;
    //after notification
    $after_notify = $general_setting->after_notify;
    $after_notify_min = substr($after_notify, 0, strpos($after_notify, ',')); 
    $after_notify_max = substr($after_notify, strpos($after_notify, ',')+1, strlen($after_notify) );
    $after_notify_min = trim($after_notify_min);
    $after_notify_max = trim($after_notify_max);
    //beep
    $beep = trim($general_setting->beep);
    //on mobile 
    $on_mobile = trim($general_setting->on_mobile);
    //in time 
    $inTime = $general_setting->in_time;
    $inTime1 = $inTime2 = $inTime3 = "";
    if ($inTime == "1") {
        $inTime1 = "checked";
    }
    elseif ($inTime == "2") {
        $inTime2 = "checked";
    }
    elseif ($inTime == "3") {
        $inTime3 = "checked";
    }

    //Not show on these pages
    $notShow = esc_html($general_setting->not_show);

    ?>
    <div class="woo-live-saleTabs woo-live-sale-thirdTab">
     <table class="settings-tbls settings-3-tbl">
        <tr>
            <td class="lbl-left-woo-live-stt">
                Minimum and maximum number of notifications on each page
            </td>
            <td class="input-text-left-woo-live-stt">
                <input type="text" class="woo-min-pr-live pr-inputs-small" value="<?php echo esc_attr($min_notify); ?>"><span> To </span>
                <input type="text" class="woo-max-pr-live pr-inputs-small" value="<?php echo esc_attr($max_notify); ?>"><span> Notifications </span>
            </td>
        </tr>
        <tr>
            <td class="lbl-left-woo-live-stt">
                Number of seconds the notification will be availabe on the screen
            </td>
            <td class="input-text-left-woo-live-stt">
                <input type="text" class="woo-timeafter-pr-live pr-inputs-small" value="<?php echo esc_attr($on_screen)?>">
                <span> Seconds</span>
            </td>
        </tr>
        <tr>
            <td class="lbl-left-woo-live-stt">
                Show each notifcation after
            </td>
            <td class="input-text-left-woo-live-stt">
                <input type="text" class="woo-min-pr-each pr-inputs-small" value="<?php echo esc_attr($after_notify_min) ?>"><span> To </span>
                <input type="text" class="woo-max-pr-each pr-inputs-small" value="<?php echo esc_attr($after_notify_max) ?>"> <span> Seconds</span>
            </td>
        </tr>
        <tr>
            <td>
                Display time on the notification in 
            </td>
            <td>
                <table>
                    <tr>
                        <td>
                            <label>Random hours from 1 to 5 <i>e.g <b><br/>2 hours ago</b></i></label><br/><br/>
                            <input type="radio" name="r-time-in" value="1" class="" <?php echo $inTime1; ?>>
                        </td>
                        <td>
                            <label>Random minutes from 1 to 30 <i>e.g <b><br/>10 minutes ago</b></i></label><br/><br/>
                            <input type="radio" name="r-time-in" value="2" class="" <?php echo $inTime2; ?>>
                        </td>
                        <td>
                            <label>Now <i>e.g <b><br/>Now</b></i></label><br/><br/>
                            <input type="radio" name="r-time-in" value="3" class="" <?php echo $inTime3; ?>>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
               Notification does not show on these pages    
            </td>
            <td class="not-show-cont">
                <label>Home page</label>
                <input type="checkbox" name="not-show-notify" value="home" <?php if (strpos($notShow, 'home') !== false) {echo 'checked';} ?>>
                <label>Cart</label>
                <input type="checkbox" name="not-show-notify" value="cart" <?php if (strpos($notShow, 'cart') !== false) {echo 'checked';} ?>>
                <label>Checkout</label>
                <input type="checkbox" name="not-show-notify" value="checkout" <?php if (strpos($notShow, 'checkout') !== false) {echo 'checked';} ?>>
                <label>My Accout</label>
                <input type="checkbox" name="not-show-notify" value="account" <?php if (strpos($notShow, 'account') !== false) {echo 'checked';} ?>>
                <label>Blog</label>
                <input type="checkbox" name="not-show-notify" value="blog" <?php if (strpos($notShow, 'blog') !== false) {echo 'checked';} ?>>
            </td>
            
        </tr>
        <tr>
            <td class="lbl-left-woo-live-stt">
                Notification beep?
            </td>
            <td class="">
               <label class="woo-live-switch woo-show-notify-beep">
                  <input type="checkbox" <?php if($beep=="1")echo "checked"; ?>>
                  <span class="woo-live-slider woo-live-round"></span>
              </label>
          </td>
      </tr>
      <tr>
        <td class="lbl-left-woo-live-stt">
            Show on the mobile
        </td>
        <td class="">
           <label class="woo-live-switch woo-show-on-mbl-live">
              <input type="checkbox"  <?php if($on_mobile == "1"){ echo "checked";} ?>>
              <span class="woo-live-slider woo-live-round"></span>
          </label>
      </td>
  </tr>
</table>
<input type="button"  id="submit-6-tab" class="button button-primary btn-submit-lists" value="Save Changes">
</div>
<?php
}
}