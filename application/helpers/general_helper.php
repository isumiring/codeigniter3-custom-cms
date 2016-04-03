<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Use $CI=& get_instance() for get CI instance inside the helper.
 * example : use $CI->load->database() to connect a db after you declare $CI=&get_instance().
 *
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 */

/**
 * Custom date format.
 *
 * @param string $string date
 * @param string $format format date
 *
 * @return string $return
 */
function custDateFormat($string, $format = 'Y-m-d H:i:s')
{
    $return = date($format, strtotime($string));

    return $return;
}

/**
 * Generate alert box notification with close button.
 *     style is based on bootstrap 3.
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
 * Get site setting into array.
 *
 * @return array $return
 */
function get_sitesetting()
{
    $CI = &get_instance();
    $CI->load->database();
    $query = $CI->db
                ->select('setting.type, setting.value')
                ->where('sites.id_ref_publish', 1)
                ->where('sites.is_delete', 0)
                ->where('sites.is_default', 1)
                ->join('sites', 'sites.id_site = setting.id_site', 'left')
                ->order_by('setting.id_setting', 'asc')
                ->get('setting')->result_array();

    foreach ($query as $row => $val) {
        $return[$val['type']] = $val['value'];
    }
    return $return;
}

/**
 * Get current controller value.
 *
 * @param string $param
 *
 * @return string current controller url
 */
function current_controller($param = '')
{
    $param = '/'.$param;
    $CI    = &get_instance();
    $dir   = $CI->router->directory;
    $class = $CI->router->fetch_class();

    return base_url().$dir.$class.$param;
}

/**
 * Encrypt string to md5 value.
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
 * Generate new token.
 *
 * @return string $code
 */
function generate_token()
{
    $rand          = md5(sha1('reg'.date('Y-m-d H:i:s')));
    $acceptedChars = 'abcdefghijklmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    $max           = strlen($acceptedChars) - 1;
    $tmp_code      = null;
    for ($i = 0; $i < 8; $i++) {
        $tmp_code .= $acceptedChars{mt_rand(0, $max)};
    }
    $code = $rand.$tmp_code;

    return $code;
}

/**
 * Generate random code.
 *
 * @param int $loop
 *
 * @return string $code
 */
function random_code($loop = 5)
{
    $acceptedChars = 'abcdefghijklmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    $max           = strlen($acceptedChars) - 1;
    $tmp_code      = null;
    for ($i = 0; $i < $loop; $i++) {
        $tmp_code .= $acceptedChars{mt_rand(0, $max)};
    }
    $code = $tmp_code;

    return $code;
}

/**
 * Generate random number.
 *
 * @param int $loop
 *
 * @return string $code
 */
function random_number($loop = 3)
{
    $acceptedChars = '23456789';
    $max           = strlen($acceptedChars) - 1;
    $tmp_code      = null;
    for ($i = 0; $i < $loop; $i++) {
        $tmp_code .= $acceptedChars{mt_rand(0, $max)};
    }
    $code = $tmp_code;

    return $code;
}

/**
 * Clear browser cache.
 * 
 */
function clear_cache()
{
    $CI = &get_instance();
    $CI->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0');
    $CI->output->set_header('Pragma: no-cache');
}

/**
 * Remove recursive directory.
 *
 * @param string $dir
 */
function remove_recursive_directory($dir)
{
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != '.' && $object != '..') {
                if (filetype($dir.'/'.$object) == 'dir') {
                    rrmdir($dir.'/'.$object);
                } else {
                    unlink($dir.'/'.$object);
                }
            }
        }
        reset($objects);
        rmdir($dir);
    }
}

/**
 * Retrieve field value of table.
 *
 * @param string $field field of table
 * @param string $table table name
 * @param string $where condition of query
 *
 * @return string $val value
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
 * Retrieve setting value by key.
 *
 * @param string $config_key field key
 * @param int $id_site (optional) site id
 *
 * @return string $val value
 */
function get_setting($config_key = '', $id_site = 1)
{
    // load ci instance
    $CI = &get_instance();
    $CI->load->database();
    $val = '';
    if ($config_key != '') {
        $CI->db->where('type', $config_key);
    }
    $query = $CI->db
        ->where('id_site', $id_site)
        ->get('setting');

    if ($query->num_rows() > 1) {
        $val = $query->result_array();
    } elseif ($query->num_rows() == 1) {
        $row = $query->row_array();
        $val = $row['value'];
    }

    return $val;
}

