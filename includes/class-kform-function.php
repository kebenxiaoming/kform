<?php
/**
 * The core plugin functions.
 *
 * This is used to define our plugin function.
 *
 * @since      1.0.0
 * @package    kform
 * @subpackage kform/includes
 * @author     kebenxiaoming <kebenxiaoming@gmail.com>
 */
if ( ! function_exists( '__kform_lang' ) )
{
    /**
     * @param string $str
     * @param string $domain
     * @return string|void
     * Description:kform language function
     * Author:sunnier
     * Email:kebenxiaoming@gmail.com
     * Date:2023-11-29 14:23
     * @since:1.0.0
     */
    function __kform_lang($str='',$domain='default')
    {
        return __($str,$domain);
    }
}
