<?php
/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    kform
 * @subpackage kform/includes
 * @author     kebenxiaoming <kebenxiaoming@gmail.com>
 */
class KForm_i18n
{
    /**
     * Description:Load the plugin text domain for translation.
     * Author:sunnier
     * Email:kebenxiaoming@gmail.com
     * Date:2023-11-29 14:23
     * @since:1.0.0
     */
	public function load_plugin_textdomain()
    {

		load_plugin_textdomain(
			'kform',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}
}
