﻿<?php 
///////////// EXIT IF ACCESSED DIRECTLY /////////////
if ( ! defined( 'ABSPATH' ) ) exit;
///////////// END EXIT IF ACCESSED DIRECTLY /////////////

//////////////// GET PINTEREST ACCOUNT ID FROM DB ////////////////
global $wpdb;
global $bbt_pinterest_db_version;
$bbt_pin_installed_ver = get_option( "bbt_pinterest_db_version" );
global $bbt_plugin_version;
$bbt_pin_update = " - You have the latest version. 🙂";
if ( $bbt_plugin_version != $bbt_pinterest_db_version ) {
	$bbt_pin_update = " - <a href='update-core.php' style='color:#8DAD3D;font-weight:bold;'>Update available!</a>";
}
$table_name = $wpdb->prefix . 'bbt_pinterest';
$bbt_act_id = $wpdb->get_row("SELECT * FROM $table_name WHERE id = 1");
$bbt_account = filter_var($bbt_act_id->account, FILTER_SANITIZE_STRING);
$bbt_mobile_status = filter_var($bbt_act_id->mobile, FILTER_SANITIZE_NUMBER_INT);
$bbt_pin_powered_status = filter_var($bbt_act_id->powered_by, FILTER_SANITIZE_NUMBER_INT);
if($bbt_mobile_status === '1') { $bbt_mobile_checked = "checked"; } else { $bbt_mobile_checked = "";}
if($bbt_pin_powered_status === '1') { $bbt_pin_powered_checked = "checked"; } else { $bbt_pin_powered_checked = "";}
//////////////// END GET PINTEREST ACCOUNT ID FROM DB ////////////////

///////////// UPDATE WHEN SUBMITTED /////////////
if (isset($_POST['submit'])){
$bbt_account_post = filter_var($_POST['account_id'], FILTER_SANITIZE_STRING);
$bbt_mobile_post = filter_var($_POST['bbt_pin_mobile'], FILTER_SANITIZE_NUMBER_INT);
$bbt_pin_powered_post = filter_var($_POST['bbt_pin_powered_by'], FILTER_SANITIZE_NUMBER_INT);
if($bbt_account_post !== '' && $bbt_account_post !== 'pinterest') {
		if (check_admin_referer( 'bbt_nonce', 'submit_bbt' )) {
			$table_name = $wpdb->prefix . 'bbt_pinterest';
    		$wpdb->update($table_name, array('account'=>$bbt_account_post, 'mobile'=>$bbt_mobile_post, 'powered_by'=>$bbt_pin_powered_post), array('id'=>1));
			$bbt_act_id = $wpdb->get_row("SELECT * FROM $table_name WHERE id = 1");
			$bbt_account = filter_var($bbt_act_id->account, FILTER_SANITIZE_STRING);
			$bbt_mobile_status = filter_var($bbt_act_id->mobile, FILTER_SANITIZE_NUMBER_INT);
			$bbt_pin_powered_status = filter_var($bbt_act_id->powered_by, FILTER_SANITIZE_NUMBER_INT);
			$bbt_success = "<div class='updated notice is-dismissible' style='padding: 20px 10px 20px 15px;'>Success! Your Pinterest ID was update and your optin is now being shown on your site (mobile respected, of course). You may need to clear your site/browser cache.</div>"; echo $bbt_success;
			if($bbt_mobile_status === '1') { $bbt_mobile_checked = "checked"; } else { $bbt_mobile_checked = ""; }
			if($bbt_pin_powered_status === '1') { $bbt_pin_powered_checked = "checked"; } else { $bbt_pin_powered_checked = "";}
		} else { 
		echo "<div class='notice notice-error is-dismissible' style='padding: 20px 10px 20px 15px;'>Error! Something went wrong... Please try your request again.</div>";
		}
	}
else { 
		if(isset($_POST['submit']) && $bbt_account_post === 'pinterest' || $bbt_account_post === '' || $bbt_act_id->account === 'pinterest' || $bbt_act_id->account === ''){
	echo "<div class='notice notice-error is-dismissible' style='padding: 20px 10px 20px 15px;'>Error! Something went wrong... Please try your request again. (You cannot enter 'pinterest' as your ID nor leave it blank.)</div>";
		}
	}
}
///////////// END UPDATE WHEN SUBMITTED /////////////
?>

<!-- ADMIN SETTINGS FORM -->
<div class="wrap">
<h2><a href="https://bestblogtech.com/" target="_blank" style="text-decoration:none;"><img src="<?php echo plugins_url( 'BestBlogTech-transparent_225x.png', __FILE__ ); ?>" alt="BestBlogTech.com"></a></h2>
<h2>Enter Your Pinterest ID (https://www.pinterest.com/***THIS-IS-YOUR-PINTEREST-ID***)</h2><p><strong>Do not include the "https://www.pinterest.com/" portion.</strong></p>

<form method="post" action="">
    <?php wp_nonce_field('bbt_nonce', 'submit_bbt'); ?>
    <?php settings_fields( 'bbt-pinterest-settings-group' ); ?>
    <?php do_settings_sections( 'bbt-pinterest-settings-group' );
	?>
    <table class="form-table">
    <tr valign="top" style="background-color: #ccc;">
    <th scope="row" style="padding: 20px 10px 20px 15px;">Pinterest ID</th>
    <td>https://www.pinterest.com/<input type="text" id="account_id" name="account_id" value="<?php echo esc_attr($bbt_account); ?>" /></td>
	</tr>
	<tr valign="top" style="background-color: #ccc;">
	<th scope="row" style="padding: 20px 10px 20px 15px;">Display on Mobile?</th>
	<td>Check this box to enable the optin for mobile. Uncheck it to disable it for mobile. <input type="checkbox" <?php echo esc_attr($bbt_mobile_checked); ?> id="bbt_pin_mobile" name="bbt_pin_mobile" value="1" /></td>
    </tr>
    <tr valign="top" style="background-color: #ccc;">
	<th scope="row" style="padding: 20px 10px 20px 15px;">Display "by BestBlogTech.com"?</th>
	<td>Check this box to show us your support! Uncheck it to disable it. <input type="checkbox" <?php echo esc_attr($bbt_pin_powered_checked); ?> id="bbt_pin_powered_by" name="bbt_pin_powered_by" value="1" /></td>
    </tr>
    </table>
    
    <?php submit_button(); ?>

</form>
	<span style="bottom:0;left:0;">Plugin Version: <?php echo $bbt_plugin_version; ?></span><br>
	<span style="bottom:0;right:0;">Plugin Page: <a href="https://wordpress.org/plugins/bbt-pinterest-optin/" target="_blank">Visit page</a></span>
</div>
<!-- END ADMIN SETTINGS FORM -->