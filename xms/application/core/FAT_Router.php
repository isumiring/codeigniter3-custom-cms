<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Router Class Extension
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Core
 * @desc extension of router class
 * 
 */
class FAT_Router extends CI_Router {

    /**
     * load the constructor
     */
    function __construct() {
        parent::__construct();
    }
    
    /**
     * set routes to lowercaser
     * @return string routes
     */
    public function _parse_routes() {
        foreach ($this->uri->segments as &$segment) {
            $segment = strtolower($segment);
        }

        return parent::_parse_routes();
    }

}
