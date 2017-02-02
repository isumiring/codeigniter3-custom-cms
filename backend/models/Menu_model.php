<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Menu Model Class.
 *
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 *
 * @version 3.0
 *
 * @category Model
 */
class Menu_model extends FAT_Model
{
    /**
     * The database table used by the model
     * 
     * @var string
     */
    protected $table = 'auth_menu';

    /**
     * Primary key of the table
     * 
     * @var string
     */
    protected $primaryKey = 'id_auth_menu';

    /**
     * The database foreign table used by the model
     * 
     * @var string
     */
    protected $foreign_table_group = 'auth_menu_group';

    /**
     * Foreign key of the main table
     * 
     * @var string
     */
    protected $foreign_key_group = 'id_auth_group';

    /**
     * Class constructor.
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
    public function GetAllMenuData($param = [])
    {
        if ( ! is_superadmin()) {
            $this->db->where('is_superadmin', 0);
        }
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
                ->select($this->table. '.*, '.$this->table.'.'.$this->primaryKey.' as id, parent_auth_menu.parent_menu')
                ->join(
                    "(
                        SELECT {$this->primaryKey}, menu as parent_menu 
                        FROM {$this->db->dbprefix($this->table)}
                    ) AS {$this->db->dbprefix('parent_auth_menu')}",
                    'parent_auth_menu.'.$this->primaryKey.' = '.$this->table.'.parent_auth_menu',
                    'left'
                )
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
    public function CountAllMenu($param = [])
    {
        if ( ! is_superadmin()) {
            $this->db->where('is_superadmin', 0);
        }
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
    public function GetMenu($id)
    {
        $data = $this->db
                ->where($this->primaryKey, $id)
                ->limit(1)
                ->get($this->table)
                ->row_array();

        return $data;
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
                ->where('parent_auth_menu', $id_menu)
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

    /**
     * Get all auth menu.
     *
     * @param int $id_parent
     *
     * @return array|bool $data
     */
    public function MenusData($id_parent = 0)
    {
        if (!is_superadmin()) {
            $this->db->where('is_superadmin', 0);
        }
        $data = $this->db
                ->select($this->primaryKey. ' as id, parent_auth_menu as parent_id, menu')
                ->where('parent_auth_menu', $id_parent)
                ->order_by('position', 'asc')
                ->order_by($this->table. '.'. $this->primaryKey, 'asc')
                ->get($this->table)
                ->result_array();
        foreach ($data as $row => $val) {
            $data[$row]['children'] = $this->MenusData($val['id']);
        }

        return $data;
    }

    /**
     * Print auth menu to html.
     *
     * @param array  $menus
     * @param string $prefix
     * @param string $selected
     * @param array  $disabled
     *
     * @return string $return
     */
    public function PrintAuthMenu($menus = [], $prefix = '', $selected = '', $disabled = [])
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
                        $return .= $this->PrintAuthMenu($menu['children'], $prefix.'--', $selected, $disabled);
                    }
                }
            }
        }

        return $return;
    }

    /**
     * Check if user/group have access rights to menu.
     *
     * @param int $id_group
     * @param int $id_menu
     *
     * @return bool true/false
     */
    public function checkUserHaveRightsMenu($id_group, $id_menu)
    {
        $count = $this->db
                ->from($this->foreign_table_group)
                ->where($this->foreign_key_group, $id_group)
                ->where($this->primaryKey, $id_menu)
                ->count_all_results();
        if ($count > 0) {
            return true;
        }

        return false;
    }
}
/* End of file Menu_model.php */
/* Location: ./application/models/Menu_model.php */
