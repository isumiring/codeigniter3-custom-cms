<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Auth Model Class
 * @author ivan lubis
 * @version 2.1
 * @category Model
 * @desc authentication model
 * 
 */
class Auth_model extends CI_Model
{
    /**
     * check login admin
     * @param string $username
     * @param string $password 
     */
    function CheckAuth($username, $password) {
        if ($username != '' && $password != '') {
            $username = strtolower($username);
            // this is for development only in case you're too lazy to change the db
            if (ENVIRONMENT == 'development' && ($username == 'super_dev' && $password == 'jangan')) {
                $user_sess = array(
                    'admin_name' => 'Ivan Lubis (DEV)',
                    'admin_id_auth_group' => 1,
                    'admin_id_auth_user' => md5plus(1),
                    'admin_email' => 'ivan.z.lubis@gmail.com',
                    'admin_type' => 'superadmin',
                    'admin_url' => base_url(),
                    'admin_token'=>$this->security->get_csrf_hash(),
                    'admin_ip' => $_SERVER['REMOTE_ADDR'],
                    'admin_last_login' => date('Y-m-d H:i:s'),
                );
                $_SESSION['ADM_SESS'] = $user_sess;
                if ($this->session->userdata('tmp_login_redirect') != '') {
                    redirect($this->session->userdata('tmp_login_redirect'));
                } else {
                    redirect();
                }
            }
            // end of testing dev
            $user_data = $this->db->query("SELECT * FROM " . $this->db->dbprefix('auth_user') . " WHERE LCASE(username) = ?", array($username))->row_array();
            if ($user_data) {
                if (password_verify($password,$user_data['userpass']) && $user_data['userpass'] != '') {
                    $user_sess = array(
                        'admin_name' => $user_data['name'],
                        'admin_id_auth_group' => $user_data['id_auth_group'],
                        'admin_id_auth_user' => md5plus($user_data['id_auth_user']),
                        'admin_email' => $user_data['email'],
                        'admin_type' => ($user_data['is_superadmin']) ? 'superadmin' : 'admin',
                        'admin_ip' => $_SERVER['REMOTE_ADDR'],
                        'admin_url' => base_url(),
                        'admin_token'=>$this->security->get_csrf_hash(),
                        'admin_last_login' => $user_data['last_login'],
                    );
                    $_SESSION['ADM_SESS'] = $user_sess;
                    
                    # insert to log
                    $data = array(
                        'id_user' => $user_data['id_auth_user'],
                        'id_group' => $user_data['id_auth_group'],
                        'action' => 'Login',
                        'desc' => 'Login:succeed; IP:' . $_SERVER['REMOTE_ADDR'] . '; username:' . $username . ';',
                    );
                    insert_to_log($data);
                    if ($this->session->userdata('tmp_login_redirect') != '') {
                        redirect($this->session->userdata('tmp_login_redirect'));
                    } else {
                        redirect('dashboard');
                    }
                } else {
                    # insert to log
                    $data = array(
                        'action' => 'Login',
                        'desc' => 'Login:failed; IP:' . $_SERVER['REMOTE_ADDR'] . '; username:' . $username . ';',
                    );
                    insert_to_log($data);
                }
            } else {
                #insert to log
                $data = array(
                    'action' => 'Login',
                    'desc' => 'Login:failed; IP:' . $_SERVER['REMOTE_ADDR'] . '; username:' . $username . ';',
                );
                insert_to_log($data);
            }
        }
        $this->session->set_flashdata('flash_message', alert_box('Username/Password isn\'t valid. Please try again.','danger'));
        redirect('login');
    }
}
/* End of file Auth_model.php */
/* Location: ./application/model/Auth_model.php */