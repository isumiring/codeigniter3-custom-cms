<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Logs Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Logs Controller
 * 
 */
class Logs extends CI_Controller {
    
    private $class_path_name;

    /**
     * constructor
     */
    function __construct() {
        parent::__construct();
        $this->load->model('Logs_model');
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
            $searchq = $post['search']['value'];
            $start = $post['start'];
            $perpage = $post['length'];
            $order_by['by'] = $post['columns'][$post['order'][0]['column']]['data'];
            $order_by['sort'] = $post['order'][0]['dir'];
            $count_all_records = $this->Logs_model->CountAllLogs();
            $count_filtered_records = $this->Logs_model->CountAllLogs($searchq);
            $records = $this->Logs_model->GetAllLogs($searchq,$order_by,$start,$perpage);
            $return = array();
            $return['draw'] = $post['draw'];
            $return['recordsTotal'] = $count_all_records;
            $return['recordsFiltered'] = $count_filtered_records;
            $return['data'] = array();
            foreach ($records as $row => $record) {
                $return['data'][$row]['DT_RowId'] = 'row_'.$record['id'];
                //$return['data'][$i]['DT_RowData'] = array('pkey'=>(int)$record['id']);
                $return['data'][$row]['username'] = $record['username'];
                $return['data'][$row]['email'] = $record['email'];
                $return['data'][$row]['auth_group'] = $record['auth_group'];
                $return['data'][$row]['action'] = $record['action'];
                $return['data'][$row]['desc'] = $record['desc'];
                $return['data'][$row]['created'] = custDateFormat($record['created'],'d M Y H:i:s');
                /*$return['data'][$row] = array(
                    $record['username'],
                    $record['name'],
                    $record['email'],
                    $record['auth_group'],
                    $record['action'],
                    $record['desc'],
                    custDateFormat($record['create_date'],'d M Y H:i:s'),
                );*/
            }
            echo json_encode($return);
        }
    }
}
/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */