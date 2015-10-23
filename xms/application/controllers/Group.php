<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Group Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Group Controller
 * 
 */
class Group extends CI_Controller {
    
    private $class_path_name;
    
    function __construct() {
        parent::__construct();
        $this->load->model('Group_model');
        $this->class_path_name = $this->router->fetch_class();
    }
    
    /**
     * index page
     */
    public function index() {
        $this->data['add_url'] = site_url($this->class_path_name.'/add');
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
            $param['search_value'] = $post['search']['value'];
            $param['search_field'] = $post['columns'];
            if (isset($post['order'])) {
                $param['order_field'] = $post['columns'][$post['order'][0]['column']]['data'];
                $param['order_sort'] = $post['order'][0]['dir'];
            }
            $param['row_from'] = $post['start'];
            $param['length'] = $post['length'];
            $count_all_records = $this->Group_model->CountAllGroup();
            $count_filtered_records = $this->Group_model->CountAllGroup($param);
            $records = $this->Group_model->GetAllGroupData($param);
            $return = array();
            $return['draw'] = $post['draw'];
            $return['recordsTotal'] = $count_all_records;
            $return['recordsFiltered'] = $count_filtered_records;
            $return['data'] = array();
            foreach ($records as $row => $record) {
                $return['data'][$row]['DT_RowId'] = $record['id'];
                $return['data'][$row]['actions'] = '<a href="'.site_url($this->class_path_name.'/edit/'.$record['id']).'"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>';
                $return['data'][$row]['auth_group'] = $record['auth_group'];
                $return['data'][$row]['authorization'] = '<a href="'.site_url($this->class_path_name.'/authorization/'.$record['id']).'">Auth</a>';
            }
            header('Content-type: application/json');
            exit (
                json_encode($return)
            );
        }
        redirect($this->class_path_name);
    }
    
    /**
     * add page
     */
    public function add() {
        $this->data['page_title'] = 'Add';
        $this->data['form_action'] = site_url($this->class_path_name.'/add');
        $this->data['cancel_url'] = site_url($this->class_path_name);
        if ($this->input->post()) {
            $post = $this->input->post();
            if ($this->validateForm()) {
                $post['is_superadmin'] = (isset($post['is_superadmin'])) ? 1 : 0;
                
                // update data
                $id = $this->Group_model->InsertRecord($post);
                // insert to log
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'Group Admin',
                    'desc' => 'Add Group Admin; ID: '.$id.'; Data: '.json_encode($post),
                );
                insert_to_log($data_log);
                // end insert to log
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
     * detail page
     * @param int $id
     */
    public function edit($id=0) {
        if (!$id) {
            redirect($this->class_path_name);
        }
        $record = $this->Group_model->GetGroup($id);
        if (!$record) {
            redirect($this->class_path_name);
        }
        if ($record['is_superadmin'] == 1 && !is_superadmin()) {
            $this->session->set_flashdata('flash_message', alert_box('You don\'t have rights to manage this record. Please contact Your Administrator','danger'));
            redirect($this->class_path_name);
        }
        $this->data['page_title'] = 'Edit';
        $this->data['form_action'] = site_url($this->class_path_name.'/edit/'.$id);
        $this->data['cancel_url'] = site_url($this->class_path_name);
        if ($this->input->post()) {
            $post = $this->input->post();
            if ($this->validateForm($id)) {
                $post['is_superadmin'] = (isset($post['is_superadmin'])) ? 1 : 0;
                // update data
                $this->Group_model->UpdateRecord($id,$post);
                // insert to log
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'Admin Group',
                    'desc' => 'Edit Admin Group; ID: '.$id.'; Data: '.json_encode($post),
                );
                insert_to_log($data_log);
                // end insert to log
                $this->session->set_flashdata('flash_message', alert_box('Success.','success'));

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
     * set authentication page
     * @param int $id
     */
    public function authorization($id=0) {
        $id = (int)$id;
        if (!$id) {
            redirect($this->class_path_name);
        }
        $this->data['form_action'] = site_url($this->class_path_name.'/authorization/'.$id);
        $this->data['cancel_url'] = site_url($this->class_path_name);
        $record = $this->Group_model->GetGroup($id);
        if (!$record) {
            redirect($this->class_path_name);
        }
        $this->data['page_title'] = 'Auth: '.$record['auth_group'];
        $menu_data = $this->Group_model->MenusData($record['id_auth_group']);
        $this->data['auth_menu_html'] = $this->Group_model->PrintAuthMenu($menu_data);
        
        if ($this->input->post()) {
            $post = $this->input->post();
            // update data
            $this->Group_model->UpdateAuth($id,$post['auth_menu_group']);
            // insert to log
            $data_log = array(
                'id_user' => id_auth_user(),
                'id_group' => id_auth_group(),
                'action' => 'Admin Group',
                'desc' => 'Edit Admin Group Authentication; ID: '.$id.'; Data: '.json_encode($post),
            );
            insert_to_log($data_log);
            // end insert to log
            $this->session->set_flashdata('flash_message', alert_box('Success.','success'));

            redirect($this->class_path_name);
        }
        if (isset($this->error)) {
            $this->data['form_message'] = $this->error;
        }
    }
    
    /**
     * delete page
     */
    public function delete() {
        $this->layout = 'none';
        if ($this->input->post() && $this->input->is_ajax_request()) {
            $post = $this->input->post();
            $json = array();
            if ($post['ids'] != '') {
                $array_id = array_map('trim', explode(',', $post['ids']));
                if (count($array_id)>0) {
                    foreach ($array_id as $row => $id) {
                        $record = $this->Group_model->GetGroup($id);
                        if ($record) {
                            if ($id == id_auth_group()) {
                                $json['error'] = alert_box('You can\'t delete Your own group.','danger');
                                break;
                            } else {
                                if (is_superadmin()) {
                                    $this->Group_model->DeleteRecord($id);
                                    // insert to log
                                    $data_log = array(
                                        'id_user' => id_auth_user(),
                                        'id_group' => id_auth_group(),
                                        'action' => 'Delete User Group',
                                        'desc' => 'Delete User Group; ID: '.$id.';',
                                    );
                                    insert_to_log($data_log);
                                    // end insert to log
                                    $json['success'] = alert_box('Data has been deleted','success');
                                    $this->session->set_flashdata('flash_message',$json['success']);
                                } else {
                                    $json['error'] = alert_box('You don\'t have permission to delete this record(s). Please contact the Administrator.','danger');
                                    break;
                                }
                            }
                        } else {
                            $json['error'] = alert_box('Failed. Please refresh the page.','danger');
                            break;
                        }
                    }
                }
            }
            header('Content-type: application/json');
            exit (
                json_encode($json)
            );
        }
        redirect($this->class_path_name);
    }
    
    /**
     * validate form
     * @param int $id
     * @return boolean
     */
    private function validateForm($id=0) {
        $config = array(
            array(
                'field' => 'auth_group',
                'label' => 'Username',
                'rules' => 'required|min_length[3]|max_length[32]'
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() === FALSE) {
            $this->error = alert_box(validation_errors(),'danger');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
}
/* End of file Group.php */
/* Location: ./application/controllers/Group.php */