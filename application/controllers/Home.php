<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Home Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Home Controller
 * 
 */
class Home extends CI_Controller {
    
    /**
     * load the parent constructor
     */
    public function __construct() {
        parent::__construct();
        $this->load->model(array("Slideshow_model","Article_model"));
    }
    
    /**
     * Index Page for this controller.
     * @access public
     */
    public function index() {
        // slideshows
        if (!$slideshows = $this->cache->get('frSlideshows')) {
            $slideshows = $this->Slideshow_model->GetSlideshows();
            $this->cache->save('frSlideshows',$slideshows);
        }
        $this->data['slideshows'] = $slideshows;
        // featured articles
        if (!$featured_articles = $this->cache->get('frFeaturedArticles')) {
            $param['conditions']['is_featured'] = 1;
            $featured_articles = $this->Article_model->GetArticles($param);
            $this->cache->save('frFeaturedArticles',$featured_articles);
        }
        $this->data['featured_articles'] = $featured_articles;
    }

}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */
