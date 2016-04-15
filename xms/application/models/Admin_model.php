<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Admin Model Class.
 *
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 *
 * @version 3.0
 *
 * @category Model
 */
class Admin_model extends CI_Model
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get group data.
     *
     * @return array|bool $data
     */
    public function GetGroups()
    {
        if (!is_superadmin()) {
            $this->db->where('is_superadmin', 0);
        }
        $data = $this->db
                ->order_by('auth_group', 'asc')
                ->get('auth_group')
                ->result_array();

        return $data;
    }

    /**
     * Get all admin data.
     *
     * @param array $param
     *
     * @return array|bool $data
     */
    public function GetAllData($param = [])
    {
        if (!is_superadmin()) {
            $this->db->where('auth_user.is_superadmin', 0);
            $this->db->where('auth_group.is_superadmin', 0);
        }
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
                ->select('auth_user.*, auth_group.auth_group, id_auth_user as id')
                ->join('auth_group', 'auth_group.id_auth_group = auth_user.id_auth_group', 'left')
                ->get('auth_user')
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
        if (!is_superadmin()) {
            $this->db->where('auth_user.is_superadmin', 0);
            $this->db->where('auth_group.is_superadmin', 0);
        }
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
                ->from('auth_user')
                ->join('auth_group', 'auth_group.id_auth_group = auth_user.id_auth_group', 'left')
                ->count_all_results();

        return $total_records;
    }

    /**
     * Get admin user detail by id.
     *
     * @param int $id
     *
     * @return array|bool $data
     */
    public function GetAdmin($id)
    {
        $data = $this->db
                ->where('id_auth_user', $id)
                ->limit(1)
                ->get('auth_user')
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
    public function InsertRecord($param)
    {
        $this->db->insert('auth_user', $param);
        $last_id = $this->db->insert_id();

        return $last_id;
    }

    /**
     * Update record admin user.
     *
     * @param int   $id
     * @param array $param
     */
    public function UpdateRecord($id, $param)
    {
        $this->db
            ->where('id_auth_user', $id)
            ->update('auth_user', $param);
    }

    /**
     * Delete record.
     *
     * @param int $id
     */
    public function DeleteRecord($id)
    {
        $this->db
            ->where('id_auth_user', $id)
            ->delete('auth_user');
    }

    /**
     * Check exist email.
     *
     * @param string $email
     * @param int    $id
     *
     * @return bool true/false
     */
    public function checkExistsEmail($email, $id = 0)
    {
        if ($id != '' && $id != 0) {
            $this->db->where('id_auth_user !=', $id);
        }
        $count_records = $this->db
                ->from('auth_user')
                ->where('LCASE(email)', strtolower($email))
                ->count_all_results();
        if ($count_records > 0) {
            return false;
        }

        return true;
    }

    /**
     * Check exist username.
     *
     * @param string $username
     * @param int    $id
     *
     * @return bool true/false
     */
    public function checkExistsUsername($username, $id = 0)
    {
        if ($id != '' && $id != 0) {
            $this->db->where('id_auth_user !=', $id);
        }
        $count_records = $this->db
                ->from('auth_user')
                ->where('username', $username)
                ->count_all_results();
        if ($count_records > 0) {
            return false;
        }

        return true;
    }
}
/* End of file Admin_model.php */
/* Location: ./application/models/Admin_model.php */
