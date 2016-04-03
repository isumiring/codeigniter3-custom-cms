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
 * 
 */
class Article_model extends CI_Model
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
     * Get categories.
     * 
     * @return array|bool $data
     */
    function GetCategories() 
    {
        $data = $this->db
                ->join('article_category_detail', 'article_category_detail.id_article_category = article_category.id_article_category', 'left')
                ->join('localization', 'localization.id_localization = article_category_detail.id_localization', 'left')
                ->where("LCASE({$this->db->dbprefix('localization')}.iso_1)", $this->lang->get_active_uri_lang())
                ->group_by('article_category.id_article_category')
                ->get('article_category')
                ->result_array();
        
        return $data;
    }
    
    /**
     * Count total records.
     * 
     * @param array $param
     * 
     * @return int $total_records total records
     */
    function CountArticles($param = []) 
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
                ->from('article')
                ->join('status', 'status.id_status = article.id_status', 'left')
                ->where('article.is_delete', 0)
                ->where('publish_date <=', $this->date_now)
                ->where("(expire_date >= '{$this->date_now}' OR expire_date IS NULL || expire_date = '0000-00-00')")
                ->where("LCASE({$this->db->dbprefix('status')}.status_text)", "publish")
                ->count_all_results();

        return $total_records;
    }
    
    /**
     * Get articles.
     * 
     * @param array $param
     * 
     * @return array|bool $data
     */
    function GetArticles($param = []) 
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
            $sort_by = 'id_article';
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
                ->select('article.*, article_detail.*, article_category.category_title')
                ->join('status', 'status.id_status = article.id_status', 'left')
                ->join('article_detail', 'article_detail.id_article = article.id_article', 'left')
                ->join('localization', 'localization.id_localization = article_detail.id_localization', 'left')
                ->join(
                    "(
                        SELECT {$this->db->dbprefix('article_category')}.id_article_category AS id_category, title AS category_title, uri_path AS category_uri_path
                        FROM {$this->db->dbprefix('article_category')}
                        LEFT JOIN {$this->db->dbprefix('article_category_detail')} ON {$this->db->dbprefix('article_category_detail')}.id_article_category = {$this->db->dbprefix('article_category')}.id_article_category
                        LEFT JOIN {$this->db->dbprefix('localization')} ON {$this->db->dbprefix('localization')}.id_localization = {$this->db->dbprefix('article_category_detail')}.id_localization
                        WHERE {$this->db->dbprefix('localization')}.iso_1 = '{$this->lang->get_active_uri_lang()}'
                    ) AS {$this->db->dbprefix('article_category')}",
                    'article_category.id_category = article.id_article_category',
                    'left'
                )
                ->where('article.is_delete', 0)
                ->where('publish_date <=', $this->date_now)
                ->where("(expire_date >= '{$this->date_now}' OR expire_date IS NULL || expire_date = '0000-00-00')")
                ->where("LCASE({$this->db->dbprefix('status')}.status_text)", "publish")
                ->where("LCASE({$this->db->dbprefix('localization')}.iso_1)", $this->lang->get_active_uri_lang())
                ->order_by('publish_date', 'desc')
                ->order_by('article.id_article', 'desc')
                ->get('article')
                ->result_array();

        return $data;
    }
    
    /**
     * Get category by uri.
     * 
     * @param string $uri_path
     * 
     * @return array|bool $data
     */
    function GetCatagoryByURI($uri_path = '') 
    {
        if (! $uri_path) {
            return false;
        }
        $data = $this->db
                ->join('article_category_detail', 'article_category_detail.id_article_category = article_category.id_article_category', 'left')
                ->join('localization', 'localization.id_localization=article_category_detail.id_localization', 'left')
                ->where("LCASE({$this->db->dbprefix('localization')}.iso_1)", $this->lang->get_active_uri_lang())
                ->where("LCASE(uri_path)", strtolower($uri_path))
                ->limit(1)
                ->get('article_category')
                ->row_array();
        
        return $data;
    }
    
    /**
     * Get article info by URI.
     * 
     * @param string $uri_path
     * 
     * @return array|bool $data
     */
    function GetArticleByURI($uri_path = '') 
    {
        if ( ! $uri_path) {
            return false;
        }
        $data = $this->db
                ->join('status', 'status.id_status = article.id_status', 'left')
                ->join('article_detail', 'article_detail.id_article = article.id_article', 'left')
                ->join('localization', 'localization.id_localization = article_detail.id_localization', 'left')
                ->join(
                    "(
                        SELECT {$this->db->dbprefix('article_category')}.id_article_category AS id_category, title AS category_title, uri_path AS category_uri_path 
                        FROM {$this->db->dbprefix('article_category')}
                        LEFT JOIN {$this->db->dbprefix('article_category_detail')} ON {$this->db->dbprefix('article_category_detail')}.id_article_category = {$this->db->dbprefix('article_category')}.id_article_category
                        LEFT JOIN {$this->db->dbprefix('localization')} ON {$this->db->dbprefix('localization')}.id_localization = {$this->db->dbprefix('article_category_detail')}.id_localization
                        WHERE {$this->db->dbprefix('localization')}.iso_1 = '{$this->lang->get_active_uri_lang()}'
                    ) AS {$this->db->dbprefix('article_category')}",
                    'article_category.id_category = article.id_article_category',
                    'left'
                )
                ->where('is_delete', 0)
                ->where('publish_date <=', $this->date_now)
                ->where("(expire_date >= '{$this->date_now}' OR expire_date IS NULL || expire_date = '0000-00-00')")
                ->where("LCASE({$this->db->dbprefix('article')}.uri_path)", strtolower($uri_path))
                ->where("LCASE({$this->db->dbprefix('status')}.status_text)", "publish")
                ->where("LCASE({$this->db->dbprefix('localization')}.iso_1)", $this->lang->get_active_uri_lang())
                ->order_by('article.id_article', 'desc')
                ->limit(1)
                ->get('article')
                ->row_array();

        return $data;
    }
}
/* End of file Article_model.php */
/* Article: ./application/models/Article_model.php */