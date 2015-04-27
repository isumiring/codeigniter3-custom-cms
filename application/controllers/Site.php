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
                $post['status'] = (isset($post['status'])) ? 1 : 0;
                $post['is_superadmin'] = (isset($post['is_superadmin'])) ? 1 : 0;
                $post['email'] = strtolower($post['email']);

                if ($post['password'] != '') {
                    $post['userpass'] = password_hash($post['password'],PASSWORD_DEFAULT);
                }
                unset($post['password']);
                unset($post['conf_password']);
                
                // update data
                $this->Site_model->UpdateRecord($id,$post);
                unset($post['userpass']);
                // now change session if user is edit themselve
                if (id_auth_user() == $id) {
                    $user_session = array($_SESSION['ADM_SESS']);
                    $user_sess = array();
                    foreach ($user_session as $key => $val) {
                        $user_session[$key]['admin_name'] = $post['name'];
                        $user_session[$key]['admin_id_auth_group'] = $post['id_auth_group'];
                        $user_session[$key]['admin_email'] = strtolower($post['email']);
                    }
                    foreach ($user_session as $key => $val) {
                        $user_sess[$val] = $key[$val];
                    }
                    $new_session = $val;
                    $this->session->set_userdata('ADM_SESS', $new_session);
                }
                $post_image = $_FILES;
                if ($post_image['image']['tmp_name']) {
                    if ($record['image'] != '' && file_exists(UPLOAD_DIR.'admin/'.$record['image'])) {
                        unlink(UPLOAD_DIR.'admin/'.$record['image']);
                        @unlink(UPLOAD_DIR.'admin/tmb_'.$record['image']);
                        @unlink(UPLOAD_DIR.'admin/sml_'.$record['image']);
                    }
                    $filename = 'adm_'.url_title($post['name'],'_',true).md5plus($id);
                    $picture_db = file_copy_to_folder($post_image['image'], UPLOAD_DIR.'admin/', $filename);
                    copy_image_resize_to_folder(UPLOAD_DIR.'admin/'.$picture_db, UPLOAD_DIR.'admin/', 'tmb_'.$filename, IMG_THUMB_WIDTH, IMG_THUMB_HEIGHT);
                    copy_image_resize_to_folder(UPLOAD_DIR.'admin/'.$picture_db, UPLOAD_DIR.'admin/', 'sml_'.$filename, IMG_SMALL_WIDTH, IMG_SMALL_HEIGHT);

                    $this->Site_model->UpdateRecord($id,array('image'=>$picture_db));
                }
                // insert to log
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'User Site',
                    'desc' => 'Edit User Site; ID: '.$id.'; Data: '.json_encode($post),
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
                        $record = $this->Site_model->GetSite($id);
                        if ($record) {
                            if ($id == id_auth_user()) {
                                $json['error'] = alert_box('You can\'t delete Your own account.','danger');
                                break;
                            } else {
                                if (is_superadmin()) {
                                    if ($record['image'] != '' && file_exists(UPLOAD_DIR.'admin/'.$record['image'])) {
                                        unlink(UPLOAD_DIR.'admin/'.$record['image']);
                                        @unlink(UPLOAD_DIR.'admin/tmb_'.$record['image']);
                                        @unlink(UPLOAD_DIR.'admin/sml_'.$record['image']);
                                    }
                                    $this->Site_model->DeleteRecord($id);
                                    // insert to log
                                    $data_log = array(
                                        'id_user' => id_auth_user(),
                                        'id_group' => id_auth_group(),
                                        'action' => 'Delete User Site',
                                        'desc' => 'Delete User Site; ID: '.$id.';',
                                    );
                                    insert_to_log($data_log);
                                    // end insert to log
                                    $json['success'] = alert_box('Data has been deleted','success');
                                    $this->session->set_flashdata('flash_message',$json['success']);
                                } else {
                                    $json['error'] = alert_box('You don\'t have permission to delete this record(s). Please contact the Siteistrator.','danger');
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
        $post = $this->input->post();
        $config = array(
            array(
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'required|min_length[3]|max_length[32]|alpha_dash|callback_check_username_exists['.$id.']'
            ),
            array(
                'field' => 'id_auth_group',
                'label' => 'Group',
                'rules' => 'required|is_natural_no_zero'
            ),
            array(
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required|alpha_numeric_spaces'
            ),
            array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required|valid_email|callback_check_email_exists['.$id.']'
            ),
            array(
                'field' => 'id_auth_group',
                'label' => 'Group',
                'rules' => 'required|is_natural_no_zero'
            ),
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() === FALSE) {
            $this->error = alert_box(validation_errors(),'danger');
            return FALSE;
        } else {
            $post_image = $_FILES;
            if (!$id) {
                if ($post['password'] == '') {
                    $this->error = 'Please insert Password.<br/>';
                } else {
                    if (strlen($post['password']) <= 6) {
                        $this->error = 'Please input Password more than 6 characters.<br/>';
                    } else {
                        if ($post['conf_password'] != $post['password']) {
                            $this->error = 'Your Confirmation Password is not same with Your Password.<br/>';
                        }
                    }
                }
            } else {
                if (strlen($post['password']) > 0) {
                    if (strlen($post['password']) <= 6) {
                        $this->error = 'Please input Password more than 6 characters.<br/>';
                    } else {
                        if ($post['conf_password'] != $post['password']) {
                            $this->error = 'Your Confirmation Password is not same with Your Password.<br/>';
                        }
                    }
                }
            }
            if (!$this->error) {
                if (!empty($post_image['image']['tmp_name'])) {
                    $check_picture = validatePicture('image');
                    if (!empty($check_picture)) {
                        $this->error = alert_box($check_picture,'danger');
                        return FALSE;
                    }
                }
                return TRUE;
            } else {
                $this->error = alert_box($this->error,'danger');
                return FALSE;
            }
        }
    }
    
    /**
     * form validation check email exist
     * @param string $string
     * @param int $id
     * @return boolean
     */
    public function check_email_exists($string,$id=0) {
        if (!$this->Site_model->checkExistsEmail($string, $id)) {
            $this->form_validation->set_message('check_email_exists', '{field} is already exists. Please use different {field}');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    /**
     * form validation check username exist
     * @param string $string
     * @param int $id
     * @return boolean
     */
    public function check_username_exists($string,$id=0) {
        if (!$this->Site_model->checkExistsUsername($string, $id)) {
            $this->form_validation->set_message('check_username_exists', '{field} is already exists. Please use different {field}');
            return FALSE;
        } else {
            return TRUE;
        }
    }
}
/* End of file Site.php */
/* Location: ./application/controllers/Site.php */