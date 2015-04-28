<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Site Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Site Controller
 * 
 */
class Site extends CI_Controller {
    
    private $class_path_name;
    
    function __construct() {
        parent::__construct();
        $this->load->model('Site_model');
        $this->class_path_name = $this->router->fetch_class();
    }
    
    /**
     * index page
     */
    public function index() {
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
            $count_all_records = $this->Site_model->CountAllSite();
            $count_filtered_records = $this->Site_model->CountAllSite($param);
            $records = $this->Site_model->GetAllSiteData($param);
            $return = array();
            $return['draw'] = $post['draw'];
            $return['recordsTotal'] = $count_all_records;
            $return['recordsFiltered'] = $count_filtered_records;
            $return['data'] = array();
            foreach ($records as $row => $record) {
                $return['data'][$row]['DT_RowId'] = $record['id'];
                $return['data'][$row]['actions'] = '<a href="'.site_url($this->class_path_name.'/detail/'.$record['id']).'"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>';
                $return['data'][$row]['site_name'] = $record['site_name'];
                $return['data'][$row]['site_url'] = $record['site_url'];
                $return['data'][$row]['is_default'] = ($record['is_default'] == 1) ? 'Default' : '';
            }
            header('Content-type: application/json');
            exit (
                json_encode($return)
            );
        }
        redirect($this->class_path_name);
    }
    
    /**
     * detail page
     * @param int $id
     */
    public function detail($id=0) {
        if (!$id) {
            redirect($this->class_path_name);
        }
        $record = $this->Site_model->GetSite($id);
        if (!$record) {
            redirect($this->class_path_name);
        }
        $this->data['page_title'] = 'Detail: '.$record['site_name'];
        $this->data['form_action'] = site_url($this->class_path_name.'/detail/'.$id);
        $this->data['cancel_url'] = site_url($this->class_path_name);
        if ($this->input->post()) {
            $post = $this->input->post();
            if ($this->validateForm($id)) {
                $post['modify_date'] = date('Y-m-d H:i:s');
                $post['is_default'] = (isset($post['is_default'])) ? 1 : 0;
                
                // update data
                $post_setting = $post['setting'];
                unset($post['setting']);
                $this->Site_model->UpdateRecord($id,$post);
                
                // update setting
                $this->Site_model->UpdateSettingData($id,$post_setting);
                $post_image = $_FILES;
                if ($post_image['site_logo']['tmp_name']) {
                    if ($record['site_logo'] != '' && file_exists(UPLOAD_DIR.'site/'.$record['site_logo'])) {
                        unlink(UPLOAD_DIR.'site/'.$record['site_logo']);
                        @unlink(UPLOAD_DIR.'site/tmb_'.$record['site_logo']);
                        @unlink(UPLOAD_DIR.'site/sml_'.$record['site_logo']);
                    }
                    $filename = url_title($post['site_name'].'-logo');
                    $picture_db = file_copy_to_folder($post_image['site_logo'], UPLOAD_DIR.'site/', $filename);
                    copy_image_resize_to_folder(UPLOAD_DIR.'site/'.$picture_db, UPLOAD_DIR.'site/', 'tmb_'.$filename, IMG_THUMB_WIDTH, IMG_THUMB_HEIGHT);
                    copy_image_resize_to_folder(UPLOAD_DIR.'site/'.$picture_db, UPLOAD_DIR.'site/', 'sml_'.$filename, IMG_SMALL_WIDTH, IMG_SMALL_HEIGHT);

                    $this->Site_model->UpdateRecord($id,array('site_logo'=>$picture_db));
                }
                // insert to log
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'Site Setting',
                    'desc' => 'Edit Site Setting; ID: '.$id.'; Data: '.json_encode($post),
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
     * delete picture
     */
    public function delete_picture() {
        $this->layout = 'none';
        if ($this->input->post() && $this->input->is_ajax_request()) {
            $json = array();
            $post = $this->input->post();
            if (isset($post['id']) && $post['id'] > 0 && ctype_digit($post['id'])) {
                $detail = $this->Site_model->GetSite($post['id']);
                if ($detail && ($detail['site_logo'] != '' && file_exists(UPLOAD_DIR.'site/'.$detail['site_logo']))) {
                    $id = $post['id'];
                    unlink(UPLOAD_DIR.'site/'.$detail['site_logo']);
                    @unlink(UPLOAD_DIR.'site/tmb_'.$detail['site_logo']);
                    @unlink(UPLOAD_DIR.'site/sml_'.$detail['site_logo']);
                    $data_update = array('site_logo' =>'');
                    $this->Site_model->UpdateRecord($post['id'],$data_update);
                    $json['success'] = alert_box('File hase been deleted.','success');
                    // insert to log
                    $data_log = array(
                        'id_user' => id_auth_user(),
                        'id_group' => id_auth_group(),
                        'action' => 'Site Setting',
                        'desc' => 'Delete Picture Site Setting; ID: '.$id.';',
                    );
                    insert_to_log($data_log);
                    // end insert to log
                } else {
                    $json['error'] = alert_box('Failed to remove File. Please try again.','danger');
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
                'field' => 'site_name',
                'label' => 'Site Name',
                'rules' => 'required'
            ),
            array(
                'field' => 'site_url',
                'label' => 'Site URL',
                'rules' => 'required'
            ),
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() === FALSE) {
            $this->error = alert_box(validation_errors(),'danger');
            return FALSE;
        } else {
            $post_image = $_FILES;
            if (!empty($post_image['site_logo']['tmp_name'])) {
                $check_picture = validatePicture('site_logo');
                if (!empty($check_picture)) {
                    $this->error = alert_box($check_picture,'danger');
                    return FALSE;
                }
            }
            return TRUE;
        }
    }
}
/* End of file Site.php */
/* Location: ./application/controllers/Site.php */