<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
    function autentication() {
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
        $data['page_title'] = (isset($data['page_title'])) ? $data['page_title'] : ucfirst($class);
        
        $menus = $this->Menus();
        
        //$data['main_nav'] = $this->printMenu();

        $data['save_button_text'] = 'Save';
        $data['cancel_button_text'] = 'Cancel';
        
        $bread = $this->Breadcrumbs($class);
        if (isset($data['breadcumbs'])) {
            $data['breadcrumbs'] = array_push($data['breadcrumbs'],$bread);
        } else {
            $data['breadcrumbs'] = $bread;
        }
        
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
     * get all authenticated menu
     * @param int $id_parent
     * @return array data
     */
    private function Menus($id_parent=0) {
        $i=0;
        $id_group = 1;
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
            $data[$row]['children'] = $this->Menus($val['id_auth_menu']);
            $i++;
        }
        return $data;
    }
    
    /**
     * print auth menu navigation
     * @param type $id_parent
     * @return string print menu
     */
    private function printMenu($id_parent=0) {
        $CI=&get_instance();
        $CI->load->database();
        $id_group = adm_sess_usergroupid();
        $segment_1 = $CI->uri->segment(1);
        $segment_2 = $CI->uri->segment(2);
        $return = '';
        $menus = $CI->db
                ->where('auth_menu_group.id_auth_group',$id_group)
                ->where('auth_menu.parent_auth_menu',$id_parent)
                ->order_by('auth_menu.position','asc')
                ->order_by('auth_menu.id_auth_menu','asc')
                ->join('auth_menu','auth_menu.id_auth_menu=auth_menu_group.id_auth_menu','left')
                ->get('auth_menu_group')
                ->result_array();
        
        $a=0;
        /*
        $active_menu = $CI->db
                ->where('LCASE(file)',strtolower($segment_1))
                ->where('file !=','#')
                ->limit(1)
                ->get('auth_menu')
                ->row_array();
        $id_active = false;
        if ($active_menu) {
            $id_active = $this->getActiveMenu($active_menu['parent_auth_menu'], $active_menu['id_auth_menu']);
        }
        */
        foreach ($menus as $menu) {
            $set_active = true;
            if ($a==0) {
                $return .= '<li class="divider-vertical"></li>';
                if ($segment_1 == 'home' || $segment_1 == 'dashboard' || $segment_1 == '' || $segment_1 == 'profile') {
                    $set_active = false;
                    $return .= '<li class="active"><a href="'.site_url('home').'">Dashboard</a></li>';
                } else {
                    $return .= '<li><a href="'.site_url('home').'">Dashboard</a></li>';
                }
                $return .= '<li class="divider-vertical"></li>';
            }
            
            $href = ($menu['file'] == '#' || $menu['file'] == '') ? '#' : site_url($menu['file']);
            
            if ($segment_1 == $menu['file'] && $menu['file'] != '#') {
                $class_active = 'active';
            } else {
                if ($id_active == $menu['id_auth_menu'] && $set_active) {
                    $class_active = 'active';
                } else {
                    $class_active = '';
                }
            }
            
            $children = $this->getMenuChildren($menu['id_auth_menu']);
            if ($children) {
                $li_open = '<li class="dropdown '.$class_active.'"><a data-toggle="dropdown" class="dropdown-toggle" href="'.$href.'">'.$menu['menu'].' <b class="caret"></b></a>';
                $print_children = $this->printMenuChildren($menu['id_auth_menu']);
            } else {
                $li_open = '<li class="'.$class_active.'"><a href="'.$href.'">'.$menu['menu'].'</a>';
                $print_children = '';
            }
            
            $return .= $li_open.$print_children.'</li><li class="divider-vertical"></li>';
            
            $a++;
        }
        
        return $return;
    }
    
    /**
     * get active auth menu
     * @param int $id_parent
     * @param int $id_menu
     * @return int id parent of active menu
     */
    private function getActiveMenu($id_parent,$id_menu) {
        $CI=&get_instance();
        $CI->load->database();
        $return = 0;
        if ($id_parent == 0) {
            return $id_menu;
        }
        $data = $CI->db
                ->where('id_auth_menu',$id_parent)
                ->get('auth_menu')
                ->row_array();
        if ($data) {
            $return = $this->getActiveMenu($data['parent_auth_menu'], $data['id_auth_menu']);
        }
        return $return;
    }
    
    /**
     * get auth menu children
     * @param int $id_parent
     * @return array data
     */
    private function getMenuChildren($id_parent=0) {
        $CI=&get_instance();
        $CI->load->database();
        $id_group = adm_sess_usergroupid();
        $menus = $CI->db
                ->where('auth_menu_group.id_auth_group',$id_group)
                ->where('auth_menu.parent_auth_menu',$id_parent)
                ->order_by('auth_menu.position','asc')
                ->order_by('auth_menu.id_auth_menu','asc')
                ->join('auth_menu','auth_menu.id_auth_menu=auth_menu_group.id_auth_menu','left')
                ->get('auth_menu_group')
                ->result_array();
        
        return $menus;
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
     * @param type $path
     * @return type
     */
    private function Breadcrumbs($path) {
        $return[] = array(
            'text'  => 'Dashboard',
            'href'  => site_url('/'),
            'class' => ''
        );
        $id_parent = $this->getMenuIDByFile($path);
        $breadcrumbs = $this->breadcrumbsMenu($id_parent);
        $return = array_push($return,$breadcrumbs);
        return $return;
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


    /**
     * custom config
     */
    function custom_cfg() {
        $CI = & get_instance();
        //$base_url = str_replace('http://' . $_SERVER['HTTP_HOST'], '', base_url());
        //$CI->base_url = str_replace('https://' . $_SERVER['HTTP_HOST'], '', $base_url); //jika https
        $base_url =  ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ?  "https" : "http");
        $base_url .=  "://".$_SERVER['HTTP_HOST'];
        $base_url .=  str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
        $CI->base_url = $base_url;
    }
    
}

/* End of file hooks.php */
/* Location: ./application/hooks/hooks.php */
