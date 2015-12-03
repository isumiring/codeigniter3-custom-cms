<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Profile Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Profile Controller
 * 
 */
class Profile extends CI_Controller {
    
    private $class_path_name;
    private $error = '';
    
    function __construct() {
        parent::__construct();
        $this->load->model('Admin_model');
        $this->class_path_name = $this->router->fetch_class();
    }
    
    /**
     * index page for this controller
     */
    public function index()
    {
        $id = id_auth_user();
        if (!$id) {
            redirect();
        }
        $this->data['page_title'] = 'Profile';
        $this->load->model('Admin_model');
        $this->data['form_action'] = site_url($this->class_path_name);
        $this->data['changepass_form'] = site_url($this->class_path_name.'/change_pass');
        $detail = $this->Admin_model->getAdmin($id);
        $post = $detail;
        
        if ($this->input->post()) {
            if ($this->validateForm()) {
                $post = $this->input->post();
                $now = date('Y-m-d H:i:s');
                $data_post = array(
                    'name' => $post['name'],
                    'email' => strtolower($post['email']),
                    'phone' => $post['phone'],
                    'alamat' => $post['alamat'],
                    'modify_date' => $now,
                );

                // update data
                $this->Admin_model->UpdateRecord($id, $data_post);
                $post_image = $_FILES;
                if ($post_image['image']['tmp_name']) {
                    $filename = 'adm_'.url_title($post['name'],'_',true).md5plus($id);
                    if ($record['image'] != '' && file_exists(UPLOAD_DIR.'admin/'.$record['image'])) {
                        unlink(UPLOAD_DIR.'admin/'.$record['image']);
                        @unlink(UPLOAD_DIR.'admin/tmb_'.$record['image']);
                        @unlink(UPLOAD_DIR.'admin/sml_'.$record['image']);
                    }
                    $picture_db = file_copy_to_folder($post_image['image'], UPLOAD_DIR.'admin/', $filename);
                    copy_image_resize_to_folder(UPLOAD_DIR.'admin/'.$picture_db, UPLOAD_DIR.'admin/', 'tmb_'.$filename, IMG_THUMB_WIDTH, IMG_THUMB_HEIGHT);
                    copy_image_resize_to_folder(UPLOAD_DIR.'admin/'.$picture_db, UPLOAD_DIR.'admin/', 'sml_'.$filename, IMG_SMALL_WIDTH, IMG_SMALL_HEIGHT);
                    // update data
                    $this->Admin_model->UpdateRecord($id,array('image'=>$picture_db));
                }

                $user_session = $_SESSION['ADM_SESS'];
                $user_session['admin_name'] = $post['name'];
                $user_session['admin_email'] = strtolower($post['email']);
                // insert to log
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'Profile',
                    'desc' => 'Edit Profile; ID: '.$id.'; Data: '.json_encode($post),
                );
                insert_to_log($data_log);
                // end insert to log
                $_SESSION['ADM_SESS'] = $user_session;

                $this->session->set_flashdata('form_message', alert_box('Your Profile has been updated.','success'));

                redirect($this->class_path_name);
            }
        }
        $this->data['post'] = $post;
        if ($this->error) {
            $this->data['form_message'] = $this->error;
        }
        if ($this->session->flashdata('form_message')) {
            $this->data['form_message'] = $this->session->flashdata('form_message');
        }
    }
    
    /**
     * change user password
     */
    public function change_pass() {
        $this->layout = 'none';
        if ($this->input->is_ajax_request() && $this->input->post()) {
            $json = array();
            $post = $this->input->post();
            $id = id_auth_user();
            $this->load->model('Admin_model');
            $detail = $this->Admin_model->getAdmin($id);
            if (!$id || !$detail) {
                $json['location'] = site_url('home');
            }
            if (!$this->validatePassword()) {
                $json['error'] = $this->error;
            }
            if (!$json) {
                $now = date('Y-m-d H:i:s');
                $data = array(
                    'userpass'=>password_hash($post['new_password'],PASSWORD_DEFAULT),
                    'modify_date'=>$now
                );
                $this->Admin_model->UpdateRecord($id,$data);
                // insert to log
                $data_log = array(
                    'id_user' => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action' => 'Profile',
                    'desc' => 'Change Password Profile; ID: '.$id.';',
                );
                insert_to_log($data_log);
                // end insert to log
                $json['success'] = alert_box('Your Password has been changed.','success');
                $this->session->set_flashdata('form_message',$json['success']);
                $json['redirect'] = site_url('profile');
            }
            header('Content-type: application/json');
            exit (
                json_encode($json)
            );
        }
        redirect('profile');
    }
    
    /**
     * validate form
     * @return boolean
     */
    private function validateForm()
    {
        $this->load->model('Admin_model');
        $id = id_auth_user();
        $post = $this->input->post();
        $err = '';

        if ($post['name'] == '') {
            $err .= 'Please insert Name.<br/>';
        } else {
            if ((strlen($post['name']) < 1) || (strlen($post['name']) > 32)) {
                $err .= 'Please insert Name.<br/>';
            }
        }

        if ($post['email'] == '') {
            $err .= 'Please insert Email.<br/>';
        } else {
            if (!mycheck_email($post['email'])) {
                $err .= 'Please insert correct Email.<br/>';
            } else {
                if (!$this->Admin_model->checkExistsEmail($post['email'], $id)) {
                    $err .= 'Email already exists, please input different Email.<br/>';
                }
            }
        }

        if (($post['phone'] != '') && (!ctype_digit($post['phone']))) {
            $err .= 'Please insert correct Phone.<br/>';
        }
        
        $post_image = $_FILES;
        if (!empty($post_image['image']['tmp_name'])) {
            $check_picture = validatePicture('image');
            if (!empty($check_picture)) {
                $err .= $check_picture.'<br/>';
            }
        }
        
        if ($err) {
            $this->error = $err;
            return false;
        } else {
            return true;
        }
    }
    
    /**
     * validate change password form
     * @return boolean
     */
    private function validatePassword()
    {
        $this->load->model('Admin_model');
        $id = id_auth_user();
        $post = $this->input->post();
        $err = '';
        $detail = $this->Admin_model->getAdmin($id);
        if ($post['old_password'] == '') {
            $err .= 'Please insert Old Password.<br/>';
        } else {
            if (!password_verify($post['old_password'],$detail['userpass']) && $detail['userpass'] != '') {
                $err .= 'Your Old Password is incorrect.<br/>';
            }
        }
        if ($post['new_password'] == '') {
            $err .= 'Please input your New Password.<br/>';
        } else {
            if (strlen($post['new_password']) <= 6) {
                $err .= 'Please input New Password more than 6 characters.<br/>';
            } else {
                if ($post['conf_password'] != $post['new_password']) {
                    $err .= 'Your Confirmation Password is not same with Your New Password.<br/>';
                }
            }
        }
        
        if ($err) {
            $this->error = alert_box($err,'danger');
            return false;
        } else {
            return true;
        }
    }
}
/* End of file Profile.php */
/* Location: ./application/controllers/Profile.php */