// =============== Removing notification ==================//
document.addEventListener('click', function (e) {
    if (hasClass(e.target, 'cross-hide-live-sale')) {
        jQuery('.woo-live-sale-pop-up').hide();
    } 
}, false);
function hasClass(elem, className) {
    return elem.className.split(' ').indexOf(className) > -1;
}


  jQuery(document).ready(function( $ ) {
  	// ======================== Removing notificaiton =====================//
$('.woo-live-sale-pop-up').on("click", function(event){
	//$('.woo-live-sale-pop-up').remove();
	alert("hleo");

});
$(".woo-live-sale-pop-up").on("click", "div", function(event){
    
});

  var counter_type = post_id = only_live_sale = "0";
  var clearVar;
  var timerTime = 0;
//Ajax call for getting notification details
jQuery.ajax({
			url : wlsnURL.wlsn_ajax_url,
			type : 'post',
			data : {
				action : 'wlsnReciveNotificaiton',
				counter_type   : counter_type,
				post_id 	   : post_id,
				only_live_sale : only_live_sale
			},
			success : function( response ) {
				console.log(response);
				var resultResponse = JSON.parse(response);

				//console.log("First ajax responese "+resultResponse[2][2]);
				
				//latest order check
				if (resultResponse[0][0] == "latest-order-date-check") {
					
					onlyLatestOrderCheckId(resultResponse);
				}else{
				$('body').append(resultResponse[0][11]);
				$('body .woo-live-sale-pop-up').css({'display': 'none', 'position':'fixed', 'z-index': '100000'});
				effectsNotification(resultResponse[0][1], resultResponse[0][0]); //effects notification
				notifyPosition(resultResponse[0][0]); //postion of the notiificaiton
				showNotification(resultResponse);	
				  }
				  
				 }
			
		});




// ================= Updating postion of notification =================//
 function notifyPosition(position) {
 	if (position == "1") {
 		$('body .woo-live-sale-pop-up').css({'left': '2%', 'bottom':'20px'});
 	}
 	else if (position == "2") {
       $('body .woo-live-sale-pop-up').css({'right': '2%', 'bottom':'20px'});
 	}
 	 	else if (position == "3") {
 		$('body .woo-live-sale-pop-up').css({ 'top':'21px', 'left':'30px'});
 	}
 	 	else if (position == "4") {
 		$('body .woo-live-sale-pop-up').css({'top': '21px', 'right':'40px'});
 	}
 	
 }

 // ================================= Notificaiton animation effects ====================//
 function effectsNotification(effects, position){
if (effects == "1") {
if (position == "1" || position == "2") {
$('body .woo-live-sale-pop-up').addClass('animated bounceInUp');
}
else{
$('body .woo-live-sale-pop-up').addClass('animated bounceInDown');
}
}
else if (effects == "2") {
if (position == "1" || position == "2") {
$('body .woo-live-sale-pop-up').addClass('animated fadeInUp');
}
else{
$('body .woo-live-sale-pop-up').addClass('animated fadeInDown');
}
}
else if (effects == "3") {
	if (position == "1" || position == "2") {
$('body .woo-live-sale-pop-up').addClass('animated slideInUp');
}
else{
$('body .woo-live-sale-pop-up').addClass('animated slideInDown');
}
}
else if (effects == "4") {
	if (position == "1" || position == "2") {
$('body .woo-live-sale-pop-up').addClass('animated jackInTheBox');
}
else{
$('body .woo-live-sale-pop-up').addClass('animated jackInTheBox');
}	
}
 }
 // ============================= Show notification ============================//
 function showNotification(result){
 	var len = result.length;
 	if (len > 0) {
 		popUpNotificaiton(len, result);
 	}
 	}

 	// ====================== Pop up notificaiton ===================//
 	function popUpNotificaiton(len, result){
 		var numberOfNotify= result[0][6];
 		numberOfNotify 	  = numberOfNotify.trim();

 		var onScreen      = result[0][7];
 		var timeOutNotify = result[0][8];
 		var beep 		  = result[0][9];
 		beep			  = beep.trim();
 		var onMobile 	  = result[0][10];
 		var startOnScreen = 1000;
 		var inTime 		  = result[0][12];
 		var isNow 		  = result[1][14];
 		//on screen in seconds
 		onScreen = onScreen * 1000;

 		//after notify in seconds 
 		var minOut = timeOutNotify.substr(0, timeOutNotify.indexOf(',')).trim(); 
 		var maxOut = timeOutNotify.substr(timeOutNotify.indexOf(',')+1, timeOutNotify.length).trim(); 
 		minOut = parseInt(minOut);
 		maxOut = parseInt(maxOut);

 		//min and maximum numbers
 		var minNumbers = numberOfNotify.substr(0, numberOfNotify.indexOf(',')).trim(); 
 		var maxNumbers = numberOfNotify.substr(numberOfNotify.indexOf(',')+1, numberOfNotify.length).trim(); 
 		minNumbers = parseInt(minNumbers);
 		maxNumbers = parseInt(maxNumbers);
 		maxNotifyCount = minNumbers + (maxNumbers - minNumbers) * Math.random()
 		maxNotifyCount = parseInt(maxNotifyCount);

 		//updating number of notificaitons depends on database result
 		var mainTimeCounter = 1;
 		var productName;
 		var image; 
 		var firstName; 
 		var lastName; 
 		var cityName; 
 		var stateName;
 		
 		var i = 0;
 		var j   = 0;
 		if (result[0][2] == "running-orders" || result[0][2] == "completed-orders" || result[0][2] == "pro-manually") {
 			i = userRowCookie(result.length, maxNotifyCount);
 			j   = i-1;
 			var inc = i;
 			maxNotifyCount = parseInt(inc)+parseInt(maxNotifyCount);	
 			//console.log(result.length+"="+maxNotifyLength);
 		}
		
		//checking total products
		if(result.length < maxNotifyCount){
			maxNotifyCount = result.length - 1;
		}
 		
 		//console.log("Max noti:"+maxNotifyLength+", increment:"+inc +", i value"+i);
 		//console.log(j+"maincount"+mainTimeCounter);
 		//console.log(i +"="+maxNotifyCount);
 	   for (; i < maxNotifyCount; i++) {
 	   //	console.log(i +"="+maxNotifyCount);
 	   	//console.log("start:"+i+", End:"+(parseInt(inc)+parseInt(maxNotifyLength)));

 		
 		timeOutNotify = Math.floor(Math.random() * (maxOut - minOut + 1)) + minOut; 
 		timeOutNotify = timeOutNotify * 1000;
 	    setTimeout( function(){
 		productName  = result[mainTimeCounter + j][7];

 		 image 		 = result[mainTimeCounter + j][2];
 		 firstName 	 = result[mainTimeCounter + j][3];
 		 lastName 	 = result[mainTimeCounter + j][4];
 		 cityName 	 = result[mainTimeCounter + j][5];
 		 stateName 	 = result[mainTimeCounter + j][6];
 		 j++;




 		// console.log("Total counts" + mainTimeCounter+j +"end");

 		$('body .woo-live-sale-pop-up .woo-live-sale-product-pic').css("background-image", "url("+image+")");

    $('body .woo-live-sale-pop-up .pop-up-p-name').text(firstName + " " + lastName);
 	$('body .woo-live-sale-pop-up .pop-up-area-name').text(cityName + " "+ stateName);
	$('body .woo-live-sale-pop-up .woo-live-sale-right-pr-off-name').text(productName);
 	//show time
 	var resultTime = showNotifyTime(inTime);
 	if (isNow == "yes") {
 		$('body .woo-live-sale-pop-up .woo-live-sale-pr-sale-time').text("Now");
 	}
 	else{
 	$('body .woo-live-sale-pop-up .woo-live-sale-pr-sale-time').text(resultTime);	
 	}
 	
 	//show notification
    $('body .woo-live-sale-pop-up').css("display", "block"); 

    //adding product url
    $('body .woo-live-sale-pop-up').on( "click", function() {
    	window.location.href = result[mainTimeCounter][8];
    });


    //tone on notificaiton show
    if (beep == "1") {
    	notificaitonTone();
    } 
    

  }  , startOnScreen ); // end of show notification
 var showTimerMinus = 1;
  setTimeout( function(){ 
  $('body .woo-live-sale-pop-up').hide(); 
  mainTimeCounter++;
  console.log(onScreen);
  }  , onScreen ); //hide timer
  startOnScreen = onScreen +timeOutNotify;
  onScreen      = onScreen + onScreen;
    
 	}
 	
 	}

// adding audio
$('body').append('<audio id="carteSoudCtrl">\
  <source src="https://moondeveloper.com/wp-content/uploads/2020/08/tri-tone_iphone.mp3" type="audio/mpeg"></audio>'); 
 var x = document.getElementById("carteSoudCtrl");
//playing audio
 	function notificaitonTone(){
    playAudio();
 	}
 	function playAudio() { 
    x.play(); 
   } 


// =========================== show notification time =====================//
function showNotifyTime(showTime){
	// time notify
	var returnTime = "";
 		if (showTime == "1") {
 			returnTime = Math.floor(Math.random() * (4 - 1 + 1)) + 1;
 			returnTime = returnTime + " hours ago";
 		}
 		else if (showTime == "2") {
 			returnTime = Math.floor(Math.random() * (30 - 1 + 1)) + 1;
 			returnTime = returnTime + " minutes ago";
 		}
 		else if (showTime == "3") {
 			returnTime = "Now";
 		}
 		
 		return returnTime;
}

// ================================ Latest order id check ======================//
function onlyLatestOrderCheckId(result){
lastOrderTime 	  = result[0][1];
currentServerTime = result[0][2];
only_live_sale 	  = "2";
window.setInterval(function(){
//Ajax call for getting notification details
jQuery.ajax({
			url : wlsnURL.wlsn_ajax_url,
			type : 'post',
			data : {
				action         : 'wlsnReciveNotificaiton',
				counter_type   : counter_type,
				post_id 	   : post_id,
				only_live_sale : only_live_sale,
				lastOrderTime  : lastOrderTime
			},
			success : function( response ) {
				
				var orderResult   = JSON.parse(response);

				
				var newStatus 	  = orderResult[1][14];
				lastOrderTime  	  = orderResult[1][15];
				var orderCheckTime= orderResult[0][16];
				
				if (newStatus == "yes") {
					//order received
			    $('body').append(result[0][11]);
				$('body .woo-live-sale-pop-up').css({'display': 'none', 'position':'fixed', 'z-index': '100000'});
				effectsNotification(orderResult[0][1], orderResult[0][0]); //effects notification
				notifyPosition(orderResult[0][0]); //postion of the notiificaiton
				showNotification(orderResult);

				}
				
				}
				
			});
         }, 10000);

}
});

function randomIntFromInterval(min,max) // min and max included
{
    return Math.floor(Math.random()*(max-min+1)+min);
}


//user row cookies
function userRowCookie(len, len2){
	
	if (getCookie("userOnRow") == "") {
	 setCookie("userOnRow", "0", "30");		
	}
	else{

		//check row value 
		if (parseInt(getCookie("userOnRow")) + parseInt(len2) >= parseInt(len)) {
			setCookie("userOnRow", "0", "30");
		}
		else{
			var cUser = parseInt(getCookie("userOnRow"));
			setCookie("userOnRow", cUser+parseInt(len2),"30");
		}
	}

	if (parseInt(getCookie("userOnRow")) + parseInt(len2) >= parseInt(len)) {
			setCookie("userOnRow", "0", "30");
		}
	
	return getCookie("userOnRow");
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

