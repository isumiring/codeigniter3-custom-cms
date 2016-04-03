<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Slideshow Model Class.
 *
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 *
 * @version 3.0
 *
 * @category Model
 */
class Slideshow_model extends CI_Model
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get localization list.
     *
     * @return array|bool $data
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
     * Get default localization.
     *
     * @return array|bool $data
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
     * Get status.
     *
     * @return array|bool $data
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
     * Get maximum position.
     *
     * @return int $max maximum position
     */
    public function GetMaxPosition()
    {
        $data = $this->db
                ->select_max('position', 'max_pos')
                ->get('slideshow')
                ->row_array();
        $max = (isset($data['max_pos'])) ? $data['max_pos'] + 1 : 1;

        return $max;
    }

    /**
     * Get all data.
     *
     * @param array $param
     *
     * @return array|bool $data
     */
    public function GetAllSlideshowData($param = [])
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
                ->select('*, slideshow.id_slideshow as id')
                ->join('status', 'status.id_status = slideshow.id_status', 'left')
                ->join('slideshow_detail', 'slideshow_detail.id_slideshow = slideshow.id_slideshow', 'left')
                ->join('localization', 'localization.id_localization = slideshow_detail.id_localization', 'left')
                ->where('slideshow.is_delete', 0)
                ->where('localization.locale_status', 1)
                ->get('slideshow')
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
    public function CountAllSlideshow($param = [])
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
                ->from('slideshow')
                ->join('status', 'status.id_status = slideshow.id_status', 'left')
                ->join('slideshow_detail', 'slideshow_detail.id_slideshow = slideshow.id_slideshow', 'left')
                ->join('localization', 'localization.id_localization = slideshow_detail.id_localization', 'left')
                ->where('slideshow.is_delete', 0)
                ->where('localization.locale_status', 1)
                ->count_all_results();

        return $total_records;
    }

    /**
     * Get detail by id.
     *
     * @param int $id
     *
     * @return array|bool $data
     */
    public function GetSlideshow($id)
    {
        $data = $this->db
                ->where('id_slideshow', $id)
                ->where('is_delete', 0)
                ->limit(1)
                ->get('slideshow')
                ->row_array();

        if ($data) {
            $locales = $this->db
                        ->select('id_localization, title, caption')
                        ->where('id_slideshow', $id)
                        ->order_by('id_localization', 'asc')
                        ->get('slideshow_detail')
                        ->result_array();
            foreach ($locales as $row => $local) {
                $data['locales'][$local['id_localization']]['title'] = $local['title'];
                $data['locales'][$local['id_localization']]['caption'] = $local['caption'];
            }
        }

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
        $this->db->insert('slideshow', $param);
        $last_id = $this->db->insert_id();

        return $last_id;
    }

    /**
     * Insert detail record.
     *
     * @param array $param
     */
    public function InsertDetailRecord($param)
    {
        $this->db->insert_batch('slideshow_detail', $param);
    }

    /**
     * Update record.
     *
     * @param int   $id
     * @param array $param
     */
    public function UpdateRecord($id, $param)
    {
        $this->db
            ->where('id_slideshow', $id)
            ->update('slideshow', $param);
    }

    /**
     * Delete record.
     *
     * @param int $id
     */
    public function DeleteRecord($id)
    {
        $this->db
            ->where('id_slideshow', $id)
            ->update('slideshow', ['is_delete' => 1]);
    }

    /**
     * Delete detail record.
     *
     * @param int $id
     */
    public function DeleteDetailRecordByID($id)
    {
        $this->db
            ->where('id_slideshow', $id)
            ->delete('slideshow_detail');
    }
}
/* End of file Slideshow_model.php */
/* Location: ./application/models/Slideshow_model.php */
