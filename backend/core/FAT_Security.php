<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Security Class Extension.
 *     extension of security class
 *
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 *
 * @version 3.0
 *
 * @category Core
 */
class FAT_Security extends CI_Security
{
    /**
     * Class Constructor.
     * 
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Reset to login page if csrf is expired.
     * 
     */
    public function csrf_show_error()
    {
        // show_error('The action you have requested is not allowed.');  // default code
        $redirect_url = PATH_CMS. 'error/csrf_redirect';
        header('Location: '. $redirect_url, true, 302);
    }
}
/* End of file FAT_Security.php */
/* Location: ./application/core/FAT_Security.php */
