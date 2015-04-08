<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * @file
 * using for general need.
 * 
 * use $CI=& get_instance() for get CI instance inside the helper.
 *  
 * example : use $ci->load->database() to connect a db after you declare $ci=&get_instance().
 * 
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 */

/**
 * custom date formate
 * @param string $string
 * @param string $format
 * @return string $return
 */
function custDateFormat($string, $format = 'Y-m-d H:i:s') {
    $return = date($format,strtotime($string));
    return $return;
}

/**
 * generate alert box notification with close button
 * style is based on bootstrap 3
 * @author ivan lubis
 * @param string $msg notification message
 * @param string $type type of notofication
 * @param boolean $close_button close button
 * @return string notification with html tag
 */
function alert_box($msg,$type='warning',$close_button=TRUE) {
    $html = '';
    if ($msg != '') {
        $html .= '<div class="alert alert-' . $type . ' alert-dismissible" role="alert">';
        if ($close_button) {
            $html .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        }
        $html .= $msg;
        $html .= '</div>';
    }
    return $html;
}

/**
 * get site setting into array
 * @return array $return
 */
function get_sitesetting() {
    $CI = & get_instance();
    $CI->load->database();
    $return = array();
    $query = $CI->db
            ->select('setting.type,setting.value')
            ->where('sites.id_ref_publish', 1)
            ->where('sites.is_delete', 0)
            ->where('sites.is_default', 1)
            ->join('sites', 'sites.id_site=setting.id_site', 'left')
            ->order_by('setting.id_setting', 'asc')
            ->get('setting')->result_array();
    foreach ($query as $row => $val) {
        $return[$val['type']] = $val['value'];
    }
    return $return;
}

/**
 * get current controller value
 * @param string $param
 * @return string current controller url
 */
function current_controller($param = '') {
    $param = '/' . $param;
    $CI = & get_instance();
    $dir = $CI->router->directory;
    $class = $CI->router->fetch_class();
    return base_url() . $dir . $class . $param;
}

/**
 * set/convert query condition
 * @param array $param
 * @param array $alias
 * @return string query condition
 */
function q_where($param, $alias)
{
    $where = '';
    foreach ($param as $key => $val) {
        if (substr($key, 0, 6) == 'search') {
            $field = ($alias[$key] != '') ? $alias[$key] : substr($key, 7);
            if ($val) {
                $where .= "and LCASE($field)  like '%".strtolower($val)."%' ";
            }
        }
        if (substr($key, 0, 10) == 'search_opt') {
            $field = ($alias[$key] != '') ? $alias[$key] : substr($key, 11);
            if ($val != '') {
                $where .= "and $field = '".$val."' ";
            }
        }
    }
    return $where;
}

/**
 * return grid data from query
 * @param string $query
 * @param string $alias
 * @param string $group_by
 * @return array data
 */
function query_grid($query, $alias=array(), $group_by='')
{
    $CI = & get_instance();
    $CI->layout = 'blank';
    $param = $CI->input->get();
    $where = q_where($param, $alias);
    $order = "order by `$param[sort_field]` $param[sort_type]";
    $paging = "limit $param[perpage] offset $param[page]";
    $group = ($group_by) ? "group by ".$group_by : "";
    $sql = "$query $where $group";
    $data['data'] = $CI->db->query($sql . " $order $paging")->result_array();
    echo $CI->db->last_query();
    $data['total'] = $CI->db->query($sql)->num_rows();
    return $data;
}

/**
 * encrypt string to md5 value
 * @param string $string
 * @return string encryption string
 */
function md5plus($string)
{
    $CI = & get_instance();
    return '_' . md5($CI->session->encryption_key . $string);
}

/**
 * generate new token
 * @return string $code
 */
function generate_token() {
    $rand = md5(sha1('reg' . date('Y-m-d H:i:s')));
    $acceptedChars = 'abcdefghijklmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    $max = strlen($acceptedChars) - 1;
    $tmp_code = null;
    for ($i = 0; $i < 8; $i++) {
        $tmp_code .= $acceptedChars{mt_rand(0, $max)};
    }
    $code = $rand . $tmp_code;
    return $code;
}

/**
 * generate random code
 * @param int $loop
 * @return string $code
 */
function random_code($loop = 5)
{
    $acceptedChars = 'abcdefghijklmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    $max = strlen($acceptedChars) - 1;
    $tmp_code = null;
    for ($i = 0; $i < $loop; $i++) {
        $tmp_code .= $acceptedChars{mt_rand(0, $max)};
    }
    $code = $tmp_code;
    return $code;
}

/**
 * generate random number
 * @param int $loop
 * @return string $code
 */
function random_number($loop = 3)
{
    $acceptedChars = '23456789';
    $max = strlen($acceptedChars) - 1;
    $tmp_code = null;
    for ($i = 0; $i < $loop; $i++) {
        $tmp_code .= $acceptedChars{mt_rand(0, $max)};
    }
    $code = $tmp_code;
    return $code;
}

/**
 * get session admin
 * @param string $key
 * @return boolean
 */
function getSessionAdmin($key='') {
    $CI = & get_instance();
    $CI->load->library('session');
    if ($CI->session->userdata('ADM_SESS')) {
        $ADM_SESS = $CI->session->userdata('ADM_SESS');
        if ($key != '') {
            return $ADM_SESS[$key];
        } else {
            return $ADM_SESS;
        }
    } else {
        return FALSE;
    }
}

/**
 * retrieve session of admin user id
 * @author ivan lubis
 * @return string admin user id
 */
function adm_sess_userid()
{
    $CI = & get_instance();
    $CI->load->library('session');
    if ($CI->session->userdata('ADM_SESS') == '')
        $sess = 0;
    else {
        $ADM_SESS = $CI->session->userdata('ADM_SESS');
        $sess = $ADM_SESS['admin_id_auth_user'];
    }
    return $sess;
}

/**
 * get admin logged info by email session
 * @return boolean
 */
function getAdminLoggedInfo() {
    $CI = & get_instance();
    $CI->load->library('session');
    if ($CI->session->ADM_SESS == '') {
        return false;
    } else {
        $ADM_SESS = $CI->session->ADM_SESS;
        $sess = $ADM_SESS['admin_email'];
        $CI->load->database();
        $data = $CI->db
                //->select('id_auth_user')
                ->where('LCASE(email)',strtolower($sess))
                ->limit(1)
                ->get('auth_user')
                ->row_array();
        if ($data) {
            return $data;
        } else {
            return false;
        }
    }
}

/**
 * retrieve auth user id from session
 * @author ivan lubis
 * @return string admin user id
 */
function id_auth_user()
{
    $CI = & get_instance();
    $CI->load->library('session');
    if ($CI->session->ADM_SESS == '') {
        return false;
    } else {
        $ADM_SESS = $CI->session->ADM_SESS;
        $sess = $ADM_SESS['admin_email'];
        $CI->load->database();
        $data = getAdminLoggedInfo();
        if ($data) {
            return $data['id_auth_user'];
        } else {
            return false;
        }
    }
}

/**
 * check user if super admin
 * @return boolean
 */
function is_superadmin() {
    $CI = & get_instance();
    $CI->load->library('session');
    if ($CI->session->ADM_SESS == '') {
        return FALSE;
    } else {
        $data = getAdminLoggedInfo();
        if (isset($data['is_superadmin']) && $data['is_superadmin'] == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}

/**
 * retrieve session of admin user group id
 * @author ivan lubis
 * @return string admin user group id
 */
function adm_sess_usergroupid()
{
    $CI = & get_instance();
    $CI->load->library('session');
    if ($CI->session->userdata('ADM_SESS') == '')
        $sess = 0;
    else {
        $ADM_SESS = $CI->session->userdata('ADM_SESS');
        $sess = $ADM_SESS['admin_id_auth_group'];
    }
    return $sess;
}

/**
 *
 * @param int $id_user
 * @return int super admin status 
 */
function adm_is_superadmin($id_user)
{
    $return = 0;
    $CI = & get_instance();
    $CI->load->database();
    $CI->db->where('id_auth_user', $id_user);
    $CI->db->where('status', 1);
    $CI->db->limit(1);
    $query = $CI->db->get('auth_user');
    if ($query->num_rows() > 0) {
        $row = $query->row_array();
        $return = $row['is_superadmin'];
    }
    return $return;
}

/**
 *
 * @param int $id_group
 * @return int super admin group status 
 */
function adm_group_is_superadmin($id_group)
{
    $return = 0;
    $CI = & get_instance();
    $CI->load->database();
    $CI->db->where('id_auth_group', $id_group);
    $CI->db->limit(1);
    $query = $CI->db->get('auth_group');
    if ($query->num_rows() > 0) {
        $row = $query->row_array();
        $return = $row['is_superadmin'];
    }
    return $return;
}

/**
 * retrieve session of admin user site id
 * @author ivan lubis
 * @return string admin user group id
 */
function adm_sess_siteid()
{
    $CI = & get_instance();
    $CI->load->library('session');
    if ($CI->session->userdata('ADM_SESS') == '')
        $sess = 0;
    else {
        $ADM_SESS = $CI->session->userdata('ADM_SESS');
        $sess = $ADM_SESS['admin_id_site'];
    }
    return $sess;
}

/**
 * retrieve session of admin microsite user id
 * @author ivan lubis
 * @return string admin user id
 */
function adm_microsite_sess_userid()
{
    $CI = & get_instance();
    $CI->load->library('session');
    if ($CI->session->userdata('MICROSITE_SESS') == '')
        $sess = 0;
    else {
        $MICROSITE_SESS = $CI->session->userdata('MICROSITE_SESS');
        $sess = $MICROSITE_SESS['microadmin_id_auth_user'];
    }
    return $sess;
}

/**
 * retrieve session of admin microsite user group id
 * @author ivan lubis
 * @return string admin user group id
 */
function adm_microsite_sess_usergroupid()
{
    $CI = & get_instance();
    $CI->load->library('session');
    if ($CI->session->userdata('MICROSITE_SESS') == '')
        $sess = 0;
    else {
        $MICROSITE_SESS = $CI->session->userdata('MICROSITE_SESS');
        $sess = $MICROSITE_SESS['microadmin_id_auth_group'];
    }
    return $sess;
}

/**
 * retrieve session of admin user site id
 * @author ivan lubis
 * @return string admin user group id
 */
function adm_microsite_sess_siteid()
{
    $CI = & get_instance();
    $CI->load->library('session');
    if ($CI->session->userdata('MICROSITE_SESS') == '')
        $sess = 0;
    else {
        $MICROSITE_SESS = $CI->session->userdata('MICROSITE_SESS');
        $sess = $MICROSITE_SESS['microadmin_id_site'];
    }
    return $sess;
}

/**
 * get administrator folder
 * @return string cms folder
 */
function getAdminFolder()
{
    $CI = & get_instance();
    $return = $CI->config->item('admin_folder');
    return $return;
}

/**
 * get microsite administrator folder
 * @return string microsite cms folder
 */
function getMicroAdminFolder()
{
    $CI = & get_instance();
    $return = $CI->config->item('micrositeadmin_folder');
    return $return;
}

/**
 * sort management
 * @param type $id_menu
 * @param type $urut
 * @param type $id_parents_menu
 * @param type $path_app
 * @param type $sort
 * @return string $return 
 */
function sort_arrow($id_menu, $urut, $id_parents_menu, $path_app, $sort)
{
    if ($sort == 'down') {
        $img = 'desc.gif';
    } else {
        $img = 'asc.gif';
    }
    $return = '<a id="sort_' . $sort . '-' . $id_menu . '" class="sort_arrow" onclick="javascript:change_sort(\'' . $urut . '\',\'' . $id_menu . '\',\'' . $id_parents_menu . '\',\'' . $sort . '\',\'' . $path_app . '\')">
            <img src="' . base_url() . 'assets/images/admin/' . $img . '">
    </a>';
    return $return;
}

/**
 * check admin session authorization, return true or false 
 * @author ivan lubis
 * @return redirect to cms login page
 */
function auth_admin()
{
    $CI = & get_instance();
    $CI->load->library('session');
    if ($CI->session->userdata('ADM_SESS') == '') {
        $CI->session->set_userdata('tmp_login_redirect', current_url());
        redirect(getAdminFolder() . '/login');
    } else {
        $sess = $CI->session->userdata('ADM_SESS');
        if (base_url() != $sess['admin_url']) {
            $CI->session->unset_userdata('ADM_SESS');
            $CI->session->set_userdata('tmp_login_redirect', current_url());
            redirect(getAdminFolder() . '/login');
        } else {
            if ($_SERVER['REMOTE_ADDR'] != $sess['admin_ip']) {
                $CI->session->unset_userdata('ADM_SESS');
                $CI->session->set_userdata('tmp_login_redirect', current_url());
                redirect(getAdminFolder() . '/login');
            }
        }
    }
}

/**
 * check admin microsite session authorization, return true or false 
 * @author ivan lubis
 * @return redirect to microsite cms login page
 */
function auth_microsite_admin()
{
    $CI = & get_instance();
    $CI->load->library('session');
    if ($CI->session->userdata('MICROSITE_SESS') == '') {
        $CI->session->set_userdata('tmp_login_site_redirect', current_url());
        redirect(getMicroAdminFolder() . '/login');
    } else {
        $sess = $CI->session->userdata('MICROSITE_SESS');
        if (base_url() != $sess['microadmin_url']) {
            $CI->session->unset_userdata('MICROSITE_SESS');
            $CI->session->set_userdata('tmp_login_site_redirect', current_url());
            redirect(getMicroAdminFolder() . '/login');
        } else {
            if ($_SERVER['REMOTE_ADDR'] != $sess['microadmin_ip']) {
                $CI->session->unset_userdata('MICROSITE_SESS');
                $CI->session->set_userdata('tmp_login_site_redirect', current_url());
                redirect(getMicroAdminFolder() . '/login');
            }
        }
    }
}

/**
 * check authentication user by group id and menu id
 * @author ivan lubis
 * @param $id_group admin group id
 * @param $menu_name path menu or controller
 * @return true or false
 */
function auth_access_validation($id_group, $menu_name)
{
    $CI = & get_instance();
    $CI->load->database();

    $CI->db->select('auth_pages.id_auth_user_group,auth_pages.id_menu_admin,menu_admin.file');
    $CI->db->join('menu_admin', 'menu_admin.id_menu_admin=auth_pages.id_menu_admin', 'left');
    $CI->db->where('auth_pages.id_auth_user_group', $id_group);
    $CI->db->where('menu_admin.file', $menu_name);
    $query = $CI->db->get('auth_pages');
    if ($query->num_rows() > 0) {
        return true;
    } else {
        return false;
    }
}

/**
 * clear browser cache
 * @author ivan lubis
 */
function clear_cache()
{
    $CI = & get_instance();
    $CI->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
    $CI->output->set_header("Pragma: no-cache");
}

/**
 * check authentication member, return true or false
 * @author ivan lubis
 * @return redirect to login page
 */
function auth_member()
{
    $CI = & get_instance();
    $CI->load->library('session');
    if ($CI->session->userdata('M_SESS') == '') {
        redirect('login');
    }
}

/**
 * check authentication store, return true or false
 * @author ivan lubis
 * @return redirect to store login page
 */
function auth_store()
{
    $CI = & get_instance();
    $CI->load->library('session');
    if ($CI->session->userdata('S_SESS') == '') {
        redirect('store_login');
    }
}

/**
 * check if user admin is logged
 * @author ivan lubis
 * @return redirect to profile page
 */
function admin_microsite_is_loged()
{
    $CI = & get_instance();
    $CI->load->library('session');
    if ($CI->session->userdata('MICROSITE_SESS') != '') {
        redirect(getMicroAdminFolder() . '/home');
    }
}

/**
 * check if user admin is logged
 * @author ivan lubis
 * @return redirect to profile page
 */
function admin_is_loged()
{
    $CI = & get_instance();
    $CI->load->library('session');
    if ($CI->session->userdata('ADM_SESS') != '') {
        redirect(getAdminFolder() . '/home');
    }
}

/**
 * check if user is logged
 * @author ivan lubis
 * @return redirect to profile page
 */
function mem_is_loged()
{
    $CI = & get_instance();
    $CI->load->library('session');
    if ($CI->session->userdata('M_SESS') != '') {
        redirect('myprofile');
    }
}

/**
 * check if user store is logged
 * @author ivan lubis
 * @return redirect to store profile page
 */
function store_is_loged()
{
    $CI = & get_instance();
    $CI->load->library('session');
    if ($CI->session->userdata('S_SESS') != '') {
        redirect('mystore');
    }
}

/**
 * retrieve session of user id
 * @author ivan lubis
 * @return string user id
 */
function mem_sess_userid()
{
    $CI = & get_instance();
    $CI->load->library('session');
    if ($CI->session->userdata('M_SESS') == '')
        $m_sess = 0;
    else {
        $MEM_SESS = $CI->session->userdata('M_SESS');
        $m_sess = $MEM_SESS['M_ID'];
    }
    return $m_sess;
}

/**
 * retrieve session of user store id
 * @author ivan lubis
 * @return string user id
 */
function store_sess_userid()
{
    $CI = & get_instance();
    $CI->load->library('session');
    if ($CI->session->userdata('S_SESS') == '')
        $s_sess = 0;
    else {
        $STORE_SESS = $CI->session->userdata('S_SESS');
        $s_sess = $STORE_SESS['S_ID'];
    }
    return $s_sess;
}

/**
 * retrieve session of user store id
 * @author ivan lubis
 * @return string user id
 */
function store_sess_storeid()
{
    $CI = & get_instance();
    $CI->load->library('session');
    if ($CI->session->userdata('S_SESS') == '')
        $s_sess = 0;
    else {
        $STORE_SESS = $CI->session->userdata('S_SESS');
        $s_sess = $STORE_SESS['S_STOREID'];
    }
    return $s_sess;
}

/**
 * 
 * @param int $total_row
 * @param int $uri_segment
 * @return string pagination
 */
function paging($total_row, $uri_segment = 3)
{
    $CI = & get_instance();
    $param = $_GET;
    $function = $CI->uri->segment(2);
    $CI->load->library('pagination');
    $config['base_url'] = current_controller($function);
    $config['total_rows'] = $total_row;
    $config['uri_segment'] = $uri_segment;
    $config['anchor_class'] = 'class="tangan"';
    $config['per_page'] = $param['perpage'];
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['first_link'] = '<<';
    $config['last_link'] = '>>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';
    $config['last_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['first_tag_open'] = '<li>';
    $config['next_link'] = '>';
    $config['prev_link'] = '<';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a>';
    $config['cur_tag_close'] = '</a></li>';
    $CI->pagination->initialize($config);
    $paging = '<div class="pagination pull-right"><ul>';
    $paging .= $CI->pagination->create_links();
    $paging .= '</ul></div>';
    $n = $param['page'];
    $n2 = $n + 1;
    $sd = $n + $param['perpage'];
    $sd = ($total_row < $sd) ? $total_row : $sd;
    $remark = ($sd > 0) ? ("View $n2 - $sd of $total_row") : '';
    return $paging . '<div class="pull-right" style="line-height:32px;margin:0 8px;">' . $remark . '</div>';
}

/**
 * global function for pagination
 * @author ivan lubis
 * @param $total_records total records data
 * @param $perpage showing total data per page
 * @param $path  path url
 * @param $uri_segment get from uri segment
 * @return string print pagination
 */
function global_paging($total_records, $perpage, $path, $uri_segment)
{
    # load ci instance
    $CI = & get_instance();
    $CI->load->library('pagination');
    $link = '';
    $config_paging['base_url'] = $path;
    $config_paging['total_rows'] = $total_records;
    $config_paging['per_page'] = $perpage;
    $config_paging['num_links'] = 5;
    $config_paging['full_tag_open'] = '<ul class="pagination">';
    $config_paging['full_tag_close'] = '</ul>';
    $config_paging['cur_tag_open'] = '<li class="current"><a>';
    $config_paging['cur_tag_close'] = '</a></li>';
    $config_paging['num_tag_open'] = '<li>';
    $config_paging['num_tag_close'] = '</li>';
    $config_paging['first_link'] = 'First';
    $config_paging['first_tag_open'] = '<li>';
    $config_paging['first_tag_close'] = '</li>';
    $config_paging['last_link'] = 'Last';
    $config_paging['last_tag_open'] = '<li>';
    $config_paging['last_tag_close'] = '</li>';
    $config_paging['next_link'] = FALSE;
    $config_paging['prev_link'] = FALSE;
    $config_paging['uri_segment'] = $uri_segment;
    $CI->pagination->initialize($config_paging);
    $paging = $CI->pagination->create_links();
    return $paging;
}

/**
 * global function for pagination front end
 * @author ivan lubis
 * @param $total_records total records data
 * @param $perpage showing total data per page
 * @param $path  path url
 * @param $uri_segment get from uri segment
 * @return string print pagination
 */
function global_paging_front($total_records, $perpage, $path, $uri_segment)
{
    # load ci instance
    $CI = & get_instance();
    $CI->load->library('pagination');
    $link = '';
    $config_paging['base_url'] = $path;
    $config_paging['total_rows'] = $total_records;
    $config_paging['per_page'] = $perpage;
    $config_paging['num_links'] = 5;
    $config_paging['full_tag_open'] = '';
    $config_paging['full_tag_close'] = '';
    $config_paging['cur_tag_open'] = '<label><a class="paging-case" style="background:#F23400;">';
    $config_paging['cur_tag_close'] = '</a></label>';
    $config_paging['num_tag_open'] = '<label>';
    $config_paging['num_tag_close'] = '</label>';
    $config_paging['anchor_class'] = 'paging-case';
    $config_paging['first_link'] = FALSE;
    $config_paging['last_link'] = FALSE;
    $config_paging['next_link'] = FALSE;
    $config_paging['prev_link'] = FALSE;
    $config_paging['uri_segment'] = $uri_segment;
    $CI->pagination->initialize($config_paging);
    $paging = $CI->pagination->create_links();
    return $paging;
}

/**
 * remove module directory
 * @param string $dir
 */
function remove_module_directory($dir)
{
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dir . "/" . $object) == "dir")
                    rrmdir($dir . "/" . $object);
                else
                    unlink($dir . "/" . $object);
            }
        }
        reset($objects);
        rmdir($dir);
    }
}

