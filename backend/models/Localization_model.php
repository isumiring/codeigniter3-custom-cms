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
class Localization_model extends FAT_Model
{
    /**
     * The database table used by the model
     * 
     * @var string
     */
    protected $table = 'localization';

    /**
     * Primary key of the table
     * 
     * @var string
     */
    protected $primaryKey = 'id_localization';
    
    /**
     * Class constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get Table Value.
     * 
     * @param string $key
     * 
     * @return string table value.
     */
    public function GetIdentifier($key)
    {
        return $this->{$key};
    }

    /**
     * Set Table Value.
     * 
     * @param string $key
     * @param string $value
     * 
     * @return object|array|string $this
     */
    public function SetIdentifier($key, $value)
    {
        $this->{$key} = $value;

        return $this;
    }
    
    /**
     * Get all data.
     * 
     * @param array $param
     * 
     * @return array|bool $data
     */
    public function GetAllData($param = []) 
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
                ->select('*, '.$this->primaryKey.' as id')
                ->get($this->table)
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
    public function CountAllData($param = []) 
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
                ->from($this->table)
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
    public function GetLocalization($id) 
    {
        $data = $this->db
                ->where($this->primaryKey, $id)
                ->limit(1)
                ->get($this->table)
                ->row_array();
        
        return $data;
    }
    
    /**
     * Check default status.
     * 
     * @param int $id
     * 
     * @return boolean true/false
     */
    public function CheckDefault($id = 0) 
    {
        $this->db->where('locale_status', 1);
        /*if ($id) {
            $this->db->where('id_localization !=',$id);
        }*/
        $this->db->from($this->table);
        $total = $this->db->count_all_results();
        if ($total > 0) {
            return true;
        }

        return false;
    }

    /**
     * Update localization status.
     * 
     * @param int $id_localization
     */
    public function UpdateDefault($id_localization)
    {
        // update all to standard first
        $this->db->update($this->table, ['locale_status' => 0]);

        // and then update the specified data
        $this->db
            ->where($this->primaryKey, $id_localization)
            ->update($this->table, ['locale_status' => 1]);
    }
    
}
/* End of file Localization_model.php */
/* Location: ./application/models/Localization_model.php */