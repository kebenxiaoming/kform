<?php
/**
 * KForm export class.
 *
 * This class defines export user form data.
 *
 * @since      1.0.0
 * @package    kform
 * @subpackage kform/includes
 * @author     kebenxiaoming <kebenxiaoming@gmail.com>
 */
class KForm_Export
{
    /**
     * @param $head_data
     * @param array $data
     * @param string $file_name
     * Description:export data
     * Author:sunnier
     * Email:kebenxiaoming@gmail.com
     * Date:2023-11-29 14:38
     * @since:1.0.0
     */
    public static function export($head_data,$data = array(),$file_name='')
    {
        ob_clean();
        set_time_limit(0);
        ini_set('memory_limit', '256M');
        //download csv filename
        if(empty($fileName)){
            $file_name = __kform_lang("KForm",'kform').time();
        }
        $fileName = $file_name.'.csv';
        //set header
        header('Content-Description: File Transfer');
        header('Content-Encoding: UTF-8');
        header('Content-Type: application/vnd.ms-excel;charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        //open php file
        $fp = fopen('php://output', 'a');
        //judge if windows OS convert data
        $is_cn = get_locale()=='zh_CN';
        //convert data to GBK
        if($is_cn)
        mb_convert_variables('GBK', 'UTF-8', $head_data);
        //input header to file
        fputcsv($fp, $head_data);
        //input data to file
        if($is_cn) {
            foreach ($data as $row) {
                //convert data to GBK
                mb_convert_variables('GBK', 'UTF-8', $row);
                fputcsv($fp, $row);
                //release $row
                unset($row);
            }
        }else{
            foreach ($data as $row) {
                fputcsv($fp, $row);
                //release $row
                unset($row);
            }
        }
        //close file
        fclose($fp);
        die();
    }
}