<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * HOOKS Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Hook
 * @desc hook class that load before and after the controller
 * 
 */
class FAT_Hooks {
    
    function post_construct() {
        $CI=& get_instance();
        $CI->output->enable_profiler(TRUE);
    }
    
    /**
     * check admin session authorization, return true or false 
     * @author ivan lubis
     * @return redirect to cms login page if not valid
     */
    function authentication() {
        $CI=& get_instance();
        
        // make exception auth for login
        $segment_1 = $CI->uri->segment(1);
        $segment_2 = $CI->uri->segment(2);
        if ($segment_1 == 'login') {
            if (isset($_SESSION['ADM_SESS']) && $_SESSION['ADM_SESS'] != '') {
                redirect();
            } else {
                return;
            }
        } else {
            if ($segment_1 == 'logout') {
                return;
            }
            if(!isset($_SESSION['ADM_SESS'])) {
                if ($CI->input->is_ajax_request()) {
                    $CI->session->set_userdata('tmp_login_redirect','dashboard');
                    echo '<script>window.location="'.site_url('login').'";</script>';
                } else {
                    $CI->session->set_userdata('tmp_login_redirect',current_url());
                    redirect('login');
                }
            } else {
                $sess = $_SESSION['ADM_SESS'];
                if (base_url() != $sess['admin_url'] || $sess['admin_token'] != $CI->security->get_csrf_hash() || $_SERVER['REMOTE_ADDR'] != $sess['admin_ip']) {
                    session_destroy();
                    if ($CI->input->is_ajax_request()) {
                        $CI->session->set_userdata('tmp_login_redirect','dashboard');
                        echo '<script>window.location="'.site_url('login').'";</script>';
                    } else {
                        $CI->session->set_userdata('tmp_login_redirect',current_url());
                        redirect('login');
                    }
                }
                
                // check auth
                $id_group = $sess['admin_id_auth_group'];
                if (!$this->checkAuth($segment_1, $id_group)) {
                    //$CI->session->sess_destroy();
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
        $CI =& get_instance();
        $CI->load->database();
        
        if ($menu == 'home' || $menu == 'dashboard' || $menu == '' && $menu == 'profile') {
            return true;
        }
        
        if (is_superadmin()) {
            $data = $CI->db
                    ->from('auth_menu')
                    ->where('LCASE(file)',strtolower($menu))
                    ->where('id_auth_group',$id_group)
                    ->join('auth_menu_group','auth_menu_group.id_auth_menu=auth_menu.id_auth_menu','left')
                    ->count_all_results();
        } else {
            $data = $CI->db
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
    
    /**
     * print layout based on controller class and function
     * @return string view layout
     */
    function view() {
        $CI = & get_instance();

        if (isset($CI->layout) && $CI->layout == 'none') {
            return;
        }
        
        // set data
        $dir = $CI->router->directory;
        $class = $CI->router->fetch_class();
        $method = $CI->router->fetch_method();
        $method = ($method == 'index') ? $class : $method;
        $data = (isset($CI->data)) ? $CI->data : array();
        $data['current_controller'] = base_url() . $dir . $class . '/';
        $page_info = $this->GetPageInfoByFile($class);
        $id_auth_menu = $page_info['id_auth_menu'];
        $data['base_url'] = base_url();
        $data['current_url'] = current_url();
        if (isset($_SESSION['ADM_SESS'])) {
            $data['ADM_SESSION'] = $_SESSION['ADM_SESS'];
        }
        $data['flash_message'] = $CI->session->flashdata('flash_message');
        $data['persistent_message'] = $CI->session->userdata('persistent_message');
        
        $data['auth_sess'] = $CI->session->userdata('ADM_SESS');
        $data['site_setting'] = get_sitesetting();
        $data['site_info'] = get_site_info();
        $data['page_title'] = (isset($data['page_title'])) ? $data['page_title'] : $page_info['menu'];
        
        $menus = $this->MenusData();
        $data['left_menu'] = $this->PrintLeftMenu($menus);

        $data['save_button_text'] = 'Save';
        $data['cancel_button_text'] = 'Cancel';
        
        $breadcrumbs = $this->Breadcrumbs($id_auth_menu);
        $breadcrumbs[] = array(
            'text'=>'<i class="fa fa-dashboard"></i> Dashboard',
            'url'=>site_url('dashboard'),
            'class'=>''
        );
        array_multisort($breadcrumbs,SORT_ASC,SORT_NUMERIC);
        if (isset($data['breadcrumbs'])) {
            $breadcrumbs[] = $data['breadcrumbs'];
        }
        $data['breadcrumbs'] = $breadcrumbs;
        
        if (isset($data['template'])) {
            $data['content'] = $CI->load->view(TEMPLATE_DIR.'/'.$data['template'], $data, true);
        } else {
            $data['content'] = $CI->load->view(TEMPLATE_DIR.'/'.$class . '/' . $method, $data, true);
        }
        if (isset($CI->layout)) {
            $layout = TEMPLATE_DIR.'/layout/'.$CI->layout;
        } elseif ($CI->input->is_ajax_request()) {
            $layout = TEMPLATE_DIR.'/layout/blank';
        } else {
            $layout = TEMPLATE_DIR.'/layout/default';
        }
        $CI->load->view($layout, $data);
    }


    /**
     * get page info by file
     * @param string $class
     * @param mixed $return array or string
     * @return mixed array/string
     */
    private function GetPageInfoByFile($class,$return=array()) {
        $CI =& get_instance();
        $CI->load->database();
        $data = $CI->db
                ->where('LCASE(file)',strtolower($class))
                ->limit(1)
                ->get('auth_menu')
                ->row_array();
        if (is_array($return)) {
            return $data;
        } else {
            return $data[$return];
        }
    }
    
    /**
     * get all authenticated menu
     * @param int $id_parent
     * @return array data
     */
    private function MenusData($id_parent=0) {
        $i=0;
        $id_group = id_auth_group();
        $CI =& get_instance();
        $CI->load->database();
        $data = $CI->db
                ->join('auth_menu','auth_menu.id_auth_menu=auth_menu_group.id_auth_menu','left')
                ->where('auth_menu_group.id_auth_group',$id_group)
                ->where('auth_menu.parent_auth_menu',$id_parent)
                ->order_by('auth_menu.position','asc')
                ->order_by('auth_menu.id_auth_menu','asc')
                ->get('auth_menu_group')
                ->result_array();
        foreach ($data as $row => $val) {
            $data[$row]['children'] = $this->MenusData($val['id_auth_menu']);
            $i++;
        }
        return $data;
    }
    
    /**
     * print left menu
     * @param array $menus
     * @return string $return left menu html
     */
    private function PrintLeftMenu($menus=array()) {
        $return = '';
        if ($menus) {
            foreach ($menus as $row => $menu) {
                $return .= '<li>';
                $style = '';
                if (strlen($menu['menu'])>25) {
                    $style = 'style="font-size:12px;"';
                }
                $return .= '<a href="'.site_url($menu['file']).'" '.$style.'>';
                $return .= $menu['menu'];
                if (isset($menu['children']) && count($menu['children'])>0) {
                    $return .= '<span class="fa arrow"></span>';
                }
                $return .= '</a>';
                if (isset($menu['children']) && count($menu['children'])>0) {
                    $return .= '<ul class="nav" style="padding-left:15px;">';
                    $return .= $this->PrintLeftMenu($menu['children']);
                    $return .= '</ul>';
                }
                $return .= '</li>';
            }
        }
        return $return;
    }
    
    /**
     * print auth menu children
     * @param int $id_parent
     * @return string return menu
     */
    private function printMenuChildren($id_parent) {
        $menus = $this->getMenuChildren($id_parent);
        $return = '';
        if ($menus) {
            $return .= '<ul class="dropdown-menu">';
            foreach ($menus as $menu) {
                $href = ($menu['file'] == '#' || $menu['file'] == '') ? '#' : site_url($menu['file']);
                $children = $this->getMenuChildren($menu['id_auth_menu']);
                if ($children) {
                    $return .= '<li class="dropdown-submenu">';
                    $return .= '<a tabindex="-1" href="'.$href.'">'.$menu['menu'].'</a>';
                    $return .= $this->printMenuChildren($menu['id_auth_menu']);
                } else {
                    $return .= '<li><a href="'.$href.'">'.$menu['menu'].'</a></li>';
                }
            }
            $return .= '</ul>';
        }
        return $return;
    }
    
    /**
     * Breadcrumbs 
     * @param int $id_auth_menu
     * @param array $breadcrumbs
     * @return array breadcrumbs list
     */
    private function Breadcrumbs($id_auth_menu,&$breadcrumbs=array()) {
        $CI =& get_instance();
        $CI->load->database();
        $data = $CI->db
                ->where('id_auth_menu',$id_auth_menu)
                ->limit(1)
                ->get('auth_menu')
                ->row_array();
        if ($data) {
            $breadcrumbs[] = array(
                'text'=>$data['menu'],
                'url'=>($data['file'] != '' && $data['file'] != '#') ? site_url($data['file']) : '#',
                'class'=>''
            );
            if ($data['parent_auth_menu'] > 0) {
                $parent_data = $CI->db
                        ->where('id_auth_menu',$data['parent_auth_menu'])
                        ->limit(1)
                        ->get('auth_menu')
                        ->row_array();
                if ($parent_data) {
                    $this->Breadcrumbs($parent_data['id_auth_menu'],$breadcrumbs);
                }
            }
        }
        return $breadcrumbs;
    }
    
    /**
     * breadcrumbs menu
     * @param int $id_parent
     * @return array $return
     */
    private function breadcrumbsMenu($id_parent) {
        $CI=& get_instance();
        $CI->load->database();
        $return = array();
        $data = $CI->db
                ->select('menu,file,parent_auth_menu')
                ->where('id_auth_menu',$id_parent)
                ->limit(1)
                ->get('auth_menu')
                ->row_array();
        if ($data) {
            $href = ($data['file'] == '' || $data['file'] == '#') ? '#' : site_url($data['file']);
            $return[] = array(
                'text'  => $data['menu'],
                'href'  => $href,
                'class' => ''
            );
            print_r($return);
            $menu = $this->breadcrumbsMenu($data['parent_auth_menu']);
            $return = array_push($menu,$return);
        }
        return $return;
    }
    
    /**
     * get menu id by file
     * @param string $path
     * @return int
     */
    private function getMenuIDByFile($path) {
        $CI=& get_instance();
        $CI->load->database();
        $data = $CI->db
                ->select('parent_auth_menu')
                ->where('LCASE(file)',strtolower($path))
                ->where('file !=','#')
                ->limit(1)
                ->get('auth_menu')
                ->row_array();
        if ($data) {
            return $data['parent_auth_menu'];
        } else {
            return 0;
        }
            
    }
    
}

/* End of file FAT_Hooks.php */
/* Location: ./application/hooks/FAT_Hooks.php */
