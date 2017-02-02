<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Logs Class.
 *
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 *
 * @version 3.0
 *
 * @category Controller
 */
class Logs extends CI_Controller
{
    /**
     * This show current class.
     *
     * @var string
     */
    protected $class_path_name;

    /**
     * Table for this controller.
     *
     * @var string
     */
    protected $mainTable;

    /**
     * Primary Key from table for this controller.
     *
     * @var string
     */
    protected $primaryKey;

    /**
     * Class contructor.
     * 
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Logs_model', 'model');

        $this->class_path_name = $this->router->fetch_class();
        $this->mainTable       = $this->model->GetIdentifier('table');
        $this->primaryKey      = $this->model->GetIdentifier('primaryKey');
    }

    /**
     * Index page.
     * 
     */
    public function index()
    {
        $this->data['url_data']       = site_url($this->class_path_name. '/list_data');
        $this->data['record_perpage'] = SHOW_RECORDS_DEFAULT;
    }

    /**
     * Listing data from record.
     *
     * @return json $return
     */
    public function list_data()
    {
        $this->layout = 'none';
        if ($this->input->post() && $this->input->is_ajax_request()) {
            $post = $this->input->post();
            $param['search_value'] = $post['search']['value'];
            $param['search_field'] = $post['columns'];
            if (isset($post['order'])) {
                $param['order_field'] = $post['columns'][$post['order'][0]['column']]['data'];
                $param['order_sort']  = $post['order'][0]['dir'];
            }
            $param['row_from']         = $post['start'];
            $param['length']           = $post['length'];
            $count_all_records         = $this->model->CountAllData();
            $count_filtered_records    = $this->model->CountAllData($param);
            $records                   = $this->model->GetAllData($param);
            $return                    = [];
            $return['draw']            = $post['draw'];
            $return['recordsTotal']    = $count_all_records;
            $return['recordsFiltered'] = $count_filtered_records;
            $return['data']            = [];
            foreach ($records as $row => $record) {
                $return['data'][$row]['DT_RowId']   = $record['id'];
                $return['data'][$row]['username']   = ($record['username'] != '') ? $record['username'] : '---';
                $return['data'][$row]['email']      = ($record['email'] != '') ? $record['email'] : '---';
                $return['data'][$row]['auth_group'] = ($record['auth_group'] != '') ? $record['auth_group'] : '---';
                $return['data'][$row]['action']     = $record['action'];
                $return['data'][$row]['desc']       = $record['desc'];
                $return['data'][$row]['created']    = custom_date_format($record['created'], 'd M Y H:i:s');
            }
            json_exit($return);
        }
        redirect($this->class_path_name);
    }
}
/* End of file Logs.php */
/* Location: ./application/controllers/Logs.php */
