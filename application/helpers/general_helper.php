<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * using for general need.
 * use $CI=& get_instance() for get CI instance inside the helper.
 * example : use $CI->load->database() to connect a db after you declare $CI=&get_instance().
 *
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 */

/**
 * custom date formate.
 *
 * @param string $string
 * @param string $format
 *
 * @return string $return
 */
function custDateFormat($string, $format = 'Y-m-d H:i:s')
{
    $return = date($format, strtotime($string));

    return $return;
}

/**
 * generate alert box notification with close button
 * style is based on bootstrap 3.
 *
 * @author ivan lubis
 *
 * @param string $msg          notification message
 * @param string $type         type of notofication
 * @param bool   $close_button close button
 *
 * @return string notification with html tag
 */
function alert_box($msg, $type = 'warning', $close_button = true)
{
    $html = '';
    if ($msg != '') {
        $html .= '<div class="alert alert-'.$type.' alert-dismissible" role="alert">';
        if ($close_button) {
            $html .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        }
        $html .= $msg;
        $html .= '</div>';
    }

    return $html;
}

/**
 * get site setting into array.
 *
 * @return array $return
 */
function get_sitesetting($id_site = 0)
{
    $CI = &get_instance();
    if (!$return = $CI->cache->get('frSiteSetting')) {
        $CI->load->database();
        if (!$id_site) {
            $CI->db->where('sites.is_default', 1);
        } else {
            $CI->db->where('setting.id_site', $id_site);
        }
        $query = $CI->db
                ->select('setting.type,setting.value')
                ->where('sites.id_ref_publish', 1)
                ->where('sites.is_delete', 0)
                ->join('sites', 'sites.id_site=setting.id_site', 'left')
                ->order_by('setting.id_setting', 'asc')
                ->get('setting')->result_array();
        foreach ($query as $row => $val) {
            $return[$val['type']] = $val['value'];
        }
        $CI->cache->save('frSiteSetting', $return);
    }

    return $return;
}

/**
 * retrieve setting value by key.
 *
 * @author ivan lubis
 *
 * @param $config_key field key
 * @param $id_site (optional) site id
 *
 * @return string value
 */
function get_setting($config_key = '', $id_site = 0)
{
    // load ci instance
    $CI = &get_instance();
    $CI->load->database();
    $val = '';
    if ($config_key != '') {
        $CI->db->where('setting.type', $config_key);
    }
    if (!$id_site) {
        $CI->db->where('sites.is_default', 1);
    } else {
        $CI->db->where('setting.id_site', $id_site);
    }
    $data = $CI->db
            ->join('sites', 'sites.id_site=setting.id_site', 'left')
            ->get('setting');

    if ($data->num_rows() > 1) {
        $val = $data->result_array();
    } elseif ($data->num_rows() == 1) {
        $row = $data->row_array();
        $val = $row['value'];
    } else {
        $val = false;
    }

    return $val;
}

/**
 * retrieve site info by id site.
 *
 * @author ivan lubis
 *
 * @param $id_site (optional) site id
 *
 * @return string value
 */
function get_site_info($id_site = 0)
{
    // load ci instance
    $CI = &get_instance();
    if (!$return = $CI->cache->get('frSiteInfo')) {
        $CI->load->database();
        if (!$id_site) {
            $CI->db->where('is_default', 1);
        } else {
            $CI->db->where('id_site', $id_site);
        }
        $return = $CI->db
                ->limit(1)
                ->order_by('id_site', 'desc')
                ->get('sites')->row_array();
        $CI->cache->save('frSiteInfo', $return);
    }

    return $return;
}

/**
 * get current controller value.
 *
 * @param string $param
 *
 * @return string current controller url
 */
function current_controller($param = '')
{
    $param = '/'.$param;
    $CI = &get_instance();
    $dir = $CI->router->directory;
    $class = $CI->router->fetch_class();

    return base_url().$dir.$class.$param;
}

/**
 * encrypt string to md5 value.
 *
 * @param string $string
 *
 * @return string encryption string
 */
function md5plus($string)
{
    $CI = &get_instance();

    return '_'.md5($CI->session->encryption_key.$string);
}

/**
 * generate new token.
 *
 * @return string $code
 */
function generate_token()
{
    $rand = md5(sha1('reg'.date('Y-m-d H:i:s')));
    $acceptedChars = 'abcdefghijklmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    $max = strlen($acceptedChars) - 1;
    $tmp_code = null;
    for ($i = 0; $i < 8; $i++) {
        $tmp_code .= $acceptedChars{mt_rand(0, $max)};
    }
    $code = $rand.$tmp_code;

    return $code;
}

/**
 * generate random code.
 *
 * @param int $loop
 *
 * @return string $code
 */
function random_code($loop = 5)
{
    $acceptedChars = 'abcdefghijklmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    $max = strlen($acceptedChars) - 1;
    $tmp_code = null;
    for ($i = 0; $i < $loop; $i++) {
        $tmp_code .= $acceptedChars{mt_rand(0, $max)};
    }
    $code = $tmp_code;

    return $code;
}

/**
 * generate random number.
 *
 * @param int $loop
 *
 * @return string $code
 */
function random_number($loop = 3)
{
    $acceptedChars = '23456789';
    $max = strlen($acceptedChars) - 1;
    $tmp_code = null;
    for ($i = 0; $i < $loop; $i++) {
        $tmp_code .= $acceptedChars{mt_rand(0, $max)};
    }
    $code = $tmp_code;

    return $code;
}

/**
 * generate random numbers.
 *
 * @return string random numbers
 */
function random_numbers()
{
    return date('ymdHis').substr(str_replace('.', '', (string) microtime()), 1, 2);
}

/**
 * clear browser cache.
 *
 * @author ivan lubis
 */
function clear_cache()
{
    $CI = &get_instance();
    $CI->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0');
    $CI->output->set_header('Pragma: no-cache');
}

/**
 * retrieve field value of table.
 *
 * @author ivan lubis
 *
 * @param $field field of table
 * @param $table table name
 * @param $where condition of query
 *
 * @return string value
 */
function get_value($field, $table, $where)
{
    // load ci instance
    $CI = &get_instance();
    $CI->load->database();

    $val = '';
    $sql = 'SELECT '.$field.' FROM '.$table.' WHERE '.$where;
    $query = $CI->db->query($sql);
    foreach ($query->result_array() as $r) {
        $val = $r[$field];
    }

    return $val;
}

/**
 * get option list by array.
 *
 * @param array  $option
 * @param string $selected
 *
 * @return string $return
 */
function getOptionSelect($option = [], $selected = '')
{
    $return = '';
    for ($a = 0; $a < count($option); $a++) {
        if ($selected != '' && $selected == $option[$a]) {
            $return .= '<option value="'.$option[$a].'" selected="selected">'.$option[$a].'</option>';
        } else {
            $return .= '<option value="'.$option[$a].'">'.$option[$a].'</option>';
        }
    }

    return $return;
}

/**
 * get option publish select.
 *
 * @param type $selected
 *
 * @return string
 */
function getOptionSelectPublish($selected = '')
{
    $return = '';
    $pub[] = 'Not Publish';
    $pub[] = 'Publish';
    for ($a = 1; $a >= 0; $a--) {
        $sel = '';
        if ($selected == $a && $selected != '') {
            $sel = 'selected="selected"';
        }
        $return .= '<option value="'.$a.'" '.$sel.'>'.$pub[$a].'</option>';
    }

    return $return;
}

/**
 * insert log user activity to database.
 *
 * @author ivan lubis
 *
 * @param $data data array to insert
 */
function insert_to_log($data)
{
    // load ci instance
    $CI = &get_instance();
    $CI->load->database();

    $CI->db->insert('logs', $data);
}

/**
 * enconding url characters.
 *
 * @author ivan lubis
 *
 * @param $string  string value to encode
 *
 * @return encoded string value
 */
function myUrlEncode($string)
{
    $entities = [' ', '!', '*', "'", '(', ')', ';', ':', '@', '&', '=', '+', '$', ',', '/', '?', '[', ']', '(', ')'];
    $replacements = ['%20', '%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%5B', '%5D', '&#40;', '&#41;'];

    return str_replace($entities, $replacements, $string);
}

/**
 * decoding url characters.
 *
 * @author ivan lubis
 *
 * @param $string string value to decode
 *
 * @return decoded string value
 */
function myUrlDecode($string)
{
    $entities = ['%20', '%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%5B', '%5D', '&#40;', '&#41;'];
    $replacements = [' ', '!', '*', "'", '(', ')', ';', ':', '@', '&', '=', '+', '$', ',', '/', '?', '[', ']', '(', ')'];

    return str_replace($entities, $replacements, $string);
}

/**
 * form validation : check characters only alpha, numeric, dash.
 *
 * @param type $str
 *
 * @return type
 */
function mycheck_alphadash($str)
{
    if (preg_match('/^[a-z0-9_-]+$/i', $str)) {
        return true;
    } else {
        return false;
    }
}

/**
 * form validation : check iso date.
 *
 * @param string $str
 *
 * @return bool true/false
 */
function mycheck_isodate($str)
{
    if (preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $str)) {
        return true;
    } else {
        return false;
    }
}

/**
 * form validation : check email.
 *
 * @author ivan lubis
 *
 * @param $str string value to check
 *
 * @return string true or false
 */
function mycheck_email($str)
{
    $str = strtolower($str);

    return preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $str);
}

/**
 * form validation : check phone number.
 *
 * @param string $string
 *
 * @return bool
 */
function mycheck_phone($string)
{
    if (preg_match('/^[+]?([\d]{0,3})?[\(\.\-\s]?([\d]{3})[\)\.\-\s]*([\d]{3})[\.\-\s]?([\d]{4})$/', $string)) {
        return true;
    } else {
        return false;
    }
}

/**
 * @param string $string
 * @param int    $decimal
 * @param string $thousands_sep
 * @param string $dec_point
 *
 * @return string number_format()
 */
function myprice($string, $decimal = 0, $thousands_sep = '.', $dec_point = ',')
{
    return number_format($string, $decimal, $dec_point, $thousands_sep);
}

/**
 * clean data from xss.
 *
 * @author ivan lubis
 *
 * @return string clean data from xss
 */
function xss_clean_data($string)
{
    $CI = &get_instance();
    $return = $CI->security->xss_clean($string);

    return $return;
}

/**
 * check validation of upload file.
 *
 * @author ivan lubis
 *
 * @param $str string file to check
 * @param $max_size (optional) set maximum of file size, default is 4 MB
 *
 * @return true or false
 */
function check_file_size($str, $max_size = 0)
{
    if (!$max_size) {
        $max_size = IMG_UPLOAD_MAX_SIZE;
    }
    $file_size = $str['size'];
    if ($file_size > $max_size) {
        return false;
    } else {
        return true;
    }
}

/**
 * check validation of image type.
 *
 * @author ivan lubis
 *
 * @param $source_pic string file to check
 *
 * @return true or false
 */
function check_image_type($source_pic)
{
    $image_info = check_mime_type($source_pic);

    switch ($image_info) {
        case 'image/gif':
            return true;
            break;

        case 'image/jpeg':
            return true;
            break;

        case 'image/png':
            return true;
            break;

        case 'image/wbmp':
            return true;
            break;

        default:
            return false;
            break;
    }
}

/**
 * check validation of image type in array.
 *
 * @author ivan lubis
 *
 * @param $source_pic string file to check
 *
 * @return true or false
 */
function check_image_type_array($source_pic)
{
    switch ($source_pic) {
        case 'image/gif':
            return true;
            break;

        case 'image/jpeg':
            return true;
            break;

        case 'image/png':
            return true;
            break;

        case 'image/wbmp':
            return true;
            break;

        default:
            return false;
            break;
    }
}

/**
 * check validation of file type.
 *
 * @author ivan lubis
 *
 * @param $source string file to check
 *
 * @return true or false
 */
function check_file_type($source)
{
    $file_info = check_mime_type($source);

    switch ($file_info) {
        case 'application/pdf':
            return true;
            break;

        case 'application/msword':
            return true;
            break;

        case 'application/rtf':
            return true;
            break;
        case 'application/vnd.ms-excel':
            return true;
            break;

        case 'application/vnd.ms-powerpoint':
            return true;
            break;

        case 'application/vnd.oasis.opendocument.text':
            return true;
            break;

        case 'application/vnd.oasis.opendocument.spreadsheet':
            return true;
            break;

        case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
            return true;
            break;

        case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
            return true;
            break;

        case 'image/gif':
            return true;
            break;

        case 'image/jpeg':
            return true;
            break;

        case 'image/png':
            return true;
            break;

        case 'image/wbmp':
            return true;
            break;

        default:
            return false;
            break;
    }
}

/**
 * get mime upload file.
 *
 * @author ivan lubis
 *
 * @param $source string file to check
 *
 * @return string mime type
 */
function check_mime_type($source)
{
    $mime_types = [
        // images
        'png'  => 'image/png',
        'jpe'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpg'  => 'image/jpeg',
        'gif'  => 'image/gif',
        'bmp'  => 'image/bmp',
        'ico'  => 'image/vnd.microsoft.icon',
        'tiff' => 'image/tiff',
        'tif'  => 'image/tiff',
        'svg'  => 'image/svg+xml',
        'svgz' => 'image/svg+xml',
        // adobe
        'pdf' => 'application/pdf',
        // ms office
        'doc'  => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'rtf'  => 'application/rtf',
        'xls'  => 'application/vnd.ms-excel',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'ppt'  => 'application/vnd.ms-powerpoint',
        // open office
        'odt' => 'application/vnd.oasis.opendocument.text',
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
    ];
    $arrext = explode('.', $source['name']);
    $jml = count($arrext) - 1;
    $ext = $arrext[$jml];
    $ext = strtolower($ext);
    //$ext = strtolower(array_pop(explode(".", $source['name'])));
    if (array_key_exists($ext, $mime_types)) {
        return $mime_types[$ext];
    } elseif (function_exists('finfo_open')) {
        $finfo = finfo_open(FILEINFO_MIME);
        $mimetype = finfo_file($finfo, $source['tmp_name']);
        finfo_close($finfo);

        return $mimetype;
    } else {
        return false;
    }
}

/**
 * function validatePicture.
 *
 * validation for file upload from form
 *
 * @param string $fieldname
 *                          fieldname of input file form
 */
function validatePicture($fieldname)
{
    $error = '';
    if (!empty($_FILES[$fieldname]['error'])) {
        switch ($_FILES[$fieldname]['error']) {
            case '1':
                $error = 'Upload maximum file is '.number_format(IMG_UPLOAD_MAX_SIZE / 1024, 2).' MB.';
                break;
            case '2':
                $error = 'File is too big, please upload with smaller size.';
                break;
            case '3':
                $error = 'File uploaded, but only halef of file.';
                break;
            case '4':
                $error = 'There is no File to upload';
                break;
            case '6':
                $error = 'Temporary folder not exists, Please try again.';
                break;
            case '7':
                $error = 'Failed to record File into disk.';
                break;
            case '8':
                $error = 'Upload file has been stop by extension.';
                break;
            case '999':
            default:
                $error = 'No error code avaiable';
        }
    } elseif (empty($_FILES[$fieldname]['tmp_name']) || $_FILES[$fieldname]['tmp_name'] == 'none') {
        $error = 'There is no File to upload.';
    } elseif ($_FILES[$fieldname]['size'] > IMG_UPLOAD_MAX_SIZE) {
        $error = 'Upload maximum file is '.number_format(IMG_UPLOAD_MAX_SIZE / 1024, 2).' MB.';
    } else {
        //$get_ext = substr($_FILES[$fieldname]['name'],strlen($_FILES[$fieldname]['name'])-3,3);
        $cekfileformat = check_image_type($_FILES[$fieldname]);
        if (!$cekfileformat) {
            $error = 'Upload Picture only allow (jpg, gif, png)';
        }
    }

    return $error;
}

/**
 * private function validateFile.
 *
 * validation for file upload from form
 *
 * @param string $fieldname
 *                          fieldname of input file form
 */
function validateFile($fieldname)
{
    $error = '';
    if (!empty($_FILES[$fieldname]['error'])) {
        switch ($_FILES[$fieldname]['error']) {
            case '1':
                $error = 'Upload maximum file is 4 MB.';
                break;
            case '2':
                $error = 'File is too big, please upload with smaller size.';
                break;
            case '3':
                $error = 'File uploaded, but only halef of file.';
                break;
            case '4':
                $error = 'There is no File to upload';
                break;
            case '6':
                $error = 'Temporary folder not exists, Please try again.';
                break;
            case '7':
                $error = 'Failed to record File into disk.';
                break;
            case '8':
                $error = 'Upload file has been stop by extension.';
                break;
            case '999':
            default:
                $error = 'No error code avaiable';
        }
    } elseif (empty($_FILES[$fieldname]['tmp_name']) || $_FILES[$fieldname]['tmp_name'] == 'none') {
        $error = 'There is no File to upload.';
    } elseif ($_FILES[$fieldname]['size'] > FILE_UPLOAD_MAX_SIZE) {
        $error = 'Upload maximum file is '.number_format(FILE_UPLOAD_MAX_SIZE / 1024, 2).' MB.';
    } else {
        //$get_ext = substr($_FILES[$fieldname]['name'],strlen($_FILES[$fieldname]['name'])-3,3);
        $cekfileformat = check_file_type($_FILES[$fieldname]);
        if (!$cekfileformat) {
            $error = 'Upload File only allow (jpg, gif, png, pdf, doc, xls, xlsx, docx)';
        }
    }

    return $error;
}

/**
 * debug variable.
 *
 * @author ivan lubis
 *
 * @param $datadebug string data to debug
 *
 * @return print debug data
 */
function debugvar($datadebug)
{
    echo '<pre>';
    print_r($datadebug);
    echo '</pre>';
}

/**
 * set number to rupiah format.
 *
 * @author ivan lubis
 *
 * @param $angka string number to change format
 *
 * @return string format idr
 */
function rupiah($angka)
{
    $rupiah = '';
    $rp = strlen($angka);
    while ($rp > 3) {
        $rupiah = '.'.substr($angka, -3).$rupiah;
        $s = strlen($angka) - 3;
        $angka = substr($angka, 0, $s);
        $rp = strlen($angka);
    }
    $rupiah = 'Rp.'.$angka.$rupiah.',-';

    return $rupiah;
}

/**
 * upload file to destination folder, return file name.
 *
 * @author ivan lubis
 *
 * @param $source_file string of source file
 * @param $destination_folder string destination upload folder
 * @param $filename string file name
 *
 * @return string edited filename
 */
function file_copy_to_folder($source_file, $destination_folder, $filename)
{
    $arrext = explode('.', $source_file['name']);
    $jml = count($arrext) - 1;
    $ext = $arrext[$jml];
    $ext = strtolower($ext);
    $ret = false;
    if (!is_dir($destination_folder)) {
        mkdir($destination_folder, 0755);
    }
    $destination_folder .= $filename.'.'.$ext;

    if (@move_uploaded_file($source_file['tmp_name'], $destination_folder)) {
        $ret = $filename.'.'.$ext;
    }

    return $ret;
}

/**
 * upload multiple(array) file to destination folder, return array of file name.
 *
 * @author ivan lubis
 *
 * @param $source_file array string of source file
 * @param $destination_folder string destination upload folder
 * @param $filename string of file name
 *
 * @return string of edited filename
 */
function file_arr_copy_to_folder($source_file, $destination_folder, $filename)
{
    $tmp_destination = $destination_folder;
    for ($index = 0; $index < count($source_file['tmp_name']); $index++) {
        $arrext = explode('.', $source_file['name'][$index]);
        $jml = count($arrext) - 1;
        $ext = $arrext[$jml];
        $ext = strtolower($ext);
        $destination_folder = $tmp_destination.$filename[$index].'.'.$ext;

        if (@move_uploaded_file($source_file['tmp_name'][$index], $destination_folder)) {
            $ret[$index] = $filename[$index].'.'.$ext;
        }
    }

    return $ret;
}

/**
 * upload image to destination folder, return file name.
 *
 * @author ivan lubis
 *
 * @param $source_pic string source file
 * @param $destination_folder string destination upload folder
 * @param $filename string file name
 * @param $max_width string maximum image width
 * @param $max_height string maximum image height
 *
 * @return string of edited file name
 */
function image_resize_to_folder($source_pic, $destination_folder, $filename, $max_width, $max_height)
{
    $image_info = getimagesize($source_pic['tmp_name']);
    $source_pic_name = $source_pic['name'];
    $source_pic_tmpname = $source_pic['tmp_name'];
    $source_pic_size = $source_pic['size'];
    $source_pic_width = $image_info[0];
    $source_pic_height = $image_info[1];
    if (!is_dir($destination_folder)) {
        mkdir($destination_folder, 0755);
    }

    $x_ratio = $max_width / $source_pic_width;
    $y_ratio = $max_height / $source_pic_height;

    if (($source_pic_width <= $max_width) && ($source_pic_height <= $max_height)) {
        $tn_width = $source_pic_width;
        $tn_height = $source_pic_height;
    } elseif (($x_ratio * $source_pic_height) < $max_height) {
        $tn_height = ceil($x_ratio * $source_pic_height);
        $tn_width = $max_width;
    } else {
        $tn_width = ceil($y_ratio * $source_pic_width);
        $tn_height = $max_height;
    }

    switch ($image_info['mime']) {
        case 'image/gif':
            if (imagetypes() & IMG_GIF) {
                $src = imagecreatefromgif($source_pic['tmp_name']);
                $destination_folder .= "$filename.gif";
                $namafile = "$filename.gif";
            }
            break;

        case 'image/jpeg':
            if (imagetypes() & IMG_JPG) {
                $src = imagecreatefromjpeg($source_pic['tmp_name']);
                $destination_folder .= "$filename.jpg";
                $namafile = "$filename.jpg";
            }
            break;

        case 'image/pjpeg':
            if (imagetypes() & IMG_JPG) {
                $src = imagecreatefromjpeg($source_pic['tmp_name']);
                $destination_folder .= "$filename.jpg";
                $namafile = "$filename.jpg";
            }
            break;

        case 'image/png':
            if (imagetypes() & IMG_PNG) {
                $src = imagecreatefrompng($source_pic['tmp_name']);
                $destination_folder .= "$filename.png";
                $namafile = "$filename.png";
            }
            break;

        case 'image/wbmp':
            if (imagetypes() & IMG_WBMP) {
                $src = imagecreatefromwbmp($source_pic['tmp_name']);
                $destination_folder .= "$filename.bmp";
                $namafile = "$filename.bmp";
            }
            break;
    }

    //chmod($destination_pic,0777);
    $tmp = imagecreatetruecolor($tn_width, $tn_height);
    imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tn_width, $tn_height, $source_pic_width, $source_pic_height);

    //**** 100 is the quality settings, values range from 0-100.
    switch ($image_info['mime']) {
        case 'image/jpeg':
            imagejpeg($tmp, $destination_folder, 100);
            break;

        case 'image/gif':
            imagegif($tmp, $destination_folder, 100);
            break;

        case 'image/png':
            imagepng($tmp, $destination_folder);
            break;

        default:
            imagejpeg($tmp, $destination_folder, 100);
            break;
    }

    return $namafile;
}

/**
 * copy image and resize it to destination folder.
 *
 * @param string $source_file
 * @param string $destination_folder
 * @param string $filename
 * @param string $max_width
 * @param string $max_height
 *
 * @return string $namafile file name
 */
