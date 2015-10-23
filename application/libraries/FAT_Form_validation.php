<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * custom class form validation
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @category library
 * 
 */
class FAT_Form_validation extends CI_Form_validation {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * form validation : check characters only alpha, numeric, dash
     * @param type $str
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
     * form validation : check iso date
     * @param string $str
     * @return bool true/false 
     */
    function mycheck_isodate($str)
    {
        if (preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $str)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * form validation : check email
     * @author ivan lubis
     * @param $str string value to check
     * @return string true or false
     */
    function mycheck_email($str)
    {
        if (preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', strtolower($str))) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * form validation : check name
     * @author ivan lubis
     * @param $str string value to check
     * @return string true or false
     */
    function mycheck_name($str) {
        if (preg_match("/^[a-zA-Z ]*$/",$str)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * form validation : check phone number
     * @param string $string
     * @return boolean
     */
    function mycheck_phone( $string ) {
        if ( preg_match( '/^[+]?([\d]{0,3})?[\(\.\-\s]?([\d]{3})[\)\.\-\s]*([\d]{3})[\.\-\s]?([\d]{4})$/', $string ) ) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}