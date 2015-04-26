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

        $flash_message = alert_box('Session cookie automatically reset due to expired browser session.&nbsp; Please Re-Login.','danger');
        session_destroy();
        $this->session->set_flashdata('message', $flash_message);
        redirect('login', 'location');
    }

}
