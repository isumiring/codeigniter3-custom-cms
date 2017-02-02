<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Group Class.
 *
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 *
 * @version 3.0
 *
 * @category Controller
 */
class Group extends CI_Controller
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
    protected $foreignTableMenuGroup;

    /**
     * Foreign key for this controller.
     *
     * @var string
     */
    protected $foreignKeyMenu;

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
        $this->load->model('Group_model', 'model');

        $this->class_path_name       = $this->router->fetch_class();
        $this->mainTable             = $this->model->GetIdentifier('table');
        $this->primaryKey            = $this->model->GetIdentifier('primaryKey');
        $this->foreignTableMenuGroup = $this->model->GetIdentifier('foreign_table_menu_group');
        $this->foreignKeyMenu        = $this->model->GetIdentifier('foreign_key_menu');

        $this->post_data = array_filtered(
            $this->input->post(), [
                'auth_group',
                'is_superadmin'
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
                $return['data'][$row]['DT_RowId']      = $record['id'];
                $return['data'][$row]['actions']       = '<a href="'.site_url($this->class_path_name. '/edit/'. $record['id']). '" class="btn btn-sm btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                $return['data'][$row]['auth_group']    = $record['auth_group'];
                $return['data'][$row]['authorization'] = '<a href="'. site_url($this->class_path_name. '/authorization/'. $record['id']). '" class="btn btn-sm btn-primary">Auth</a>';
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
        $this->data['page_title']  = 'Add';
        $this->data['form_action'] = site_url($this->class_path_name. '/add');
        $this->data['cancel_url']  = site_url($this->class_path_name);
        if ($this->input->post()) {
            $post = $this->post_data;
            if ($this->validateForm()) {
                $post['is_superadmin'] = (isset($post['is_superadmin']) && $post['is_superadmin'] != '') ?: 0;

                // insert data
                $id = $this->model->InsertData($this->mainTable, $post);

                // insert to log
                $this->model->InsertLog('Group Admin', 'Add Group Admin; ID: '.$id.'; Data: '.json_encode($post));

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
        if (!$id) {
            redirect($this->class_path_name);
        }
        $record = $this->model->GetGroup($id);
        if (!$record) {
            redirect($this->class_path_name);
        }
        if ($record['is_superadmin'] == 1 && ! is_superadmin()) {
            $this->session->set_flashdata('flash_message', alert_box('You don\'t have rights to manage this record. Please contact Your Administrator', 'danger'));
            redirect($this->class_path_name);
        }
        $this->data['page_title']  = 'Edit';
        $this->data['form_action'] = site_url($this->class_path_name.'/edit/'.$id);
        $this->data['cancel_url']  = site_url($this->class_path_name);
        $this->data['post'] = $record;
        if ($this->input->post()) {
            $post = $this->post_data;
            if ($this->validateForm($id)) {
                $post['is_superadmin'] = (isset($post['is_superadmin']) && $post['is_superadmin'] != '') ?: 0;
                // update data
                $this->model->UpdateData($this->mainTable, [$this->primaryKey => $id], $post);

                // insert to log
                $this->model->InsertLog('Admin Group', 'Edit Admin Group; ID: '.$id.'; Data: '.json_encode($post));

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
     * Set authentication page.
     *
     * @param int $id
     */
    public function authorization($id = 0)
    {
        $id = (int) $id;
        if ( ! $id) {
            redirect($this->class_path_name);
        }
        $this->data['form_action'] = site_url($this->class_path_name. '/authorization/'. $id);
        $this->data['cancel_url']  = site_url($this->class_path_name);
        $record                    = $this->model->GetGroup($id);
        if ( ! $record) {
            redirect($this->class_path_name);
        }
        $this->data['page_title']     = 'Auth: '.$record['auth_group'];
        $menu_data                    = $this->model->MenusData($record[$this->primaryKey]);
        $this->data['auth_menu_html'] = $this->model->PrintAuthMenu($menu_data);

        if ($this->input->post()) {
            $post = array_filtered(
                $this->input->post(), ['auth_menu_group']
            );
            // update data auth
            // let's delete/clean the data before make a new insert
            $this->model->DeleteData($this->foreignTableMenuGroup, [$this->primaryKey => $id]);
            $insert = [];
            foreach ($post[$this->foreignTableMenuGroup] as $row => $val) {
                $insert[$row][$this->primaryKey]     = $id;
                $insert[$row][$this->foreignKeyMenu] = $val;
            }
            // insert data
            if (isset($insert) && count($insert) > 0) {
                $this->model->InsertBatchData($this->foreignTableMenuGroup, $insert);
            }

            // insert to log
            $this->model->InsertLog('Admin Group', 'Edit Admin Group Authentication; ID: '. $id. '; Data: '. json_encode($post));

            $this->session->set_flashdata('flash_message', alert_box('Success.', 'success'));

            redirect($this->class_path_name);
        }
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
                        $record = $this->model->GetGroup($id);
                        if ($record) {
                            if ($id == id_auth_group()) {
                                $json['error'] = alert_box('You can\'t delete Your own group.', 'danger');
                                break;
                            } else {
                                if (is_superadmin()) {
                                    $this->model->DeleteData($this->mainTable, [$this->primaryKey => $id]);
                                    // insert to log
                                    $this->model->InsertLog('Delete User Group', 'Delete User Group; ID: '.$id.';');

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
                'field' => 'auth_group',
                'label' => 'Group Name',
                'rules' => 'required|min_length[3]|max_length[32]',
            ],
        ];
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() === false) {
            $this->error = alert_box(validation_errors(), 'danger');

            return false;
        }

        return true;
    }
}
/* End of file Group.php */
/* Location: ./application/controllers/Group.php */
