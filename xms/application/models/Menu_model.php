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
class Menu_model extends CI_Model
{
    /**
     * Class constructor.
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all group data.
     *
     * @param array $param
     *
     * @return array|bool $data
     */
    function GetAllMenuData($param = [])
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
                ->select('auth_menu.*, auth_menu.id_auth_menu as id, parent_auth_menu.parent_menu')
                ->join(
                    "(
                        SELECT id_auth_menu, menu as parent_menu 
                        FROM {$this->db->dbprefix('auth_menu')}
                    ) AS {$this->db->dbprefix('parent_auth_menu')}",
                    'parent_auth_menu.id_auth_menu = auth_menu.parent_auth_menu',
                    'left'
                )
                ->get('auth_menu')
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
    function CountAllMenu($param = [])
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
                ->from('auth_menu')
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
    function GetMenu($id)
    {
        $data = $this->db
                ->where('id_auth_menu', $id)
                ->limit(1)
                ->get('auth_menu')
                ->row_array();

        return $data;
    }

    /**
     * Insert new record.
     *
     * @param array $param
     *
     * @return int $last_id last inserted id
     */
    function InsertRecord($param)
    {
        $this->db->insert('auth_menu', $param);
        $last_id = $this->db->insert_id();

        return $last_id;
    }

    /**
     * Update record admin group.
     *
     * @param int   $id
     * @param array $param
     */
    function UpdateRecord($id, $param)
    {
        $this->db
            ->where('id_auth_menu', $id)
            ->update('auth_menu', $param);
    }

    /**
     * Delete record.
     *
     * @param int $id
     */
    function DeleteRecord($id)
    {
        $this->db->delete(['auth_menu', 'auth_menu_group'], ['id_auth_menu' => $id]);
    }

    /**
     * Get max position in table.
     *
     * @return int maximum value
     */
    function MaxPosition()
    {
        $data = $this->db
                ->select('max(position) as max_position')
                ->get('auth_menu')
                ->row_array();
        if ($data) {
            return $data['max_position'];
        } else {
            return '0';
        }
    }

    /**
     * Get menu children id by id menu.
     *
     * @param int $id_menu
     *
     * @return array $return
     */
    function MenusIdChildrenTaxonomy($id_menu)
    {
        $return = [];
        $data = $this->db
                ->select('id_auth_menu')
                ->where('parent_auth_menu', $id_menu)
                ->get('auth_menu')
                ->result_array();
        foreach ($data as $row) {
            $return[] = $row['id_auth_menu'];
            $children = $this->MenusIdChildrenTaxonomy($row['id_auth_menu']);
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
    function MenusData($id_parent = 0)
    {
        if (!is_superadmin()) {
            $this->db->where('is_superadmin', 0);
        }
        $data = $this->db
                ->select('id_auth_menu as id, parent_auth_menu as parent_id, menu')
                ->where('parent_auth_menu', $id_parent)
                ->order_by('position', 'asc')
                ->order_by('auth_menu.id_auth_menu', 'asc')
                ->get('auth_menu')
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
    function PrintAuthMenu($menus = [], $prefix = '', $selected = '', $disabled = [])
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
     * Check exist file/path.
     *
     * @param string $file
     * @param int    $id
     *
     * @return bool true/false
     */
    function checkExistsFilePath($file, $id = 0)
    {
        if ($id != '' && $id != 0) {
            $this->db->where('id_auth_menu !=', $id);
        }
        $count_records = $this->db
                ->from('auth_menu')
                ->where('LCASE(file)', strtolower($file))
                ->count_all_results();
        if ($count_records > 0) {
            return false;
        }

        return true;
    }

    /**
     * Check if user/group have access rights to menu.
     *
     * @param int $id_group
     * @param int $id_menu
     *
     * @return bool true/false
     */
    function checkUserHaveRightsMenu($id_group, $id_menu)
    {
        $count = $this->db
                ->from('auth_menu_group')
                ->where('id_auth_group', $id_group)
                ->where('id_auth_menu', $id_menu)
                ->count_all_results();
        if ($count > 0) {
            return true;
        }

        return false;
    }

    /**
     * Insert auth, this function is just for development only. otherwise, should be de-activated.
     *
     * @param array $data
     *
     * @return int $last_id last inserted id
     */
    function InsertAuth($data)
    {
        $this->db->insert('auth_menu_group', $data);
        $last_id = $this->db->insert_id();

        return $last_id;
    }
}
/* End of file Menu_model.php */
/* Location: ./application/models/Menu_model.php */
