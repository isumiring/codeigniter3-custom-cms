<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Pages Model Class.
 * 
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * 
 * @version 3.0
 * 
 * @category Model
 * 
 */
class Pages_model extends CI_Model
{
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
     * Class constructor.
     * 
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get Identifier Value.
     * 
     * @param string $key
     * 
     * @return string table value.
     */
    public function GetIdentifier($key)
    {
        return $this->{$key};
    }

    /**
     * Set Identifier Value.
     * 
     * @param string $key
     * @param string $value
     * 
     * @return object|array|string $this
     */
    public function SetIdentifier($key, $value)
    {
        $this->{$key} = $value;

        return $this;
    }

    /**
     * Get Page Info.
     * 
     * @param array $conditions
     *
     * @return array|bool $data
     */
    public function GetPageInfo($conditions = [])
    {
        if (isset($conditions) && count($conditions) > 0) {
            foreach ($conditions as $key => $value) {
                if (ctype_digit($value)) {
                    $this->db->where("{$this->db->dbprefix($this->table)}.{$key}", $value);
                } else {
                    $this->db->where("LCASE({$this->db->dbprefix($this->table)}.{$key})", strtolower($value));
                }
            }
        }
        $data = $this->db
                ->join($this->foreign_table_status, "{$this->foreign_table_status}.{$this->foreign_key_status} = {$this->table}.{$this->foreign_key_status}", 'left')
                ->join($this->child_table_detail, "{$this->child_table_detail}.{$this->primaryKey} = {$this->table}.{$this->primaryKey}", 'left')
                ->join($this->foreign_table_localization, "{$this->foreign_table_localization}.{$this->foreign_key_localization} = {$this->child_table_detail}.{$this->foreign_key_localization}", 'left')
                ->where("LCASE({$this->db->dbprefix($this->foreign_table_status)}.status_text)", "publish")
                ->where('is_delete', 0)
                ->where("LCASE({$this->db->dbprefix($this->foreign_table_localization)}.iso_1)", $this->lang->get_active_uri_lang())
                ->limit(1)
                ->get($this->table)
                ->row_array();

        return $data;
    }

    /**
     * Get Pages.
     * 
     * @param array $conditions
     *
     * @return array|bool $data
     */
    public function GetPages($conditions = [])
    {
        if (isset($conditions) && count($conditions) > 0) {
            foreach ($conditions as $key => $value) {
                if (ctype_digit($value)) {
                    $this->db->where("{$this->table}.{$key}", $value);
                } else {
                    $this->db->where("LCASE({$this->table}.{$key})", strtolower($value));
                }
            }
        }
        $data = $this->db
                ->join($this->foreign_table_status, "{$this->foreign_table_status}.{$this->foreign_key_status} = {$this->table}.{$this->foreign_key_status}", 'left')
                ->join($this->child_table_detail, "{$this->child_table_detail}.{$this->primaryKey} = {$this->table}.{$this->primaryKey}", 'left')
                ->join($this->foreign_table_localization, "{$this->foreign_table_localization}.{$this->foreign_key_localization} = {$this->child_table_detail}.{$this->foreign_key_localization}", 'left')
                ->where("LCASE({$this->db->dbprefix($this->foreign_table_status)}.status_text)", "publish")
                ->where('is_delete', 0)
                ->where("LCASE({$this->db->dbprefix($this->foreign_table_localization)}.iso_1)", $this->lang->get_active_uri_lang())
                ->order_by('position', 'asc')
                ->get($this->table)
                ->result_array();

        return $data;
    }

    /**
     * Print Main Menu to html.
     * 
     * @param integer $id_parent
     *
     * @return string $return
     */
    function PrintMainMenu($id_parent = 0, $class= '')
    {
        $return = '';
        $data = $this->db
                ->join($this->foreign_table_status, "{$this->foreign_table_status}.{$this->foreign_key_status} = {$this->table}.{$this->foreign_key_status}", 'left')
                ->join($this->child_table_detail, "{$this->child_table_detail}.{$this->primaryKey} = {$this->table}.{$this->primaryKey}", 'left')
                ->join($this->foreign_table_localization, "{$this->foreign_table_localization}.{$this->foreign_key_localization} = {$this->child_table_detail}.{$this->foreign_key_localization}", 'left')
                ->where("LCASE({$this->db->dbprefix($this->foreign_table_status)}.status_text)", "publish")
                ->where('is_delete', 0)
                ->where("{$this->table}.parent_page", $id_parent)
                ->where("{$this->table}.is_header", 1)
                ->where("LCASE({$this->db->dbprefix($this->foreign_table_localization)}.iso_1)", $this->lang->get_active_uri_lang())
                ->order_by('position', 'asc')
                ->get($this->table)
                ->result_array();
        if ($data) {
            $return .= '<ul>';
            foreach ($data as $key => $row) {
                $attributes = '';
                if ($row['page_type'] == 'static_page') {
                    $menu_href = site_url('pages/'.$row['uri_path']);
                } elseif ($row['page_type'] == 'module') {
                    $menu_href = site_url($row['module']);
                } else {
                    $menu_href = $row['ext_link'];
                    if ($row['ext_link'] != '' && $row['ext_link'] != '#') {
                        $attributes = 'target="_blank"';
                    }
                }
                $return .= '<li><a href="'. $menu_href .'" '. $attributes .'>'. $row['page_name'] .'</a></li>';
                $return .= $this->PrintSiteMap($row['id_page']);
            }
            $return .= '</ul>';
        }

        return $return;
    }
    
}
/* End of file Pages_model.php */
/* Location: ./application/models/Pages_model.php */