<?php
if(!defined('ABSPATH'))
    die('Forbidden');
//Only admin users can use it
if(!is_admin())
    die('Forbidden');

$action=sanitize_text_field($_GET['action']);
if (!in_array(strtolower($action),['export','add','clone','edit','upload','delete'])) {
    $action="";
}
if($action=='export'){
    require_once KFORM_DIR.'includes/class-kform-export.php';
    global $wpdb;
    $export_saved_forms=$wpdb
        ->get_results("SELECT kform_data_id,title,email,phone,content,create_time FROM ".KFORM_TABLE_NAME);
    $head_data=array(
        kform_lang('ID'),
        kform_lang('Title'),
        kform_lang('Email'),
        kform_lang('Phone'),
        kform_lang('Content'),
        kform_lang('Time'),
    );
    $export_data = array();
    foreach($export_saved_forms as $export_form)
    {
        $export_data[]=array(
            esc_html($export_form->kform_data_id),
            esc_html($export_form->title),
            esc_html($export_form->email),
            esc_html($export_form->phone),
            esc_html($export_form->content),
            date('Y-m-d H:i:s',$export_form->create_time),
        );
    }
    $kform_export = new KForm_Export();
    $kform_export->export($head_data,$export_data);
    return;
}
//show page title
$page='kform';
echo "<div class='wrap'><h1 class='wp-heading-inline'>".kform_lang("KForm")."</h1>";
echo sprintf(' <a href="?page=%s&action=%s" class="page-title-action" >'.kform_lang("Export").'</a>',esc_attr($page),'export');
?>
</div>
<?php
if(!class_exists('WP_LIST_TABLE'))
{
    require_once ABSPATH.'wp-admin/includes/class-wp-list-table.php';
}

/**
 * The form data show page class.
 *
 * @since      1.0.0
 * @package    kform
 * @subpackage kform/includes/admin
 * @author     kebenxiaoming <kebenxiaoming@gmail.com>
 */
class KForm_Admin_Table_List extends WP_List_Table
{
    /**
     * @return array
     * Description:initialize column data
     * Author:sunnier
     * Email:kebenxiaoming@gmail.com
     * 2023-11-21 16:37
     */
    function get_columns()
    {
        return array(
            'kform_data_id'=>kform_lang('ID'),
            'title'=>kform_lang('Title'),
            'email'=>kform_lang('Email'),
            'phone'=>kform_lang('Phone'),
            'content'=>kform_lang('Content'),
            'create_time'=>kform_lang('Time'),
        );
    }

    /**
     * @return array
     * Description:sortable columns
     * Author:sunnier
     * Email:kebenxiaoming@gmail.com
     * Date:2023-11-29 17:16
     * @since:1.0.0
     */
    function get_sortable_columns()
    {
        return array();
    }

    /**
     * Description:prepare item data
     * Author:sunnier
     * Email:kebenxiaoming@gmail.com
     * 2023-11-21 16:36
     */
    function prepare_items()
    {
        $this->_column_headers = array($this->get_columns(),array(),$this->get_sortable_columns(),array());
        global $wpdb;
        $form_data_count_obj = $wpdb->get_row("SELECT count(*) as data_num FROM ".KFORM_TABLE_NAME);
        $form_data_count = $form_data_count_obj->data_num;
        $per_page = 10;
        $page = !empty($_GET['paged'])?intval($_GET['paged']):1;
        $start_data_num = ($page-1)*$per_page;
        $saved_forms=$result=$wpdb->get_results("SELECT kform_data_id,title,email,phone,content,create_time FROM ".KFORM_TABLE_NAME." LIMIT $start_data_num,$per_page");
        foreach($saved_forms as $form)
        {
            $form->id=esc_html($form->kform_data_id);
            $form->title=esc_html($form->title);
            $form->email=esc_html($form->email);
            $form->phone=esc_html($form->phone);
            $form->content=esc_html($form->content);
            $form->create_time=date('Y-m-d H:i:s',$form->create_time);
        }
        $this->items=$saved_forms;
        //pagination
        $page_args = array(
            'total_items' =>$form_data_count,
            'total_pages' => ceil($form_data_count/$per_page),
            'per_page'    => $per_page,
        );
        $this->set_pagination_args($page_args);
    }

    /**
     * @param array|object $item
     * @param string $column_name
     * Description:column default show
     * Author:sunnier
     * Email:kebenxiaoming@gmail.com
     * Date:2023-11-29 15:42
     * @since:1.0.0
     */
    function column_default($item, $column_name)
    {
        return $item->$column_name;
    }

    /**
     * @param array|object $item
     * Description:rewrite generates the columns for a single row of the table.
     * Author:sunnier
     * Email:kebenxiaoming@gmail.com
     * Date:2023-11-29 17:49
     * @since:1.0.0
     */
    function single_row_columns( $item ) {
        list( $columns, $hidden, $sortable, $primary ) = $this->get_column_info();

        foreach ( $columns as $column_name => $column_display_name ) {
            $classes = "$column_name column-$column_name";
            if ( $primary === $column_name ) {
                $classes .= ' has-row-actions column-primary';
            }

            if ( in_array( $column_name, $hidden, true ) ) {
                $classes .= ' hidden';
            }

            /*
             * Comments column uses HTML in the display name with screen reader text.
             * Strip tags to get closer to a user-friendly string.
             */
            $data = '';
            $attributes = "class='$classes' $data";

            if ( 'cb' === $column_name ) {
                echo '<th scope="row" class="check-column">';
                echo esc_html($this->column_cb( $item ));
                echo '</th>';
            } elseif ( method_exists( $this, '_column_' . $column_name ) ) {
                echo esc_html(call_user_func(
                    array( $this, '_column_' . $column_name ),
                    $item,
                    $classes,
                    $data,
                    $primary
                ));
            } elseif ( method_exists( $this, 'column_' . $column_name ) ) {
                echo "<td ".esc_html($attributes).">";
                echo esc_html(call_user_func( array( $this, 'column_' . $column_name ), $item ));
                echo $this->handle_row_actions( $item, $column_name, $primary );
                echo '</td>';
            } else {
                echo "<td $attributes>";
                echo $this->column_default( $item, $column_name );
                echo $this->handle_row_actions( $item, $column_name, $primary );
                echo '</td>';
            }
        }
    }
}
$donationList=new KForm_Admin_Table_List();
$donationList->prepare_items();
$donationList->display();
?>