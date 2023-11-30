<?php
/**
 * The core plugin class.
 *
 * @since      1.0.0
 * @package    kform
 * @subpackage kform/includes
 * @author     kebenxiaoming <kebenxiaoming@gmail.com>
 */
class KForm
{

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Kform_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

    /**
     * Main Kform Instance.
     *
     * *Only one instance of Kform exists in memory at any one time.
     * Also prevent the need to define globals all over the place.
     *
     * @since    1.0.0
     * @return   Kform
     */
	protected static $instance;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct()
    {
		if ( defined( 'PLUGIN_NAME_VERSION' ) ) {
			$this->version = PLUGIN_NAME_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'kform';
        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once KFORM_DIR . 'includes/class-kform-loader.php';
        $this->loader = new KForm_Loader();
        if ( is_admin() ) {
            $this->load_admin_dependencies();
            $this->define_admin_hooks();
        }
        $this->load_dependencies();
        $this->set_locale();
		$this->define_public_hooks();
	}

    /**
     * @return Kform
     * Description:Main Kform Instance
     * Author:sunnier
     * Email:kebenxiaoming@gmail.com
     * Date:2023-11-29 15:51
     * @since:1.0.0
     */
    public static function instance()
    {

        if (
            self::$instance === null ||
            ! self::$instance instanceof self
        ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Description:Create an instance of the loader which will be used to register the public hooks
     * with WordPress.
     * Author:sunnier
     * Email:kebenxiaoming@gmail.com
     * Date:2023-11-29 15:51
     * @since:1.0.0
     */
	private function load_dependencies()
    {

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once KFORM_DIR . 'includes/class-kform-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once KFORM_DIR. 'admin/class-kform-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once KFORM_DIR . 'public/class-kform-public.php';

	}

    /**
     * Description:Create an instance of the loader which will be used to register the admin hooks
     * with WordPress.
     * Author:sunnier
     * Email:kebenxiaoming@gmail.com
     * Date:2023-11-29 15:51
     * @since:1.0.0
     */
    private function load_admin_dependencies()
    {
        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once KFORM_DIR. 'admin/class-kform-admin.php';
    }

    /**
     * Description:Define the locale for this plugin for internationalization.
     * Author:sunnier
     * Email:kebenxiaoming@gmail.com
     * Date:2023-11-29 15:51
     * @since:1.0.0
     */
	private function set_locale()
    {

		$plugin_i18n = new Kform_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

    /**
     * Description:Register all of the hooks related to the admin area functionality
     * of the plugin.
     * Author:sunnier
     * Email:kebenxiaoming@gmail.com
     * Date:2023-11-29 15:52
     * @since:1.0.0
     */
	private function define_admin_hooks()
    {

		$plugin_admin = new Kform_Admin( $this->get_plugin_name(), $this->get_version() );

        $plugin_admin->define_hooks($this->loader);

	}

    /**
     * Description: Register all of the hooks related to the public-facing functionality
     * of the plugin.
     * Author:sunnier
     * Email:kebenxiaoming@gmail.com
     * Date:2023-11-29 15:52
     * @since:1.0.0
     */
	private function define_public_hooks()
    {

		$plugin_public = new Kform_Public( $this->get_plugin_name(), $this->get_version() );

        $plugin_public->define_hooks($this->loader);
	}

    /**
     * Description:Run the loader to execute all of the hooks with WordPress.
     * Author:sunnier
     * Email:kebenxiaoming@gmail.com
     * Date:2023-11-29 15:52
     * @since:1.0.0
     */
	public function run()
    {
		$this->loader->run();
	}

    /**
     * @return string
     * Description:The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     * Author:sunnier
     * Email:kebenxiaoming@gmail.com
     * Date:2023-11-29 15:52
     * @since:1.0.0
     */
	public function get_plugin_name()
    {
		return $this->plugin_name;
	}

    /**
     * @return Kform_Loader
     * Description:The reference to the class that orchestrates the hooks with the plugin.
     * Author:sunnier
     * Email:kebenxiaoming@gmail.com
     * Date:2023-11-29 15:52
     * @since:1.0.0
     */
	public function get_loader()
    {
		return $this->loader;
	}

    /**
     * @return string
     * Description: Retrieve the version number of the plugin.
     * Author:sunnier
     * Email:kebenxiaoming@gmail.com
     * Date:2023-11-29 15:53
     * @since:1.0.0
     */
	public function get_version()
    {
		return $this->version;
	}

}
