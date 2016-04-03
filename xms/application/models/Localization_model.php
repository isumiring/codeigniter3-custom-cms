<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Localization Model Class.
 * 
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * 
 * @version 3.0
 * 
 * @category Model
 * 
 */
class Localization_model extends CI_Model
{
    /**
     * Class constructor.
     */
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Get all data.
     * 
     * @param array $param
     * 
     * @return array|bool $data
     */
    function GetAllData($param = []) 
    {
        if (isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i=0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i==0) {
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
                ->select('*, id_localization as id')
                ->get('localization')
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
    function CountAllData($param = []) 
    {
        if (is_array($param) && isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i=0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i==0) {
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
                ->from('localization')
                ->count_all_results();

        return $total_records;
    }
    
    /**
     * Get localization detail.
     * 
     * @param int $id
     * 
     * @return array|bool $data
     */
    function GetLocalization($id) 
    {
        $data = $this->db
                ->where('id_localization', $id)
                ->limit(1)
                ->get('localization')
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
        $this->db->insert('localization', $param);
        $last_id = $this->db->insert_id();

        return $last_id;
    }
    
    /**
     * Update record.
     * 
     * @param int $id
     * @param array $param
     */
    function UpdateRecord($id, $param) 
    {
        $this->db
            ->where('id_localization', $id)
            ->update('localization', $param);
    }
    
    /**
     * Check exists path.
     * 
     * @param string $path
     * @param int $id
     * 
     * @return boolean
     */
    function CheckExistsPath($path, $id = 0) 
    {
        $this->db->where('LCASE(locale_path)', strtolower($path));
        if ($id) {
            $this->db->where('id_localization !=', $id);
        }
        $this->db->from('localization');
        $total = $this->db->count_all_results();
        if ($total > 0) {
            return false;
        }

        return true;
    }
    
    /**
     * Check default status.
     * 
     * @param int $id
     * 
     * @return boolean true/false
     */
    function CheckDefault($id = 0) 
    {
        $this->db->where('locale_status', 1);
        /*if ($id) {
            $this->db->where('id_localization !=',$id);
        }*/
        $this->db->from('localization');
        $total = $this->db->count_all_results();
        if ($total == 1) {
            return true;
        }

        return false;
    }

    /**
     * Update localization status.
     * 
     * @param int $id_localization
     */
    function UpdateDefault($id_localization)
    {
        // update all to standard first
        $this->db->update('localization', ['locale_status' => 0]);

        // and then update the specified data
        $this->db
            ->where('id_localization', $id_localization)
            ->update('localization', ['locale_status' => 1]);
    }

    /**
     * Delete record.
     *
     * @param int $id
     */
    function DeleteRecord($id)
    {
        $this->db
            ->where('id_localization', $id)
            ->delete('localization');
    }
    
}
/* End of file Localization_model.php */
/* Location: ./application/models/Localization_model.php */