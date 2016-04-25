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
 */
class Pages extends CI_Controller
{
    /**
     * This show current class.
     *
     * @var string
     */
    private $class_path_name;

    /**
     * Error message/system.
     *
     * @var string
     */
    private $error;

    /**
     * Class contructor.
     * 
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pages_model');
        $this->class_path_name = $this->router->fetch_class();
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
            $count_all_records         = $this->Pages_model->CountAllData();
            $count_filtered_records    = $this->Pages_model->CountAllData($param);
            $records                   = $this->Pages_model->GetAllData($param);
            $return                    = [];
            $return['draw']            = $post['draw'];
            $return['recordsTotal']    = $count_all_records;
            $return['recordsFiltered'] = $count_filtered_records;
            $return['data']            = [];
            foreach ($records as $row => $record) {
                $return['data'][$row]['DT_RowId']         = $record['id'];
                $return['data'][$row]['actions']          = '<a href="'.site_url($this->class_path_name.'/edit/'.$record['id']).'" class="btn btn-sm btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                $return['data'][$row]['page_name']        = $record['page_name'];
                $return['data'][$row]['parent_page_name'] = ($record['parent_page_name'] != '') ? $record['parent_page_name'] : 'ROOT';
                $return['data'][$row]['url_link']         = ($record['page_type'] == 1) ? $record['uri_path'] : (($record['page_type'] == 2) ? $record['module'] : $record['ext_link']);
                $return['data'][$row]['status_text']      = ucfirst($record['status_text']);
                $return['data'][$row]['position']         = $record['position'];
                $return['data'][$row]['create_date']      = custDateFormat($record['create_date'], 'd M Y H:i:s');
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
        $this->data['page_title']   = 'Add';
        $this->data['form_action']  = site_url($this->class_path_name.'/add');
        $this->data['cancel_url']   = site_url($this->class_path_name);
        $this->data['locales']      = $this->Pages_model->GetLocalization();
        $this->data['statuses']     = $this->Pages_model->GetStatus();
        $menu_data                  = $this->Pages_model->MenusData();
        $this->data['max_position'] = $this->Pages_model->GetMaxPosition();
        $selected                   = '';
        if ($this->input->post()) {
            $post = $this->input->post();
            if ($this->validateForm()) {
                $post['is_featured'] = (isset($post['is_featured'])) ?: 0;
                $post['is_header']   = (isset($post['is_header'])) ?: 0;
                $post['is_footer']   = (isset($post['is_footer'])) ?: 0;
                if (isset($post['locales'])) {
                    $post_locales = $post['locales'];
                    unset($post['locales']);
                }
                if ($post['page_type'] == 1) {
                    unset(
                        $post['module'],
                        $post['ext_link']
                    );
                } elseif ($post['page_type'] == 2) {
                    unset(
                        $post['uri_path'],
                        $post['ext_link']
                    );
                } elseif ($post['page_type'] == 3) {
                    if ($post['ext_link'] != '#' && $post['ext_link'] != '') {
                        $post['ext_link'] = prep_url($post['ext_link']);
                    }
                    unset(
                        $post['uri_path'],
                        $post['module']
                    );
                }
                // insert data
                $id = $this->Pages_model->InsertRecord($post);

                // insert localization
                if ($id && isset($post_locales)) {
                    $insert_locales = array();
                    foreach ($post_locales as $id_localization => $post_local) {
                        $insert_locales[] = array(
                            'id_page'         => $id,
                            'title'           => $post_local['title'],
                            'teaser'          => $post_local['teaser'],
                            'description'     => $post_local['description'],
                            'id_localization' => $id_localization,
                        );
                    }
                    $post['locales'] = $insert_locales;
                    $this->Pages_model->InsertDetailRecord($insert_locales);
                }

                $post_image = $_FILES;
                if ($post_image['thumbnail_image']['tmp_name']) {
                    $filename   = url_title($post['page_name'].'-thumb', '_', true);
                    $picture_db = file_copy_to_folder($post_image['thumbnail_image'], UPLOAD_DIR. $this->class_path_name. '/', $filename);
                    copy_image_resize_to_folder(UPLOAD_DIR. $this->class_path_name. '/'.$picture_db, UPLOAD_DIR. $this->class_path_name. '/', 'tmb_'.$filename, IMG_THUMB_WIDTH, IMG_THUMB_HEIGHT);
                    copy_image_resize_to_folder(UPLOAD_DIR. $this->class_path_name. '/'.$picture_db, UPLOAD_DIR. $this->class_path_name. '/', 'sml_'.$filename, IMG_SMALL_WIDTH, IMG_SMALL_HEIGHT);
                    // update data
                    $this->Pages_model->UpdateRecord($id, ['thumbnail_image' => $picture_db]);
                }
                if ($post_image['primary_image']['tmp_name']) {
                    $filename   = url_title($post['page_name'], '_', true);
                    $picture_db = file_copy_to_folder($post_image['primary_image'], UPLOAD_DIR. $this->class_path_name. '/', $filename);
                    copy_image_resize_to_folder(UPLOAD_DIR. $this->class_path_name. '/'.$picture_db, UPLOAD_DIR. $this->class_path_name. '/', 'tmb_'.$filename, IMG_THUMB_WIDTH, IMG_THUMB_HEIGHT);
                    copy_image_resize_to_folder(UPLOAD_DIR. $this->class_path_name. '/'.$picture_db, UPLOAD_DIR. $this->class_path_name. '/', 'sml_'.$filename, IMG_SMALL_WIDTH, IMG_SMALL_HEIGHT);
                    // update data
                    $this->Pages_model->UpdateRecord($id, ['primary_image' => $picture_db]);
                }
                if ($post_image['background_image']['tmp_name']) {
                    $filename = url_title($post['page_name'].'-bg','_', true);
                    $picture_db = file_copy_to_folder($post_image['background_image'], UPLOAD_DIR. $this->class_path_name. '/', $filename);
                    copy_image_resize_to_folder(UPLOAD_DIR. $this->class_path_name. '/'.$picture_db, UPLOAD_DIR. $this->class_path_name. '/', 'tmb_'.$filename, IMG_THUMB_WIDTH, IMG_THUMB_HEIGHT);
                    copy_image_resize_to_folder(UPLOAD_DIR. $this->class_path_name. '/'.$picture_db, UPLOAD_DIR. $this->class_path_name. '/', 'sml_'.$filename, IMG_SMALL_WIDTH, IMG_SMALL_HEIGHT);
                    // update data
                    $this->Pages_model->UpdateRecord($id, ['background_image' => $picture_db]);
                }
                // insert to log
                $data_log = [
                    'id_user'  => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action'   => 'Pages',
                    'desc'     => 'Add Pages; ID: '.$id.'; Data: '.json_encode($post),
                ];
                insert_to_log($data_log);
                // end insert to log
                $this->session->set_flashdata('flash_message', alert_box('Success.', 'success'));

                redirect($this->class_path_name);
            }
            $selected           = $post['parent_page'];
            $this->data['post'] = $post;
        }
        $this->data['parent_html'] = $this->Pages_model->PrintMenu($menu_data, '', $selected);
        $this->data['template']    = $this->class_path_name.'/form';
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
        if (!$id) {
            redirect($this->class_path_name);
        }
        $record = $this->Pages_model->GetPages($id);
        if (!$record) {
            redirect($this->class_path_name);
        }
        $this->data['page_title']         = 'Edit';
        $this->data['form_action']        = site_url($this->class_path_name.'/edit/'.$id);
        $this->data['delete_picture_url'] = site_url($this->class_path_name.'/delete_picture/'.$id);
        $this->data['cancel_url']         = site_url($this->class_path_name);
        $this->data['locales']            = $this->Pages_model->GetLocalization();
        $this->data['statuses']           = $this->Pages_model->GetStatus();
        $disabled_menu                    = $this->Pages_model->MenusIdChildrenTaxonomy($id);
        $menu_data                        = $this->Pages_model->MenusData();
        $this->data['parent_html']        = $this->Pages_model->PrintMenu($menu_data,'',$record['parent_page'],$disabled_menu);
        if ($this->input->post()) {
            $post = $this->input->post();
            if ($this->validateForm($id)) {
                $post['modify_date'] = date('Y-m-d H:i:s');
                $post['is_featured'] = (isset($post['is_featured'])) ?: 0;
                $post['is_header']   = (isset($post['is_header'])) ?: 0;
                $post['is_footer']   = (isset($post['is_footer'])) ?: 0;
                if (isset($post['locales'])) {
                    $post_locales = $post['locales'];
                    unset($post['locales']);
                }
                if ($post['page_type'] == 1) {
                    $post['module']   = '';
                    $post['ext_link'] = '';
                } elseif ($post['page_type'] == 2) {
                    $post['uri_path'] = '';
                    $post['ext_link'] = '';
                } elseif ($post['page_type'] == 3) {
                    if ($post['ext_link'] != '#' && $post['ext_link'] != '') {
                        $post['ext_link'] = prep_url($post['ext_link']);
                    }
                    $post['uri_path'] = '';
                    $post['module']   = '';
                }
                // update data
                $this->Pages_model->UpdateRecord($id, $post);
                
                // delete/purge detail content before new insert
                $this->Pages_model->DeleteDetailRecordByID($id);
                if (isset($post_locales)) {
                    $insert_locales = array();
                    foreach ($post_locales as $id_localization => $post_local) {
                        $insert_locales[] = array(
                            'id_page'         => $id,
                            'title'           => $post_local['title'],
                            'teaser'          => $post_local['teaser'],
                            'description'     => $post_local['description'],
                            'id_localization' => $id_localization,
                        );
                    }
                    $post['locales'] = $insert_locales;
                    $this->Pages_model->InsertDetailRecord($insert_locales);
                }

                $post_image = $_FILES;
                if ($post_image['thumbnail_image']['tmp_name']) {
                    $filename = url_title($post['page_name'].'-thumb', '_', true);
                    if ($record['thumbnail_image'] != '' && file_exists(UPLOAD_DIR. $this->class_path_name. '/'.$record['thumbnail_image'])) {
                        unlink(UPLOAD_DIR. $this->class_path_name. '/'.$record['thumbnail_image']);
                        @unlink(UPLOAD_DIR. $this->class_path_name. '/tmb_'.$record['thumbnail_image']);
                        @unlink(UPLOAD_DIR. $this->class_path_name. '/sml_'.$record['thumbnail_image']);
                    }
                    $picture_db = file_copy_to_folder($post_image['thumbnail_image'], UPLOAD_DIR. $this->class_path_name. '/', $filename);
                    copy_image_resize_to_folder(UPLOAD_DIR. $this->class_path_name. '/'.$picture_db, UPLOAD_DIR. $this->class_path_name. '/', 'tmb_'.$filename, IMG_THUMB_WIDTH, IMG_THUMB_HEIGHT);
                    copy_image_resize_to_folder(UPLOAD_DIR. $this->class_path_name. '/'.$picture_db, UPLOAD_DIR. $this->class_path_name. '/', 'sml_'.$filename, IMG_SMALL_WIDTH, IMG_SMALL_HEIGHT);
                    // update data
                    $this->Pages_model->UpdateRecord($id, ['thumbnail_image' => $picture_db]);
                }
                if ($post_image['primary_image']['tmp_name']) {
                    $filename = url_title($post['page_name'], '_', true);
                    if ($record['primary_image'] != '' && file_exists(UPLOAD_DIR. $this->class_path_name. '/'.$record['primary_image'])) {
                        unlink(UPLOAD_DIR. $this->class_path_name. '/'.$record['primary_image']);
                        @unlink(UPLOAD_DIR. $this->class_path_name. '/tmb_'.$record['primary_image']);
                        @unlink(UPLOAD_DIR. $this->class_path_name. '/sml_'.$record['primary_image']);
                    }
                    $picture_db = file_copy_to_folder($post_image['primary_image'], UPLOAD_DIR. $this->class_path_name. '/', $filename);
                    copy_image_resize_to_folder(UPLOAD_DIR. $this->class_path_name. '/'.$picture_db, UPLOAD_DIR. $this->class_path_name. '/', 'tmb_'.$filename, IMG_THUMB_WIDTH, IMG_THUMB_HEIGHT);
                    copy_image_resize_to_folder(UPLOAD_DIR. $this->class_path_name. '/'.$picture_db, UPLOAD_DIR. $this->class_path_name. '/', 'sml_'.$filename, IMG_SMALL_WIDTH, IMG_SMALL_HEIGHT);
                    // update data
                    $this->Pages_model->UpdateRecord($id, ['primary_image' => $picture_db]);
                }
                if ($post_image['background_image']['tmp_name']) {
                    $filename = url_title($post['page_name'].'-bg', '_', true);
                    if ($record['background_image'] != '' && file_exists(UPLOAD_DIR. $this->class_path_name. '/'.$record['background_image'])) {
                        unlink(UPLOAD_DIR. $this->class_path_name. '/'.$record['background_image']);
                        @unlink(UPLOAD_DIR. $this->class_path_name. '/tmb_'.$record['background_image']);
                        @unlink(UPLOAD_DIR. $this->class_path_name. '/sml_'.$record['background_image']);
                    }
                    $picture_db = file_copy_to_folder($post_image['background_image'], UPLOAD_DIR. $this->class_path_name. '/', $filename);
                    copy_image_resize_to_folder(UPLOAD_DIR. $this->class_path_name. '/'.$picture_db, UPLOAD_DIR. $this->class_path_name. '/', 'tmb_'.$filename, IMG_THUMB_WIDTH, IMG_THUMB_HEIGHT);
                    copy_image_resize_to_folder(UPLOAD_DIR. $this->class_path_name. '/'.$picture_db, UPLOAD_DIR. $this->class_path_name. '/', 'sml_'.$filename, IMG_SMALL_WIDTH, IMG_SMALL_HEIGHT);
                    // update data
                    $this->Pages_model->UpdateRecord($id, ['background_image' => $picture_db]);
                }
                // insert to log
                $data_log = [
                    'id_user'  => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action'   => 'Pages',
                    'desc'     => 'Edit Pages; ID: '.$id.'; Data: '.json_encode($post),
                ];
                insert_to_log($data_log);
                // end insert to log
                $this->session->set_flashdata('flash_message', alert_box('Success.', 'success'));

                redirect($this->class_path_name);
            }
        }
        $this->data['template'] = $this->class_path_name.'/form';
        $this->data['post'] = $record;
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
                        $record = $this->Pages_model->GetPages($id);
                        if ($record) {
                            $this->Pages_model->DeleteRecord($id);
                            // insert to log
                            $data_log = [
                                'id_user'  => id_auth_user(),
                                'id_group' => id_auth_group(),
                                'action'   => 'Delete Pages',
                                'desc'     => 'Delete Pages; ID: '.$id.';',
                            ];
                            insert_to_log($data_log);
                            // end insert to log
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
     */
    public function delete_picture()
    {
        $this->layout = 'none';
        if ($this->input->post() && $this->input->is_ajax_request()) {
            $json = [];
            $post = $this->input->post();
            if (isset($post['id']) && $post['id'] > 0 && ctype_digit($post['id'])) {
                $detail = $this->Pages_model->GetPages($post['id']);
                $type = (isset($post['type'])) ? $post['type'] : 'primary';
                if ($detail && ($detail[$type.'_image'] != '')) {
                    $id = $post['id'];
                    unlink(UPLOAD_DIR. $this->class_path_name. '/'.$detail[$type.'_image']);
                    @unlink(UPLOAD_DIR. $this->class_path_name. '/tmb_'.$detail[$type.'_image']);
                    @unlink(UPLOAD_DIR. $this->class_path_name. '/sml_'.$detail[$type.'_image']);
                    // update data
                    $this->Pages_model->UpdateRecord($id, [$type.'_image' => '']);
                    $json['success'] = alert_box('File hase been deleted.', 'success');
                    // insert to log
                    $data_log = [
                        'id_user'  => id_auth_user(),
                        'id_group' => id_auth_group(),
                        'action'   => 'Pages',
                        'desc'     => 'Delete '.ucfirst($type).' Picture Pages; ID: '.$id.';',
                    ];
                    insert_to_log($data_log);
                    // end insert to log
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
        $post = $this->input->post();
        $rules = [
            [
                'field' => 'parent_page',
                'label' => 'Parent',
                'rules' => 'required',
            ],
            [
                'field' => 'page_name',
                'label' => 'Title',
                'rules' => 'required',
            ],
            [
                'field' => 'page_type',
                'label' => 'Page Type',
                'rules' => 'required',
            ],
            [
                'field' => 'id_status',
                'label' => 'Status',
                'rules' => 'required',
            ],
        ];
        if ($post['page_type'] == 2) {
            array_push($rules, [
                    'field' => 'module',
                    'label' => 'Module',
                    'rules' => 'required',
            ]);
        } elseif ($post['page_type'] == 3) {
            array_push($rules, [
                    'field' => 'ext_link',
                    'label' => 'External URL',
                    'rules' => 'required',
            ]);
        }
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() === false) {
            $this->error = alert_box(validation_errors(), 'danger');

            return false;
        } else {
            // static content
            if ($post['page_type'] == 1) {
                if ($post['uri_path'] == '') {
                    $this->error = 'Please Input SEO URL';
                } else {
                    if ( ! check_exist_uri('pages', $post['uri_path'], $id)) {
                        $this->error = 'SEO URL is already used.';
                    }
                }
            }
            $post_image = $_FILES;
            if ( ! $this->error) {
                if (!empty($post_image['thumbnail_image']['tmp_name'])) {
                    $check_picture = validatePicture('thumbnail_image');
                    if (!empty($check_picture)) {
                        $this->error = alert_box($check_picture, 'danger');

                        return false;
                    }
                }
                if (!empty($post_image['primary_image']['tmp_name'])) {
                    $check_picture = validatePicture('primary_image');
                    if (!empty($check_picture)) {
                        $this->error = alert_box($check_picture, 'danger');

                        return false;
                    }
                }
                if (!empty($post_image['background_image']['tmp_name'])) {
                    $check_picture = validatePicture('background_image');
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
/* End of file Pages.php */
/* Location: ./application/controllers/Pages.php */
