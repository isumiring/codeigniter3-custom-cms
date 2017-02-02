<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Slideshow Class.
 *
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 *
 * @version 3.0
 *
 * @category Controller
 */
class Slideshow extends CI_Controller 
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
     * Child table for this controller.
     *
     * @var string
     */
    protected $childTableDetail;

    /**
     * Foreign Key from table for this controller.
     *
     * @var string
     */
    protected $foreignKeyLocalization;

    /**
     * Foreign Key from table for this controller.
     *
     * @var string
     */
    protected $foreignKeyStatus;

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
     * Class constructor.
     * 
     */
    function __construct() 
    {
        parent::__construct();
        $this->load->model('Slideshow_model', 'model');

        $this->class_path_name        = $this->router->fetch_class();
        $this->mainTable              = $this->model->GetIdentifier('table');
        $this->primaryKey             = $this->model->GetIdentifier('primaryKey');
        $this->childTableDetail       = $this->model->GetIdentifier('child_table_detail');
        $this->foreignKeyLocalization = $this->model->GetIdentifier('foreign_key_localization');
        $this->foreignKeyStatus       = $this->model->GetIdentifier('foreign_key_status');

        $this->post_data = array_filtered(
            $this->input->post(), [
                'position',
                'url_link',
                'id_status',
                'locales',
            ]
        );
    }

    /**
     * Index page.
     * 
     */
    public function index()
    {
        $this->data['add_url']        = site_url($this->class_path_name.'/add');
        $this->data['url_data']       = site_url($this->class_path_name.'/list_data');
        $this->data['record_perpage'] = SHOW_RECORDS_DEFAULT;
    }
    
    /**
     * List data.
     * 
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
                $return['data'][$row]['DT_RowId']    = $record['id'];
                $return['data'][$row]['actions']     = '<a href="'.site_url($this->class_path_name.'/edit/'.$record['id']).'" class="btn btn-sm btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                $return['data'][$row]['title']       = $record['title'];
                $return['data'][$row]['url_link']    = ($record['url_link'] != '') ? $record['url_link'] : '--';
                $return['data'][$row]['position']    = $record['position'];
                $return['data'][$row]['status_text'] = ucfirst($record['status_text']);
                $return['data'][$row]['create_date'] = custom_date_format($record['create_date'], 'd M Y H:i:s');
            }
            json_exit($return);
        }
        redirect($this->class_path_name);
    }
    
    /**
     * Add page.
     * 
     */
    public function add() 
    {
        $this->data['page_title']   = 'Add';
        $this->data['form_action']  = site_url($this->class_path_name.'/add');
        $this->data['cancel_url']   = site_url($this->class_path_name);
        $this->data['locales']      = get_localization();
        $this->data['statuses']     = get_status();
        $this->data['max_position'] = $this->model->GetMaximumValue($this->mainTable) + 1;
        if ($this->input->post()) {
            $post = $this->post_data;
            if ($this->validateForm()) {
                if (isset($post['locales'])) {
                    $post_locales = $post['locales'];
                    unset($post['locales']);
                }
                if ($post['url_link'] != '' && $post['url_link'] != '#') {
                    $post['url_link'] = prep_url($post['url_link']);
                }
                // insert data
                $id = $this->model->InsertData($this->mainTable, $post);

                $title_name = '';
                if ($id && isset($post_locales)) {
                    $insert_locales = [];
                    foreach ($post_locales as $id_localization => $post_local) {
                        $insert_locales[] = [
                            $this->primaryKey             => $id,
                            'title'                       => $post_local['title'],
                            'caption'                     => $post_local['caption'],
                            $this->foreignKeyLocalization => $id_localization,
                        ];
                        $title_name = ($title_name == '') ? $post_local['title'] : $title_name;
                    }
                    $post['locales'] = $insert_locales;
                    $this->model->InsertBatchData($this->childTableDetail, $insert_locales);
                }
                
                $post_image = $_FILES;
                if ($post_image['primary_image']['tmp_name']) {
                    $filename   = url_title($title_name. '_'. md5plus($id), '_', true);
                    $picture_db = file_copy_to_folder($post_image['primary_image'], UPLOAD_DIR. $this->class_path_name. '/', $filename);

                    copy_image_resize_to_folder(UPLOAD_DIR. $this->class_path_name. '/'.$picture_db, UPLOAD_DIR . $this->class_path_name. '/', 'tmb_'. $filename, IMG_MAX_WIDTH, IMG_MAX_HEIGHT, IMG_RESIZE_QUALITY);

                    $this->model->UpdateData($this->mainTable, [$this->primaryKey => $id], ['primary_image' => $picture_db]);
                }
                // insert to log
                $this->model->InsertLog('Slideshow', 'Add Slideshow; ID: '.$id.'; Data: '.json_encode($post));

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
     * Edit page.
     * 
     * @param int $id
     */
    public function edit($id = 0) 
    {
        if ( ! $id) {
            redirect($this->class_path_name);
        }
        $record = $this->model->GetSlideshow($id);
        if ( ! $record) {
            redirect($this->class_path_name);
        }
        $this->data['page_title']  = 'Edit';
        $this->data['form_action'] = site_url($this->class_path_name.'/edit/'.$id);
        $this->data['cancel_url']  = site_url($this->class_path_name);
        $this->data['locales']     = get_localization();
        $this->data['statuses']    = get_status();
        $this->data['post'] = $record;
        if ($this->input->post()) {
            $post = $this->post_data;
            if ($this->validateForm($id)) {
                if (isset($post['locales'])) {
                    $post_locales = $post['locales'];
                    unset($post['locales']);
                }
                if ($post['url_link'] != '' && $post['url_link'] != '#') {
                    $post['url_link'] = prep_url($post['url_link']);
                }
                $post['modify_date'] = date('Y-m-d H:i:s');
                
                // update data
                $this->model->UpdateData($this->mainTable, [$this->primaryKey => $id], $post);
                
                // delete/purge detail content before make a new insert
                $this->model->DeleteData($this->childTableDetail, [$this->primaryKey => $id]);
                $title_name = '';
                if ($id && isset($post_locales)) {
                    $insert_locales = [];
                    foreach ($post_locales as $id_localization => $post_local) {
                        $insert_locales[] = [
                            $this->primaryKey             => $id,
                            'title'                       => $post_local['title'],
                            'caption'                     => $post_local['caption'],
                            $this->foreignKeyLocalization => $id_localization,
                        ];
                        $title_name = ($title_name == '') ? $post_local['title'] : $title_name;
                    }
                    $post['locales'] = $insert_locales;
                    $this->model->InsertBatchData($this->childTableDetail, $insert_locales);
                }
                
                $post_image = $_FILES;
                if ($post_image['primary_image']['tmp_name']) {
                    // delete file if exists
                    if ($record['primary_image'] != '' && file_exists(UPLOAD_DIR. $this->class_path_name. '/'.$record['primary_image'])) {
                        unlink(UPLOAD_DIR. $this->class_path_name. '/'.$record['primary_image']);
                        @unlink(UPLOAD_DIR. $this->class_path_name. '/tmb_'.$record['primary_image']);
                    }
                    $filename   = url_title($title_name. '_'. md5plus($id), '_', true);
                    $picture_db = file_copy_to_folder($post_image['primary_image'], UPLOAD_DIR. $this->class_path_name. '/', $filename);

                    copy_image_resize_to_folder(UPLOAD_DIR. $this->class_path_name. '/'.$picture_db, UPLOAD_DIR . $this->class_path_name. '/', 'tmb_'. $filename, IMG_MAX_WIDTH, IMG_MAX_HEIGHT, IMG_RESIZE_QUALITY);

                    $this->model->UpdateData($this->mainTable, [$this->primaryKey => $id], ['primary_image' => $picture_db]);
                }
                // insert to log
                $this->model->InsertLog('Slideshow', 'Edit Slideshow; ID: '.$id.'; Data: '.json_encode($post));

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
            $json = array();
            if ($post['ids'] != '') {
                $array_id = array_map('trim', explode(',', $post['ids']));
                if (count($array_id)>0) {
                    foreach ($array_id as $row => $id) {
                        $record = $this->model->GetSlideshow($id);
                        if ($record) {
                            $this->model->DeleteData($this->mainTable, [$this->primaryKey => $id]);
                            // insert to log
                            $this->model->InsertLog('Delete Slideshow', 'Delete Slideshow; ID: '.$id.';');

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
     * Validate form.
     * 
     * @param int $id
     * 
     * @return boolean
     */
    private function validateForm($id = 0) 
    {
        $post           = $this->post_data;
        $default_locale = get_localization(1);
        $rules = [
            [
                'field' => $this->foreignKeyStatus,
                'label' => 'Status',
                'rules' => 'required'
            ],
        ];
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() === false) {
            $this->error = alert_box(validation_errors(), 'danger');

            return false;
        } else {
            foreach ($post['locales'] as $row => $local) {
                if ($row == $default_locale[$this->foreignKeyLocalization] && $local['title'] == '') {
                    $this->error = 'Please insert Title.';

                    break;
                }
            }
            $post_image = $_FILES;
            if ( ! $this->error) {
                if ( ! empty($post_image['primary_image']['tmp_name'])) {
                    $check_picture = validate_picture('primary_image');
                    if ( ! empty($check_picture)) {
                        $this->error = alert_box($check_picture, 'danger');

                        return false;
                    }
                }

                return true;
            }
            $this->error = alert_box($this->error, 'danger');

            return false;
        }

        return true;
    }
}
/* End of file Slideshow.php */
/* Location: ./application/controllers/Slideshow.php */