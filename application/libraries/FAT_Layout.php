<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Layout Class.
 *     hook class that load to display layouts.
 *
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 *
 * @version 3.0
 *
 * @category Library
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
        $lang = $this->CI->lang->get_active_uri_lang();
        $dir = $this->CI->router->directory;
        $class = $this->CI->router->fetch_class();
        $method = $this->CI->router->fetch_method();
        $method = ($method == 'index') ? $class : $method;
        $data = (isset($this->CI->data)) ? $this->CI->data : [];
        $data['current_controller'] = base_url().$dir.$class.'/';
        $data['base_url'] = base_url();
        $data['current_url'] = current_url();
        $data['persistent_message'] = $this->CI->session->userdata('persistent_message');
        $site_setting = get_sitesetting();
        $site_info = get_site_info();
        $data['lang'] = $lang;
        $data['site_info'] = $site_info;
        $data['site_setting'] = $site_setting;

        $data['head_title'] = $site_info['site_name'];
        if (isset($data['page_title']) && $data['page_title'] != '') {
            $data['head_title'] .= ' | '.$data['page_title'];
        } else {
            $page_title = $this->GetMenuTitleByURI($this->CI->uri->uri_string());
            $data['head_title'] .= ' | '.$page_title;
            $data['page_title'] = $page_title;
        }

        if (!$menus = $this->CI->cache->get('frHeaderMenu')) {
            $menus = $this->GetMainMenus();
            $this->CI->cache->save('frHeaderMenu', $menus);
        }
        $data['print_main_menu'] = $this->PrintMainMenu($menus);

        if (!$footer_menus = $this->CI->cache->get('frFooterMenu')) {
            $footer_menus = $this->GetFooterMenus();
            $this->CI->cache->save('frFooterMenu', $footer_menus);
        }
        $data['print_footer_menu'] = $this->PrintFooterMenu($footer_menus);

        $data['uri_lang'] = ($lang == 'en') ? site_url($this->CI->lang->switch_uri('id')) : site_url($this->CI->lang->switch_uri('en'));

        if (isset($data['template'])) {
            $data['content'] = $this->CI->load->view(TEMPLATE_DIR.'/'.$data['template'], $data, true);
        } else {
            $data['content'] = $this->CI->load->view(TEMPLATE_DIR.'/'.$class.'/'.$method, $data, true);
        }
        if (isset($this->CI->layout)) {
            $layout = TEMPLATE_DIR.'/layout/'.$this->CI->layout;
        } elseif ($this->CI->input->is_ajax_request()) {
            $layout = TEMPLATE_DIR.'/layout/blank';
        } else {
            $layout = TEMPLATE_DIR.'/layout/default';
        }
        $this->CI->load->view($layout, $data);
    }

    /**
     * Get menu title by uri.
     *
     * @param string $uri
     *
     * @return string title of the page
     */
    private function GetMenuTitleByURI($uri = '')
    {
        $this->CI = &get_instance();
        $this->CI->load->database();
        if (!empty($uri)) {
            $uri_explode = explode('/', $uri);
            $lang = $uri_explode[0];
            $current_class = (isset($uri_explode[1])) ? $uri_explode[1] : $this->CI->router->fetch_class();
            $data['title'] = '';
            if (strtolower($current_class) == 'pages') {
                $data = $this->CI->db
                    ->select('pages_detail.title')
                    ->join('pages_detail', 'pages_detail.id_page = pages.id_page', 'left')
                    ->join('localization', 'localization.id_localization = pages_detail.id_localization', 'left')
                    ->where('is_delete', 0)
                    ->where("LCASE({$this->CI->db->dbprefix('pages')}.uri_path)", strtolower($uri_explode[2]))
                    ->where("LCASE({$this->CI->db->dbprefix('localization')}.iso_1)", $lang)
                    ->limit(1)
                    ->get('pages')
                    ->row_array();
            } else {
                $data = $this->CI->db
                    ->select('pages_detail.title')
                    ->join('pages_detail', 'pages_detail.id_page = pages.id_page', 'left')
                    ->join('localization', 'localization.id_localization = pages_detail.id_localization', 'left')
                    ->where('is_delete', 0)
                    ->where("LCASE({$this->CI->db->dbprefix('pages')}.module)", strtolower($current_class))
                    ->where("LCASE({$this->CI->db->dbprefix('localization')}.iso_1)", $lang)
                    ->limit(1)
                    ->get('pages')
                    ->row_array();
            }

            return $data['title'];
        }

        return '';
    }

    /**
     * Get main menu.
     *
     * @param int $parent
     *
     * @return array|bool $data
     */
    private function GetMainMenus($parent = 0)
    {
        $this->CI = &get_instance();
        $this->CI->load->database();
        $lang = $this->CI->lang->get_active_uri_lang();
        $data = $this->CI->db
                ->select('pages.id_page, pages.parent_page, pages.page_type, pages.uri_path, pages.module, pages.ext_link')
                ->join('status', 'status.id_status = pages.id_status', 'left')
                ->where("LCASE({$this->CI->db->dbprefix('status')}.status_text)", 'publish')
                ->where('is_delete', 0)
                ->where('is_header', 1)
                ->where('parent_page', $parent)
                ->order_by('position', 'asc')
                ->order_by('id_page', 'desc')
                ->get('pages')
                ->result_array();

        if ($data) {
            foreach ($data as $row => $record) {
                if ($record['page_type'] == 1) {
                    $menu_href = site_url('pages/'.$record['uri_path']);
                } elseif ($record['page_type'] == 2) {
                    $menu_href = site_url($record['module']);
                } else {
                    $menu_href = $record['ext_link'];
                }
                $data[$row]['menu_href'] = $menu_href;
                $detail = $this->CI->db
                        ->select('title')
                        ->join('localization', 'localization.id_localization = pages_detail.id_localization', 'left')
                        ->where("LCASE({$this->CI->db->dbprefix('localization')}.iso_1)", $lang)
                        ->where('id_page', $record['id_page'])
                        ->limit(1)
                        ->get('pages_detail')
                        ->row_array();
                $data[$row]['menu_title'] = $detail['title'];
                $data[$row]['childrens'] = $this->GetMainMenus($record['id_page']);
            }
        }

        return $data;
    }

    /**
     * Print menu to html.
     *
     * @param array  $menus  listing of menu in array
     * @param string $active print html
     *
     * @return string $return html menu
     */
    private function PrintMainMenu($menus = [], $active = '')
    {
        $return = '';
        if ($menus) {
            foreach ($menus as $row => $menu) {
                $style = $set_active = $class = '';
                if (isset($menu['childrens']) && count($menu['childrens']) > 0) {
                    $class .= ' dropdown';
                }
                if (strlen($menu['menu_title']) > 25) {
                    $style = 'style="font-size:12px;"';
                }
                $return .= '<li class="'.$class.'" '.$style.'>';
                if (isset($menu['childrens']) && count($menu['childrens']) > 0) {
                    $return .= '<a href="'.$menu['menu_href'].'" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.$menu['menu_title'].' <span class="caret"></span></a>';
                    $return .= '<ul class="dropdown-menu">';
                    $return .= $this->PrintMainMenu($menu['childrens']);
                    $return .= '</ul>';
                } else {
                    $return .= '<a href="'.$menu['menu_href'].'">'.$menu['menu_title'].'</a>';
                }
                $return .= '</li>';
            }
        }

        return $return;
    }

    /**
     * Get footer menu.
     *
     * @param int $parent
     *
     * @return array|bool $data
     */
    private function GetFooterMenus($parent = 0)
    {
        $this->CI = &get_instance();
        $this->CI->load->database();
        $lang = $this->CI->lang->get_active_uri_lang();
        $data = $this->CI->db
                ->select('pages.id_page, pages.parent_page, pages.page_type, pages.uri_path, pages.module, pages.ext_link')
                ->join('status', 'status.id_status = pages.id_status', 'left')
                ->where("LCASE({$this->CI->db->dbprefix('status')}.status_text)", 'publish')
                ->where('is_delete', 0)
                ->where('is_footer', 1)
                ->where('parent_page', $parent)
                ->order_by('position', 'asc')
                ->order_by('id_page', 'desc')
                ->get('pages')
                ->result_array();
        if ($data) {
            foreach ($data as $row => $record) {
                if ($record['page_type'] == 1) {
                    $menu_href = site_url('pages/'.$record['uri_path']);
                } elseif ($record['page_type'] == 2) {
                    $menu_href = site_url($record['module']);
                } else {
                    $menu_href = $record['ext_link'];
                }
                $data[$row]['menu_href'] = $menu_href;
                $detail = $this->CI->db
                        ->select('title')
                        ->join('localization', 'localization.id_localization = pages_detail.id_localization', 'left')
                        ->where("LCASE({$this->CI->db->dbprefix('localization')}.iso_1)", $lang)
                        ->where('id_page', $record['id_page'])
                        ->limit(1)
                        ->get('pages_detail')
                        ->row_array();
                $data[$row]['menu_title'] = $detail['title'];
                $data[$row]['childrens'] = $this->GetFooterMenus($record['id_page']);
            }
        }

        return $data;
    }

    /**
     * Print footer menu in html.
     *
     * @param array  $menus  listing of menu in array
     * @param string $active print html
     *
     * @return string $return html menu
     */
    private function PrintFooterMenu($menus = [], $active = '')
    {
        $return = '';
        if ($menus) {
            foreach ($menus as $row => $menu) {
                $style = $set_active = $class = '';
                if (isset($menu['childrens']) && count($menu['childrens']) > 0) {
                    $class .= ' dropdown';
                }
                if (strlen($menu['menu_title']) > 25) {
                    $style = 'style="font-size:12px;"';
                }
                $return .= '<li class="'.$class.'" '.$style.'>';
                if (isset($menu['childrens']) && count($menu['childrens']) > 0) {
                    $return .= '<a href="'.$menu['menu_href'].'" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.$menu['menu_title'].' <span class="caret"></span></a>';
                    $return .= '<ul class="dropdown-menu">';
                    $return .= $this->PrintFooterMenu($menu['childrens']);
                    $return .= '</ul>';
                } else {
                    $return .= '<a href="'.$menu['menu_href'].'">'.$menu['menu_title'].'</a>';
                }
                $return .= '</li>';
            }
        }

        return $return;
    }
}

/* End of file FAT_Layout.php */
/* Location: ./application/hooks/FAT_Layout.php */
