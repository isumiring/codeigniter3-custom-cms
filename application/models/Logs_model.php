<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Logs Model Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Logs model
 * 
 */
class Logs_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * get all data and filter
     * @param array $param
     * @return array data
     */
    function GetAllLogsData($param=array()) {
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
                ->select('*,logs.create_date as created,id_logs as id')
                ->join('auth_user','auth_user.id_auth_user=logs.id_user','left')
                ->join('auth_group','auth_group.id_auth_group=logs.id_group','left')
                ->get('logs')
                ->result_array();
        return $data;
    }
    
    /**
     * count records
     * @param array $param
     * @return int total records
     */
    function CountAllLogs($param=array()) {
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
        $total_records = $this->db
                ->from('logs')
                ->join('auth_user','auth_user.id_auth_user=logs.id_user','left')
                ->join('auth_group','auth_group.id_auth_group=logs.id_group','left')
                ->count_all_results();
        return $total_records;
    }
    
    /**
     * delete record
     * @param mixed $ids array or int of id
     */
    function DeleteRecords($ids) {
        if (is_array($ids)) {
            $this->db->where_in('id_logs',$ids);
        } else {
            $this->db->where('id_logs',$ids);
        }
        $this->db->delete('logs');
    }
}
/* End of file Logs_model.php */
/* Location: ./application/models/Logs_model.php */