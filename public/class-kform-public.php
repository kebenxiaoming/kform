<?php
/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    kform
 * @subpackage kform/public
 * @author     kebenxiaoming <kebenxiaoming@gmail.com>
 */
class KForm_Public
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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version )
    {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

    /**
     * @param $loader
     * Description:define admin hook.
     * Author:sunnier
     * Email:kebenxiaoming@gmail.com
     * Date:2023-11-29 14:28
     * @since:1.0.0
     */
    public function define_hooks($loader)
    {
        $loader->add_action( 'wp_enqueue_scripts',$this, 'enqueue_styles' );
        $loader->add_action( 'wp_enqueue_scripts', $this, 'enqueue_scripts' );
        $loader->add_action( 'wp_ajax_kform_submit_form_info', $this, 'submit_info_handler' );
        require_once KFORM_DIR. 'includes/class-kform-shortcode.php';
        new KForm_Shortcode($this);
    }

    /**
     * Description:handler ajax request
     * Author:sunnier
     * Email:kebenxiaoming@gmail.com
     * Date:2023-11-29 14:28
     * @since:1.0.0
     */
    public function submit_info_handler()
    {
        check_ajax_referer( 'kform_submit_form_info' );
        //deal form data
        if(!wp_doing_ajax()){
            echo wp_json_encode( ['status'=>0,'msg'=>__kform_lang('Incorrect request method','kform')]);
        }
        $formData = $_POST;
        $result_data = $this->validate_form_data($formData);
        //data hash
        $data_hash = md5(json_encode($result_data));
        global $wpdb;
        if($exist_data = $wpdb
            ->get_var("SELECT * FROM ".KFORM_TABLE_NAME." WHERE data_hash = '$data_hash'")){
            echo wp_json_encode(['status' => 0, 'msg' => __kform_lang('Please do not resubmit', 'kform')]);
            wp_die();
        }
        //Check if the data already exists
        $result_data['data_hash'] = $data_hash;
        $result_data['create_time'] = time();
        //save data
        $result = $wpdb->insert(KFORM_TABLE_NAME, $result_data);
        if ($result) {
            echo wp_json_encode(['status' => 1, 'msg' => __kform_lang('save successful', 'kform')]);
        } else {
            ob_clean();
            echo wp_json_encode(['status' => 0, 'msg' => __kform_lang('save fail', 'kform')]);
        }
        wp_die();
    }

    /**
     * @param array $data
     * @return array
     * Description:validate form data
     * Author:sunnier
     * Email:kebenxiaoming@gmail.com
     * Date:2023-11-29 14:28
     * @since:1.0.0
     */
    public function validate_form_data($data = array())
    {
        if(empty($data)){
            echo wp_json_encode( ['status'=>0,'msg'=>__kform_lang('Request data is empty','kform')]);
            wp_die();
        }
        if(empty($data['title'])){
            echo wp_json_encode( ['status'=>0,'msg'=>__kform_lang('Please enter a title','kform')]);
            wp_die();
        }else{
            $title = sanitize_text_field(wp_unslash($data['title']));
            if(mb_strlen($title,'UTF-8')<2){
                echo wp_json_encode( ['status'=>0,
                    'msg'=>__kform_lang('The title should be at least two characters long','kform')]);
                wp_die();
            }
            if(mb_strlen($title,'UTF-8')>200){
                echo wp_json_encode( ['status'=>0,
                    'msg'=>__kform_lang('The maximum title can only be 200 characters','kform')]);
                wp_die();
            }
        }
        $email='';
        $phone='';
        if(empty($data['email'])&&empty($data['phone'])){
            echo wp_json_encode( ['status'=>0,
                'msg'=>__kform_lang('Please enter your email or phone number','kform')]);
            wp_die();
        }else {
            if (!empty($data['email'])) {
                $email = sanitize_text_field(wp_unslash($data['email']));
                if (!is_email($email)) {
                    echo wp_json_encode(['status' => 0, 'msg' =>
                        __kform_lang('Incorrect email format','kform')]);
                    wp_die();
                }
            }
            if (!empty($data['phone'])) {
                $phone = sanitize_text_field(wp_unslash($data['phone']));
                if (mb_strlen($phone, 'UTF-8') < 3||mb_strlen($phone, 'UTF-8') > 100) {
                    echo wp_json_encode(['status' => 0,
                        'msg' => __kform_lang('Incorrect phone format','kform')]);
                    wp_die();
                }
            }
        }
        if(empty($data['content'])){
            echo wp_json_encode( ['status'=>0,
                'msg'=>__kform_lang('Please enter the content','kform')]);
            wp_die();
        }else{
            $content = sanitize_text_field(wp_unslash($data['content']));
            if(mb_strlen($content,'UTF-8')<5){
                echo wp_json_encode( ['status'=>0,
                    'msg'=>__kform_lang('The content should be at least five characters long','kform')]);
                wp_die();
            }
            if(mb_strlen($content,'UTF-8')>500){
                echo wp_json_encode( ['status'=>0,
                    'msg'=>__kform_lang('The maximum content can only be 500 characters','kform')]);
                wp_die();
            }
        }
        return array(
            'title'=>$title,
            'email'=>$email,
            'phone'=>$phone,
            'content'=>$content,
        );
    }

    /**
     * @param $args
     * @return false|string
     * Description:shortcode show page
     * Author:sunnier
     * Email:kebenxiaoming@gmail.com
     * Date:2023-11-29 14:28
     * @since:1.0.0
     */
    public function front_page($args)
    {
        ob_start();
        require_once KFORM_DIR. 'public/view/kform-public-display.php';
        return ob_get_clean();
    }

    /**
     * Description:Register the stylesheets for the public-facing side of the site.
     * Author:sunnier
     * Email:kebenxiaoming@gmail.com
     * Date:2023-11-29 14:28
     * @since:1.0.0
     */
	public function enqueue_styles()
    {
		wp_enqueue_style( $this->plugin_name.'-base', KFORM_PUBLIC_DIR_URL. 'css/kform-public.css', array(), $this->version, 'all' );
        wp_enqueue_style( $this->plugin_name.'-bootstrap-base', KFORM_DIR_URL. '/static/css/bootstrap.min.css', array(), $this->version);
	}

    /**
     * Description:Register the JavaScript for the public-facing side of the site.
     * Author:sunnier
     * Email:kebenxiaoming@gmail.com
     * Date:2023-11-29 14:29
     * @since:1.0.0
     */
	public function enqueue_scripts()
    {
		wp_enqueue_script( $this->plugin_name.'-base', KFORM_PUBLIC_DIR_URL. 'js/kform-public.js', array( 'jquery' ), $this->version, false );
        wp_enqueue_script( $this->plugin_name.'-bootstrap-base', KFORM_DIR_URL. '/static/js/bootstrap.min.js', array(), $this->version, false );
        //transfer php variable to javascript global variable
		require_once ABSPATH.'wp-includes/pluggable.php';
		//create ajax nonce
        $title_nonce = wp_create_nonce( 'kform_submit_form_info' );
        //js data load
        wp_localize_script(
            $this->plugin_name.'-base',
            'kform_ajax_obj',
            array(
                'ajax_url' => admin_url( 'admin-ajax.php' ),
                'action' =>'kform_submit_form_info',
                'nonce'    => $title_nonce,
            )
        );
	}
}
