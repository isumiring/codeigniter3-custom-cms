<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Home Class.
 * 
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * 
 * @version 3.0
 * 
 * @category Controller
 * 
 */
class Home extends CI_Controller 
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
        $this->load->model(
            [
                'Slideshow_model',
                'Pages_model',
                'Article_model',
            ]
        );
        $this->class_path_name = $this->router->fetch_class();
    }
    
    /**
     * Index Page for this controller.
     * 
     * @access public
     */
    public function index() 
    {
        $conditions = [
            'module'    => $this->class_path_name,
            'page_type' => 'module'
        ];
        $page_info = $this->Pages_model->GetPageInfo($conditions);
        if ( ! $page_info) {
            // show_404();
            exit();
        }
        $params = [];
        $json   = [];
        $this->data['page_info']  = $page_info;
        $this->data['page_title'] = $page_info['page_name'];
        if ($page_info['thumbnail_image'] != '' || $page_info['primary_image'] != '') {
            $this->data['head_image'] = ($page_info['thumbnail_image'] != '') ? base_url('uploads/pages/'. $page_info['thumbnail_image']) : base_url('uploads/pages/'. $page_info['primary_image']);
        }

        // slideshows
        $this->data['slideshows'] = $this->Slideshow_model->GetSlideshows();

        // article categories
        $this->data['categories'] = $this->Article_model->GetCategories();
    }

}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */
