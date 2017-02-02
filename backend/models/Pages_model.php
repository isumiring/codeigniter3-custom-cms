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
class Pages_model extends FAT_Model
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
    protected $foreign_table_localization = 'localization';

    /**
     * Foreign key of the main table
     * 
     * @var string
     */
    protected $foreign_key_localization = 'id_localization';

    /**
     * constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get Table Value.
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
     * Set Table Value.
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
     * Get all data.
     *
     * @param array $param
     * 
     * @return array|bool $data
     */
    public function GetAllData($param = [])
    {
        if (isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i = 0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i == 0) {
                        $this->db->like('LCASE(`'.$val['data'].'`)', strtolower($param['search_value']));
                    } else {
                        $this->db->or_like('LCASE(`'.$val['data'].'`)', strtolower($param['search_value']));
                    }
                    $i++;
                }
            }
            $this->db->group_end();
        }
        if (isset($param['row_from']) && isset($param['length'])) {
            $this->db->limit($param['length'], $param['row_from']);
        }
        if (isset($param['order_field'])) {
            if (isset($param['order_sort'])) {
                $this->db->order_by($param['order_field'], $param['order_sort']);
            } else {
                $this->db->order_by($param['order_field'], 'desc');
            }
        } else {
            $this->db->order_by('id', 'desc');
        }
        $data = $this->db
                ->select('*')
                ->select($this->primaryKey. ' as id')
                ->join(
                    "(
                        SELECT page_name as parent_page_name, {$this->primaryKey} as page_id FROM {$this->db->dbprefix($this->table)}
                    ) as {$this->db->dbprefix('parent_page')}
                    ",
                    'parent_page.page_id = '.$this->table.'.parent_page',
                    'left'
                )
                ->join($this->foreign_table_status, $this->foreign_table_status. '.'. $this->foreign_key_status.' = '.$this->table.'.'. $this->foreign_key_status, 'left')
                ->where('is_delete', 0)
                ->get($this->table)
                ->result_array();

        return $data;
    }

    /**
     * Count records.
     *
     * @param array $param
     *
     * @return int $total_records total records
     */
    public function CountAllData($param = [])
    {
        if (is_array($param) && isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i = 0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i == 0) {
                        $this->db->like('LCASE(`'.$val['data'].'`)', strtolower($param['search_value']));
                    } else {
                        $this->db->or_like('LCASE(`'.$val['data'].'`)', strtolower($param['search_value']));
                    }
                    $i++;
                }
            }
            $this->db->group_end();
        }
        $total_records = $this->db
                ->from($this->table)
                ->join(
                    "(
                        SELECT page_name as parent_page_name, {$this->primaryKey} as page_id FROM {$this->db->dbprefix($this->table)}
                    ) as {$this->db->dbprefix('parent_page')}
                    ",
                    'parent_page.page_id = '.$this->table.'.parent_page',
                    'left'
                )
                ->join($this->foreign_table_status, $this->foreign_table_status. '.'. $this->foreign_key_status.' = '.$this->table.'.'. $this->foreign_key_status, 'left')
                ->where('is_delete', 0)
                ->count_all_results();

        return $total_records;
    }

    /**
     * Get detail by id.
     *
     * @param int $id
     * 
     * @return array|bool $data
     */
    public function GetPage($id)
    {
        $data = $this->db
                ->select('*')
                ->select($this->primaryKey. ' as id')
                ->where($this->primaryKey, $id)
                ->limit(1)
                ->get($this->table)
                ->row_array();

        if ($data) {
            $locales = $this->db
                        ->select('*')
                        ->where($this->primaryKey, $id)
                        ->order_by($this->foreign_key_localization, 'asc')
                        ->get($this->child_table_detail)
                        ->result_array();
            foreach ($locales as $row => $local) {
                $data['locales'][$local[$this->foreign_key_localization]]['title']       = $local['title'];
                $data['locales'][$local[$this->foreign_key_localization]]['teaser']      = $local['teaser'];
                $data['locales'][$local[$this->foreign_key_localization]]['description'] = $local['description'];
            }
        }
        return $data;
    }

    /**
     * Get parent menu data hierarcy.
     *
     * @param int $id_parent
     * 
     * @return array|bool $data
     */
    public function MenusData($id_parent = 0)
    {
        $data = $this->db
                ->select($this->primaryKey. ' as id')
                ->select('parent_page as parent_id, page_name as menu')
                ->where('parent_page', $id_parent)
                ->where('is_delete', 0)
                ->order_by('position', 'asc')
                ->get($this->table)
                ->result_array();

        foreach ($data as $row => $parent) {
            $data[$row]['children'] = $this->MenusData($parent['id']);
        }

        return $data;
    }

    /**
     * Print parent menu to html.
     *
     * @param array  $menus
     * @param string $prefix
     * @param string $selected
     * @param array  $disabled
     *
     * @return string $return
     */
    public function PrintMenu($menus = [], $prefix = '', $selected = '', $disabled = [])
    {
        $return = '';
        if ($menus) {
            foreach ($menus as $row => $menu) {
                if ($disabled && in_array($menu['id'], $disabled)) {
                    $return .= '';
                } elseif ($disabled && $selected == $menu['parent_id'] && $selected != '' && $selected != '0') {
                    $return .= '';
                } else {
                    if ($menu['id'] == $selected && $selected != '') {
                        $return .= '<option value="'.$menu['id'].'" selected="selected">'.$prefix.'&nbsp;'.$menu['menu'].'</option>';
                    } else {
                        $return .= '<option value="'.$menu['id'].'">'.$prefix.'&nbsp;'.$menu['menu'].'</option>';
                    }
                    if (isset($menu['children']) && count($menu['children']) > 0) {
                        $return .= $this->PrintMenu($menu['children'], $prefix.'--', $selected, $disabled);
                    }
                }
            }
        }

        return $return;
    }

    /**
     * Get menu children id by id menu.
     *
     * @param int $id_menu
     *
     * @return array $return
     */
    public function MenusIdChildrenTaxonomy($id_menu)
    {
        $return = [];
        $data = $this->db
                ->select($this->primaryKey)
                ->where('parent_page', $id_menu)
                ->get($this->table)
                ->result_array();

        foreach ($data as $row) {
            $return[] = $row[$this->primaryKey];
            $children = $this->MenusIdChildrenTaxonomy($row[$this->primaryKey]);
            $return   = array_merge($return, $children);
        }

        $return[] = $id_menu;

        return $return;
    }
}
/* End of file Pages_model.php */
/* Location: ./application/models/Pages_model.php */
