<?php
/**
 * Plugin Name:       Kuai Form
 * Plugin URI:        http://wordpress.org/plugins/kform/
 * Description:       Kuai&Simple WordPress contact form plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            kebenxiaoming
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 *
 * KForm is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * KForm is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with KForm. If not, see <https://www.gnu.org/licenses/>.
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * plugin config.
 * @since:1.0.0
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-kform-config.php';

if ( ! function_exists( 'kform_activate_function' ) )
{
    /**
     * Description:The code that runs during plugin activation.
     * This action is documented in includes/class-kform-activator.php
     * Author:sunnier
     * Email:kebenxiaoming@gmail.com
     * Date:2023-11-29 15:56
     * @since:1.0.0
     */
    function kform_activate_function()
    {
        require_once KFORM_DIR . 'includes/class-kform-activator.php';
        KForm_Activator::activate();
    }
}

if ( ! function_exists( 'kform_deactivate_function' ) )
{
    /**
     * Description:The code that runs during plugin deactivation.
     * This action is documented in includes/class-kform-deactivator.php
     * Author:sunnier
     * Email:kebenxiaoming@gmail.com
     * Date:2023-11-29 15:56
     * @since:1.0.0
     */
    function kform_deactivate_function()
    {
        require_once KFORM_DIR . 'includes/class-kform-deactivator.php';
        KForm_Deactivator::deactivate();
    }
}

/**
 * activation hook
 * @since:1.0.0
 */
register_activation_hook( __FILE__, 'kform_activate_function' );

/**
 * deactivation hook
 * @since:1.0.0
 */
register_deactivation_hook( __FILE__, 'kform_deactivate_function' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 * @since:1.0.0
 */
require_once KFORM_DIR. 'includes/class-kform.php';

/**
 * plugin functions.
 * @since:1.0.0
 */
require_once KFORM_DIR. 'includes/class-kform-function.php';

/**
 * @return KForm
 * Description:Begins execution of the plugin.
 * Author:sunnier
 * Email:kebenxiaoming@gmail.com
 * Date:2023-11-29 15:55
 * @since:1.0.0
 */
function kform()
{
    return KForm::instance();
}

/**
 * Description:run kform function
 * Author:sunnier
 * Email:kebenxiaoming@gmail.com
 * Date:2023-11-29 17:01
 * @since:1.0.0
 */
function run_kform()
{
    kform()->run();
}

/**
 * run kform plugin.
 * @since:1.0.0
 */
run_kform();