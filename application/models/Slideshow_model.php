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
 * 
 * 
 */
class Slideshow_model extends CI_Model
{
    /**
     * Class constructor.
     */
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Get all slideshows.
     * 
     * @return array|bool $data
     */
    function GetSlideshows() 
    {
        $data = $this->db
                ->join('status', 'status.id_status = slideshow.id_status', 'left')
                ->join('slideshow_detail', 'slideshow_detail.id_slideshow = slideshow.id_slideshow', 'left')
                ->join('localization', 'localization.id_localization = slideshow_detail.id_localization', 'left')
                ->where("LCASE({$this->db->dbprefix('status')}.status_text)", "publish")
                ->where('is_delete', 0)
                ->where("LCASE({$this->db->dbprefix('localization')}.iso_1)", $this->lang->get_active_uri_lang())
                ->order_by('position','asc')
                ->order_by('slideshow.id_slideshow', 'desc')
                ->get('slideshow')
                ->result_array();

        return $data;
    }
}
/* End of file Slideshow_model.php */
/* Location: ./application/models/Slideshow_model.php */