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
 * @desc Localization model
 */
class Localization_model extends CI_Model
{
    /**
     * constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * get all admin data.
     *
     * @param string $param
     *
     * @return array data
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
                ->select('*,id_localization as id')
                ->get('localization')
                ->result_array();

        return $data;
    }

    /**
     * count records.
     *
     * @param string $param
     *
     * @return int total records
     */
    public function CountAllData($param = [])
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
                ->from('localization')
                ->count_all_results();

        return $total_records;
    }

    /**
     * get locale list.
     *
     * @return array data
     */
    public function GetLocale()
    {
        $data = $this->db
                ->order_by('locale_status', 'desc')
                ->order_by('id_localization', 'asc')
                ->get('localization')
                ->result_array();

        return $data;
    }

    /**
     * Get localization detail.
     *
     * @param int $id
     *
     * @return array data
     */
    public function GetLocalization($id)
    {
        $data = $this->db
                ->where('id_localization', $id)
                ->limit(1)
                ->get('localization')
                ->row_array();

        return $data;
    }

    /**
     * insert new record.
     *
     * @param array $param
     *
     * @return int last inserted id
     */
    public function InsertRecord($param)
    {
        $this->db->insert('localization', $param);
        $last_id = $this->db->insert_id();

        return $last_id;
    }

    /**
     * update record admin user.
     *
     * @param int   $id
     * @param array $param
     */
    public function UpdateRecord($id, $param)
    {
        $this->db->where('id_localization', $id);
        $this->db->update('localization', $param);
    }

    /**
     * check exists path.
     *
     * @param string $path
     * @param int    $id
     *
     * @return bool
     */
    public function CheckExistsPath($path, $id = 0)
    {
        $this->db->where('LCASE(locale_path)', strtolower($path));
        if ($id) {
            $this->db->where('id_localization !=', $id);
        }
        $this->db->from('localization');
        $total = $this->db->count_all_results();
        if ($total > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * check default status.
     *
     * @param int $id
     *
     * @return bool true/false
     */
    public function CheckDefault($id = 0)
    {
        $this->db->where('locale_status', 1);
        /*if ($id) {
            $this->db->where('id_localization !=',$id);
        }*/
        $this->db->from('localization');
        $total = $this->db->count_all_results();
        if ($total == 1) {
            return true;
        } else {
            return false;
        }
    }
}
/* End of file Localization_model.php */
/* Location: ./application/models/Localization_model.php */
