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
     * @return array data
     */
    function GetAllLogs($search,$order_by=array(),$start=0,$perpage=0) {
        if ($search != '') {
            $this->db
                ->group_start()
                    ->like('LCASE(username)', strtolower($search))
                    ->or_like('LCASE(name)', strtolower($search))
                    ->or_like('LCASE(email)', strtolower($search))
                    ->or_like('LCASE(auth_group)', strtolower($search))
                    ->or_like('LCASE(action)', strtolower($search))
                    ->or_like('LCASE(desc)', strtolower($search))
                ->group_end();
        }
        if ($perpage) {
            $this->db->limit($perpage,$start);
        }
        if (is_array($order_by)) {
            $this->db->order_by($order_by['by'],$order_by['sort']);
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
     * @param string $search
     * @return int total records
     */
    function CountAllLogs($search='') {
        if ($search != '') {
            $this->db->group_start()
                    ->like('LCASE(username)', strtolower($search))
                    ->or_like('LCASE(name)', strtolower($search))
                    ->or_like('LCASE(email)', strtolower($search))
                    ->or_like('LCASE(auth_group)', strtolower($search))
                    ->or_like('LCASE(action)', strtolower($search))
                    ->or_like('LCASE(desc)', strtolower($search))
                ->group_end();
        }
        $total_records = $this->db
                ->from('logs')
                ->join('auth_user','auth_user.id_auth_user=logs.id_user','left')
                ->join('auth_group','auth_group.id_auth_group=logs.id_group','left')
                ->count_all_results();
        return $total_records;
    }
}
/* End of file Logs_model.php */
/* Location: ./application/models/Logs_model.php */