<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Article Class.
 * 
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * 
 * @version 3.0
 * 
 * @category Controller
 * 
 */
class Article extends CI_Controller 
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
     * Parent table from this controller.
     * 
     * @var string
     */
    private $parentCategoryTable;

    /**
     * Parent key from this controller.
     * 
     * @var string
     */
    private $parentCategoryKey;

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
    public function __construct() 
    {
        parent::__construct();

        $this->load->model('Article_model', 'model');

        $this->class_path_name        = $this->router->fetch_class();
        $this->mainTable              = $this->model->GetIdentifier('table');
        $this->primaryKey             = $this->model->GetIdentifier('primaryKey');
        $this->childTableDetail       = $this->model->GetIdentifier('child_table_detail');
        $this->foreignKeyLocalization = $this->model->GetIdentifier('foreign_key_localization');
        $this->foreignKeyStatus       = $this->model->GetIdentifier('foreign_key_status');
        $this->parentCategoryTable    = $this->model->GetIdentifier('parent_table_category');
        $this->parentCategoryKey      = $this->model->GetIdentifier('parent_key_category');

        $this->post_data = array_filtered(
            $this->input->post(), [
                $this->parentCategoryKey,
                'publish_date',
                'expire_date',
                'uri_path',
                'id_status',
                'is_featured',
                'locales',
                'forever',
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
                $return['data'][$row]['DT_RowId']      = $record['id'];
                $return['data'][$row]['actions']       = '<a href="'. site_url($this->class_path_name. '/edit/'. $record['id']). '" class="btn btn-sm btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                $return['data'][$row]['title']         = $record['title'];
                $return['data'][$row]['category_name'] = $record['category_name'];
                $return['data'][$row]['publish_date']  = ($record['publish_date'] != '') ? custom_date_format($record['publish_date'], 'd M Y') : '-';
                $return['data'][$row]['status_text']   = $record['status_text'];
                $return['data'][$row]['create_date']   = custom_date_format($record['create_date'], 'd M Y H:i:s');
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
        $this->data['statuses']    = get_status();
        $this->data['categories']  = $this->model->GetCategories();
        if ($this->input->post()) {
            $post = $this->post_data;
            if ($this->validateForm()) {
                if (isset($post['locales'])) {
                    $post_locales = $post['locales'];
                    unset($post['locales']);
                }
                $post['is_featured'] = (isset($post['is_featured'])) ?: 0;
                $post['expire_date'] = (isset($post['forever'])) ? NULL : $post['expire_date'];
                unset($post['forever']);
                
                // insert data
                $id = $this->model->InsertData($this->mainTable, $post);

                if ($id && isset($post_locales)) {
                    $insert_locales = [];
                    foreach ($post_locales as $id_localization => $post_local) {
                        $insert_locales[] = [
                            $this->primaryKey             => $id,
                            'title'                       => $post_local['title'],
                            'teaser'                      => $post_local['teaser'],
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
                    copy_image_resize_to_folder(UPLOAD_DIR. $this->class_path_name. '/'.$picture_db, UPLOAD_DIR . $this->class_path_name. '/', 'tmb_'. $filename, IMG_ARTICLE_THUMB_WIDTH, IMG_ARTICLE_THUMB_HEIGHT, IMG_RESIZE_QUALITY);
                    copy_image_resize_to_folder(UPLOAD_DIR. $this->class_path_name. '/'.$picture_db, UPLOAD_DIR . $this->class_path_name. '/', 'sml_'. $filename, IMG_SMALL_WIDTH, IMG_SMALL_HEIGHT, IMG_RESIZE_QUALITY);
                    // update data
                    $this->model->UpdateData($this->mainTable, [$this->primaryKey => $id], ['thumbnail_image' => $picture_db]);
                }
                if ($post_image['primary_image']['tmp_name']) {
                    $filename   = url_title($post['uri_path'], '_', true);
                    $picture_db = file_copy_to_folder($post_image['primary_image'], UPLOAD_DIR. $this->class_path_name. '/', $filename);
                    copy_image_resize_to_folder(UPLOAD_DIR. $this->class_path_name. '/'.$picture_db, UPLOAD_DIR . $this->class_path_name. '/', 'tmb_'. $filename, IMG_ARTICLE_PRIMARY_WIDTH, IMG_ARTICLE_PRIMARY_HEIGHT);
                    copy_image_resize_to_folder(UPLOAD_DIR. $this->class_path_name. '/'.$picture_db, UPLOAD_DIR . $this->class_path_name. '/', 'sml_'. $filename, IMG_SMALL_WIDTH, IMG_SMALL_HEIGHT);
                    // update data
                    $this->model->UpdateData($this->mainTable, [$this->primaryKey => $id], ['primary_image' => $picture_db]);
                }
                // insert to log
                $this->model->InsertLog('Article', 'Add Article; ID: '.$id.'; Data: '.json_encode($post));
                
                $this->session->set_flashdata('flash_message', alert_box('Success.','success'));
                
                redirect($this->class_path_name);
            }
            $this->data['post'] = $post;
        }
        $this->data['template'] = $this->class_path_name. '/form';
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
        $record = $this->model->GetArticle($id);
        if ( ! $record) {
            redirect($this->class_path_name);
        }
        $this->data['page_title']         = 'Edit';
        $this->data['form_action']        = site_url($this->class_path_name.'/edit/'.$id);
        $this->data['delete_picture_url'] = site_url($this->class_path_name.'/delete_picture/'.$id);
        $this->data['cancel_url']         = site_url($this->class_path_name);
        $this->data['locales']            = get_localization();
        $this->data['statuses']           = get_status();
        $this->data['categories']         = $this->model->GetCategories();
        $this->data['post'] = $record;
        if ($this->input->post()) {
            $post = $this->post_data;
            if ($this->validateForm($id)) {
                if (isset($post['locales'])) {
                    $post_locales = $post['locales'];
                    unset($post['locales']);
                }
                $post['modify_date'] = date('Y-m-d H:i:s');
                $post['is_featured'] = (isset($post['is_featured'])) ?: 0;
                $post['expire_date'] = (isset($post['forever'])) ? NULL : $post['expire_date'];
                unset($post['forever']);
                
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
                            'teaser'                      => $post_local['teaser'],
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
                    $filename   = url_title($post['uri_path'].'-thumb', '_', true);
                    $picture_db = file_copy_to_folder($post_image['thumbnail_image'], UPLOAD_DIR. $this->class_path_name. '/', $filename);
                    copy_image_resize_to_folder(UPLOAD_DIR. $this->class_path_name. '/'.$picture_db, UPLOAD_DIR. $this->class_path_name. '/', 'tmb_'.$filename, IMG_ARTICLE_THUMB_WIDTH, IMG_ARTICLE_THUMB_HEIGHT, IMG_RESIZE_QUALITY);
                    copy_image_resize_to_folder(UPLOAD_DIR. $this->class_path_name. '/'.$picture_db, UPLOAD_DIR. $this->class_path_name. '/', 'sml_'.$filename, IMG_SMALL_WIDTH, IMG_SMALL_HEIGHT, IMG_RESIZE_QUALITY);
                    // update data
                    $this->model->UpdateData($this->mainTable, [$this->primaryKey => $id], ['thumbnail_image' => $picture_db]);
                }
                if ($post_image['primary_image']['tmp_name']) {
                    if ($record['primary_image'] != '' && file_exists(UPLOAD_DIR. $this->class_path_name. '/'.$record['primary_image'])) {
                        unlink(UPLOAD_DIR. $this->class_path_name. '/'.$record['primary_image']);
                        @unlink(UPLOAD_DIR. $this->class_path_name. '/tmb_'.$record['primary_image']);
                        @unlink(UPLOAD_DIR. $this->class_path_name. '/sml_'.$record['primary_image']);
                    }
                    $filename   = url_title($post['uri_path'],'_',true);
                    $picture_db = file_copy_to_folder($post_image['primary_image'], UPLOAD_DIR. $this->class_path_name. '/', $filename);
                    copy_image_resize_to_folder(UPLOAD_DIR. $this->class_path_name. '/'.$picture_db, UPLOAD_DIR. $this->class_path_name. '/', 'tmb_'.$filename, IMG_ARTICLE_PRIMARY_WIDTH, IMG_ARTICLE_PRIMARY_HEIGHT);
                    copy_image_resize_to_folder(UPLOAD_DIR. $this->class_path_name. '/'.$picture_db, UPLOAD_DIR. $this->class_path_name. '/', 'sml_'.$filename, IMG_SMALL_WIDTH, IMG_SMALL_HEIGHT);
                    // update data
                    $this->model->UpdateData($this->mainTable, [$this->primaryKey => $id], ['primary_image' => $picture_db]);
                }
                // insert to log
                $this->model->InsertLog('Article', 'Edit Article; ID: '.$id.'; Data: '.json_encode($post));

                $this->session->set_flashdata('flash_message', alert_box('Success.','success'));
                
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
                        $record = $this->model->GetArticle($id);
                        if ($record) {
                            // update or set status to delete instead of delete the record
                            $this->model->UpdateData($this->mainTable, [$this->primaryKey => $id], ['is_delete' => 1]);

                            // insert to log
                            $this->model->InsertLog('Article', 'Delete Article; ID: '.$id.';');

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
                $detail = $this->model->GetArticle($post['id']);
                $type   = (isset($post['type'])) ? $post['type'] : 'primary';
                $id = $post['id'];
                if ($detail && ($detail[$type. '_image'] != '')) {
                    unlink(UPLOAD_DIR. $this->class_path_name. '/'.$detail[$type.'_image']);
                    @unlink(UPLOAD_DIR. $this->class_path_name. '/tmb_'.$detail[$type.'_image']);
                    @unlink(UPLOAD_DIR. $this->class_path_name. '/sml_'.$detail[$type.'_image']);
                    $data_update = [$type. '_image' => ''];

                    // update data
                    $this->model->UpdateData($this->mainTable, [$this->primaryKey => $id], $data_update);

                    // insert to log
                    $this->model->InsertLog('Article', 'Delete '. ucfirst($type). ' Picture Article; ID: '. $id. ';');

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
     * @return boolean
     */
    private function validateForm($id = 0) 
    {
        $post  = $this->post_data;
        $default_locale = get_localization(1);
        $rules = [
            [
                'field' => 'publish_date',
                'label' => 'Publish Date',
                'rules' => 'required'
            ],
            [
                'field' => 'uri_path',
                'label' => 'SEO URL',
                'rules' => 'required'
            ],
            [
                'field' => $this->foreignKeyStatus,
                'label' => 'Status',
                'rules' => 'required'
            ],
            [
                'field' => $this->parentCategoryKey,
                'label' => 'Category',
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
            if ( ! isset($post['forever']) && $post['expire_date'] == '') {
                $this->error = 'Please input End Date.';
            }
            $post_image = $_FILES;
            if (!$this->error) {
                if (!empty($post_image['thumbnail_image']['tmp_name'])) {
                    $check_picture = validate_picture('thumbnail_image');
                    if (!empty($check_picture)) {
                        $this->error = alert_box($check_picture, 'danger');

                        return false;
                    }
                }
                if (!empty($post_image['primary_image']['tmp_name'])) {
                    $check_picture = validate_picture('primary_image');
                    if (!empty($check_picture)) {
                        $this->error = alert_box($check_picture, 'danger');

                        return false;
                    }
                }

                return true;
            }
            $this->error = alert_box($this->error, 'danger');

            return false;
        }
    }
}
/* End of file Article.php */
/* Location: ./application/controllers/Article.php */