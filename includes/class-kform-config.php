<?php
/**
 * Description:kform config data
 * Author:sunnier
 * Email:kebenxiaoming@gmail.com
 * Date:2023-11-23 14:11
 * @since:1.0.0
 */
if(!defined('ABSPATH'))
    die('Forbidden');
global $wpdb;
define('KFORM_NAME','WordPress Kuai Form' );
define('KFORM_PLUGIN_NAME','kform' );
define('PLUGIN_NAME_VERSION', '1.0.0' );
define('KFORM_DIR',WP_PLUGIN_DIR.'/'.KFORM_PLUGIN_NAME.'/');
define('KFORM_DIR_URL',plugin_dir_url(dirname(__FILE__)));
define('KFORM_ADMIN_DIR_URL',plugin_dir_url(dirname(__FILE__)).'/admin/');
define('KFORM_PUBLIC_DIR_URL',plugin_dir_url(dirname(__FILE__)).'/public/');
define('KFORM_TABLE_NAME',$wpdb->prefix . "kform_form_data_list");
define('KFORM_LATEST_DB_VERSION',1);
?>