<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Site Model Class.
 *
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 *
 * @version 3.0
 *
 * @category Model
 * 
 */
class Site_model extends FAT_Model
{
    /**
     * The database table used by the model
     * 
     * @var string
     */
    protected $table = 'site';

    /**
     * Primary key of the table
     * 
     * @var string
     */
    protected $primaryKey = 'id_site';

    /**
     * The database foreign table used by the model
     * 
     * @var string
     */
    protected $foreign_table_setting = 'site_setting';

    /**
     * Foreign key of the main table
     * 
     * @var string
     */
    protected $foreign_key_setting = 'id_site_setting';

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
     * @param string $param
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
                ->select('*, '. $this->primaryKey. ' as id')
                ->where('is_delete', 0)
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
    public function CountAll($param = [])
    {
        if (is_array($param) && isset($param['search_value']) && $param['search_value'] != '') {
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
                ->where('is_delete', 0)
                ->from($this->table)
                ->count_all_results();

        return $total_records;
    }

    /**
     * Get site detail by id.
     *
     * @param int $id
     *
     * @return array|bool $data
     */
    public function GetSite($id)
    {
        $data = $this->db
                ->select('*')
                ->select("{$this->primaryKey} as id")
                ->where($this->primaryKey, $id)
                ->limit(1)
                ->get($this->table)
                ->row_array();

        if ($data) {
            $settings = $this->db
                    ->select('type, value')
                    ->where($this->primaryKey, $data[$this->primaryKey])
                    ->order_by('type', 'asc')
                    ->get($this->foreign_table_setting)
                    ->result_array();

            foreach ($settings as $row => $val) {
                $data['setting'][$val['type']] = $val['value'];
            }
        }

        return $data;
    }
}
/* End of file Site_model.php */
/* Location: ./application/models/Site_model.php */
