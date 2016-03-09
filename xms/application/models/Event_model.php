<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Event Model Class.
 *
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 *
 * @version 3.0
 *
 * @category Model
 * @desc Event model
 */
class Event_model extends CI_Model
{
    /**
     * constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * get localization list.
     *
     * @return array data
     */
    public function GetLocalization()
    {
        $data = $this->db
                ->order_by('locale_status', 'desc')
                ->order_by('id_localization', 'asc')
                ->get('localization')
                ->result_array();

        return $data;
    }

    /**
     * get default localization.
     *
     * @return array data
     */
    public function GetDefaultLocalization()
    {
        $data = $this->db
                ->where('locale_status', 1)
                ->limit(1)
                ->get('localization')
                ->row_array();

        return $data;
    }

    /**
     * get status.
     *
     * @return array data
     */
    public function GetStatus()
    {
        $data = $this->db
                ->order_by('id_status', 'asc')
                ->get('status')
                ->result_array();

        return $data;
    }

    /**
     * get all data.
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
                ->select('*,event.id_event as id')
                ->join('event_detail', 'event_detail.id_event=event.id_event', 'left')
                ->join('localization', 'localization.id_localization=event_detail.id_localization', 'left')
                ->join('status', 'status.id_status=event.id_status', 'left')
                ->where('localization.locale_status', 1)
                ->where('event.is_delete', 0)
                ->get('event')
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
                ->from('event')
                ->join('event_detail', 'event_detail.id_event=event.id_event', 'left')
                ->join('localization', 'localization.id_localization=event_detail.id_localization', 'left')
                ->join('status', 'status.id_status=event.id_status', 'left')
                ->where('localization.locale_status', 1)
                ->where('event.is_delete', 0)
                ->count_all_results();

        return $total_records;
    }

    /**
     * Get detail by id.
     *
     * @param int $id
     *
     * @return array data
     */
    public function GetEvent($id)
    {
        $data = $this->db
                ->where('id_event', $id)
                ->limit(1)
                ->get('event')
                ->row_array();
        if ($data) {
            $locales = $this->db
                        ->select('id_localization,title,teaser,description')
                        ->where('id_event', $id)
                        ->order_by('id_localization', 'asc')
                        ->get('event_detail')
                        ->result_array();
            foreach ($locales as $row => $local) {
                $data['locales'][$local['id_localization']]['title'] = $local['title'];
                $data['locales'][$local['id_localization']]['teaser'] = $local['teaser'];
                $data['locales'][$local['id_localization']]['description'] = $local['description'];
            }
        }

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
        $this->db->insert('event', $param);
        $last_id = $this->db->insert_id();

        return $last_id;
    }

    /**
     * update record.
     *
     * @param int   $id
     * @param array $param
     */
    public function UpdateRecord($id, $param)
    {
        $this->db->where('id_event', $id);
        $this->db->update('event', $param);
    }

    /**
     * delete record.
     *
     * @param int $id
     */
    public function DeleteRecord($id)
    {
        $this->db->where('id_event', $id);
        $this->db->update('event', ['is_delete' => 1]);
    }

    /**
     * insert detail.
     *
     * @param array $param
     */
    public function InsertDetailRecord($param)
    {
        $this->db->insert_batch('event_detail', $param);
    }

    /**
     * delete detail record.
     *
     * @param int $id
     */
    public function DeleteDetailRecordByID($id)
    {
        $this->db->where('id_event', $id);
        $this->db->delete('event_detail');
    }
}
/* End of file Event_model.php */
/* Location: ./application/models/Event_model.php */
