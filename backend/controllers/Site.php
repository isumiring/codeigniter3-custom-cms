<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Site Class.
 *
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 *
 * @version 3.0
 *
 * @category Controller
 */
class Site extends CI_Controller
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
     * Foreign table for this controller.
     *
     * @var string
     */
    protected $foreignTableSetting;

    /**
     * Filtered Post Data.
     * 
     * @var array
     */
    protected $post_data;

    /**
     * Error message/system.
     *
     * @var string
     */
    protected $error;

    /**
     * Class contructor.
     * 
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Site_model', 'model');

        $this->class_path_name     = $this->router->fetch_class();
        $this->mainTable           = $this->model->GetIdentifier('table');
        $this->primaryKey          = $this->model->GetIdentifier('primaryKey');
        $this->foreignTableSetting = $this->model->GetIdentifier('foreign_table_setting');

        $this->post_data = array_filtered(
            $this->input->post(), [
                'site_name',
                'site_url',
                'site_path',
                'site_address',
                'is_default',
                'setting',
            ]
        );
    }

    /**
     * Index page for this controller.
     * 
     */
    public function index()
    {
        $this->data['url_data']       = site_url($this->class_path_name.'/list_data');
        $this->data['add_url']        = site_url($this->class_path_name.'/add');
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
            $count_all_records         = $this->model->CountAll();
            $count_filtered_records    = $this->model->CountAll($param);
            $records                   = $this->model->GetAllData($param);
            $return                    = [];
            $return['draw']            = $post['draw'];
            $return['recordsTotal']    = $count_all_records;
            $return['recordsFiltered'] = $count_filtered_records;
            $return['data']            = [];
            foreach ($records as $row => $record) {
                $return['data'][$row]['DT_RowId']   = $record['id'];
                $return['data'][$row]['actions']    = '<a href="'. site_url($this->class_path_name. '/detail/'. $record['id']). '" class="btn btn-sm btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                $return['data'][$row]['site_name']  = $record['site_name'];
                $return['data'][$row]['site_url']   = $record['site_url'];
                $return['data'][$row]['is_default'] = ($record['is_default'] == 1) ? 'Default' : '';
            }
            json_exit($return);
        }
        redirect($this->class_path_name);
    }

    /**
     * Detail/Edit page.
     *
     * @param int $id
     */
    public function detail($id = 0)
    {
        if ( ! $id) {
            redirect($this->class_path_name);
        }
        $record = $this->model->GetSite($id);
        if ( ! $record) {
            redirect($this->class_path_name);
        }
        $this->data['page_title']         = 'Detail: '. $record['site_name'];
        $this->data['form_action']        = site_url($this->class_path_name. '/detail/'. $id);
        $this->data['cancel_url']         = site_url($this->class_path_name);
        $this->data['delete_picture_url'] = site_url($this->class_path_name. '/delete_picture');
        $this->data['post'] = $record;
        if ($this->input->post()) {
            $post = $this->post_data;
            if ($this->validateForm($id)) {
                $post['modify_date'] = date('Y-m-d H:i:s');
                $post['is_default'] = (isset($post['is_default']) && $post['is_default'] != '') ?: 0;

                $post_setting = $post['setting'];
                unset($post['setting']);

                // update data
                $this->model->UpdateData($this->mainTable, [$this->primaryKey => $id], $post);

                // update setting
                // but let's delete data before make a new input
                $this->model->DeleteData($this->foreignTableSetting, [$this->primaryKey => $id]);
                $insert = [];
                foreach ($post_setting as $row => $val) {
                    $insert[$row][$this->primaryKey] = $id;
                    $insert[$row]['type']            = $row;
                    $insert[$row]['value']           = $val;
                }
                // insert data
                if (isset($insert) && count($insert) > 0) {
                    $this->model->InsertBatchData($this->foreignTableSetting, $insert);
                }

                $post_image = $_FILES;
                if ($post_image['site_logo']['tmp_name']) {
                    if ($record['site_logo'] != '' && file_exists(UPLOAD_DIR. $this->class_path_name. '/'.$record['site_logo'])) {
                        unlink(UPLOAD_DIR. $this->class_path_name. '/' .$record['site_logo']);
                    }
                    $filename   = url_title($post['site_name'], '_', true). md5plus($id);
                    $picture_db = file_copy_to_folder($post_image['site_logo'], UPLOAD_DIR. $this->class_path_name. '/', $filename);
                    // update data
                    $this->model->UpdateData($this->mainTable, [$this->primaryKey => $id], ['site_logo' => $picture_db]);
                }
                // insert to log
                $this->model->InsertLog('Site Setting', 'Edit Site Setting; ID: '.$id.'; Data: '.json_encode($post));

                $this->session->set_flashdata('flash_message', alert_box('Success.', 'success'));

                redirect($this->class_path_name);
            }
            $this->data['post'] = $post;
        }
        $this->data['template'] = $this->class_path_name.'/form';
        if (isset($this->error)) {
            $this->data['form_message'] = $this->error;
        }
    }

    /**
     * Delete page.
     * 
     */
    public function delete()
    {
        $this->layout = 'none';
        if ($this->input->post() && $this->input->is_ajax_request()) {
            $post = $this->input->post();
            $json = [];
            if ($post['ids'] != '') {
                $array_id = array_map('trim', explode(',', $post['ids']));
                if (count($array_id) > 0) {
                    foreach ($array_id as $row => $id) {
                        $record = $this->model->GetSite($id);
                        if ($record) {
                            $this->model->DeleteData($this->mainTable, [$this->primaryKey => $id]);

                            // insert to log
                            $this->model->InsertLog('Delete Site', 'Delete Site; ID: '. $id. ';');

                            $json['success'] = alert_box('Data has been deleted', 'success');
                            $this->session->set_flashdata('flash_message', $json['success']);
                        } else {
                            $json['error'] = alert_box('Failed. Please refresh the page.', 'danger');
                            break;
                        }
                    }
                }
            }
            json_exit($json);
        }
        redirect($this->class_path_name);
    }

    /**
     * Delete picture.
     * 
     */
    public function delete_picture()
    {
        $this->layout = 'none';
        if ($this->input->post() && $this->input->is_ajax_request()) {
            $json = [];
            $post = $this->input->post();
            if (isset($post['id']) && $post['id'] > 0 && ctype_digit($post['id'])) {
                $detail = $this->model->GetSite($post['id']);
                if ($detail && ($detail['site_logo'] != '' && file_exists(UPLOAD_DIR. $this->class_path_name. '/'.$detail['site_logo']))) {
                    $id = $post['id'];
                    unlink(UPLOAD_DIR. $this->class_path_name. '/'. $detail['site_logo']);
                    // update data
                    $this->model->UpdateData($this->mainTable, [$this->primaryKey => $post['id']], ['site_logo' => '']);

                    // insert to log
                    $this->model->InsertLog('Site Setting', 'Delete Picture Site Setting; ID: '.$id.';');
                    
                    $json['success'] = alert_box('File hase been deleted.', 'success');
                } else {
                    $json['error'] = alert_box('Failed to remove File. Please try again.', 'danger');
                }
            }
            json_exit($json);
        }
        redirect($this->class_path_name);
    }

    /**
     * Validate form.
     *
     * @param int $id
     *
     * @return bool
     */
    private function validateForm($id = 0)
    {
        $rules = [
            [
                'field' => 'site_name',
                'label' => 'Site Name',
                'rules' => 'required',
            ],
            [
                'field' => 'site_url',
                'label' => 'Site URL',
                'rules' => 'required',
            ],
        ];
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() === false) {
            $this->error = alert_box(validation_errors(), 'danger');

            return false;
        } else {
            $post_image = $_FILES;
            if ( ! empty($post_image['site_logo']['tmp_name'])) {
                $check_picture = validate_picture('site_logo');
                if ( ! empty($check_picture)) {
                    $this->error = alert_box($check_picture, 'danger');

                    return false;
                }
            }
        }

        return true;
    }
}
/* End of file Site.php */
/* Location: ./application/controllers/Site.php */
