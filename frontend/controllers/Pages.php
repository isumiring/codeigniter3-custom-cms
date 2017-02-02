<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Pages Class.
 * 
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * 
 * @version 3.0
 * 
 * @category Controller
 * 
 */
class Pages extends CI_Controller 
{
    /**
     * This show current class.
     *
     * @var string
     */
    private $class_path_name;
    
    /**
     * Class constructor.
     *     load the parent constructor.
     */
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('Pages_model');
        $this->class_path_name = $this->router->fetch_class();
    }
    
    /**
     * Index Page for this controller.
     * 
     * @access public
     *
     * @param string $uri
     */
    public function index($uri = '') 
    {
        if ( ! $uri) {
            show_404();
        }
        $record = $this->Pages_model->GetPageInfo(['uri_path' => $uri]);
        if ( ! $record) {
            show_404();
        }
        $this->data['page_info'] = $record;
        $this->data['page_title'] = $record['title'];
        if ($record['thumbnail_image'] != '' || $record['primary_image'] != '') {
            $this->data['head_image'] = ($record['thumbnail_image'] != '') ? base_url('uploads/pages/'. $record['thumbnail_image']) : base_url('uploads/pages/'. $record['primary_image']);
        }
        $this->data['page'] = $record;
    }
}

/* End of file Pages.php */
/* Location: ./application/controllers/Pages.php */
