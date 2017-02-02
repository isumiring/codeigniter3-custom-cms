<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Hooks Class.
 *     hook class that load before and after the controller
 *
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 *
 * @version 3.0
 *
 * @category Hook
 */
class FAT_Hooks
{
    /**
     * Load Codeigniter Super Class
     * 
     * @var object
     */
    protected $CI;

    /**
     * Class constructor.
     * 
     */
    public function __construct()
    {
        $this->CI = &get_instance();
    }

    /**
     * This function is running on post constructor.
     * 
     */
    public function set_profiler()
    {
        $this->CI->output->enable_profiler(false);
    }

    /**
     * Set Cache Library.
     * 
     */
    public function set_cache()
    {
        $this->CI->load->driver('cache',
            ['adapter' => 'file', 'backup' => 'file', 'key_prefix' => CACHE_PREFIX]
        );
    }
}

/* End of file FAT_Hooks.php */
/* Location: ./application/hooks/FAT_Hooks.php */
