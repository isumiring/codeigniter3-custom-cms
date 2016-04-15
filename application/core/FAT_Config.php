<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Config Class Extension.
 *     extension of config class to support internationalization.
 *
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 *
 * @version 3.0
 *
 * @category Core
 */
class FAT_Config extends CI_Config
{
    /**
     * Replace the deafult site url.
     *
     * @param string $uri
     * @param string $protocol
     *
     * @return string site url
     */
    public function site_url($uri = '', $protocol = null)
    {
        if (is_array($uri)) {
            $uri = implode('/', $uri);
        }

        if (function_exists('get_instance')) {
            $CI = &get_instance();
            $uri = $CI->lang->localized($uri);
        }

        return parent::site_url($uri, $protocol);
    }
}
/* End of file FAT_Config.php */
/* Location: ./application/core/FAT_Config.php */
