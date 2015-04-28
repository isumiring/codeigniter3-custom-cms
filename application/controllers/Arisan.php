<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Arisan Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Arisan Controller
 * 
 */
class Arisan extends CI_Controller {
    
    private $class_path_name;

    /**
     * constructor
     */
    function __construct() {
        parent::__construct();
        $this->load->model('Arisan_model');
        $this->class_path_name = $this->router->fetch_class();
    }
    
    /**
     * index page
     */
    public function index() {
        $this->data['url_data'] = site_url($this->class_path_name.'/list_data');
        $this->data['record_perpage'] = SHOW_RECORDS_DEFAULT;
    }
    
    /**
     * list data
     */
    public function list_data() {
        $this->layout = 'none';
        if ($this->input->post() && $this->input->is_ajax_request()) {
            $post = $this->input->post();
            $param['search_value'] = $post['search']['value'];
            $param['search_field'] = $post['columns'];
            if (isset($post['order'])) {
                $param['order_field'] = $post['columns'][$post['order'][0]['column']]['data'];
                $param['order_sort'] = $post['order'][0]['dir'];
            }
            $param['row_from'] = $post['start'];
            $param['length'] = $post['length'];
            $count_all_records = $this->Arisan_model->CountAllArisan();
            $count_filtered_records = $this->Arisan_model->CountAllArisan($param);
            $records = $this->Arisan_model->GetAllArisanData($param);
            $return = array();
            $return['draw'] = $post['draw'];
            $return['recordsTotal'] = $count_all_records;
            $return['recordsFiltered'] = $count_filtered_records;
            $return['data'] = array();
            foreach ($records as $row => $record) {
                $return['data'][$row]['DT_RowId'] = $record['id'];
                $return['data'][$row]['pelanggan_id'] = $record['pelanggan_id'];
                $return['data'][$row]['name'] = $record['name'];
                $return['data'][$row]['email'] = $record['email'];
                $return['data'][$row]['phone'] = $record['phone'];
                $return['data'][$row]['phone2'] = $record['phone2'];
                $return['data'][$row]['create_date'] = custDateFormat($record['create_date'],'d M Y H:i:s');
            }
            header('Content-type: application/json');
            exit (
                json_encode($return)
            );
        }
        redirect($this->class_path_name);
    }
}
/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */