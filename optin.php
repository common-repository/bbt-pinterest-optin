<?php 
///////////// EXIT IF ACCESSED DIRECTLY /////////////
if ( ! defined( 'ABSPATH' ) ) exit;
///////////// END EXIT IF ACCESSED DIRECTLY /////////////

///////////////// CHECK DB FOR PINTEREST ACCOUNT ID /////////////////
global $wpdb;
global $bbt_plugin_version;
$table_name = $wpdb->prefix . 'bbt_pinterest';
$bbt_act_id = $wpdb->get_row("SELECT * FROM $table_name WHERE id = 1");
$bbt_pin_account = filter_var($bbt_act_id->account, FILTER_SANITIZE_STRING);
$bbt_mobile_pin = filter_var($bbt_act_id->mobile, FILTER_SANITIZE_NUMBER_INT);
$bbt_pin_powered_by = filter_var($bbt_act_id->powered_by, FILTER_SANITIZE_NUMBER_INT);
///////////////// END CHECK DB FOR PINTEREST ACCOUNT ID /////////////////

///////////////// CONDITIONALLY HIDE PINTEREST OPTIN IF PINTEREST ACCOUNT ID ISN'T SET /////////////////
    if(esc_attr($bbt_act_id->account) === 'pinterest' || esc_attr($bbt_act_id->account) === '');
///////////////// END CONDITIONALLY HIDE PINTEREST OPTIN IF PINTEREST ACCOUNT ID ISN'T SET /////////////////

///////////////// LOAD PINTEREST OPTIN IF PINTEREST ACCOUNT ID IS SET /////////////////
	else{ 
    ////// LOAD SHOW ALL CSS //////
	    if(esc_attr($bbt_mobile_pin) === '1' && esc_attr($bbt_pin_powered_by) === '1') { 
	        include ("css/show_all.php");
	    }
    ////// END SHOW ALL CSS //////
    
    ////// LOAD HIDE POWERED BY CSS //////
	    else if(esc_attr($bbt_mobile_pin) === '1' && esc_attr($bbt_pin_powered_by) !== '1') { 
	        include ("css/_pb.php");
	    }
    ////// END HIDE POWERED BY CSS //////
    
	////// LOAD HIDE MOBILE / SHOW POWERED BY CSS //////
	    else if(esc_attr($bbt_mobile_pin) !== '1' && esc_attr($bbt_pin_powered_by) === '1') { 
	        include ("css/_mobile.php");
	    }
    ////// END HIDE POWERED BY CSS //////

    ////// LOAD HIDE MOBILE CSS //////
	    else if(esc_attr($bbt_mobile_pin) !== '1'){ 
	        include ("css/_both.php");
	    }
    ////// END HIDE MOBILE CSS //////
?>
<!-- OPTIN-CLOSED COOKIE FUNCTIONS -->
<script type="text/javascript">
function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

function eraseCookie(name) {
	createCookie(name,"",-1);
}
</script>
<!-- OPTIN-CLOSED COOKIE FUNCTIONS -->
<div class="bbt-follow-slide" id="bbt-follow-slide"></div>
<!-- OPTIN -->
<script>
$bbt_pin_cache = (function($) {
  var DOMCACHESTORE = {};
  return function(selector, force) {
    if (DOMCACHESTORE[selector] === undefined || force)
      DOMCACHESTORE[selector] = jQuery(selector);
    return DOMCACHESTORE[selector];
  }
})($);
	
$bbt_pin_text = "<a id=\"bbt-pin-url\" class=\"bbt-pin-url\" data-pin-do=\"embedUser\" data-pin-board-width=\"280\" data-pin-scale-height=\"240\" data-pin-scale-width=\"80\" href=\"https://www.pinterest.com/<?php echo esc_attr($bbt_pin_account); ?>/\"></a><div class=\"bbt-closePin\" onclick=\"createCookie('bbt-pin-hide','bbt-pin-hide',30);$bbt_pin_cache('.bbt-follow-slide').remove();$bbt_pin_cache('.bbt-closePin').remove();\" style=\"cursor: pointer;\">x</div><div class=\"bbt-pinterest-powered-by\"><a href=\"https://bestblogtech.com/pinterest-optin/\" target=\"_blank\">by BestBlogTech.com</a></div>";
	
$bbt_pin_cache("#bbt-follow-slide").html($bbt_pin_text);
	
jQuery(window).load(function () {
	setTimeout(function(){	
		if (jQuery('script[src="//assets.pinterest.com/js/pinit.js"]').length > 0) {
			(function(d){
    		var f = d.getElementsByTagName('SCRIPT')[0], p = d.createElement('SCRIPT');
   			p.type = 'text/javascript';
    		p.src = '//assets.pinterest.com/js/pinit.js?v=<?php echo $bbt_plugin_version; ?>';
			p.async = 'async';
    		f.parentNode.insertBefore(p, f);
			}(document));
		console.log("-100 -- Loaded opt-in");
		}
	}, 2000);
});
</script>
<!-- END OPTIN -->

<!-- CHECK FOR OPTIN-CLOSED COOKIE AND CONDITIONALLY HIDE OPTIN -->
<script type="text/javascript">
var optCookie = readCookie('bbt-pin-hide');
      if(!optCookie) { 
jQuery(window).scroll(function() {
if(jQuery(window).scrollTop() >= jQuery(document).height()*0.3){
    $bbt_pin_cache('.bbt-follow-slide').fadeIn(500);$bbt_pin_cache('.bbt-pinterest-powered-by').fadeIn(500);$bbt_pin_cache('.bbt-closePin').css('left','auto').css('right','2%');
} else {
   $bbt_pin_cache('.bbt-follow-slide').fadeOut(500);$bbt_pin_cache('.bbt-pinterest-powered-by').fadeOut(500);$bbt_pin_cache('.bbt-closePin').css('left','auto').css('right','-100%');
}
});
}else{
$bbt_pin_cache('.bbt-follow-slide').remove();
$bbt_pin_cache('.bbt-closePin').remove();
}
</script>
<!-- CHECK FOR OPTIN-CLOSED COOKIE AND CONDITIONALLY HIDE OPTIN -->
<?php 
} 
///////////////// END LOAD PINTEREST OPTIN IF PINTEREST ACCOUNT ID IS SET /////////////////
?>