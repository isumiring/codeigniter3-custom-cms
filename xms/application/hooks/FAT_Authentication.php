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
     * Check admin session authorization, return true or false.
     *
     * @author ivan lubis
     *
     * @return redirect to cms login page if not valid
     */
    public function authentication()
    {
        $this->CI =& get_instance();
        // make exception auth for login
        $segment_1    = $this->CI->uri->segment(1);
        $segment_2    = $this->CI->uri->segment(2);
        $fetch_class  = $this->CI->router->fetch_class();
        $fetch_method = $this->CI->router->fetch_method();
        if ($fetch_class == 'error') {
            // allow to access error page
            return;
        }
        if ($fetch_class == 'auth') {
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
                    redirect('login');
                }
            } else {
                $sess = $_SESSION['ADM_SESS'];
                if (base_url() != $sess['admin_url'] || $sess['admin_token'] != $this->CI->security->get_csrf_hash() || $_SERVER['REMOTE_ADDR'] != $sess['admin_ip']) {
                    session_destroy();
                    if ($this->CI->input->is_ajax_request()) {
                        $_SESSION['tmp_login_redirect'] = 'dashboard';
                        $json['redirect_auth']          = site_url('login');
                        json_exit($json);
                    } else {
                        $_SESSION['tmp_login_redirect'] = uri_string();
                        redirect('login');
                    }
                }

                // check auth
                $id_group = $sess['admin_id_auth_group'];
                if ( ! $this->checkAuth($fetch_class, $id_group)) {
                    show_404();
                    // $this->CI->session->sess_destroy();
                    // redirect('login');
                }
            }
        }
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
        $this->CI = &get_instance();
        $this->CI->load->database();
        // exclude this uri/menu
        // this menu does not require acl
        if ( ! $menu || $menu == 'home' || $menu == 'dashboard' || $menu == '' || $menu == 'profile') {
            return true;
        }

        if (is_superadmin()) {
            $count = $this->CI->db
                    ->from('auth_menu')
                    ->where('LCASE(file)', strtolower($menu))
                    ->where('id_auth_group', $id_group)
                    ->join('auth_menu_group', 'auth_menu_group.id_auth_menu = auth_menu.id_auth_menu', 'left')
                    ->count_all_results();
        } else {
            $count = $this->CI->db
                    ->from('auth_menu')
                    ->where('LCASE(file)', strtolower($menu))
                    ->where('id_auth_group', $id_group)
                    ->where('is_superadmin', 0)
                    ->join('auth_menu_group', 'auth_menu_group.id_auth_menu = auth_menu.id_auth_menu', 'left')
                    ->count_all_results();

        }

        if ($count > 0) {
            return true;
        }

        return false;
    }
}

/* End of file FAT_Authentication.php */
/* Location: ./application/hooks/FAT_Authentication.php */
