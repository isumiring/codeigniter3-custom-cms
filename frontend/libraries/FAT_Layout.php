<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Layout Class.
 *     hook class that load to display layouts.
 * 
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * 
 * @version 3.0
 * 
 * @category Library
 * 
 */
class FAT_Layout 
{
    /**
     * Load Codeigniter Super Object
     * 
     * @var object
     */
    protected $CI;

    /**
     * The database table used by the model
     * 
     * @var string
     */
    protected $table = 'page';

    /**
     * Primary key of the table
     * 
     * @var string
     */
    protected $primaryKey = 'id_page';

    /**
     * The database child table used by the model
     * 
     * @var string
     */
    protected $child_table_detail = 'page_detail';

    /**
     * Child key of the main table
     * 
     * @var string
     */
    protected $child_key_detail = 'id_page_detail';

    /**
     * The database foreign table used by the model
     * 
     * @var string
     */
    protected $foreign_table_status = 'status';

    /**
     * Foreign key of the main table
     * 
     * @var string
     */
    protected $foreign_key_status = 'id_status';

    /**
     * The database foreign table used by the model
     * 
     * @var string
     */
    protected $foreign_table_localization = 'localization';

    /**
     * Foreign key of the main table
     * 
     * @var string
     */
    protected $foreign_key_localization = 'id_localization';
    