/**
 * Retrieve site info by id site.
 *
 * @param int $id_site (optional) site id
 *
 * @return string $return
 */
function get_site_info($id_site = 1)
{
    // load ci instance
    $CI = &get_instance();
    if ( ! $return = $CI->cache->get('siteInfo')) {
        $CI->load->database();

        $return = $CI->db
                ->where('id_site', $id_site)
                ->limit(1)
                ->order_by('id_site', 'desc')
                ->get('sites')->row_array();
        $CI->cache->save('siteInfo', $return);
    }

    return $return;
}

/**
 * Insert log user activity to database.
 *
 * @param array $data data to insert
 */
function insert_to_log($data)
{
    // load ci instance
    $CI = &get_instance();
    $CI->load->database();

    $CI->db->insert('logs', $data);
}

/**
 * Check page requested by ajax.
 *
 * @return bool
 */
function is_ajax_requested()
{
    /* AJAX check  */
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        return true;
    }

    return false;
}

/**
 * Enconding url characters.
 *
 * @param string $string value to encode
 *
 * @return string encoded string value
 */
function myUrlEncode($string)
{
    $entities = [' ', '!', '*', "'", '(', ')', ';', ':', '@', '&', '=', '+', '$', ',', '/', '?', '[', ']', '(', ')'];
    $replacements = ['%20', '%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%5B', '%5D', '&#40;', '&#41;'];

    return str_replace($entities, $replacements, $string);
}

/**
 * Decoding url characters.
 *
 * @param string $string value to decode
 *
 * @return string decoded string value
 */
function myUrlDecode($string)
{
    $entities = ['%20', '%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%5B', '%5D', '&#40;', '&#41;'];
    $replacements = [' ', '!', '*', "'", '(', ')', ';', ':', '@', '&', '=', '+', '$', ',', '/', '?', '[', ']', '(', ')'];

    return str_replace($entities, $replacements, $string);
}

/**
 * Form validation : check characters only alpha, numeric, dash.
 *
 * @param string $str
 *
 * @return bool
 */
function mycheck_alphadash($str)
{
    if (preg_match('/^[a-z0-9_-]+$/i', $str)) {
        return true;
    }

    return false;
}

/**
 * Form validation : check iso date.
 *
 * @param string $str
 *
 * @return bool true/false
 */
function mycheck_isodate($str)
{
    if (preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $str)) {
        return true;
    }

    return false;
}

/**
 * Form validation : check email.
 * 
 * @param string $str value to check
 *
 * @return bool true or false
 */
function mycheck_email($str)
{
    $str = strtolower($str);

    return preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $str);
}

/**
 * Form validation : check phone number.
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
 * Convert number/decimal to default price
 * 
 * @param string $string
 * @param int    $decimal
 * @param string $thousands_sep
 * @param string $dec_point
 *
 * @return string price format
 */
function myprice($string, $decimal = 0, $thousands_sep = '.', $dec_point = ',')
{
    return number_format($string, $decimal, $dec_point, $thousands_sep);
}

/**
 * Clean data from xss.
 *
 * @return string $return clean data from xss
 */
function xss_clean_data($string)
{
    $CI = &get_instance();
    $return = $CI->security->xss_clean($string);

    return $return;
}

/**
 * Check validation file size of upload file.
 *
 * @param array|object|string $str file to check
 * @param int $max_size (optional) set maximum of file size, default is 4 MB
 *
 * @return bool
 */
function check_file_size($str, $max_size = 0)
{
    if ( ! $max_size) {
        $max_size = IMG_UPLOAD_MAX_SIZE;
    }
    $file_size = $str['size'];
    if ($file_size > $max_size) {
        return false;
    }

    return true;
}

/**
 * Get mime upload file.
 *
 * @param string|array|object $source file to check
 *
 * @return string|bool mime type
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
    }

    return false;
}

/**
 * Check validation of image type.
 *
 * @param string|object|array $source_pic file to check
 *
 * @return bool
 */
