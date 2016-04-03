<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Article Model Class.
 *
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 *
 * @version 3.0
 *
 * @category Model
 */
class Article_model extends CI_Model
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
     * Get categories.
     *
     * @return array|bool $data
     */
    public function GetCategories()
    {
        $data = $this->db
                ->select('article_category.id_article_category as id_category, article_category_detail.title')
                ->join('article_category_detail', 'article_category_detail.id_article_category = article_category.id_article_category', 'left')
                ->join('localization', 'localization.id_localization = article_category_detail.id_localization', 'left')
                ->where('localization.locale_status', 1)
                ->order_by('article_category_detail.title', 'asc')
                ->get('article_category')
                ->result_array();

        return $data;
    }

    /**
     * Get All Data.
     *
     * @param array $param
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
                ->select('*, article.id_article as id')
                ->join('article_detail', 'article_detail.id_article = article.id_article', 'left')
                ->join('localization', 'localization.id_localization = article_detail.id_localization', 'left')
                ->join('status', 'status.id_status = article.id_status', 'left')
                ->join(
                    "(
                        SELECT {$this->db->dbprefix('article_category')}.id_article_category, title as category_title 
                        FROM {$this->db->dbprefix('article_category')}
                        LEFT JOIN {$this->db->dbprefix('article_category_detail')} ON {$this->db->dbprefix('article_category_detail')}.id_article_category = {$this->db->dbprefix('article_category')}.id_article_category
                        LEFT JOIN {$this->db->dbprefix('localization')} ON {$this->db->dbprefix('localization')}.id_localization = {$this->db->dbprefix('article_category_detail')}.id_localization
                        WHERE {$this->db->dbprefix('localization')}.locale_status = 1
                    ) AS {$this->db->dbprefix('article_category')}",
                    'article_category.id_article_category = article.id_article_category',
                    'left'
                )
                ->where('localization.locale_status', 1)
                ->where('article.is_delete', 0)
                ->get('article')
                ->result_array();

        return $data;
    }

    /**
     * Count Records.
     *
     * @param array $param
     *
     * @return array|bool $data
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
                ->from('article')
                ->join('article_detail', 'article_detail.id_article = article.id_article', 'left')
                ->join('localization', 'localization.id_localization = article_detail.id_localization', 'left')
                ->join('status', 'status.id_status = article.id_status', 'left')
                ->join(
                    "(
                        SELECT {$this->db->dbprefix('article_category')}.id_article_category, title as category_title 
                        FROM {$this->db->dbprefix('article_category')}
                        LEFT JOIN {$this->db->dbprefix('article_category_detail')} ON {$this->db->dbprefix('article_category_detail')}.id_article_category = {$this->db->dbprefix('article_category')}.id_article_category
                        LEFT JOIN {$this->db->dbprefix('localization')} ON {$this->db->dbprefix('localization')}.id_localization = {$this->db->dbprefix('article_category_detail')}.id_localization
                        WHERE {$this->db->dbprefix('localization')}.locale_status = 1
                    ) AS {$this->db->dbprefix('article_category')}",
                    'article_category.id_article_category = article.id_article_category',
                    'left'
                )
                ->where('localization.locale_status', 1)
                ->where('article.is_delete', 0)
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
    public function GetArticle($id)
    {
        $data = $this->db
                ->where('id_article', $id)
                ->limit(1)
                ->get('article')
                ->row_array();

        if ($data) {
            $locales = $this->db
                        ->select('id_localization, title, teaser, description')
                        ->where('id_article', $id)
                        ->order_by('id_localization', 'asc')
                        ->get('article_detail')
                        ->result_array();
            foreach ($locales as $key => $local) {
                $data['locales'][$local['id_localization']]['title'] = $local['title'];
                $data['locales'][$local['id_localization']]['teaser'] = $local['teaser'];
                $data['locales'][$local['id_localization']]['description'] = $local['description'];
            }
        }

        return $data;
    }

    /**
     * Insert New Record.
     *
     * @param array $param
     *
     * @return int $last_id last inserted id
     */
    public function InsertRecord($param)
    {
        $this->db->insert('article', $param);
        $last_id = $this->db->insert_id();

        return $last_id;
    }

    /**
     * Update Record.
     *
     * @param int   $id
     * @param array $param
     */
    public function UpdateRecord($id, $param)
    {
        $this->db
            ->where('id_article', $id)
            ->update('article', $param);
    }

    /**
     * Delete Record.
     *
     * @param int $id
     */
    public function DeleteRecord($id)
    {
        $this->db
            ->where('id_article', $id)
            ->update('article', ['is_delete' => 1]);
    }

    /**
     * Insert Detail.
     *
     * @param array $param
     */
    public function InsertDetailRecord($param)
    {
        $this->db->insert_batch('article_detail', $param);
    }

    /**
     * Delete Detail Record.
     *
     * @param int $id
     */
    public function DeleteDetailRecordByID($id)
    {
        $this->db
            ->where('id_article', $id)
            ->delete('article_detail');
    }
}
/* End of file Article_model.php */
/* Location: ./application/models/Article_model.php */
