<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Authentication Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Hook
 * @desc hook class that check the authentication
 * 
 */
class FAT_Authentication {
    
    protected $CI;
    
    /**
     * check admin session authorization, return true or false 
     * @author ivan lubis
     * @return redirect to cms login page if not valid
     */
    public function authentication() {
        $this->CI=& get_instance();
        // make exception auth for login
        $segment_1 = $this->CI->uri->segment(1);
        $segment_2 = $this->CI->uri->segment(2);
        if ($segment_1 == 'login') {
            if (isset($_SESSION['ADM_SESS']) && $_SESSION['ADM_SESS'] != '') {
                redirect();
            } else {
                return;
            }
        } else {
            if ($segment_1 == 'logout' || $segment_1 == 'auth') {
                return;
            }
            if(!isset($_SESSION['ADM_SESS'])) {
                if ($this->CI->input->is_ajax_request()) {
                    $_SESSION['tmp_login_redirect'] = 'dashboard';
                    header('Content-type: application/json');
                    $json['redirect_auth'] = site_url('login');
                    exit(
                        json_encode($json)
                    );
                } else {
                    $_SESSION['tmp_login_redirect'] = current_url();
                    redirect('login');
                }
            } else {
                $sess = $_SESSION['ADM_SESS'];
                if (base_url() != $sess['admin_url'] || $sess['admin_token'] != $this->CI->security->get_csrf_hash() || $_SERVER['REMOTE_ADDR'] != $sess['admin_ip']) {
                    session_destroy();
                    if ($this->CI->input->is_ajax_request()) {
                        $this->CI->session->set_userdata('tmp_login_redirect','dashboard');
                        header('Content-type: application/json');
                        $json['redirect_auth'] = site_url('login');
                        exit(
                            json_encode($json)
                        );
                    } else {
                        $this->CI->session->set_userdata('tmp_login_redirect',current_url());
                        redirect('login');
                    }
                }
                
                // check auth
                $id_group = $sess['admin_id_auth_group'];
                if (!$this->checkAuth($segment_1, $id_group)) {
                    //$this->CI->session->sess_destroy();
                    //redirect('login');
                }
                
            }
        }
    }
    
    /**
     * check authorization for user
     * @param string $menu
     * @param int $id_group
     * @return boolean
     */
    private function checkAuth($menu,$id_group) {
        $this->CI =& get_instance();
        $this->CI->load->database();
        if (!$menu || $menu == 'home' || $menu == 'dashboard' || $menu == '' && $menu == 'profile') {
            return true;
        }
        
        if (is_superadmin()) {
            $data = $this->CI->db
                    ->from('auth_menu')
                    ->where('LCASE(file)',strtolower($menu))
                    ->where('id_auth_group',$id_group)
                    ->join('auth_menu_group','auth_menu_group.id_auth_menu=auth_menu.id_auth_menu','left')
                    ->count_all_results();
        } else {
            $data = $this->CI->db
                    ->from('auth_menu')
                    ->where('LCASE(file)',strtolower($menu))
                    ->where('id_auth_group',$id_group)
                    ->where('is_superadmin',0)
                    ->join('auth_menu_group','auth_menu_group.id_auth_menu=auth_menu.id_auth_menu','left')
                    ->count_all_results();
        }
        if ($data > 0) {
            return true;
        } else {
            return false;
        }
    }

}

/* End of file FAT_Authentication.php */
/* Location: ./application/hooks/FAT_Authentication.php */
