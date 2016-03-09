<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Pages Model Class.
 *
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 *
 * @version 3.0
 *
 * @category Model
 * @desc Pages model
 */
class Pages_model extends CI_Model
{
    /**
     * constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * get menu title.
     *
     * @param string $uri
     *
     * @return string title of the page
     */
    public function GetMenuTitleByURI($uri = '')
    {
        if (!empty($uri)) {
            $uri_explode = explode('/', $uri);
            $lang = $uri_explode[0];
            $data['title'] = '';
            if (strtolower($uri_explode[1]) == 'pages') {
                $data = $this->db
                    ->select('pages_detail.title')
                    ->join('pages_detail', 'pages_detail.id_page=pages.id_page', 'left')
                    ->join('localization', 'localization.id_localization=pages_detail.id_localization', 'left')
                    ->where('is_delete', 0)
                    ->where("LCASE({$this->db->dbprefix('uri_path')})", strtolower($uri_explode[2]))
                    ->where("LCASE({$this->db->dbprefix('localization')}.iso_1)", $lang)
                    ->limit(1)
                    ->get('pages')
                    ->row_array();
            } else {
                $data = $this->db
                    ->select('pages_detail.title')
                    ->join('pages_detail', 'pages_detail.id_page=pages.id_page', 'left')
                    ->join('localization', 'localization.id_localization=pages_detail.id_localization', 'left')
                    ->where('is_delete', 0)
                    ->where("LCASE({$this->db->dbprefix('module')})", strtolower($uri_explode[1]))
                    ->where("LCASE({$this->db->dbprefix('localization')}.iso_1)", $lang)
                    ->limit(1)
                    ->get('pages')
                    ->row_array();
            }

            return $data['title'];
        } else {
            return '';
        }
    }

    /**
     * get page info by ID.
     *
     * @param int $id_page
     *
     * @return array $data
     */
    public function GetPageByID($id_page)
    {
        $data = $this->db
                ->join('status', 'status.id_status=pages.id_status', 'left')
                ->join('pages_detail', 'pages_detail.id_page=pages.id_page', 'left')
                ->join('localization', 'localization.id_localization=pages_detail.id_localization', 'left')
                ->where("LCASE({$this->db->dbprefix('status')}.status_text)", 'publish')
                ->where('is_delete', 0)
                ->where('pages.id_page', $id_page)
                ->where("LCASE({$this->db->dbprefix('localization')}.iso_1)", $this->lang->get_active_uri_lang())
                ->limit(1)
                ->get('pages')
                ->row_array();

        return $data;
    }

    /**
     * get pages by uri.
     *
     * @param string $uri
     *
     * @return array/mixed $data or boolean
     */
    public function GetPageByURI($uri = '')
    {
        if ($uri) {
            $data = $this->db
                    ->join('status', 'status.id_status=pages.id_status', 'left')
                    ->join('pages_detail', 'pages_detail.id_page=pages.id_page', 'left')
                    ->join('localization', 'localization.id_localization=pages_detail.id_localization', 'left')
                    ->where("LCASE({$this->db->dbprefix('status')}.status_text)", 'publish')
                    ->where('is_delete', 0)
                    ->where("LCASE({$this->db->dbprefix('uri_path')})", strtolower($uri))
                    ->where("LCASE({$this->db->dbprefix('localization')}.iso_1)", $this->lang->get_active_uri_lang())
                    ->limit(1)
                    ->get('pages')
                    ->row_array();

            return $data;
        } else {
            return false;
        }
    }

    /**
     * get page by parent.
     *
     * @param int $parent_id
     *
     * @return array $data
     */
    public function GetPageByParent($parent_id)
    {
        $data = $this->db
                ->join('status', 'status.id_status=pages.id_status', 'left')
                ->join('pages_detail', 'pages_detail.id_page=pages.id_page', 'left')
                ->join('localization', 'localization.id_localization=pages_detail.id_localization', 'left')
                ->where("LCASE({$this->db->dbprefix('status')}.status_text)", 'publish')
                ->where('is_delete', 0)
                ->where('page_type', 1)
                ->where('parent_page', $parent_id)
                ->where("LCASE({$this->db->dbprefix('localization')}.iso_1)", $this->lang->get_active_uri_lang())
                ->get('pages')
                ->result_array();

        return $data;
    }

    /**
     * get info by module.
     *
     * @param string $module
     *
     * @return array $data
     */
    public function GetPageInfoByModule($module)
    {
        $data = $this->db
                ->join('status', 'status.id_status=pages.id_status', 'left')
                ->join('pages_detail', 'pages_detail.id_page=pages.id_page', 'left')
                ->join('localization', 'localization.id_localization=pages_detail.id_localization', 'left')
                ->where("LCASE({$this->db->dbprefix('status')}.status_text)", 'publish')
                ->where('is_delete', 0)
                ->where("LCASE({$this->db->dbprefix('module')})", strtolower($module))
                ->where("LCASE({$this->db->dbprefix('localization')}.iso_1)", $this->lang->get_active_uri_lang())
                ->limit(1)
                ->get('pages')
                ->row_array();

        return $data;
    }
}
/* End of file Pages_model.php */
/* Location: ./application/models/Pages_model.php */
