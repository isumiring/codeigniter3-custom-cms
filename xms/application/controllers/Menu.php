<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Menu Class.
 *
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 *
 * @version 3.0
 *
 * @category Controller
 */
class Menu extends CI_Controller
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
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Menu_model');
        $this->class_path_name = $this->router->fetch_class();
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
            $count_all_records         = $this->Menu_model->CountAllMenu();
            $count_filtered_records    = $this->Menu_model->CountAllMenu($param);
            $records                   = $this->Menu_model->GetAllMenuData($param);
            $return                    = [];
            $return['draw']            = $post['draw'];
            $return['recordsTotal']    = $count_all_records;
            $return['recordsFiltered'] = $count_filtered_records;
            $return['data']            = [];
            foreach ($records as $row => $record) {
                $return['data'][$row]['DT_RowId']    = $record['id'];
                $return['data'][$row]['actions']     = '<a href="'.site_url($this->class_path_name.'/edit/'.$record['id']).'" class="btn btn-sm btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                $return['data'][$row]['menu']        = $record['menu'];
                $return['data'][$row]['parent_menu'] = ($record['parent_menu'] != '') ? $record['parent_menu'] : 'ROOT';
                $return['data'][$row]['position']    = $record['position'];
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
        $menu_data                  = $this->Menu_model->MenusData();
        $selected                   = '';
        $this->data['max_position'] = $this->Menu_model->MaxPosition() + 1;
        if ($this->input->post()) {
            $post = $this->input->post();
            if ($this->validateForm()) {
                $post['is_superadmin'] = (isset($post['is_superadmin'])) ?: 0;
                $post['file']          = strtolower($post['file']);

                // insert data
                $id = $this->Menu_model->InsertRecord($post);

                // for development only. otherwise, disable this method
                if (ENVIRONMENT == 'development' && is_superadmin()) {
                    $insert_auth = [
                        'id_auth_group' => id_auth_group(),
                        'id_auth_menu'  => $id,
                    ];
                    $this->Menu_model->InsertAuth($insert_auth);
                }

                // insert to log
                $data_log = [
                    'id_user'  => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action'   => 'Menu Admin',
                    'desc'     => 'Add Menu Admin; ID: '.$id.'; Data: '.json_encode($post),
                ];
                insert_to_log($data_log);
                // end insert to log
                $this->session->set_flashdata('flash_message', alert_box('Success.', 'success'));

                redirect($this->class_path_name);
            }
            $selected           = $post['parent_auth_menu'];
            $this->data['post'] = $post;
        }
        $this->data['auth_menu_html'] = $this->Menu_model->PrintAuthMenu($menu_data, '', $selected);
        $this->data['template']       = $this->class_path_name.'/form';
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
        $record = $this->Menu_model->GetMenu($id);
        if ( ! $record) {
            redirect($this->class_path_name);
        }
        if ($record['is_superadmin'] == 1 && ! is_superadmin()) {
            $this->session->set_flashdata('flash_message', alert_box('You don\'t have rights to manage this record. Please contact Your Administrator', 'danger'));
            redirect($this->class_path_name);
        }
        $this->data['page_title']     = 'Edit';
        $this->data['form_action']    = site_url($this->class_path_name.'/edit/'.$id);
        $this->data['cancel_url']     = site_url($this->class_path_name);
        $this->data['post']           = $record;
        $disabled_menu                = $this->Menu_model->MenusIdChildrenTaxonomy($id);
        $menu_data                    = $this->Menu_model->MenusData();
        $this->data['auth_menu_html'] = $this->Menu_model->PrintAuthMenu($menu_data, '', $record['parent_auth_menu'], $disabled_menu);
        if ($this->input->post()) {
            $post = $this->input->post();
            if ($this->validateForm($id)) {
                $post['is_superadmin'] = (isset($post['is_superadmin'])) ?: 0;
                $post['file']          = strtolower($post['file']);

                // update data
                $this->Menu_model->UpdateRecord($id, $post);
                // insert to log
                $data_log = [
                    'id_user'  => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action'   => 'Menu Admin',
                    'desc'     => 'Edit Menu Admin; ID: '.$id.'; Data: '.json_encode($post),
                ];
                insert_to_log($data_log);
                // end insert to log
                
                $this->session->set_flashdata('flash_message', alert_box('Success.', 'success'));

                redirect($this->class_path_name);
            }
        }
        $this->data['template'] = $this->class_path_name.'/form';
        $this->data['post']     = $record;
        if (isset($this->error)) {
            $this->data['form_message'] = $this->error;
        }
    }

    /**
     * delete page.
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
                        $record = $this->Menu_model->GetMenu($id);
                        if ($record) {
                            if ($record['is_superadmin'] && ! is_superadmin()) {
                                $json['error'] = alert_box('You don\'t have permission to delete this record(s). Please contact the Administrator.', 'danger');
                                break;
                            } else {
                                if ( ! $this->Menu_model->checkUserHaveRightsMenu(id_auth_group(),$id)) {
                                    $json['error'] = alert_box('You don\'t have permission to delete this record(s). Please contact the Administrator.','danger');
                                    break;
                                } else {
                                    $this->Menu_model->DeleteRecord($id);
                                    // insert to log
                                    $data_log = [
                                        'id_user'  => id_auth_user(),
                                        'id_group' => id_auth_group(),
                                        'action'   => 'Delete Admin Menu',
                                        'desc'     => 'Delete Admin Menu; ID: '.$id.';',
                                    ];
                                    insert_to_log($data_log);
                                    // end insert to log
                                    $json['success'] = alert_box('Data has been deleted', 'success');
                                    $this->session->set_flashdata('flash_message', $json['success']);
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
                'field' => 'parent_auth_menu',
                'label' => 'Parent',
                'rules' => 'required',
            ],
            [
                'field' => 'menu',
                'label' => 'Menu',
                'rules' => 'required',
            ],
            [
                'field' => 'file',
                'label' => 'File Path',
                'rules' => 'required|callback_check_menu_file['.$id.']',
            ],
            [
                'field' => 'position',
                'label' => 'Position',
                'rules' => 'numeric',
            ],
        ];
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() === false) {
            $this->error = alert_box(validation_errors(), 'danger');

            return false;
        }

        return true;
    }

    /**
     * Check if file is exists.
     *
     * @param string $string
     * @param int    $id
     *
     * @return bool true/false
     */
    public function check_menu_file($string, $id = 0)
    {
        if ($string == '#') {
            return true;
        } else {
            if ( ! $this->Menu_model->checkExistsFilePath($string, $id)) {
                $this->form_validation->set_message('check_menu_file', '{field} is already exists. Please use different {field}');

                return false;
            }
            
            return true;
        }
    }
}
/* End of file Menu.php */
/* Location: ./application/controllers/Menu.php */