/**
 * retrieve field value of table
 * @author ivan lubis
 * @param $field field of table
 * @param $table table name
 * @param $where condition of query
 * @return string value
 */
function get_value($field, $table, $where)
{
    # load ci instance
    $CI = & get_instance();
    $CI->load->database();

    $val = '';
    $sql = "SELECT " . $field . " FROM " . $table . " WHERE " . $where;
    $query = $CI->db->query($sql);
    foreach ($query->result_array() as $r) {
        $val = $r[$field];
    }
    return $val;
}

/**
 * retrieve setting value by key
 * @author ivan lubis
 * @param $config_key field key
 * @param $id_site (optional) site id
 * @return string value
 */
function get_setting($config_key = '', $id_site = 1)
{
    # load ci instance
    $CI = & get_instance();
    $CI->load->database();
    $val = '';
    if ($config_key != '')
        $CI->db->where('type', $config_key);
    $CI->db->where('id_site', $id_site);
    $query = $CI->db->get('setting');

    if ($query->num_rows() > 1) {
        $val = $query->result_array();
    } elseif ($query->num_rows() == 1) {
        $row = $query->row_array();
        $val = $row['value'];
    }
    return $val;
}

/**
 * retrieve site info by id site
 * @author ivan lubis
 * @param $id_site (optional) site id
 * @return string value
 */
