<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Login Class.
 *
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 *
 * @version 3.0
 *
 * @category Controller
 */
class Auth extends CI_Controller
{
    /**
     * login page.
     */
    public function login()
    {
        $this->load->model('Auth_model');
        $this->layout              = 'login';
        $this->data['page_title']  = 'Login';
        $this->data['form_action'] = site_url('login');
        if ($this->input->post()) {
            $post = $this->input->post();
            $json = [];
            if (isset($post['username']) && isset($post['password']) && $post['username'] != '' && $post['password'] != '') {
                $auth_data = $this->Auth_model->CheckAuth($post['username'], $post['password']);
                if (ENVIRONMENT == 'development' && ($post['username'] == 'super_dev' && $post['password'] == 'jangan')) {
                    // this is for development only in case you're too lazy to change the db
                    $user_sess = [
                        'admin_name'          => 'Ivan Lubis (DEV MODE)',
                        'admin_uname'         => 'admin_dev_mode',
                        'admin_id_auth_group' => 1,
                        'admin_id_auth_user'  => md5plus(1),
                        'admin_email'         => 'ivan.z.lubis@gmail.com',
                        'admin_type'          => 'superadmin',
                        'admin_url'           => base_url(),
                        'admin_token'         => $this->security->get_csrf_hash(),
                        'admin_ip'            => get_client_ip(),
                        'admin_last_login'    => date('Y-m-d H:i:s'),
                    ];
                } elseif ($auth_data) {
                    if (validate_password($post['password'], $auth_data['userpass'])) {
                        $user_sess = [
                            'admin_name'          => $auth_data['name'],
                            'admin_uname'         => $auth_data['username'],
                            'admin_id_auth_group' => $auth_data['id_auth_group'],
                            'admin_id_auth_user'  => md5plus($auth_data['id_auth_user']),
                            'admin_email'         => $auth_data['email'],
                            'admin_ip'            => get_client_ip(),
                            'admin_url'           => base_url(),
                            'admin_token'         => $this->security->get_csrf_hash(),
                            'admin_last_login'    => $auth_data['last_login'],
                        ];
                        
                        // insert to log
                        $data = [
                            'id_user'  => $auth_data['id_auth_user'],
                            'id_group' => $auth_data['id_auth_group'],
                            'action'   => 'Login',
                            'desc'     => 'Login:succeed; IP:'.get_client_ip().'; username:'.$post['username'].';',
                        ];
                        insert_to_log($data);
                    }
                }
                if (isset($user_sess)) {
                    $remember_token = (isset($post['remember_me'])) ? md5plus(random_code()). $auth_data['id_auth_user'] : '';
                    if (isset($post['remember_me'])) {
                        $cookie = array(
                            'name'   => 'remember_me_token',
                            'value'  => md5plus(random_code()). $auth_data['id_auth_user'],
                            'expire' => '1209600', // set two weeks
                            'domain' => '',
                            'path'   => '/'
                        );

                        $this->input->set_cookie($cookie);
                    }
                    // update user data
                    $this->Auth_model->UpdateAuthData($auth_data['id_auth_user'], [
                        'last_login' => date('Y-m-d H:i:s'),
                        'remember_token' => $remember_token,
                    ]);
                    
                    // set auth session
                    $_SESSION['ADM_SESS'] = $user_sess;

                    if (isset($_SESSION['tmp_login_redirect'])) {
                        $redirect = $_SESSION['tmp_login_redirect'];
                        unset($_SESSION['tmp_login_redirect']);
                    } else {
                        $redirect = '';
                    }
                    $json = [
                        'status' => 'success',
                        'redirect_auth' => site_url($redirect)
                    ];
                } else {
                    //insert to log
                    $data = [
                        'action' => 'Login',
                        'desc'   => 'Login:failed; IP:'.get_client_ip().'; username:'.$post['username'].';',
                    ];
                    insert_to_log($data);

                    $this->session->set_flashdata('flash_message', alert_box('Username/Password isn\'t valid. Please try again.', 'danger'));
                    $json = [
                        'status'  => 'failed',
                        'message' => alert_box('Username/Password isn\'t valid. Please try again.', 'danger')
                    ];
                    $redirect = 'login';
                }
            } else {
                //insert to log
                $data = [
                    'action' => 'Login',
                    'desc'   => 'Login:failed; IP:'.get_client_ip().'; username:'.$post['username'].';',
                ];
                insert_to_log($data);

                $this->session->set_flashdata('flash_message', alert_box('Username/Password isn\'t valid. Please try again.', 'danger'));
                $json = [
                    'status'  => 'failed',
                    'message' => alert_box('Username/Password isn\'t valid. Please try again.', 'danger')
                ];
                $redirect = 'login';
            }
            if ($this->input->is_ajax_request()) {
                json_exit($json);
            } else {
                redirect($redirect);
            }
        }
        if ($this->session->flashdata('flash_message')) {
            $this->data['error_login'] = $this->session->flashdata('flash_message');
        }
    }

    /**
     * lougout page.
     */
    public function logout()
    {
        session_destroy();
        redirect('login', 'refresh');
        exit;
    }
}
/* End of file Login.php */
/* Location: ./application/controllers/Login.php */
