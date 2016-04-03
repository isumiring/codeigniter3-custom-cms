<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Pagination extend class.
 *
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 *
 * @category library
 */
class FAT_Pagination extends CI_Pagination
{
    public $is_ajax = false;
    public $display_prev_link = false;
    public $display_next_link = false;
    public $base_url = '';
    public $prefix = '';
    public $suffix = '';
    public $total_rows = 0;
    public $per_page = 10;
    public $num_links = 2;
    public $cur_page = 0;
    public $use_page_numbers = false;
    public $first_link = '&lsaquo; First';
    public $next_link = '&gt;';
    public $prev_link = '&lt;';
    public $last_link = 'Last &rsaquo;';
    public $uri_segment = 3;
    public $full_tag_open = '';
    public $full_tag_close = '';
    public $first_tag_open = '';
    public $first_tag_close = '';
    public $last_tag_open = '';
    public $last_tag_close = '';
    public $first_url = '';
    public $cur_tag_open = '<strong>';
    public $cur_tag_close = '</strong>';
    public $next_tag_open = '';
    public $next_tag_close = '';
    public $prev_tag_open = '';
    public $prev_tag_close = '';
    public $num_tag_open = '';
    public $num_tag_close = '';
    public $page_query_string = false;
    public $query_string_segment = 'per_page';
    public $display_pages = true;
    public $_attributes = '';
    public $_link_types = [];
    public $reuse_query_string = false;
    public $data_page_attr = 'data-ci-pagination-page';

    // --------------------------------------------------------------------

    /**
     * Constructor.
     *
     * @param array $params Initialization parameters
     *
     * @return void
     */
    public function __construct($params = [])
    {
        $this->initialize($params);
        log_message('debug', 'Pagination Class Initialized');
    }

    // --------------------------------------------------------------------

    /**
     * Initialize Preferences.
     *
     * @param array $params Initialization parameters
     *
     * @return void
     */
    public function initialize(array $params = [])
    {
        $attributes = [];

        if (isset($params['attributes']) && is_array($params['attributes'])) {
            $attributes = $params['attributes'];
            unset($params['attributes']);
        }

        // Deprecated legacy support for the anchor_class option
        // Should be removed in CI 3.1+
        if (isset($params['anchor_class'])) {
            empty($params['anchor_class']) or $attributes['class'] = $params['anchor_class'];
            unset($params['anchor_class']);
        }

        $this->_parse_attributes($attributes);

        if (count($params) > 0) {
            foreach ($params as $key => $val) {
                if (isset($this->$key)) {
                    $this->$key = $val;
                }
            }
        }
    }

    // --------------------------------------------------------------------