function get_site_info($id_site = 1)
{
    # load ci instance
    $CI = & get_instance();
    $CI->load->database();
    $CI->db->where('id_site', $id_site);
    $CI->db->limit(1);
    $CI->db->order_by('id_site', 'desc');
    $query = $CI->db->get('sites');
    $row = $query->row_array();
    return $row;
}

/**
 * get option list by array
 * @param array $option
 * @param string $selected
 * @return string $return
 */
function getOptionSelect($option = array(), $selected = '')
{
    $return = '';
    for ($a = 0; $a < count($option); $a++) {
        if ($selected != '' && $selected == $option[$a]) {
            $return .= '<option value="' . $option[$a] . '" selected="selected">' . $option[$a] . '</option>';
        } else {
            $return .= '<option value="' . $option[$a] . '">' . $option[$a] . '</option>';
        }
    }
    return $return;
}

/**
 * get option publish select
 * @param type $selected
 * @return string
 */
function getOptionSelectPublish($selected = '')
{
    $return = '';
    $pub[] = 'Not Publish';
    $pub[] = 'Publish';
    for ($a = 1; $a >= 0; $a--) {
        $sel = '';
        if ($selected == $a && $selected != '')
            $sel = 'selected="selected"';
        $return .= '<option value="' . $a . '" ' . $sel . '>' . $pub[$a] . '</option>';
    }
    return $return;
}

/**
 * retrieve menu admin title
 * @author ivan lubis
 * @param $key key menu file, returning blank if empty/false
 * @return string title value
 */
function get_admin_menu_title($key)
{
    # load ci instance
    $CI = & get_instance();
    $CI->load->database();

    $CI->db->where('file', $key);
    $CI->db->limit(1);
    $CI->db->order_by('id_menu_admin', 'desc');
    $query = $CI->db->get("menu_admin");

    if ($query->num_rows() > 0) {
        $row = $query->row_array();
        return $row['menu'];
    } else {
        return '';
    }
}

/**
 * retrieve menu admin id
 * @author ivan lubis
 * @param $key key menu file, returning blank if empty/false
 * @return int id menu value
 */
function get_admin_menu_id($key)
{
    # load ci instance
    $CI = & get_instance();
    $CI->load->database();

    $CI->db->where('file', $key);
    $CI->db->limit(1);
    $CI->db->order_by('id_menu_admin', 'desc');
    $query = $CI->db->get("menu_admin");

    if ($query->num_rows() > 0) {
        $row = $query->row_array();
        return $row['id_menu_admin'];
    } else {
        return '0';
    }
}

/**
 * insert log user activity to database
 * @author ivan lubis
 * @param $data data array to insert
 */
function insert_to_log($data)
{
    # load ci instance
    $CI = & get_instance();
    $CI->load->database();

    $CI->db->insert('logs', $data);
}

/**
 * print seo label for help
 * @return string
 */
function seo_label()
{
    return ' <img src="' . base_url('assets/images/admin/help.png') . '" width="16" height="16" class="has-tip" title="leave this field empty if you want the seo link same as menu title" border="0" alt="Help"/>';
}

