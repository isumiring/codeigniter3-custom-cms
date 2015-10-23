<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Article Category Model Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Model
 * @desc Article Category model
 * 
 */
class Article_category_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * get localization list
     * @return array data
     */
    function GetLocalization() {
        $data = $this->db
                ->order_by('locale_status','desc')
                ->order_by('id_localization','asc')
                ->get('localization')
                ->result_array();
        return $data;
    }
    
    /**
     * get default localization
     * @return array data
     */
    function GetDefaultLocalization() {
        $data = $this->db
                ->where('locale_status',1)
                ->limit(1)
                ->get('localization')
                ->row_array();
        return $data;
    }
    
    /**
     * get all data
     * @param string $param
     * @return array data
     */
    function GetAllData($param=array()) {
        if (isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i=0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i==0) {
                        $this->db->like('LCASE(`'.$val['data'].'`)',strtolower($param['search_value']));
                    } else {
                        $this->db->or_like('LCASE(`'.$val['data'].'`)',strtolower($param['search_value']));
                    }
                    $i++;
                }
            }
            $this->db->group_end();
        }
        if (isset($param['row_from']) && isset($param['length'])) {
            $this->db->limit($param['length'],$param['row_from']);
        }
        if (isset($param['order_field'])) {
            if (isset($param['order_sort'])) {
                $this->db->order_by($param['order_field'],$param['order_sort']);
            } else {
                $this->db->order_by($param['order_field'],'desc');
            }
        } else {
            $this->db->order_by('id','desc');
        }
        $data = $this->db
                ->select("*,article_category.id_article_category as id",FALSE)
                ->join('article_category_detail','article_category_detail.id_article_category=article_category.id_article_category','left')
                ->join('localization','localization.id_localization=article_category_detail.id_localization','left')
                ->where('localization.locale_status',1)
                ->get('article_category')
                ->result_array();
        return $data;
    }
    
    /**
     * count records
     * @param string $param
     * @return int total records
     */
    function CountAllData($param=array()) {
        if (is_array($param) && isset($param['search_value']) && $param['search_value'] != '') {
            $this->db->group_start();
            $i=0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i==0) {
                        $this->db->like('LCASE(`'.$val['data'].'`)',strtolower($param['search_value']));
                    } else {
                        $this->db->or_like('LCASE(`'.$val['data'].'`)',strtolower($param['search_value']));
                    }
                    $i++;
                }
            }
            $this->db->group_end();
        }
        $total_records = $this->db
                ->from('article_category')
                ->join('article_category_detail','article_category_detail.id_article_category=article_category.id_article_category','left')
                ->join('localization','localization.id_localization=article_category_detail.id_localization','left')
                ->where('localization.locale_status',1)
                ->count_all_results();
        return $total_records;
    }
    
    /**
     * Get detail by id
     * @param int $id
     * @return array data
     */
    function GetArticleCategory($id) {
        $data = $this->db
                ->where('id_article_category',$id)
                ->limit(1)
                ->get('article_category')
                ->row_array();
        if ($data) {
            $locales = $this->db
                        ->select('id_localization,title')
                        ->where('id_article_category',$id)
                        ->order_by('id_localization','asc')
                        ->get('article_category_detail')
                        ->result_array();
            foreach ($locales as $row => $local) {
                $data['locales'][$local['id_localization']]['title'] = $local['title'];
            }
        }
        return $data;
    }
    
    /**
     * insert new record
     * @param array $param
     * @return int last inserted id
     */
    function InsertRecord($param) {
        $this->db->insert('article_category',$param);
        $last_id = $this->db->insert_id();
        return $last_id;
    }
    
    /**
     * update record
     * @param int $id
     * @param array $param
     */
    function UpdateRecord($id,$param) {
        $this->db->where('id_article_category',$id);
        $this->db->update('article_category',$param);
    }
    
    /**
     * delete record
     * @param int $id
     */
    function DeleteRecord($id) {
        $this->db->where('id_article_category',$id);
        $this->db->delete('article_category');
    }
    
    /**
     * insert detail
     * @param array $param
     */
    function InsertDetailRecord($param) {
        $this->db->insert_batch('article_category_detail',$param);
    }
    
    /**
     * delete detail record
     * @param int $id
     */
    function DeleteDetailRecordByID($id) {
        $this->db->where('id_article_category',$id);
        $this->db->delete('article_category_detail');
    }
    
}
/* End of file Article_category_model.php */
/* Article: ./application/models/Article_category_model.php */