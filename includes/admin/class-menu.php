<?php
/**
 * The plugin admin menu class.
 *
 * @since      1.0.0
 * @package    kform
 * @subpackage kform/includes/admin
 * @author     kebenxiaoming <kebenxiaoming@gmail.com>
 */
class KForm_Admin_Menu {

	/**
	 * Primary class constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct()
    {
	}

	/**
	 * Register our menus.
	 *
	 * @since 1.0.0
	 */
	public function register_menus()
    {
		//kform menu.
        add_menu_page(
            'KForm',
            kform_lang('KForm'),
            'manage_options',
            'kform',
            [$this,'admin_page'],
            'data:image/svg+xml;base64,' . base64_encode( '<svg width="1792" height="1792" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path fill="#9ea3a8" d="M643 911v128h-252v-128h252zm0-255v127h-252v-127h252zm758 511v128h-341v-128h341zm0-256v128h-672v-128h672zm0-255v127h-672v-127h672zm135 860v-1240q0-8-6-14t-14-6h-32l-378 256-210-171-210 171-378-256h-32q-8 0-14 6t-6 14v1240q0 8 6 14t14 6h1240q8 0 14-6t6-14zm-855-1110l185-150h-406zm430 0l221-150h-406zm553-130v1240q0 62-43 105t-105 43h-1240q-62 0-105-43t-43-105v-1240q0-62 43-105t105-43h1240q62 0 105 43t43 105z"/></svg>' ),
            20
        );
	}

    /**
     * Description:kform menu page
     * Author:sunnier
     * Email:kebenxiaoming@gmail.com
     * Date:2023-11-29 15:47
     * @since:1.0.0
     */
    public function admin_page()
    {
        do_action( 'kform_admin_page' );
    }
}