/**
 * check page requested by ajax
 * @return boolean
 */
function is_ajax_requested()
{
    /* AJAX check  */
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        return true;
    } else {
        return false;
    }
}

/**
 * check status of module
 * @param type $module
 * @return type bool
 */
function check_module_installed($module)
{
    # load ci instance
    $CI = & get_instance();
    $CI->load->database();
    $CI->load->library('maintenance_mode');
    if ($CI->maintenance_mode->check_maintenance()) {
        $CI->db->where('module', $module);
        $CI->db->where('is_installed', 1);
        $query = $CI->db->get('ddi_modules');
        if ($query->num_rows() > 0) {
            return true;
        } else {
            show_404('page');
        }
    }
}

/**
 * return if module is installer
 * @param type $module
 * @return type 
 */
function module_is_installed($module)
{
    # load ci instance
    $CI = & get_instance();
    $CI->load->database();
    $CI->load->library('maintenance_mode');
    if ($CI->maintenance_mode->check_maintenance()) {
        $CI->db->where('module', $module);
        $CI->db->where('is_installed', 1);
        $query = $CI->db->get('ddi_modules');
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * enconding url characters
 * @author ivan lubis
 * @param $string  string value to encode
 * @return encoded string value
 */
function myUrlEncode($string)
{
    $entities = array(' ', '!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "[", "]", "(", ")");
    $replacements = array('%20', '%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%5B', '%5D', '&#40;', '&#41;');
    return str_replace($entities, $replacements, $string);
}

/**
 * decoding url characters
 * @author ivan lubis
 * @param $string string value to decode
 * @return decoded string value
 */
function myUrlDecode($string)
{
    $entities = array('%20', '%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%5B', '%5D', '&#40;', '&#41;');
    $replacements = array(' ', '!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "[", "]", "(", ")");
    return str_replace($entities, $replacements, $string);
}

/**
 * form validation : check characters only alpha, numeric, dash
 * @param type $str
 * @return type 
 */
function mycheck_alphadash($str)
{
    if (preg_match('/^[a-z0-9_-]+$/i', $str)) {
        return true;
    } else {
        return false;
    }
}

/**
 * form validation : check iso date
 * @param string $str
 * @return bool true/false 
 */
function mycheck_isodate($str)
{
    if (preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $str)) {
        return TRUE;
    } else {
        return FALSE;
    }
}

/**
 * form validation : check email
 * @author ivan lubis
 * @param $str string value to check
 * @return string true or false
 */
function mycheck_email($str)
{
    $str = strtolower($str);
    return preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $str);
}

/**
 * form validation : check phone number
 * @param string $string
 * @return boolean
 */
function mycheck_phone( $string ) {
    if ( preg_match( '/^[+]?([\d]{0,3})?[\(\.\-\s]?([\d]{3})[\)\.\-\s]*([\d]{3})[\.\-\s]?([\d]{4})$/', $string ) ) {
        return TRUE;
    } else {
        return FALSE;
    }
}

/**
 * 
 * @param string $string
 * @param int $decimal
 * @param string $thousands_sep
 * @param string $dec_point
 * @return string number_format()
 */
function myprice($string,$decimal=0,$thousands_sep='.',$dec_point=',') {
    return number_format($string, $decimal, $dec_point, $thousands_sep);
}

/**
 * clean data from xss
 * @author ivan lubis
 * @return string clean data from xss
 */
function xss_clean_data($string)
{
    $CI = & get_instance();
    $return = $CI->security->xss_clean($string);
    return $return;
}

/**
 * check validation of upload file
 * @author ivan lubis
 * @param $str string file to check
 * @param $max_size (optional) set maximum of file size, default is 4 MB
 * @return true or false
 */
function check_file_size($str, $max_size = 0)
{
    if (!$max_size) {
        $max_size = IMG_UPLOAD_MAX_SIZE;
    }
    $file_size = $str['size'];
    if ($file_size > $max_size)
        return false;
    else
        return true;
}

/**
 * check validation of image type
 * @author ivan lubis
 * @param $source_pic string file to check
 * @return true or false
 */
function check_image_type($source_pic)
{
    $image_info = check_mime_type($source_pic);

    switch ($image_info) {
        case 'image/gif':
            return true;
            break;

        case 'image/jpeg':
            return true;
            break;

        case 'image/png':
            return true;
            break;

        case 'image/wbmp':
            return true;
            break;

        default:
            return false;
            break;
    }
}

/**
 * check validation of image type in array
 * @author ivan lubis
 * @param $source_pic string file to check
 * @return true or false
 */
function check_image_type_array($source_pic)
{
    switch ($source_pic) {
        case 'image/gif':
            return true;
            break;

        case 'image/jpeg':
            return true;
            break;

        case 'image/png':
            return true;
            break;

        case 'image/wbmp':
            return true;
            break;

        default:
            return false;
            break;
    }
}

/**
 * check validation of file type
 * @author ivan lubis
 * @param $source string file to check
 * @return true or false
 */
function check_file_type($source)
{
    $file_info = check_mime_type($source);

    switch ($file_info) {
        case 'application/pdf':
            return true;
            break;

        case 'application/msword':
            return true;
            break;

        case 'application/rtf':
            return true;
            break;
        case 'application/vnd.ms-excel':
            return true;
            break;

        case 'application/vnd.ms-powerpoint':
            return true;
            break;

        case 'application/vnd.oasis.opendocument.text':
            return true;
            break;

        case 'application/vnd.oasis.opendocument.spreadsheet':
            return true;
            break;
        
        case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
            return true;
            break;

        case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
            return true;
            break;
        
        case 'image/gif':
            return true;
            break;

        case 'image/jpeg':
            return true;
            break;

        case 'image/png':
            return true;
            break;

        case 'image/wbmp':
            return true;
            break;

        default:
            return false;
            break;
    }
}

/**
 * get mime upload file
 * @author ivan lubis
 * @param $source string file to check
 * @return string mime type
 */
function check_mime_type($source)
{
    $mime_types = array(
        // images
        'png' => 'image/png',
        'jpe' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'gif' => 'image/gif',
        'bmp' => 'image/bmp',
        'ico' => 'image/vnd.microsoft.icon',
        'tiff' => 'image/tiff',
        'tif' => 'image/tiff',
        'svg' => 'image/svg+xml',
        'svgz' => 'image/svg+xml',
        // adobe
        'pdf' => 'application/pdf',
        // ms office
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'rtf' => 'application/rtf',
        'xls' => 'application/vnd.ms-excel',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'ppt' => 'application/vnd.ms-powerpoint',
        // open office
        'odt' => 'application/vnd.oasis.opendocument.text',
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
    );

    $ext = strtolower(array_pop(explode(".", $source['name'])));
    if (array_key_exists($ext, $mime_types)) {
        return $mime_types[$ext];
    } elseif (function_exists('finfo_open')) {
        $finfo = finfo_open(FILEINFO_MIME);
        $mimetype = finfo_file($finfo, $source['tmp_name']);
        finfo_close($finfo);
        return $mimetype;
    } else {
        return 'application/octet-stream';
    }
}

/**
 * function validatePicture.
 * 
 * validation for file upload from form
 * 
 * @param string $fieldname
 *  fieldname of input file form
 */
function validatePicture($fieldname)
{
    $error = '';
    if (!empty($_FILES[$fieldname]['error'])) {
        switch ($_FILES[$fieldname]['error']) {
            case '1':
                $error = 'Upload maximum file is '.number_format(IMG_UPLOAD_MAX_SIZE/1024,2).' MB.';
                break;
            case '2':
                $error = 'File is too big, please upload with smaller size.';
                break;
            case '3':
                $error = 'File uploaded, but only halef of file.';
                break;
            case '4':
                $error = 'There is no File to upload';
                break;
            case '6':
                $error = 'Temporary folder not exists, Please try again.';
                break;
            case '7':
                $error = 'Failed to record File into disk.';
                break;
            case '8':
                $error = 'Upload file has been stop by extension.';
                break;
            case '999':
            default:
                $error = 'No error code avaiable';
        }
    } elseif (empty($_FILES[$fieldname]['tmp_name']) || $_FILES[$fieldname]['tmp_name'] == 'none') {
        $error = 'There is no File to upload.';
    } elseif ($_FILES[$fieldname]['size'] > IMG_UPLOAD_MAX_SIZE) {
        $error = 'Upload maximum file is '.number_format(IMG_UPLOAD_MAX_SIZE/1024,2).' MB.';
    } else {
        //$get_ext = substr($_FILES[$fieldname]['name'],strlen($_FILES[$fieldname]['name'])-3,3);	
        $cekfileformat = check_image_type($_FILES[$fieldname]);
        if (!$cekfileformat) {
            $error = 'Upload Picture only allow (jpg, gif, png)';
        }
    }

    return $error;
}

/**
 * private function validateFile.
 * 
 * validation for file upload from form
 * 
 * @param string $fieldname
 *  fieldname of input file form
 */
function validateFile($fieldname)
{
    $error = '';
    if (!empty($_FILES[$fieldname]['error'])) {
        switch ($_FILES[$fieldname]['error']) {
            case '1':
                $error = 'Upload maximum file is 4 MB.';
                break;
            case '2':
                $error = 'File is too big, please upload with smaller size.';
                break;
            case '3':
                $error = 'File uploaded, but only halef of file.';
                break;
            case '4':
                $error = 'There is no File to upload';
                break;
            case '6':
                $error = 'Temporary folder not exists, Please try again.';
                break;
            case '7':
                $error = 'Failed to record File into disk.';
                break;
            case '8':
                $error = 'Upload file has been stop by extension.';
                break;
            case '999':
            default:
                $error = 'No error code avaiable';
        }
    } elseif (empty($_FILES[$fieldname]['tmp_name']) || $_FILES[$fieldname]['tmp_name'] == 'none') {
        $error = 'There is no File to upload.';
    } elseif ($_FILES[$fieldname]['size'] > FILE_UPLOAD_MAX_SIZE) {
        $error = 'Upload maximum file is '.number_format(FILE_UPLOAD_MAX_SIZE/1024,2).' MB.';
    } else {
        //$get_ext = substr($_FILES[$fieldname]['name'],strlen($_FILES[$fieldname]['name'])-3,3);	
        $cekfileformat = check_file_type($_FILES[$fieldname]);
        if (!$cekfileformat) {
            $error = 'Upload File only allow (jpg, gif, png, pdf, doc, xls, xlsx, docx)';
        }
    }

    return $error;
}

/**
 * debug variable
 * @author ivan lubis
 * @param $datadebug string data to debug
 * @return print debug data
 */
function debugvar($datadebug)
{
    echo "<pre>";
    print_r($datadebug);
    echo "</pre>";
}

/**
 * set number to rupiah format
 * @author ivan lubis
 * @param $angka string number to change format
 * @return string format idr
 */
function rupiah($angka)
{
    $rupiah = "";
    $rp = strlen($angka);
    while ($rp > 3) {
        $rupiah = "." . substr($angka, -3) . $rupiah;
        $s = strlen($angka) - 3;
        $angka = substr($angka, 0, $s);
        $rp = strlen($angka);
    }
    $rupiah = "Rp." . $angka . $rupiah . ",-";
    return $rupiah;
}

/**
 * upload file to destination folder, return file name
 * @author ivan lubis
 * @param $source_file string of source file
 * @param $destination_folder string destination upload folder
 * @param $filename string file name
 * @return string edited filename
 */
function file_copy_to_folder($source_file, $destination_folder, $filename)
{
    $arrext = explode('.', $source_file['name']);
    $jml = count($arrext) - 1;
    $ext = $arrext[$jml];
    $ext = strtolower($ext);
    $ret = false;
    if (!is_dir($destination_folder)) {
        mkdir($destination_folder, 0755);
    }
    $destination_folder .= $filename . '.' . $ext;

    if (@move_uploaded_file($source_file['tmp_name'], $destination_folder)) {
        $ret = $filename . "." . $ext;
    }
    return $ret;
}

/**
 * file copy to blob
 * @param type $source_file
 * @param type $filename
 * @return type
 */
function file_copy_to_blob($source_file, $filename) {
    $arrext = explode('.', $source_file['name']);
    $jml = count($arrext) - 1;
    $ext = $arrext[$jml];
    $ext = strtolower($ext);
    $image['mime'] = check_mime_type($source_file);
    $image['name'] = $filename . "." . $ext;
    $image['ext'] = $ext;
    $image['tmp_file'] = file_get_contents($source_file['tmp_name']);
    
    return $image;
}

/**
 * upload multiple(array) file to destination folder, return array of file name
 * @author ivan lubis
 * @param $source_file array string of source file
 * @param $destination_folder string destination upload folder
 * @param $filename string of file name
 * @return string of edited filename
 */
function file_arr_copy_to_folder($source_file, $destination_folder, $filename)
{
    $tmp_destination = $destination_folder;
    for ($index = 0; $index < count($source_file['tmp_name']); $index++) {
        $arrext = explode('.', $source_file['name'][$index]);
        $jml = count($arrext) - 1;
        $ext = $arrext[$jml];
        $ext = strtolower($ext);
        $destination_folder = $tmp_destination . $filename[$index] . '.' . $ext;

        if (@move_uploaded_file($source_file['tmp_name'][$index], $destination_folder)) {
            $ret[$index] = $filename[$index] . "." . $ext;
        }
    }
    return $ret;
}

/**
 * upload image to destination folder, return file name
 * @author ivan lubis
 * @param $source_pic string source file
 * @param $destination_folder string destination upload folder
 * @param $filename string file name
 * @param $max_width string maximum image width
 * @param $max_height string maximum image height
 * @return string of edited file name
 */
function image_resize_to_folder($source_pic, $destination_folder, $filename, $max_width, $max_height)
{
    $image_info = getimagesize($source_pic['tmp_name']);
    $source_pic_name = $source_pic['name'];
    $source_pic_tmpname = $source_pic['tmp_name'];
    $source_pic_size = $source_pic['size'];
    $source_pic_width = $image_info[0];
    $source_pic_height = $image_info[1];
    if (!is_dir($destination_folder)) {
        mkdir($destination_folder, 0755);
    }

    $x_ratio = $max_width / $source_pic_width;
    $y_ratio = $max_height / $source_pic_height;

    if (($source_pic_width <= $max_width) && ($source_pic_height <= $max_height)) {
        $tn_width = $source_pic_width;
        $tn_height = $source_pic_height;
    } elseif (($x_ratio * $source_pic_height) < $max_height) {
        $tn_height = ceil($x_ratio * $source_pic_height);
        $tn_width = $max_width;
    } else {
        $tn_width = ceil($y_ratio * $source_pic_width);
        $tn_height = $max_height;
    }

    switch ($image_info['mime']) {
        case 'image/gif':
            if (imagetypes() & IMG_GIF) {
                $src = imageCreateFromGIF($source_pic['tmp_name']);
                $destination_folder.="$filename.gif";
                $namafile = "$filename.gif";
            }
            break;

        case 'image/jpeg':
            if (imagetypes() & IMG_JPG) {
                $src = imageCreateFromJPEG($source_pic['tmp_name']);
                $destination_folder.="$filename.jpg";
                $namafile = "$filename.jpg";
            }
            break;

        case 'image/pjpeg':
            if (imagetypes() & IMG_JPG) {
                $src = imageCreateFromJPEG($source_pic['tmp_name']);
                $destination_folder.="$filename.jpg";
                $namafile = "$filename.jpg";
            }
            break;

        case 'image/png':
            if (imagetypes() & IMG_PNG) {
                $src = imageCreateFromPNG($source_pic['tmp_name']);
                $destination_folder.="$filename.png";
                $namafile = "$filename.png";
            }
            break;

        case 'image/wbmp':
            if (imagetypes() & IMG_WBMP) {
                $src = imageCreateFromWBMP($source_pic['tmp_name']);
                $destination_folder.="$filename.bmp";
                $namafile = "$filename.bmp";
            }
            break;
    }

    //chmod($destination_pic,0777);
    $tmp = imagecreatetruecolor($tn_width, $tn_height);
    imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tn_width, $tn_height, $source_pic_width, $source_pic_height);

    //**** 100 is the quality settings, values range from 0-100.
    switch ($image_info['mime']) {
        case 'image/jpeg':
            imagejpeg($tmp, $destination_folder, 100);
            break;

        case 'image/gif':
            imagegif($tmp, $destination_folder, 100);
            break;

        case 'image/png':
            imagepng($tmp, $destination_folder);
            break;

        default:
            imagejpeg($tmp, $destination_folder, 100);
            break;
    }

    return ($namafile);
}

/**
 * copy image and resize it to destination folder
 * @param string $source_file
 * @param string $destination_folder
 * @param string $filename
 * @param string $max_width
 * @param string $max_height
 * @return string $namafile file name
 */
function copy_image_resize_to_folder($source_file, $destination_folder, $filename, $max_width, $max_height)
{
    $image_info = getimagesize($source_file);
    $source_pic_width = $image_info[0];
    $source_pic_height = $image_info[1];

    $x_ratio = $max_width / $source_pic_width;
    $y_ratio = $max_height / $source_pic_height;

    if (($source_pic_width <= $max_width) && ($source_pic_height <= $max_height)) {
        $tn_width = $source_pic_width;
        $tn_height = $source_pic_height;
    } elseif (($x_ratio * $source_pic_height) < $max_height) {
        $tn_height = ceil($x_ratio * $source_pic_height);
        $tn_width = $max_width;
    } else {
        $tn_width = ceil($y_ratio * $source_pic_width);
        $tn_height = $max_height;
    }
    
    if (!is_dir($destination_folder)) {
        mkdir($destination_folder, 0755);
    }

    switch ($image_info['mime']) {
        case 'image/gif':
            if (imagetypes() & IMG_GIF) {
                $src = imageCreateFromGIF($source_file);
                $destination_folder.="$filename.gif";
                $namafile = "$filename.gif";
            }
            break;

        case 'image/jpeg':
            if (imagetypes() & IMG_JPG) {
                $src = imageCreateFromJPEG($source_file);
                $destination_folder.="$filename.jpg";
                $namafile = "$filename.jpg";
            }
            break;

        case 'image/pjpeg':
            if (imagetypes() & IMG_JPG) {
                $src = imageCreateFromJPEG($source_file);
                $destination_folder.="$filename.jpg";
                $namafile = "$filename.jpg";
            }
            break;

        case 'image/png':
            if (imagetypes() & IMG_PNG) {
                $src = imageCreateFromPNG($source_file);
                $destination_folder.="$filename.png";
                $namafile = "$filename.png";
            }
            break;

        case 'image/wbmp':
            if (imagetypes() & IMG_WBMP) {
                $src = imageCreateFromWBMP($source_file);
                $destination_folder.="$filename.bmp";
                $namafile = "$filename.bmp";
            }
            break;
    }
    
    $tmp = imagecreatetruecolor($tn_width, $tn_height);
    imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tn_width, $tn_height, $source_pic_width, $source_pic_height);

    //**** 100 is the quality settings, values range from 0-100.
    switch ($image_info['mime']) {
        case 'image/jpeg':
            imagejpeg($tmp, $destination_folder, 100);
            break;

        case 'image/gif':
            imagegif($tmp, $destination_folder, 100);
            break;

        case 'image/png':
            imagepng($tmp, $destination_folder);
            break;

        default:
            imagejpeg($tmp, $destination_folder, 100);
            break;
    }

    return ($namafile);
}

