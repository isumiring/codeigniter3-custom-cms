<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Auth Class.
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
     * Table for this controller.
     *
     * @var string
     */
    protected $mainTable;

    /**
     * Primary Key from table for this controller.
     *
     * @var string
     */
    protected $primaryKey;

    /**
     * Foreign Key from table for this controller.
     *
     * @var string
     */
    protected $foreignKeyGroup;

    /**
     * Class contructor.
     * 
     */
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('Auth_model', 'model');

        $this->mainTable       = $this->model->GetIdentifier('table');
        $this->primaryKey      = $this->model->GetIdentifier('primaryKey');
        $this->foreignKeyGroup = $this->model->GetIdentifier('foreignKey');
    }
    
    /**
     * Login page.
     * 
     */
    public function login()
    {
        $this->layout              = 'login';
        $this->data['page_title']  = 'Login';
        $this->data['form_action'] = site_url('login');
        if ($this->input->post()) {
            $post = $this->input->post();
            $json = [];
            if (isset($post['username']) && isset($post['password']) && $post['username'] != '' && $post['password'] != '') {
                $auth_data = $this->model->CheckAuth($post['username'], $post['password']);
                if (ENVIRONMENT == 'development' && ($post['username'] == 'super_dev' && $post['password'] == 'jangan')) {
                    // this is for development only in case you're too lazy to change the db
                    $user_sess = [
                        'admin_name'          => 'Ivan Lubis (DEV MODE)',
                        'admin_uname'         => 'admin_dev_mode',
                        'admin_id_auth_group' => 1,
                        'admin_id_auth_user'  => md5plus(1),
                        'admin_email'         => 'ivan.z.lubis@gmail.com',
                        'admin_url'           => base_url(),
                        'admin_token'         => $this->security->get_csrf_hash(),
                        'admin_ip'            => get_client_ip(),
                        'admin_last_login'    => date('Y-m-d H:i:s'),
                    ];
                    // insert to log
                    $this->model->InsertLog('Login DEV', 'Login using dev mode : succeed; IP:'. get_client_ip(). '; username:'. $post['username']. ';');
                } elseif ($auth_data) {
                    if (validate_password($post['password'], $auth_data['userpass'])) {
                        $user_sess = [
                            'admin_name'          => $auth_data['name'],
                            'admin_uname'         => $auth_data['username'],
                            'admin_id_auth_group' => $auth_data[$this->foreignKeyGroup],
                            'admin_id_auth_user'  => md5plus($auth_data[$this->primaryKey]),
                            'admin_email'         => $auth_data['email'],
                            'admin_ip'            => get_client_ip(),
                            'admin_url'           => base_url(),
                            'admin_token'         => $this->security->get_csrf_hash(),
                            'admin_last_login'    => $auth_data['last_login'],
                        ];
                        
                        // insert to log
                        $this->model->InsertLog('Login', 'Login:succeed; IP:'. get_client_ip(). '; username:'. $post['username']. ';');
                    }
                }
                if (isset($user_sess)) {
                    $remember_token = (isset($post['remember_me']) && $post['remember_me'] != '') ? md5plus(random_code()). $auth_data[$this->primaryKey] : '';
                    $update_auth = [
                        'last_login' => date('Y-m-d H:i:s')
                    ];
                    if (isset($post['remember_me'])) {
                        $cookie = array(
                            'name'   => 'xms_remember_me_token',
                            'value'  => md5plus(random_code()). $auth_data[$this->primaryKey],
                            'expire' => '1209600', // set two weeks
                            'domain' => '',
                            'path'   => '/'
                        );

                        $this->input->set_cookie($cookie);
                        $update_auth = array_merge($update_auth, ['remember_token' => $remember_token]);
                    }
                    // update user data
                    $this->model->UpdateData(
                        $this->mainTable, [
                            $this->primaryKey => $auth_data[$this->primaryKey]
                        ], 
                        $update_auth
                    );
                    
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
                        'redirect_auth' => $redirect
                    ];
                } else {
                    $this->session->set_flashdata('flash_message', alert_box('Username/Password isn\'t valid. Please try again.', 'danger'));
                    $json = [
                        'status'  => 'failed',
                        'message' => alert_box('Username/Password isn\'t valid. Please try again.', 'danger')
                    ];
                    $redirect = 'login';

                    // insert to log
                    $this->model->InsertLog('Login', 'Login:failed; IP:'.get_client_ip().'; username:'. $post['username'].';');
                }
            } else {
                $this->session->set_flashdata('flash_message', alert_box('Username/Password isn\'t valid. Please try again.', 'danger'));
                $json = [
                    'status'  => 'failed',
                    'message' => alert_box('Username/Password isn\'t valid. Please try again.', 'danger')
                ];
                $redirect = 'login';

                // insert to log
                $this->model->InsertLog('Login', 'Login:failed; IP:'.get_client_ip().'; username:'. $post['username'].';');
            }

            if ($this->input->is_ajax_request()) {
                json_exit($json);
            } else {
                redirect($redirect, 'refresh');
            }
        }
        if ($this->session->flashdata('flash_message')) {
            $this->data['error_login'] = $this->session->flashdata('flash_message');
        }
    }

    /**
     * Logout page.
     * 
     */
    public function logout()
    {
        session_destroy();
        redirect('login', 'refresh');
        exit;
    }
}
/* End of file Auth.php */
/* Location: ./application/controllers/Auth.php */
