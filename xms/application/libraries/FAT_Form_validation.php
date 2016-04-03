<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Custom class form validation.
 *     override/extend form validation library.
 *
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 *
 * @category library
 */
class FAT_Form_validation extends CI_Form_validation
{
    /**
     * Class constructor.
     *     load parent constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Form validation : check characters only alpha, numeric, dash.
     *
     * @param string $str
     *
     * @return bool
     */
    public function mycheck_alphadash($str)
    {
        if (!preg_match('/^[a-z0-9_-]+$/i', $str)) {
            $this->set_message('mycheck_alphadash', 'Please input your correct {field}.');

            return false;
        }

        return true;
    }

    /**
     * Form validation : check iso date.
     *
     * @param string $str
     *
     * @return bool true/false
     */
    public function mycheck_isodate($str)
    {
        if (!preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $str)) {
            $this->set_message('mycheck_isodate', 'Please input your correct {field}.');

            return false;
        }

        return true;
    }

    /**
     * Form validation : check email.
     *
     * @author ivan lubis
     *
     * @param string $str value to check
     *
     * @return bool true or false
     */
    public function mycheck_email($str)
    {
        if (!preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', strtolower($str))) {
            $this->set_message('mycheck_email', 'Please input your correct {field}.');

            return false;
        }

        return true;
    }

    /**
     * Form validation : check name.
     *
     * @author ivan lubis
     *
     * @param string $str value to check
     *
     * @return bool true or false
     */
    public function mycheck_name($str)
    {
        if (!preg_match('/^[a-zA-Z ]*$/', $str)) {
            $this->set_message('mycheck_name', 'Please input your correct {field}.');

            return false;
        }

        return true;
    }

    /**
     * Form validation : check phone number.
     *
     * @param string $str
     *
     * @return bool
     */
    public function mycheck_phone($str)
    {
        if (!preg_match('/^[+]?([\d]{0,3})?[\(\.\-\s]?([\d]{3})[\)\.\-\s]*([\d]{3})[\.\-\s]?([\d]{4})$/', $str)) {
            $this->set_message('mycheck_phone', 'Please input your correct {field}.');

            return false;
        }

        return true;
    }

    /**
     * Form validation : check password.
     *
     * @param string $str
     *
     * @return bool
     */
    public function mycheck_password($str)
    {
        if (!preg_match('#[0-9]#', $str) && preg_match('#[a-zA-Z]#', $str)) {
            $this->set_message('mycheck_password', 'Password must be combination between numbers and letters.');

            return false;
        }

        return true;
    }
}

/* End of file FAT_Form_validation.php */
/* Location: ./application/libraries/FAT_Form_validation.php */