/**
 * upload image to destination folder, return file name
 * @author ivan lubis
 * @param $source_pic array string source file
 * @param $destination_folder string destination upload folder
 * @param $filename string file name
 * @param $max_width string maximum image width
 * @param $max_height string maximum image height
 * @return array string of edited file name
 */
function image_arr_resize_to_folder($source_pic, $destination_folder, $filename, $max_width, $max_height)
{
    $tmp_dest = $destination_folder;
    for ($index = 0; $index < count($source_pic['tmp_name']); $index++) {
        $destination_folder = $tmp_dest;
        $image_info = getimagesize($source_pic['tmp_name'][$index]);
        $source_pic_name = $source_pic['name'][$index];
        $source_pic_tmpname = $source_pic['tmp_name'][$index];
        $source_pic_size = $source_pic['size'][$index];
        $source_pic_width = $image_info[0];
        $source_pic_height = $image_info[1];
        $x_ratio = $max_width / $source_pic_width;
        $y_ratio = $max_height / $source_pic_height;

        if (($source_pic_width <= $max_width) && ($source_pic_height <= $max_height)) {
            $tn_width = $source_pic_width;
            $tn_height = $source_pic_height;
        } elseif (($x_ratio * $source_pic_height) < $max_height) {
            $tn_height = ceil($x_ratio * $source_pic_height);
            $tn_width = $max_width;
        } else {
            $tn_width = ceil($y_ratio * $source_pic_width);
            $tn_height = $max_height;
        }

        switch ($image_info['mime']) {
            case 'image/gif':
                if (imagetypes() & IMG_GIF) {
                    $src = imageCreateFromGIF($source_pic['tmp_name'][$index]);
                    $destination_folder.="$filename[$index].gif";
                    $namafile = "$filename[$index].gif";
                }
                break;

            case 'image/jpeg':
                if (imagetypes() & IMG_JPG) {
                    $src = imageCreateFromJPEG($source_pic['tmp_name'][$index]);
                    $destination_folder.="$filename[$index].jpg";
                    $namafile = "$filename[$index].jpg";
                }
                break;

            case 'image/pjpeg':
                if (imagetypes() & IMG_JPG) {
                    $src = imageCreateFromJPEG($source_pic['tmp_name'][$index]);
                    $destination_folder.="$filename[$index].jpg";
                    $namafile = "$filename[$index].jpg";
                }
                break;

            case 'image/png':
                if (imagetypes() & IMG_PNG) {
                    $src = imageCreateFromPNG($source_pic['tmp_name'][$index]);
                    $destination_folder.="$filename[$index].png";
                    $namafile = "$filename[$index].png";
                }
                break;

            case 'image/wbmp':
                if (imagetypes() & IMG_WBMP) {
                    $src = imageCreateFromWBMP($source_pic['tmp_name'][$index]);
                    $destination_folder.="$filename[$index].bmp";
                    $namafile = "$filename[$index].bmp";
                }
                break;
        }

        //chmod($destination_pic,0777);
        $tmp = imagecreatetruecolor($tn_width, $tn_height);
        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tn_width, $tn_height, $source_pic_width, $source_pic_height);

        //**** 100 is the quality settings, values range from 0-100.
        switch ($image_info['mime']) {
            case 'image/jpeg':
                imagejpeg($tmp, $destination_folder, 100);
                break;

            case 'image/gif':
                imagegif($tmp, $destination_folder, 100);
                break;

            case 'image/png':
                imagepng($tmp, $destination_folder);
                break;

            default:
                imagejpeg($tmp, $destination_folder, 100);
                break;
        }
        $url[] = $namafile;
    }
    return ($url);
}

