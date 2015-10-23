<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Error Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Hook
 * @desc hook class that using for error handler
 * 
 */
class FAT_Error {
    
    protected $CI;
    
    /**
     * error catcher
     */
    public function error_catcher() {
        set_error_handler(array($this, 'handle_errors'));
        set_exception_handler(array($this, 'handle_exceptions'));
        register_shutdown_function(array($this, 'handle_fatal_errors'));
    }
    
    /**
     * Fatal Error Handler
     *
     * Accesses output buffers on shutdown, formats the error message and redirects
     *
     * @access	public
     * @return	void
     */
    public function handle_fatal_errors() {
        if (($error = error_get_last())) {
            $buffer = ob_get_contents();
            ob_clean();
            $message = "\nError Type: [" . $error['type'] . "] " . $this->_friendly_error_type($error['type']) . "\n";
            $message .= "Error Message: " . $error['message'] . "\n";
            $message .= "In File: " . $error['file'] . "\n";
            $message .= "At Line: " . $error['line'] . "\n";
            $message .= "Platform: " . PHP_VERSION . " (" . PHP_OS . ")\n";
            $message .= "\nBACKTRACE\n";
            $message .= $buffer;
            $message .= "\nEND\n";
            $this->_forward_error($message);
        }
    }

    /**
     * Exception Handler
     *
     * Accesses exception class on shutdown, formats the error message and redirects
     *
     * @access	public
     * @return	void
     */
    public function handle_exceptions($exception) {
        $message = "\nError Type: " . get_class($exception) . "\n";
        $message .= "Error Message: " . $exception->getMessage() . "\n";
        $message .= "In File: " . $exception->getFile() . "\n";
        $message .= "At Line: " . $exception->getLine() . "\n";
        $message .= "Platform: " . PHP_VERSION . " (" . PHP_OS . ")\n";
        $message .= "\nBACKTRACE\n";
        $message .= $exception->getTraceAsString();
        $message .= "\nEND\n";
        $this->_forward_error($message);
    }

    /**
     * Parse Error Handler
     *
     * Accesses parse errors, formats the error message and redirects
     *
     * @access	public
     * @param 	int
     * @param 	string
     * @param 	string
     * @param 	int
     * @return 	void
     */
    public function handle_errors($errno, $errstr, $errfile, $errline) {
        if (!(error_reporting() & $errno)) {
            return;
        }
        $message = "\nError Type: [" . $errno . "] " . $this->_friendly_error_type($errno) . "\n";
        $message .= "Error Message: " . $errstr . "\n";
        $message .= "In File: " . $errfile . "\n";
        $message .= "At Line: " . $errline . "\n";
        $message .= "Platform: " . PHP_VERSION . " (" . PHP_OS . ")\n";
        $message .= "\nEND\n";
        $this->_forward_error($message);
    }

    /**
     * Redirection
     *
     * Stores the error message in session and redirects to inhibitor hanlder
     *
     * @access	private
     * @param	string
     * @return	void
     */
    private function _forward_error($message) {
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
        $this->CI->load->library('session');
        $this->CI->session->set_flashdata('error_exception', $message);
        redirect('error', 'refresh');
    }

    /**
     * Error Type Helper
     *
     * Translates error codes to something more human
     *
     * @access	private
     * @param	string
     * @return	string
     */
    private function _friendly_error_type($type) {
        switch ($type) {
            case E_ERROR: // 1
                return 'Fatal error';
            case E_WARNING: // 2
                return 'Warning';
            case E_PARSE: // 4
                return 'Parse error';
            case E_NOTICE: // 8
                return 'Notice';
            case E_CORE_ERROR: // 16
                return 'Core fatal error';
            case E_CORE_WARNING: // 32
                return 'Core warning';
            case E_COMPILE_ERROR: // 64
                return 'Compile-time fatal error';
            case E_COMPILE_WARNING: // 128
                return 'Compile-time warning';
            case E_USER_ERROR: // 256
                return 'Fatal user-generated error';
            case E_USER_WARNING: // 512
                return 'User-generated warning';
            case E_USER_NOTICE: // 1024
                return 'User-generated notice';
            case E_STRICT: // 2048
                return 'E_STRICT';
            case E_RECOVERABLE_ERROR: // 4096
                return 'Catchable fatal error';
            case E_DEPRECATED: // 8192
                return 'E_DEPRECATED';
            case E_USER_DEPRECATED: // 16384
                return 'E_USER_DEPRECATED';
        }
        return $type;
    }

}

/* End of file FAT_Error.php */
/* Location: ./application/hooks/FAT_Error.php */