function check_image_type($source_pic)
{
    $image_info = check_mime_type($source_pic);
    // allowed type of image
    $allowed_type = [
        'image/gif',
        'image/jpeg',
        'image/png',
        'image/wbmp',
    ];

    if ($image_info && in_array($allowed_type, $image_info)) {
        return true;
    }

    return false;
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
    // allowed type of file
    $allowed_type = [
        'image/gif',
        'image/jpeg',
        'image/png',
        'image/wbmp',
        'application/pdf',
        'application/msword',
        'application/rtf',
        'application/vnd.ms-excel',
        'application/vnd.ms-powerpoint',
        'application/vnd.oasis.opendocument.text',
        'application/vnd.oasis.opendocument.spreadsheet',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    ];

    if ($file_info && in_array($allowed_type, $file_info)) {
        return true;
    }

    return false;
}

/**
 * Validate upload image
 *
 * @param string $fieldname fieldname of input file form
 *
 * @return string $error
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
        $cekfileformat = check_image_type($_FILES[$fieldname]);
        if ( ! $cekfileformat) {
            $error = 'Upload Picture only allow (jpg, gif, png)';
        }
    }

    return $error;
}

/**
 * Validation for file upload from form
 *
 * @param string $fieldname fieldname of input file form
 *
 * @return string $error
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
        if ( ! $cekfileformat) {
            $error = 'Upload File only allow (jpg, gif, png, pdf, doc, xls, xlsx, docx)';
        }
    }

    return $error;
}

/**
 * Debug variable.
 *
 * @param mixed $datadebug data to debug
 *
 * @return string print debug data
 */
function debugvar($datadebug)
{
    echo '<pre>';
    print_r($datadebug);
    echo '</pre>';
}

/**
 * Set number to rupiah format.
 *
 * @param string $angka number to change format
 *
 * @return string $rupiah number format idr
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
    $rupiah = 'Rp. '.$angka.$rupiah.',-';

    return $rupiah;
}

/**
 * Upload file to destination folder, return file name.
 *
 * @param array|object $source_file source file
 * @param string $destination_folder destination upload folder
 * @param sreing $filename file name
 *
 * @return string $ret filename
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
 * Upload multiple (array) file to destination folder, return array of file name.
 *
 * @param array|object $source_file source file
 * @param string $destination_folder destination upload folder
 * @param string $filename file name
 *
 * @return string $ret filename
 */
function file_arr_copy_to_folder($source_file, $destination_folder, $filename)
{
    $tmp_destination = $destination_folder;
    $ret             = [];
    for ($index = 0; $index < count($source_file['tmp_name']); $index++) {
        $arrext             = explode('.', $source_file['name'][$index]);
        $jml                = count($arrext) - 1;
        $ext                = $arrext[$jml];
        $ext                = strtolower($ext);
        $destination_folder = $tmp_destination.$filename[$index].'.'.$ext;

        if (@move_uploaded_file($source_file['tmp_name'][$index], $destination_folder)) {
            $ret[$index] = $filename[$index].'.'.$ext;
        }
    }

    return $ret;
}

/**
 * Upload image to destination folder, return file name.
 *
 * @param array|object $source_file source file
 * @param string $destination_folder destination upload folder
 * @param string $filename file name
 * @param int $max_width maximum image width
 * @param int $max_height maximum image height
 *
 * @return string $callback_filename file name
 */
