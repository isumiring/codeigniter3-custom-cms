<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Auth Model Class.
 *
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 *
 * @version 3.0
 *
 * @category Model
 */
class Auth_model extends FAT_Model
{
    /**
     * The database table used by the model
     * 
     * @var string
     */
    protected $table = 'auth_user';

    /**
     * Primary key of the table
     * 
     * @var string
     */
    protected $primaryKey = 'id_auth_user';

    /**
     * Primary key of the table
     * 
     * @var string
     */
    protected $foreignKey = 'id_auth_group';

    /**
     * Class constructor.
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
     * Check login admin.
     *
     * @param string $username
     * @param string $password
     * 
     * @return bool true/false
     */
    public function CheckAuth($username, $password)
    {
        $user_data = $this->db
                ->where('LCASE(username)', $username)
                ->where('status', 1)
                ->limit(1)
                ->get($this->table)
                ->row_array();

        if ($user_data) {
            // return info auth user
            return $user_data;
        }

        return false;
    }
}
/* End of file Auth_model.php */
/* Location: ./application/models/Auth_model.php */
