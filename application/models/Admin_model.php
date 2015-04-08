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
     * get all admin data
     * @return array data
     */
    function GetAllAdmin($search,$start,$perpage) {
        if (!is_superadmin()) {
            $this->db->where('is_superadmin',0);
        }
        if ($search != '') {
            $this->db
                ->group_start()
                    ->like('LCASE(username)', strtolower($search))
                    ->or_like('LCASE(name)', strtolower($search))
                    ->or_like('LCASE(email)', strtolower($search))
                    ->or_like('LCASE(auth_group)', strtolower($search))
                ->group_end();
        }
        $data = $this->db
                ->select('*,id_auth_user as id')
                ->from('auth_user')
                ->join('auth_group','auth_group.id_auth_group=auth_user.id_auth_group','left')
                ->order_by('id','desc')
                ->limit($perpage,$start)
                ->get()
                ->result_array();
        return $data;
    }
    
    /**
     * count records
     * @param string $search
     * @return int total records
     */
    function CountAllAdmin($search='') {
        if (!is_superadmin()) {
            $this->db->where('is_superadmin',0);
        }
        if ($search != '') {
            $this->db->group_start()
                    ->like('LCASE(username)', strtolower($search))
                    ->or_like('LCASE(name)', strtolower($search))
                    ->or_like('LCASE(email)', strtolower($search))
                    ->or_like('LCASE(auth_group)', strtolower($search))
                ->group_end();
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
                ->Get('auth_user')
                ->row_array();
        
        return $data;
    }
    
    /**
     * Get all admin group
     * @return array data
     */
    function GetAdminGroup() {
        if (is_superadmin()) {
            $data = $this->db
                    ->order_by('auth_group','asc')
                    ->Get('auth_group')
                    ->result_array();
        } else {
            $data = $this->db
                    ->where('is_superadmin',0)
                    ->order_by('auth_group','asc')
                    ->Get('auth_group')
                    ->result_array();
        }
        
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
     * check exist email
     * @param string $email
     * @param int $id
     * @return boolean true/false 
     */
    function checkExistsEmail($email,$id=0) {
        if ($id != '' && $id != 0) {
            $this->db->where('id_auth_user !=',$id);
        }
        $this->db->where('LCASE(email)',strtolower($email));
        $query = $this->db->Get('auth_user');
        if ($query->num_rows()>0) {
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
        $this->db->where('username',$username);
        $query = $this->db->Get('auth_user');
        if ($query->num_rows()>0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
}
/* End of file Admin_model.php */
/* Location: ./application/models/Admin_model.php */