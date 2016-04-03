<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Localization Class.
 * 
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * 
 * @version 3.0
 * 
 * @category Controller
 */
class Localization extends CI_Controller 
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
    function __construct() 
    {
        parent::__construct();
        $this->load->model('Localization_model');
        $this->class_path_name = $this->router->fetch_class();
    }
    
    /**
     * Index page.
     */
    public function index() 
    {
        $this->data['url_data']        = site_url($this->class_path_name.'/list_data');
        $this->data['add_url']         = site_url($this->class_path_name.'/add');
        $this->data['set_default_url'] = site_url($this->class_path_name.'/set_default');
        $this->data['record_perpage']  = SHOW_RECORDS_DEFAULT;
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
            $count_all_records         = $this->Localization_model->CountAllData();
            $count_filtered_records    = $this->Localization_model->CountAllData($param);
            $records                   = $this->Localization_model->GetAllData($param);
            $return                    = [];
            $return['draw']            = $post['draw'];
            $return['recordsTotal']    = $count_all_records;
            $return['recordsFiltered'] = $count_filtered_records;
            $return['data']            = [];
            foreach ($records as $row => $record) {
                $return['data'][$row]['DT_RowId']      = $record['id'];
                $return['data'][$row]['actions']       = '<a href="'.site_url($this->class_path_name.'/detail/'.$record['id']).'" class="btn btn-sm btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                $return['data'][$row]['locale']        = $record['locale'];
                $return['data'][$row]['iso_1']         = $record['iso_1'];
                $return['data'][$row]['iso_2']         = $record['iso_2'];
                $return['data'][$row]['locale_path']   = $record['locale_path'];
                $return['data'][$row]['locale_status'] = ($record['locale_status'] == 1) ? 'Default' : '<button class="btn btn-sm btn-info set-default" type="button" data-id="'.$record['id'].'">Set Default</button>';
            }
            json_exit($return);
        }
        redirect($this->class_path_name);
    }
    
    /**
     * Add new.
     */
    public function add() 
    {
        $this->data['page_title']  = 'Add Localization';
        $this->data['form_action'] = site_url($this->class_path_name.'/add');
        $this->data['cancel_url']  = site_url($this->class_path_name);
        if ($this->input->post()) {
            $post = $this->input->post();
            if ($this->validateForm()) {
                $post['locale_status'] = (isset($post['locale_status'])) ?: 0;
                $post['locale_path']   = ($post['locale_path'] != '') ? url_title($post['locale_path'], '-', true) : url_title($post['locale'], '-', true);
                
                $id = $this->Localization_model->InsertRecord($post);
                // insert to log
                $data_log = [
                    'id_user'  => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action'   => 'Localization',
                    'desc'     => 'Add Localization; ID: '.$id.'; Data: '.json_encode($post),
                ];
                insert_to_log($data_log);
                // end insert to log
                
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
     * Change status to default.
     */
    public function set_default()
    {
        $this->layout = 'none';
        if ($this->input->post() && $this->input->is_ajax_request()) {
            $post = $this->input->post();
            $json = [];
            if (isset($post['localization_id']) && $post['localization_id'] != '') {
                $data = $this->Localization_model->GetLocalization($post['localization_id']);
                if ($data) {
                    $this->Localization_model->UpdateDefault($post['localization_id']);
                    // insert to log
                    $data_log = [
                        'id_user'  => id_auth_user(),
                        'id_group' => id_auth_group(),
                        'action'   => 'Localization',
                        'desc'     => 'Set Default Localization; ID: '. $post['localization_id'] .';',
                    ];
                    insert_to_log($data_log);
                    // end insert to log
                    
                    $json = [
                        'status'        => 'success',
                        'response_text' => 'Success',
                        'redirect'      => site_url($this->class_path_name),
                    ];
                    $this->session->set_flashdata('flash_message', alert_box('Success.', 'success'));
                } else {
                    $json['error'] = alert_box('Failed. Please refresh the page.', 'danger');
                }
            }
            json_exit($json);
        }
        redirect($this->class_path_name);
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
                        $record = $this->Localization_model->GetLocalization($id);
                        if ($record) {
                            if ($record['locale_status'] == 1) {
                                $json['error'] = alert_box('Failed. Can\'t delete Default Localization.', 'danger');
                                break;
                            } else {
                                $this->Localization_model->DeleteRecord($id);
                                // insert to log
                                $data_log = [
                                    'id_user'  => id_auth_user(),
                                    'id_group' => id_auth_group(),
                                    'action'   => 'Delete Localization',
                                    'desc'     => 'Delete Localization; ID: '.$id.';',
                                ];
                                insert_to_log($data_log);
                                // end insert to log
                                
                                $json['success'] = alert_box('Data has been deleted', 'success');
                                $this->session->set_flashdata('flash_message', $json['success']);
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
     * @return boolean
     */
    private function validateForm($id = 0) 
    {
        $post = $this->input->post();
        $rules = [
            [
                'field' => 'locale',
                'label' => 'Locale/Language',
                'rules' => 'required'
            ],
            [
                'field' => 'iso_1',
                'label' => 'ISO 2',
                'rules' => 'required'
            ],
            [
                'field' => 'iso_2',
                'label' => 'ISO 3',
                'rules' => 'required'
            ],
        ];
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() === false) {
            $this->error = alert_box(validation_errors(), 'danger');

            return false;
        } else {
            if ( ! $this->Localization_model->CheckExistsPath($post['locale_path'], $id)) {
                $this->error = 'Path already used.';
            }
            if ( ! $this->Localization_model->CheckDefault($id)) {
                $this->error = 'Only 1 can set to Default.';
            }
            if ($this->error) {
                $this->error = alert_box($this->error, 'danger');

                return false;
            }
        }

        return true;
    }
}
/* End of file Localization.php */
/* Location: ./application/controllers/Localization.php */