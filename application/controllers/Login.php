<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    
    /**
     * login page
     */
    public function index() {
        $this->load->model('Auth_model');
        $this->layout = 'login';
        $this->data['page_title'] = 'Login';
        $this->data['form_action'] = site_url('login');
        if ($this->input->post()) {
            $post = $this->input->post();
            if (isset($post['username']) && isset($post['password']) && $post['username'] != '' && $post['password'] != '') {
                $this->Auth_model->CheckAuth($post['username'],$post['password']);
            } else {
                $error_login = alert_box('Username/Password isn\'t valid. Please try again.','danger');
            }
        }
        if (isset($error_login)) {
            $this->data['error_login'] = $error_login;
        }
        if ($this->session->flashdata('flash_message')) {
            $this->data['error_login'] = $this->session->flashdata('flash_message');
        }
    }
    
    public function logout() {
    }
}