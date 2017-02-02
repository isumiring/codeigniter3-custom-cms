<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Error Class.
 *     Error Controller, this is just redirect from error handler so you can customize
 *     
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 *
 * @version 3.0
 *
 * @category Controller
 */
class Error extends CI_Controller
{
    /**
     * This show current class.
     *
     * @var string
     */
    protected $class_path_name;

    /**
     * Class contructor.
     * 
     */
    public function __construct()
    {
        parent::__construct();
        $this->class_path_name = $this->router->fetch_class();
    }

    /**
     * Index/default page for error.
     * 
     */
    public function index()
    {
        $this->layout = 'none';
        $message = $this->session->flashdata('error_exception');
        if ($message) {
            $this->data['error_heading'] = 'Hi!, there\'s error in Your request';
            $this->data['error_message'] = $message;
            log_message('error', $message, true);
            // loads a proper view or partial
        } else { // redirects if there is no error
            // echo 'asfsaf';
            redirect(base_url(), 'refresh');
        }
    }

    /**
     * Redirect from csrf error.
     * 
     */
    public function csrf_redirect()
    {
        $this->layout = 'none';
        unset($_SESSION['ADM_SESS']);
        $flash_message = alert_box('Session cookie automatically reset due to expired browser session.&nbsp; Please Re-Login.', 'danger');
        $this->session->set_flashdata('flash_message', $flash_message);
        if ($this->input->is_ajax_request()) {
            $json['redirect_auth'] = site_url('login');
            json_exit($json);
        }
        redirect('login', 'location');
    }

    /**
     * Error 404.
     * 
     */
    public function page_not_found()
    {
        show_404();
    }

    /**
     * Show forbidden page.
     * 
     */
    public function page_forbidden()
    {
        $this->data['page_title']    = 'Forbidden';
        $this->data['error_heading'] = 'Forbidden Page';
        $this->data['error_message'] = 'Hey. Get out of here.';
    }
}
/* End of file Error.php */
/* Location: ./application/controllers/Error.php */
