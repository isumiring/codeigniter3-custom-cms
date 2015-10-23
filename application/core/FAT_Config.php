<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Config Class Extension
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Core
 * @desc extension of config class to support internationalization
 * 
 */
class FAT_Config extends CI_Config
{
    function site_url($uri = '',$protocol=NULL) {    
        if (is_array($uri))
        {
            $uri = implode('/', $uri);
        }
        
        if (function_exists('get_instance'))        
        {
            $CI =& get_instance();
            $uri = $CI->lang->localized($uri);            
        }

        return parent::site_url($uri,$protocol);
    }
}
/* End of file FAT_Config.php */
/* Location: ./application/core/FAT_Config.php */