function image_resize_to_folder($source_pic, $destination_folder, $filename, $max_width, $max_height)
{
    $image_info         = getimagesize($source_pic['tmp_name']);
    $source_pic_name    = $source_pic['name'];
    $source_pic_tmpname = $source_pic['tmp_name'];
    $source_pic_size    = $source_pic['size'];
    $source_pic_width   = $image_info[0];
    $source_pic_height  = $image_info[1];
    if (!is_dir($destination_folder)) {
        mkdir($destination_folder, 0755);
    }

    $x_ratio = $max_width / $source_pic_width;
    $y_ratio = $max_height / $source_pic_height;

    if (($source_pic_width <= $max_width) && ($source_pic_height <= $max_height)) {
        $tn_width  = $source_pic_width;
        $tn_height = $source_pic_height;
    } elseif (($x_ratio * $source_pic_height) < $max_height) {
        $tn_height = ceil($x_ratio * $source_pic_height);
        $tn_width  = $max_width;
    } else {
        $tn_width  = ceil($y_ratio * $source_pic_width);
        $tn_height = $max_height;
    }

    switch ($image_info['mime']) {
        case 'image/gif':
            if (imagetypes() & IMG_GIF) {
                $src = imagecreatefromgif($source_pic['tmp_name']);
                $destination_folder .= "$filename.gif";
                $callback_filename  = "$filename.gif";
            }
            break;

        case 'image/jpeg':
            if (imagetypes() & IMG_JPG) {
                $src = imagecreatefromjpeg($source_pic['tmp_name']);
                $destination_folder .= "$filename.jpg";
                $callback_filename  = "$filename.jpg";
            }
            break;

        case 'image/pjpeg':
            if (imagetypes() & IMG_JPG) {
                $src = imagecreatefromjpeg($source_pic['tmp_name']);
                $destination_folder .= "$filename.jpg";
                $callback_filename  = "$filename.jpg";
            }
            break;

        case 'image/png':
            if (imagetypes() & IMG_PNG) {
                $src = imagecreatefrompng($source_pic['tmp_name']);
                $destination_folder .= "$filename.png";
                $callback_filename  = "$filename.png";
            }
            break;

        case 'image/wbmp':
            if (imagetypes() & IMG_WBMP) {
                $src = imagecreatefromwbmp($source_pic['tmp_name']);
                $destination_folder .= "$filename.bmp";
                $callback_filename  = "$filename.bmp";
            }
            break;
    }

    //chmod($destination_pic, 0777);
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

    return $callback_filename;
}

/**
 * Copy image and resize it to destination folder.
 *
 * @param string $source_file
 * @param string $destination_folder
 * @param string $filename
 * @param int $max_width
 * @param int $max_height
 * @param int $quality image quality
 * @param bool $ext get the extension
 *
 * @return string $callback_filename file name
 */
function copy_image_resize_to_folder($source_file, $destination_folder, $filename, $max_width, $max_height, $quality = 100, $ext = true)
{
    $image_info        = getimagesize($source_file);
    $source_pic_width  = $image_info[0];
    $source_pic_height = $image_info[1];

    $x_ratio = $max_width / $source_pic_width;
    $y_ratio = $max_height / $source_pic_height;

    if (($source_pic_width <= $max_width) && ($source_pic_height <= $max_height)) {
        $tn_width  = $source_pic_width;
        $tn_height = $source_pic_height;
    } elseif (($x_ratio * $source_pic_height) < $max_height) {
        $tn_height = ceil($x_ratio * $source_pic_height);
        $tn_width  = $max_width;
    } else {
        $tn_width  = ceil($y_ratio * $source_pic_width);
        $tn_height = $max_height;
    }

    if (!is_dir($destination_folder)) {
        mkdir($destination_folder, 0755);
    }

    switch ($image_info['mime']) {
        case 'image/gif':
            if (imagetypes() & IMG_GIF) {
                $src = imagecreatefromgif($source_file);
                $destination_folder .= ($ext == true) ? $filename .'.gif' : $filename;
                $callback_filename  = ($ext == true) ? $filename .'.gif' : $filename;
            }
            break;

        case 'image/jpeg':
            if (imagetypes() & IMG_JPG) {
                $src = imagecreatefromjpeg($source_file);
                $destination_folder .= ($ext == true) ? $filename .'.jpg' : $filename;
                $callback_filename  = ($ext == true) ? $filename .".jpg" : $filename;
            }
            break;

        case 'image/pjpeg':
            if (imagetypes() & IMG_JPG) {
                $src = imagecreatefromjpeg($source_file);
                $destination_folder .= ($ext == true) ? $filename .'.jpg' : $filename;
                $callback_filename  = ($ext == true) ? $filename .".jpg" : $filename;
            }
            break;

        case 'image/png':
            if (imagetypes() & IMG_PNG) {
                $src = imagecreatefrompng($source_file);
                $destination_folder .= ($ext == true) ? $filename .'.png' : $filename;
                $callback_filename  = ($ext == true) ? $filename .".png" : $filename;
            }
            break;

        case 'image/wbmp':
            if (imagetypes() & IMG_WBMP) {
                $src = imagecreatefromwbmp($source_file);
                $destination_folder .= ($ext == true) ? $filename .'.bmp' : $filename;
                $callback_filename  = ($ext == true) ? $filename .".bmp" : $filename;
            }
            break;
    }

    $tmp = imagecreatetruecolor($tn_width, $tn_height);
    imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tn_width, $tn_height, $source_pic_width, $source_pic_height);

    //**** 100 is the quality settings, values range from 0-100.
    switch ($image_info['mime']) {
        case 'image/jpeg':
            imagejpeg($tmp, $destination_folder, $quality);
            break;

        case 'image/gif':
            imagegif($tmp, $destination_folder, $quality);
            break;

        case 'image/png':
            imagepng($tmp, $destination_folder);
            break;

        default:
            imagejpeg($tmp, $destination_folder, $quality);
            break;
    }

    return $callback_filename;
}

