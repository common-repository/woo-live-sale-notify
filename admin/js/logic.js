jQuery(document).ready(function( $ ) {

	// Removing box shadow
	$('.woo-witch-boxshadow input').click(function(){
		 if($(this).is(':checked')) {
		 	//$('.woo-live-sale-pop-up').removeAttr('style');
		 	//$('.woo-live-sale-pop-up').css('box-shadow', '0px 2px 10px 0px #d5d5d5);
		 	$('.woo-live-sale-pop-up').css('-webkit-box-shadow', '0px 2px 10px 0px #d5d5d5');
            $('.woo-live-sale-pop-up').css('-moz-box-shadow', '0px 2px 10px 0px #d5d5d5');
            $('.woo-live-sale-pop-up').css('box-shadow', '0px 2px 10px 0px #d5d5d5');

            $('.woo-witch-boxshadow input').val("0px 2px 10px 0px #d5d5d5");
		 	
		 }
		 else{
		 	$('.woo-live-sale-pop-up').css('box-shadow', 'none');
		 	$('.woo-witch-boxshadow input').val("");
		 }

	});//End removing box shadow	

	//Border size of the notify
	$('.border-live-woo-notify').change(function(){
		var bgIBorderSize = $(this).val();
		console.log(bgIBorderSize);
		$('.woo-live-sale-pop-up').css({"border-color": "black", 
             "border-width":bgIBorderSize, 
             "border-style":"solid"});

	});

	//Background image change of the notify
	$('.woo-bg-image').change(function(){
		var bgImage = $(this).val();
		$('.woo-live-sale-pop-up').css("background-image", "url("+bgImage+")");

	});

	//Background image size change of the notify
	$('.woo-live-bg-size').change(function(){
		var bgSize = $(this).val();
		$('.woo-live-sale-pop-up').css("background-size", bgSize);

	});


//Gradient background change
$('.grad-input-radio').change(function(){
if (this.checked){
	var bgGradient = $(this).attr('gradient-color');
	$('.woo-live-sale-pop-up').removeAttr('id');
	$('.woo-live-sale-pop-up').attr('id', bgGradient);
}
});

// Show and hide effect list
$('.woo-live-fourths .effects-list-woo input').change(function(){
	$('.woo-live-fourths .effects-list-woo input').prop('checked', false);
	$(this).prop('checked', true);
if (this.checked){
	popUpShowHideEffects($(this).attr('label-show'), $(this).attr('label-hide'));
}
});

// Layout texatarea 
$('.woo-inputs-textarea-product-text texatarea').keyup(function () {

});

// =================== Show hide method ===============//
function popUpShowHideEffects(show, hide){
$('.live-pop-up-4').hide();
$('.live-pop-up-4').removeAttr('class').addClass("woo-live-sale-pop-up live-pop-up-4 "+show).show();
window.setInterval(function(){
  /// call your function here
}, 5000);
}

//Choose product id's manually
$('.id-pro-man input').change(function(){
if (this.checked){
	$('.settings-2-tbl input').prop('checked', false);
	$(this).prop('checked', true);
	$('.p-id-speci').css("display", "table-row");
	//$('.settings-2-tbl')
}
else{
$('.p-id-speci').css("display", "none");	
$('.p-sto-sho input').prop('checked', true);
}
});


// ========================== Ajax Call updating setting 1============================//
$('#submit-1-tab').click(function(){
	$('#submit-1-tab').css("opacity", "0.2");
	var settings = $('.setting-num').val();
	if (settings =="1") {
    var notification = bg_color = text_color = border_size = border_color = shadow = bg_image = bg_size = bg_grad = "";
    
    notification = $('.woo-right-col-2').html();
    notification = notification.replace(/\s+/g, " ").trim();
    bg_color = $('.woo-bg-notify').val();
    text_color = $('.woo-clr-notify').val();
    border_color = $('.woo-border-color-notify').val();

    if ($('.border-live-woo-notify').val()!="") {
    border_size = $('.border-live-woo-notify').val();	
    }else{
    	border_size = "0";
    }
    if ($('.woo-witch-boxshadow input').val() != "") {
    shadow = $('.woo-witch-boxshadow input').val();	
    }else{
    	shadow = "0px 2px 10px 0px #d5d5d5";
    }
    if ($('.woo-bg-image').val() != "") {
    bg_image = $('.woo-bg-image').val();
    }else{
    	bg_image = "";
    }
    if ($('.bg-img-size').val() != "") {
    bg_size = $('.bg-img-size').val();
    }else{
    	bg_size = "100%";
    }
	//Gradient background change
	$('.grad-input-radio').each(function(){
	if (this.checked){
		bg_grad = $(this).attr('gradient-color');
	}else{
		bg_grad = "";
	}
	});


$.ajax({
    type: "POST",
    url: ajaxurl,
    data: { action: 'wlsn_update_setting' , settings: settings, notification: notification, bg_color: bg_color, text_color: text_color,border_size: border_size, border_color: border_color, shadow: shadow, bg_image: bg_image, bg_size: bg_size, bg_grad: bg_grad }
  }).done(function( msg ) {
  	$('#submit-1-tab').css("opacity", "1");
    if (msg.trim() == "1") {
    	 location.reload();
    }
});
}
});

// ======================= Gradient color setup on page load ===================//
var idGradient = $('.woo-live-sale-pop-up').attr('id');
var gId = $('.grad-input-radio').attr('gradient-color');
$("input[gradient-color]").each(function(){
if($(this).attr('gradient-color') == idGradient){
$(this).prop('checked', true);
}
});

// ================== Second tab clicking on radio button ==================//
$('#sec-tab-det .layout-label-input input').click(function(){
$('#sec-tab-det .layout-label-input input').prop('checked', false);
$(this).prop('checked', true);
});

// ======================== Submittin second tab - Layouts tab ======================//
$('#submit-2-tab').click(function(){
  $('#submit-2-tab').css("opacity", "0.3");
$("#sec-tab-det .layout-label-input input").each(function(){
	var th = $(this);
   if ($(this).prop('checked')==true){ 
        //do something
      var notifyHTML  = $(this).closest('.pop-up-list-layouts').html();
      notifyHTML = notifyHTML.substring( 0, notifyHTML.indexOf( '<div class="layout-label-input">' ) );
      
      notifyHTML = notifyHTML.replace(/\n\s+|\n/g, "");
      var layouts_tab = "yes";
      //ajax call for sending layout style
      $.ajax({
    type: "POST",
    url: ajaxurl,
    data: { action: 'wlsn_update_setting' , layouts_tab: layouts_tab, notifyHTML: notifyHTML}
  }).done(function( msg ) {
  	$('#submit-2-tab').css("opacity", "1");
    if (msg.trim() == "1") {
    	 location.reload();
    }
});

    }

});
});

// ======================== Submittin third tab - position tab ======================//
$('#submit-3-tab').click(function(){
  $('#submit-3-tab').css("opacity", "0.2");
var position = "";
$(".r-img-show-b-left").each(function(){
   if ($(this).prop('checked')==true){ 
        //do something
         position  = $(this).val();
          }
});
console.log(position);
      //ajax call for sending position
      $.ajax({
    type: "POST",
    url: ajaxurl,
    data: { action: 'wlsn_update_setting' , position: position}
  }).done(function( msg ) {
    $('#submit-3-tab').css("opacity", "1");
    if (msg.trim() == "1") {
       location.reload();
    }
});
});

// ======================== Submittin fourth tab - position tab ======================//
$('#submit-4-tab').click(function(){
  $('#submit-4-tab').css("opacity", "0.2");
var effects = "";
$(".effects-list-woo input").each(function(){
   if ($(this).prop('checked')==true){ 
        //do something
         effects  = $(this).attr('effects-id');
          }
});
console.log(effects);
      //ajax call for sending position
      $.ajax({
    type: "POST",
    url: ajaxurl,
    data: { action: 'wlsn_update_setting' , effects: effects}
  }).done(function( msg ) {
    $('#submit-4-tab').css("opacity", "1");
    if (msg.trim() == "1") {
       location.reload();
    }
});
});
// ======================== Submittin fifth tab - products and buyers tab ======================//
$('#submit-5-tab').click(function(){
  $('#submit-5-tab').css("opacity", "0.2");
var products = product_ids = buyerNames = buyerLocation =  "";
var only_live_sale = "0";
$(".input-text-left-woo-live-stt input").each(function(){
   if ($(this).prop('checked')==true){ 
        //do something
         products  = $(this).val();
          }
});
if (products == "pro-manually") {
  if ($('.random-pro-ids-live').val() == "") {
    alert("Minimum one product id is necessary");
    $('#submit-5-tab').css("opacity", "1");
    return false;
  }

}
    product_ids   = $('.random-pro-ids-live').val();
    product_ids   = product_ids.trim();
    if (product_ids.substr(product_ids.length - 1) == ",") {
      product_ids = product_ids.substring(0, product_ids.length - 1);
    }
    buyerNames    = $('.woo-in-txt-buyer-names').val().replace(/(\r\n|\n)/g, "<br/>");
    buyerLocation = $('.woo-in-txt-area-names').val().replace(/(\r\n|\n)/g, "<br/>");
    if ($('.woo-live-sale-last input').prop('checked') == true) {
      only_live_sale = "1";
    }

      //ajax call for sending position
      $.ajax({
    type: "POST",
    url: ajaxurl,
    data: { action: 'wlsn_update_setting' , products: products, product_ids: product_ids,buyerNames: buyerNames,buyerLocation: buyerLocation, only_live_sale: only_live_sale  }
  }).done(function( msg ) {
    $('#submit-5-tab').css("opacity", "1");
    console.log(msg);
    if (msg.trim() == "1") {
       location.reload();
    }
});
});

// ======================== Submittin sixth tab - General Setting ======================//
$('#submit-6-tab').click(function(){
  $('#submit-6-tab').css("opacity", "0.2");
var minMaxNotify = onScreen = afterNotify = beep = onMobile = inTime = notShow = "";
minMaxNotify    = $('.woo-min-pr-live').val() + "," + $('.woo-max-pr-live').val();
onScreen        = $('.woo-timeafter-pr-live').val();
afterNotify     = $('.woo-min-pr-each').val() + "," + $('.woo-max-pr-each').val();
inTime          = $('input[name="r-time-in"]:checked').val();
inTime          = inTime.trim();
$('input[name="not-show-notify"]:checked').each(function() {
   notShow = notShow + this.value +",";
});

//checked check 
if ($('.woo-show-notify-beep input').is(':checked')) {
beep = "1";  
}
else{
  beep = "0";
}
 if ($('.woo-show-on-mbl-live input').is(':checked')) {
onMobile = "1";  
}
else{
  onMobile = "0";
}
var commonSetting = "yes";
    //ajax call for sending position
    $.ajax({
    type: "POST",
    url: ajaxurl,
    data: { action: 'wlsn_update_setting' , commonSetting:commonSetting, minMaxNotify: minMaxNotify, onScreen: onScreen,afterNotify: afterNotify,beep: beep, onMobile:onMobile, inTime: inTime, notShow:notShow  }
  }).done(function( msg ) {
    $('#submit-6-tab').css("opacity", "1");
    console.log(msg);
    if (msg.trim() == "1") {
       location.reload();
    }
});
});
// ================= Product select setting ===============//
$('.input-text-left-woo-live-stt input').change(function(){
  $('.input-text-left-woo-live-stt input').prop('checked', false);
  $(this).prop('checked', true);
});


});


