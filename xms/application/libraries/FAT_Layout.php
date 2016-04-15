<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Layout Class.
 *     library class that load to display layouts.
 *
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 *
 * @version 3.0
 *
 * @category Libraries
 */
class FAT_Layout
{
    /**
     * Load Codeigniter Super Object.
     *
     * @var object
     */
    protected $CI;

    /**
     * Print layout based on controller class and function.
     *
     * @return string view layout
     */
    public function layout()
    {
        $this->CI = &get_instance();

        if (isset($this->CI->layout) && $this->CI->layout == 'none') {
            return;
        }

        // set data
        $dir = $this->CI->router->directory;
        $class = $this->CI->router->fetch_class();
        $method = $this->CI->router->fetch_method();
        $method = ($method == 'index') ? $class : $method;
        $data = (isset($this->CI->data)) ? $this->CI->data : [];
        $data['current_controller'] = base_url().$dir.$class.'/';
        if (isset($data['current_path'])) {
            $current_path = str_replace(base_url().$dir, '', current_url());
        } else {
            $current_path = $class;
        }
        $page_info = $this->GetPageInfoByFile($class);
        $id_auth_menu = $page_info['id_auth_menu'];
        $data['base_url'] = base_url();
        $data['current_url'] = current_url();
        if (isset($_SESSION['ADM_SESS'])) {
            $data['ADM_SESSION'] = $_SESSION['ADM_SESS'];
        }
        $data['flash_message'] = $this->CI->session->flashdata('flash_message');
        $data['persistent_message'] = (isset($_SESSION['persistent_message'])) ? $_SESSION['persistent_message'] : '';

        $data['auth_sess'] = (isset($_SESSION['ADM_SESS'])) ? $_SESSION['ADM_SESS'] : [];
        $data['site_setting'] = get_sitesetting();
        $data['site_info'] = get_site_info();
        $data['page_title'] = (isset($data['page_title'])) ? $data['page_title'] : $page_info['menu'];

        $menus = $this->MenusData();
        $ids[] = $id_auth_menu;
        $menus_ids = [];
        if (isset($page_info['parent_auth_menu'])) {
            $menus_ids = $this->ActiveMenuIds($page_info['parent_auth_menu'], $ids);
        }
        $data['main_menu'] = $this->PrintMainMenu($menus, $menus_ids);

        $breadcrumbs = $this->Breadcrumbs($id_auth_menu);
        $breadcrumbs[] = [
            'text'  => '<i class="fa fa-dashboard"></i> Dashboard',
            'url'   => site_url('dashboard'),
            'class' => '',
        ];
        array_multisort($breadcrumbs, SORT_ASC, SORT_NUMERIC);
        if (isset($data['breadcrumbs'])) {
            $breadcrumbs[] = $data['breadcrumbs'];
        }
        $data['breadcrumbs'] = $breadcrumbs;

        // template
        $template_dir = getActiveThemes();
        // default
        $data['GLOBAL_ASSETS_URL'] = PATH_CMS.'assets/default/';
        $data['GLOBAL_IMG_URL'] = $data['GLOBAL_ASSETS_URL'].'img/';
        $data['GLOBAL_CSS_URL'] = $data['GLOBAL_ASSETS_URL'].'css/';
        $data['GLOBAL_JS_URL'] = $data['GLOBAL_ASSETS_URL'].'js/';
        $data['GLOBAL_VENDOR_URL'] = $data['GLOBAL_ASSETS_URL'].'vendor/';
        $data['GLOBAL_LIBS_URL'] = $data['GLOBAL_ASSETS_URL'].'libs/';
        // active template
        $data['ASSETS_URL'] = PATH_CMS.'assets/'.$template_dir.'/';
        $data['IMG_URL'] = $data['ASSETS_URL'].'img/';
        $data['CSS_URL'] = $data['ASSETS_URL'].'css/';
        $data['JS_URL'] = $data['ASSETS_URL'].'js/';
        $data['VENDOR_URL'] = $data['ASSETS_URL'].'vendor/';
        $data['LIBS_URL'] = $data['ASSETS_URL'].'libs/';

        if (isset($data['template'])) {
            $data['content'] = $this->CI->load->view($template_dir.'/'.$data['template'], $data, true);
        } else {
            $data['content'] = $this->CI->load->view($template_dir.'/'.$class.'/'.$method, $data, true);
        }
        if (isset($this->CI->layout)) {
            $layout = $template_dir.'/layout/'.$this->CI->layout;
        } elseif ($this->CI->input->is_ajax_request()) {
            $layout = $template_dir.'/layout/blank';
        } else {
            $layout = $template_dir.'/layout/default';
        }
        $this->CI->load->view($layout, $data);
    }

