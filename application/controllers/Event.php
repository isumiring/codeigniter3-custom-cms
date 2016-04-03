<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Event Class.
 *
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 *
 * @version 3.0
 *
 * @category Controller
 */
class Event extends CI_Controller
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
        $this->load->model('Event_model');
        $this->class_path_name = $this->router->fetch_class();
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $param = [];
        $json = [];
        if ($this->input->get_post('perpage')) {
            $param['limit']['from'] = (int) $this->input->get_post('perpage');
            $param['base_url'] = current_url();
        }
        if ($this->input->is_ajax_request()) {
            $json['html'] = $this->list_data($param);
            json_exit($json);
        }
        $this->data['list_data'] = $this->list_data($param);
    }

    /**
     * Detail page.
     *
     * @param string $uri_path
     */
    public function detail($uri_path = '')
    {
        $record = $this->Event_model->GetEventByURI($uri_path);
        if (!$record) {
            show_404();
            exit();
        }
        $this->data['page_title'] = $record['title'];
        $this->data['event'] = $record;
    }

    /**
     * List event with template.
     *
     *
     * @param array $param
     */
    private function list_data($param = [])
    {
        $total_records = $this->Event_model->CountEvents($param);
        $records = $this->Event_model->GetEvents($param);
        if (isset($param['base_url'])) {
            $paging['base_url'] = $param['base_url'];
        } else {
            $paging['base_url'] = current_url();
        }
        $paging['per_page'] = SHOW_RECORDS_DEFAULT;
        $paging['total_rows'] = $total_records;
        $paging['is_ajax'] = true;
        $data['records'] = $records;
        $data['pagination'] = custom_pagination($paging);

        return $this->load->view(TEMPLATE_DIR.'/'.$this->class_path_name.'/list_data', $data, true);
    }
}

/* End of file Event.php */
/* Location: ./application/controllers/Event.php */