/**
 * Move file to folder.
 *
 * @param string $source_file
 * @param string $destination_folder
 * @param string $filename
 *
 * @return string $ret file name
 */
function move_file_to_folder($source_file, $destination_folder, $filename)
{
    $arrext = explode('.', $source_file);
    $jml    = count($arrext) - 1;
    $ext    = $arrext[$jml];
    $ext    = strtolower($ext);
    $ret    = false;
    if (!is_dir($destination_folder)) {
        mkdir($destination_folder, 0755);
    }
    $destination_folder .= $filename.'.'.$ext;

    if (rename($source_file, $destination_folder)) {
        $ret = $filename.'.'.$ext;
    }

    return $ret;
}

/**
 * Upload image (array) to destination folder, return file name.
 *
 * @param array|object $source_pic source file
 * @param string $destination_folder destination upload folder
 * @param string $filename file name
 * @param int $max_width maximum image width
 * @param int $max_height maximum image height
 *
 * @return array|string $return file name
 */
function image_arr_resize_to_folder($source_pic, $destination_folder, $filename, $max_width, $max_height)
{
    $tmp_dest = $destination_folder;
    $return   = [];
    for ($index = 0; $index < count($source_pic['tmp_name']); $index++) {
        $destination_folder = $tmp_dest;
        $image_info         = getimagesize($source_pic['tmp_name'][$index]);
        $source_pic_name    = $source_pic['name'][$index];
        $source_pic_tmpname = $source_pic['tmp_name'][$index];
        $source_pic_size    = $source_pic['size'][$index];
        $source_pic_width   = $image_info[0];
        $source_pic_height  = $image_info[1];
        $x_ratio            = $max_width / $source_pic_width;
        $y_ratio            = $max_height / $source_pic_height;

        if (($source_pic_width <= $max_width) && ($source_pic_height <= $max_height)) {
            $tn_width  = $source_pic_width;
            $tn_height = $source_pic_height;
        } elseif (($x_ratio * $source_pic_height) < $max_height) {
            $tn_height = ceil($x_ratio * $source_pic_height);
            $tn_width  = $max_width;
        } else {
            $tn_width  = ceil($y_ratio * $source_pic_width);
            $tn_height = $max_height;
        }

        switch ($image_info['mime']) {
            case 'image/gif':
                if (imagetypes() & IMG_GIF) {
                    $src                = imagecreatefromgif($source_pic['tmp_name'][$index]);
                    $destination_folder .= "$filename[$index].gif";
                    $callback_filename  = "$filename[$index].gif";
                }
                break;

            case 'image/jpeg':
                if (imagetypes() & IMG_JPG) {
                    $src                = imagecreatefromjpeg($source_pic['tmp_name'][$index]);
                    $destination_folder .= "$filename[$index].jpg";
                    $callback_filename  = "$filename[$index].jpg";
                }
                break;

            case 'image/pjpeg':
                if (imagetypes() & IMG_JPG) {
                    $src                = imagecreatefromjpeg($source_pic['tmp_name'][$index]);
                    $destination_folder .= "$filename[$index].jpg";
                    $callback_filename  = "$filename[$index].jpg";
                }
                break;

            case 'image/png':
                if (imagetypes() & IMG_PNG) {
                    $src                = imagecreatefrompng($source_pic['tmp_name'][$index]);
                    $destination_folder .= "$filename[$index].png";
                    $callback_filename  = "$filename[$index].png";
                }
                break;

            case 'image/wbmp':
                if (imagetypes() & IMG_WBMP) {
                    $src                = imagecreatefromwbmp($source_pic['tmp_name'][$index]);
                    $destination_folder .= "$filename[$index].bmp";
                    $callback_filename  = "$filename[$index].bmp";
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
        $return[] = $callback_filename;
    }

    return $return;
}

/**
 * Crop image.
 *
 * @param string|int $nw new width
 * @param string|int $nh new height
 * @param string $source source file
 * @param string $dest destination folder
 */
function cropImage($nw, $nh, $source, $dest)
{
    $image_info = getimagesize($source);
    $w          = $image_info[0];
    $h          = $image_info[1];

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

    $dimg     = imagecreatetruecolor($nw, $nh);
    $wm       = $w / $nw;
    $hm       = $h / $nh;
    $h_height = $nh / 2;
    $w_height = $nw / 2;

    if ($w > $h) {
        $adjusted_width = $w / $hm;
        $half_width     = $adjusted_width / 2;
        $int_width      = $half_width - $w_height;

        imagecopyresampled($dimg, $simg, -$int_width, 0, 0, 0, $adjusted_width, $nh, $w, $h);
    } elseif (($w < $h) || ($w == $h)) {
        $adjusted_height = $h / $wm;
        $half_height     = $adjusted_height / 2;
        $int_height      = $half_height - $h_height;

        imagecopyresampled($dimg, $simg, 0, -$int_height, 0, 0, $nw, $adjusted_height, $w, $h);
    } else {
        imagecopyresampled($dimg, $simg, 0, 0, 0, 0, $nw, $nh, $w, $h);
    }
    imagejpeg($dimg, $dest, 100);
}

/**
 * Get option list.
 *
 * @param array $options
 * @param string|int $selected
 * @param string $type
 * @param string $name
 *
 * @return string $temp_list list
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
            $tmp_list .= '<label for="opt-'.$a.'" class="'.$type.'"><input name="'.$name.'" id="opt-'.$a.'" value="'.$options[$a].'" type="'.$type.'"/>'.$options[$a].'&nbsp; </label>';
        }
    }

    return $tmp_list;
}

/**
 * Get languange text by key.
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
 * Simple bug fix for array_keys when returning key is 0.
 *
 * @param string $needle
 * @param array $haystack
 * 
 * @return int|bool $current_key key of array or false
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
 * Check exists uri path.
 *
 * @param string $table
 * @param string $path
 * @param int    $id
 *
 * @return bool true/false
 */
function check_exist_uri($table, $path, $id = 0)
{
    $CI = &get_instance();
    $CI->load->database();
    if ($id) {
        $field = ($table == 'pages') ? 'page' : $table;
        $CI->db->where('id_'.$field.' !=', $id);
    }
    $exists = $CI->db
            ->from($table)
            ->where('LCASE(uri_path)', strtolower($path))
            ->count_all_results();

    if ($exists > 0) {
        // if exists return false
        return false;
    }

    return true;
}

/**
 * Check exists value in db.
 *
 * @param string $table
 * @param string $field
 * @param string $value
 * @param int    $id
 *
 * @return bool true/false
 */
function check_exist_value($table, $field, $value, $id = 0)
{
    $CI = &get_instance();
    $CI->load->database();
    if ($id) {
        $CI->db->where('id_'.$table.' !=', $id);
    }
    $exists = $CI->db
            ->from($table)
            ->where("LCASE({$field})", strtolower($value))
            ->count_all_results();
    if ($exists > 0) {
        // if exists return false
        return false;
    }

    return true;
}

/**
 * Get message by language.
 * 
 * @param string $type
 * @param string $key
 * @param string $lang
 * 
 * @return string message
 */
function get_lang_text($type, $key, $lang = '') 
{
    $CI =& get_instance();
    if ( ! $lang) {
        $lang = $CI->config->item('language');
    }
    $CI->lang->load($type, $lang);

    return $CI->lang->line($key);
}

/**
 * Get language by uri.
 * 
 * @return string language
 */
function get_lang_url() 
{
    $CI =& get_instance();
    if ($CI->uri->segment(1)) {
        return $CI->uri->segment(1);
    }

    return 'en';
}

/**
 * Generate Password.
 *
 * @param string $value password
 *
 * @return string $hash hashed password
 */
function generate_password($value)
{
    $CI = &get_instance();
    // A higher "cost" is more secure but consumes more processing power
    $cost = 12;

    // Create a random salt
    $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM).$CI->config->item('encryption_key')), '+', '.');

    // Prefix information about the hash so PHP knows how to verify it later.
    // "$2a$" Means we're using the Blowfish algorithm. The following two digits are the cost parameter.
    $salt = sprintf('$2a$%02d$', $cost).$salt;

    $hash = crypt($value, $salt);

    return $hash;
}

