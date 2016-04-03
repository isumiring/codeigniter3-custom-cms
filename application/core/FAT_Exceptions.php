<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Exceptions Class Extension.
 *     extending exceptions class for customize error page.
 *
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 *
 * @version 3.0
 *
 * @category Core
 */
class FAT_Exceptions extends CI_Exceptions
{
    /**
     * Load Codeigniter Super Object.
     *
     * @var object
     */
    protected $CI;

    /**
     * Load the parent constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Error 404 handler.
     *
     * @param string $page
     * @param bool   $log_error
     *
     * @return string layout
     */
    public function show_404($page = '', $log_error = true)
    {
        $this->CI = &get_instance();

        $lang = $this->CI->lang->get_active_uri_lang();

        if (is_cli()) {
            $heading = 'Not Found';
            $message = 'The controller/method pair you requested was not found.';
        } else {
            // set data
            $heading = '404 Page Not Found';
            $message = 'The page you requested was not found.';

            $data['base_url'] = base_url();
            $data['current_url'] = current_url();
            $data['flash_message'] = $this->CI->session->flashdata('flash_message');
            $data['persistent_message'] = (isset($_SESSION['persistent_message'])) ? $_SESSION['persistent_message'] : '';
            $site_setting = get_sitesetting();
            $site_info = get_site_info();
            $data['page_title'] = $heading;
            $data['error_heading'] = $heading;
            $data['error_message'] = $message;
            $data['site_info'] = $site_info;
            $data['site_setting'] = $site_setting;

            $data['head_title'] = $site_info['site_name'].' | Page Not Found';
            $data['page_title'] = 'Page Not Found';

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

            $data['content'] = $this->CI->load->view(TEMPLATE_DIR.'/error/page_not_found', $data, true);
            $layout = TEMPLATE_DIR.'/layout/default';
            echo $this->CI->load->view($layout, $data, true);
        }

        // By default we log this, but allow a dev to skip it
        if ($log_error) {
            log_message('error', $heading.': '.$page);
        }
        // set_status_header(404);
        // echo $this->show_error($heading, $message, 'error_404', 404);
        exit(4); // EXIT_UNKNOWN_FILE
    }

    // --------------------------------------------------------------------

    /**
     * General Error Page.
     *
     * Takes an error message as input (either as a string or an array)
     * and displays it using the specified template.
     *
     * @param string          $heading     Page heading
     * @param string|string[] $message     Error message
     * @param string          $template    Template name
     * @param int             $status_code (default: 500)
     *
     * @return string Error page output
     */
    public function show_error($heading, $message, $template = 'error_general', $status_code = 500)
    {
        $templates_path = config_item('error_views_path');
        if (empty($templates_path)) {
            $templates_path = VIEWPATH.DIRECTORY_SEPARATOR.'errors'.DIRECTORY_SEPARATOR;
        }

        if (is_cli()) {
            $message = "\t".(is_array($message) ? implode("\n\t", $message) : $message);
            $template = 'cli'.DIRECTORY_SEPARATOR.$template;
        } else {
            set_status_header($status_code);
            $message = '<p>'.(is_array($message) ? implode('</p><p>', $message) : $message).'</p>';
            $template = 'html'.DIRECTORY_SEPARATOR.$template;
        }

        if (ob_get_level() > $this->ob_level + 1) {
            ob_end_flush();
        }
        ob_start();
        include $templates_path.$template.'.php';
        $buffer = ob_get_contents();
        ob_end_clean();

        return $buffer;
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

/* End of file FAT_Exceptions.php */
/* Location: ./application/core/FAT_Exceptions.php */
