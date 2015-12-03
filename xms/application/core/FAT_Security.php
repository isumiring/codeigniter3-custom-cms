<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Security Class Extension
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Core
 * @desc extension of security class
 * 
 */
class FAT_Security extends CI_Security {

    /**
     * load the constructor
     */
    function __construct() {
        parent::__construct();
    }
    
    /**
     * reset to login page if csrf is expired
     */
    public function csrf_show_error() {
        // show_error('The action you have requested is not allowed.');  // default code
        $redirect_url = PATH_CMS.'error/csrf_redirect';
        header('Location: '.$redirect_url.'', TRUE, 302);
    }

}
