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
     * The database table used by the model
     * 
     * @var string
     */
    protected $table = 'slideshow';

    /**
     * Primary key of the table
     * 
     * @var string
     */
    protected $primaryKey = 'id_slideshow';

    /**
     * The database child table used by the model
     * 
     * @var string
     */
    protected $child_table_detail = 'slideshow_detail';

    /**
     * Child key of the main table
     * 
     * @var string
     */
    protected $child_key_detail = 'id_slideshow_detail';

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
     * Get all slideshows.
     * 
     * @param string $page default is home_page
     * 
     * @return array|bool $data
     */
    function GetSlideshows() 
    {
        $data = $this->db
                ->join($this->foreign_table_status, "{$this->foreign_table_status}.{$this->foreign_key_status} = {$this->table}.{$this->foreign_key_status}", 'left')
                ->join($this->child_table_detail, "{$this->child_table_detail}.{$this->primaryKey} = {$this->table}.{$this->primaryKey}", 'left')
                ->join($this->foreign_table_localization, "{$this->foreign_table_localization}.{$this->foreign_key_localization} = {$this->child_table_detail}.{$this->foreign_key_localization}", 'left')
                ->where("LCASE({$this->db->dbprefix($this->foreign_table_status)}.status_text)", "publish")
                ->where("LCASE({$this->db->dbprefix($this->foreign_table_localization)}.iso_1)", $this->lang->get_active_uri_lang())
                ->where('is_delete', 0)
                ->order_by('position', 'asc')
                ->order_by("{$this->table}.{$this->primaryKey}", 'desc')
                ->get($this->table)
                ->result_array();

        return $data;
    }
}
/* End of file Slideshow_model.php */
/* Location: ./application/models/Slideshow_model.php */