<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Slideshow Class.
 *
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 *
 * @version 3.0
 *
 * @category Controller
 * @desc Slideshow Controller
 */
class Slideshow extends CI_Controller
{
    private $class_path_name;
    private $error;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Slideshow_model');
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
            $count_all_records = $this->Slideshow_model->CountAllSlideshow();
            $count_filtered_records = $this->Slideshow_model->CountAllSlideshow($param);
            $records = $this->Slideshow_model->GetAllSlideshowData($param);
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
                $return['data'][$row]['url_link'] = $record['url_link'];
                $return['data'][$row]['position'] = $record['position'];
                $return['data'][$row]['status_text'] = ucfirst($record['status_text']);
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
        $this->data['locales'] = $this->Slideshow_model->GetLocalization();
        $this->data['statuses'] = $this->Slideshow_model->GetStatus();
        $this->data['max_position'] = $this->Slideshow_model->GetMaxPosition();
        if ($this->input->post()) {
            $post = $this->input->post();
            if ($this->validateForm()) {
                if (isset($post['locales'])) {
                    $post_locales = $post['locales'];
                    unset($post['locales']);
                }
                if ($post['url_link'] != '' && $post['url_link'] != '#') {
                    $post['url_link'] = prep_url($post['url_link']);
                }
                // insert data
                $id = $this->Slideshow_model->InsertRecord($post);
                $title_name = '';
                if ($id && isset($post_locales)) {
                    $insert_locales = [];
                    foreach ($post_locales as $id_localization => $post_local) {
                        $insert_locales[] = [
                            'id_slideshow'    => $id,
                            'title'           => $post_local['title'],
                            'caption'         => $post_local['caption'],
                            'id_localization' => $id_localization,
                        ];
                        $title_name = ($title_name == '') ? $post_local['title'] : $title_name;
                    }
                    $post['locales'] = $insert_locales;
                    $this->Slideshow_model->InsertDetailRecord($insert_locales);
                }

                $post_image = $_FILES;
                if ($post_image['primary_image']['tmp_name']) {
                    $filename = url_title($title_name, '_', true);
                    $picture_db = file_copy_to_folder($post_image['primary_image'], UPLOAD_DIR.'slideshow/', $filename);
                    $this->Slideshow_model->UpdateRecord($id, ['primary_image' => $picture_db]);
                }
                // insert to log
                $data_log = [
                    'id_user'  => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action'   => 'Slideshow',
                    'desc'     => 'Add Slideshow; ID: '.$id.'; Data: '.json_encode($post),
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
        $record = $this->Slideshow_model->GetSlideshow($id);
        if (!$record) {
            redirect($this->class_path_name);
        }
        $this->data['page_title'] = 'Edit';
        $this->data['form_action'] = site_url($this->class_path_name.'/edit/'.$id);
        $this->data['cancel_url'] = site_url($this->class_path_name);
        $this->data['locales'] = $this->Slideshow_model->GetLocalization();
        $this->data['statuses'] = $this->Slideshow_model->GetStatus();
        if ($this->input->post()) {
            $post = $this->input->post();
            if ($this->validateForm($id)) {
                if (isset($post['locales'])) {
                    $post_locales = $post['locales'];
                    unset($post['locales']);
                }
                if ($post['url_link'] != '' && $post['url_link'] != '#') {
                    $post['url_link'] = prep_url($post['url_link']);
                }
                $post['modify_date'] = date('Y-m-d H:i:s');

                // update data
                $this->Slideshow_model->UpdateRecord($id, $post);

                $title_name = '';
                // delete/purge detail content before new insert
                $this->Slideshow_model->DeleteDetailRecordByID($id);
                if ($id && isset($post_locales)) {
                    $insert_locales = [];
                    foreach ($post_locales as $id_localization => $post_local) {
                        $insert_locales[] = [
                            'id_slideshow'    => $id,
                            'title'           => $post_local['title'],
                            'caption'         => $post_local['caption'],
                            'id_localization' => $id_localization,
                        ];
                        $title_name = ($title_name == '') ? $post_local['title'] : $title_name;
                    }
                    $post['locales'] = $insert_locales;
                    $this->Slideshow_model->InsertDetailRecord($insert_locales);
                }

                $post_image = $_FILES;
                if ($post_image['primary_image']['tmp_name']) {
                    $filename = url_title($title_name, '_', true);
                    // delete file if exists
                    if ($record['primary_image'] != '' && file_exists(UPLOAD_DIR.'slideshow/'.$record['primary_image'])) {
                        unlink(UPLOAD_DIR.'slideshow/'.$record['primary_image']);
                    }
                    $picture_db = file_copy_to_folder($post_image['primary_image'], UPLOAD_DIR.'slideshow/', $filename);
                    $this->Slideshow_model->UpdateRecord($id, ['primary_image' => $picture_db]);
                }
                if ($post_image['mobile_image']['tmp_name']) {
                    $filename = url_title($title_name.'-mob', '_', true);
                    // delete file if exists
                    if ($record['mobile_image'] != '' && file_exists(UPLOAD_DIR.'slideshow/'.$record['mobile_image'])) {
                        unlink(UPLOAD_DIR.'slideshow/'.$record['mobile_image']);
                    }
                    $picture_db = file_copy_to_folder($post_image['mobile_image'], UPLOAD_DIR.'slideshow/', $filename);
                    $this->Slideshow_model->UpdateRecord($id, ['mobile_image' => $picture_db]);
                }
                if ($post_image['video']['tmp_name']) {
                    $filename = url_title('vidz-'.$title_name, '_', true);
                    // delete file if exists
                    if ($record['video'] != '' && file_exists(UPLOAD_DIR.'slideshow/'.$record['video'])) {
                        unlink(UPLOAD_DIR.'slideshow/'.$record['video']);
                    }
                    $picture_db = file_copy_to_folder($post_image['video'], UPLOAD_DIR.'slideshow/', $filename);
                    $this->Slideshow_model->UpdateRecord($id, ['video' => $picture_db]);
                }
                if ($post_image['video_mobile_1']['tmp_name']) {
                    $filename = url_title('m1vidz-'.$title_name, '_', true);
                    // delete file if exists
                    if ($record['video_mobile_1'] != '' && file_exists(UPLOAD_DIR.'slideshow/'.$record['video_mobile_1'])) {
                        unlink(UPLOAD_DIR.'slideshow/'.$record['video_mobile_1']);
                    }
                    $picture_db = file_copy_to_folder($post_image['video_mobile_1'], UPLOAD_DIR.'slideshow/', $filename);
                    $this->Slideshow_model->UpdateRecord($id, ['video_mobile_1' => $picture_db]);
                }
                if ($post_image['video_mobile_2']['tmp_name']) {
                    $filename = url_title('m2vidz-'.$title_name, '_', true);
                    // delete file if exists
                    if ($record['video_mobile_2'] != '' && file_exists(UPLOAD_DIR.'slideshow/'.$record['video_mobile_2'])) {
                        unlink(UPLOAD_DIR.'slideshow/'.$record['video_mobile_2']);
                    }
                    $picture_db = file_copy_to_folder($post_image['video_mobile_2'], UPLOAD_DIR.'slideshow/', $filename);
                    $this->Slideshow_model->UpdateRecord($id, ['video_mobile_2' => $picture_db]);
                }
                // insert to log
                $data_log = [
                    'id_user'  => id_auth_user(),
                    'id_group' => id_auth_group(),
                    'action'   => 'Slideshow',
                    'desc'     => 'Edit Slideshow; ID: '.$id.'; Data: '.json_encode($post),
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
                        $record = $this->Slideshow_model->GetSlideshow($id);
                        if ($record) {
                            $this->Slideshow_model->DeleteRecord($id);
                            // insert to log
                            $data_log = [
                                'id_user'  => id_auth_user(),
                                'id_group' => id_auth_group(),
                                'action'   => 'Delete Slideshow',
                                'desc'     => 'Delete Slideshow; ID: '.$id.';',
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
        $default_locale = $this->Slideshow_model->GetDefaultLocalization();
        $config = [
            [
                'field' => 'id_status',
                'label' => 'Status',
                'rules' => 'required',
            ],
        ];
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() === false) {
            $this->error = alert_box(validation_errors(), 'danger');

            return false;
        } else {
            foreach ($post['locales'] as $row => $local) {
                if ($row == $default_locale['id_localization'] && $local['title'] == '') {
                    $this->error = 'Please insert Title.';
                    break;
                }
            }
            $post_image = $_FILES;
            if (!$this->error) {
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
/* End of file Slideshow.php */
/* Location: ./application/controllers/Slideshow.php */
