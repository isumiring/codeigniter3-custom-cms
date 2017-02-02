<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Authentication Class.
 *     hook class that check the authentication
 *
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 *
 * @version 3.0
 *
 * @category Hook
 */
class FAT_Authentication
{
    /**
     * Load Codeigniter Super Object
     * 
     * @var object
     */
    protected $CI;

    /**
     * Class constrictor.
     * 
     */
    public function __construct()
    {
        $this->CI = &get_instance();
    }

    /**
     * Check admin session authorization, return true or false.
     *
     * @author ivan lubis
     *
     * @return redirect to cms login page if not valid
     */
    public function authentication()
    {
        // make exception auth for login
        $segment_1    = $this->CI->uri->segment(1);
        $segment_2    = $this->CI->uri->segment(2);
        $fetch_class  = $this->CI->router->fetch_class();
        $fetch_method = $this->CI->router->fetch_method();

        // check remember me cookie
        if ($this->CI->input->cookie($this->CI->config->item('cookie_prefix'). 'remember_me_token')) {
            $remember_token = $this->CI->input->cookie($this->CI->config->item('cookie_prefix'). 'remember_me_token');
            $token_data = $this->CheckAuthByRememberToken($remember_token);
            if ($token_data) {
                if ( ! isset($_SESSION['ADM_SESS'])) {
                    // create new session
                    $user_sess = [
                        'admin_name'          => $token_data['name'],
                        'admin_uname'         => $token_data['username'],
                        'admin_id_auth_group' => $token_data['id_auth_group'],
                        'admin_id_auth_user'  => md5plus($token_data['id_auth_user']),
                        'admin_email'         => $token_data['email'],
                        'admin_ip'            => get_client_ip(),
                        'admin_url'           => base_url(),
                        'admin_token'         => $this->security->get_csrf_hash(),
                        'admin_last_login'    => $token_data['last_login'],
                    ];
                    $_SESSION['ADM_SESS'] = $user_sess;
                }
            }
        }

        if ($fetch_class == 'auth' || $fetch_class == 'error') {
            if ($fetch_method == 'login') {
                if (isset($_SESSION['ADM_SESS']) && $_SESSION['ADM_SESS'] != '') {
                    redirect();
                }
            }
            return;
        } else {
            if ( ! isset($_SESSION['ADM_SESS'])) {
                if ($this->CI->input->is_ajax_request()) {
                    $_SESSION['tmp_login_redirect'] = 'dashboard';
                    $json['redirect_auth']          = site_url('login');
                    json_exit($json);
                } else {
                    $_SESSION['tmp_login_redirect'] = uri_string();
                    redirect('login', 'refresh');
                }
                return;
            } else {
                $sess = $_SESSION['ADM_SESS'];
                if (base_url() != $sess['admin_url'] || $sess['admin_token'] != $this->CI->security->get_csrf_hash() || $_SERVER['REMOTE_ADDR'] != $sess['admin_ip']) {
                    unset($_SESSION['ADM_SESS']);
                    if ($this->CI->input->is_ajax_request()) {
                        $_SESSION['tmp_login_redirect'] = 'dashboard';
                        $json['redirect_auth']          = site_url('login');
                        json_exit($json);
                    } else {
                        $_SESSION['tmp_login_redirect'] = uri_string();
                        redirect('login', 'refresh');
                    }
                    return;
                }

                // check auth
                $id_group = $sess['admin_id_auth_group'];
                if ( ! $this->checkAuth($fetch_class, $id_group)) {
                    // show_404();
                    // $this->CI->session->sess_destroy();
                    // redirect('login');
                    redirect('error/page_forbidden', 'refresh');
                }
            }
        }
    }

    /**
     * Check Auth User By Token Key.
     * 
     * @param string $token
     * 
     * @return array|bool $data
     */
    private function CheckAuthByRememberToken($token = '')
    {
        if ( ! $token) {
            return false;
        }

        $data = $this->CI->db
                ->where('remember_token', $token)
                ->where('status', 1)
                ->limit(1)
                ->order_by('id_auth_user', 'desc')
                ->get('auth_user')
                ->row_array();

        if ($data) {
            return $data;
        }

        return false;
    }

    /**
     * Check authorization for user.
     *
     * @param string $menu
     * @param int    $id_group
     *
     * @return bool
     */
    private function checkAuth($menu, $id_group)
    {
        // exclude this uri/menu
        // this menu does not require acl
        if ( ! $menu || $menu == 'home' || $menu == 'dashboard' || $menu == '' || $menu == 'profile') {
            return true;
        }

        if ( ! is_superadmin()) {
            $this->CI->where('is_superadmin', 0);
        }

        $count = $this->CI->db
                ->from('auth_menu')
                ->where('LCASE(file)', strtolower($menu))
                ->where('id_auth_group', $id_group)
                ->join('auth_menu_group', 'auth_menu_group.id_auth_menu = auth_menu.id_auth_menu', 'left')
                ->count_all_results();

        if ($count > 0) {
            return true;
        }

        return false;
    }
}

/* End of file FAT_Authentication.php */
/* Location: ./application/hooks/FAT_Authentication.php */
