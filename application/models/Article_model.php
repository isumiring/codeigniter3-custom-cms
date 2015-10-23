<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Article Model Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Article model
 * 
 */
class Article_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct() {
        parent::__construct();
    }
    
    /**
     * get categories
     * @return array $data
     */
    function GetCategories() {
        $data = $this->db
                ->join('article_category_detail','article_category_detail.id_article_category=article_category.id_article_category','left')
                ->join('localization','localization.id_localization=article_category_detail.id_localization','left')
                ->where("LCASE({$this->db->dbprefix('localization')}.iso_1)",$this->lang->get_active_uri_lang())
                ->group_by('article_category.id_article_category')
                ->get('article_category')
                ->result_array();
        
        return $data;
    }
    
    /**
     * count total records
     * @param array $param
     * @return int $total_records
     */
    function CountArticles($param) {
        $now = date('Y-m-d');
        if (isset($param['conditions'])) {
            foreach ($param['conditions'] as $key => $val) {
                $this->db->where($key,$val);
            }
        }
        $total_records = $this->db
                ->from('article')
                ->join('status','status.id_status=article.id_status','left')
                ->where('article.is_delete',0)
                ->where('publish_date <=',$now)
                ->where("(expire_date >= '{$now}' OR expire_date IS NULL || expire_date = '0000-00-00')")
                ->where("LCASE({$this->db->dbprefix('status')}.status_text)","publish")
                //->group_by('article.id_article')
                ->count_all_results();
        return $total_records;
    }
    
    /**
     * get articles
     * @param array $param
     * @return array $data
     */
    function GetArticles($param) {
        $now = date('Y-m-d');
        if (isset($param['conditions'])) {
            foreach ($param['conditions'] as $key => $val) {
                $this->db->where($key,$val);
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
            $sort = 'desc';
            $sort_by = 'id_article';
            if (isset($param['order']['field'])) {
                $sort_by = $param['order']['field'];
            }
            if (isset($param['order']['sort'])) {
                $sort = $param['order']['sort'];
            }
            $this->db->order_by($sort_by,$sort);
        }
        $this->db->limit($per_page,$from);
        $data = $this->db
                ->select('article.*,article_detail.*,article_category.category_title')
                ->join('status','status.id_status=article.id_status','left')
                ->join('article_detail','article_detail.id_article=article.id_article','left')
                ->join('localization','localization.id_localization=article_detail.id_localization','left')
                ->join(
                    "(
                        select {$this->db->dbprefix('article_category')}.id_article_category as id_category, title as category_title from {$this->db->dbprefix('article_category')}
                        left join {$this->db->dbprefix('article_category_detail')} on {$this->db->dbprefix('article_category_detail')}.id_article_category={$this->db->dbprefix('article_category')}.id_article_category
                        left join {$this->db->dbprefix('localization')} on {$this->db->dbprefix('localization')}.id_localization={$this->db->dbprefix('article_category_detail')}.id_localization
                        where {$this->db->dbprefix('localization')}.iso_1='{$this->lang->get_active_uri_lang()}'
                    ) as {$this->db->dbprefix('article_category')}",
                    'article_category.id_category=article.id_article_category',
                    'left'
                )
                ->where('article.is_delete',0)
                ->where('publish_date <=',$now)
                ->where("(expire_date >= '{$now}' OR expire_date IS NULL || expire_date = '0000-00-00')")
                ->where("LCASE({$this->db->dbprefix('status')}.status_text)","publish")
                ->where("LCASE({$this->db->dbprefix('localization')}.iso_1)",$this->lang->get_active_uri_lang())
                ->order_by('publish_date','desc')
                ->order_by('article.id_article','desc')
                ->get('article')
                ->result_array();
        return $data;
    }
    
    /**
     * get category by uri
     * @param string $uri_path
     * @return array $data
     */
    function GetCatagoryByURI($uri_path) {
        $data = $this->db
                ->join('article_category_detail','article_category_detail.id_article_category=article_category.id_article_category','left')
                ->join('localization','localization.id_localization=article_category_detail.id_localization','left')
                ->where("LCASE({$this->db->dbprefix('localization')}.iso_1)",$this->lang->get_active_uri_lang())
                ->where("LCASE(uri_path)",strtolower($uri_path))
                ->limit(1)
                ->get('article_category')
                ->row_array();
        
        return $data;
    }
    
    /**
     * get article info by URI
     * @param string $uri_path
     * @return boolean
     */
    function GetArticleByURI($uri_path='') {
        $now = date('Y-m-d');
        if ($uri_path) {
            $data = $this->db
                    ->join('status','status.id_status=article.id_status','left')
                    ->join('article_detail','article_detail.id_article=article.id_article','left')
                    ->join('localization','localization.id_localization=article_detail.id_localization','left')
                    ->where('is_delete',0)
                    ->where('publish_date <=',$now)
                    ->where("(expire_date >= '{$now}' OR expire_date IS NULL || expire_date = '0000-00-00')")
                    ->where('LCASE(uri_path)',strtolower($uri_path))
                    ->where("LCASE({$this->db->dbprefix('status')}.status_text)","publish")
                    ->where("LCASE({$this->db->dbprefix('localization')}.iso_1)",$this->lang->get_active_uri_lang())
                    ->order_by('article.id_article','desc')
                    ->limit(1)
                    ->get('article')
                    ->row_array();
            return $data;
        } else {
            return FALSE;
        }
    }
    
    function GetNextPrevArticle($id_article,$publish_date,$direction='next') {
        $now = date('Y-m-d');
        if ($direction == 'prev') {
            $this->db->where('article.publish_date<=',$publish_date);
            $this->db->where('article.id_article<',$id_article);
            $this->db->order_by('article.publish_date','desc');
            $this->db->order_by('article.id_article','desc');
        } else {
            $this->db->where('article.publish_date>=',$publish_date);
            $this->db->where('article.id_article>',$id_article);
            $this->db->order_by('article.publish_date','asc');
            $this->db->order_by('article.id_article','asc');
        }
        $data = $this->db
                ->join('status','status.id_status=article.id_status','left')
                ->join('article_detail','article_detail.id_article=article.id_article','left')
                ->join('localization','localization.id_localization=article_detail.id_localization','left')
                ->where('is_delete',0)
                //->where('article.id_article !=',$id_article)
                ->where('publish_date <=',$now)
                ->where("(expire_date >= '{$now}' OR expire_date IS NULL || expire_date = '0000-00-00')")
                ->where("LCASE({$this->db->dbprefix('status')}.status_text)","publish")
                ->where("LCASE({$this->db->dbprefix('localization')}.iso_1)",$this->lang->get_active_uri_lang())
                ->limit(1)
                ->get('article')
                ->row_array();
        return $data;
    }
}
/* End of file Article_model.php */
/* Article: ./application/models/Article_model.php */