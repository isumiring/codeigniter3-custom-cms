<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Admin Class.
 *
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 *
 * @version 3.0
 *
 * @category Controller
 * 
 */
class Admin extends CI_Controller
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
    protected $foreignTableGroup;

    /**
     * Foreign Key from table for this controller.
     *
     * @var string
     */
    protected $foreignKeyGroup;

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
        $this->load->model('Admin_model', 'model');

        $this->class_path_name   = $this->router->fetch_class();
        $this->mainTable         = $this->model->GetIdentifier('table');
        $this->primaryKey        = $this->model->GetIdentifier('primaryKey');
        $this->foreignTableGroup = $this->model->GetIdentifier('foreign_table_group');
        $this->foreignKeyGroup   = $this->model->GetIdentifier('foreign_key_group');

        $this->post_data = array_filtered(
            $this->input->post(), [
                'id_auth_group',
                'username',
                'password',
                'name',
                'email',
                'address',
                'phone',
                'status',
                'is_superadmin',
                'themes',
            ]
        );
    }

    /**
     * Index page.
     * 
     */
    public function index()
    {
        $this->data['add_url']        = site_url($this->class_path_name. '/add');
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
                $return['data'][$row]['DT_RowId']    = $record['id'];
                $return['data'][$row]['actions']     = '<a href="'. site_url($this->class_path_name. '/edit/'. $record['id']). '" class="btn btn-sm btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                $return['data'][$row]['username']    = $record['username'];
                $return['data'][$row]['name']        = $record['name'];
                $return['data'][$row]['email']       = $record['email'];
                $return['data'][$row]['auth_group']  = $record['auth_group'];
                $return['data'][$row]['create_date'] = custom_date_format($record['create_date'], 'd M Y H:i:s');
            }
            json_exit($return);
        }
        redirect($this->class_path_name);
    }

    /**
     * Add page.
     *
     * @return string layout page
     */
    public function add()
    {
        $this->data['groups']      = $this->model->GetGroups();
        $this->data['page_title']  = 'Add';
        $this->data['form_action'] = site_url($this->class_path_name. '/add');
        $this->data['cancel_url']  = site_url($this->class_path_name);
        $this->data['themes']      = get_enum_values($this->mainTable, 'themes');
        if ($this->input->post()) {
            $post = $this->post_data;
            if ($this->validateForm()) {
                $post['status']        = (isset($post['status']) && $post['status'] != '') ?: 0;
                $post['is_superadmin'] = (isset($post['is_superadmin']) && $post['is_superadmin'] != '') ?: 0;
                $post['email']         = strtolower($post['email']);
                $post['userpass']      = generate_password($post['password']);
                unset(
                    $post['password'],
                    $post['conf_password']
                );

                // update data
                $id = $this->model->InsertData($this->mainTable, $post);
                unset($post['userpass']);
                $post_image = $_FILES;
                if ($post_image['image']['tmp_name']) {
                    $filename   = 'adm_'. url_title($post['username'], '_', true). md5plus($id);
                    $picture_db = file_copy_to_folder($post_image['image'], UPLOAD_DIR. $this->class_path_name. '/', $filename);
                    copy_image_resize_to_folder(UPLOAD_DIR. $this->class_path_name. '/'. $picture_db, UPLOAD_DIR. $this->class_path_name. '/', 'tmb_'. $filename, IMG_THUMB_WIDTH, IMG_THUMB_HEIGHT, IMG_RESIZE_QUALITY);
                    copy_image_resize_to_folder(UPLOAD_DIR. $this->class_path_name. '/'. $picture_db, UPLOAD_DIR. $this->class_path_name. '/', 'sml_'. $filename, IMG_SMALL_WIDTH, IMG_SMALL_HEIGHT, IMG_RESIZE_QUALITY);
                    // update data
                    $this->model->UpdateRecord($this->mainTable, 
                        [
                            $this->primaryKey => $id
                        ], 
                        [
                            'image' => $picture_db
                        ]
                    );
                }
                // insert to log
                $this->model->InsertLog('User Admin', 'Add User Admin; ID: '. $id. '; Data: '. json_encode($post));

                $this->session->set_flashdata('flash_message', alert_box('Success.', 'success'));

                redirect($this->class_path_name);
            }
            $this->data['post'] = $post;
        }
        $this->data['template'] = 'admin/form';
        if (isset($this->error)) {
            $this->data['form_message'] = $this->error;
        }
    }

    /**
     * Detail/Edit Page.
     *
     * @param int $id
     *
     * @return string layout
     */
    public function edit($id = 0)
    {
        if (!$id) {
            redirect($this->class_path_name);
        }
        $record = $this->model->GetAdmin($id);
        if (!$record) {
            redirect($this->class_path_name);
        }
        if ($record['is_superadmin'] == 1 && !is_superadmin()) {
            $this->session->set_flashdata('flash_message', alert_box('You don\'t have rights to manage this record. Please contact Your Administrator', 'danger'));
            redirect($this->class_path_name);
        }
        $this->data['groups']             = $this->model->GetGroups();
        $this->data['page_title']         = 'Edit';
        $this->data['form_action']        = site_url($this->class_path_name. '/edit/'. $id);
        $this->data['delete_picture_url'] = site_url($this->class_path_name. '/delete_picture/'. $id);
        $this->data['cancel_url']         = site_url($this->class_path_name);
        $this->data['themes']             = get_enum_values($this->mainTable, 'themes');
        $this->data['post'] = $record;
        if ($this->input->post()) {
            $post = $this->post_data;
            if ($this->validateForm($id)) {
                $post['modify_date']   = date('Y-m-d H:i:s');
                $post['status']        = (isset($post['status']) && $post['status'] != '') ?: 0;
                $post['is_superadmin'] = (isset($post['is_superadmin']) && $post['is_superadmin'] != '') ?: 0;
                $post['email']         = strtolower($post['email']);

                if ($post['password'] != '') {
                    $post['userpass'] = generate_password($post['password']);
                }
                unset(
                    $post['password'],
                    $post['conf_password']
                );

                // update data
                $this->model->UpdateData($this->mainTable, [
                        $this->primaryKey => $id
                    ], 
                    $post
                );
                unset($post['userpass']);
                // now change session if user is edit themselve
                if (id_auth_user() == $id) {
                    $user_session                        = $_SESSION['ADM_SESS'];
                    $user_session['admin_name']          = $post['name'];
                    $user_session['admin_id_auth_group'] = $post[$this->foreignKeyGroup];
                    $user_session['admin_email']         = strtolower($post['email']);
                    $_SESSION['ADM_SESS']                = $user_session;
                }
                $post_image = $_FILES;
                if ($post_image['image']['tmp_name']) {
                    if ($record['image'] != '' && file_exists(UPLOAD_DIR. $this->class_path_name. '/'. $record['image'])) {
                        unlink(UPLOAD_DIR. $this->class_path_name. '/'. $record['image']);
                        @unlink(UPLOAD_DIR. $this->class_path_name. '/tmb_'. $record['image']);
                        @unlink(UPLOAD_DIR. $this->class_path_name. '/sml_'. $record['image']);
                    }
                    $filename   = 'adm_'. url_title($post['name'], '_', true). md5plus($id);
                    $picture_db = file_copy_to_folder($post_image['image'], UPLOAD_DIR. $this->class_path_name. '/', $filename);
                    copy_image_resize_to_folder(UPLOAD_DIR. $this->class_path_name. '/'. $picture_db, UPLOAD_DIR. $this->class_path_name. '/', 'tmb_'.$filename, IMG_THUMB_WIDTH, IMG_THUMB_HEIGHT, IMG_RESIZE_QUALITY);
                    copy_image_resize_to_folder(UPLOAD_DIR. $this->class_path_name. '/'. $picture_db, UPLOAD_DIR. $this->class_path_name. '/', 'sml_'.$filename, IMG_SMALL_WIDTH, IMG_SMALL_HEIGHT, IMG_RESIZE_QUALITY);
                    // update data
                    $this->model->UpdateData($this->mainTable, 
                        [
                            $this->primaryKey => $id
                        ], 
                        [
                            'image' => $picture_db
                        ]
                    );
                }
                // insert to log
                $this->model->InsertLog('User Admin', 'Edit User Admin; ID: '. $id. '; Data: '.json_encode($post));

                $this->session->set_flashdata('flash_message', alert_box('Success.', 'success'));

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
     * Delete page.
     *
     * @return json $json
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
                        $record = $this->model->GetAdmin($id);
                        if ($record) {
                            if ($id == id_auth_user()) {
                                $json['error'] = alert_box('You can\'t delete Your own account.', 'danger');
                                break;
                            } else {
                                if (is_superadmin()) {
                                    if ($record['image'] != '' && file_exists(UPLOAD_DIR. $this->class_path_name. '/'.$record['image'])) {
                                        unlink(UPLOAD_DIR. $this->class_path_name. '/'. $record['image']);
                                        @unlink(UPLOAD_DIR. $this->class_path_name. '/tmb_'. $record['image']);
                                        @unlink(UPLOAD_DIR. $this->class_path_name. '/sml_'. $record['image']);
                                    }
                                    $this->model->DeleteData($this->mainTable, [$this->primaryKey => $id]);

                                    // insert to log
                                    $this->model->InsertLog('User Admin', 'Delete User Admin; ID: '. $id. ';');
                                    
                                    $json['success'] = alert_box('Data has been deleted', 'success');
                                    $this->session->set_flashdata('flash_message', $json['success']);
                                } else {
                                    $json['error'] = alert_box('You don\'t have permission to delete this record(s). Please contact the Administrator.', 'danger');
                                    break;
                                }
                            }
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
     * Delete Picture.
     *
     * @return json $json
     */
    public function delete_picture()
    {
        $this->layout = 'none';
        if ($this->input->post() && $this->input->is_ajax_request()) {
            $json = [];
            $post = $this->input->post();
            if (isset($post['id']) && $post['id'] > 0 && ctype_digit($post['id'])) {
                $detail = $this->model->GetAdmin($post['id']);
                if ($detail && $detail['image'] != '') {
                    $id = $post['id'];
                    unlink(UPLOAD_DIR. $this->class_path_name. '/'. $detail['image']);
                    @unlink(UPLOAD_DIR. $this->class_path_name. '/tmb_'. $detail['image']);
                    @unlink(UPLOAD_DIR. $this->class_path_name. '/sml_'. $detail['image']);

                    $data_update = ['image' => ''];
                    $this->model->UpdateData($this->mainTable, [$this->primaryKey => $post['id']], $data_update);

                    // insert to log
                    $this->model->InsertLog('User Admin', 'Delete Picture User Admin; ID: '. $id. ';');
                    
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
     * Validate Form.
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
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'required|min_length[3]|max_length[32]|alpha_dash|callback_check_username_exists['. $id. ']',
            ],
            [
                'field' => 'id_auth_group',
                'label' => 'Group',
                'rules' => 'required|is_natural_no_zero',
            ],
            [
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required|alpha_numeric_spaces',
            ],
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required|valid_email|callback_check_email_exists['. $id. ']',
            ],
        ];
        if ( ! $id) {
            array_push($rules, 
                [
                    'field' => 'password',
                    'label' => 'Password',
                    'rules' => 'required|min_length[8]',
                ],
                [
                    'field' => 'conf_password',
                    'label' => 'Password Confirmation',
                    'rules' => 'required|matches[password]',
                ]);
        } else {
            if (strlen($post['password']) > 0) {
                array_push($rules, 
                    [
                        'field' => 'password',
                        'label' => 'Password',
                        'rules' => 'min_length[8]',
                    ],
                    [
                        'field' => 'conf_password',
                        'label' => 'Password Confirmation',
                        'rules' => 'required|matches[password]',
                    ]);
            }
        }
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() === false) {
            $this->error = alert_box(validation_errors(), 'danger');

            return false;
        } else {
            $post_image = $_FILES;
            if (!$this->error) {
                if ( ! empty($post_image['image']['tmp_name'])) {
                    $check_picture = validate_picture('image');
                    if ( ! empty($check_picture)) {
                        $this->error = alert_box($check_picture, 'danger');

                        return false;
                    }
                }

                return true;
            } else {
                $this->error = alert_box($this->error, 'danger');

                return false;
            }
        }
    }

    /**
     * Form validation check email exist.
     *
     * @param string $string
     * @param int    $id
     *
     * @return bool
     */
    public function check_email_exists($string, $id = 0)
    {
        $conditions = [
            'email' => $string
        ];
        if ($id) {
            $conditions = array_merge($conditions, ["{$this->primaryKey} !=" => $id]);
        }
        if ( ! check_exists_value($this->mainTable, $conditions)) {
            $this->form_validation->set_message('check_email_exists', '{field} is already exists. Please use different {field}');

            return false;
        }

        return true;
    }

    /**
     * Form validation check username exist.
     *
     * @param string $string
     * @param int    $id
     *
     * @return bool
     */
    public function check_username_exists($string, $id = 0)
    {
        $conditions = [
            'username' => $string
        ];
        if ($id) {
            $conditions = array_merge($conditions, ["{$this->primaryKey} !=" => $id]);
        }
        if ( ! check_exists_value($this->mainTable, $conditions)) {
            $this->form_validation->set_message('check_username_exists', '{field} is already exists. Please use different {field}');

            return false;
        }

        return true;
    }
}
/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */
