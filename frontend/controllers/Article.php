<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Article Class.
 * 
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * 
 * @version 3.0
 * 
 * @category Controller
 * 
 */
class Article extends CI_Controller 
{
    /**
     * This show current class.
     *
     * @var string
     */
    private $class_path_name;

    /**
     * Class constructor.
     *     load the parent constructor.
     */
    public function __construct() 
    {
        parent::__construct();
        $this->load->model(
            [
                'Pages_model',
                'Article_model'
            ]
        );
        $this->class_path_name = $this->router->fetch_class();
    }
    
    /**
     * Index Page for this controller.
     * 
     * @access public
     */
    public function index() 
    {
        $conditions = [
            'page_type' => 'module',
            'module'    => $this->class_path_name
        ];
        $page_info = $this->Pages_model->GetPageInfo($conditions);
        if ( ! $page_info) {
            show_404();
            exit();
        }
        $params = [];
        $this->data['page_info']  = $page_info;
        $this->data['page_title'] = $page_info['page_name'];
        if ($page_info['thumbnail_image'] != '' || $page_info['primary_image'] != '') {
            $this->data['head_image'] = ($page_info['thumbnail_image'] != '') ? base_url('uploads/pages/'. $page_info['thumbnail_image']) : base_url('uploads/pages/'. $page_info['primary_image']);
        }

        $total_records = $this->Article_model->CountArticles($params);

        if ($this->input->get_post('perpage')) {
            $params['limit']['from'] = (int)$this->input->get_post('perpage');
            $paging['base_url']      = current_url();
        }

        $this->data['records'] = $this->Article_model->GetArticles($params);

        $paging['per_page']   = SHOW_RECORDS_DEFAULT;
        $paging['total_rows'] = $total_records;
        $paging['is_ajax']    = false;

        $this->data['pagination'] = custom_pagination($paging);

        // article categories
        $this->data['categories'] = $this->Article_model->GetCategories();
    }
    
    /**
     * Categories.
     * 
     * @access public
     * 
     * @param string $uri
     */
    public function category($uri = '') 
    {
        if (! $uri) {
            show_404();
        }
        $conditions = [
            'page_type' => 'module',
            'module'    => $this->class_path_name
        ];
        $page_info = $this->Pages_model->GetPageInfo($conditions);
        if ( ! $page_info) {
            show_404();
            exit();
        }
        $category_info = $this->Article_model->GetCategoryInfo(['uri_path' => $uri]);
        if ( ! $category_info) {
            show_404();
            exit();
        }
        $params = [];
        $this->data['page_info']  = $page_info;
        $this->data['page_title'] = $page_info['page_name'];
        if ($page_info['thumbnail_image'] != '' || $page_info['primary_image'] != '') {
            $this->data['head_image'] = ($page_info['thumbnail_image'] != '') ? base_url('uploads/pages/'. $page_info['thumbnail_image']) : base_url('uploads/pages/'. $page_info['primary_image']);
        }

        $this->data['breadcrumbs'] = [
            'text'  => $category_info['title'],
            'url'   => '#',
            'class' => 'active',
        ];

        $params['conditions'][$this->Article_model->GetIdentifier('parent_key_category')] = $category_info[$this->Article_model->GetIdentifier('parent_key_category')];

        $total_records = $this->Article_model->CountArticles($params);


        if ($this->input->get_post('perpage')) {
            $params['limit']['from'] = (int)$this->input->get_post('perpage');
            $paging['base_url']      = current_url();
        }

        $this->data['records'] = $this->Article_model->GetArticles($params);

        $paging['per_page']   = SHOW_RECORDS_DEFAULT;
        $paging['total_rows'] = $total_records;
        $paging['is_ajax']    = false;

        $this->data['pagination'] = custom_pagination($paging);

        // article categories
        $this->data['categories'] = $this->Article_model->GetCategories();

        $this->data['template'] = $this->class_path_name. '/'. $this->class_path_name;
    }
    
    /**
     * Detail page.
     * 
     * @param string $uri
     */
    public function detail($uri = '') 
    {
        if (! $uri) {
            show_404();
        }
        $conditions = [
            'page_type' => 'module',
            'module'    => $this->class_path_name
        ];
        $page_info = $this->Pages_model->GetPageInfo($conditions);
        if ( ! $page_info) {
            show_404();
            exit();
        }
        $params = [
            'uri_path' => $uri
        ];
        $record = $this->Article_model->GetArticleInfo($params);
        if ( ! $record) {
            show_404();
            exit();
        }
        $param_category = [
            $this->Article_model->GetIdentifier('parent_key_category') => $record[$this->Article_model->GetIdentifier('parent_key_category')]
        ];
        $category_info = $this->Article_model->GetCategoryInfo($param_category);
        if ($category_info) {
            $this->data['breadcrumbs']      = [
                'text'  => $category_info['title'],
                'url'   => '#',
                'class' => 'active'
            ];
        }
        $this->data['page_info'] = $page_info;

        $this->data['page_title']       = $record['title'];
        $this->data['head_description'] = word_limiter(strip_tags($record['description']), 10);
        if ($record['thumbnail_image'] != '' || $record['primary_image'] != '') {
            $this->data['head_image'] = ($record['thumbnail_image'] != '') ? base_url('uploads/article/'. $record['thumbnail_image']) : base_url('uploads/article/'. $record['primary_image']);
        }
        $this->data['article']    = $record;

        // article categories
        $this->data['categories'] = $this->Article_model->GetCategories();
    }
    
}

/* End of file Article.php */
/* Location: ./application/controllers/Article.php */
