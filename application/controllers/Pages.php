<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Pages Class.
 *
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 *
 * @version 3.0
 *
 * @category Controller
 * @desc Pages Controller
 */
class Pages extends CI_Controller
{
    /**
     * load the parent constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pages_model');
        $this->class_path_name = $this->router->fetch_class();
    }

    /**
     * Index Page for this controller.
     */
    public function index($uri = '')
    {
        $record = $this->Pages_model->GetPageByURI($uri);
        if (!$record) {
            redirect();
        }
        $this->data['record'] = $record;
    }
}

/* End of file Pages.php */
/* Location: ./application/controllers/Pages.php */