function copy_image_resize_to_folder($source_file, $destination_folder, $filename, $max_width, $max_height)
{
    $image_info = getimagesize($source_file);
    $source_pic_width = $image_info[0];
    $source_pic_height = $image_info[1];

    $x_ratio = $max_width / $source_pic_width;
    $y_ratio = $max_height / $source_pic_height;

    if (($source_pic_width <= $max_width) && ($source_pic_height <= $max_height)) {
        $tn_width = $source_pic_width;
        $tn_height = $source_pic_height;
    } elseif (($x_ratio * $source_pic_height) < $max_height) {
        $tn_height = ceil($x_ratio * $source_pic_height);
        $tn_width = $max_width;
    } else {
        $tn_width = ceil($y_ratio * $source_pic_width);
        $tn_height = $max_height;
    }

    if (!is_dir($destination_folder)) {
        mkdir($destination_folder, 0755);
    }

    switch ($image_info['mime']) {
        case 'image/gif':
            if (imagetypes() & IMG_GIF) {
                $src = imagecreatefromgif($source_file);
                $destination_folder .= "$filename.gif";
                $namafile = "$filename.gif";
            }
            break;

        case 'image/jpeg':
            if (imagetypes() & IMG_JPG) {
                $src = imagecreatefromjpeg($source_file);
                $destination_folder .= "$filename.jpg";
                $namafile = "$filename.jpg";
            }
            break;

        case 'image/pjpeg':
            if (imagetypes() & IMG_JPG) {
                $src = imagecreatefromjpeg($source_file);
                $destination_folder .= "$filename.jpg";
                $namafile = "$filename.jpg";
            }
            break;

        case 'image/png':
            if (imagetypes() & IMG_PNG) {
                $src = imagecreatefrompng($source_file);
                $destination_folder .= "$filename.png";
                $namafile = "$filename.png";
            }
            break;

        case 'image/wbmp':
            if (imagetypes() & IMG_WBMP) {
                $src = imagecreatefromwbmp($source_file);
                $destination_folder .= "$filename.bmp";
                $namafile = "$filename.bmp";
            }
            break;
    }

    $tmp = imagecreatetruecolor($tn_width, $tn_height);
    imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tn_width, $tn_height, $source_pic_width, $source_pic_height);

    //**** 100 is the quality settings, values range from 0-100.
    switch ($image_info['mime']) {
        case 'image/jpeg':
            imagejpeg($tmp, $destination_folder, 100);
            break;

        case 'image/gif':
            imagegif($tmp, $destination_folder, 100);
            break;

        case 'image/png':
            imagepng($tmp, $destination_folder);
            break;

        default:
            imagejpeg($tmp, $destination_folder, 100);
            break;
    }

    return $namafile;
}

/**
 * upload image to destination folder, return file name.
 *
 * @author ivan lubis
 *
 * @param $source_pic array string source file
 * @param $destination_folder string destination upload folder
 * @param $filename string file name
 * @param $max_width string maximum image width
 * @param $max_height string maximum image height
 *
 * @return array string of edited file name
 */
function image_arr_resize_to_folder($source_pic, $destination_folder, $filename, $max_width, $max_height)
{
    $tmp_dest = $destination_folder;
    for ($index = 0; $index < count($source_pic['tmp_name']); $index++) {
        $destination_folder = $tmp_dest;
        $image_info = getimagesize($source_pic['tmp_name'][$index]);
        $source_pic_name = $source_pic['name'][$index];
        $source_pic_tmpname = $source_pic['tmp_name'][$index];
        $source_pic_size = $source_pic['size'][$index];
        $source_pic_width = $image_info[0];
        $source_pic_height = $image_info[1];
        $x_ratio = $max_width / $source_pic_width;
        $y_ratio = $max_height / $source_pic_height;

        if (($source_pic_width <= $max_width) && ($source_pic_height <= $max_height)) {
            $tn_width = $source_pic_width;
            $tn_height = $source_pic_height;
        } elseif (($x_ratio * $source_pic_height) < $max_height) {
            $tn_height = ceil($x_ratio * $source_pic_height);
            $tn_width = $max_width;
        } else {
            $tn_width = ceil($y_ratio * $source_pic_width);
            $tn_height = $max_height;
        }

        switch ($image_info['mime']) {
            case 'image/gif':
                if (imagetypes() & IMG_GIF) {
                    $src = imagecreatefromgif($source_pic['tmp_name'][$index]);
                    $destination_folder .= "$filename[$index].gif";
                    $namafile = "$filename[$index].gif";
                }
                break;

            case 'image/jpeg':
                if (imagetypes() & IMG_JPG) {
                    $src = imagecreatefromjpeg($source_pic['tmp_name'][$index]);
                    $destination_folder .= "$filename[$index].jpg";
                    $namafile = "$filename[$index].jpg";
                }
                break;

            case 'image/pjpeg':
                if (imagetypes() & IMG_JPG) {
                    $src = imagecreatefromjpeg($source_pic['tmp_name'][$index]);
                    $destination_folder .= "$filename[$index].jpg";
                    $namafile = "$filename[$index].jpg";
                }
                break;

            case 'image/png':
                if (imagetypes() & IMG_PNG) {
                    $src = imagecreatefrompng($source_pic['tmp_name'][$index]);
                    $destination_folder .= "$filename[$index].png";
                    $namafile = "$filename[$index].png";
                }
                break;

            case 'image/wbmp':
                if (imagetypes() & IMG_WBMP) {
                    $src = imagecreatefromwbmp($source_pic['tmp_name'][$index]);
                    $destination_folder .= "$filename[$index].bmp";
                    $namafile = "$filename[$index].bmp";
                }
                break;
        }

        //chmod($destination_pic,0777);
        $tmp = imagecreatetruecolor($tn_width, $tn_height);
        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tn_width, $tn_height, $source_pic_width, $source_pic_height);

        //**** 100 is the quality settings, values range from 0-100.
        switch ($image_info['mime']) {
            case 'image/jpeg':
                imagejpeg($tmp, $destination_folder, 100);
                break;

            case 'image/gif':
                imagegif($tmp, $destination_folder, 100);
                break;

            case 'image/png':
                imagepng($tmp, $destination_folder);
                break;

            default:
                imagejpeg($tmp, $destination_folder, 100);
                break;
        }
        $url[] = $namafile;
    }

    return $url;
}

/**
 * crop image.
 *
 * @author ivan lubis
 *
 * @param $nw string new width
 * @param $nh string new height
 * @param $source string source file
 * @param $dest string destination folder
 */
function cropImage($nw, $nh, $source, $dest)
{
    $image_info = getimagesize($source);
    $w = $image_info[0];
    $h = $image_info[1];

    switch ($image_info['mime']) {
        case 'image/gif':
            $simg = imagecreatefromgif($source);
            break;
        case 'image/jpeg':
            $simg = imagecreatefromjpeg($source);
            break;
        case 'image/pjpeg':
            $simg = imagecreatefromjpeg($source);
            break;
        case 'png':
            $simg = imagecreatefrompng($source);
            break;
    }

    $dimg = imagecreatetruecolor($nw, $nh);
    $wm = $w / $nw;
    $hm = $h / $nh;
    $h_height = $nh / 2;
    $w_height = $nw / 2;

    if ($w > $h) {
        $adjusted_width = $w / $hm;
        $half_width = $adjusted_width / 2;
        $int_width = $half_width - $w_height;

        imagecopyresampled($dimg, $simg, -$int_width, 0, 0, 0, $adjusted_width, $nh, $w, $h);
    } elseif (($w < $h) || ($w == $h)) {
        $adjusted_height = $h / $wm;
        $half_height = $adjusted_height / 2;
        $int_height = $half_height - $h_height;
        imagecopyresampled($dimg, $simg, 0, -$int_height, 0, 0, $nw, $adjusted_height, $w, $h);
    } else {
        imagecopyresampled($dimg, $simg, 0, 0, 0, 0, $nw, $nh, $w, $h);
    }
    imagejpeg($dimg, $dest, 100);
}

/**
 * get option list.
 *
 * @param type $options
 * @param type $selected
 * @param type $type
 * @param type $name
 *
 * @return string $temp_list
 */
function getOptions($options = [], $selected = '', $type = 'option', $name = 'option_list')
{
    $tmp_list = '';
    for ($a = 0; $a < count($options); $a++) {
        $set_select = '';
        if ($selected == $options[$a]) {
            $set_select = 'selected="selected"';
        }

        if ($type == 'option') {
            $tmp_list .= '<option value="'.$options[$a].'" '.$set_select.'>'.$options[$a].'</option>';
        } else {
            $tmp_list .= '<label for="opt-'.$a.'"><input name="'.$name.'" id="opt-'.$a.'" value="'.$options[$a].'" type="'.$type.'"/>'.$options[$a].'&nbsp; </label>';
        }
    }

    return $tmp_list;
}

/**
 * mark up price.
 *
 * @param int $price
 * @param int $precision
 *
 * @return string $new_price
 */
function markupPrice($price = 0, $precision = 0)
{
    $price = (int) $price;
    if (!$price) {
        return '0';
    }
    // get margin price first
    $margin = MARGIN_PRICE;
    $percentage = round(($margin / 100) * $price, $precision);
    $new_price = $price + $percentage;

    return $new_price;
}

/**
 * get languange text by key.
 *
 * @param string $key
 *
 * @return string text language
 */
function get_lang_key($key)
{
    $CI = &get_instance();

    return $CI->lang->line($key);
}

/**
 * get message by language.
 *
 * @param string $type
 * @param string $key
 * @param string $lang
 *
 * @return string message
 */
function get_lang_text($type, $key, $lang = '')
{
    $CI = &get_instance();
    if (!$lang) {
        $lang = $CI->config->item('language');
    }
    $CI->lang->load($type, $lang);

    return $CI->lang->line($key);
}

/**
 * get language by uri.
 *
 * @return string language
 */
function get_lang_url()
{
    $CI = &get_instance();
    if ($CI->uri->segment(1)) {
        return $CI->uri->segment(1);
    } else {
        return 'en';
    }
}

/**
 * simple bug fix for array_keys when returning key is 0.
 *
 * @param $needle string
 * @param $haystack array
 * $return key of array or false
 */
function recursive_array_search($needle, $haystack)
{
    foreach ($haystack as $key => $value) {
        $current_key = $key;
        if ($needle === $value or (is_array($value) && recursive_array_search($needle, $value) !== false)) {
            return $current_key;
        }
    }

    return false;
}

/**
 * customizing pagination (w/ bootstrap template).
 *
 * @param array $param parameters
 *
 * @return string $return print pagination
 */
