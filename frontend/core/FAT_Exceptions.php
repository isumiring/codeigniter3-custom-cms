<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Exceptions Class Extension.
 *     extending exceptions class for customize error page.
 *     
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * 
 * @version 3.0
 * 
 * @category Core
 * 
 */

class FAT_Exceptions extends CI_Exceptions 
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
     * Load the parent constructor.
     */
    public function __construct() 
    {
        parent::__construct();
    }

    /**
     * Error 404 handler.
     * 
     * @param  string  $page
     * @param  boolean $log_error
     * 
     * @return string layout
     */
    public function show_404($page = '', $log_error = TRUE)
    {
        $this->CI =& get_instance();

        if (is_cli())
        {
            $heading = 'Not Found';
            $message = 'The controller/method pair you requested was not found.';
        }
        else
        {
            // set data
            $heading = 'Page Not Found';
            $message = 'The page you requested was not found.';

            $data['base_url']           = base_url();
            $data['current_url']        = current_url();
            $data['flash_message']      = $this->CI->session->flashdata('flash_message');
            $data['persistent_message'] = (isset($_SESSION['persistent_message'])) ? $_SESSION['persistent_message'] : '';
            $site_setting               = get_site_setting();
            $site_info                  = get_site_info();
            $data['page_title']         = $heading;
            $data['error_heading']      = $heading;
            $data['error_message']      = $message;
            $data['site_info']          = $site_info;
            $data['site_setting']       = $site_setting;
            $data['site_locales']       = get_localization();
            $data['active_lang']        = $this->CI->lang->get_active_uri_lang();

            $data['head_title'] = $site_info['site_name'].' | Page Not Found';
            $data['page_title'] = 'Page Not Found';

            $data['main_menu']    = $this->GetMainMenus();
            $data['footer_menus'] = $this->GetFooterMenus();

            $data['content'] = $this->CI->load->view(TEMPLATE_DIR. '/error/page_not_found', $data, true);
            $layout = TEMPLATE_DIR. '/layout/default';
            echo $this->CI->load->view($layout, $data, true);
        }

        // By default we log this, but allow a dev to skip it
        if ($log_error)
        {
            log_message('error', $heading.': '.$page);
        }
        // set_status_header(404);
        // echo $this->show_error($heading, $message, 'error_404', 404);
        exit(4); // EXIT_UNKNOWN_FILE
    }

    // --------------------------------------------------------------------

    /**
     * General Error Page
     *
     * Takes an error message as input (either as a string or an array)
     * and displays it using the specified template.
     *
     * @param   string      $heading    Page heading
     * @param   string|string[] $message    Error message
     * @param   string      $template   Template name
     * @param   int     $status_code    (default: 500)
     *
     * @return  string  Error page output
     */
    public function show_error($heading, $message, $template = 'error_general', $status_code = 500) 
    {
        $templates_path = config_item('error_views_path');
        if (empty($templates_path)) {
            $templates_path = VIEWPATH .DIRECTORY_SEPARATOR.'errors' . DIRECTORY_SEPARATOR;
        }
        
        if (is_cli()) {
            $message = "\t" . (is_array($message) ? implode("\n\t", $message) : $message);
            $template = 'cli' . DIRECTORY_SEPARATOR . $template;
        } else {
            set_status_header($status_code);
            $message = '<p>' . (is_array($message) ? implode('</p><p>', $message) : $message) . '</p>';
            $template = 'html' . DIRECTORY_SEPARATOR . $template;
        }

        if (ob_get_level() > $this->ob_level + 1) {
            ob_end_flush();
        }
        ob_start();
        include($templates_path . $template . '.php');
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
        $this->CI =& get_instance();
        $data = $this->CI->db
                ->select("{$this->table}.{$this->primaryKey}")
                ->select('parent_page, page_name, page_type, uri_path, module, ext_link, icon_image')
                ->join($this->foreign_table_status, "{$this->foreign_table_status}.{$this->foreign_key_status} = {$this->table}.{$this->foreign_key_status}", 'left')
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
                if ($record['page_type'] == 1) {
                    $menu_href = site_url('pages/'.$record['uri_path']);
                    if ($this->CI->uri->segment(1) == 'pages' && strtolower($this->CI->uri->segment(2)) == strtolower($record['uri_path'])) {
                        $data[$row]['attributes'] = 'class="active"';
                    }
                } elseif ($record['page_type'] == 2) {
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
                $data[$row]['menu_href'] = $menu_href;

                $detail = $this->CI->db
                        ->select('title')
                        ->join($this->foreign_table_localization, "{$this->foreign_table_localization}.{$this->foreign_key_localization} = {$this->child_table_detail}.{$this->foreign_key_localization}", 'left')
                        ->where('LCASE(iso_1)', $this->CI->lang->get_active_uri_lang())
                        ->where($this->primaryKey, $record[$this->primaryKey])
                        ->limit(1)
                        ->get($this->child_table_detail)
                        ->row_array();

                $data[$row]['menu_title'] = $detail['title'];
            }
        }

        return $data;
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
        $this->CI =& get_instance();
        $data = $this->CI->db
                ->select("{$this->table}.{$this->primaryKey}")
                ->select('parent_page, page_name, page_type, uri_path, module, ext_link, icon_image')
                ->join($this->foreign_table_status, "{$this->foreign_table_status}.{$this->foreign_key_status} = {$this->table}.{$this->foreign_key_status}", 'left')
                ->where('LCASE(status_text)', 'publish')
                ->where('is_delete', 0)
                ->where('is_footer', 1)
                ->where('parent_page', $parent)
                ->order_by('position', 'asc')
                ->order_by($this->primaryKey, 'desc')
                ->get($this->table)
                ->result_array();
        if ($data) {
            foreach ($data as $row => $record) {
                $data[$row]['attributes'] = '';
                if ($record['page_type'] == 1) {
                    $menu_href = site_url('pages/'.$record['uri_path']);
                } elseif ($record['page_type'] == 2) {
                    $menu_href = site_url($record['module']);
                } else {
                    $menu_href = $record['ext_link'];
                    if ($record['ext_link'] != '' && $record['ext_link'] != '#') {
                        $data[$row]['attributes'] = 'target="_blank"';
                    }
                }
                $data[$row]['menu_href'] = $menu_href;

                $detail = $this->CI->db
                        ->select('title')
                        ->join($this->foreign_table_localization, "{$this->foreign_table_localization}.{$this->foreign_key_localization} = {$this->child_table_detail}.{$this->foreign_key_localization}", 'left')
                        ->where('LCASE(iso_1)', $this->CI->lang->get_active_uri_lang())
                        ->where($this->primaryKey, $record[$this->primaryKey])
                        ->limit(1)
                        ->get($this->child_table_detail)
                        ->row_array();

                $data[$row]['menu_title'] = $detail['title'];
            }
        }

        return $data;
    }

}

/* End of file FAT_Exceptions.php */
/* Location: ./application/core/FAT_Exceptions.php */
