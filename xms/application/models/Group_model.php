<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Group Model Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Group model
 * 
 */
class Group_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * get all group data
     * @param string $param
     * @return array data
     */
    function GetAllGroupData($param=array()) {
        if (!is_superadmin()) {
            $this->db->where('is_superadmin',0);
        }
        if (isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i=0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i==0) {
                        $this->db->like('LCASE(`'.$val['data'].'`)',strtolower($param['search_value']));
                    } else {
                        $this->db->or_like('LCASE(`'.$val['data'].'`)',strtolower($param['search_value']));
                    }
                    $i++;
                }
            }
            $this->db->group_end();
        }
        if (isset($param['row_from']) && isset($param['length'])) {
            $this->db->limit($param['length'],$param['row_from']);
        }
        if (isset($param['order_field'])) {
            if (isset($param['order_sort'])) {
                $this->db->order_by($param['order_field'],$param['order_sort']);
            } else {
                $this->db->order_by($param['order_field'],'desc');
            }
        } else {
            $this->db->order_by('id','desc');
        }
        $data = $this->db
                ->select('*,id_auth_group as id')
                ->get('auth_group')
                ->result_array();
        return $data;
    }
    
    /**
     * count records
     * @param string $param
     * @return int total records
     */
    function CountAllGroup($param=array()) {
        if (!is_superadmin()) {
            $this->db->where('is_superadmin',0);
        }
        if (is_array($param) && isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i=0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i==0) {
                        $this->db->like('LCASE(`'.$val['data'].'`)',strtolower($param['search_value']));
                    } else {
                        $this->db->or_like('LCASE(`'.$val['data'].'`)',strtolower($param['search_value']));
                    }
                    $i++;
                }
            }
            $this->db->group_end();
        }
        $total_records = $this->db
                ->from('auth_group')
                ->count_all_results();
        return $total_records;
    }
    
    /**
     * Get admin group detail by id
     * @param int $id
     * @return array data
     */
    function GetGroup($id) {
        $data = $this->db
                ->where('id_auth_group',$id)
                ->limit(1)
                ->get('auth_group')
                ->row_array();
        
        return $data;
    }
    
    /**
     * insert new record
     * @param array $param
     * @return int last inserted id
     */
    function InsertRecord($param) {
        $this->db->insert('auth_group',$param);
        $last_id = $this->db->insert_id();
        return $last_id;
    }
    
    /**
     * update record admin group
     * @param int $id
     * @param array $param
     */
    function UpdateRecord($id,$param) {
        $this->db->where('id_auth_group',$id);
        $this->db->update('auth_group',$param);
    }
    
    /**
     * delete record
     * @param int $id
     */
    function DeleteRecord($id) {
        $this->db->where('id_auth_group',$id);
        $this->db->delete('auth_group');
    }
    
    /**
     * get all auth menu
     * @param int $id_parent
     * @return array data
     */
    function MenusData($id_group=0,$id_parent=0) {
        if (!is_superadmin()) {
            $this->db->where('is_superadmin',0);
        }
        $data = $this->db
                ->join(
                    "
                        (select id_auth_menu as id_auth,id_auth_group from {$this->db->dbprefix('auth_menu_group')} where id_auth_group={$id_group}) {$this->db->dbprefix('auth_menu_group')}
                    ",
                    'auth_menu_group.id_auth=auth_menu.id_auth_menu',
                    'left'
                )
                ->where('parent_auth_menu',$id_parent)
                ->order_by('position','asc')
                ->order_by('auth_menu.id_auth_menu','asc')
                ->get('auth_menu')
                ->result_array();
        foreach ($data as $row => $val) {
            if ($val['id_auth_group'] == $id_group) {
                $data[$row]['checked'] = true;
            } else {
                $data[$row]['checked'] = false;
            }
            $data[$row]['children'] = $this->MenusData($id_group,$val['id_auth_menu']);
        }
        return $data;
    }
    
    /**
     * update authorization
     * @param int $id_group
     * @param array $data
     */
    function UpdateAuth($id_group,$data=array()) {
        $this->db->where('id_auth_group',$id_group);
        $this->db->delete('auth_menu_group');
        if (count($data)>0) {
            $insert=array();
            foreach ($data as $row => $val) {
                $insert[$row]['id_auth_group'] = $id_group;
                $insert[$row]['id_auth_menu'] = $val;
            }
            $this->db->insert_batch('auth_menu_group',$insert);
        }
    }
    
    /**
     * print auth menu to html
     * @param array $menus
     * @param string $prefix
     * @return string $return
     */
    function PrintAuthMenu($menus=array(),$prefix='') {
        $return = '';
        if ($menus) {
            foreach ($menus as $row => $menu) {
                $return .= '<div class="checkbox">';
                if ($menu['parent_auth_menu'] != 0) {
                    $return .= $prefix;
                    $return .= '<img src="'.GLOBAL_IMG_URL.'tree-taxo.png"/>&nbsp;&nbsp;';
                } else {
                    $prefix = '';
                }
                $checked = '';
                $return .= '<label>';
                if ($menu['checked'] == true) {
                    $checked = 'checked="checked"';
                }
                $return .= '<input type="checkbox" value="'.$menu['id_auth_menu'].'" name="auth_menu_group[]" id="auth-'.$menu['id_auth_menu'].'" class="auth-menu checkauth" '.$checked.'/><label for="auth-'.$menu['id_auth_menu'].'" class="auth-menu">'.$menu['menu'].'</label>';
                $return .= '</label>';
                $return .= '</div>';
                if (isset($menu['children']) && count($menu['children'])>0) {
                    $prefix .= '&nbsp;&nbsp;&nbsp;&nbsp;';
                    $return .= $this->PrintAuthMenu($menu['children'],$prefix);
                }
            }
        }
        return $return;
    }
    
    /**
     * print list of menu to checkbox
     * @param int $id_group
     * @param int $id_parent
     * @param string $prefix
     * @return string return
     */
    function printAuthMenuGroup($id_group,$id_parent=0, $prefix='')
    {
        $tmp_menu = '';
        $menus = $this->getMenus($id_parent);
        foreach ($menus as $menu) 
        {
            $checked = '';
            $tree = '';
            $divider = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $id_auth_menu_group = $this->getAuthMenuGroup($id_group,$menu["id_auth_menu"]);
            if ($id_auth_menu_group)
            {
                $checked = 'checked="checked"';
            }
            if ($id_parent != 0) {
                $tree = '&nbsp;&nbsp;<img src="'.IMG_URL.'tree-tax.png" class="tree-tax" alt="taxo"/>';
            }
            $tmp_menu .=  '<label class="checkbox" style="margin-top: 8px;">
                                <input type="checkbox" value="'.$menu["id_auth_menu"].'" '.$checked.'" id="menu-group-'.$menu["id_auth_menu"].'" name="auth_menu_group[]" class="checkauth">
                        '.$prefix.' '.$tree.' &nbsp;&nbsp;'.$menu["menu"].'</label>';

           $tmp_menu .=  $this->printAuthMenuGroup($id_group,$menu["id_auth_menu"], $prefix.$divider);
        }
        return $tmp_menu;
    }
    
}
/* End of file Group_model.php */
/* Location: ./application/models/Group_model.php */