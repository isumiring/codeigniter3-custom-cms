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
        if (isset($param['search_value'])) {
            $this->db->group_start();
            $i=0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i==0) {
                        $this->db->like('LCASE('.$val['data'].')',strtolower($param['search_value']));
                    } else {
                        $this->db->or_like('LCASE('.$val['data'].')',strtolower($param['search_value']));
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
        if (is_array($param) && isset($param['search_value'])) {
            $this->db->group_start();
            $i=0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i==0) {
                        $this->db->like('LCASE('.$val['data'].')',strtolower($param['search_value']));
                    } else {
                        $this->db->or_like('LCASE('.$val['data'].')',strtolower($param['search_value']));
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
/* End of file Group_model.php */
/* Location: ./application/models/Group_model.php */