<?php
/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    kform
 * @subpackage kform/includes
 * @author     kebenxiaoming <kebenxiaoming@gmail.com>
 */
class KForm_Activator
{
    /**
     * Description:execute during plugin activation
     * Author:sunnier
     * Email:kebenxiaoming@gmail.com
     * Date:2023-11-29 14:22
     * @since:1.0.0
     */
	public static function activate()
    {
        $dbversion=get_option("KFORM_LATEST_DB_VERSION");
        if($dbversion < KFORM_LATEST_DB_VERSION )
        {
            require_once ABSPATH.'wp-admin/includes/upgrade.php';
            $sql = "CREATE TABLE IF NOT EXISTS " . KFORM_TABLE_NAME . " (
                    kform_data_id int(11) UNSIGNED AUTO_INCREMENT,       
                    title VARCHAR(200) NOT NULL default '',   
                    email VARCHAR(200) NOT NULL default '',   
                    phone VARCHAR(50) NOT NULL default '',
                    content MEDIUMTEXT NOT NULL,
                    data_hash VARCHAR(32) NOT NULL default '',
                    create_time int(11) UNSIGNED NOT NULL default 0,
                    PRIMARY KEY  (kform_data_id)
                    ) COLLATE utf8_general_ci;";
            dbDelta($sql);
            update_site_option("KFORM_LATEST_DB_VERSION", KFORM_LATEST_DB_VERSION);
        }
	}
}
