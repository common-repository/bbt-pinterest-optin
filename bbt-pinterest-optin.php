<?php
/**
 * Plugin Name: Pinterest Follow Optin
 * Plugin URI: https://bestblogtech.com/pinterest-optin/
 * Description: This plugin adds a Pinterest follow optin to your Wordpress site. Simply add your Pinterest account ID in the plugin's settings (Pinterest Opt-in) to activate it for your website.
 * Version: 1.2.5
 * Tested up to: 5.3.2
 * Author: David Dietz
 * Author URI: https://BestBlogTech.com/
 * License: GPL2
 */
///////////// EXIT IF ACCESSED DIRECTLY /////////////
if ( ! defined( 'ABSPATH' ) ) exit;
///////////// END EXIT IF ACCESSED DIRECTLY /////////////

///////////// CREATE BBT DATABASE TABLE /////////////
global $bbt_pinterest_db_version;
global $bbt_plugin_version;
$bbt_plugin_version = '1.2.5';
register_activation_hook( __FILE__, 'bbt_pinterest_create_db' );
function bbt_pinterest_create_db() {
	global $wpdb;
	global $bbt_plugin_version;
	$table_name = $wpdb->prefix . 'bbt_pinterest';
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		account varchar(75) DEFAULT '' NOT NULL,
		mobile mediumint(1) DEFAULT 0 NOT NULL,
		powered_by mediumint(1) DEFAULT 0 NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
	add_option( 'bbt_plugin_version', $bbt_plugin_version );

global $wpdb;
$table_name = $wpdb->prefix . 'bbt_pinterest';
$act_id = $wpdb->get_row("SELECT * FROM $table_name WHERE id = 1");
	if(!filter_var($act_id->account, FILTER_SANITIZE_STRING)){
	$wpdb->query( $wpdb->prepare(
 "INSERT INTO $table_name (account,mobile) VALUES ( 'pinterest',0 )"
));
}
add_action( 'admin_notices', 'wp_cache_flush__success' );
global $wp_object_cache;
return $wp_object_cache->flush();
}
///////////// END CREATE BBT DATABASE TABLE /////////////

//////////// CHECK PLUGIN FOR UPDATES /////////////
global $wpdb;
$installed_ver = get_option( "bbt_plugin_version" );
if ( $installed_ver != $bbt_pinterest_db_version ) {
	$table_name = $wpdb->prefix . 'bbt_pinterest';

	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		account varchar(75) DEFAULT '' NOT NULL,
		mobile mediumint(1) DEFAULT 0 NOT NULL,
		powered_by mediumint(1) DEFAULT 0 NOT NULL,
		PRIMARY KEY  (id)
	);";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
	update_option( "bbt_pinterest_db_version", $bbt_pinterest_db_version );
}

function bbt_pinterest_update_db_check() {
    global $bbt_plugin_version;
    if ( get_site_option( 'bbt_plugin_version' ) != $bbt_pinterest_db_version ) {
        bbt_install();
    }
}
add_action( 'plugins_loaded', 'bbt_pinterest_update_db_check' );
///////////// END CHECK PLUGIN FOR UPDATES ////////////

///////////// CREATE BBT SETTINGS PAGE /////////////
add_action('admin_menu', 'bbt_pinterest_plugin_menu');
function bbt_pinterest_plugin_menu() {
	add_menu_page('Pinterest Follow Opt-in Settings - BestBlogTech.com', 'Pinterest Opt-in', 'administrator', 'bbt-pinterest-optin-settings', 'bbt_pinterest_settings_page', 'dashicons-admin-generic');
}

function bbt_pinterest_settings_page() {
  include( plugin_dir_path( __FILE__ ) . 'form.php');
}
///////////// END CREATE BBT SETTINGS PAGE /////////////

///////////// REGISTER BBT SETTINGS /////////////
add_action( 'admin_init', 'bbt_pinterest_settings' );
function bbt_pinterest_settings() {
	register_setting( 'bbt-pinterest-settings-group', 'account' );
}
///////////// END REGISTER BBT SETTINGS /////////////

///////////// CONDITIONALLY LOAD JQUERY /////////////
add_action( 'wp_enqueue_scripts', 'bbt_pinterest_load_jquery' );
 function bbt_pinterest_load_jquery() {
    if ( ! wp_script_is( 'jquery', 'enqueued' )) {
        wp_enqueue_script( 'jquery' );
    }
}
///////////// END CONDITIONALLY LOAD JQUERY /////////////

///////////// UPDATE TABLE WITH PINTEREST ID /////////////
$table_name = $wpdb->prefix . 'bbt_pinterest';
$item = $wpdb->get_row("SELECT * FROM $table_name WHERE id = 1");
  	if(esc_attr($item->account) === 'pinterest' || esc_attr($item->account) === ''){
	add_action( 'admin_notices', 'bbt_pinterest_admin_notice__error' ); 
	}
function bbt_pinterest_admin_notice__success() {
    ?>
    <div class="notice notice-success is-dismissible">
        <p><?php _e( 'Success! Your Pinterest ID was added and your optin is now being shown on your site. You may need to clear your cache.', 'sample-text-domain' ); ?></p>
    </div>
    <?php
}
function bbt_pinterest_admin_notice__error() {
	$class = 'notice notice-error';
	$message = __( 'Please enter your Pinterest ID for your optin to become visible on your site. ', 'sample-text-domain' );

	printf( '<div class="%1$s"><p><strong>PINTEREST OPTIN NOTICE: </strong>%2$s <a href="/wp-admin/admin.php?page=bbt-pinterest-optin-settings">Enter it here.</a></p></div>', esc_attr( $class ), esc_html( $message ) ); 
}
///////////// END CHECK PLUGIN FOR UPDATES /////////////

///////////// INSERT THE PINTEREST OPTIN /////////////
function bbt_pinterest_optin() {
  include_once( 'optin.php' );
}
add_action( 'wp_footer', 'bbt_pinterest_optin' );
///////////// END INSERT THE PINTEREST OPTIN /////////////