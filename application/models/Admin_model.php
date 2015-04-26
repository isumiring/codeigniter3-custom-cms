<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin Model Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Admin model
 * 
 */
class Admin_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * get group data
     * @return array data
     */
    function GetGroups() {
        if (!is_superadmin()) {
            $this->db->where('is_superadmin',0);
        }
        $data = $this->db
                ->order_by('auth_group','asc')
                ->get('auth_group')
                ->result_array();
        
        return $data;
    }
    
    /**
     * get all admin data
     * @param string $param
     * @return array data
     */
    function GetAllAdminData($param=array()) {
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
                ->select('auth_user.*,auth_group.auth_group,id_auth_user as id')
                ->join('auth_group','auth_group.id_auth_group=auth_user.id_auth_group','left')
                ->get('auth_user')
                ->result_array();
        return $data;
    }
    
    /**
     * count records
     * @param string $param
     * @return int total records
     */
    function CountAllAdmin($param=array()) {
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
                ->from('auth_user')
                ->join('auth_group','auth_group.id_auth_group=auth_user.id_auth_group','left')
                ->count_all_results();
        return $total_records;
    }
    
    /**
     * Get admin user detail by id
     * @param int $id
     * @return array data
     */
    function GetAdmin($id) {
        $data = $this->db
                ->where('id_auth_user',$id)
                ->limit(1)
                ->get('auth_user')
                ->row_array();
        
        return $data;
    }
    
    /**
     * insert new record
     * @param array $param
     * @return int last inserted id
     */
    function InsertRecord($param) {
        $this->db->insert('auth_user',$param);
        $last_id = $this->db->insert_id();
        return $last_id;
    }
    
    /**
     * update record admin user
     * @param int $id
     * @param array $param
     */
    function UpdateRecord($id,$param) {
        $this->db->where('id_auth_user',$id);
        $this->db->update('auth_user',$param);
    }
    
    /**
     * delete record
     * @param int $id
     */
    function DeleteRecord($id) {
        $this->db->where('id_auth_user',$id);
        $this->db->delete('auth_user');
    }
    
    /**
     * check exist email
     * @param string $email
     * @param int $id
     * @return boolean true/false 
     */
    function checkExistsEmail($email,$id=0) {
        if ($id != '' && $id != 0) {
            $this->db->where('id_auth_user !=',$id);
        }
        $count_records = $this->db
                ->from('auth_user')
                ->where('LCASE(email)',strtolower($email))
                ->count_all_results();
        if ($count_records>0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    /**
     * check exist username
     * @param string $username
     * @param int $id
     * @return boolean true/false 
     */
    function checkExistsUsername($username,$id=0) {
        if ($id != '' && $id != 0) {
            $this->db->where('id_auth_user !=',$id);
        }
        $count_records = $this->db
                ->from('auth_user')
                ->where('username',$username)
                ->count_all_results();
        if ($count_records>0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
}
/* End of file Admin_model.php */
/* Location: ./application/models/Admin_model.php */