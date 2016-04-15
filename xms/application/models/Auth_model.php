<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Auth Model Class.
 *
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 *
 * @version 3.0
 *
 * @category Model
 */
class Auth_model extends CI_Model
{
    /**
     * check login admin.
     *
     * @param string $username
     * @param string $password
     */
    function CheckAuth($username, $password)
    {
        $user_data = $this->db
                ->where('LCASE(username)', $username)
                ->where('status', 1)
                ->limit(1)
                ->get('auth_user')
                ->row_array();

        if ($user_data) {
            // return info auth user
            return $user_data;
        }

        return false;
    }
}
/* End of file Auth_model.php */
/* Location: ./application/models/Auth_model.php */