    /**
     * Print layout based on controller class and function.
     * 
     * @return string view layout
     */
    public function layout() 
    {
        $this->CI = & get_instance();

        if (isset($this->CI->layout) && $this->CI->layout == 'none') {
            return;
        }
        
        // set data
        $dir                        = $this->CI->router->directory;
        $class                      = $this->CI->router->fetch_class();
        $method                     = $this->CI->router->fetch_method();
        $method                     = ($method == 'index') ? $class : $method;
        $data                       = (isset($this->CI->data)) ? $this->CI->data : [];
        $data['current_controller'] = base_url() . $dir . $class . '/';
        $data['base_url']           = base_url();
        $data['current_url']        = current_url();
        $data['persistent_message'] = $this->CI->session->userdata('persistent_message');
        $site_setting               = get_site_setting();
        $site_info                  = get_site_info();
        $data['site_info']          = $site_info;
        $data['site_setting']       = $site_setting;
        $data['site_locales']       = get_localization();
        $data['active_lang']        = $this->CI->lang->get_active_uri_lang();


        $data['head_title'] = $site_info['site_name'];
        if (isset($data['page_title']) && $data['page_title'] != '') {
            $data['head_title'] .= ' | '.$data['page_title'];
        } else {
            $page_title = $this->GetMenuTitleByURI($this->CI->uri->uri_string());
            $data['head_title'] .= ($page_title != '') ? ' | '. $page_title : '';
            $data['page_title'] = ($page_title !='') ? $page_title : $data['head_title'];
        }
        // echo $this->CI->uri->rsegment(1);

        $data['main_menus']    = $this->GetMainMenus();
        
        if (isset($data['page_info']['id_page'])) {
            $breadcrumbs = $this->Breadcrumbs($data['page_info'][$this->primaryKey]);
            
            $breadcrumbs[] = [
                'text'  => 'Home',
                'url'   => site_url('home'),
                'class' => '',
            ];
            array_multisort($breadcrumbs, SORT_ASC, SORT_NUMERIC);
            if (isset($data['breadcrumbs'])) {
                $breadcrumbs[] = $data['breadcrumbs'];
            }
            $data['breadcrumbs'] = $breadcrumbs;
        }
        
        if (isset($data['template'])) {
            $data['content'] = $this->CI->load->view(TEMPLATE_DIR. '/'. $data['template'], $data, true);
        } else {
            $data['content'] = $this->CI->load->view(TEMPLATE_DIR. '/'. $class. '/'. $method, $data, true);
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
        $this->CI =& get_instance();
        if ( ! empty($uri)) {
            $uri_explode = explode('/', $uri);
            $current_class = (isset($uri_explode[0])) ? $uri_explode[0] : $this->CI->router->fetch_class();
            $data['title'] = '';
            if (strtolower($current_class) == 'pages') {
                $this->CI->db->where('LCASE(uri_path)', strtolower($uri_explode[1]));
            } else {
                $this->CI->db->where('LCASE(module)', strtolower($current_class));
            }
            $data = $this->CI->db
                ->select('title')
                ->join($this->child_table_detail, "{$this->child_table_detail}.{$this->primaryKey} = {$this->table}.{$this->primaryKey}", 'left')
                ->join($this->foreign_table_localization, "{$this->foreign_table_localization}.{$this->foreign_key_localization} = {$this->child_table_detail}.{$this->foreign_key_localization}", 'left')
                ->join($this->foreign_table_status, "{$this->foreign_table_status}.{$this->foreign_key_status} = {$this->table}.{$this->foreign_key_status}", 'left')
                ->where('LCASE(iso_1)', $this->CI->lang->get_active_uri_lang())
                ->where('LCASE(status_text)', 'publish')
                ->where('is_delete', 0)
                ->limit(1)
                ->get($this->table)
                ->row_array();

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
        $this->CI =& get_instance();
        $data = $this->CI->db
                ->select("{$this->table}.{$this->primaryKey}")
                ->select('parent_page, page_name, page_type, uri_path, module, ext_link, icon_image, title')
                ->join($this->foreign_table_status, "{$this->foreign_table_status}.{$this->foreign_key_status} = {$this->table}.{$this->foreign_key_status}", 'left')
                ->join($this->child_table_detail, "{$this->child_table_detail}.{$this->primaryKey} = {$this->table}.{$this->primaryKey}", 'left')
                ->join($this->foreign_table_localization, "{$this->foreign_table_localization}.{$this->foreign_key_localization} = {$this->child_table_detail}.{$this->foreign_key_localization}", 'left')
                ->where('LCASE(iso_1)', $this->CI->lang->get_active_uri_lang())
                ->where('LCASE(status_text)', 'publish')
                ->where('is_delete', 0)
                ->where('is_header', 1)
                ->where('parent_page', $parent)
                ->order_by('position', 'asc')
                ->order_by($this->primaryKey, 'desc')
                ->get($this->table)
                ->result_array();

        if ($data) {
            foreach ($data as $row => $record) {
                $data[$row]['attributes'] = '';
                if ($record['page_type'] == 'static_page') {
                    $menu_href = site_url('pages/'.$record['uri_path']);
                    if ($this->CI->uri->segment(1) == 'pages' && strtolower($this->CI->uri->segment(2)) == strtolower($record['uri_path'])) {
                        $data[$row]['attributes'] = 'class="active"';
                    }
                } elseif ($record['page_type'] == 'module') {
                    $menu_href = site_url($record['module']);
                    if (strtolower($this->CI->uri->segment(1)) == strtolower($record['module'])) {
                        $data[$row]['attributes'] = 'class="active"';
                    }
                } else {
                    $menu_href = $record['ext_link'];
                    if ($record['ext_link'] != '' && $record['ext_link'] != '#') {
                        $data[$row]['attributes'] = 'target="_blank"';
                    }
                }
                $data[$row]['menu_href']  = $menu_href;
                $data[$row]['menu_title'] = $record['title'];
            }
        }

        return $data;
    }

    /**
     * Breadcrumbs.
     *
     * @param int   $id_page
     * @param array $breadcrumbs
     *
     * @return array breadcrumbs list
     */
    private function Breadcrumbs($id_page, &$breadcrumbs = [])
    {
        $this->CI =& get_instance();
        $data = $this->CI->db
                ->select("{$this->table}.{$this->primaryKey}")
                ->select('parent_page, page_name, page_type, uri_path, module, ext_link, icon_image, title')
                ->join($this->child_table_detail, "{$this->child_table_detail}.{$this->primaryKey} = {$this->table}.{$this->primaryKey}", 'left')
                ->join($this->foreign_table_status, "{$this->foreign_table_status}.{$this->foreign_key_status} = {$this->table}.{$this->foreign_key_status}", 'left')
                ->join($this->foreign_table_localization, "{$this->foreign_table_localization}.{$this->foreign_key_localization} = {$this->child_table_detail}.{$this->foreign_key_localization}", 'left')
                ->where('LCASE(iso_1)', $this->CI->lang->get_active_uri_lang())
                ->where('LCASE(status_text)', 'publish')
                ->where("{$this->table}.{$this->primaryKey}", $id_page)
                ->where('is_delete', 0)
                ->order_by('position', 'asc')
                ->order_by($this->primaryKey, 'desc')
                ->limit(1)
                ->get($this->table)
                ->row_array();
        if ($data) {
            if ($data['page_type'] == 'static_page') {
                $menu_href = site_url('pages/'.$data['uri_path']);
            } elseif ($data['page_type'] == 'module') {
                $menu_href = site_url($data['module']);
            } else {
                $menu_href = $data['ext_link'];
            }
            $breadcrumbs[] = [
                'text'  => (($data['icon_image'] != '') ? '<i class="'.$data['icon_image'].'"></i> ' : ''). $data['title'],
                'url'   => $menu_href,
                'class' => '',
            ];
            if ($data['parent_page'] > 0) {
                $parent_data = $this->CI->db
                        ->select($this->primaryKey)
                        ->where($this->primaryKey, $data['parent_page'])
                        ->limit(1)
                        ->get($this->table)
                        ->row_array();
                if ($parent_data) {
                    $this->Breadcrumbs($parent_data[$this->primaryKey], $breadcrumbs);
                }
            }
        }

        return $breadcrumbs;
    }
}

/* End of file FAT_Layout.php */
/* Location: ./application/libraries/FAT_Layout.php */
