<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Error Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Error Controller, this is just redirect from error handler so you can customize
 * 
 */
class Error extends CI_Controller {
    
    private $class_path_name;
    
    function __construct() {
        parent::__construct();
        $this->class_path_name = $this->router->fetch_class();
    }
    
    /**
     * redirect from csrf error
     */
    public function csrf_redirect() {
        $this->layout = 'none';
        unset($_SESSION['ADM_SESS']);
        $flash_message = alert_box('Session cookie automatically reset due to expired browser session.&nbsp; Please Re-Login.','danger');
        $this->session->set_flashdata('flash_message', $flash_message);
        if($this->input->is_ajax_request()) {
            header('Content-type: application/json');
            $json['redirect_auth'] = site_url('login');
            exit(
                json_encode($json)
            );
        }
        redirect('login', 'location');
    }
    
}
/* End of file Error.php */
/* Location: ./application/controllers/Error.php */