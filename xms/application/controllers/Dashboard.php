<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard Class
 * 		default home location
 * 		
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * 
 * @version 3.0
 * 
 * @category Controller
 * 
 */
class Dashboard extends CI_Controller 
{
    /**
     * Index Page for this controller.
     * 
     */
    public function index() 
    {
        $this->data['page_title'] = 'Dashboard';
    }
}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */
