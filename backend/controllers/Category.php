<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Article Category Class.
 * 
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * 
 * @version 3.0
 * 
 * @category Controller
 * 
 */
class Category extends CI_Controller 
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
     * Child table for this controller.
     *
     * @var string
     */
    protected $childTableArticle;

    /**
     * Foreign Key from table for this controller.
     *
     * @var string
     */
    protected $foreignKeyLocalization;

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
     */
    function __construct() 
    {
        parent::__construct();
        $this->load->model('Category_model', 'model');

        $this->class_path_name        = $this->router->fetch_class();
        $this->mainTable              = $this->model->GetIdentifier('table');
        $this->primaryKey             = $this->model->GetIdentifier('primaryKey');
        $this->childTableDetail       = $this->model->GetIdentifier('child_table_detail');
        $this->childTableArticle      = $this->model->GetIdentifier('child_table_article');
        $this->foreignKeyLocalization = $this->model->GetIdentifier('foreign_key_localization');

        $this->post_data = array_filtered(
            $this->input->post(), [
                'uri_path',
                'locales',
            ]
        );
    }
    
    /**
     * Index page.
     */
    public function index() 
    {
        $this->data['add_url']        = site_url($this->class_path_name.'/add');
        $this->data['url_data']       = site_url($this->class_path_name.'/list_data');
        $this->data['record_perpage'] = SHOW_RECORDS_DEFAULT;
    }
    
    /**
     * List data.
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
                $return['data'][$row]['actions']  = '<a href="'.site_url($this->class_path_name.'/edit/'.$record['id']).'" class="btn btn-sm btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                $return['data'][$row]['DT_RowId'] = $record['id'];
                $return['data'][$row]['title']    = $record['title'];
            }
            json_exit($return);
        }
        redirect($this->class_path_name);
    }
    
    /**
     * Add page.
     */
    public function add() 
    {
        $this->data['page_title']  = 'Add';
        $this->data['form_action'] = site_url($this->class_path_name.'/add');
        $this->data['cancel_url']  = site_url($this->class_path_name);
        $this->data['locales']     = get_localization();
        if ($this->input->post()) {
            $post = $this->post_data;
            if ($this->validateForm()) {
                if (isset($post['locales'])) {
                    $post_locales = $post['locales'];
                    unset($post['locales']);
                }
                // insert data
                $id = $this->model->InsertData($this->mainTable, $post);

                // insert locales
                if ($id && isset($post_locales)) {
                    $insert_locales = [];
                    foreach ($post_locales as $id_localization => $post_local) {
                        $insert_locales[] = [
                            $this->primaryKey             => $id,
                            'title'                       => $post_local['title'],
                            'description'                 => $post_local['description'],
                            $this->foreignKeyLocalization => $id_localization,
                        ];
                    }
                    $post['locales'] = $insert_locales;
                    $this->model->InsertBatchData($this->childTableDetail, $insert_locales);
                }

                $post_image = $_FILES;
                if ($post_image['thumbnail_image']['tmp_name']) {
                    $filename   = url_title($post['uri_path']. '-thumb', '_', true);
                    $picture_db = file_copy_to_folder($post_image['thumbnail_image'], UPLOAD_DIR. $this->class_path_name. '/', $filename);
                    copy_image_resize_to_folder(UPLOAD_DIR. $this->class_path_name. '/'.$picture_db, UPLOAD_DIR . $this->class_path_name. '/', 'tmb_'. $filename, IMG_DESTINATION_THUMB_WIDTH, IMG_DESTINATION_THUMB_HEIGHT, IMG_RESIZE_QUALITY);
                    copy_image_resize_to_folder(UPLOAD_DIR. $this->class_path_name. '/'.$picture_db, UPLOAD_DIR . $this->class_path_name. '/', 'sml_'. $filename, IMG_SMALL_WIDTH, IMG_SMALL_HEIGHT, IMG_RESIZE_QUALITY);
                    // update data
                    $this->model->UpdateData($this->mainTable, [$this->primaryKey => $id], ['thumbnail_image' => $picture_db]);
                }
                
                // insert to log
                $this->model->InsertLog('Category', 'Add Category; ID: '.$id.'; Data: '.json_encode($post));
                
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
     * Detail page.
     * 
     * @param int $id
     */
    public function edit($id = 0) 
    {
        if ( ! $id) {
            redirect($this->class_path_name);
        }
        $record = $this->model->GetCategory($id);
        if ( ! $record) {
            redirect($this->class_path_name);
        }
        $this->data['page_title']  = 'Edit';
        $this->data['form_action'] = site_url($this->class_path_name.'/edit/'.$id);
        $this->data['delete_picture_url'] = site_url($this->class_path_name.'/delete_picture/'.$id);
        $this->data['cancel_url']  = site_url($this->class_path_name);
        $this->data['locales']     = get_localization();
        $this->data['post'] = $record;
        if ($this->input->post()) {
            $post = $this->post_data;
            if ($this->validateForm($id)) {
                if (isset($post['locales'])) {
                    $post_locales = $post['locales'];
                    unset($post['locales']);
                }
                
                // update data
                $this->model->UpdateData($this->mainTable, [$this->primaryKey => $id], $post);

                // delete/purge detail content before make a new insert
                $this->model->DeleteData($this->childTableDetail, [$this->primaryKey => $id]);
                if ($id && isset($post_locales)) {
                    $insert_locales = [];
                    foreach ($post_locales as $id_localization => $post_local) {
                        $insert_locales[] = [
                            $this->primaryKey             => $id,
                            'title'                       => $post_local['title'],
                            'description'                 => $post_local['description'],
                            $this->foreignKeyLocalization => $id_localization,
                        ];
                    }
                    $post['locales'] = $insert_locales;
                    $this->model->InsertBatchData($this->childTableDetail, $insert_locales);
                }

                $post_image = $_FILES;
                if ($post_image['thumbnail_image']['tmp_name']) {
                    if ($record['thumbnail_image'] != '' && file_exists(UPLOAD_DIR. $this->class_path_name. '/'.$record['thumbnail_image'])) {
                        unlink(UPLOAD_DIR. $this->class_path_name. '/'.$record['thumbnail_image']);
                        @unlink(UPLOAD_DIR. $this->class_path_name. '/tmb_'.$record['thumbnail_image']);
                        @unlink(UPLOAD_DIR. $this->class_path_name. '/sml_'.$record['thumbnail_image']);
                    }
                    $filename   = url_title($post['uri_path']. '-thumb', '_', true);
                    $picture_db = file_copy_to_folder($post_image['thumbnail_image'], UPLOAD_DIR. $this->class_path_name. '/', $filename);
                    copy_image_resize_to_folder(UPLOAD_DIR. $this->class_path_name. '/'.$picture_db, UPLOAD_DIR . $this->class_path_name. '/', 'tmb_'. $filename, IMG_DESTINATION_THUMB_WIDTH, IMG_DESTINATION_THUMB_HEIGHT, IMG_RESIZE_QUALITY);
                    copy_image_resize_to_folder(UPLOAD_DIR. $this->class_path_name. '/'.$picture_db, UPLOAD_DIR . $this->class_path_name. '/', 'sml_'. $filename, IMG_SMALL_WIDTH, IMG_SMALL_HEIGHT, IMG_RESIZE_QUALITY);
                    // update data
                    $this->model->UpdateData($this->mainTable, [$this->primaryKey => $id], ['thumbnail_image' => $picture_db]);
                }
                
                // insert to log
                $this->model->InsertLog('Category', 'Edit Category; ID: '.$id.'; Data: '.json_encode($post));

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
                        $record = $this->model->GetCategory($id);
                        if ($record) {
                            if ($this->model->GetIdentifier('cascading') == true) {
                                $this->model->UpdateData($this->childTableArticle, [$this->primaryKey => $id], ['is_delete' => 1]);
                            }
                            $this->model->DeleteData($this->mainTable, [$this->primaryKey => $id]);

                            // insert to log
                            $this->model->InsertLog('Delete Category', 'Delete Category; ID: '. $id. ';');

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
        $post = $this->input->post();
        $default_locale = get_localization(1);
        $rules = [
            [
                'field' => 'uri_path',
                'label' => 'SEO URL',
                'rules' => 'required'
            ],
        ];
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() === false) {
            $this->error = alert_box(validation_errors(), 'danger');

            return false;
        } else {
            $conditions = ['uri_path' => $post['uri_path']];
            if ($id) {
                $conditions = array_merge($conditions, ["{$this->primaryKey} !=", $id]);
            }
            if ( ! check_exists_value($this->mainTable, $conditions)) {
                $this->error = 'SEO URL is already used.';
            } else {
                foreach ($post['locales'] as $row => $local) {
                    if ($row == $default_locale[$this->foreignKeyLocalization] && $local['title'] == '') {
                        $this->error = 'Please insert Title.';

                        break;
                    }
                }
            }
            if ($this->error) {
                $this->error = alert_box($this->error, 'danger');

                return false;
                
            }
        }

        return true;
    }
}
/* End of file Category.php */
/* Destination: ./application/controllers/Category.php */