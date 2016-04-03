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
 */
class Site_model extends CI_Model
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all site data.
     *
     * @param string $param
     *
     * @return array|bool $data
     */
    public function GetAllSiteData($param = [])
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
                ->select('*, id_site as id')
                ->where('is_delete', 0)
                ->get('sites')
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
    public function CountAllSite($param = [])
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
                ->from('sites')
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
                ->where('id_site', $id)
                ->limit(1)
                ->get('sites')
                ->row_array();

        if ($data) {
            $settings = $this->db
                    ->select('type, value')
                    ->where('id_site', $data['id_site'])
                    ->order_by('type', 'asc')
                    ->get('setting')
                    ->result_array();

            foreach ($settings as $row => $val) {
                $data['setting'][$val['type']] = $val['value'];
            }
        }

        return $data;
    }

    /**
     * Insert record data.
     *
     * @param array $param
     *
     * @return int $last_id last inserted id
     */
    public function InsertRecord($param)
    {
        $this->db->insert('sites', $param);
        $last_id = $this->db->insert_id();

        return $last_id;
    }

    /**
     * Update record data.
     *
     * @param int   $id
     * @param array $param
     */
    public function UpdateRecord($id, $param)
    {
        $this->db
            ->where('id_site', $id)
            ->update('sites', $param);
    }

    /**
     * Update setting data.
     *
     * @param int   $id_site
     * @param array $param
     */
    public function UpdateSettingData($id_site, $param)
    {
        // delete setting before update
        $this->db
            ->where('id_site', $id_site)
            ->delete('setting');
        $ins = [];
        foreach ($param as $setting => $val) {
            $ins[] = [
                'id_site' => $id_site,
                'type'    => $setting,
                'value'   => $val,
            ];
        }
        // now we update the setting
        if (count($ins) > 0) {
            $this->db->insert_batch('setting', $ins);
        }
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

    /**
     * Delete record.
     *
     * @param int $id
     */
    public function DeleteRecord($id)
    {
        $this->db
            ->where('id_site', $id)
            ->update('sites', ['is_delete' => 1]);
    }
}
/* End of file Site_model.php */
/* Location: ./application/models/Site_model.php */