/**
 * crop image 
 * @author ivan lubis
 * @param $nw string new width
 * @param $nh string new height
 * @param $source string source file
 * @param $dest string destination folder
 */
function cropImage($nw, $nh, $source, $dest)
{
    $image_info = getimagesize($source);
    $w = $image_info[0];
    $h = $image_info[1];

    switch ($image_info['mime']) {
        case 'image/gif':
            $simg = imagecreatefromgif($source);
            break;
        case 'image/jpeg':
            $simg = imagecreatefromjpeg($source);
            break;
        case 'image/pjpeg':
            $simg = imagecreatefromjpeg($source);
            break;
        case 'png':
            $simg = imagecreatefrompng($source);
            break;
    }

    $dimg = imagecreatetruecolor($nw, $nh);
    $wm = $w / $nw;
    $hm = $h / $nh;
    $h_height = $nh / 2;
    $w_height = $nw / 2;

    if ($w > $h) {
        $adjusted_width = $w / $hm;
        $half_width = $adjusted_width / 2;
        $int_width = $half_width - $w_height;

        imagecopyresampled($dimg, $simg, -$int_width, 0, 0, 0, $adjusted_width, $nh, $w, $h);
    } elseif (($w < $h) || ($w == $h)) {
        $adjusted_height = $h / $wm;
        $half_height = $adjusted_height / 2;
        $int_height = $half_height - $h_height;
        imagecopyresampled($dimg, $simg, 0, -$int_height, 0, 0, $nw, $adjusted_height, $w, $h);
    } else {
        imagecopyresampled($dimg, $simg, 0, 0, 0, 0, $nw, $nh, $w, $h);
    }
    imagejpeg($dimg, $dest, 100);
}

