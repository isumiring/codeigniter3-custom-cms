<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * HOOKS Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Hook
 * @desc hook class that load before and after the controller
 * 
 */
class FAT_Hooks {
    
    protected $CI;
    
    /**
     * set profiler
     */
    public function set_profiler() {
        $this->CI=& get_instance();
        //$this->CI->output->enable_profiler(TRUE);
    }
    
    /**
     * set caching
     */
    public function set_cache() {
        $this->CI=& get_instance();
        $this->CI->load->driver('cache',
            array('adapter' => 'file', 'backup' => 'file', 'key_prefix' => CACHE_PREFIX)
        );
    }

}

/* End of file FAT_Hooks.php */
/* Location: ./application/hooks/FAT_Hooks.php */
