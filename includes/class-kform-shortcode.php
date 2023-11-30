<?php
/**
 * KForm frontend show
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    kform
 * @subpackage kform/includes
 * @author     kebenxiaoming <kebenxiaoming@gmail.com>
 */
class KForm_Shortcode
{
    /**
     * Public controller class
     *
     * @since    1.0.0
     * @access   protected
     */
    protected $public_controller;

    /**
     * KForm_Shortcode constructor.
     * @param $public_controller
     */
    public function __construct($public_controller)
    {
        add_shortcode( 'kuai_form', array( $this, 'kform_submit_info' ) );
        $this->public_controller = $public_controller;
    }

    /**
     * @param array $args
     * @return mixed
     * Description:KForm submit html
     * Author:sunnier
     * Email:kebenxiaoming@gmail.com
     * Date:2023-11-29 15:54
     * @since:1.0.0
     */
    public function kform_submit_info( $args=[] )
    {
        return $this->public_controller->front_page($args);
    }
}