    /**
     * Get page info by file.
     *
     * @param string $class
     * @param mixed  $return array or string
     *
     * @return mixed array/string
     */
    private function GetPageInfoByFile($class, $return = [])
    {
        $this->CI = &get_instance();
        $this->CI->load->database();
        if ($class == 'login') {
            $arr = [
                'id_auth_menu' => 0,
                'menu'         => 'Login',
            ];

            return $arr;
        }
        $data = $this->CI->db
                ->where('LCASE(file)', strtolower($class))
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
     * Get all authenticated menu.
     *
     * @param int $id_parent
     *
     * @return array|bool $data
     */
    private function MenusData($id_parent = 0)
    {
        $i = 0;
        $id_group = id_auth_group();
        if (!$id_group) {
            return;
        }
        $this->CI = &get_instance();
        $this->CI->load->database();
        $data = $this->CI->db
                ->join('auth_menu', 'auth_menu.id_auth_menu = auth_menu_group.id_auth_menu', 'left')
                ->where('auth_menu_group.id_auth_group', $id_group)
                ->where('auth_menu.parent_auth_menu', $id_parent)
                ->order_by('auth_menu.position', 'asc')
                ->order_by('auth_menu.id_auth_menu', 'asc')
                ->get('auth_menu_group')
                ->result_array();
        foreach ($data as $row => $val) {
            $data[$row]['children'] = $this->MenusData($val['id_auth_menu']);
            $i++;
        }

        return $data;
    }

    /**
     * Active Menu Ids
     *     return array for listing hierarcy active menu.
     *
     * @param int   $id_parent
     * @param array &$ids
     *
     * @return array $ids;
     */
    private function ActiveMenuIds($id_parent = 0, &$ids = [])
    {
        $this->CI = &get_instance();
        $this->CI->load->database();
        if (!$id_parent) {
            return $ids;
        }
        $data = $this->CI->db
                ->select('id_auth_menu, parent_auth_menu, file')
                ->where('id_auth_menu', $id_parent)
                ->limit(1)
                ->get('auth_menu')
                ->row_array();
        if ($data) {
            $ids[] = $data['id_auth_menu'];
            $parent = $this->ActiveMenuIds($data['parent_auth_menu'], $ids);
        }

        return $ids;
    }

    /**
     * print left menu.
     *
     * @param array $menus
     *
     * @return string $return left menu html
     */
    private function PrintMainMenu($menus = [], $active_menus = [])
    {
        $return = '';
        if ($menus) {
            foreach ($menus as $row => $menu) {
                $style = $set_active = '';
                if (strlen($menu['menu']) > 25) {
                    $style = 'style="font-size:12px;"';
                }
                if (is_array($active_menus) && count($active_menus) > 0) {
                    if (in_array($menu['id_auth_menu'], $active_menus)) {
                        $set_active = 'class="in active"';
                    }
                }
                $return .= '<li '.$set_active.'>';
                $return .= '<a href="'.(($menu['file'] == '#' || $menu['file'] == '') ? '#' : site_url($menu['file'])).'" '.$style.' '.$set_active.'>';
                $return .= $menu['menu'];
                if (isset($menu['children']) && count($menu['children']) > 0) {
                    $return .= '<span class="fa arrow"></span>';
                }
                $return .= '</a>';
                if (isset($menu['children']) && count($menu['children']) > 0) {
                    $return .= '<ul class="nav" style="padding-left:15px;">';
                    $return .= $this->PrintMainMenu($menu['children'], $active_menus);
                    $return .= '</ul>';
                }
                $return .= '</li>';
            }
        }

        return $return;
    }

    /**
     * Breadcrumbs.
     *
     * @param int   $id_auth_menu
     * @param array $breadcrumbs
     *
     * @return array breadcrumbs list
     */
    private function Breadcrumbs($id_auth_menu, &$breadcrumbs = [])
    {
        $this->CI = &get_instance();
        $this->CI->load->database();
        if (!$id_auth_menu) {
            return;
        }
        $data = $this->CI->db
                ->select('id_auth_menu,parent_auth_menu,menu,file')
                ->where('id_auth_menu', $id_auth_menu)
                ->limit(1)
                ->get('auth_menu')
                ->row_array();
        if ($data) {
            $breadcrumbs[] = [
                'text'  => $data['menu'],
                'url'   => ($data['file'] != '' && $data['file'] != '#') ? site_url($data['file']) : '#',
                'class' => '',
            ];
            if ($data['parent_auth_menu'] > 0) {
                $parent_data = $this->CI->db
                        ->select('id_auth_menu')
                        ->where('id_auth_menu', $data['parent_auth_menu'])
                        ->limit(1)
                        ->get('auth_menu')
                        ->row_array();
                if ($parent_data) {
                    $this->Breadcrumbs($parent_data['id_auth_menu'], $breadcrumbs);
                }
            }
        }

        return $breadcrumbs;
    }
}

/* End of file FAT_Layout.php */
/* Location: ./application/hooks/FAT_Layout.php */
