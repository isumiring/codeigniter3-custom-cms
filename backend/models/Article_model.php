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
class Article_model extends FAT_Model
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
     * The database child table used by the model
     * 
     * @var string
     */
    protected $parent_table_category = 'article_category';

    /**
     * Child key of the main table
     * 
     * @var string
     */
    protected $parent_key_category = 'id_article_category';

    /**
     * The database child table used by the model
     * 
     * @var string
     */
    protected $parent_table_category_detail = 'article_category_detail';

    /**
     * Child key of the main table
     * 
     * @var string
     */
    protected $parent_key_category_detail = 'id_article_category_detail';

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
     * Class constructor.
     * 
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get Table Value.
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
     * Set Table Value.
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
            $i=0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i==0) {
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
                ->select("*, {$this->table}.{$this->primaryKey} as id")
                ->join(
                    "(
                        SELECT title as category_name, {$this->db->dbprefix($this->parent_table_category)}.{$this->parent_key_category} FROM {$this->db->dbprefix($this->parent_table_category)}
                        LEFT JOIN {$this->db->dbprefix($this->parent_table_category_detail)} ON {$this->db->dbprefix($this->parent_table_category_detail)}.{$this->parent_key_category} = {$this->db->dbprefix($this->parent_table_category)}.{$this->parent_key_category}
                        LEFT JOIN {$this->db->dbprefix($this->foreign_table_localization)} ON {$this->db->dbprefix($this->foreign_table_localization)}.{$this->foreign_key_localization} = {$this->db->dbprefix($this->parent_table_category_detail)}.{$this->foreign_key_localization}
                        WHERE {$this->db->dbprefix($this->foreign_table_localization)}.locale_status = 1
                    ) as {$this->db->dbprefix($this->parent_table_category)}
                    ",
                    $this->parent_table_category. '.'. $this->parent_key_category. ' = '. $this->table. '.'. $this->parent_key_category,
                    'left'
                )
                ->join($this->child_table_detail, "{$this->child_table_detail}.{$this->primaryKey} = {$this->table}.{$this->primaryKey}", 'left')
                ->join($this->foreign_table_localization, "{$this->foreign_table_localization}.{$this->foreign_key_localization} = {$this->child_table_detail}.{$this->foreign_key_localization}", 'left')
                ->join($this->foreign_table_status, "{$this->foreign_table_status}.{$this->foreign_key_status} = {$this->table}.{$this->foreign_key_status}", 'left')
                ->where($this->foreign_table_localization. '.locale_status', 1)
                ->where($this->table. '.is_delete', 0)
                ->get($this->table)
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
            $i=0;
            foreach ($param['search_field'] as $row => $val) {
                if ($val['searchable'] == 'true') {
                    if ($i==0) {
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
                ->from($this->table)
                ->join(
                    "(
                        SELECT title as category_name, {$this->db->dbprefix($this->parent_table_category)}.{$this->parent_key_category} FROM {$this->db->dbprefix($this->parent_table_category)}
                        LEFT JOIN {$this->db->dbprefix($this->parent_table_category_detail)} ON {$this->db->dbprefix($this->parent_table_category_detail)}.{$this->parent_key_category} = {$this->db->dbprefix($this->parent_table_category)}.{$this->parent_key_category}
                        LEFT JOIN {$this->db->dbprefix($this->foreign_table_localization)} ON {$this->db->dbprefix($this->foreign_table_localization)}.{$this->foreign_key_localization} = {$this->db->dbprefix($this->parent_table_category_detail)}.{$this->foreign_key_localization}
                        WHERE {$this->db->dbprefix($this->foreign_table_localization)}.locale_status = 1
                    ) as {$this->db->dbprefix($this->parent_table_category)}
                    ",
                    $this->parent_table_category. '.'. $this->parent_key_category. ' = '. $this->table. '.'. $this->parent_key_category,
                    'left'
                )
                ->join($this->child_table_detail, "{$this->child_table_detail}.{$this->primaryKey} = {$this->table}.{$this->primaryKey}", 'left')
                ->join($this->foreign_table_localization, "{$this->foreign_table_localization}.{$this->foreign_key_localization} = {$this->child_table_detail}.{$this->foreign_key_localization}", 'left')
                ->join($this->foreign_table_status, "{$this->foreign_table_status}.{$this->foreign_key_status} = {$this->table}.{$this->foreign_key_status}", 'left')
                ->where($this->foreign_table_localization. '.locale_status', 1)
                ->where($this->table. '.is_delete', 0)
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
                ->select('*')
                ->select("{$this->primaryKey} as id")
                ->where($this->primaryKey, $id)
                ->limit(1)
                ->get($this->table)
                ->row_array();

        if ($data) {
            $locales = $this->db
                        ->where($this->primaryKey, $id)
                        ->order_by($this->foreign_key_localization, 'asc')
                        ->get($this->child_table_detail)
                        ->result_array();
            foreach ($locales as $key => $local) {
                $data['locales'][$local[$this->foreign_key_localization]]['title']       = $local['title'];
                $data['locales'][$local[$this->foreign_key_localization]]['teaser']      = $local['teaser'];
                $data['locales'][$local[$this->foreign_key_localization]]['description'] = $local['description'];
            }
        }
        return $data;
    }

    /**
     * Get Categories.
     * 
     * @return array|bool $data
     */
    public function GetCategories()
    {
        $data = $this->db
                ->select("*, {$this->parent_table_category}.{$this->parent_key_category} as id")
                ->join($this->parent_table_category_detail, "{$this->parent_table_category_detail}.{$this->parent_key_category} = {$this->parent_table_category}.{$this->parent_key_category}", 'left')
                ->join($this->foreign_table_localization, "{$this->foreign_table_localization}.$this->foreign_key_localization = {$this->parent_table_category_detail}.{$this->foreign_key_localization}", 'left')
                ->where($this->foreign_table_localization. '.locale_status', 1)
                ->order_by("{$this->parent_table_category_detail}.title", 'asc')
                ->get($this->parent_table_category)
                ->result_array();

        return $data;
    }
    
}
/* End of file Article_model.php */
/* Location: ./application/models/Article_model.php */