<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Logs Model Class.
 *
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 *
 * @version 3.0
 *
 * @category Model
 */
class Logs_model extends FAT_Model
{
    /**
     * The database table used by the model
     * 
     * @var string
     */
    protected $table = 'xms_log';

    /**
     * Primary key of the table
     * 
     * @var string
     */
    protected $primaryKey = 'id_log';

    /**
     * The database foreign table used by the model
     * 
     * @var string
     */
    protected $foreign_table_auth_user = 'auth_user';

    /**
     * Foreign key of the main table
     * 
     * @var string
     */
    protected $foreign_key_auth_user = 'id_auth_user';

    /**
     * The database foreign table used by the model
     * 
     * @var string
     */
    protected $foreign_table_auth_group = 'auth_group';

    /**
     * Foreign key of the main table
     * 
     * @var string
     */
    protected $foreign_key_auth_group = 'id_auth_group';

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
     * Get all data and filter.
     *
     * @param array $param
     *
     * @return array|bool $data
     */
    public function GetAllData($param = [])
    {
        if (isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i = 0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i == 0) {
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
                ->select('*, '.$this->table.'.create_date as created, '.$this->primaryKey.' as id')
                ->join($this->foreign_table_auth_user, $this->foreign_table_auth_user. '.'. $this->foreign_key_auth_user. ' = '. $this->table. '.'. $this->foreign_key_auth_user, 'left')
                ->join($this->foreign_table_auth_group, $this->foreign_table_auth_group. '.'. $this->foreign_key_auth_group. ' = '. $this->table. '.'. $this->foreign_key_auth_group, 'left')
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
        if (isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i = 0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i == 0) {
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
                ->join($this->foreign_table_auth_user, $this->foreign_table_auth_user. '.'. $this->foreign_key_auth_user. ' = '. $this->table. '.'. $this->foreign_key_auth_user, 'left')
                ->join($this->foreign_table_auth_group, $this->foreign_table_auth_group. '.'. $this->foreign_key_auth_group. ' = '. $this->table. '.'. $this->foreign_key_auth_group, 'left')
                ->count_all_results();

        return $total_records;
    }
}
/* End of file Logs_model.php */
/* Location: ./application/models/Logs_model.php */