function custom_pagination($param = [])
{
    $CI = &get_instance();
    $CI->load->library('pagination');
    $paging = [];
    $paging['num_links'] = 4;
    $paging['enable_query_strings'] = true;
    $paging['page_query_string'] = true;
    $paging['query_string_segment'] = 'perpage';
    $paging['first_link'] = false;
    $paging['last_link'] = false;
    $paging['attributes'] = ['class' => 'paging-number'];
    $paging['full_tag_open'] = '<ul class="pagination">';
    $paging['full_tag_close'] = '</ul>';
    $paging['num_tag_open'] = '<li>';
    $paging['num_tag_close'] = '</li>';
    $paging['cur_tag_open'] = '<li><a class="current">';
    $paging['cur_tag_close'] = '</a></li>';
    $paging['prev_link'] = '<span aria-hidden="true">&laquo;</span>';
    $paging['prev_tag_open'] = '<li class="button btn-page-arrow">';
    $paging['prev_tag_close'] = '</li>';
    $paging['next_link'] = '<span aria-hidden="true">&raquo;</span>';
    $paging['next_tag_open'] = '<li class="button btn-page-arrow">';
    $paging['next_tag_close'] = '</li>';
    $paging['display_prev_link'] = true;
    $paging['display_next_link'] = true;
    $paging['data_page_attr'] = 'data-page';
    foreach ($param as $key => $value) {
        $paging[$key] = $value;
    }
    $CI->pagination->initialize($paging);

    return $CI->pagination->create_links();
}

/**
 * customize send email.
 *
 * @param mixed  $from
 * @param mixed  $to
 * @param string $subject
 * @param string $body
 * @param mixed  $attachment
 * @param string $method
 */
function custom_send_email_ci($from, $to, $subject, $body, $attachment = '', $method = 'smtp')
{
    $CI = &get_instance();
    $CI->load->library('email');
    $config['mailtype'] = 'html';
    $config['useragent'] = '';
    // smtp
    if ($method == 'smtp') {
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'smtp2.bigtv.co.id';
        $config['smtp_user'] = 'bramadhanus';
        $config['smtp_pass'] = '123456Br';
        $config['smtp_port'] = 587;
    }
    $CI->email->initialize($config);
    if (is_array($from)) {
        $CI->email->from($from['email'], $from['name']);
    } else {
        $CI->email->from($from);
    }
    if (is_array($to)) {
        foreach ($to as $email_to) {
            $CI->email->to($email_to);
        }
    } else {
        $CI->email->to($from);
    }
    if ($attachment != '') {
        $CI->email->attach($attachment);
    }
    $CI->email->set_alt_message('bigtvhd.com');
    $CI->email->subject($subject);
    $data_email['email_title'] = $subject;
    $data_email['email_content'] = $body;
    $email_template_body = $CI->load->view(TEMPLATE_DIR.'/layout/email_template', $data_email, true);
    $CI->email->message($email_template_body);
    $CI->email->send();
    //echo $CI->email->print_debugger();
    $CI->email->clear(true);
}

/**
 * customize send email.
 *
 * @param mixed  $from
 * @param mixed  $to
 * @param string $subject
 * @param string $body
 * @param mixed  $attachment
 * @param string $method
 */
function custom_send_email($from, $to, $subject, $body, $attachment = '')
{
    $CI = &get_instance();
    $CI->load->library('FAT_PHPMailer');
    $mail = new PHPMailer();
    $mail->IsSMTP(); // we are going to use SMTP
    $mail->SMTPAuth = true; // enabled SMTP authentication
    // $mail->SMTPSecure = "ssl";  // prefix for secure protocol to connect to the server
    $mail->Host = 'smtp2.bigtv.co.id';      // setting GMail as our SMTP server
    $mail->Port = 587;                   // SMTP port to connect to GMail
    $mail->Username = 'bramadhanus';  // user email address
    $mail->Password = '123456Br';            // password in GMail
    if (is_array($from)) {
        $mail->From = $from['email'];
        $mail->FromName = $from['name'];
    } else {
        $mail->SetFrom($from, 'BIGTV');
    }
    if (is_array($to)) {
        foreach ($to as $row => $val) {
            $mail->AddAddress($val['email'], $val['name']);
        }
        /*foreach ($to as $email_to) {
            $mail->AddAddress($email_to);
        }*/
    } else {
        $mail->AddAddress($to);
    }
    $mail->addBCC('bigtvbcc@gmail.com');
    if ($attachment != '') {
        $mail->addAttachment($attachment);
    }
    $mail->Subject = $subject;
    $data_email['email_title'] = $subject;
    $data_email['email_content'] = $body;
    $email_template_body = $CI->load->view(TEMPLATE_DIR.'/layout/email_template', $data_email, true);
    $mail->Body = $email_template_body;
    $mail->AltBody = 'BigTVHD.com';

    if (!$mail->Send()) {
        return false;
    } else {
        return true;
    }
}

/**
 * Function to get the client IP address.
 *
 * @return string
 */
function get_client_ip()
{
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP')) {
        $ipaddress = getenv('HTTP_CLIENT_IP');
    } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    } elseif (getenv('HTTP_X_FORWARDED')) {
        $ipaddress = getenv('HTTP_X_FORWARDED');
    } elseif (getenv('HTTP_FORWARDED_FOR')) {
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    } elseif (getenv('HTTP_FORWARDED')) {
        $ipaddress = getenv('HTTP_FORWARDED');
    } elseif (getenv('REMOTE_ADDR')) {
        $ipaddress = getenv('REMOTE_ADDR');
    } else {
        $ipaddress = 'UNKNOWN';
    }

    return $ipaddress;
}

/* End of file general_helper.php */
/* Location: ./application/helpers/general_helper.php */
