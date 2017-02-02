<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @desc using for general need.
 * use $CI=& get_instance() for get CI instance inside the helper.
 * example : use $ci->load->database() to connect a db after you declare $ci=&get_instance().
 *
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 */

/**
 * Create PDF.
 * 
 * @param  string  $html
 * @param  string  $filename
 * @param  boolean $stream
 * 
 * @return mixed output pdf
 */
use Dompdf\Dompdf;
function pdf_create($html, $filename = '', $stream = true) 
{

    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->render();
    if ($stream) {
        $dompdf->stream($filename.".pdf");
    } else {
        return $dompdf->output();
    }
}

/* End of file dompdf_helper.php */
/* Location: ./application/helpers/dompdf_helper.php */