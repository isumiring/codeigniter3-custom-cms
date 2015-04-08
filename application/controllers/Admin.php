<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Admin Controller
 * 
 */
class Admin extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('Admin_model');
    }
    /**
     * index page
     */
    public function index() {
        $this->data['url_data'] = site_url('admin/list_data');
        $this->data['record_perpage'] = SHOW_RECORDS_DEFAULT;
    }
    
    public function list_data() {
        $this->layout = 'none';
        if ($this->input->post() && $this->input->is_ajax_request()) {
            $post = $this->input->post();
            $searchq = $post['search']['value'];
            $start = $post['start'];
            $perpage = ($post['length']/10);
            $count_all_records = $this->Admin_model->CountAllAdmin();
            $count_filtered_records = $this->Admin_model->CountAllAdmin($searchq);
            $records = $this->Admin_model->GetAllAdmin($searchq,$start,$perpage);
            $return = array();
            $return['draw'] = $post['draw'];
            $return['recordsTotal'] = $count_all_records;
            $return['recordsFiltered'] = $count_filtered_records;
            $return['data'] = array();
            foreach ($records as $row => $record) {
                /*$return['data'][$i]['DT_RowId'] = 'row_'.$record['id'];
                $return['data'][$i]['DT_RowData'] = array('pkey'=>(int)$record['id']);
                $return['data'][$i]['username'] = $record['username'];
                $return['data'][$i]['name'] = $record['name'];
                $return['data'][$i]['email'] = $record['email'];*/
                $return['data'][$row] = array(
                    $record['username'],
                    $record['name'],
                    $record['email'],
                    $record['auth_group'],
                    custDateFormat($record['create_date'],'d M Y H:i:s'),
                );
            }
            echo json_encode($return);
        }
    }
}
/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */