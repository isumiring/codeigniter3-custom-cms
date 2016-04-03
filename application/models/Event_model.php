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
 * 
 */
class Event_model extends CI_Model
{
    /**
     * Current Date.
     * 
     * @var string
     */
    protected $date_now;

    /**
     * Current Date Time.
     * 
     * @var string
     */
    protected $date_time_now;

    /**
     * Class constructor.
     */
    function __construct() 
    {
        parent::__construct();
        $this->date_now      = date('Y-m-d');
        $this->date_time_now = date('Y-m-d H:i:s');
    }
    
    /**
     * Count total records.
     * 
     * @param array $param
     * 
     * @return int $total_records total records
     */
    function CountEvents($param = []) 
    {
        if (isset($param['conditions'])) {
            foreach ($param['conditions'] as $key => $val) {
                if (ctype_digit($val)) {
                    $this->db->where($key, $val);
                } else {
                    $this->db->where("LCASE({$key})", strtolower($val));
                }
            }
        }
        $total_records = $this->db
                ->from('event')
                ->join('status', 'status.id_status = event.id_status', 'left')
                ->where('event.is_delete', 0)
                ->where('publish_date <=', $this->date_now)
                ->where("LCASE({$this->db->dbprefix('status')}.status_text)", "publish")
                ->count_all_results();

        return $total_records;
    }
    
    /**
     * Get events.
     * 
     * @param array $param
     * 
     * @return array|bool $data
     */
    function GetEvents($param = []) 
    {
        if (isset($param['conditions'])) {
            foreach ($param['conditions'] as $key => $val) {
                if (ctype_digit($val)) {
                    $this->db->where($key, $val);
                } else {
                    $this->db->where("LCASE({$key})", strtolower($val));
                }
            }
        }
        $from = 0;
        $per_page = SHOW_RECORDS_DEFAULT;
        if (isset($param['limit'])) {
            if (isset($param['limit']['from'])) {
                $from = $param['limit']['from'];
            }
            if (isset($param['limit']['to'])) {
                $per_page = $param['limit']['to'];
            }
        }
        if (isset($param['order'])) {
            $sort    = 'desc';
            $sort_by = 'id_event';
            if (isset($param['order']['field'])) {
                $sort_by = $param['order']['field'];
            }
            if (isset($param['order']['sort'])) {
                $sort = $param['order']['sort'];
            }
            $this->db->order_by($sort_by, $sort);
        }

        $this->db->limit($per_page, $from);

        $data = $this->db
                ->select('event.*, event_detail.*')
                ->join('status', 'status.id_status = event.id_status', 'left')
                ->join('event_detail', 'event_detail.id_event = event.id_event', 'left')
                ->join('localization', 'localization.id_localization = event_detail.id_localization', 'left')
                ->where('event.is_delete', 0)
                ->where('publish_date <=', $this->date_now)
                ->where("LCASE({$this->db->dbprefix('status')}.status_text)", "publish")
                ->where("LCASE({$this->db->dbprefix('localization')}.iso_1)", $this->lang->get_active_uri_lang())
                ->order_by('publish_date', 'desc')
                ->order_by('event.id_event', 'desc')
                ->get('event')
                ->result_array();

        return $data;
    }
    
    /**
     * Get event info by URI.
     * 
     * @param string $uri_path
     * 
     * @return array|bool $data
     */
    function GetEventByURI($uri_path = '') 
    {
        if ( ! $uri_path) {
            return false;
        }
        $data = $this->db
                ->join('status', 'status.id_status = event.id_status', 'left')
                ->join('event_detail', 'event_detail.id_event = event.id_event', 'left')
                ->join('localization', 'localization.id_localization = event_detail.id_localization', 'left')
                ->where('is_delete', 0)
                ->where('publish_date <=', $this->date_now)
                ->where("(expire_date >= '{$this->date_now}' OR expire_date IS NULL || expire_date = '0000-00-00')")
                ->where("LCASE({$this->db->dbprefix('event')}.uri_path)", strtolower($uri_path))
                ->where("LCASE({$this->db->dbprefix('status')}.status_text)", "publish")
                ->where("LCASE({$this->db->dbprefix('localization')}.iso_1)", $this->lang->get_active_uri_lang())
                ->order_by('event.id_event', 'desc')
                ->limit(1)
                ->get('event')
                ->row_array();

        return $data;
    }
}
/* End of file Event_model.php */
/* Event: ./application/models/Event_model.php */