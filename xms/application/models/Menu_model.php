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
 * @desc Menu model
 */
class Menu_model extends CI_Model
{
    /**
     * constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * get all group data.
     *
     * @param string $param
     *
     * @return array data
     */
    public function GetAllMenuData($param = [])
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
                ->select('auth_menu.*,auth_menu.id_auth_menu as id, parent_auth_menu.parent_menu')
                ->join(
                    "(SELECT id_auth_menu, menu as parent_menu FROM {$this->db->dbprefix('auth_menu')}) as parent_auth_menu",
                    'parent_auth_menu.id_auth_menu=auth_menu.parent_auth_menu',
                    'left'
                )
                ->get('auth_menu')
                ->result_array();

        return $data;
    }

    /**
     * count records.
     *
     * @param string $param
     *
     * @return int total records
     */
    public function CountAllMenu($param = [])
    {
        if (!is_superadmin()) {
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
     * @return array data
     */
    public function GetMenu($id)
    {
        $data = $this->db
                ->where('id_auth_menu', $id)
                ->limit(1)
                ->get('auth_menu')
                ->row_array();

        return $data;
    }

    /**
     * insert new record.
     *
     * @param array $param
     *
     * @return int last inserted id
     */
    public function InsertRecord($param)
    {
        $this->db->insert('auth_menu', $param);
        $last_id = $this->db->insert_id();

        return $last_id;
    }

    /**
     * update record admin group.
     *
     * @param int   $id
     * @param array $param
     */
    public function UpdateRecord($id, $param)
    {
        $this->db->where('id_auth_menu', $id);
        $this->db->update('auth_menu', $param);
    }

    /**
     * delete record.
     *
     * @param int $id
     */
    public function DeleteRecord($id)
    {
        $this->db->delete(['auth_menu', 'auth_menu_group'], ['id_auth_menu' => $id]);
    }

    /**
     * get max position in table.
     *
     * @return string max
     */
    public function MaxPosition()
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
     * get menu children id by id menu.
     *
     * @param int $id_menu
     *
     * @return array $return
     */
    public function MenusIdChildrenTaxonomy($id_menu)
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
            $return = array_merge($return, $children);
        }
        $return[] = $id_menu;

        return $return;
    }

    /**
     * get all auth menu.
     *
     * @param int $id_parent
     *
     * @return array data
     */
    public function MenusData($id_parent = 0)
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
     * print auth menu to html.
     *
     * @param array  $menus
     * @param string $prefix
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
     * update authorization.
     *
     * @param int   $id_group
     * @param array $data
     */
    public function UpdateAuth($id_group, $data = [])
    {
        $this->db->where('id_auth_menu', $id_group);
        $this->db->delete('auth_menu_group');
        if (count($data) > 0) {
            $insert = [];
            foreach ($data as $row => $val) {
                $insert[$row]['id_auth_menu'] = $id_group;
                $insert[$row]['id_auth_menu'] = $val;
            }
            $this->db->insert_batch('auth_menu_group', $insert);
        }
    }

    /**
     * print list of menu to checkbox.
     *
     * @param int    $id_group
     * @param int    $id_parent
     * @param string $prefix
     *
     * @return string return
     */
    public function printAuthMenuMenu($id_group, $id_parent = 0, $prefix = '')
    {
        $tmp_menu = '';
        $menus = $this->getMenus($id_parent);
        foreach ($menus as $menu) {
            $checked = '';
            $tree = '';
            $divider = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $id_auth_menu_group = $this->getAuthMenuMenu($id_group, $menu['id_auth_menu']);
            if ($id_auth_menu_group) {
                $checked = 'checked="checked"';
            }
            if ($id_parent != 0) {
                $tree = '&nbsp;&nbsp;<img src="'.IMG_URL.'tree-tax.png" class="tree-tax" alt="taxo"/>';
            }
            $tmp_menu .=  '<label class="checkbox" style="margin-top: 8px;">
                                <input type="checkbox" value="'.$menu['id_auth_menu'].'" '.$checked.'" id="menu-group-'.$menu['id_auth_menu'].'" name="auth_menu_group[]" class="checkauth">
                        '.$prefix.' '.$tree.' &nbsp;&nbsp;'.$menu['menu'].'</label>';

            $tmp_menu .=  $this->printAuthMenuMenu($id_group, $menu['id_auth_menu'], $prefix.$divider);
        }

        return $tmp_menu;
    }

    /**
     * check exist file/path.
     *
     * @param string $file
     * @param int    $id
     *
     * @return bool true/false
     */
    public function checkExistsFilepath($file, $id = 0)
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
        } else {
            return true;
        }
    }

    /**
     * check if user/group have access rights to menu.
     *
     * @param int $id_group
     * @param int $id_menu
     *
     * @return bool true/false
     */
    public function checkUserHaveRightsMenu($id_group, $id_menu)
    {
        $count = $this->db
                ->from('auth_menu_group')
                ->where('id_auth_group', $id_group)
                ->where('id_auth_menu', $id_menu)
                ->count_all_results();
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * insert auth, this function is just for development only. otherwise, should be de-activated.
     *
     * @param array $data
     *
     * @return int last inserted id
     */
    public function InsertAuth($data)
    {
        $this->db->insert('auth_menu_group', $data);

        return $this->db->insert_id();
    }
}
/* End of file Menu_model.php */
/* Location: ./application/models/Menu_model.php */