/**
 * Validate a password.
 *
 * @param string $password
 * @param string $hash
 *
 * @return bool true/false
 */
function validate_password($password, $hash)
{
    if (hash_equals($hash, crypt($password, $hash))) {
        // return valid!
        return true;
    }

    return false;
}

/**
 * Print Json with header.
 *
 * @param array $params parameters
 *
 * @return string encoded json
 */
function json_exit($params)
{
    header('Content-type: application/json');
    exit(
        json_encode($params)
    );
}

/**
 * Customize sending email using default library.
 * 
 * @param mixed $from
 * @param mixed $to
 * @param string $subject
 * @param string $body
 * @param mixed $attachment
 * @param string $method
 * 
 */
function custom_send_email_ci($from, $to, $subject, $body, $attachment = '', $method = 'smtp') 
{
    $CI = &get_instance();
    $CI->load->library('email');
    $config['mailtype'] = 'html';
    $config['useragent'] = '';
    // smtp
    if ($method == 'smtp') {
        $config['protocol']     = 'smtp';
        $config['smtp_host']    = '';
        $config['smtp_port']    = '';
        $config['smtp_user']    = '';
        $config['smtp_pass']    = '';
    }
    $CI->email->initialize($config);
    if (is_array($from)) {
        $CI->email->from($from['email'], $from['name']);
    } else {
        $CI->email->from($from);
    }
    if (is_array($to)) {
        foreach ($to as $key => $email_to) {
            $CI->email->to($email_to['email']);
        }
    } else {
        $CI->email->to($to);
    }
    if ($attachment != '') {
        $CI->email->attach($attachment);
    }
    $CI->email->bcc('only.ccbcc@gmail.com');
    $CI->email->subject($subject);
    $CI->email->message($body);
    $CI->email->send();
    log_message('info', $CI->email->print_debugger());
    $CI->email->clear(TRUE);
}

