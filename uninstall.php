<?php
//////////////// DELETE DATABASE TABLE WHEN UNINSTALLED ////////////////
    if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit();
    global $wpdb;
    $table_name = $wpdb->prefix . 'bbt_pinterest';
    $wpdb->query( "DROP TABLE IF EXISTS $table_name" );
    delete_option("bbt_pinterest_db_version");
//////////////// END DELETE DATABASE TABLE WHEN UNINSTALLED ////////////////
?>