/**
 * get option list
 * @param type $options
 * @param type $selected
 * @param type $type
 * @param type $name
 * @return string $temp_list
 */
function getOptions($options = array(), $selected = '', $type = 'option', $name = 'option_list')
{
    $tmp_list = '';
    for ($a = 0; $a < count($options); $a++) {
        $set_select = '';
        if ($selected == $options[$a]) {
            $set_select = 'selected="selected"';
        }

        if ($type == 'option') {
            $tmp_list .= '<option value="' . $options[$a] . '" ' . $set_select . '>' . $options[$a] . '</option>';
        } else {
            $tmp_list .= '<label for="opt-' . $a . '"><input name="' . $name . '" id="opt-' . $a . '" value="' . $options[$a] . '" type="' . $type . '"/>' . $options[$a] . '&nbsp; </label>';
        }
    }
    return $tmp_list;
}

/**
 * mark up price
 * @param int $price
 * @param int $precision
 * @return string $new_price
 */
function markupPrice($price=0,$precision=0) {
    $price = (int)$price;
    if (!$price) {
        return '0';
    }
    // get margin price first
    $margin = MARGIN_PRICE;
    $percentage = round(($margin / 100)*$price,$precision);
    $new_price = $price+$percentage;
    
    return $new_price;
}

/**
 * get languange text by key
 * @param string $key
 * @return string text language
 */
function get_lang_key($key) {
    $CI = &get_instance();
    return $CI->lang->line($key);
}

/**
 * simple bug fix for array_keys when returning key is 0
 * @param $needle string
 * @param $haystack array
 * $return key of array or false
 */
function recursive_array_search($needle,$haystack) {
    foreach($haystack as $key=>$value) {
        $current_key=$key;
        if($needle===$value OR (is_array($value) && recursive_array_search($needle,$value) !== false)) {
            return $current_key;
        }
    }
    return false;
}

/** End of file custom_helper.php */
/** Location: ./application/helpers/custom_helper.php */

