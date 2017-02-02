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
     * The database table used by the model
     * 
     * @var string
     */
    protected $table = 'article';

    /**
     * Primary key of the table
     * 
     * @var string
     */
    protected $primaryKey = 'id_article';

    /**
     * The database child table used by the model
     * 
     * @var string
     */
    protected $child_table_detail = 'article_detail';

    /**
     * Child key of the main table
     * 
     * @var string
     */
    protected $child_key_detail = 'id_article_detail';

    /**
     * The database foreign table used by the model
     * 
     * @var string
     */
    protected $foreign_table_status = 'status';

    /**
     * Foreign key of the main table
     * 
     * @var string
     */
    protected $foreign_key_status = 'id_status';

    /**
     * The database foreign table used by the model
     * 
     * @var string
     */
    protected $foreign_table_localization = 'localization';

    /**
     * Foreign key of the main table
     * 
     * @var string
     */
    protected $foreign_key_localization = 'id_localization';

    /**
     * The database parent table used by the model
     * 
     * @var string
     */
    protected $parent_table_category = 'article_category';

    /**
     * Foreign key of the main table
     * 
     * @var string
     */
    protected $parent_key_category = 'id_article_category';

    /**
     * The database parent table used by the model
     * 
     * @var string
     */
    protected $parent_table_category_detail = 'article_category_detail';

    /**
     * Foreign key of the main table
     * 
     * @var string
     */
    protected $parent_key_category_detail = 'id_article_category_detail';

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
    public function __construct() 
    {
        parent::__construct();
        $this->date_now      = date('Y-m-d');
        $this->date_time_now = date('Y-m-d H:i:s');
    }

    /**
     * Get Identifier Value.
     * 
     * @param string $key
     * 
     * @return string table value.
     */
    public function GetIdentifier($key)
    {
        return $this->{$key};
    }

    /**
     * Set Identifier Value.
     * 
     * @param string $key
     * @param string $value
     * 
     * @return object|array|string $this
     */
    public function SetIdentifier($key, $value)
    {
        $this->{$key} = $value;

        return $this;
    }
    
    /**
     * Count total records.
     * 
     * @param array $param
     * 
     * @return int $total_records total records
     */
    public function CountArticles($param = []) 
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
                ->from($this->table)
                ->join($this->foreign_table_status, "{$this->foreign_table_status}.{$this->foreign_key_status} = {$this->table}.{$this->foreign_key_status}", 'left')
                ->where('is_delete', 0)
                ->where('publish_date <=', $this->date_now)
                ->group_start()
                    ->where('expire_date >= ', $this->date_now)
                    ->or_where('expire_date IS NULL')
                    ->or_where('expire_date', '0000-00-00')
                ->group_end()
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
    public function GetArticles($param = []) 
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
                ->select("{$this->table}.*, {$this->child_table_detail}.*")
                ->join($this->foreign_table_status, "{$this->foreign_table_status}.{$this->foreign_key_status} = {$this->table}.{$this->foreign_key_status}", 'left')
                ->join($this->child_table_detail, "{$this->child_table_detail}.{$this->primaryKey} = {$this->table}.{$this->primaryKey}", 'left')
                ->join($this->foreign_table_localization, "{$this->foreign_table_localization}.{$this->foreign_key_localization} = {$this->child_table_detail}.{$this->foreign_key_localization}", 'left')
                ->where('publish_date <=', $this->date_now)
                ->group_start()
                    ->where('expire_date >= ', $this->date_now)
                    ->or_where('expire_date IS NULL')
                    ->or_where('expire_date', '0000-00-00')
                ->group_end()
                ->where('article.is_delete', 0)
                ->where("LCASE({$this->db->dbprefix('status')}.status_text)", "publish")
                ->where("LCASE({$this->db->dbprefix('localization')}.iso_1)", $this->lang->get_active_uri_lang())
                ->order_by('publish_date', 'desc')
                ->order_by("{$this->table}.{$this->primaryKey}", 'desc')
                ->get($this->table)
                ->result_array();

        return $data;
    }

    /**
     * Get Categories.
     * 
     * @param array $params
     *
     * @return array|boolean $data
     */
    public function GetCategories($params = [])
    {
        $data = $this->db
                ->join($this->parent_table_category_detail, "{$this->parent_table_category_detail}.{$this->parent_key_category} = {$this->parent_table_category}.{$this->parent_key_category}", 'left')
                ->join($this->foreign_table_localization, "{$this->foreign_table_localization}.$this->foreign_key_localization = {$this->parent_table_category_detail}.{$this->foreign_key_localization}", 'left')
                ->where($this->foreign_table_localization. '.iso_1', $this->lang->get_active_uri_lang())
                ->order_by("{$this->parent_table_category_detail}.title", 'asc')
                ->get($this->parent_table_category)
                ->result_array();

        return $data;
    }

    /**
     * Get Category Info.
     * 
     * @param array $conditions
     *
     * @return array|boolean $data
     */
    public function GetCategoryInfo($conditions = []) 
    {
        if (isset($conditions)) {
            foreach ($conditions as $key => $val) {
                if (ctype_digit($val)) {
                    $this->db->where("{$this->parent_table_category}.{$key}", $val);
                } else {
                    $this->db->where("LCASE({$this->db->dbprefix($this->parent_table_category)}.{$key})", strtolower($val));
                }
            }
        }
        $data = $this->db
                ->join($this->parent_table_category_detail, "{$this->parent_table_category_detail}.{$this->parent_key_category} = {$this->parent_table_category}.{$this->parent_key_category}", 'left')
                ->join($this->foreign_table_localization, "{$this->foreign_table_localization}.$this->foreign_key_localization = {$this->parent_table_category_detail}.{$this->foreign_key_localization}", 'left')
                ->where($this->foreign_table_localization. '.iso_1', $this->lang->get_active_uri_lang())
                ->order_by("{$this->parent_table_category_detail}.title", 'asc')
                ->limit(1)
                ->get($this->parent_table_category)
                ->row_array();

        return $data;
    }

    /**
     * Get Article Info.
     * 
     * @param array $conditions
     *
     * @return array|boolean $data
     */
    public function GetArticleInfo($conditions = [])
    {
        if (isset($conditions)) {
            foreach ($conditions as $key => $val) {
                if (ctype_digit($val)) {
                    $this->db->where("{$this->table}.{$key}", $val);
                } else {
                    $this->db->where("LCASE({$this->db->dbprefix($this->table)}.{$key})", strtolower($val));
                }
            }
        }

        $data = $this->db
                ->select("{$this->table}.*, {$this->child_table_detail}.*")
                ->join($this->foreign_table_status, "{$this->foreign_table_status}.{$this->foreign_key_status} = {$this->table}.{$this->foreign_key_status}", 'left')
                ->join($this->child_table_detail, "{$this->child_table_detail}.{$this->primaryKey} = {$this->table}.{$this->primaryKey}", 'left')
                ->join($this->foreign_table_localization, "{$this->foreign_table_localization}.{$this->foreign_key_localization} = {$this->child_table_detail}.{$this->foreign_key_localization}", 'left')
                ->where('publish_date <=', $this->date_now)
                ->group_start()
                    ->where('expire_date >= ', $this->date_now)
                    ->or_where('expire_date IS NULL')
                    ->or_where('expire_date', '0000-00-00')
                ->group_end()
                ->where('article.is_delete', 0)
                ->where("LCASE({$this->db->dbprefix('status')}.status_text)", "publish")
                ->where("LCASE({$this->db->dbprefix('localization')}.iso_1)", $this->lang->get_active_uri_lang())
                ->order_by('publish_date', 'desc')
                ->order_by("{$this->table}.{$this->primaryKey}", 'desc')
                ->limit(1)
                ->get($this->table)
                ->row_array();

        return $data;
    }
}
/* End of file Article_model.php */
/* Article: ./application/models/Article_model.php */