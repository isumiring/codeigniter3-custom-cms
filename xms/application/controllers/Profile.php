<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Profile Class.
 *     Profile page for every admin user.
 *
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 *
 * @version 3.0
 *
 * @category Controller
 */
class Profile extends CI_Controller
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
        $this->load->model('Admin_model');
        $this->class_path_name = $this->router->fetch_class();
    }

    /**
     * Index page for this controller.
     */
    public function index()
    {
        $id = id_auth_user();
        $id_group = id_auth_group();
        if (!$id || !$id_group) {
            redirect();
        }
        $this->data['page_title'] = 'Profile';
        $this->data['form_action'] = site_url($this->class_path_name);
        $this->data['changepass_form'] = site_url($this->class_path_name.'/change_pass');
        $detail = $this->Admin_model->GetAdmin($id);
        $post = $detail;

        if ($this->input->post()) {
            if ($this->validateForm()) {
                $post = $this->input->post();
                $now = date('Y-m-d H:i:s');
                $data_post = [
                    'name'         => $post['name'],
                    'email'        => strtolower($post['email']),
                    'phone'        => $post['phone'],
                    'address'      => $post['address'],
                    'modify_date'  => $now,
                ];

                // update data
                $this->Admin_model->UpdateRecord($id, $data_post);

                $post_image = $_FILES;
                if ($post_image['image']['tmp_name']) {
                    $filename = 'adm_'.url_title($post['name'], '_', true).md5plus($id);
                    if ($record['image'] != '' && file_exists(UPLOAD_DIR.'admin/'.$record['image'])) {
                        unlink(UPLOAD_DIR.'admin/'.$record['image']);
                        @unlink(UPLOAD_DIR.'admin/tmb_'.$record['image']);
                        @unlink(UPLOAD_DIR.'admin/sml_'.$record['image']);
                    }
                    $picture_db = file_copy_to_folder($post_image['image'], UPLOAD_DIR.'admin/', $filename);
                    copy_image_resize_to_folder(UPLOAD_DIR.'admin/'.$picture_db, UPLOAD_DIR.'admin/', 'tmb_'.$filename, IMG_THUMB_WIDTH, IMG_THUMB_HEIGHT, 70);
                    copy_image_resize_to_folder(UPLOAD_DIR.'admin/'.$picture_db, UPLOAD_DIR.'admin/', 'sml_'.$filename, IMG_SMALL_WIDTH, IMG_SMALL_HEIGHT, 70);
                    // update data
                    $this->Admin_model->UpdateRecord($id, ['image' => $picture_db]);
                }

                $user_session = $_SESSION['ADM_SESS'];
                $user_session['admin_name'] = $post['name'];
                $user_session['admin_email'] = strtolower($post['email']);

                $_SESSION['ADM_SESS'] = $user_session;

                // insert to log
                $data_log = [
                    'id_user'  => $id,
                    'id_group' => $id_group,
                    'action'   => 'Profile',
                    'desc'     => 'Edit Profile; ID: '.$id.'; Data: '.json_encode($post),
                ];
                insert_to_log($data_log);
                // end insert to log

                $this->session->set_flashdata('form_message', alert_box('Your Profile has been updated.', 'success'));

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
     * Change user password.
     */
    public function change_pass()
    {
        $this->layout = 'none';
        if ($this->input->is_ajax_request() && $this->input->post()) {
            $json = [];
            $post = $this->input->post();
            $id = id_auth_user();
            $detail = $this->Admin_model->GetAdmin($id);
            if (!$id || !$detail) {
                $json['location'] = site_url('home');
            }
            if (!$this->validatePassword($detail)) {
                $json['error'] = $this->error;
            }
            if (!$json) {
                $now = date('Y-m-d H:i:s');
                $data = [
                    'userpass'    => generate_password($post['new_password']),
                    'modify_date' => $now,
                ];
                $this->Admin_model->UpdateRecord($id, $data);
                // insert to log
                $data_log = [
                    'id_user'  => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action'   => 'Profile',
                    'desc'     => 'Change Password Profile; ID: '.$id.';',
                ];
                insert_to_log($data_log);
                // end insert to log
                $json['success'] = alert_box('Your Password has been changed.', 'success');
                $json['redirect'] = site_url('profile');
                $this->session->set_flashdata('form_message', $json['success']);
            }
            json_exit($json);
        }
        redirect('profile');
    }

    /**
     * Validate form.
     *
     * @return bool
     */
    private function validateForm()
    {
        $id = id_auth_user();
        $post = $this->input->post();
        $config = [
            [
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required|alpha_numeric_spaces',
            ],
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required|valid_email|callback_check_email_exists['.$id.']',
            ],
        ];
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() === false) {
            $this->error = alert_box(validation_errors(), 'danger');

            return false;
        } else {
            $post_image = $_FILES;
            if (!empty($post_image['image']['tmp_name'])) {
                $check_picture = validatePicture('image');
                if (!empty($check_picture)) {
                    $this->error = alert_box($check_picture, 'danger');

                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Validate change password form.
     *
     * @return bool
     */
    private function validatePassword($user_data)
    {
        $post = $this->input->post();
        $config = [
            [
                'field' => 'old_password',
                'label' => 'Old Password',
                'rules' => 'required',
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required|min_lenght[8]',
            ],
            [
                'field' => 'conf_password',
                'label' => 'Password Confirmation',
                'rules' => 'required|matches[password]',
            ],
        ];
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() === false) {
            $this->error = alert_box(validation_errors(), 'danger');

            return false;
        } else {
            if (!validate_password($post['old_password'], $user_data['userpass']) && $user_data['userpass'] != '') {
                $this->error = alert_box('Your Old Password is incorrect.', 'danger');

                return false;
            }
        }

        return true;
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
        if (!$this->Admin_model->checkExistsEmail($string, $id)) {
            $this->form_validation->set_message('check_email_exists', '{field} is already exists. Please use different {field}');

            return false;
        }

        return true;
    }
}
/* End of file Profile.php */
/* Location: ./application/controllers/Profile.php */
