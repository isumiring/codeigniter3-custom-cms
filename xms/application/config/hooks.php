<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/
/*$hook['pre_system'][] = array(
    'class'    => 'FAT_Error',
    'function' => 'error_catcher',
    'filename' => 'FAT_Error.php',
    'filepath' => 'hooks'
);*/
$hook['post_controller_constructor'][] = array(
    'class'    => 'FAT_Hooks',
    'function' => 'set_cache',
    'filename' => 'FAT_Hooks.php',
    'filepath' => 'hooks'
);
$hook['post_controller_constructor'][] = array(
    'class'    => 'FAT_Hooks',
    'function' => 'set_profiler',
    'filename' => 'FAT_Hooks.php',
    'filepath' => 'hooks'
);
$hook['post_controller_constructor'][] = array(
    'class'    => 'FAT_Authentication',
    'function' => 'authentication',
    'filename' => 'FAT_Authentication.php',
    'filepath' => 'hooks'
);
$hook['post_controller'][] = array(
    'class'    => 'FAT_Layout',
    'function' => 'layout',
    'filename' => 'FAT_Layout.php',
    'filepath' => 'hooks'
);
