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
 * @desc Slideshow model
 */
class Slideshow_model extends CI_Model
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
     * get maximum position.
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
     * get all data.
     *
     * @param string $param
     *
     * @return array data
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
                ->select('*,slideshow.id_slideshow as id')
                ->join('status', 'status.id_status=slideshow.id_status')
                ->join('slideshow_detail', 'slideshow_detail.id_slideshow=slideshow.id_slideshow')
                ->join('localization', 'localization.id_localization=slideshow_detail.id_localization')
                ->where('slideshow.is_delete', 0)
                ->where('localization.locale_status', 1)
                ->get('slideshow')
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
                ->join('status', 'status.id_status=slideshow.id_status')
                ->join('slideshow_detail', 'slideshow_detail.id_slideshow=slideshow.id_slideshow')
                ->join('localization', 'localization.id_localization=slideshow_detail.id_localization')
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
     * @return array data
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
                        ->select('id_localization,title,caption')
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
     * insert new record.
     *
     * @param array $param
     *
     * @return int last inserted id
     */
    public function InsertRecord($param)
    {
        $this->db->insert('slideshow', $param);
        $last_id = $this->db->insert_id();

        return $last_id;
    }

    /**
     * insert detail record.
     *
     * @param array $param
     */
    public function InsertDetailRecord($param)
    {
        $this->db->insert_batch('slideshow_detail', $param);
    }

    /**
     * update record.
     *
     * @param int   $id
     * @param array $param
     */
    public function UpdateRecord($id, $param)
    {
        $this->db->where('id_slideshow', $id);
        $this->db->update('slideshow', $param);
    }

    /**
     * delete record.
     *
     * @param int $id
     */
    public function DeleteRecord($id)
    {
        $this->db->where('id_slideshow', $id);
        $this->db->update('slideshow', ['is_delete' => 1]);
    }

    /**
     * delete detail record.
     *
     * @param int $id
     */
    public function DeleteDetailRecordByID($id)
    {
        $this->db->where('id_slideshow', $id);
        $this->db->delete('slideshow_detail');
    }
}
/* End of file Slideshow_model.php */
/* Location: ./application/models/Slideshow_model.php */
