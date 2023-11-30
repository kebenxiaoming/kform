<?php
/**
 * Uninstall Kuai Form.
 * @since 1.0.0
 */
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}
//// delete site options
delete_site_option( "KFORM_LATEST_DB_VERSION");
//
//// drop database table
global $wpdb;
$wpdb->query( "DROP TABLE IF EXISTS ".KFORM_TABLE_NAME);
