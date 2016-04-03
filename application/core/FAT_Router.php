<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Router Class Extension.
 *     extension of router class.
 *
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 *
 * @version 3.0
 *
 * @category Core
 */
class FAT_Router extends CI_Router
{
    /**
     * Class constructor.
     *     load parent constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Set routes to lowercaser.
     *
     * @return string routes
     */
    public function _parse_routes()
    {
        foreach ($this->uri->segments as &$segment) {
            $segment = strtolower($segment);
        }

        return parent::_parse_routes();
    }
}
/* End of file FAT_Router.php */
/* Location: ./application/core/FAT_Router.php */