    /**
     * Generate the pagination links.
     *
     * @return string
     */
    public function create_links()
    {
        // If our item count or per-page total is zero there is no need to continue.
        if ($this->total_rows === 0 or $this->per_page === 0) {
            return '';
        }

        // Calculate the total number of pages
        $num_pages = (int) ceil($this->total_rows / $this->per_page);

        // Is there only one page? Hm... nothing more to do here then.
        if ($num_pages === 1) {
            //$uri_page_number = 1;
            //return '';
        }

        // Set the base page index for starting page number
        $base_page = ($this->use_page_numbers) ? 1 : 0;

        // Determine the current page number.
        $CI = &get_instance();

        // See if we are using a prefix or suffix on links
        if ($this->prefix !== '' or $this->suffix !== '') {
            $this->cur_page = (int) str_replace([$this->prefix, $this->suffix], '', $CI->uri->rsegment($this->uri_segment));
        }

        if ($CI->config->item('enable_query_strings') === true or $this->page_query_string === true) {
            if ($CI->input->get($this->query_string_segment) != $base_page) {
                $this->cur_page = (int) $CI->input->get($this->query_string_segment);
            }
        } elseif (!$this->cur_page && $CI->uri->segment($this->uri_segment) !== $base_page) {
            $this->cur_page = (int) $CI->uri->rsegment($this->uri_segment);
        }

        // Set current page to 1 if it's not valid or if using page numbers instead of offset
        if (!is_numeric($this->cur_page) or ($this->use_page_numbers && $this->cur_page === 0)) {
            $this->cur_page = $base_page;
        }

        $this->num_links = (int) $this->num_links;

        if ($this->num_links < 1) {
            show_error('Your number of links must be a positive number.');
        }

        // Is the page number beyond the result range?
        // If so we show the last page
        if ($this->use_page_numbers) {
            if ($this->cur_page > $num_pages) {
                $this->cur_page = $num_pages;
            }
        } elseif ($this->cur_page > $this->total_rows) {
            $this->cur_page = ($num_pages - 1) * $this->per_page;
        }

        $uri_page_number = $this->cur_page;

        if (!$this->use_page_numbers) {
            $this->cur_page = (int) floor(($this->cur_page / $this->per_page) + 1);
        }

        // Calculate the start and end numbers. These determine
        // which number to start and end the digit links with
        $start = (($this->cur_page - $this->num_links) > 0) ? $this->cur_page - ($this->num_links - 1) : 1;
        $end = (($this->cur_page + $this->num_links) < $num_pages) ? $this->cur_page + $this->num_links : $num_pages;

        // Is pagination being used over GET or POST? If get, add a per_page query
        // string. If post, add a trailing slash to the base URL if needed
        if ($CI->config->item('enable_query_strings') === true or $this->page_query_string === true) {
            $segment = (strpos($this->base_url, '?')) ? '&amp;' : '?';
            $this->base_url = rtrim($this->base_url).$segment.$this->query_string_segment.'=';
        } else {
            $this->base_url = rtrim($this->base_url, '/').'/';
        }

        // And here we go...
        $output = '';
        $query_string = '';

        // Add anything in the query string back to the links
        // Note: Nothing to do with query_string_segment or any other query string options
        if ($this->reuse_query_string === true) {
            $get = $CI->input->get();

            // Unset the controll, method, old-school routing options
            unset($get['c'], $get['m'], $get[$this->query_string_segment]);

            if (!empty($get)) {
                // Put everything else onto the end
                $query_string = (strpos($this->base_url, '?') !== false ? '&amp;' : '?')
                        .http_build_query($get, '', '&amp;');

                // Add this after the suffix to put it into more links easily
                $this->suffix .= $query_string;
            }
        }

        // Render the "First" link
        if ($this->first_link !== false && $this->cur_page > ($this->num_links + 1)) {
            $first_url = ($this->first_url === '') ? $this->base_url : $this->first_url;

            // Take the general parameters, and squeeze this pagination-page attr in there for JS fw's
            $attributes = sprintf('%s %s="%d"', $this->_attributes, $this->data_page_attr, 1);
            $output .= $this->first_tag_open.'<a '.$this->href_url($first_url).$attributes.$this->_attr_rel('start').'>'
                    .$this->first_link.'</a>'.$this->first_tag_close;
        }

        // Render the "previous" link
        if ($this->prev_link !== false && $this->cur_page !== 1) {
            $i = ($this->use_page_numbers) ? $uri_page_number - 1 : $uri_page_number - $this->per_page;

            // Take the general parameters, and squeeze this pagination-page attr in there for JS fw's
            $attributes = sprintf('%s %s="%d"', $this->_attributes, $this->data_page_attr, (int) $i);

            if ($i === $base_page && $this->first_url !== '') {
                $output .= $this->prev_tag_open.'<a '.$this->href_url($this->first_url.$query_string).$attributes.$this->_attr_rel('prev').'>'
                        .$this->prev_link.'</a>'.$this->prev_tag_close;
            } else {
                $append = ($i === $base_page) ? $query_string : $this->prefix.$i.$this->suffix;
                $output .= $this->prev_tag_open.'<a '.$this->href_url($this->base_url.$append).$attributes.$this->_attr_rel('prev').'>'
                        .$this->prev_link.'</a>'.$this->prev_tag_close;
            }
        }
        // !!!!!!!! START EDITION !!!!!!!!!!
        elseif ($this->display_prev_link && $this->cur_page === 1) {
            $output .= $this->prev_tag_open.'<a class="disabled">'.$this->prev_link.'</a>'.$this->next_tag_close;
        }
        // !!!!!!!! END EDITION !!!!!!!!!!
        // Render the pages
        if ($this->display_pages !== false) {
            // Write the digit links
            for ($loop = $start - 1; $loop <= $end; $loop++) {
                $i = ($this->use_page_numbers) ? $loop : ($loop * $this->per_page) - $this->per_page;

                // Take the general parameters, and squeeze this pagination-page attr in there for JS fw's
                $attributes = sprintf('%s %s="%d"', $this->_attributes, $this->data_page_attr, (int) $i);

                if ($i >= $base_page) {
                    if ($this->cur_page === $loop) {
                        $output .= $this->cur_tag_open.$loop.$this->cur_tag_close; // Current page
                    } else {
                        $n = ($i === $base_page) ? '' : $i;
                        if ($n === '' && !empty($this->first_url)) {
                            //$output .= $this->num_tag_open.'<a href="'.$this->first_url.$query_string.'"'.$attributes.$this->_attr_rel('start').'>'
                            //  .$loop.'</a>'.$this->num_tag_close;
                        } else {
                            $append = ($n === '') ? $query_string : $this->prefix.$n.$this->suffix;
                            $output .= $this->num_tag_open.'<a '.$this->href_url($this->base_url.$append).$attributes.$this->_attr_rel('start').'>'
                                    .$loop.'</a>'.$this->num_tag_close;
                        }
                    }
                }
            }
        }

        // Render the "next" link
        if ($this->next_link !== false && $this->cur_page < $num_pages) {
            $i = ($this->use_page_numbers) ? $this->cur_page + 1 : $this->cur_page * $this->per_page;

            // Take the general parameters, and squeeze this pagination-page attr in there for JS fw's
            $attributes = sprintf('%s %s="%d"', $this->_attributes, $this->data_page_attr, (int) $i);

            $output .= $this->next_tag_open.'<a '.$this->href_url($this->base_url.$this->prefix.$i.$this->suffix).$attributes
                    .$this->_attr_rel('next').'>'.$this->next_link.'</a>'.$this->next_tag_close;
        }
        // !!!!!!!! START EDITION !!!!!!!!!!
        elseif ($this->display_next_link && $this->cur_page >= $num_pages) {
            $output .= $this->next_tag_open.'<a class="disabled">'.$this->next_link.'</a>'.$this->next_tag_close;
        }
        // !!!!!!!! END EDITION !!!!!!!!!!
        // Render the "Last" link
        if ($this->last_link !== false && ($this->cur_page + $this->num_links) < $num_pages) {
            $i = ($this->use_page_numbers) ? $num_pages : ($num_pages * $this->per_page) - $this->per_page;

            // Take the general parameters, and squeeze this pagination-page attr in there for JS fw's
            $attributes = sprintf('%s %s="%d"', $this->_attributes, $this->data_page_attr, (int) $i);

            $output .= $this->last_tag_open.'<a '.$this->href_url($this->base_url.$this->prefix.$i.$this->suffix).$attributes.'>'
                    .$this->last_link.'</a>'.$this->last_tag_close;
        }

        // Kill double slashes. Note: Sometimes we can end up with a double slash
        // in the penultimate link so we'll kill all double slashes.
        $output = preg_replace('#([^:])//+#', '\\1/', $output);

        // Add the wrapper HTML if exists
        return $this->full_tag_open.$output.$this->full_tag_close;
    }

    // --------------------------------------------------------------------

    /**
     * Parse attributes.
     *
     * @param array $attributes
     *
     * @return void
     */
    public function _parse_attributes($attributes)
    {
        isset($attributes['rel']) or $attributes['rel'] = true;
        $this->_link_types = ($attributes['rel']) ? ['start' => 'start', 'prev' => 'prev', 'next' => 'next'] : [];
        unset($attributes['rel']);

        $this->_attributes = '';
        foreach ($attributes as $key => $value) {
            $this->_attributes .= ' '.$key.'="'.$value.'"';
        }
    }

    // --------------------------------------------------------------------

    /**
     * Add "rel" attribute.
     *
     * @link    http://www.w3.org/TR/html5/links.html#linkTypes
     *
     * @param string $type
     *
     * @return string
     */
    public function _attr_rel($type)
    {
        if (isset($this->_link_types[$type])) {
            unset($this->_link_types[$type]);

            return ' rel="'.$type.'"';
        }

        return '';
    }

    /**
     * print href url with conditional.
     *
     * @param string $param
     *
     * @return string href url
     */
    private function href_url($param = '')
    {
        if ($this->is_ajax) {
            return 'data-href="'.$param.'"';
        } else {
            return 'href="'.$param.'"';
        }
    }
}

/* End of file FAT_Pagination.php */
/* Location: ./application/libraries/FAT_Pagination.php */
