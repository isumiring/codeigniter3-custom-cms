<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Destination Category Model Class.
 * 
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * 
 * @version 3.0
 * 
 * @category Model
 * 
 */
class Category_model extends FAT_Model
{
    /**
     * The database table used by the model
     * 
     * @var string
     */
    protected $table = 'article_category';

    /**
     * Primary key of the table
     * 
     * @var string
     */
    protected $primaryKey = 'id_article_category';

    /**
     * The database child table used by the model
     * 
     * @var string
     */
    protected $child_table_detail = 'article_category_detail';

    /**
     * Child key of the main table
     * 
     * @var string
     */
    protected $child_key_detail = 'id_article_category_detail';

    /**
     * The database child table used by the model
     * 
     * @var string
     */
    protected $child_table_article = 'article';

    /**
     * Child key of the main table
     * 
     * @var string
     */
    protected $child_key_article = 'id_article';

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
     * Cascading Article Delete.
     * 
     * @var boolean
     */
    protected $cascading = false;

    /**
     * Class constructor.
     * 
     */
    public function __construct()
    {
        parent::__construct();
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
     * Get all data.
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
                ->join($this->child_table_detail, "{$this->child_table_detail}.{$this->primaryKey} = {$this->table}.{$this->primaryKey}", 'left')
                ->join($this->foreign_table_localization, "{$this->foreign_table_localization}.$this->foreign_key_localization = {$this->child_table_detail}.{$this->foreign_key_localization}", 'left')
                ->where($this->foreign_table_localization. '.locale_status', 1)
                ->get($this->table)
                ->result_array();

        return $data;
    }
    
    /**
     * Count records.
     * 
     * @param array $param
     * 
     * @return int $total_records total records
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
                ->join($this->child_table_detail, "{$this->child_table_detail}.{$this->primaryKey} = {$this->table}.{$this->primaryKey}", 'left')
                ->join($this->foreign_table_localization, "{$this->foreign_table_localization}.$this->foreign_key_localization = {$this->child_table_detail}.{$this->foreign_key_localization}", 'left')
                ->where($this->foreign_table_localization. '.locale_status', 1)                         
                ->count_all_results();

        return $total_records;
    }
    
    /**
     * Get detail by id.
     * 
     * @param int $id
     * 
     * @return array|bool $data
     */
    public function GetCategory($id) 
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
            foreach ($locales as $row => $local) {
                $data['locales'][$local[$this->foreign_key_localization]]['title']      = $local['title'];
                $data['locales'][$local[$this->foreign_key_localization]]['description'] = $local['description'];
            }
        }

        return $data;
    }
    
}
/* End of file Category_model.php */
/* Destination: ./application/models/Category_model.php */