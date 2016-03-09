<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Article Category Class.
 *
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 *
 * @version 3.0
 *
 * @category Controller
 * @desc Article Category Controller
 */
class Article_category extends CI_Controller
{
    private $class_path_name;
    private $error;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Article_category_model', 'Category_model');
        $this->class_path_name = $this->router->fetch_class();
    }

    /**
     * index page.
     */
    public function index()
    {
        $this->data['add_url'] = site_url($this->class_path_name.'/add');
        $this->data['url_data'] = site_url($this->class_path_name.'/list_data');
        $this->data['record_perpage'] = SHOW_RECORDS_DEFAULT;
    }

    /**
     * list data.
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
                $param['order_sort'] = $post['order'][0]['dir'];
            }
            $param['row_from'] = $post['start'];
            $param['length'] = $post['length'];
            $count_all_records = $this->Category_model->CountAllData();
            $count_filtered_records = $this->Category_model->CountAllData($param);
            $records = $this->Category_model->GetAllData($param);
            $return = [];
            $return['draw'] = $post['draw'];
            $return['recordsTotal'] = $count_all_records;
            $return['recordsFiltered'] = $count_filtered_records;
            $return['data'] = [];
            foreach ($records as $row => $record) {
                $return['data'][$row]['DT_RowId'] = $record['id'];
                $return['data'][$row]['actions'] = '
                    <a href="'.site_url($this->class_path_name.'/edit/'.$record['id']).'"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                ';
                $return['data'][$row]['title'] = $record['title'];
            }
            header('Content-type: application/json');
            exit(
                json_encode($return)
            );
        }
        redirect($this->class_path_name);
    }

    /**
     * add page.
     */
    public function add()
    {
        $this->data['page_title'] = 'Add';
        $this->data['form_action'] = site_url($this->class_path_name.'/add');
        $this->data['cancel_url'] = site_url($this->class_path_name);
        $this->data['locales'] = $this->Category_model->GetLocalization();
        if ($this->input->post()) {
            $post = $this->input->post();
            if ($this->validateForm()) {
                if (isset($post['locales'])) {
                    $post_locales = $post['locales'];
                    unset($post['locales']);
                }
                // insert data
                $id = $this->Category_model->InsertRecord($post);
                if ($id && isset($post_locales)) {
                    $insert_locales = [];
                    foreach ($post_locales as $id_localization => $post_local) {
                        $insert_locales[] = [
                            'id_article_category' => $id,
                            'title'               => $post_local['title'],
                            'id_localization'     => $id_localization,
                        ];
                    }
                    $post['locales'] = $insert_locales;
                    $this->Category_model->InsertDetailRecord($insert_locales);
                }

                // insert to log
                $data_log = [
                    'id_user'  => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action'   => 'Article Category',
                    'desc'     => 'Add Article Category; ID: '.$id.'; Data: '.json_encode($post),
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
     * detail page.
     *
     * @param int $id
     */
    public function edit($id = 0)
    {
        if (!$id) {
            redirect($this->class_path_name);
        }
        $record = $this->Category_model->GetArticleCategory($id);
        if (!$record) {
            redirect($this->class_path_name);
        }
        $this->data['page_title'] = 'Edit';
        $this->data['form_action'] = site_url($this->class_path_name.'/edit/'.$id);
        $this->data['cancel_url'] = site_url($this->class_path_name);
        $this->data['locales'] = $this->Category_model->GetLocalization();
        if ($this->input->post()) {
            $post = $this->input->post();
            if ($this->validateForm($id)) {
                if (isset($post['locales'])) {
                    $post_locales = $post['locales'];
                    unset($post['locales']);
                }

                // update data
                $this->Category_model->UpdateRecord($id, $post);
                // delete/purge detail content before new insert
                $this->Category_model->DeleteDetailRecordByID($id);
                if (isset($post_locales)) {
                    $insert_locales = [];
                    foreach ($post_locales as $id_localization => $post_local) {
                        $insert_locales[] = [
                            'id_article_category' => $id,
                            'title'               => $post_local['title'],
                            'id_localization'     => $id_localization,
                        ];
                    }
                    $post['locales'] = $insert_locales;
                    $this->Category_model->InsertDetailRecord($insert_locales);
                }

                // insert to log
                $data_log = [
                    'id_user'  => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action'   => 'Article Category',
                    'desc'     => 'Edit Article Category; ID: '.$id.'; Data: '.json_encode($post),
                ];
                insert_to_log($data_log);
                // end insert to log
                $this->session->set_flashdata('flash_message', alert_box('Success.', 'success'));

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
                        $record = $this->Category_model->GetArticleCategory($id);
                        if ($record) {
                            $this->Category_model->DeleteRecord($id);
                            // insert to log
                            $data_log = [
                                'id_user'  => id_auth_user(),
                                'id_group' => id_auth_group(),
                                'action'   => 'Delete Article Category',
                                'desc'     => 'Delete Article Category; ID: '.$id.';',
                            ];
                            insert_to_log($data_log);
                            // end insert to log
                            $json['success'] = alert_box('Data has been deleted', 'success');
                            $this->session->set_flashdata('flash_message', $json['success']);
                        } else {
                            $json['error'] = alert_box('Failed. Please refresh the page.', 'danger');
                            break;
                        }
                    }
                }
            }
            header('Content-type: application/json');
            exit(
                json_encode($json)
            );
        }
        redirect($this->class_path_name);
    }

    /**
     * validate form.
     *
     * @param int $id
     *
     * @return bool
     */
    private function validateForm($id = 0)
    {
        $post = $this->input->post();
        $default_locale = $this->Category_model->GetDefaultLocalization();
        $config = [
            [
                'field' => 'uri_path',
                'label' => 'SEO URL',
                'rules' => 'required',
            ],
        ];
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() === false) {
            $this->error = alert_box(validation_errors(), 'danger');

            return false;
        } else {
            if (!check_exist_uri('article_category', $post['uri_path'], $id)) {
                $this->error = 'SEO URL is already used.';
            } else {
                foreach ($post['locales'] as $row => $local) {
                    if ($row == $default_locale['id_localization'] && $local['title'] == '') {
                        $this->error = 'Please insert Title.';
                        break;
                    }
                }
            }
            if (!$this->error) {
                return true;
            } else {
                $this->error = alert_box($this->error, 'danger');

                return false;
            }
        }
    }
}
/* End of file Article_category.php */
/* Article: ./application/controllers/Article_category.php */