/**
 * Customizing pagination (w/ bootstrap template).
 * 
 * @param  array  $param parameters
 * 
 * @return string $return print pagination
 */
function custom_pagination($param = []) 
{
    $CI = &get_instance();
    $CI->load->library('pagination');
    $paging                         = [];
    $paging['num_links']            = 4;
    $paging['enable_query_strings'] = true;
    $paging['page_query_string']    = true;
    $paging['query_string_segment'] = 'perpage';
    $paging['first_link']           = false;
    $paging['last_link']            = false;
    $paging['attributes']           = ['class' => 'paging-number'];
    $paging['full_tag_open']        = '<ul class="pagination">';
    $paging['full_tag_close']       = '</ul>';
    $paging['num_tag_open']         = '<li>';
    $paging['num_tag_close']        = '</li>';
    $paging['cur_tag_open']         = '<li class="active"><a class="current">';
    $paging['cur_tag_close']        = '</a></li>';
    $paging['prev_link']            = '<span aria-hidden="true">&laquo;</span>';
    $paging['prev_tag_open']        = '<li class="button btn-page-arrow">';
    $paging['prev_tag_close']       = '</li>';
    $paging['next_link']            = '<span aria-hidden="true">&raquo;</span>';
    $paging['next_tag_open']        = '<li class="button btn-page-arrow">';
    $paging['next_tag_close']       = '</li>';
    $paging['display_prev_link']    = false;
    $paging['display_next_link']    = false;
    $paging['data_page_attr']       = 'data-page';
    foreach ($param as $key => $value) {
        $paging[$key] = $value;
    }
    $CI->pagination->initialize($paging);

    return $CI->pagination->create_links();
}

/**
 * Get the client IP address.
 * 
 * @return string $ipaddress
 */
function get_client_ip() 
{
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

/* End of file general_helper.php */
/* Location: ./application/helpers/general_helper.php */

