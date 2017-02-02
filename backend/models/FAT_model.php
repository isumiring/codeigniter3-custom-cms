<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * FAT Model Class.
 *
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 *
 * @version 3.0
 *
 * @category Model
 */
class FAT_Model extends CI_Model
{

    /**
     * Class constructor.
     * 
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Insert to log.
     * 
     * @param [type] $data [description]
     */
    public function InsertLog($action = '', $desc = '')
    {
        $data = [
            'id_auth_user'  => id_auth_user(),
            'id_auth_group' => id_auth_group(),
            'action'        => $action,
            'desc'          => $desc,
            'ip_address'    => get_client_ip(),
        ];
        $this->InsertData('xms_log', $data);
    }

    /**
     * Insert data and return last inserted id.
     * 
     * @param string $table
     * @param array $data
     *
     * @return int last inserted id
     */
    public function InsertData($table, $data)
    {
        $this->db
            ->insert($table, $data);

        return $this->db->insert_id();
    }

    /**
     * Update Data.
     * 
     * @param string   $table
     * @param array    $conditions
     * @param array    $data
     *
     * @return integer|bool affected rows
     */
    public function UpdateData($table, $conditions, $data)
    {
        foreach ($conditions as $key => $value) {
            $this->db->where($key, $value);
        }
        $this->db->update($table, $data);

        return $this->db->affected_rows();
    }

    /**
     * Delete Data.
     * 
     * @param string   $table
     * @param array    $conditions
     *
     * @return integer|bool affected rows
     */
    public function DeleteData($table, $conditions = [])
    {
        foreach ($conditions as $key => $value) {
            $this->db->where($key, $value);
        }
        $this->db->delete($table);

        return $this->db->affected_rows();
    }

    /**
     * Insert Data Batch.
     * 
     * @param string $table
     * @param array  $data
     *
     * @return int affected rows
     */
    public function InsertBatchData($table, $data) 
    {
        $this->db->insert_batch($table, $data);

        return $this->db->affected_rows();
    }

    /**
     * Get maximum value of the table.
     * 
     * @param string   $table
     * @param string   $field
     * @param array    $conditions
     *
     * @return int $return
     */
    public function GetMaximumValue($table, $field = 'position', $conditions = [])
    {
        $return = '0';
        if (isset($conditions) && count($conditions) > 0) {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $data = $this->db
                ->select_max($field, 'max_value')
                ->get($table)
                ->row_array();

        if ($data) {
            $return = $data['max_value'];
        }

        return $return;
    }
}

/* End of file FAT_Model.php */
/* Location: ./application/hooks/FAT_Model.php */
