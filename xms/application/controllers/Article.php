<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Article Class.
 *
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 *
 * @version 3.0
 *
 * @category Controller
 * @desc Article Controller
 */
class Article extends CI_Controller
{
    private $class_path_name;
    private $error;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Article_model');
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
            $count_all_records = $this->Article_model->CountAllData();
            $count_filtered_records = $this->Article_model->CountAllData($param);
            $records = $this->Article_model->GetAllData($param);
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
                $return['data'][$row]['category_title'] = $record['category_title'];
                $return['data'][$row]['publish_date'] = ($record['publish_date'] != '') ? custDateFormat($record['publish_date'], 'd M Y') : '-';
                $return['data'][$row]['status_text'] = $record['status_text'];
                $return['data'][$row]['create_date'] = custDateFormat($record['create_date'], 'd M Y H:i:s');
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
        $this->data['locales'] = $this->Article_model->GetLocalization();
        $this->data['statuses'] = $this->Article_model->GetStatus();
        $this->data['categories'] = $this->Article_model->GetCategories();
        if ($this->input->post()) {
            $post = $this->input->post();
            if ($this->validateForm()) {
                if (isset($post['locales'])) {
                    $post_locales = $post['locales'];
                    unset($post['locales']);
                }
                $post['expire_date'] = (isset($post['forever'])) ? null : $post['expire_date'];
                unset($post['forever']);

                // insert data
                $id = $this->Article_model->InsertRecord($post);
                $title_name = '';
                if ($id && isset($post_locales)) {
                    $insert_locales = [];
                    foreach ($post_locales as $id_localization => $post_local) {
                        $insert_locales[] = [
                            'id_article'      => $id,
                            'title'           => $post_local['title'],
                            'teaser'          => $post_local['teaser'],
                            'description'     => $post_local['description'],
                            'id_localization' => $id_localization,
                        ];
                        $title_name = ($title_name == '') ? $post_local['title'] : $title_name;
                    }
                    $post['locales'] = $insert_locales;
                    $this->Article_model->InsertDetailRecord($insert_locales);
                }
                $post_image = $_FILES;
                if ($post_image['thumbnail_image']['tmp_name']) {
                    $filename = url_title($title_name.'-thumb', '_', true);
                    $picture_db = file_copy_to_folder($post_image['thumbnail_image'], UPLOAD_DIR.'article/', $filename);
                    copy_image_resize_to_folder(UPLOAD_DIR.'article/'.$picture_db, UPLOAD_DIR.'article/', 'tmb_'.$filename, IMG_THUMB_WIDTH, IMG_THUMB_HEIGHT);
                    copy_image_resize_to_folder(UPLOAD_DIR.'article/'.$picture_db, UPLOAD_DIR.'article/', 'sml_'.$filename, IMG_SMALL_WIDTH, IMG_SMALL_HEIGHT);
                    // update data
                    $this->Article_model->UpdateRecord($id, ['thumbnail_image' => $picture_db]);
                }
                if ($post_image['primary_image']['tmp_name']) {
                    $filename = url_title($title_name, '_', true);
                    $picture_db = file_copy_to_folder($post_image['primary_image'], UPLOAD_DIR.'article/', $filename);
                    copy_image_resize_to_folder(UPLOAD_DIR.'article/'.$picture_db, UPLOAD_DIR.'article/', 'tmb_'.$filename, IMG_THUMB_WIDTH, IMG_THUMB_HEIGHT);
                    copy_image_resize_to_folder(UPLOAD_DIR.'article/'.$picture_db, UPLOAD_DIR.'article/', 'sml_'.$filename, IMG_SMALL_WIDTH, IMG_SMALL_HEIGHT);
                    // update data
                    $this->Article_model->UpdateRecord($id, ['primary_image' => $picture_db]);
                }
                // insert to log
                $data_log = [
                    'id_user'  => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action'   => 'Article',
                    'desc'     => 'Add Article; ID: '.$id.'; Data: '.json_encode($post),
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
        $record = $this->Article_model->GetArticle($id);
        if (!$record) {
            redirect($this->class_path_name);
        }
        $this->data['page_title'] = 'Edit';
        $this->data['form_action'] = site_url($this->class_path_name.'/edit/'.$id);
        $this->data['delete_picture_url'] = site_url($this->class_path_name.'/delete_picture/'.$id);
        $this->data['cancel_url'] = site_url($this->class_path_name);
        $this->data['locales'] = $this->Article_model->GetLocalization();
        $this->data['statuses'] = $this->Article_model->GetStatus();
        $this->data['categories'] = $this->Article_model->GetCategories();
        if ($this->input->post()) {
            $post = $this->input->post();
            if ($this->validateForm($id)) {
                if (isset($post['locales'])) {
                    $post_locales = $post['locales'];
                    unset($post['locales']);
                }
                $post['modify_date'] = date('Y-m-d H:i:s');
                $post['expire_date'] = (isset($post['forever'])) ? null : $post['expire_date'];
                unset($post['forever']);

                // update data
                $this->Article_model->UpdateRecord($id, $post);
                $title_name = '';
                // delete/purge detail content before new insert
                $this->Article_model->DeleteDetailRecordByID($id);
                if (isset($post_locales)) {
                    $insert_locales = [];
                    foreach ($post_locales as $id_localization => $post_local) {
                        $insert_locales[] = [
                            'id_article'      => $id,
                            'title'           => $post_local['title'],
                            'teaser'          => $post_local['teaser'],
                            'description'     => $post_local['description'],
                            'id_localization' => $id_localization,
                        ];
                        $title_name = ($title_name == '') ? $post_local['title'] : $title_name;
                    }
                    $post['locales'] = $insert_locales;
                    $this->Article_model->InsertDetailRecord($insert_locales);
                }
                $post_image = $_FILES;
                if ($post_image['thumbnail_image']['tmp_name']) {
                    $filename = url_title($title_name.'-thumb', '_', true);
                    if ($record['thumbnail_image'] != '' && file_exists(UPLOAD_DIR.'article/'.$record['thumbnail_image'])) {
                        unlink(UPLOAD_DIR.'article/'.$record['thumbnail_image']);
                        @unlink(UPLOAD_DIR.'article/tmb_'.$record['thumbnail_image']);
                        @unlink(UPLOAD_DIR.'article/sml_'.$record['thumbnail_image']);
                    }
                    $picture_db = file_copy_to_folder($post_image['thumbnail_image'], UPLOAD_DIR.'article/', $filename);
                    copy_image_resize_to_folder(UPLOAD_DIR.'article/'.$picture_db, UPLOAD_DIR.'article/', 'tmb_'.$filename, IMG_THUMB_WIDTH, IMG_THUMB_HEIGHT);
                    copy_image_resize_to_folder(UPLOAD_DIR.'article/'.$picture_db, UPLOAD_DIR.'article/', 'sml_'.$filename, IMG_SMALL_WIDTH, IMG_SMALL_HEIGHT);
                    // update data
                    $this->Article_model->UpdateRecord($id, ['thumbnail_image' => $picture_db]);
                }
                if ($post_image['primary_image']['tmp_name']) {
                    $filename = url_title($title_name, '_', true);
                    if ($record['primary_image'] != '' && file_exists(UPLOAD_DIR.'article/'.$record['primary_image'])) {
                        unlink(UPLOAD_DIR.'article/'.$record['primary_image']);
                        @unlink(UPLOAD_DIR.'article/tmb_'.$record['primary_image']);
                        @unlink(UPLOAD_DIR.'article/sml_'.$record['primary_image']);
                    }
                    $picture_db = file_copy_to_folder($post_image['primary_image'], UPLOAD_DIR.'article/', $filename);
                    copy_image_resize_to_folder(UPLOAD_DIR.'article/'.$picture_db, UPLOAD_DIR.'article/', 'tmb_'.$filename, IMG_THUMB_WIDTH, IMG_THUMB_HEIGHT);
                    copy_image_resize_to_folder(UPLOAD_DIR.'article/'.$picture_db, UPLOAD_DIR.'article/', 'sml_'.$filename, IMG_SMALL_WIDTH, IMG_SMALL_HEIGHT);
                    // update data
                    $this->Article_model->UpdateRecord($id, ['primary_image' => $picture_db]);
                }
                // insert to log
                $data_log = [
                    'id_user'  => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action'   => 'Article',
                    'desc'     => 'Edit Article; ID: '.$id.'; Data: '.json_encode($post),
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
                        $record = $this->Article_model->GetArticle($id);
                        if ($record) {
                            /*if ($record['thumbnail_image'] != '' && file_exists(UPLOAD_DIR.'news/'.$record['thumbnail_image'])) {
                                unlink(UPLOAD_DIR.'news/'.$record['thumbnail_image']);
                            }
                            if ($record['primary_image'] != '' && file_exists(UPLOAD_DIR.'news/'.$record['primary_image'])) {
                                unlink(UPLOAD_DIR.'news/'.$record['primary_image']);
                            }*/
                            $this->Article_model->DeleteRecord($id);
                            // insert to log
                            $data_log = [
                                'id_user'  => id_auth_user(),
                                'id_group' => id_auth_group(),
                                'action'   => 'Delete Article',
                                'desc'     => 'Delete Article; ID: '.$id.';',
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
     * delete picture.
     */
    public function delete_picture()
    {
        $this->layout = 'none';
        if ($this->input->post() && $this->input->is_ajax_request()) {
            $json = [];
            $post = $this->input->post();
            if (isset($post['id']) && $post['id'] > 0 && ctype_digit($post['id'])) {
                $detail = $this->Article_model->GetArticle($post['id']);
                $type = (isset($post['type'])) ? $post['type'] : 'primary';
                if ($detail && ($detail[$type.'_image'] != '')) {
                    $id = $post['id'];
                    unlink(UPLOAD_DIR.'article/'.$detail[$type.'_image']);
                    @unlink(UPLOAD_DIR.'article/tmb_'.$detail[$type.'_image']);
                    @unlink(UPLOAD_DIR.'article/sml_'.$detail[$type.'_image']);
                    $data_update = [$type.'_image' => ''];
                    $this->Article_model->UpdateRecord($post['id'], $data_update);
                    $json['success'] = alert_box('File hase been deleted.', 'success');
                    // insert to log
                    $data_log = [
                        'id_user'  => id_auth_user(),
                        'id_group' => id_auth_group(),
                        'action'   => 'Article',
                        'desc'     => 'Delete '.ucfirst($type).' Picture Article; ID: '.$id.';',
                    ];
                    insert_to_log($data_log);
                    // end insert to log
                } else {
                    $json['error'] = alert_box('Failed to remove File. Please try again.', 'danger');
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
        $default_locale = $this->Article_model->GetDefaultLocalization();
        $config = [
            [
                'field' => 'publish_date',
                'label' => 'Publish Date',
                'rules' => 'required',
            ],
            [
                'field' => 'uri_path',
                'label' => 'SEO URL',
                'rules' => 'required',
            ],
            [
                'field' => 'id_status',
                'label' => 'Status',
                'rules' => 'required',
            ],
            [
                'field' => 'id_article_category',
                'label' => 'Category',
                'rules' => 'required',
            ],
        ];
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() === false) {
            $this->error = alert_box(validation_errors(), 'danger');

            return false;
        } else {
            if (!check_exist_uri('article', $post['uri_path'], $id)) {
                $this->error = 'SEO URL is already used.';
            } else {
                foreach ($post['locales'] as $row => $local) {
                    if ($row == $default_locale['id_localization'] && $local['title'] == '') {
                        $this->error = 'Please insert Title.';
                        break;
                    }
                }
            }
            if (!isset($post['forever']) && $post['expire_date'] == '') {
                $this->error = 'Please input End Date.';
            }
            $post_image = $_FILES;
            if (!$this->error) {
                if (!empty($post_image['thumbnail_image']['tmp_name'])) {
                    $check_picture = validatePicture('thumbnail_image');
                    if (!empty($check_picture)) {
                        $this->error = alert_box($check_picture, 'danger');

                        return false;
                    }
                }
                if (!empty($post_image['primary_image']['tmp_name'])) {
                    $check_picture = validatePicture('primary_image');
                    if (!empty($check_picture)) {
                        $this->error = alert_box($check_picture, 'danger');

                        return false;
                    }
                }

                return true;
            } else {
                $this->error = alert_box($this->error, 'danger');

                return false;
            }
        }
    }
}
/* End of file Article.php */
/* Location: ./application/controllers/Article.php */
