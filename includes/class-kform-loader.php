<?php
/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    kform
 * @subpackage kform/includes
 * @author     kebenxiaoming <kebenxiaoming@gmail.com>
 */
class KForm_Loader
{
	/**
	 * The array of actions registered with WordPress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $actions    The actions registered with WordPress to fire when the plugin loads.
	 */
	protected $actions;

	/**
	 * The array of filters registered with WordPress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $filters    The filters registered with WordPress to fire when the plugin loads.
	 */
	protected $filters;

	/**
	 * Initialize the collections used to maintain the actions and filters.
	 *
	 * @since    1.0.0
	 */
	public function __construct()
    {
		$this->actions = array();
		$this->filters = array();
	}

    /**
     * @param $hook
     * @param $component
     * @param $callback
     * @param int $priority
     * @param int $accepted_args
     * Description:Add a new action to the collection to be registered with WordPress.
     * Author:sunnier
     * Email:kebenxiaoming@gmail.com
     * Date:2023-11-29 14:24
     * @since:1.0.0
     */
	public function add_action( $hook, $component, $callback, $priority = 10, $accepted_args = 1 )
    {
		$this->actions = $this->add( $this->actions, $hook, $component, $callback, $priority, $accepted_args );
	}

    /**
     * @param $hook
     * @param $component
     * @param $callback
     * @param int $priority
     * @param int $accepted_args
     * Description:Add a new filter to the collection to be registered with WordPress.
     * Author:sunnier
     * Email:kebenxiaoming@gmail.com
     * Date:2023-11-29 14:24
     * @since:1.0.0
     */
	public function add_filter( $hook, $component, $callback, $priority = 10, $accepted_args = 1 )
    {
		$this->filters = $this->add( $this->filters, $hook, $component, $callback, $priority, $accepted_args );
	}

    /**
     * @param $hooks
     * @param $hook
     * @param $component
     * @param $callback
     * @param $priority
     * @param $accepted_args
     * @return mixed
     * Description:A utility function that is used to register the actions and hooks into a single
     * collection.
     * Author:sunnier
     * Email:kebenxiaoming@gmail.com
     * Date:2023-11-29 14:24
     * @since:1.0.0
     */
	private function add( $hooks, $hook, $component, $callback, $priority, $accepted_args )
    {
		$hooks[] = array(
			'hook'          => $hook,
			'component'     => $component,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $accepted_args
		);
		return $hooks;
	}

    /**
     * Description:Register the filters and actions with WordPress.
     * Author:sunnier
     * Email:kebenxiaoming@gmail.com
     * Date:2023-11-29 14:24
     * @since:1.0.0
     */
	public function run()
    {
		foreach ( $this->filters as $hook ) {
			add_filter( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}
		foreach ( $this->actions as $hook ) {
			add_action( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}
	}
}
