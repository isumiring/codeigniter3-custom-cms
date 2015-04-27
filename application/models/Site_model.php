<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Site Model Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Site model
 * 
 */
class Site_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * get all site data
     * @param string $param
     * @return array data
     */
    function GetAllSiteData($param=array()) {
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
                ->select('*,id_site as id')
                ->get('sites')
                ->result_array();
        return $data;
    }
    
    /**
     * count records
     * @param string $param
     * @return int total records
     */
    function CountAllSite($param=array()) {
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
                ->from('sites')
                ->count_all_results();
        return $total_records;
    }
    
    /**
     * Get site detail by id
     * @param int $id
     * @return array data
     */
    function GetSite($id) {
        $data = $this->db
                ->where('id_site',$id)
                ->limit(1)
                ->get('sites')
                ->row_array();
        if ($data) {
            $settings = $this->db
                    ->select('type,value')
                    ->where('id_site',$data['id_site'])
                    ->order_by('type','asc')
                    ->get('setting')
                    ->result_array();
            foreach ($settings as $row => $val) {
                $data['setting'][$val['type']] = $val['value'];
            }
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
/* End of file Site_model.php */
/* Location: ./application/models/Site_model.php */