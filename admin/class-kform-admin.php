<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    kform
 * @subpackage kform/admin
 * @author     kebenxiaoming <kebenxiaoming@gmail.com>
 */
class KForm_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param    string    $plugin_name       The name of this plugin.
	 * @param    string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
        $this->dependencies();
	}

    /**
     * Description: Initialize admin menu class.
     * Author:sunnier
     * Email:kebenxiaoming@gmail.com
     * Date:2023-11-29 14:27
     * @since:1.0.0
     */
    private function dependencies() {
        /**
         * admin menu
         */
        require_once KFORM_DIR. 'includes/admin/class-menu.php';
    }

    /**
     * @param $loader
     * Description:define admin hook.
     * Author:sunnier
     * Email:kebenxiaoming@gmail.com
     * Date:2023-11-29 15:46
     * @since:1.0.0
     */
    public function define_hooks($loader)
    {
        $loader->add_action( 'admin_enqueue_scripts',$this, 'enqueue_styles' );
        $loader->add_action( 'admin_enqueue_scripts', $this, 'enqueue_scripts' );
        $loader->add_action( 'admin_menu', $this, 'admin_menu' );
        $loader->add_action( 'kform_admin_page', $this, 'admin_page' );
    }

    /**
     * Description:Register admin menu for the admin area.
     * Author:sunnier
     * Email:kebenxiaoming@gmail.com
     * Date:2023-11-29 15:46
     * @since:1.0.0
     */
    public function admin_menu() {
        (new KForm_Admin_Menu())->register_menus();
    }

    /**
     * Description:kform admin front page
     * Author:sunnier
     * Email:kebenxiaoming@gmail.com
     * Date:2023-11-29 15:46
     * @since:1.0.0
     */
    public function admin_page() {
        require_once KFORM_DIR. 'includes/admin/class-admin-table-list.php';
    }

    /**
     * Description:Register the stylesheets for the admin area.
     * Author:sunnier
     * Email:kebenxiaoming@gmail.com
     * Date:2023-11-29 15:46
     * @since:1.0.0
     */
	public function enqueue_styles()
    {
		wp_enqueue_style( $this->plugin_name.'-base', KFORM_ADMIN_DIR_URL. 'css/kform-admin.css', array(), $this->version);
	}

    /**
     * Description:Register the JavaScript for the admin area.
     * Author:sunnier
     * Email:kebenxiaoming@gmail.com
     * Date:2023-11-29 15:46
     * @since:1.0.0
     */
	public function enqueue_scripts()
    {
        wp_enqueue_script('jquery');
		wp_enqueue_script( $this->plugin_name.'-base', KFORM_ADMIN_DIR_URL . 'js/kform-admin.js', array( 'jquery' ), $this->version, false );
	}

}
