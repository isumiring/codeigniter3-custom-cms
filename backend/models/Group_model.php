<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Group Model Class.
 *
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 *
 * @version 3.0
 *
 * @category Model
 * 
 */
class Group_model extends FAT_Model
{
    /**
     * The database table used by the model
     * 
     * @var string
     */
    protected $table = 'auth_group';

    /**
     * Primary key of the table
     * 
     * @var string
     */
    protected $primaryKey = 'id_auth_group';

    /**
     * The database foreign table used by the model
     * 
     * @var string
     */
    protected $foreign_table_menu = 'auth_menu';

    /**
     * Foreign key of the main table
     * 
     * @var string
     */
    protected $foreign_key_menu = 'id_auth_menu';

    /**
     * The database foreign table used by the model
     * 
     * @var string
     */
    protected $foreign_table_menu_group = 'auth_menu_group';

    /**
     * Foreign key of the main table
     * 
     * @var string
     */
    protected $foreign_key_menu_group = 'id_auth_menu_group';

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
     * Get all group data.
     *
     * @param array $param
     *
     * @return array|bool $data
     */
    public function GetAllData($param = [])
    {
        if (!is_superadmin()) {
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
                ->select('*, '.$this->primaryKey.' as id')
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
     * Get admin group detail by id.
     *
     * @param int $id
     *
     * @return array|bool $data
     */
    public function GetGroup($id)
    {
        $data = $this->db
                ->where($this->primaryKey, $id)
                ->limit(1)
                ->get($this->table)
                ->row_array();

        return $data;
    }

    /**
     * Get all auth menu.
     *
     * @param int $id_parent
     *
     * @return array|bool $data
     */
    public function MenusData($id_group = 0, $id_parent = 0)
    {
        if (!is_superadmin()) {
            $this->db->where('is_superadmin', 0);
        }
        $data = $this->db
                ->join(
                    "(
                        SELECT {$this->foreign_key_menu} as id_auth, {$this->primaryKey} 
                        FROM {$this->db->dbprefix($this->foreign_table_menu_group)} 
                        WHERE {$this->primaryKey} = {$id_group}
                    ) AS {$this->db->dbprefix($this->foreign_table_menu_group)}", 
                    $this->foreign_table_menu_group. '.id_auth = '.$this->foreign_table_menu. '.'. $this->foreign_key_menu, 
                    'left'
                )
                ->where('parent_auth_menu', $id_parent)
                ->order_by('position', 'asc')
                ->order_by($this->foreign_table_menu. '.'. $this->foreign_key_menu, 'asc')
                ->get($this->foreign_table_menu)
                ->result_array();

        foreach ($data as $row => $val) {
            $data[$row]['checked'] = false;
            if ($val[$this->primaryKey] == $id_group) {
                $data[$row]['checked'] = true;
            }
            $data[$row]['children'] = $this->MenusData($id_group, $val[$this->foreign_key_menu]);
        }

        return $data;
    }

    /**
     * Print auth menu to html.
     *
     * @param array  $menus
     * @param string $prefix
     *
     * @return string $return
     */
    public function PrintAuthMenu($menus = [], $prefix = '')
    {
        $return = '';
        if ($menus) {
            foreach ($menus as $row => $menu) {
                $return .= '<div class="checkbox">';
                $return .= '<label>';
                if ($menu['parent_auth_menu'] != 0) {
                    $return .= $prefix;
                    $return .= '<img src="'.PATH_CMS.'assets/default/img/tree-taxo.png"/>&nbsp;&nbsp;';
                } else {
                    $prefix = '';
                }
                $checked = '';
                if ($menu['checked'] == true) {
                    $checked = 'checked="checked"';
                }
                $return .= '<input type="checkbox" value="'.$menu[$this->foreign_key_menu].'" name="auth_menu_group[]" id="auth-'.$menu[$this->foreign_key_menu].'" class="auth-menu checkauth" '.$checked.'/> '.$menu['menu'];
                $return .= '</label>';
                $return .= '</div>';
                if (isset($menu['children']) && count($menu['children']) > 0) {
                    $prefix .= '&nbsp;&nbsp;&nbsp;&nbsp;';
                    $return .= $this->PrintAuthMenu($menu['children'], $prefix);
                }
            }
        }

        return $return;
    }
}
/* End of file Group_model.php */
/* Location: ./application/models/Group_model.php */
